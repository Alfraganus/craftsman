<?php

namespace common\models;

/**
 * This is the model class for table "products_category".
 *
 * @property int $pct_id
 * @property int|null $product_id
 * @property int|null $category_id
 */
class ProductsCategory extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'products_category';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'integer'],
            [['product_id', 'category_id'], 'required'],
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
            'pct_id' => 'Table ID',
            'product_id' => 'Product ID',
            'category_id' => 'Category ID',
        ];
    }
}
