<?php
namespace backend\controllers\fields;

use base\BackendController;

/**
 * Custom Fields controller
 */
class CustomFieldsController extends BackendController
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
