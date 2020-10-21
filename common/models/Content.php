<?php

namespace common\models;

/**
 * This is the model class for table "site_content".
 *
 * @property int $id
 * @property string $type
 * @property int|null $parent_id
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
class Content extends \yii\db\ActiveRecord
{
    public $posts_column;
    public $posts_sorting;
    public $products_sorting;
    public $posts_per_page;
    public $products_per_page;
    public $products_view_type;
    public $subcategories_view_type;

    public static $selected_language = 'en';

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'site_content';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['created_on', 'updated_by'], 'safe'],
            [['sort', 'type'], 'required'],
            [['parent_id', 'sort', 'status', 'deleted', 'searchable', 'cacheable', 'created_by', 'updated_by'], 'integer'],
            [['settings', 'template', 'layout', 'posts_column', 'posts_sorting', 'posts_per_page', 'subcategories_view_type', 'products_view_type', 'products_sorting', 'products_per_page'], 'string'],
            [['searchable', 'cacheable'], 'default', 'value' => 1],
            [['parent_id', 'status', 'sort', 'deleted'], 'default', 'value' => 0],
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
            'type' => 'Type',
            'settings' => 'Settings',
            'parent_id' => 'Parent',
            'sort' => 'Sort',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'cacheable' => 'Cacheable',
            'searchable' => 'Searchable',
            'created_on' => 'Created on',
            'created_by' => 'Created by',
            'updated_on' => 'Updated on',
            'updated_by' => 'Updated by',
            'template' => 'Template',
            'layout' => 'Layout',
            'posts_column' => 'Posts column',
            'posts_sorting' => 'Posts sorting',
            'posts_per_page' => 'Posts per page',
            'subcategories_view_type' => 'Subcategories view type',
            'products_view_type' => 'Products view type',
            'products_sorting' => 'Products sorting',
            'products_per_page' => 'Products per page',
        ];
    }

    /**
     * Get content info
     *
     * @return void
     */
    public function getInfo()
    {
        return $this->hasOne(ContentInfos::className(), ['content_id' => 'id']);
    }

    /**
     * Get parent
     *
     * @return void
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * Get parent
     *
     * @return void
     */
    public function getParentInfo()
    {
        return $this->hasOne(ContentInfos::className(), ['content_id' => 'id'])
            ->via('parent');
    }
}
