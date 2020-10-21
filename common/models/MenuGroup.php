<?php

namespace common\models;

/**
 * This is the model class for table "menu_group".
 *
 * @property int $id
 * @property string $group_key
 * @property string $name
 * @property string $description
 * @property int $sort
 * @property int|null $status
 * @property int $deleted
 * @property string|null $created_on
 * @property int $created_by
 * @property string|null $updated_on
 * @property int $updated_by
 */
class MenuGroup extends \yii\db\ActiveRecord
{
    public $title;
    public $language;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'menu_group';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['created_on', 'updated_on'], 'safe'],
            [['title'], 'required'],
            [['description', 'name', 'language', 'title'], 'string'],
            [['sort', 'status', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['name', 'group_key'], 'string', 'max' => 255],
            [['sort', 'status'], 'default', 'value' => 0],
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
            'name' => 'Name',
            'group_key' => 'Group Key',
            'description' => 'Description',
            'sort' => 'Sort',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'language' => 'Language',
        ];
    }
}
