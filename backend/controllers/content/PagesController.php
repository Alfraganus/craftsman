<?php

namespace backend\controllers\content;

use base\BackendController;
use backend\models\Content;
use common\models\ContentInfos;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Pages controller
 */
class PagesController extends BackendController
{
    public $url = '/content/pages';
    public $content_type = 'page';

    /**
     * Init controller
     */
    public function init()
    {
        parent::init();
        Content::$type = $this->content_type;
        Content::$items_with_parent = true;
        Content::$slug_generator = 'same';
    }

    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        $main_url = Url::to([$this->url]);
        $limit_default = 20;
        $sort_default = 'a-z';
        $bulk_actions = array('publish', 'unpublish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['content.deleted' => 0];

        $query = Content::getItems('', $args)->andWhere($where_query);
        $count = $query->count();
//        echo "<pre>";
//        var_dump($count);die;
        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Content::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $pages = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Content::getPageTypes('');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'pages' => $pages,
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
        $limit_default = 20;
        $sort_default = 'a-z';
        $bulk_actions = array('unpublish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['content.status' => 1, 'content.deleted' => 0];

        $query = Content::getItems('published', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Content::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $pages = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Content::getPageTypes('published');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'pages' => $pages,
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
        $limit_default = 20;
        $sort_default = 'a-z';
        $bulk_actions = array('publish', 'trash');

        $args = ['sort' => $sort_default];
        $where_query = ['content.status' => 0, 'content.deleted' => 0];

        $query = Content::getItems('unpublished', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Content::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $pages = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Content::getPageTypes('unpublished');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'pages' => $pages,
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
        $limit_default = 20;
        $sort_default = 'a-z';
        $bulk_actions = array('publish', 'unpublish', 'restore', 'delete');

        $args = ['sort' => $sort_default];
        $where_query = ['content.deleted' => 1];

        $query = Content::getItems('deleted', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Content::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $pages = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Content::getPageTypes('deleted');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'pages' => $pages,
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
        $post_item = Yii::$app->request->post();
        $model = new Content();
        $info = new ContentInfos();

        if ($post_item) {
            $submit_button = input_post('submit_button');

            $flash_type = 'success-error';
            $flash_message = 'An error occurred while processing your request. Please try agian.';

            if ($model->load($post_item) && $info->load($post_item)) {
                $id = Content::createItem($model, $info, $post_item);

                $flash_type = 'success-alert';
                $flash_message = 'The page was created successfully!';

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
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('create', array(
            'main_url' => $main_url,
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
        $post_item = Yii::$app->request->post();

        $item = Content::getItemToEdit($id);
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
                $action = Content::updateItem($model, $info, $post_item);

                if (is_string($action) && $action) {
                    $flash_type = 'error-alert';
                    $flash_message = $action;
                } else {
                    $flash_type = 'success-alert';
                    $flash_message = 'The page has been successfully updated!';
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
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('update', array(
            'main_url' => $main_url,
            'model' => $model,
            'info' => $info,
            'translations' => $translations,
        ));
    }
}
