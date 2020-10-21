<?php

namespace backend\models;

use common\models\Segment as Segments;
use common\models\LogsAdmin;
use common\models\LogsFrontend;
use common\models\LogsSeller;
use common\models\ProductsCategory;
use common\models\SegmentFields;
use common\models\SegmentInfos;
use Yii;
use yii\helpers\Inflector;

/**
 * Segment model
 */
class Segment extends Segments
{
    public static $type;
    public static $items_with_parent = false;
    public static $slug_generator = false;

    /**
     * Get items
     *
     * @param string $page_type
     * @return object
     */
    public static function getItems($page_type = '', $args = array())
    {
        $search = input_get('s');
        $sort = input_get('sort');
        $parent = input_get('parent');

        $current_lexicon = get_content_lexicon();
        self::$selected_language = array_value($current_lexicon, 'lang_code', 'en');

        if (empty($sort) && array_value($args, 'sort')) {
            $sort = array_value($args, 'sort');
        }

        if (empty($parent) && array_value($args, 'parent')) {
            $parent = array_value($args, 'parent');
        }

        $query = self::find()
            ->alias('segment')
            ->select('segment.*, info.*')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where(['segment.type' => self::$type, 'info.language' => self::$selected_language]);

        if ($search) {
            $query->andWhere(['like', 'info.title', $search]);

            if (is_numeric($parent) && $parent > 0) {
                $query->andWhere(['segment.parent_id' => $parent]);
            }
        } elseif (is_numeric($parent) && $parent > 0) {
            $query->andWhere(['segment.parent_id' => $parent]);
        } elseif ($page_type != 'deleted') {
            $query->andWhere(['segment.parent_id' => 0]);
        }

        if ($sort == 'a-z') {
            $sort_query = ['info.title' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['info.title' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['segment.created_on' => SORT_ASC];
        } else {
            $sort_query = ['segment.created_on' => SORT_DESC];
        }

        if (self::$items_with_parent) {
            $query->with([
                'info' => function ($query) {
                    $query->andWhere(['language' => self::$selected_language]);
                },
                'parentInfo',
            ]);
        } else {
            $query->with([
                'info' => function ($query) {
                    $query->andWhere(['language' => self::$selected_language]);
                },
            ]);
        }

        $query->orderBy($sort_query);
        return $query;
    }

    /**
     * Page types
     *
     * @param string $active_key
     * @return array
     */
    public static function getPageTypes($active_key = '')
    {
        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => self::allCount(['segment.type' => self::$type, 'segment.deleted' => 0]),
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => self::publishedCount(['segment.type' => self::$type]),
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => false,
                'count' => self::unpublishedCount(['segment.type' => self::$type]),
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => self::deletedCount(['segment.type' => self::$type]),
            ),
        );

        if (isset($page_types[$active_key])) {
            $page_types[$active_key]['active'] = true;
        }

        return $page_types;
    }

    /**
     * Status array
     *
     * @param int $key
     * @return array
     */
    public function statusArray($key = null)
    {
        $array = [
            1 => 'Published',
            0 => 'Unpublished',
        ];

        if (isset($array[$key])) {
            return $array[$key];
        }

        return $array;
    }

    /**
     * Create item
     *
     * @param [type] $model
     * @param [type] $info
     * @param [type] $post_item
     * @return int
     */
    public static function createItem($model, $info, $post_item = array())
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $current_user_id = Yii::$app->user->id;
        $active_languages = get_active_langs();
        $translations_title = array_value($post_item, 'translations_title');

        if (empty($info->language)) {
            $info->language = $active_languages ? $active_languages[0]['lang_code'] : 'en';
        }

        // Create model
        $model->type = self::$type;
        $model->created_on = $now_date;
        $model->created_by = $current_user_id;
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        // Settings
        $settings = Content::settingsArray($model);
        $model->settings = json_encode($settings);

        if ($model->save()) {
            $log_data['segment']['attrs'] = $model->getAttributes();
            $log_data['segment']['old_attrs'] = array();

            // Create info
            if (!isset($info->icon) || empty($info->icon)) {
                $info->icon = '';
            }

            $info->segment_id = $model->id;
            $info->slug = self::generateSlug($info->title, $info->language);

            // Meta
            $meta = Content::settingsArray($info, 'meta');
            $info->meta = json_encode($meta);

            if ($info->save()) {
                $log_data['info'][$info->language]['attrs'] = $info->getAttributes();
                $log_data['info'][$info->language]['old_attrs'] = array();

                // Create translations
                if ($active_languages) {
                    $item_lang = $info->language;

                    foreach ($active_languages as $active_language) {
                        $lang_code = $active_language['lang_code'];

                        if ($item_lang != $lang_code) {
                            $new = new SegmentInfos();
                            $new->setAttributes($info->getAttributes());

                            if (isset($translations_title[$lang_code]) && $translations_title[$lang_code]) {
                                $new->title = $translations_title[$lang_code];
                            }

                            $new->language = $lang_code;
                            $new->slug = self::generateSlug($new->title, $new->language);

                            if ($new->save()) {
                                $log_data['info'][$new->language]['attrs'] = $new->getAttributes();
                                $log_data['info'][$new->language]['old_attrs'] = array();
                            }
                        }
                    }
                }

                // Count childs
                self::countChilds($model);

                // Set log
                set_log('admin', [
                    'res_id' => $model->id,
                    'type' => $model->type,
                    'action' => 'create',
                    'data' => json_encode($log_data),
                ]);
            }
        }

        return $model->id;
    }

    /**
     * Update item
     *
     * @param [type] $model
     * @param [type] $info
     * @param [type] $post_item
     * @return int
     */
    public static function updateItem($model, $info, $post_item = array())
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $active_languages = get_active_langs();

        if (empty($info->language)) {
            $info->language = $active_languages ? $active_languages[0]['lang_code'] : 'en';
        }

        $item_lang = $info->language;
        $item_lang_old = $info->getOldAttribute('language');
        $current_user_id = Yii::$app->user->id;

        // Check language
        if ($item_lang != $item_lang_old && $info->info_id > 0) {
            $find_translation = SegmentInfos::find()
                ->where(['segment_id' => $model->id, 'language' => $item_lang])
                ->all();

            if ($find_translation) {
                $error = 'Translation found. Please select an empty language!';
                return $error;
            }
        }

        // Save model
        $model->type = self::$type;
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        // Settings
        $settings = Content::settingsArray($model);
        $model->settings = json_encode($settings);
        $model_oldAttributes = $model->getOldAttributes();

        if ($model->save()) {
            $log_data['segment']['attrs'] = $model->getAttributes();
            $log_data['segment']['old_attrs'] = $model_oldAttributes;

            // Check slug
            if (empty($info->slug)) {
                $info->slug = self::generateSlug($info->title, $info->language);
            }

            // Update info
            if ($info->info_id < 1) {
                unset($info->info_id);

                $new = new SegmentInfos();
                $new->setAttributes($info->getAttributes());
                $new->slug = self::generateSlug($new->title, $new->language);

                if ($new->save()) {
                    $log_data['info'][$new->language]['attrs'] = $new->getAttributes();
                    $log_data['info'][$new->language]['old_attrs'] = array();
                }
            } else {
                if (!isset($info->icon) || empty($info->icon)) {
                    $info->icon = '';
                }

                $meta = Content::settingsArray($info, 'meta');
                $info->meta = json_encode($meta);
                $info_oldAttributes = $info->getOldAttributes();

                if ($info->save()) {
                    $log_data['info'][$info->language]['attrs'] = $info->getAttributes();
                    $log_data['info'][$info->language]['old_attrs'] = $info_oldAttributes;
                }
            }

            // Count childs
            self::countChilds($model);

            // Set log
            set_log('admin', [
                'res_id' => $model->id,
                'type' => $model->type,
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $model->id;
    }

    /**
     * Get item to edit
     *
     * @param int $id
     * @return array
     */
    public static function getItemToEdit($id)
    {
        $lang_key = input_get('lang', 'en');

        $model = self::findOne($id);
        $info = SegmentInfos::find()->where(['segment_id' => $id, 'language' => $lang_key])->one();
        $translations = SegmentInfos::find()->where(['segment_id' => $id])->all();

        if (!$info) {
            $info = SegmentInfos::find()->where(['segment_id' => $id])->one();

            if ($info) {
                $info->title = $info->title . " [{$lang_key}]";
                $info->slug = '';
                $info->info_id = 0;
                $info->language = $lang_key;
            }
        }

        $output['model'] = $model;
        $output['info'] = $info;
        $output['translations'] = $translations;

        return $output;
    }

    /**
     * Get parents list
     *
     * @param [type] $model
     * @param [type] $info
     * @param [type] $parent_id
     * @param [type] $type
     * @return array
     */
    public static function getListParent($model, $info, $parent_id = 0, $type = '')
    {
        if ($model == 'product') {
            if ($type == 'category') {
                $output = array('' => 'No category');
            } elseif ($type == 'brand') {
                $output = array('0' => 'No brand');
            } else {
                $output = array('' => '-');
            }

            $where = array('segment.type' => $type);
        } else {
            $output = array('0' => 'No parent');
            $where = array('segment.type' => self::$type);
        }

        if (isset($info->language) && $info->language) {
            self::$selected_language = $info->language;
        }

        if (is_numeric($parent_id) && $parent_id > 0) {
            $where['segment.parent_id'] = $parent_id;
        } else {
            $where['segment.parent_id'] = 0;
        }

        $query = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where($where);

        if (isset($model->id) && is_numeric($model->id)) {
            $query->andWhere(['!=', 'id', $model->id]);
        }

        $query->with([
            'info' => function ($query) {
                $query->andWhere(['language' => self::$selected_language]);
            },
        ]);

        $query->orderBy(['info.title' => 'ASC']);
        $items = $query->all();

        if ($items) {
            foreach ($items as $item) {
                $childs = self::getParentChilds($item->id, $model, $info, $type, 1);

                $output[$item->id] = $item->info->title;

                if ($childs) {
                    $output = $output + $childs;
                }
            }
        }

        return $output;
    }

    /**
     * Get parent childs
     *
     * @param integer $parent_id
     * @param [type] $model
     * @param [type] $info
     * @param [type] $type
     * @param integer $level
     * @param string $prefix
     * @return array
     */
    private static function getParentChilds($parent_id = 0, $model = null, $info = null, $type = '', $level = 0, $prefix = '')
    {
        $array = array();

        if ($type) {
            $where = array('segment.type' => $type);
        } else {
            $where = array('segment.type' => self::$type);
        }

        if (isset($info->language) && $info->language) {
            self::$selected_language = $info->language;
        }

        if (is_numeric($parent_id) && $parent_id > 0) {
            $where['segment.parent_id'] = $parent_id;
        } else {
            $where['segment.parent_id'] = 0;
        }

        $query = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where($where);

        if (isset($model->id) && is_numeric($model->id)) {
            $query->andWhere(['!=', 'id', $model->id]);
        }

        $query->with([
            'info' => function ($query) {
                $query->andWhere(['language' => self::$selected_language]);
            },
        ]);

        $query->orderBy(['info.title' => 'ASC']);
        $items = $query->all();

        if ($items) {
            if ($level > 0) {
                for ($i = 0; $i < $level; $i++) {
                    $prefix .= '-';
                }
            }

            foreach ($items as $item) {
                if ($prefix) {
                    $title = '&nbsp;' . $prefix . ' ' . $item->info->title;
                } else {
                    $title = $item->info->title;
                }

                $childs = self::getParentChilds($item->id, $model, $info, $type, $level, $prefix);

                $array[$item->id] = $title;

                if ($childs) {
                    $array = $array + $childs;
                }
            }
        }

        $level++;
        return $array;
    }

    /**
     * Count all
     *
     * @param array $where
     * @return int
     */
    public static function allCount($where = array())
    {
        $query = self::find()->alias('segment');
        $query->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id');

        if (is_array($where) && $where) {
            $query->where($where);
        }

        $query->groupBy('info.segment_id');
        return $query->count();
    }

    /**
     * Count published
     *
     * @param array $where
     * @return int
     */
    public static function publishedCount($where = array())
    {
        $query = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where(['segment.deleted' => 0, 'segment.status' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.segment_id');
        return $query->count();
    }

    /**
     * Count unpublished
     *
     * @param array $where
     * @return int
     */
    public static function unpublishedCount($where = array())
    {
        $query = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where(['segment.deleted' => 0, 'segment.status' => 0]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.segment_id');
        return $query->count();
    }

    /**
     * Count deleted
     *
     * @param array $where
     * @return int
     */
    public static function deletedCount($where = array())
    {
        $query = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where(['segment.deleted' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.segment_id');
        return $query->count();
    }

    /**
     * Childs count
     *
     * @param [type] $model
     * @return void
     */
    public static function countChilds($model)
    {
        $parent_id = $model->parent_id;

        if (is_numeric($parent_id) && $parent_id > 0) {
            $x = 0;
            $childs_count = 0;

            do {
                $x++;
                $parent = self::findOne($parent_id);

                if ($parent) {
                    $item_where = ['parent_id' => $parent->id];
                    $field_where = ['segment_id' => $parent->id, 'field_key' => 'child_count'];

                    $field = SegmentFields::find()->where($field_where)->one();
                    $childs = self::find()->where($item_where)->count();

                    $childs_count = ($childs_count + $childs);

                    if ($field) {
                        $field->field_value = $childs_count;
                        $field->save(false);
                    } else {
                        $field = new SegmentFields();
                        $field->segment_id = $parent->id;
                        $field->field_key = 'child_count';
                        $field->field_value = $childs_count;
                        $field->save(false);
                    }

                    $parent_id = $parent->parent_id;
                } else {
                    $parent = false;
                }
            } while ($parent && $x < 10000);
        }
    }

    /**
     * Products count
     *
     * @param [type] $category_id
     * @return mixed
     */
    public static function countProducts($category_id)
    {
        $x = 0;
        $count = 0;

        do {
            $x++;
            $category = ($category_id > 0 ? self::findOne($category_id) : false);

            if ($category) {
                $cats_where = ['category_id' => $category_id];
                $field_where = ['segment_id' => $category_id, 'field_key' => 'products_count'];

                $field = SegmentFields::find()->where($field_where)->one();
                $products = ProductsCategory::find()->where($cats_where)->count();

                $count = ($count + $products);

                if ($field) {
                    $field->field_value = $count;
                    $field->save(false);
                } else {
                    $field = new SegmentFields();
                    $field->segment_id = $category_id;
                    $field->field_key = 'products_count';
                    $field->field_value = $count;
                    $field->save(false);
                }

                $category_id = $category->parent_id;
            } else {
                $category = false;
            }

            echo $x;
        } while ($category);
    }

    /**
     * Ajax actions
     *
     * @param [type] $action
     * @param [type] $id
     * @param [type] $items
     * @return array
     */
    public static function ajaxAction($action, $id, $items)
    {
        $output['error'] = true;
        $output['success'] = false;

        if ($action == 'unpublish') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithSegment('unpublish', $item);

                $output['message'] = 'Item unpublished successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithSegment('unpublish', $item);
                }

                $output['message'] = 'Selected items have been successfully unpublished.';
            }
        } elseif ($action == 'publish') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithSegment('publish', $item);

                $output['message'] = 'Item published successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithSegment('publish', $item);
                }

                $output['message'] = 'Selected items have been successfully published.';
            }
        } elseif ($action == 'trash') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithSegment('trash', $item);

                $output['message'] = 'Item moved to the trash successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithSegment('trash', $item);
                }

                $output['message'] = 'Selected items have been successfully moved to the trash.';
            }
        } elseif ($action == 'restore') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithSegment('restore', $item);

                $output['message'] = 'Item restored successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithSegment('restore', $item);
                }

                $output['message'] = 'Selected items have been successfully restored.';
            }
        } elseif ($action == 'delete') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::deleteSegment($item);

                $output['message'] = 'Item deleted successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = $item = self::findOne($items[$i]);
                    self::deleteSegment($item);
                }

                $output['message'] = 'Selected items have been successfully deleted.';
            }
        }

        return $output;
    }

    /**
     * Actions with item
     *
     * @param [type] $type
     * @param [type] $model
     * @param boolean $with_childs
     * @return void
     */
    public static function bulkActionWithSegment($type, $model, $with_childs = true)
    {
        if ($model) {
            if ($with_childs) {
                self::bulkActionWithSegmentChilds($type, $model);
            }

            if ($type == 'trash') {
                $model->deleted = 1;
                $model->save();
            } elseif ($type == 'restore') {
                $model->deleted = 0;
                $model->save();
            } elseif ($type == 'publish') {
                $model->status = 1;
                $model->save();
            } elseif ($type == 'unpublish') {
                $model->status = 0;
                $model->save();
            }

            // Set log
            set_log('admin', ['res_id' => $model->id, 'type' => $model->type, 'action' => $type]);
        }
    }

    /**
     * Actions with childs
     *
     * @param [type] $type
     * @param [type] $model
     * @return void
     */
    public static function bulkActionWithSegmentChilds($type, $model)
    {
        if ($model) {
            $id = $model->id;
            $childs = self::find()->where(['parent_id' => $id])->all();

            if ($childs) {
                foreach ($childs as $child) {
                    self::bulkActionWithSegment($type, $child);
                }
            }
        }
    }

    /**
     * Delete item
     *
     * @param [type] $model
     * @param boolean $with_childs
     * @return void
     */
    public static function deleteSegment($model, $with_childs = true)
    {
        if ($model) {
            $trash_item['segment'] = $model->getAttributes();

            if ($with_childs) {
                self::deleteSegmentChilds($model, false);
            }

            if ($model->delete(false)) {
                $id = $model->id;
                $info = SegmentInfos::find()->where(['segment_id' => $id])->all();
                $fields = SegmentInfos::find()->where(['segment_id' => $id])->all();

                if ($info) {
                    foreach ($info as $info_item) {
                        $trash_item['info'][] = $info_item->getAttributes();
                        $info_item->delete();
                    }
                }

                if ($fields) {
                    foreach ($fields as $field_item) {
                        $trash_item['field'][] = $field_item->getAttributes();
                        $field_item->delete();
                    }
                }

                // Set trash
                set_trash(array(
                    'res_id' => $id,
                    'type' => $model->type,
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $model->id,
                    'type' => $model->type,
                    'action' => 'delete',
                    'data' => json_encode($trash_item),
                ]);
            }
        }
    }

    /**
     * Delete segment childs
     *
     * @param [type] $model
     * @param boolean $self_delete
     * @return void
     */
    public static function deleteSegmentChilds($model, $self_delete = true)
    {
        if ($model) {
            $id = $model->id;
            $type = $model->type;
            $childs = self::find()->where(['parent_id' => $id])->all();

            if ($childs) {
                foreach ($childs as $child) {
                    self::deleteSegmentChilds($child);
                }
            }

            if ($self_delete && $model->delete(false)) {
                $trash_item['segment'] = $model->getAttributes();
                $info = SegmentInfos::find()->where(['segment_id' => $id])->all();
                $fields = SegmentInfos::find()->where(['segment_id' => $id])->all();

                if ($info) {
                    foreach ($info as $info_item) {
                        $trash_item['infos'][] = $info_item->getAttributes();
                        $info_item->delete();
                    }
                }

                if ($fields) {
                    foreach ($fields as $field_item) {
                        $trash_item['fields'][] = $field_item->getAttributes();
                        $field_item->delete();
                    }
                }

                LogsAdmin::deleteAll(['res_id' => $id, 'type' => $type]);
                LogsFrontend::deleteAll(['res_id' => $id, 'type' => $type]);
                LogsSeller::deleteAll(['res_id' => $id, 'type' => $type]);

                // Set trash
                set_trash(array(
                    'res_id' => $id,
                    'type' => $type,
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $id,
                    'type' => $type,
                    'action' => 'delete',
                    'data' => json_encode($trash_item),
                ]);
            }
        }
    }

    /**
     * Slug generator
     *
     * @param [type] $title
     * @return string
     */
    public static function generateSlug($title, $lang = false)
    {
        if (self::$slug_generator == 'prefix') {
            $slug = self::generateSlugWithPrefix($title, self::$type, $lang);
        } else {
            $slug = self::generateSlugSame($title, self::$type, $lang);
        }

        return $slug;
    }

    /**
     * Slug generator
     *
     * @param [type] $title
     * @param [type] $type
     * @param boolean $lang
     * @return string
     */
    public static function generateSlugSame($title, $type, $lang = false)
    {
        $title_slug = Inflector::slug($title);
        $slug = $title_slug;
        $where = array('segment.type' => $type, 'info.slug' => $slug);

        if ($lang) {
            $where['info.language'] = $lang;
        }

        $item = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where($where)
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;
                $slug = $title_slug . '-' . $i;
                $where['info.slug'] = $slug;

                $item = self::find()
                    ->alias('segment')
                    ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
                    ->where($where)
                    ->one();
            } while ($item && $i < 10000);
        }

        return $slug;
    }

    /**
     * Slug generator with prefix
     *
     * @param [type] $title
     * @param [type] $type
     * @param boolean $lang
     * @return string
     */
    public static function generateSlugWithPrefix($title, $type, $lang = false)
    {
        $title_slug = Inflector::slug($title);
        $slug = $title_slug . '-' . rand(1000, 9999);

        $where = array('segment.type' => $type, 'info.slug' => $slug);

        if ($lang) {
            $where['info.language'] = $lang;
        }

        $item = self::find()
            ->alias('segment')
            ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
            ->where($where)
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;
                $slug = $title_slug . '-' . rand(1000, 9999);
                $where['info.slug'] = $slug;

                $item = self::find()
                    ->alias('segment')
                    ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
                    ->where($where)
                    ->one();
            } while ($item && $i < 10000);
        }

        return $slug;
    }

    /**
     * Menu page item render
     *
     * @param [type] $type
     * @param [type] $post
     * @param [type] $yii
     * @return array
     */
    public static function menuPageItemRender($type, $post, $yii)
    {
        $output['error'] = true;
        $output['success'] = false;
        $output['message'] = 'An error occurred while processing your request. Please try agian.';

        $results = array();
        $search_items = array_value($post, 'search_items');
        $selected_items = array_value($post, 'selected_items');
        self::$selected_language = array_value($post, 'lang', 'en');

        if ($selected_items) {
            $array = array_value($post, 'selected_array');

            if (is_array($array) && $array) {
                $query = self::find()
                    ->alias('segment')
                    ->select('segment.*, info.*')
                    ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
                    ->where(['in', 'segment.id', $array])
                    ->andWhere(['segment.type' => $type])
                    ->with([
                        'info' => function ($query) {
                            $query->andWhere(['language' => self::$selected_language]);
                        },
                    ])
                    ->all();

                if ($query) {
                    $output['error'] = false;
                    $output['success'] = true;
                    $output['message'] = 'Menu item was added successfully.';

                    foreach ($query as $value) {
                        $value_json = ['name' => $value->info->title];

                        $value_data = array(
                            'action_type' => $type,
                            'item_id' => $value->id,
                            'data' => json_encode($value_json),
                        );

                        $data[] = $yii->renderPartial('menu-item', $value_data);
                    }

                    $output['view'] = implode(' ', $data);
                }
            } else {
                $output['message'] = 'No items selected to add! Please select item to add to the menu!';
            }
        } elseif ($search_items) {
            $search = array_value($post, 'search');
            $search_key = clean_str($search);

            if (strlen($search_key) < 3) {
                $output['message'] = 'Please enter at least 3 characters to search!';
            } elseif ($search_key) {
                $results = self::find()
                    ->alias('segment')
                    ->select('segment.*, info.*')
                    ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
                    ->where(['segment.type' => $type])
                    ->andWhere(['like', 'info.title', $search])
                    ->with([
                        'info' => function ($query) {
                            $query->andWhere(['language' => self::$selected_language]);
                        },
                    ])
                    ->all();

                if (!$results) {
                    $output['message'] = 'No results were found for your request! Please try other keywords!';
                }
            } else {
                $output['message'] = 'Enter your search keyword to find item!';
            }
        } else {
            $data = array();
            $results = self::find()
                ->alias('segment')
                ->select('segment.*, info.*')
                ->join('INNER JOIN', 'site_segments_info info', 'info.segment_id = segment.id')
                ->where(['segment.type' => $type, 'segment.deleted' => 0, 'segment.status' => 1])
                ->with([
                    'info' => function ($query) {
                        $query->andWhere(['language' => self::$selected_language]);
                    },
                ])
                ->orderBy(['segment.created_on' => SORT_DESC])
                ->limit(10)
                ->all();

            if ($results) {
                $output['message'] = '';
            } else {
                $output['message'] = 'Items not found!';
            }
        }

        if ($results) {
            $data = array();
            $output['error'] = false;
            $output['success'] = true;

            foreach ($results as $value) {
                $value_data = array(
                    'item_type' => $type,
                    'item_id' => $value->id,
                    'item_title' => $value->info->title,
                );

                $data[] = $yii->renderPartial('ajax-item', $value_data);
            }

            $output['html'] = $data;
        }

        return $output;
    }
}
