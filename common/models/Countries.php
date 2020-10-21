<?php

namespace common\models;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string $name
 * @property string $ISO
 * @property string $ISO3
 * @property int $num_code
 * @property int $phone_code
 *
 * @property Cities[] $cities
 * @property Regions[] $regions
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['ISO', 'ISO3', 'num_code', 'name', 'phone_code'], 'required'],
            [['num_code', 'phone_code'], 'integer'],
            [['ISO'], 'string', 'max' => 2],
            [['ISO3'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 64],
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
            'ISO' => 'ISO',
            'ISO3' => 'ISO3',
            'num_code' => 'Numeric Code',
            'phone_code' => 'Phone code',
        ];
    }

    /**
     * Get cities
     *
     * @return void
     */
    public function getCities()
    {
        return $this->hasMany(Cities::className(), ['country_id' => 'id']);
    }

    /**
     * Get regions
     *
     * @return void
     */
    public function getRegions()
    {
        return $this->hasMany(Regions::className(), ['country_id' => 'id']);
    }

    /**
     * Get country
     *
     * @param [type] $where
     * @param string $field
     * @return object
     */
    public static function getOne($where, $field = '')
    {
        $ouput = '';

        $row = self::findOne($where);

        if ($row) {
            $ouput = $row;

            if ($field) {
                $ouput = $row->$field;
            }
        }

        return $ouput;
    }
}
