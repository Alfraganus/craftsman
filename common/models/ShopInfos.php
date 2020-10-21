<?php

namespace common\models;

/**
 * This is the model class for table "shop_infos".
 *
 * @property int $info_id
 * @property int|null $shop_id
 * @property string|null $company_type
 * @property string|null $company_no
 * @property string|null $person_status
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $fax
 * @property string|null $country
 * @property string|null $city
 * @property string|null $region
 * @property string|null $postal_code
 * @property string|null $address
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $image
 * @property string|null $cover_image
 * @property string|null $files
 */
class ShopInfos extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'shop_infos';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['shop_id'], 'integer'],
            [['address', 'phone', 'mobile', 'fax', 'image', 'cover_image', 'postal_code'], 'string', 'max' => 255],
            [['files', 'email', 'company_type', 'company_no', 'person_status', 'country', 'city', 'region', 'description'], 'string'],
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
            'info_id' => 'Info ID',
            'shop_id' => 'Shop ID',
            'company_no' => 'Company No',
            'company_type' => 'Company Type',
            'person_status' => 'Person Status',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'country' => 'Country',
            'city' => 'City',
            'region' => 'Region',
            'postal_code' => 'Postal code',
            'address' => 'Address',
            'description' => 'Description',
            'image' => 'Image',
            'cover_image' => 'Cover Image',
            'files' => 'Files',
        ];
    }
}
