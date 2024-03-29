<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $name
 * @property string $lang_code
 * @property string $locale
 * @property int $rtl
 * @property int $default
 * @property int $sort
 * @property int $status
 */
class Languages extends ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{languages}}';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'lang_code'], 'required'],
            [['rtl', 'status', 'sort', 'default'], 'integer'],
            [['name', 'lang_code', 'locale'], 'string'],
            [['rtl', 'status', 'sort'], 'default', 'value' => 0],
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
            'lang_code' => 'Code',
            'locale' => 'Locale',
            'rtl' => 'RTL',
            'default' => 'Default',
            'sort' => 'Sort',
            'status' => 'Status',
        ];
    }

    /**
     * Get all
     *
     * @param array $where
     * @param string $order_by
     * @return array
     */
    public function getAll($where = array(), $order_by = 'name')
    {
        $query = Languages::find();
        $query->asArray();
        $query->orderBy($order_by);

        if (is_array($where) && $where) {
            $query->where($where);
        }

        $results = $query->all();

        if ($results) {
            foreach ($results as $key => $result) {
                $results[$key]['flag'] = images_url('flags/svg/' . $result['lang_code'] . '.svg');
            }
        }

        return $results;
    }

    /**
     * Get one
     *
     * @param array $where
     * @return array
     */
    public function getOne($where = array())
    {
        $query = Languages::find();
        $query->asArray();

        if (is_array($where) && $where) {
            $query->where($where);
        }

        $result = $query->one();

        if ($result) {
            $result['flag'] = images_url('flags/svg/' . $result['lang_code'] . '.svg');
        }

        return $result;
    }
}
