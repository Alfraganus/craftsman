<?php
namespace base;

use yii\web\Controller;

/**
 * Frontend controller
 */
class FrontendController extends Controller
{
    /**
     * Register JS file or files
     *
     * @param [type] $file
     * @return void
     */
    public function registerJs($file)
    {
        if ($file) {
            $bundle = \frontend\assets\AppAsset::register(\Yii::$app->view);

            if (is_array($file)) {
                foreach ($file as $fi) {
                    $bundle->js[] = $fi;
                }
            } else {
                $bundle->js[] = $file;
            }
        }
    }

    /**
     * Register CSS file or files
     *
     * @param [type] $file
     * @return void
     */
    public function registerCss($file)
    {
        if ($file) {
            $bundle = \frontend\assets\AppAsset::register(\Yii::$app->view);

            if (is_array($file)) {
                foreach ($file as $fi) {
                    $bundle->css[] = $fi;
                }
            } else {
                $bundle->css[] = $file;
            }
        }
    }
}
