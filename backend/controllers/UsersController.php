<?php

namespace backend\controllers;

use backend\models\User;
use base\BackendController;
use common\models\Profile;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Users controller
 */
class UsersController extends BackendController
{
    public $url = '/users';

    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        $main_url = Url::to([$this->url]);
        $bulk_actions = array('activate', 'block', 'trash');

        $where_query = ['users.deleted' => 0];
        $query = User::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = User::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = User::getPageTypes('');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'users' => $users,
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
        $bulk_actions = array('block', 'trash');

        $where_query = ['users.deleted' => 0, 'users.status' => User::ACTIVE];
        $query = User::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = User::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = User::getPageTypes('active');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'users' => $users,
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
        $bulk_actions = array('activate', 'block', 'trash');

        $where_query = ['users.deleted' => 0, 'users.status' => User::PENDING];
        $query = User::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = User::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = User::getPageTypes('pending');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'users' => $users,
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
        $bulk_actions = array('activate', 'trash');

        $where_query = ['users.deleted' => 0, 'users.status' => User::BANNED];
        $query = User::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = User::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = User::getPageTypes('blocked');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'users' => $users,
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
        $bulk_actions = array('activate', 'block', 'restore', 'delete');

        $where_query = ['users.deleted' => 1];
        $query = User::getItems()->andWhere($where_query);
        $count = $query->count();

        $limit = input_get('limit');
        $ajax = input_post('ajax');

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = User::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = User::getPageTypes('deleted');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'users' => $users,
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
        $model = new User();
        $profile = new Profile();
        $main_url = Url::to([$this->url]);
        $post_item = Yii::$app->request->post();

        if ($post_item) {
            $submit_button = input_post('submit_button');

            if ($submit_button == 'create_and_add_new' && $model->load($post_item) && $profile->load($post_item)) {
                $model->createUser($model, $profile);

                Yii::$app->session->setFlash('success-alert', "The user was created successfully!");
                return $this->redirect(['create']);
            } elseif ($model->load($post_item) && $profile->load($post_item)) {
                $user_id = $model->createUser($model, $profile);

                Yii::$app->session->setFlash('success-alert', "The user was created successfully!");
                return $this->redirect(['edit', 'id' => $user_id]);
            }
        }

        $this->registerJs(array(
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('create', array(
            'main_url' => $main_url,
            'model' => $model,
            'profile' => $profile,
        ));
    }

    /**
     * Displays edit page
     *
     * @return string
     */
    public function actionEdit($id)
    {
        $model = User::findOne($id);
        $profile = Profile::find()->where(['user_id' => $id])->one();
        $main_url = Url::to([$this->url]);
        $post_item = Yii::$app->request->post();

        if (!$model || !$profile) {
            return $this->render('error', array(
                'main_url' => $main_url,
            ));
        }

        $user_role = User::getRole($id);
        $model->role = $user_role ? $user_role['name'] : '';

        if ($post_item) {
            $submit_button = input_post('submit_button');

            if ($submit_button == 'create_and_add_new' && $model->load($post_item) && $profile->load($post_item)) {
                $model->updateUser($model, $profile, $post_item);

                Yii::$app->session->setFlash('success-alert', "The user has been successfully updated!");
                return $this->redirect(['create']);
            } elseif ($model->load($post_item) && $profile->load($post_item)) {
                $model->updateUser($model, $profile, $post_item);

                Yii::$app->session->setFlash('success-alert', "The user has been successfully updated!");
                return $this->refresh();
            }
        }

        $this->registerJs(array(
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('update', array(
            'main_url' => $main_url,
            'model' => $model,
            'profile' => $profile,
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
        $user = User::findOne($id);
        $profile = Profile::findOne(['user_id' => $id]);

        $tabs = array(
            ['link' => 'profile', 'name' => 'Profile', 'icon' => 'ri-information-line'],
            ['link' => 'orders', 'name' => 'Orders', 'icon' => 'ri-shopping-cart-line'],
            ['link' => 'activity', 'name' => 'Activity', 'icon' => 'ri-file-paper-line'],
            ['link' => 'sessions', 'name' => 'Sessions', 'icon' => 'ri-bar-chart-horizontal-line'],
        );

        $this->registerCss(array(
            'dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            'dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
            'dist/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css',
            'dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css',
        ));

        $this->registerJs(array(
            'dist/libs/datatables.net/js/jquery.dataTables.min.js',
            'dist/libs/datatables.net-buttons/js/dataTables.buttons.min.js',
            'dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
            'dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
            'dist/js/pages/datatables.init.js',
        ));

        return $this->render('info', array(
            'main_url' => $main_url,
            'tabs' => $tabs,
            'user' => $user,
            'profile' => $profile,
        ));
    }
}
