<?php

namespace common\models;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $order_id
 * @property int|null $customer_id
 * @property string|null $address_info
 * @property string|null $payment_info
 * @property string|null $sale_contract
 * @property int|null $status
 * @property string|null $created_on
 * @property int $created_by
 * @property string|null $updated_on
 * @property int $updated_by
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['customer_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['address_info', 'payment_info', 'sale_contract'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['order_id'], 'string', 'max' => 150],
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
            'customer_id' => 'Customer ID',
            'address_info' => 'Address Info',
            'payment_info' => 'Payment Info',
            'sale_contract' => 'Sale Contract',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
