<?php

namespace backend\models;

use common\models\CurrencyList;
use common\models\LogsAdmin;
use common\models\LogsFrontend;
use common\models\LogsSeller;
use common\models\ProductsField;
use common\models\ProductsInfo;
use common\models\Products;
use common\models\ProductsCategory;
use common\models\Profile;
use common\models\Shops;
use Yii;
use yii\helpers\Inflector;

/**
 * Product model
 */
class Product extends Products
{
    /**
     * Get products
     *
     * @return object
     */
    public static function getItems($page_type = '', $args = array())
    {
        $search = input_get('s');
        $sort = input_get('sort');

        $current_lexicon = get_content_lexicon();
        self::$selected_language = array_value($current_lexicon, 'lang_code', 'en');

        if (empty($sort) && array_value($args, 'sort')) {
            $sort = array_value($args, 'sort');
        }

        $query = self::find()
            ->select('products.*, info.*')
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where(['info.language' => self::$selected_language]);

        if ($search) {
            $query->andWhere([
                'or',
                ['info.name' => $search],
                ['products.upc' => $search],
                ['products.mpn' => $search],
            ]);
        }

        if ($sort == 'a-z') {
            $sort_query = ['info.name' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['info.name' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['products.created_on' => SORT_ASC];
        } else {
            $sort_query = ['products.created_on' => SORT_DESC];
        }

        $query->with([
            'info' => function ($query) {
                $query->andWhere(['language' => self::$selected_language]);
            },
        ]);

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
                'count' => self::allCount(['products.deleted' => 0]),
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => self::publishedCount(),
            ),
            'pending' => array(
                'name' => 'Pending',
                'active' => false,
                'count' => self::pendingCount(),
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
        $active_languages = get_active_langs();
        $translations_title = array_value($post_item, 'translations_title');

        // Create model
        $model = self::checkProductData($model, $post_item);

        if ($model->save()) {
            $log_data['product']['attrs'] = $model->getAttributes();
            $log_data['product']['old_attrs'] = array();

            // Category
            self::bindCategory($model);

            // Create info
            $info->product_id = $model->id;

            if (empty($info->language)) {
                $info->language = $active_languages ? $active_languages[0]['lang_code'] : 'en';
            }

            $info = self::checkInfoData($info);

            if ($info->save()) {
                $log_data['info'][$info->language]['attrs'] = $info->getAttributes();
                $log_data['info'][$info->language]['old_attrs'] = array();

                // Create translations
                if ($active_languages) {
                    $item_lang = $info->language;

                    foreach ($active_languages as $active_language) {
                        $lang_code = $active_language['lang_code'];

                        if ($item_lang != $lang_code) {
                            $new = new ProductsInfo();
                            $new->setAttributes($info->getAttributes());

                            if (isset($translations_title[$lang_code]) && $translations_title[$lang_code]) {
                                $new->name = $translations_title[$lang_code];
                            }

                            $new->language = $lang_code;
                            $new->slug = self::generateSlug($new->name, $new->language);

                            if ($new->save(false)) {
                                $log_data['info'][$new->language]['attrs'] = $new->getAttributes();
                                $log_data['info'][$new->language]['old_attrs'] = array();
                            }
                        }
                    }
                }

                // Set log
                set_log('admin', [
                    'res_id' => $model->id,
                    'type' => 'product',
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
        $current_user_id = Yii::$app->user->id;
        $active_languages = get_active_langs();

        if (empty($info->language)) {
            $info->language = $active_languages ? $active_languages[0]['lang_code'] : 'en';
        }

        $item_lang = $info->language;
        $item_lang_old = $info->getOldAttribute('language');

        // Check language
        if ($item_lang != $item_lang_old && $info->info_id > 0) {
            $find_translation = ProductsInfo::find()
                ->where(['product_id' => $model->id, 'language' => $item_lang])
                ->all();

            if ($find_translation) {
                $error = 'Translation found. Please select an empty language!';
                return $error;
            }
        }

        // Save model
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        $model = self::checkProductData($model, $post_item);
        $model_oldAttributes = $model->getOldAttributes();

        if ($model->save()) {
            $log_data['product']['attrs'] = $model->getAttributes();
            $log_data['product']['old_attrs'] = $model_oldAttributes;

            // Category
            self::bindCategory($model);

            // Check info
            $info = self::checkInfoData($info);

            // Update info
            if ($info->info_id < 1) {
                unset($info->info_id);

                $new = new ProductsInfo();
                $new->setAttributes($info->getAttributes());
                $new->slug = self::generateSlug($new->title, $new->language);

                if ($new->save()) {
                    $log_data['info'][$new->language]['attrs'] = $new->getAttributes();
                    $log_data['info'][$new->language]['old_attrs'] = array();
                }
            } else {
                $info_oldAttributes = $info->getOldAttributes();

                if ($info->save()) {
                    $log_data['info'][$info->language]['attrs'] = $info->getAttributes();
                    $log_data['info'][$info->language]['old_attrs'] = $info_oldAttributes;
                }
            }

            // Update translations
            $product_translations = ProductsInfo::find()
                ->where(['!=', 'info_id', $info->info_id])
                ->andWhere(['product_id' => $model->id])
                ->all();

            if ($product_translations) {
                foreach ($product_translations as $translation_info) {
                    $update_item = false;
                    $translation_oldAttributes = $translation_info->getOldAttributes();

                    if (empty($translation_info->slug)) {
                        $update_item = true;
                        $translation_info->slug = self::generateSlug($translation_info->name, $translation_info->language);
                    }

                    if ($info->short_title && empty($translation_info->short_title)) {
                        $update_item = true;
                        $translation_info->short_title = $info->short_title;
                    }

                    if ($info->description && empty($translation_info->description)) {
                        $update_item = true;
                        $translation_info->description = $info->description;
                    }

                    if ($info->image && empty($translation_info->image)) {
                        $update_item = true;
                        $translation_info->image = $info->image;
                    }

                    if ($info->gallery && empty($translation_info->gallery)) {
                        $update_item = true;
                        $translation_info->gallery = $info->gallery;
                    }

                    if ($info->type && empty($translation_info->type)) {
                        $update_item = true;
                        $translation_info->type = $info->type;
                    }

                    if ($update_item && $translation_info->save()) {
                        $log_data['info'][$translation_info->language]['attrs'] = $translation_info->getAttributes();
                        $log_data['info'][$translation_info->language]['old_attrs'] = $translation_oldAttributes;
                    }
                }
            }

            // Set log
            set_log('admin', [
                'res_id' => $model->id,
                'type' => 'product',
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $model->id;
    }

    /**
     * Get item to edit
     *
     * @param [type] $id
     * @return array
     */
    public static function getItemToEdit($id)
    {
        $lang_key = input_get('lang', 'en');

        $model = self::findOne($id);
        $info = ProductsInfo::find()->where(['product_id' => $id, 'language' => $lang_key])->one();
        $translations = ProductsInfo::find()->where(['product_id' => $id])->all();

        if (!$info) {
            $info = ProductsInfo::find()->where(['product_id' => $id])->one();

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
     * Get currencies
     *
     * @return array
     */
    public static function getCurrencies()
    {
        $output = array('' => '-');

        $results = CurrencyList::find()
            ->where(['status' => 1])
            ->all();

        if ($results) {
            foreach ($results as $item) {
                $output[$item->currency_code] = $item->currency_name;
            }
        }

        return $output;
    }

    /**
     * Get vendors
     *
     * @return array
     */
    public static function getVendors()
    {
        $output = array('0' => 'No vendor');

        $results = User::find()
            ->leftJoin('profile', 'profile.user_id = users.id')
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = users.id')
            ->where(['users.status' => User::ACTIVE])
            ->andWhere([
                'or',
                ['=', 'auth_assignment.item_name', 'admin'],
                ['=', 'auth_assignment.item_name', 'seller'],
            ])
            ->orderBy(['profile.name' => SORT_ASC])
            ->all();

        if ($results) {
            foreach ($results as $item) {
                $output[$item->id] = Profile::getFullname($item->profile);
            }
        }

        return $output;
    }

    /**
     * Get shops
     *
     * @return array
     */
    public static function getShops()
    {
        $output = array('0' => '-');

        $results = Shops::find()
            ->where(['status' => User::ACTIVE])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        if ($results) {
            foreach ($results as $item) {
                $output[$item->id] = $item->title;
            }
        }

        return $output;
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
            2 => 'Pending',
            0 => 'Unpublished',
        ];

        if (isset($array[$key])) {
            return $array[$key];
        }

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
        $query = self::find();
        $query->join('INNER JOIN', 'products_info info', 'info.product_id = products.id');

        if (is_array($where) && $where) {
            $query->where($where);
        }

        $query->groupBy('info.product_id');
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
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where(['products.deleted' => 0, 'products.status' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.product_id');
        return $query->count();
    }

    /**
     * Count pending
     *
     * @param array $where
     * @return int
     */
    public static function pendingCount($where = array())
    {
        $query = self::find()
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where(['products.deleted' => 0, 'products.status' => 2]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.product_id');
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
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where(['products.deleted' => 0, 'products.status' => 0]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.product_id');
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
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where(['products.deleted' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        $query->groupBy('info.product_id');
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
                self::bulkActionWithProduct('unpublish', $item);

                $output['message'] = 'Product unpublished successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithProduct('unpublish', $item);
                }

                $output['message'] = 'Selected products have been successfully unpublished.';
            }
        } elseif ($action == 'publish') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithProduct('publish', $item);

                $output['message'] = 'Product published successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithProduct('publish', $item);
                }

                $output['message'] = 'Selected products have been successfully published.';
            }
        } elseif ($action == 'trash') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithProduct('trash', $item);

                $output['message'] = 'Product moved to the trash successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithProduct('trash', $item);
                }

                $output['message'] = 'Selected products have been successfully moved to the trash.';
            }
        } elseif ($action == 'restore') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::bulkActionWithProduct('restore', $item);

                $output['message'] = 'Product restored successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = self::findOne($items[$i]);
                    self::bulkActionWithProduct('restore', $item);
                }

                $output['message'] = 'Selected products have been successfully restored.';
            }
        } elseif ($action == 'delete') {
            $output['error'] = false;
            $output['success'] = true;

            if (is_numeric($id) && $id > 0) {
                $item = self::findOne($id);
                self::deleteProduct($item);

                $output['message'] = 'Product deleted successfully.';
            } elseif (!empty($items)) {
                for ($i = 0; $i < count($items); $i++) {
                    $item = $item = self::findOne($items[$i]);
                    self::deleteProduct($item);
                }

                $output['message'] = 'Selected products have been successfully deleted.';
            }
        }

        return $output;
    }

    /**
     * Actions with product
     *
     * @param [type] $type
     * @param [type] $model
     * @return void
     */
    public static function bulkActionWithProduct($type, $model)
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
            set_log('admin', ['res_id' => $model->id, 'type' => 'product', 'action' => $type]);
        }
    }

    /**
     * Delete product
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteProduct($model)
    {
        if ($model) {
            $id = $model->id;
            $trash_item['content'] = $model->getAttributes();

            if ($model->delete(false)) {
                $info = ProductsInfo::find()->where(['product_id' => $id])->all();
                $fields = ProductsField::find()->where(['product_id' => $id])->all();
                $categories = ProductsCategory::find()->where(['product_id' => $id])->all();

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

                if ($categories) {
                    foreach ($categories as $categories_item) {
                        $trash_item['category'][] = $categories_item->getAttributes();
                        $categories_item->delete();
                    }
                }

                LogsAdmin::deleteAll(['res_id' => $id, 'type' => 'product']);
                LogsFrontend::deleteAll(['res_id' => $id, 'type' => 'product']);
                LogsSeller::deleteAll(['res_id' => $id, 'type' => 'product']);

                // Set trash
                set_trash(array(
                    'res_id' => $id,
                    'type' => 'product',
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $id,
                    'type' => 'product',
                    'action' => 'delete',
                    'data' => json_encode($trash_item),
                ]);
            }
        }
    }

    /**
     * Settings array
     *
     * @param [type] $model
     * @param [type] $model
     * @return array
     */
    public static function settingsArray($model, $type = 'settings')
    {
        $array = array();

        if ($type == 'meta') {
            $types = array('meta_title', 'meta_description', 'focus_keywords');
        } else {
            $types = array('layout', 'template');
        }

        foreach ($types as $type) {
            if (isset($model->$type)) {
                $array[$type] = $model->$type;
            }
        }

        return $array;
    }

    /**
     * Slug generator
     *
     * @param [type] $title
     * @param [type] $lang
     * @return string
     */
    public static function generateSlug($title, $lang = false)
    {
        $title_slug = Inflector::slug($title);
        $slug = $title_slug . '-' . rand(1000000, 9999999);
        $where = array('info.slug' => $slug);

        if ($lang) {
            $where['info.language'] = $lang;
        }

        $item = self::find()
            ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
            ->where($where)
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;
                $slug = $title_slug . '-' . rand(1000000, 9999999);
                $where['info.slug'] = $slug;

                $item = self::find()
                    ->join('INNER JOIN', 'products_info info', 'info.product_id = products.id')
                    ->where($where)
                    ->one();
            } while ($item && $i < 10000);
        }

        return $slug;
    }

    /**
     * Generate Universal Product Code
     *
     * @return string
     */
    public static function generateUPCode()
    {
        $upc = generate_product_upc();
        $where = array('products.upc' => $upc);

        $item = self::find()
            ->where($where)
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;

                if ($i > 5000) {
                    $upc = generate_product_upc() . '-' . rand(10000, 99999);
                } else {
                    $upc = generate_product_upc();
                }

                $where['products.upc'] = $upc;

                $item = self::find()
                    ->where($where)
                    ->one();
            } while ($item && $i < 10000);
        }

        return strtoupper($upc);
    }

    /**
     * Check Universal Product Code
     *
     * @param [type] $model
     * @return string
     */
    public static function checkUPCode($model)
    {
        $upc = $model->upc;
        $where = array('products.upc' => $upc);

        $item = self::find()
            ->where($where)
            ->andWhere(['!=', 'products.id', $model->id])
            ->one();

        if ($item) {
            $i = 0;

            do {
                $i++;
                $upc = $model->upc . '-' . $i;
                $where['products.upc'] = $upc;

                $item = self::find()
                    ->where($where)
                    ->andWhere(['!=', 'products.id', $model->id])
                    ->one();
            } while ($item && $i < 10000);
        }

        return strtoupper($upc);
    }

    /**
     * Check product data
     *
     * @param [type] $model
     * @param [type] $post_item
     * @return object
     */
    public static function checkProductData($model, $post_item)
    {
        $output = $model;

        if ($model) {
            $now_date = date('Y-m-d H:i:s');
            $current_user_id = Yii::$app->user->id;

            $price = round($model->price, 2);
            $discount_type = array_value($post_item, 'discount_type');
            $discount_price = round(array_value($post_item, 'discount_price'), 2);
            $discount_percentage = round(array_value($post_item, 'discount_percentage'), 2);

            if ($discount_type == 'price' && $discount_price > 0) {
                $model->discount_price = $discount_price;
                $model->discount = ($discount_price / $price) * 100;
                $model->discount = round((100 - $model->discount), 2);
                $model->discount_type = $discount_type;
            } elseif ($discount_type == 'percentage' && $discount_percentage > 0 && $discount_percentage < 100) {
                $model->discount_price = $price * ($discount_percentage / 100);
                $model->discount_price = round($price - $model->discount_price, 2);
                $model->discount = $discount_percentage;
                $model->discount_type = $discount_type;
            }

            if (empty($output->upc)) {
                $output->upc = generate_product_upc();
            } else {
                $output->upc = self::checkUPCode($model);
            }

            if (is_numeric($model->shop_id)) {
                $output->shop_id = $model->shop_id;
            } else {
                $output->shop_id = 0;
            }

            if ($model->created_on) {
                $output->created_on = $model->created_on;
            } else {
                $output->created_on = $now_date;
            }

            if (is_numeric($model->created_by)) {
                $output->created_by = $model->created_by;
            } else {
                $output->created_by = $current_user_id;
            }

            if ($model->updated_on) {
                $output->updated_on = $model->updated_on;
            } else {
                $output->updated_on = $now_date;
            }

            if (is_numeric($model->updated_by)) {
                $output->updated_by = $model->updated_by;
            } else {
                $output->updated_by = $current_user_id;
            }

            if (is_numeric($model->price)) {
                $output->price = round($model->price, 2);
            } else {
                $output->price = 0.00;
            }

            if (is_numeric($model->discount_price)) {
                $output->discount_price = round($model->discount_price, 2);
            } else {
                $output->discount_price = 0.00;
            }

            if (is_numeric($model->discount)) {
                $output->discount = round($model->discount, 2);
            } else {
                $output->discount = 0;
            }

            if ($model->discount_type) {
                $output->discount_type = $model->discount_type;
            } else {
                $output->discount_type = '';
            }

            if (is_numeric($model->quantity)) {
                $output->quantity = round($model->quantity);
            } else {
                $output->quantity = 1000;
            }

            if (is_numeric($model->quantity_min)) {
                $output->quantity_min = round($model->quantity_min);
            } else {
                $output->quantity_min = 1;
            }

            if ($model->template) {
                $output->template = $model->template;
            } else {
                $output->template = '';
            }

            if ($model->layout) {
                $output->layout = $model->layout;
            } else {
                $output->layout = '';
            }
        }

        return $output;
    }

    /**
     * Check product info
     *
     * @param [type] $info
     * @return object
     */
    public static function checkInfoData($info)
    {
        $output = $info;

        if ($info) {
            if (empty($output->slug)) {
                $output->slug = self::generateSlug($info->name, $info->language);
            }

            if ($info->short_title) {
                $output->short_title = $info->short_title;
            } else {
                $output->short_title = '';
            }

            if ($info->gallery) {
                $output->gallery = $info->gallery;
            } else {
                $output->gallery = '';
            }

            if ($info->type) {
                $output->type = $info->type;
            } else {
                $output->type = '';
            }

            $meta = self::settingsArray($info, 'meta');
            $output->meta = json_encode($meta);
        }

        return $output;
    }

    /**
     * Get product categories array
     *
     * @param [type] $model
     * @return void
     */
    public static function getProductCategoriesArray($model)
    {
        $array = array();

        $product_categories = ProductsCategory::find()
            ->where(['product_id' => $model->id])
            ->all();

        if ($product_categories) {
            foreach ($product_categories as $product_category) {
                $prc_id = $product_category->category_id;

                if (is_numeric($prc_id) && $prc_id > 0) {
                    $array[] = $prc_id;
                }
            }
        }

        return $array;
    }

    /**
     * Bind category
     *
     * @param [type] $model
     * @return void
     */
    public static function bindCategory($model)
    {
        $old = array();
        $for_count = array();
        $categories = $model->category_id;

        $product_categories = ProductsCategory::find()
            ->where(['product_id' => $model->id])
            ->all();

        if ($product_categories) {
            foreach ($product_categories as $product_category) {
                $prc_id = $product_category->category_id;

                if (is_numeric($prc_id) && $prc_id > 0) {
                    $old[$prc_id] = $product_category;
                    $for_count[$prc_id] = $prc_id;
                } else {
                    $product_category->delete();
                }
            }
        }

        if (is_numeric($categories) && $categories > 0) {
            $item = new ProductsCategory();
            $item->product_id = $model->id;
            $item->category_id = $categories;
            $item->save();

            $for_count[$categories] = $categories;

            if (isset($old[$categories])) {
                unset($old[$categories]);
            }
        } elseif (is_array($categories) && $categories) {
            foreach ($categories as $category_id) {
                if (isset($old[$category_id])) {
                    unset($old[$category_id]);
                } elseif (is_numeric($category_id) && $category_id > 0) {
                    $item = new ProductsCategory();
                    $item->product_id = $model->id;
                    $item->category_id = $category_id;
                    $item->save();

                    $for_count[$category_id] = $category_id;
                }
            }
        }

        if ($old) {
            foreach ($old as $old_category) {
                $old_category->delete();
            }
        }

        if ($for_count) {
            foreach ($for_count as $fc_category) {
                Segment::countProducts($fc_category);
            }
        }
    }
}
