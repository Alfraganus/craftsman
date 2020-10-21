<?php

namespace common\models;

/**
 * This is the model class for table "currency_list".
 *
 * @property int $id
 * @property string|null $currency_name
 * @property string|null $currency_code
 * @property int $sort
 * @property int $status
 */
class CurrencyList extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return void
     */
    public static function tableName()
    {
        return 'currency_list';
    }

    /**
     * Set rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            [['currency_name', 'currency_code'], 'string', 'max' => 50],
            [['sort', 'status'], 'integer'],
        ];
    }

    /**
     * Labels
     *
     * @return void
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_name' => 'Name',
            'currency_code' => 'Code',
            'status' => 'Status',
            'sort' => 'Sort',
        ];
    }
}
