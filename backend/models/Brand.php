<?php

namespace backend\models;

use common\models\Brands;
use Yii;
use yii\helpers\Inflector;

/**
 * Content model
 */
class Brand extends Brands
{
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

        if (empty($sort) && array_value($args, 'sort')) {
            $sort = array_value($args, 'sort');
        }

        $query = self::find();

        if ($search) {
            $query->where(['like', 'title', $search]);
        }

        if ($sort == 'a-z') {
            $sort_query = ['title' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['title' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['created_on' => SORT_ASC];
        } else {
            $sort_query = ['created_on' => SORT_DESC];
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
                'count' => self::allCount(['deleted' => 0]),
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => self::publishedCount(),
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => false,
                'count' => self::unpublishedCount(),
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => self::deletedCount(),
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
     * @param [type] $post_item
     * @return int
     */
    public static function createItem($model, $post_item = array())
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $current_user_id = Yii::$app->user->id;

        // Create model
        $model->created_on = $now_date;
        $model->created_by = $current_user_id;
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        // Settings
        $settings = Content::settingsArray($model);
        $model->settings = json_encode($settings);

        // Meta
        $meta = Content::settingsArray($model, 'meta');
        $model->meta = json_encode($meta);

        // Slug
        $model->slug = self::generateSlug($model->title);

        if ($model->save()) {
            $log_data['brand']['attrs'] = $model->getAttributes();
            $log_data['brand']['old_attrs'] = array();

            // Set log
            set_log('admin', [
                'res_id' => $model->id,
                'type' => 'brand',
                'action' => 'create',
                'data' => json_encode($log_data),
            ]);
        }

        return $model->id;
    }

    /**
     * Update item
     *
     * @param [type] $model
     * @param [type] $post_item
     * @return int
     */
    public static function updateItem($model, $post_item = array())
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $current_user_id = Yii::$app->user->id;

        // Save model
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        // Settings
        $settings = Content::settingsArray($model);
        $model->settings = json_encode($settings);
        $model_oldAttributes = $model->getOldAttributes();

        // Meta
        $meta = Content::settingsArray($model, 'meta');
        $model->meta = json_encode($meta);

        // Check slug
        if (empty($model->slug)) {
            $model->slug = self::generateSlug($model->title);
        }

        if ($model->save()) {
            $log_data['brand']['attrs'] = $model->getAttributes();
            $log_data['brand']['old_attrs'] = $model_oldAttributes;

            // Set log
            set_log('admin', [
                'res_id' => $model->id,
                'type' => 'brand',
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $model->id;
    }

    /**
     * Count all
     *
     * @param array $where
     * @return int
     */
    public static function allCount($where = array())
    {
        $query = self::find();

        if (is_array($where) && $where) {
            $query->where($where);
        }

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
            ->where(['deleted' => 0, 'status' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

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
            ->where(['deleted' => 0, 'status' => 0]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

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
            ->where(['deleted' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
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
                self::bulkActions('unpublish', $item);

                $output['message'] = 'Brand unpublished successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActions('unpublish', $item);
                }

                $output['message'] = 'Selected brands have been successfully unpublished.';
            }
        } elseif ($action == 'publish') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActions('publish', $item);

                $output['message'] = 'Brand published successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActions('publish', $item);
                }

                $output['message'] = 'Selected brands have been successfully published.';
            }
        } elseif ($action == 'trash') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActions('trash', $item);

                $output['message'] = 'Brand moved to the trash successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActions('trash', $item);
                }

                $output['message'] = 'Selected brands have been successfully moved to the trash.';
            }
        } elseif ($action == 'restore') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActions('restore', $item);

                $output['message'] = 'Brand restored successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActions('restore', $item);
                }

                $output['message'] = 'Selected brands have been successfully restored.';
            }
        } elseif ($action == 'delete') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::deleteItem($item);

                $output['message'] = 'Brand deleted successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = $item = self::findOne($items[$i]);
                    self::deleteItem($item);
                }

                $output['message'] = 'Selected brands have been successfully deleted.';
            }
        }

        return $output;
    }

    /**
     * Bulk actions
     *
     * @param [type] $type
     * @param [type] $model
     * @return void
     */
    public static function bulkActions($type, $model)
    {
        if ($model) {
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
            set_log('admin', ['res_id' => $model->id, 'type' => 'brand', 'action' => $type]);
        }
    }

    /**
     * Delete item
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteItem($model)
    {
        if ($model) {
            $trash_item['content'] = $model->getAttributes();

            if ($model->delete(false)) {
                $id = $model->id;

                // Set trash
                set_trash(array(
                    'res_id' => $id,
                    'type' => 'brand',
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $model->id,
                    'type' => 'brand',
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
    public static function generateSlug($title)
    {
        $title_slug = Inflector::slug($title);
        $slug = $title_slug . '-' . rand(10000, 99999);
        $where = array('slug' => $slug);

        $item = self::find()
            ->where($where)
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;
                $slug = $title_slug . '-' . rand(10000, 99999);
                $where['slug'] = $slug;

                $item = self::find()
                    ->where($where)
                    ->one();
            } while ($item && $i < 10000);
        }

        return $slug;
    }

    /**
     * Get dropdown list
     *
     * @param [type] $model
     * @return array
     */
    public static function getDropdownList($model = false)
    {
        $output = array('0' => 'No brand');
        $where = array(
            'status' => 1,
            'deleted' => 0,
        );

        $query = self::find()
            ->where($where);

        if (isset($model->id) && is_numeric($model->id)) {
            $query->andWhere(['!=', 'id', $model->id]);
        }

        $query->orderBy(['title' => 'ASC']);
        $items = $query->all();

        if ($items) {
            foreach ($items as $item) {
                $output[$item->id] = $item->title;
            }
        }

        return $output;
    }

    /**
     * Menu page item render
     *
     * @param [type] $post
     * @param [type] $yii
     * @return array
     */
    public static function menuPageItemRender($post, $yii)
    {
        $output['error'] = true;
        $output['success'] = false;
        $output['message'] = 'An error occurred while processing your request. Please try agian.';

        $results = array();
        $search_items = array_value($post, 'search_items');
        $selected_items = array_value($post, 'selected_items');

        if ($selected_items) {
            $array = array_value($post, 'selected_array');

            if (is_array($array) && $array) {
                $query = self::find()
                    ->where(['in', 'id', $array])
                    ->all();

                if ($query) {
                    $output['error'] = false;
                    $output['success'] = true;
                    $output['message'] = 'Menu item was added successfully.';

                    foreach ($query as $value) {
                        $value_json = ['name' => $value->title];

                        $value_data = array(
                            'action_type' => 'brand',
                            'item_id' => $value->id,
                            'data' => json_encode($value_json),
                        );

                        $data[] = $yii->renderPartial('menu-item', $value_data);
                    }

                    $output['view'] = implode(' ', $data);
                }
            } else {
                $output['message'] = 'No items selected to add! Please select a brand to add to the menu!';
            }
        } elseif ($search_items) {
            $search = array_value($post, 'search');
            $search_key = clean_str($search);

            if (strlen($search_key) < 3) {
                $output['message'] = 'Please enter at least 3 characters to search!';
            } elseif ($search_key) {
                $results = self::find()
                    ->where(['like', 'title', $search_key])
                    ->all();

                if (!$results) {
                    $output['message'] = 'No results were found for your request! Please try other keywords!';
                }
            } else {
                $output['message'] = 'Enter your search keyword to find a brand!';
            }
        } else {
            $data = array();
            $results = self::find()
                ->where(['deleted' => 0, 'status' => 1])
                ->orderBy(['created_on' => SORT_DESC])
                ->limit(10)
                ->all();

            if ($results) {
                $output['message'] = '';
            } else {
                $output['message'] = 'Brands not found!';
            }
        }

        if ($results) {
            $data = array();
            $output['error'] = false;
            $output['success'] = true;

            foreach ($results as $value) {
                $value_data = array(
                    'item_type' => 'brand',
                    'item_id' => $value->id,
                    'item_title' => $value->title,
                );

                $data[] = $yii->renderPartial('ajax-item', $value_data);
            }

            $output['html'] = $data;
        }

        return $output;
    }
}
