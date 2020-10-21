<?php

namespace common\models;

/**
 * This is the model class for table "menu_items".
 *
 * @property int $id
 * @property string $language
 * @property string $data
 * @property string $item_id
 * @property string $type
 * @property string $icon
 * @property int $parent_id
 * @property string $group_key
 * @property int $sort
 */
class MenuItems extends \yii\db\ActiveRecord
{
    public $name;
    public $attrs;
    public $class_name;
    public $link;
    public $link_target;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['group_key'], 'required'],
            [['link', 'link_target', 'attrs', 'class_name', 'icon', 'language'], 'string'],
            [['parent_id', 'sort', 'item_id'], 'integer'],
            [['name', 'group_key'], 'string', 'max' => 255],
            [['parent_id', 'item_id'], 'default', 'value' => 0],
            [['data', 'type', 'icon'], 'default', 'value' => ''],
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
            'language' => 'Language',
            'data' => 'Data',
            'item_id' => 'Item ID',
            'type' => 'Menu Type',
            'icon' => 'Icon',
            'parent_id' => 'Parent ID',
            'group_key' => 'Group Key',
            'sort' => 'Sort',
            'name' => 'Name',
            'attrs' => 'Attributes',
            'class_name' => 'Class Name',
            'link' => 'Link',
            'link_target' => 'Link Target',
        ];
    }
}
