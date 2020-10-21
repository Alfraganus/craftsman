<?php
namespace backend\controllers;

use backend\models\Shop;
use base\BackendController;
use common\models\Profile;
use common\models\ShopInfos;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Shops controller
 */
class ShopsController extends BackendController
{
    public $url = '/shops';
    public $vendors_url = '/vendors';

    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('activate', 'block', 'trash');

        $where_query = ['shops.deleted' => 0];
        $query = Shop::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Shop::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $shops = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Shop::getPageTypes('');

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'shops' => $shops,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays active page
     *
     * @return string
     */
    public function actionActive()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('block', 'trash');

        $where_query = ['shops.deleted' => 0, 'shops.status' => 1];
        $query = Shop::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Shop::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $shops = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Shop::getPageTypes('active');

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'shops' => $shops,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays pending page
     *
     * @return string
     */
    public function actionPending()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('activate', 'block', 'trash');

        $where_query = ['shops.deleted' => 0, 'shops.status' => 0];
        $query = Shop::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Shop::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $shops = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Shop::getPageTypes('pending');

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'shops' => $shops,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays blocked page
     *
     * @return string
     */
    public function actionBlocked()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('activate', 'trash');

        $where_query = ['shops.deleted' => 0, 'shops.status' => -1];
        $query = Shop::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Shop::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $shops = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Shop::getPageTypes('blocked');

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'shops' => $shops,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays deleted page
     *
     * @return string
     */
    public function actionDeleted()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('activate', 'block', 'restore', 'delete');

        $where_query = ['shops.deleted' => 1];
        $query = Shop::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Shop::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $shops = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Shop::getPageTypes('deleted');

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'shops' => $shops,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays create page
     *
     * @return string
     */
    public function actionCreate()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $model = new Shop();
        $shop_info = new ShopInfos();
        $post_item = Yii::$app->request->post();

        if ($post_item) {
            $submit_button = input_post('submit_button');

            if ($submit_button == 'create_and_add_new' && $model->load($post_item) && $shop_info->load($post_item)) {
                Shop::createShop($model, $shop_info, $post_item);

                Yii::$app->session->setFlash('success-alert', "The shop was created successfully!");
                return $this->redirect(['create']);
            } elseif ($model->load($post_item) && $shop_info->load($post_item)) {
                $shop_id = Shop::createShop($model, $shop_info, $post_item);

                Yii::$app->session->setFlash('success-alert', "The shop was created successfully!");
                return $this->redirect(['edit', 'id' => $shop_id]);
            }
        }

        $this->registerJs(array(
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('create', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'model' => $model,
            'shop_info' => $shop_info,
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
        $vendors_url = Url::to([$this->vendors_url]);

        $model = Shop::findOne($id);
        $shop_info = ShopInfos::find()->where(['shop_id' => $id])->one();
        $post_item = Yii::$app->request->post();

        if (!$model || !$shop_info) {
            return $this->render('error', array(
                'main_url' => $main_url,
            ));
        }

        $this->registerJs(array(
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        if ($post_item) {
            $submit_button = input_post('submit_button');

            if ($submit_button == 'create_and_add_new' && $model->load($post_item) && $shop_info->load($post_item)) {
                Shop::updateShop($model, $shop_info, $post_item);

                Yii::$app->session->setFlash('success-alert', "The shop was updated successfully!");
                return $this->redirect(['create']);
            } elseif ($model->load($post_item) && $shop_info->load($post_item)) {
                Shop::updateShop($model, $shop_info, $post_item);

                Yii::$app->session->setFlash('success-alert', "The shop was updated successfully!");
                return $this->refresh();
            }
        }

        $this->registerJs(array(
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('update', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'model' => $model,
            'shop_info' => $shop_info,
        ));
    }

    /**
     * Displays edit page
     *
     * @return string
     */
    public function actionInfo($id)
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $tabs = array(
            ['link' => 'informations', 'name' => 'Informations', 'icon' => 'ri-information-line'],
            ['link' => 'products', 'name' => 'Products', 'icon' => 'ri-product-hunt-line'],
            ['link' => 'orders', 'name' => 'Orders', 'icon' => 'ri-shopping-cart-line'],
            ['link' => 'vendors', 'name' => 'Vendors', 'icon' => 'ri-shopping-cart-line'],
        );

        $shop = Shop::getShop(['shops.id' => $id]);

        return $this->render('info', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'tabs' => $tabs,
            'shop' => $shop,
        ));
    }

    /**
     * Json actions
     *
     * @return void
     */
    public function actionJson()
    {
        $output['error'] = true;
        $output['success'] = false;
        $type = input_get('type');

        if ($type == 'search') {
            $keyword = input_get('keyword');
            $vendors = Shop::searchVendors($keyword);

            if ($vendors) {
                $vendors_array = array();

                foreach ($vendors as $vendor) {
                    $item = (array) $vendor->profile->fields();
                    $item['user_id'] = $vendor->id;
                    $item['fullname'] = Profile::getFullname($vendor->profile);
                    $item['email'] = $vendor->email;
                    $item['username'] = $vendor->username;
                    $item['status'] = $vendor->status;
                    $item['created_at'] = date('Y-m-d H:i:s', $vendor->created_at);
                    $item['created_at_st'] = $vendor->created_at;
                    unset($item['id']);

                    $vendors_array[] = $item;
                }

                if ($vendors_array) {
                    $output['error'] = false;
                    $output['success'] = true;
                    $output['vendors'] = $vendors_array;
                }
            }
        }

        return $this->asJson($output);
    }
}
