<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $shop_id
 * @property int $category_id
 * @property int $brand_id
 * @property string $upc
 * @property string $mpn
 * @property string $currency
 * @property float $price
 * @property float $discount
 * @property float $discount_price
 * @property int $discount_type
 * @property int $quantity
 * @property int $quantity_min
 * @property string $template
 * @property string $layout
 * @property int $sort
 * @property int|null $status
 * @property int $deleted
 * @property int $cacheable
 * @property int $searchable
 * @property string|null $created_on
 * @property int $created_by
 * @property string|null $updated_on
 * @property int $updated_by
 */
class Products extends \yii\db\ActiveRecord
{
    public $category_id;
    public static $selected_language = 'en';

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['upc'], 'unique'],
            [['created_on', 'updated_on'], 'safe'],
            [['category_id', 'price', 'currency'], 'required'],
            [['shop_id', 'brand_id', 'quantity', 'quantity_min', 'sort', 'status', 'cacheable', 'searchable', 'deleted'], 'integer'],
            [['price', 'discount_price', 'discount'], 'number'],
            [['upc', 'mpn', 'template', 'layout', 'discount_type'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10],
            [['searchable', 'cacheable'], 'default', 'value' => 1],
            [['status', 'sort', 'deleted', 'shop_id'], 'default', 'value' => 0],
            [['template', 'layout', 'discount_type'], 'default', 'value' => ''],
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
            'shop_id' => 'Shop',
            'category_id' => 'Category',
            'brand_id' => 'Brand',
            'upc' => 'UPC',
            'mpn' => 'MPN',
            'price' => 'Price',
            'discount' => 'Discount',
            'discount_price' => 'Discount price',
            'discount_type' => 'Discount type',
            'currency' => 'Currency',
            'quantity' => 'Quantity',
            'quantity_min' => 'Quantity min',
            'sort' => 'Sort',
            'template' => 'Template',
            'layout' => 'Layout',
            'status' => 'Status',
            'cacheable' => 'Cacheable',
            'searchable' => 'Searchable',
            'deleted' => 'Deleted',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Get products info
     *
     * @return void
     */
    public function getInfo()
    {
        return $this->hasOne(ProductsInfo::className(), ['product_id' => 'id']);
    }
}
