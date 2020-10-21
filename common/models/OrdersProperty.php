<?php

namespace common\models;

/**
 * This is the model class for table "orders_property".
 *
 * @property int $id
 * @property string|null $order_id
 * @property int|null $shop_id
 * @property string|null $products
 * @property int|null $products_count
 * @property float|null $total_price
 * @property int|null $cargo_id
 * @property string|null $cargo_track_no
 * @property string|null $note
 * @property int|null $status
 * @property int|null $deleted
 */
class OrdersProperty extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'orders_property';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['shop_id', 'products_count', 'cargo_id', 'status', 'deleted'], 'integer'],
            [['products'], 'string'],
            [['total_price'], 'number'],
            [['order_id', 'cargo_track_no', 'note'], 'string', 'max' => 255],
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
            'order_id' => 'Order ID',
            'shop_id' => 'Shop ID',
            'products' => 'Products',
            'products_count' => 'Products Count',
            'total_price' => 'Total Price',
            'cargo_id' => 'Cargo ID',
            'cargo_track_no' => 'Cargo Track No',
            'note' => 'Note',
            'status' => 'Status',
            'deleted' => 'Deleted',
        ];
    }
}
