<?php
namespace backend\models;

use common\models\CurrencyList;
use common\models\CurrencyRates;

class Currency
{
    /**
     * Update currency status
     *
     * @param [type] $id
     * @param integer $status
     * @return boolean
     */
    public static function setItemStatus($id, $status = 0)
    {
        $item = CurrencyList::findOne(['id' => $id]);

        if ($item && is_numeric($status)) {
            $item->status = $status;
            $item->update(false);

            return true;
        }

        return false;
    }

    /**
     * Price format
     *
     * @param [type] $number
     * @return int
     */
    public static function priceFormat($number)
    {
        $sum = number_format(round($number, 4), 4);
        $exp = explode('.', $sum);

        if (isset($exp[1])) {
            $zero = explode('0', $exp[1]);

            if (count($zero) > 2) {
                $sum = number_format(round($number, 2), 2);
            }
        }

        $output = $sum > 0 ? $sum : number_format(round($number, 6), 6);

        return $output > 0 ? $output : '0.00';
    }

    /**
     * Rate comparsion
     *
     * @param [type] $currentValue
     * @param [type] $oldValue
     * @return int
     */
    public static function rateComparison($currentValue, $oldValue)
    {
        if ($currentValue > 0 and $oldValue > 0) {
            $percentage = $currentValue / $oldValue * 100 - 100;
            $percentage = floatval($percentage);
        } else {
            $percentage = 0;
        }

        return $percentage;
    }

    /**
     * Get rates
     *
     * @return object
     */
    public static function getRates()
    {
        $query = CurrencyRates::find()->all();
        return $query;
    }
}
