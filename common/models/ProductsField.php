<?php

namespace common\models;

/**
 * This is the model class for table "products_field".
 *
 * @property int $field_id
 * @property int|null $product_id
 * @property string $field_key
 * @property string|null $field_value
 */
class ProductsField extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'products_field';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['field_key'], 'required'],
            [['field_value'], 'string'],
            [['field_key'], 'string', 'max' => 255],
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
            'field_id' => 'Field ID',
            'product_id' => 'Product ID',
            'field_key' => 'Field Key',
            'field_value' => 'Field Value',
        ];
    }
}
