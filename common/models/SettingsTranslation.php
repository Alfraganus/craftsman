<?php

namespace common\models;

/**
 * This is the model class for table "settings_translation".
 *
 * @property int $id
 * @property string|null $language
 * @property string|null $settings_key
 * @property string|null $settings_value
 * @property string|null $updated_on
 */
class SettingsTranslation extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'settings_translation';
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
            [['language', 'settings_value', 'settings_key'], 'string'],
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
            'settings_key' => 'Settings Key',
            'settings_value' => 'Settings Value',
            'updated_on' => 'Updated On',
        ];
    }
}
