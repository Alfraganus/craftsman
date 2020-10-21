<?php

namespace common\models;

/**
 * This is the model class for table "site_content_field".
 *
 * @property int $field_id
 * @property int|null $content_id
 * @property string $field_key
 * @property string|null $field_value
 */
class ContentFields extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'site_content_field';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['content_id'], 'integer'],
            [['field_key'], 'required'],
            [['field_value'], 'string'],
            [['field_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * Attribute lables
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'content_id' => 'Content ID',
            'field_key' => 'Field Key',
            'field_value' => 'Field Value',
        ];
    }
}
