<?php
namespace backend\controllers\products;

use yii\helpers\Url;
use base\BackendController;

/**
 * Products controller
 */
class CampaignsController extends BackendController
{
    public $url = '/products/campaigns';
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
        $bulk_actions = array('publish', 'unpublish', 'trash');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => true,
                'count' => 0,
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => 0,
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            ),
        );

        return $this->render('index', array(
            'actions_url' => $actions_url,
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
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
        $bulk_actions = array('unpublish', 'trash');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'published' => array(
                'name' => 'Published',
                'active' => true,
                'count' => 0,
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            ),
        );

        return $this->render('index', array(
            'actions_url' => $actions_url,
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
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
        $bulk_actions = array('publish', 'trash');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => 0,
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => true,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            ),
        );

        return $this->render('index', array(
            'actions_url' => $actions_url,
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
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
        $bulk_actions = array('publish', 'unpublish', 'restore', 'delete');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'published' => array(
                'name' => 'Published',
                'active' => false,
                'count' => 0,
            ),
            'unpublished' => array(
                'name' => 'Unpublished',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => true,
                'count' => 0,
            ),
        );

        return $this->render('index', array(
            'actions_url' => $actions_url,
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
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

        $this->registerJs(array(
            'dist/libs/sortablejs/sortable.min.js',
            'dist/libs/sortablejs/jquery-sortable.min.js',
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/gallery.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('create', array(
            'main_url' => $main_url,
        ));
    }

    /**
     * Displays edit page
     *
     * @return string
     */
    public function actionEdit()
    {
        $main_url = Url::to([$this->url]);

        $this->registerJs(array(
            'dist/libs/sortablejs/sortable.min.js',
            'dist/libs/sortablejs/jquery-sortable.min.js',
            'dist/libs/tinymce/tinymce.min.js',
            'theme/components/gallery.js',
            'theme/components/tinymce-editor.js',
        ));

        return $this->render('error', array(
            'main_url' => $main_url,
        ));
    }
}
