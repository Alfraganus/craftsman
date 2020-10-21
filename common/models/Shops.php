<?php

namespace common\models;

/**
 * This is the model class for table "shops".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $type
 * @property int|null $status
 * @property int|null $sort
 * @property int|null $deleted
 * @property int|null $created_on
 * @property int|null $created_by
 * @property int|null $updated_on
 * @property int|null $updated_by
 */
class Shops extends \yii\db\ActiveRecord
{
    public $vendors_id = array();

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'shops';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'status', 'sort'], 'required'],
            [['title', 'slug', 'type'], 'string'],
            [['status', 'sort', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['sort', 'status', 'deleted'], 'default', 'value' => 0],
            ['created_on', 'default', 'value' => date('Y-m-d H:i:s')],
            ['updated_on', 'default', 'value' => date('Y-m-d H:i:s')],
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
            'title' => 'Title',
            'slug' => 'Slug',
            'type' => 'Status Type',
            'sort' => 'Sort',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Get shop info
     *
     * @return void
     */
    public function getInfo()
    {
        return $this->hasOne(ShopInfos::className(), ['shop_id' => 'id']);
    }

    /**
     * Get shop
     *
     * @param [array] $array
     * @return object
     */
    public static function getShop($array)
    {
        $query = self::find()
            ->leftJoin('shop_infos', 'shop_infos.shop_id = shops.id')
            ->where($array)
            ->with('info');

        return $query->one();
    }

    public static function status($key = false)
    {
        $array = array(
            1 => 'Active',
            -1 => 'Blocked',
            0 => 'Pending',
        );

        if ($key) {
            return isset($array[$key]) ? $array[$key] : '';
        }

        return $array;
    }

    public static function status_types($key = false)
    {
        $array = array(
            'applied' => 'Applied Company',
            'confirmed' => 'Confirmed Company',
            'sponsored' => 'Sponsored Company',
        );

        if ($key) {
            return isset($array[$key]) ? $array[$key] : '';
        }

        return $array;
    }

    public static function company_types($key = false)
    {
        $array = array(
            'mchj' => 'МЧЖ',
            'ooo' => 'ООО',
        );

        if ($key) {
            return isset($array[$key]) ? $array[$key] : '';
        }

        return $array;
    }

    public static function person_status($key = false)
    {
        $array = array(
            'individual' => 'Individual',
            'legal-person' => 'Legal person',
        );

        if ($key) {
            return isset($array[$key]) ? $array[$key] : '';
        }

        return $array;
    }

    /**
     * Get shop name
     *
     * @param object $shop
     * @return string
     */
    public static function shopName($shop)
    {
        $output = 'Unknown Company';

        if ($shop && !empty($shop->title)) {
            $output = $shop->title;

            if (isset($shop->info->company_type) && !empty($shop->info->company_type)) {
                $output = self::company_types($shop->info->company_type) . ' ' . $shop->title;
            }
        }

        return $output;
    }

    /**
     * Get shop image
     *
     * @param object $info
     * @return string
     */
    public static function shopImage($shop)
    {
        $image = images_url('shop.png');

        if ($shop && $shop->image && is_url($shop->image)) {
            $image = $shop->image;
        }

        return $image;
    }

    /**
     * Get vendors
     *
     * @param [type] $shop_id
     * @return object
     */
    public static function getVendors($shop_id)
    {
        if (is_numeric($shop_id) && $shop_id > 0) {
            $model = User::find()
                ->join('INNER JOIN', 'profile', 'profile.user_id = users.id')
                ->join('INNER JOIN', 'auth_assignment', 'auth_assignment.user_id = users.id')
                ->join('INNER JOIN', 'users_field', 'users_field.user_id = users.id')
                ->where(['auth_assignment.item_name' => 'seller'])
                ->andWhere(['users_field.field_key' => 'shop_id', 'users_field.field_value' => $shop_id]);

            $model->orderBy('profile.name', 'ASC');
            $model->with('profile');

            return $model->all();
        }
    }
}
