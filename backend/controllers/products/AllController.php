<?php

namespace backend\controllers\products;

use backend\models\Product;
use base\BackendController;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Products controller
 */
class AllController extends BackendController
{
    public $url = '/products/all';
    public $actions_url = '/products/action';
    public $vendors_url = '/vendors';

    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $limit_default = 20;
        $sort_default = 'newest';
        $bulk_actions = array('publish', 'unpublish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['products.deleted' => 0];

        $query = Product::getItems('', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Product::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Product::getPageTypes('');

        return $this->render('index', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'products' => $products,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays published page
     *
     * @return string
     */
    public function actionPublished()
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $limit_default = 20;
        $sort_default = 'newest';
        $bulk_actions = array('unpublish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['products.status' => 1, 'products.deleted' => 0];

        $query = Product::getItems('published', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Product::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Product::getPageTypes('published');

        return $this->render('index', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'products' => $products,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays main page
     *
     * @return string
     */
    public function actionPending()
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $limit_default = 20;
        $sort_default = 'newest';
        $args = ['sort' => $sort_default];
        $where_query = ['products.status' => 2, 'products.deleted' => 0];

        $query = Product::getItems('pending', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Product::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Product::getPageTypes('pending');
        $bulk_actions = array('publish', 'unpublish', 'trash');

        return $this->render('index', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'products' => $products,
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays unpublished page
     *
     * @return string
     */
    public function actionUnpublished()
    {
        $main_url = Url::to([$this->url]);
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $limit_default = 20;
        $sort_default = 'newest';
        $bulk_actions = array('publish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['products.status' => 0, 'products.deleted' => 0];

        $query = Product::getItems('unpublished', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Product::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Product::getPageTypes('unpublished');

        return $this->render('index', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'products' => $products,
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
        $actions_url = Url::to([$this->actions_url]);
        $vendors_url = Url::to([$this->vendors_url]);

        $limit_default = 20;
        $sort_default = 'newest';
        $bulk_actions = array('publish', 'unpublish', 'restore', 'delete');

        $args = ['sort' => $sort_default];
        $where_query = ['products.deleted' => 1];

        $query = Product::getItems('deleted', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Product::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Product::getPageTypes('deleted');

        return $this->render('index', array(
            'main_url' => $main_url,
            'actions_url' => $actions_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'products' => $products,
            'pagination' => $pagination,
        ));
    }
}
