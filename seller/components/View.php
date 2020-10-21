<?php
namespace seller\components;

class View extends \yii\web\View
{
    public $breadcrumbs = array();
    public $page_title = '';
    public $breadcrumb_title = '';

    public function getAssetsUrl($name = '')
    {
        return $this->getAssetManager()->getBundle('seller\assets\AppAsset')->baseUrl . '/main/' . $name;
    }
}
