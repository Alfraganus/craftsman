<?php

namespace common\models;

/**
 * This is the model class for table "products_info".
 *
 * @property int $info_id
 * @property int $product_id
 * @property string $language
 * @property string $name
 * @property string $short_title
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property string $gallery
 * @property string|null $meta
 * @property string $type
 */
class ProductsInfo extends \yii\db\ActiveRecord
{
    public $meta_title;
    public $focus_keywords;
    public $meta_description;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'products_info';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['slug'], 'unique'],
            [['product_id'], 'integer'],
            [['language', 'name', 'image'], 'required'],
            [['description', 'gallery'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 200],
            [['short_title', 'slug', 'image', 'type'], 'string', 'max' => 255],
            [['image', 'gallery'], 'default', 'value' => ''],
            [['meta', 'meta_title', 'meta_description', 'focus_keywords'], 'default', 'value' => ''],
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
            'product_id' => 'Product ID',
            'language' => 'Language',
            'name' => 'Product name',
            'short_title' => 'Short Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'image' => 'Product image',
            'gallery' => 'Gallery',
            'meta' => 'Meta',
            'type' => 'Type',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'focus_keywords' => 'Focus keywords',
        ];
    }
}
