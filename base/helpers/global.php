<?php
// Code debug
function debug($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// Get array value
function array_value($array = false, $key = false, $default = false)
{
    if (is_array($array) && isset($array[$key])) {
        return $array[$key];
    }

    return $default;
}

// Check cli mode
function is_cli()
{
    if (php_sapi_name() == "cli") {
        return true;
    }

    return false;
}

// Check url
function is_url($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return false;
    }

    return true;
}

// Check email address
function is_email($string)
{
    if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    return false;
}

// Translation text
function __($message, $params = array())
{
    return Yii::t('app', $message, $params, Yii::$app->language);
}

// Set log
function set_log($type, $args)
{
    if ($type == 'admin') {
        \common\models\Logs::setAdminLog($args);
    }
}

// Set trash
function set_trash($args)
{
    if (is_array($args) && $args) {
        \common\models\Trashbox::setItem($args);
    }
}

// Select array with empty label
function select_array_with_empty_label($array, $label = '-', $key = '')
{
    $default = array($key => $label);

    if (is_array($array) && $array) {
        return array_merge($default, $array);
    }

    return $default;
}

// Init content settings
function init_content_settings($model)
{
    $output = $model;

    if ($model) {
        $settings = json_decode($model->settings, true);

        if ($settings) {
            foreach ($settings as $key => $value) {
                $output->$key = $value;
            }
        }
    }

    return $output;
}

// Init content meta
function init_content_meta($info)
{
    $output = $info;

    if ($info) {
        $settings = json_decode($info->meta, true);

        if ($settings) {
            foreach ($settings as $key => $value) {
                $output->$key = $value;
            }
        }
    }

    return $output;
}

// Get product image
function get_product_image($info)
{
    $output = images_url('default-image.png');

    if ($info && $info->image) {
        $output = $info->image;
    }

    return $output;
}

// Count segment childs
function count_segment_childs($model, $field_key)
{
    $count = \common\models\SegmentFields::find()
        ->where(['segment_id' => $model->id, 'field_key' => $field_key])
        ->one();

    if ($count && is_numeric($count->field_value)) {
        return $count->field_value;
    }

    return '0';
}
