<?php

namespace common\models;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int|null $sort
 * @property int $status
 * @property string|null $created_on
 * @property int|null $created_by
 * @property string|null $updated_on
 * @property int|null $updated_by
 *
 * @property Cities $city
 * @property Countries $country
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['country_id', 'city_id', 'sort', 'status'], 'integer'],
            [['status', 'name', 'country_id'], 'required'],
            [['created_by', 'updated_by'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 150],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'city_id' => 'City ID',
            'sort' => 'Sort',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Get city
     *
     * @return void
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * get Country
     *
     * @return void
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['Id' => 'country_id']);
    }
}
