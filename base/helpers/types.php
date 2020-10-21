<?php
// Form notify
function form_notify($type = 'error', $array = array())
{
    $output = [
        'error' => true,
        'success' => false,
        'message' => 'An error was encountered. Please try again.',
    ];

    if ($type == 'success') {
        $output = [
            'error' => false,
            'success' => true,
            'message' => '',
        ];
    }

    if (isset($array['message'])) {
        $output['message'] = $array['message'];
    }

    return $output;
}

// Gender
function gender($key = null)
{
    $array = array(
        '0' => '-',
        '1' => 'Male',
        '2' => 'Female',
    );

    if (is_numeric($key)) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Order statuses
function order_statuses($key = false)
{
    $array = array(
        '0' => 'New order',
        '1' => 'Processing',
        '2' => 'Shipped',
        '10' => 'Completed',
        '20' => 'Cancelled',
    );

    if (is_numeric($key)) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Category sorting
function category_sorting($key = false)
{
    $array = array(
        'best_match' => 'Best match',
        'best_sellers' => 'Best sellers',
        'price_az' => 'The cheapest',
        'price_za' => 'Most expensive',
        'latest' => 'Latest',
        'oldets' => 'The oldest',
        'az' => 'A-Z',
        'za' => 'Z-A',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Subcategory view types
function subcategory_view_types($key = false)
{
    $array = array(
        'hidden' => 'Hidden',
        '1-col' => '1 column',
        '2-col' => '2 columns',
        '3-col' => '3 columns',
        '4-col' => '4 columns',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Category products view types
function category_products_view_types($key = false)
{
    $array = array(
        'list' => 'List',
        '3-col' => '3 columns',
        '4-col' => '4 columns',
        '5-col' => '5 columns',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Posts column types
function posts_column_types($key = false)
{
    $array = array(
        '1-col' => '1 column',
        '2-col' => '2 columns',
        '3-col' => '3 columns',
        '4-col' => '4 columns',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Posts sorting
function posts_sorting($key = false)
{
    $array = array(
        'latest' => 'Latest',
        'oldets' => 'The oldest',
        'az' => 'A-Z',
        'za' => 'Z-A',
        'comments' => 'Most commented',
        'reading' => 'Most read',
        'views' => 'Most viewed',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Dimensions types
function dimensions_types($key = false)
{
    $array = array(
        'centimeter' => 'Centimeter',
        'Inch' => 'Inch',
        'milimeter' => 'Milimeter',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}

// Weight types
function weight_types($key = false)
{
    $array = array(
        'gram' => 'Gram',
        'kilogram' => 'Kilogram',
        'ounce' => 'Ounce',
        'pound' => 'Pound',
    );

    if ($key) {
        return isset($array[$key]) ? $array[$key] : '';
    }

    return $array;
}
