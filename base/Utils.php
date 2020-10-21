<?php
namespace base;

use common\models\Languages;

class Utils
{
    /**
     * Locale list
     *
     * @return array
     */
    public static function getLocaleList()
    {
        $output = array();

        $results = Languages::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        if ($results) {
            foreach ($results as $item) {
                $output[$item->locale] = $item->name;
            }
        }

        return $output;
    }

    /**
     * Timezone list
     *
     * @return array
     */
    public static function getTimezoneList()
    {
        $output = array();

        $results = timezone_identifiers_list();

        if ($results) {
            foreach ($results as $item) {
                $output[$item] = $item;
            }
        }

        return $output;
    }
}
