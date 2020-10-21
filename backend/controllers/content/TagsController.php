<?php

namespace backend\controllers\content;

use base\BackendController;
use backend\models\Segment;
use common\models\SegmentInfos;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Tags controller
 */
class TagsController extends BackendController
{
    public $url = '/content/tags';
    public $segment_type = 'post_tag';

    /**
     * Init controller
     */
    public function init()
    {
        parent::init();
        Segment::$type = $this->segment_type;
        Segment::$items_with_parent = false;
        Segment::$slug_generator = 'same';
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
        $where_query = ['segment.deleted' => 0];

        $query = Segment::getItems('', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Segment::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Segment::getPageTypes('');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'tags' => $tags,
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
        $where_query = ['segment.status' => 1, 'segment.deleted' => 0];

        $query = Segment::getItems('published', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Segment::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Segment::getPageTypes('published');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'tags' => $tags,
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
        $where_query = ['segment.status' => 0, 'segment.deleted' => 0];

        $query = Segment::getItems('unpublished', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Segment::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Segment::getPageTypes('unpublished');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'tags' => $tags,
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
        $where_query = ['segment.deleted' => 1];

        $query = Segment::getItems('deleted', $args)->andWhere($where_query);
        $count = $query->count();

        $ajax = input_post('ajax');
        $limit = input_get('limit', $limit_default);

        if ($ajax == 'bulk-actions') {
            $ajax_action = input_post('action');
            $ajax_items = input_post('items');
            $ajax_item_id = input_post('id');
            $items = explode(',', $ajax_items);

            $output = Segment::ajaxAction($ajax_action, $ajax_item_id, $items);

            echo json_encode($output);
            exit();
        }

        if (!empty($limit)) {
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $limit]);
        } else {
            $pagination = new Pagination(['totalCount' => $count]);
        }

        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $page_types = Segment::getPageTypes('deleted');

        return $this->render('index', array(
            'main_url' => $main_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
            'limit_default' => $limit_default,
            'sort_default' => $sort_default,
            'tags' => $tags,
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
        $model = new Segment();
        $info = new SegmentInfos();

        if ($post_item) {
            $submit_button = input_post('submit_button');

            $flash_type = 'success-error';
            $flash_message = 'An error occurred while processing your request. Please try agian.';

            if ($model->load($post_item) && $info->load($post_item)) {
                $id = Segment::createItem($model, $info, $post_item);

                $flash_type = 'success-alert';
                $flash_message = 'The category was created successfully!';

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

        $item = Segment::getItemToEdit($id);
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
                $action = Segment::updateItem($model, $info, $post_item);

                if (is_string($action) && $action) {
                    $flash_type = 'error-alert';
                    $flash_message = $action;
                } else {
                    $flash_type = 'success-alert';
                    $flash_message = 'The category has been successfully updated!';
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
