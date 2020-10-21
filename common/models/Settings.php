<?php

namespace common\models;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $settings_key
 * @property string|null $settings_value
 * @property string|null $settings_group
 * @property string|null $settings_type
 * @property int|null $status
 * @property int|null $sort
 * @property int $required
 * @property string|null $updated_on
 */
class Settings extends \yii\db\ActiveRecord
{
    public $translation;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['updated_on'], 'safe'],
            [['title', 'settings_key', 'settings_group', 'settings_type', 'settings_value'], 'string'],
            [['status', 'sort', 'required'], 'integer'],
            [['status', 'sort', 'required'], 'default', 'value' => 0],
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
            'settings_key' => 'Settings Key',
            'settings_value' => 'Settings Value',
            'settings_group' => 'Settings Group',
            'settings_type' => 'Settings Type',
            'translation' => 'Translation',
            'status' => 'Status',
            'sort' => 'Sort',
            'required' => 'Required',
            'updated_on' => 'Updated On',
        ];
    }
}
