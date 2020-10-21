<?php

namespace backend\models;

use common\models\OrdersProperty;
use common\models\Products;
use common\models\ShopInfos;
use common\models\Shops;
use common\models\UsersField;
use Yii;
use yii\helpers\Inflector;

/**
 * Content model
 */
class Shop extends Shops
{
    /**
     * Get items
     *
     * @return object
     */
    public static function getItems()
    {
        $search = input_get('s');
        $sort = input_get('sort');

        $query = self::find()
            ->select('*')
            ->leftJoin('shop_infos', 'shop_infos.shop_id = shops.id');

        if ($search) {
            if (is_email($search)) {
                $query->andWhere(['like', 'shop_infos.email', $search]);
            } else {
                $query->andWhere(['or',
                    ['like', 'shops.title' => $search],
                    ['like', 'shops.phone' => $search],
                ]);
            }
        }

        if ($sort == 'a-z') {
            $sort_query = ['shops.title' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['shops.title' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['shops.id' => SORT_ASC];
        } else {
            $sort_query = ['shops.id' => SORT_DESC];
        }

        $query->orderBy($sort_query);

        return $query;
    }

    /**
     * Page types
     *
     * @param boolean $active
     * @return void
     */
    public static function getPageTypes($active = '')
    {
        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => self::countAll(),
            ),
            'active' => array(
                'name' => 'Active',
                'active' => false,
                'count' => self::countActive(),
            ),
            'pending' => array(
                'name' => 'Pending',
                'active' => false,
                'count' => self::countPending(),
            ),
            'blocked' => array(
                'name' => 'Blocked',
                'active' => false,
                'count' => self::countBanned(),
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => self::countDeleted(),
            ),
        );

        if (isset($page_types[$active])) {
            $page_types[$active]['active'] = true;
        }

        return $page_types;
    }

    /**
     * Count all shops
     *
     * @param array $where
     * @return int
     */
    public static function countAll($where = array())
    {
        $query = self::find();

        if (is_array($where) && $where) {
            $query->where($where);
        }

        return $query->count();
    }

    /**
     * Count active shops
     *
     * @param array $where
     * @return int
     */
    public static function countActive($where = array())
    {
        $query = self::find()
            ->where(['deleted' => 0, 'status' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count pending shops
     *
     * @param array $where
     * @return int
     */
    public static function countPending($where = array())
    {
        $query = self::find()
            ->where(['deleted' => 0, 'status' => 0]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count banned
     *
     * @param array $where
     * @return int
     */
    public static function countBanned($where = array())
    {
        $query = self::find()
            ->where(['deleted' => 0, 'status' => -1]);

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
    public static function countDeleted($where = array())
    {
        $query = self::find()
            ->where(['deleted' => 1]);

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        return $query->count();
    }

    /**
     * Count shop orders
     *
     * @param int $shop_id
     * @return int
     */
    public static function countShopOrders($shop_id)
    {
        if (is_numeric($shop_id) && $shop_id > 0) {
            $query = OrdersProperty::find()
                ->join('INNER JOIN', 'orders', 'orders.order_id = orders_property.order_id')
                ->where(['orders_property.shop_id' => $shop_id]);

            return $query->count();
        }
    }

    /**
     * Count shop products
     *
     * @param int $shop_id
     * @return int
     */
    public static function countShopProducts($shop_id)
    {
        if (is_numeric($shop_id) && $shop_id > 0) {
            $query = Products::find()
                ->where(['shop_id' => $shop_id]);

            return $query->count();
        }
    }

    /**
     * Count shop users
     *
     * @param int $shop_id
     * @return int
     */
    public static function countShopUsers($shop_id)
    {
        if (is_numeric($shop_id) && $shop_id > 0) {
            $query = UsersField::find()
                ->join('INNER JOIN', 'users', 'users.id = users_field.user_id')
                ->where(['users_field.field_key' => 'shop_id', 'users_field.field_value' => $shop_id]);

            return $query->count();
        }
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
        $message = false;
        $output['error'] = true;
        $output['success'] = false;

        if (is_numeric($id) && $id > 0) {
            $model = Shops::findOne(['id' => $id]);

            if ($model) {
                $set_log = false;

                switch ($action) {
                    case 'activate':
                        $set_log = true;
                        $model->status = 1;
                        $model->update(false);
                        $message = 'Shop activated successfully.';
                        break;
                    case 'block':
                        $set_log = true;
                        $model->status = -1;
                        $model->update(false);
                        $message = 'Shop blocked successfully.';
                        break;
                    case 'trash':
                        $set_log = true;
                        $model->deleted = 1;
                        $model->update(false);
                        $message = 'Shop moved to the trash successfully.';
                        break;
                    case 'restore':
                        $set_log = true;
                        $model->deleted = 0;
                        $model->update(false);
                        $message = 'Shop restored successfully.';
                        break;
                    case 'delete':
                        self::deleteShop($model);
                        $message = 'Shop deleted successfully.';
                        break;
                }

                // Set log
                if ($set_log) {
                    set_log('admin', ['res_id' => $model->id, 'type' => 'shop', 'action' => $action]);
                }
            }
        } elseif (is_array($items) && $items) {
            foreach ($items as $item) {
                $model = Shops::findOne(['id' => $item]);

                if ($model) {
                    $set_log = false;

                    switch ($action) {
                        case 'activate':
                            $set_log = true;
                            $model->status = 1;
                            $model->update(false);
                            $message = 'Selected shops have been successfully activated.';
                            break;
                        case 'block':
                            $set_log = true;
                            $model->status = -1;
                            $model->update(false);
                            $message = 'Selected shops have been successfully blocked.';
                            break;
                        case 'trash':
                            $set_log = true;
                            $model->deleted = 1;
                            $model->update(false);
                            $message = 'Selected shops have been successfully moved to the trash.';
                            break;
                        case 'restore':
                            $set_log = true;
                            $model->deleted = 0;
                            $model->update(false);
                            $message = 'Selected shops have been successfully restored.';
                            break;
                        case 'delete':
                            self::deleteShop($model);
                            $message = 'Selected shops have been successfully deleted.';
                            break;
                    }

                    // Set log
                    if ($set_log) {
                        set_log('admin', ['res_id' => $model->id, 'type' => 'shop', 'action' => $action]);
                    }
                }
            }
        }

        if ($message) {
            $output['error'] = false;
            $output['success'] = true;
            $output['message'] = $message;
        }

        return $output;
    }

    /**
     * Create shop
     *
     * @param [type] $model
     * @param [type] $info
     * @param [type] $post_item
     * @return int
     */
    public static function createShop($model, $info, $post_item)
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $current_user_id = Yii::$app->user->id;
        $vendors_id = array_value($post_item, 'vendors_id');

        // Create model
        $model->deleted = 0;
        $model->created_on = $now_date;
        $model->created_by = $current_user_id;
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;
        $model->slug = self::generateSlug($model->title);

        if ($model->save()) {
            $log_data['shop']['attrs'] = $model->getAttributes();
            $log_data['shop']['old_attrs'] = array();

            // Create info
            $info->shop_id = $model->id;

            if ($info->save()) {
                $log_data['info']['attrs'] = $info->getAttributes();
                $log_data['info']['old_attrs'] = array();

                if (is_array($vendors_id) && $vendors_id) {
                    self::bindVendors($vendors_id, $model);
                }

                // Set log
                set_log('admin', [
                    'res_id' => $model->id,
                    'type' => 'shop',
                    'action' => 'create',
                    'data' => json_encode($log_data),
                ]);
            }
        }

        return $model->id;
    }

    /**
     * Update shop
     *
     * @param [type] $model
     * @param [type] $info
     * @param [type] $post_item
     * @return int
     */
    public static function updateShop($model, $info, $post_item)
    {
        $log_data = array();
        $now_date = date('Y-m-d H:i:s');
        $current_user_id = Yii::$app->user->id;
        $vendors_id = array_value($post_item, 'vendors_id');

        if (empty($model->slug)) {
            $model->slug = self::generateSlug($model->title);
        }

        $model->deleted = 0;
        $model->updated_on = $now_date;
        $model->updated_by = $current_user_id;

        $model_oldAttributes = $model->getOldAttributes();
        $info_oldAttributes = $info->getOldAttributes();

        if ($model->save() && $info->save()) {
            $log_data['shop']['attrs'] = $model->getAttributes();
            $log_data['shop']['old_attrs'] = $model_oldAttributes;

            $log_data['info']['attrs'] = $info->getAttributes();
            $log_data['info']['old_attrs'] = $info_oldAttributes;

            if (is_array($vendors_id) && $vendors_id) {
                self::bindVendors($vendors_id, $model);
            }

            // Set log
            set_log('admin', [
                'res_id' => $model->id,
                'type' => 'shop',
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $model->id;
    }

    /**
     * Delete shop
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteShop($model)
    {
        if ($model) {
            $shop_id = $model->id;
            $trash_item['user'] = $model->getAttributes();

            if ($model->delete()) {
                $shop_info = ShopInfos::findOne(['shop_id' => $shop_id]);

                if ($shop_info) {
                    $trash_item['info'] = $shop_info->getAttributes();
                    $shop_info->delete();
                }

                // Set trash
                set_trash(array(
                    'res_id' => $shop_id,
                    'type' => 'shop',
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $shop_id,
                    'type' => 'shop',
                    'action' => 'delete',
                    'data' => json_encode($trash_item),
                ]);
            }
        }
    }

    /**
     * Generate slug
     *
     * @param [type] $title
     * @return string
     */
    public static function generateSlug($title)
    {
        $title_slug = Inflector::slug($title);
        $slug = $title_slug;
        $shop = self::find()->where(['slug' => $slug])->one();

        if ($shop) {
            $i = 0;

            do {
                $i++;
                $slug = $title_slug . '-' . rand(10000, 99999);
                $shop = self::find()->where(['slug' => $slug])->one();
            } while ($shop && $i < 100);
        }

        return $slug;
    }

    /**
     * Set vendors to shop
     *
     * @param [type] $vendors_id
     * @param [type] $model
     * @return void
     */
    public static function bindVendors($vendors_id, $model)
    {
        if ($model && is_array($vendors_id) && $vendors_id) {
            $shop_id = $model->id;
            $shop_vendors = UsersField::find()
                ->where(['field_key' => 'shop_id', 'field_value' => $shop_id])
                ->all();

            if ($shop_vendors) {
                $delete_array = array();

                foreach ($shop_vendors as $item) {
                    $user_id = $item->user_id;

                    if (in_array($user_id, $vendors_id)) {
                        $key = array_search($user_id, $vendors_id);
                        unset($vendors_id[$key]);
                    } else {
                        $delete_array[] = $item->field_id;
                    }
                }

                if ($delete_array) {
                    $str = implode(',', $delete_array);
                    $where_in = "field_id IN ({$str})";
                    UsersField::deleteAll($where_in);
                }
            }

            if ($vendors_id) {
                foreach ($vendors_id as $vendor_id) {
                    $data = array(
                        'user_id' => $vendor_id,
                        'field_key' => 'shop_id',
                        'field_value' => $shop_id,
                    );

                    $field = UsersField::find()->where($data)->one();

                    if (!$field) {
                        $user_field = new UsersField();
                        $user_field->user_id = $vendor_id;
                        $user_field->field_key = 'shop_id';
                        $user_field->field_value = $shop_id;
                        $user_field->save(false);
                    }
                }
            }
        }
    }

    /**
     * Search vendors
     *
     * @param [type] $keyword
     * @return object
     */
    public static function searchVendors($keyword)
    {
        if (is_string($keyword) && $keyword) {
            $model = User::find()
                ->join('INNER JOIN', 'profile', 'profile.user_id = users.id')
                ->join('INNER JOIN', 'auth_assignment', 'auth_assignment.user_id = users.id')
                ->where(['auth_assignment.item_name' => 'seller'])
                ->andWhere(['or',
                    ['users.status' => User::ACTIVE],
                    ['users.status' => User::PENDING],
                ]);

            if (is_email($keyword)) {
                $model->andWhere(['like', 'users.email', $keyword]);
            } elseif ($keyword) {
                $model->andWhere(['or',
                    ['like', 'profile.name', $keyword],
                    ['like', 'profile.surname', $keyword],
                    ['like', 'profile.lastname', $keyword],
                    ['like', 'users.username', $keyword],
                    ['like', 'users.email', $keyword],
                ]);
            }

            $model->orderBy('profile.name', 'ASC');
            $model->with('profile');

            return $model->all();
        }
    }
}
