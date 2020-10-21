<?php
namespace backend\controllers\appearance;

use base\BackendController;

/**
 * Themes controller
 */
class ThemesController extends BackendController
{
    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
