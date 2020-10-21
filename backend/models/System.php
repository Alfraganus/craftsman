<?php

namespace backend\models;

use common\models\CurrencyList;
use common\models\Settings;
use common\models\SettingsTranslation;

class System
{
    /**
     * Get settings
     *
     * @param string $group
     * @param array $args
     * @return object
     */
    public static function getSettings($group = '', $args = array())
    {
        $where = array_value($args, 'where');
        $orderBy = array_value($args, 'order_by', ['settings.sort' => SORT_ASC]);
        $language = array_value($args, 'language', '');
        $lang_key = clean_str($language);

        $query = Settings::find()
            ->select(['settings.*', 'translation.settings_value as translation'])
            ->join(
                'LEFT JOIN',
                'settings_translation translation',
                'translation.settings_key = settings.settings_key AND translation.language = "' . $lang_key . '"'
            );

        if (is_string($group) && !empty($group)) {
            $query->where(['settings.settings_group' => $group]);
        }

        if (is_array($where) && $where) {
            $query->andWhere($where);
        }

        if (is_array($orderBy) && $orderBy) {
            $query->orderBy($orderBy);
        }

        return $query;
    }

    /**
     * Update settings item
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function updateSetting($key, $value)
    {
        $output['updated'] = false;
        $output['new_value'] = false;
        $output['old_value'] = false;

        $model = Settings::find()->where(['settings_key' => $key])->one();

        if ($model && $model->settings_value != $value) {
            $output['updated'] = true;
            $output['new_value'] = $value;
            $output['old_value'] = $model->settings_value;

            $model->settings_value = $value;
            $model->updated_on = date('Y-m-d H:i:s');
            $model->save();
        }

        return $output;
    }

    /**
     * Update settings translation
     *
     * @param string $key
     * @param string $language
     * @param mixed $value
     * @return void
     */
    public static function updateSettingsTranslation($key, $language, $value)
    {
        $output['updated'] = false;
        $output['new_value'] = false;
        $output['old_value'] = false;

        $update = true;
        $setting = Settings::find()->where(['settings_key' => $key])->one();
        $model = SettingsTranslation::find()->where(['settings_key' => $key, 'language' => $language])->one();

        if (!$model && $setting && $setting->settings_value == $value) {
            $update = false;
        }

        if ($update) {
            $model = SettingsTranslation::find()->where(['settings_key' => $key, 'language' => $language])->one();
            $output['updated'] = true;
            $output['new_value'] = $value;

            if ($model) {
                $output['old_value'] = $model->settings_value;

                $model->settings_value = $value;
                $model->updated_on = date('Y-m-d H:i:s');
                $model->save();
            } else {
                $output['old_value'] = '';

                $model = new SettingsTranslation();
                $model->language = $language;
                $model->settings_key = $key;
                $model->settings_value = $value;
                $model->updated_on = date('Y-m-d H:i:s');
                $model->save();
            }
        }

        return $output;
    }

    /**
     * Update currency status
     *
     * @param [type] $id
     * @param integer $status
     * @return boolean
     */
    public function updateCurrencyStatus($id, $status = 0)
    {
        $item = CurrencyList::findOne(['id' => $id]);

        if ($item && is_numeric($status)) {
            $item->status = $status;
            $item->update(false);

            return true;
        }

        return false;
    }
}
