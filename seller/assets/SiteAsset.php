<?php

namespace seller\assets;

use yii\web\AssetBundle;

/**
 * Main seller application asset bundle.
 */
class SiteAsset extends AssetBundle
{
    public $sourcePath = '@seller/assets/';

    public $css = [
        'https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext',
        'main/css/bootstrap.css',
        'main/css/fontawesome-all.css',
        'main/css/swiper.css',
        'main/css/magnific-popup.css',
    ];

    public $js = [
        'main/js/popper.min.js',
        'main/js/bootstrap.min.js',
        'main/js/jquery.easing.min.js',
        'main/js/swiper.min.js',
        'main/js/jquery.magnific-popup.js',
        'main/js/validator.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js[] = 'main/js/scripts.js';
        $this->css[] = 'main/css/styles.css';
        $this->css[] = 'main/css/responsive.css';
    }
}
