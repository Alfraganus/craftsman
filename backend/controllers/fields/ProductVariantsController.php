<?php

namespace backend\controllers\fields;

use base\BackendController;

/**
 * Product Variants Controller
 */
class ProductVariantsController extends BackendController
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
