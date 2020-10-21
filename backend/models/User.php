<?php

namespace backend\models;

use common\models\AuthAssignment;
use common\models\LogsAdmin;
use common\models\LogsFrontend;
use common\models\LogsSeller;
use common\models\OrdersProperty;
use common\models\Products;
use common\models\Profile;
use common\models\UsersField;
use common\models\UsersSession;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $deleted
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class User extends \yii\db\ActiveRecord
{
    const ACTIVE = 10;
    const BANNED = 5;
    const PENDING = 0;

    public $role;
    public $password;
    public $password_repeat;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['password', 'required', 'on' => 'isNewRecord'],
            [['status', 'deleted', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['role'], 'safe'],
            [['password_reset_token'], 'unique'],
            [['status', 'deleted'], 'default', 'value' => 0],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Passwords don't match"],
        ];
    }

    /**
     * Attribute labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Get profile
     *
     * @return void
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

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
            ->leftJoin('profile', 'profile.user_id = users.id');

        if ($search) {
            if (is_email($search)) {
                $query->andWhere(['like', 'users.email', $search]);
            } else {
                $query->andWhere([
                    'or',
                    ['profile.name' => $search],
                    ['profile.surname' => $search],
                    ['profile.lastname' => $search],
                    ['users.username' => $search],
                    ['users.email' => $search],
                ]);
            }
        }

        if ($sort == 'a-z') {
            $sort_query = ['profile.name' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['profile.name' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['users.created_at' => SORT_ASC];
        } else {
            $sort_query = ['users.created_at' => SORT_DESC];
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
     * Status array
     *
     * @param int $key
     * @return array
     */
    public function statusArray($key = null)
    {
        $array = [
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::BANNED => 'Blocked',
        ];

        if (isset($array[$key])) {
            return $array[$key];
        }

        return $array;
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
            ->where(['deleted' => 0, 'status' => self::ACTIVE]);

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
            ->where(['deleted' => 0, 'status' => self::PENDING]);

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
            ->where(['deleted' => 0, 'status' => self::BANNED]);

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
    public static function countOrders($shop_id)
    {
        $count = 0;

        if (is_numeric($shop_id) && $shop_id > 0) {
            $query = OrdersProperty::find()
                ->join('INNER JOIN', 'orders', 'orders.order_id = orders_property.order_id')
                ->where(['orders_property.shop_id' => $shop_id]);

            $count = $query->count();
        }

        return $count > 0 ? $count : '0';
    }

    /**
     * Count shop products
     *
     * @param int $shop_id
     * @return int
     */
    public static function countProducts($shop_id)
    {
        $count = 0;

        if (is_numeric($shop_id) && $shop_id > 0) {
            $query = Products::find()
                ->where(['shop_id' => $shop_id]);

            $count = $query->count();
        }

        return $count > 0 ? $count : '0';
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
            $model = self::findOne(['id' => $id]);

            if ($model) {
                $set_log = false;

                switch ($action) {
                    case 'activate':
                        $set_log = true;
                        $model->status = self::ACTIVE;
                        $model->update(false);
                        $message = 'User activated successfully.';
                        break;
                    case 'block':
                        $set_log = true;
                        $model->status = self::BANNED;
                        $model->update(false);
                        $message = 'User blocked successfully.';
                        break;
                    case 'trash':
                        $set_log = true;
                        $model->deleted = 1;
                        $model->update(false);
                        $message = 'User moved to the trash successfully.';
                        break;
                    case 'restore':
                        $set_log = true;
                        $model->deleted = 0;
                        $model->update(false);
                        $message = 'User restored successfully.';
                        break;
                    case 'delete':
                        self::deleteUser($model);
                        $message = 'User deleted successfully.';
                        break;
                }

                // Set log
                if ($set_log) {
                    set_log('admin', ['res_id' => $model->id, 'type' => 'user', 'action' => $action]);
                }
            }
        } elseif (is_array($items) && $items) {
            foreach ($items as $item) {
                $model = self::findOne(['id' => $item]);

                if ($model) {
                    $set_log = false;

                    switch ($action) {
                        case 'activate':
                            $set_log = true;
                            $model->status = self::ACTIVE;
                            $model->update(false);
                            $message = 'Selected users have been successfully activated.';
                            break;
                        case 'block':
                            $set_log = true;
                            $model->status = self::BANNED;
                            $model->update(false);
                            $message = 'Selected users have been successfully blocked.';
                            break;
                        case 'trash':
                            $set_log = true;
                            $model->deleted = 1;
                            $model->update(false);
                            $message = 'Selected users have been successfully moved to the trash.';
                            break;
                        case 'restore':
                            $set_log = true;
                            $model->deleted = 0;
                            $model->update(false);
                            $message = 'Selected users have been successfully restored.';
                            break;
                        case 'delete':
                            self::deleteUser($model);
                            $message = 'Selected users have been successfully deleted.';
                            break;
                    }

                    // Set log
                    if ($set_log) {
                        set_log('admin', ['res_id' => $model->id, 'type' => 'user', 'action' => $action]);
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
     * Create user
     *
     * @param [type] $user
     * @param [type] $profile
     * @return int
     */
    public function createUser($user, $profile)
    {
        $now = time();
        $log_data = array();

        $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
        $user->auth_key = md5(_random_string('alnum', 40) . $now);
        $user->created_at = $now;
        $user->updated_at = $now;
        $user->deleted = 0;

        if ($user->save()) {
            $log_data['user']['attrs'] = $user->getAttributes();
            $log_data['user']['old_attrs'] = array();

            $profile->user_id = $user->id;

            if ($profile->save()) {
                $log_data['profile']['attrs'] = $profile->getAttributes();
                $log_data['profile']['old_attrs'] = array();

                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole($user->role);
                $auth->assign($authorRole, $user->id);

                // Set log
                set_log('admin', [
                    'res_id' => $user->id,
                    'type' => 'user',
                    'action' => 'create',
                    'data' => json_encode($log_data),
                ]);
            }
        }

        return $user->id;
    }

    /**
     * Update user
     *
     * @param [type] $user
     * @param [type] $profile
     * @param [type] $post_item
     * @return int
     */
    public function updateUser($user, $profile, $post_item)
    {
        $now = time();
        $log_data = array();

        if ($user->password) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
        }

        $user->updated_at = $now;
        $user_oldAttributes = $user->getOldAttributes();
        $profile_oldAttributes = $profile->getOldAttributes();

        if ($user->save(false) && $profile->save()) {
            $log_data['user']['attrs'] = $user->getAttributes();
            $log_data['user']['old_attrs'] = $user_oldAttributes;

            $log_data['profile']['attrs'] = $profile->getAttributes();
            $log_data['profile']['old_attrs'] = $profile_oldAttributes;

            $authAssignment = AuthAssignment::find()->where(['user_id' => $user->id])->one();
            $authAssignment->load($post_item);
            $authAssignment->item_name = $user->role;
            $authAssignment->save();

            // Set log
            set_log('admin', [
                'res_id' => $user->id,
                'type' => 'user',
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $user->id;
    }

    /**
     * Update profile
     *
     * @param [type] $user
     * @param [type] $profile
     * @param [type] $post_item
     * @return int
     */
    public function updateProfile($user, $profile, $post_item)
    {
        $now = time();
        $log_data = array();

        $user->updated_at = $now;
        $user_oldAttributes = $user->getOldAttributes();
        $profile_oldAttributes = $profile->getOldAttributes();

        if ($user->save() && $profile->save()) {
            $log_data['user']['attrs'] = $user->getAttributes();
            $log_data['user']['old_attrs'] = $user_oldAttributes;

            $log_data['profile']['attrs'] = $profile->getAttributes();
            $log_data['profile']['old_attrs'] = $profile_oldAttributes;

            // Set log
            set_log('admin', [
                'res_id' => $user->id,
                'type' => 'profile',
                'action' => 'update',
                'data' => json_encode($log_data),
            ]);
        }

        return $user->id;
    }

    /**
     * Delete user
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteUser($model)
    {
        if ($model) {
            $id = $model->id;
            $trash_item['user'] = $model->getAttributes();

            if ($model->delete(false)) {
                $profile = Profile::findOne(['user_id' => $id]);
                $sessions = UsersSession::findOne(['user_id' => $id]);
                $fields = UsersField::find()->where(['user_id' => $id])->all();

                if ($profile) {
                    $trash_item['profile'][] = $profile->getAttributes();
                    $profile->delete();
                }

                if ($sessions) {
                    $trash_item['sessions'][] = $sessions->getAttributes();
                    $sessions->delete();
                }

                if ($fields) {
                    foreach ($fields as $field_item) {
                        $trash_item['fields'][] = $field_item->getAttributes();
                        $field_item->delete();
                    }
                }

                AuthAssignment::deleteAll(['user_id' => $id]);
                LogsAdmin::deleteAll(['user_id' => $id]);
                LogsFrontend::deleteAll(['user_id' => $id]);
                LogsSeller::deleteAll(['user_id' => $id]);

                // Set trash
                set_trash(array(
                    'res_id' => $id,
                    'type' => 'user',
                    'data' => json_encode($trash_item),
                ));

                // Set log
                set_log('admin', [
                    'res_id' => $id,
                    'type' => 'user',
                    'action' => 'delete',
                    'data' => json_encode($trash_item),
                ]);
            }
        }
    }

    /**
     * Get role
     *
     * @param [type] $user_id
     * @return array
     */
    public static function getRole($user_id)
    {
        $role = array();

        if (is_numeric($user_id) && $user_id > 0) {
            $query = "SELECT itm.* FROM auth_assignment asg
                JOIN auth_item itm ON (asg.item_name = itm.name)
                WHERE asg.user_id = '{$user_id}'";

            $role = Yii::$app->db
                ->createCommand($query)
                ->queryOne();
        }

        return $role;
    }

    /**
     * Get user shop
     *
     * @param int $user_id
     * @return object
     */
    public static function getShop($user_id)
    {
        if (is_numeric($user_id) && $user_id > 0) {
            $query = Shop::find()
                ->select('*')
                ->join('INNER JOIN', 'users_field', 'users_field.field_value = shops.id')
                ->where(['users_field.user_id' => $user_id, 'users_field.field_key' => 'shop_id']);

            return $query->one();
        }
    }
}
