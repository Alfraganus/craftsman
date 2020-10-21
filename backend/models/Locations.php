<?php
namespace backend\models;

use common\models\Cities;
use common\models\Countries;
use common\models\Regions;

class Locations
{
    /**
     * Get country
     *
     * @param [type] $where
     * @param string $field
     * @return object
     */
    public static function getCountry($where, $field = '')
    {
        $ouput = '';

        $row = Countries::findOne($where);

        if ($row) {
            $ouput = $row;

            if ($field) {
                $ouput = $row->$field;
            }
        }

        return $ouput;
    }

    /**
     * Get all cities
     *
     * @return object
     */
    public static function getCitiesAll()
    {
        $sort = input_get('sort');
        $s = input_get('s');
        $country = input_get('country');
        $query = Cities::find();

        if (!empty($s)) {
            return $query->andFilterCompare('name', $s, 'like');
        }
        if (!empty($country)) {
            $query = Cities::find()->where(['country_id' => $country]);
        }

        $sort_query = ['id' => SORT_DESC];

        if ($sort == 'a-z') {
            $sort_query = ['name' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['name' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['id' => SORT_ASC];
        }

        return $query->orderBy($sort_query);
    }

    /**
     * Get all regions
     *
     * @return object
     */
    public static function getRegionAll()
    {
        $sort = input_get('sort');
        $s = input_get('s');
        $country = input_get('country');
        $city = input_get('city');
        $query = Regions::find();

        if (!empty($s)) {
            return $query->andFilterCompare('name', $s, 'like');
        }

        if (!empty($country)) {
            $query = Regions::find()->where(['country_id' => $country]);
        } elseif (!empty($city)) {
            $query = Regions::find()->where(['city_id' => $city]);
        }

        $sort_query = ['id' => SORT_DESC];

        if ($sort == 'a-z') {
            $sort_query = ['name' => SORT_ASC];
        } elseif ($sort == 'z-a') {
            $sort_query = ['name' => SORT_DESC];
        } elseif ($sort == 'oldest') {
            $sort_query = ['id' => SORT_ASC];
        }

        return $query->orderBy($sort_query);
    }
}
