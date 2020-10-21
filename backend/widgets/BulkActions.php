<?php
namespace backend\widgets;

use yii\base\Widget;

class BulkActions extends Widget
{
    public $show_clang = true;
    public $limit_default = 20;
    public $sort_default = 'newest';
    public $countries = false;
    public $cities = false;

    public $limit_array = array(
        20 => '20 items',
        40 => '40 items',
        80 => '80 items',
        100 => '100 items',
        200 => '200 items',
    );

    public $sort_array = array(
        'newest' => 'Newest',
        'oldest' => 'Oldest',
        'a-z' => 'A-Z',
        'z-a' => 'Z-A',
    );

    public $actions = array('publish', 'unpublish', 'trash', 'restore', 'delete');

    public function run()
    {
        $data = array(
            'show_clang' => $this->show_clang,
            'actions' => $this->actions,
            'sort_array' => $this->sort_array,
            'sort_default' => $this->sort_default,
            'limit_default' => $this->limit_default,
            'limit_array' => $this->limit_array,
            'countries' => $this->countries,
            'cities' => $this->cities,
        );

        return $this->render('bulk-actions', $data);
    }
}
