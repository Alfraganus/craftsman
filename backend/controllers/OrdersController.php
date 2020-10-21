<?php
namespace backend\controllers;

use yii\helpers\Url;
use base\BackendController;

/**
 * Orders controller
 */
class OrdersController extends BackendController
{
    public $url = '/orders';
    public $vendors_url = '/vendors';

    /**
     * Displays all orders
     *
     * @return string
     */
    public function actionIndex()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('new-order', 'complete-order', 'cancel-order', 'trash-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => true,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => false,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => false,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => false,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
        ));
    }

    /**
     * Displays new orders
     *
     * @return string
     */
    public function actionNew()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('complete-order', 'cancel-order', 'trash-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => true,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => false,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => false,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
        ));
    }

    /**
     * Displays processing orders
     *
     * @return string
     */
    public function actionProcessing()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('new-order', 'complete-order', 'cancel-order', 'trash-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => false,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => true,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => false,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
        ));
    }

    /**
     * Displays completed orders
     *
     * @return string
     */
    public function actionCompleted()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('new-order', 'cancel-order', 'trash-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => false,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => false,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => true,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
        ));
    }

    /**
     * Displays cancelled orders
     *
     * @return string
     */
    public function actionCancelled()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('new-order', 'complete-order', 'trash-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => false,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => false,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => false,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => true,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => false,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
        ));
    }

    /**
     * Displays deleted orders
     *
     * @return string
     */
    public function actionDeleted()
    {
        $main_url = Url::to([$this->url]);
        $vendors_url = Url::to([$this->vendors_url]);
        $bulk_actions = array('new-order', 'complete-order', 'cancel-order', 'delete-order');

        $page_types = array(
            '' => array(
                'name' => 'All',
                'active' => false,
                'count' => 0,
            ),
            'new' => array(
                'name' => 'New',
                'active' => false,
                'count' => 0,
            ),
            'processing' => array(
                'name' => 'Processing',
                'active' => false,
                'count' => 0,
            ),
            'completed' => array(
                'name' => 'Completed',
                'active' => false,
                'count' => 0,
            ),
            'cancelled' => array(
                'name' => 'Cancelled',
                'active' => false,
                'count' => 0,
            ),
            'deleted' => array(
                'name' => 'Deleted',
                'active' => true,
                'count' => 0,
            )
        );

        return $this->render('index', array(
            'main_url' => $main_url,
            'vendors_url' => $vendors_url,
            'page_types' => $page_types,
            'bulk_actions' => $bulk_actions,
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

        return $this->render('edit', array(
            'main_url' => $main_url,
        ));
    }
}
