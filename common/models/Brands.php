<?php

namespace common\models;

/**
 * This is the model class for table "brands".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property string $image
 * @property string $cover_image
 * @property string|null $meta
 * @property string|null $settings
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
class Brands extends \yii\db\ActiveRecord
{
    public $meta_title;
    public $meta_description;
    public $focus_keywords;
    public $products_sorting;
    public $products_per_page;
    public $products_view_type;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['sort', 'status', 'deleted', 'searchable', 'cacheable', 'created_by', 'updated_by'], 'integer'],
            [['description', 'icon', 'image', 'cover_image', 'slug', 'template', 'layout'], 'string'],
            [['settings', 'products_sorting', 'products_per_page', 'products_view_type'], 'string'],
            [['searchable', 'cacheable'], 'default', 'value' => 1],
            [['status', 'sort', 'deleted'], 'default', 'value' => 0],
            [['meta', 'meta_title', 'meta_description', 'focus_keywords'], 'default', 'value' => ''],
            [['settings', 'products_sorting', 'products_per_page', 'products_view_type'], 'default', 'value' => ''],
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
            'description' => 'Description',
            'icon' => 'Icon',
            'image' => 'Image',
            'cover_image' => 'Cover Image',
            'meta' => 'Meta',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'focus_keywords' => 'Focus keywords',
            'settings' => 'Settings',
            'template' => 'Template',
            'layout' => 'Layout',
            'sort' => 'Sort',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'cacheable' => 'Cacheable',
            'searchable' => 'Searchable',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'products_sorting' => 'Products sorting',
            'products_per_page' => 'Products per page',
            'products_view_type' => 'Products view type',
        ];
    }
}
