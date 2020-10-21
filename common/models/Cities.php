<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $country_id
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $sort
 *
 * @property Countries $country
 * @property Regions[] $regions
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['country_id', 'status', 'sort'], 'integer'],
            [['status', 'name'], 'required'],
            [['created_by', 'updated_by'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 150],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'Id']],
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
            'name' => 'Name',
            'slug' => 'Slug',
            'country_id' => 'Country ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'sort' => 'Sort',
        ];
    }

    /**
     * Get country
     *
     * @return void
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['Id' => 'country_id']);
    }

    /**
     * Get regions
     *
     * @return void
     */
    public function getRegions()
    {
        return $this->hasMany(Regions::className(), ['city_id' => 'id']);
    }
}
