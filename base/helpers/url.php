<?php
// Assets URL
function assets_url($url = false)
{
    $assets_url = Yii::$app->params['assets_url'];

    if ($url) {
        return $assets_url . $url;
    }

    return $assets_url;
}

// Admin URL
function admin_url($url = false)
{
    $admin_url = Yii::$app->params['admin_url'];

    if ($url) {
        return $admin_url . $url;
    }

    return $admin_url;
}

// Images URL
function images_url($url = false)
{
    $images_url = assets_url('images/');

    if ($url) {
        return $images_url . $url;
    }

    return $images_url;
}

// Seller URL
function seller_url($url = false)
{
    $seller_url = Yii::$app->params['seller_url'];

    if ($url) {
        return $seller_url . $url;
    }

    return $seller_url;
}

// Store URL
function store_url($url = false)
{
    $store_url = Yii::$app->params['store_url'];

    if ($url) {
        return $store_url . $url;
    }

    return $store_url;
}

// Uploads URL
function uploads_url($url = false)
{
    $uploads_url = assets_url('uploads/');

    if ($url) {
        return $uploads_url . $url;
    }

    return $uploads_url;
}

// Get previous url
function get_previous_url($default = false)
{
    $request = Yii::$app->request;

    if ($request->referrer) {
        return $request->referrer;
    } elseif ($default) {
        return $default;
    }

    return admin_url();
}

// Set query params to url
function set_query_var($var, $value, $url = null)
{
    if ($var && $value) {
        $params = array($var => $value);

        if ($url) {
            $currentParams = \Yii::$app->getRequest()->getQueryParams();
            $currentParams[0] = '/' . trim($url, '/');
            $route = array_replace_recursive($currentParams, $params);
            $output = yii\helpers\Url::toRoute($route);
        } else {
            $output = yii\helpers\Url::current($params, true);
        }

        return $output;
    }
}
