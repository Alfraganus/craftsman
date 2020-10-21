<?php
namespace backend\controllers\products;

use backend\models\Product;
use base\BackendController;
use common\models\ProductsInfo;
use Yii;
use yii\helpers\Url;

/**
 * Products controller
 */
class ActionController extends BackendController
{
    public $url = '/products/all';
    public $actions_url = '/products/action';
    public $vendors_url = '/vendors';

    /**
     * Displays create page
     *
     * @return string
     */
    public function actionCreate()
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $post_item = Yii::$app->request->post();
        $model = new Product();
        $info = new ProductsInfo();

        if ($post_item) {
            $submit_button = input_post('submit_button');

            $flash_type = 'success-error';
            $flash_message = 'An error occurred while processing your request. Please try agian.';

            if ($model->load($post_item) && $info->load($post_item)) {
                $id = Product::createItem($model, $info, $post_item);

                $flash_type = 'success-alert';
                $flash_message = 'The product was created successfully!';

                Yii::$app->session->setFlash($flash_type, $flash_message);

                if ($submit_button == 'create_and_add_new') {
                    return $this->refresh();
                } else {
                    return $this->redirect(['edit', 'id' => $id]);
                }
            }

            Yii::$app->session->setFlash($flash_type, $flash_message);
            return $this->refresh();
        }

        $this->registerJs(array(
            'dist/libs/sortablejs/sortable.min.js',
            'dist/libs/sortablejs/jquery-sortable.min.js',
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/gallery.js',
            'theme/components/product.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('create', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'model' => $model,
            'info' => $info,
        ));
    }

    /**
     * Displays edit page
     *
     * @return string
     */
    public function actionEdit($id)
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $post_item = Yii::$app->request->post();

        if (is_numeric($id) && $id > 0) {
            $item = Product::getItemToEdit($id);
        } else {
            $item = array();
        }

        $model = array_value($item, 'model');
        $info = array_value($item, 'info');
        $translations = array_value($item, 'translations');

        if (!$model || !$info) {
            return $this->render('error', array(
                'main_url' => $main_url,
            ));
        }

        if ($post_item) {
            $model->cacheable = 0;
            $model->searchable = 0;
            $submit_button = input_post('submit_button');

            $flash_type = 'success-error';
            $flash_message = 'An error occurred while processing your request. Please try agian.';

            if ($model->load($post_item) && $info->load($post_item)) {
                $action = Product::updateItem($model, $info, $post_item);

                if (is_string($action) && $action) {
                    $flash_type = 'error-alert';
                    $flash_message = $action;
                } else {
                    $flash_type = 'success-alert';
                    $flash_message = 'The product has been successfully updated!';
                }
            }

            Yii::$app->session->setFlash($flash_type, $flash_message);

            if ($submit_button == 'create_and_add_new') {
                return $this->redirect(['create']);
            } else {
                return $this->refresh();
            }
        }

        $this->registerJs(array(
            'dist/libs/sortablejs/sortable.min.js',
            'dist/libs/sortablejs/jquery-sortable.min.js',
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/gallery.js',
            'theme/components/product.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('update', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'model' => $model,
            'info' => $info,
            'translations' => $translations,
        ));
    }
}
