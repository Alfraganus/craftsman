<?php
namespace base;

use Yii;
use yii\web\Controller;

/**
 * Seller controller
 */
class SellerController extends Controller
{
    private $login_url = '/account/login';

    /**
     * Before action
     *
     * @return string
     */
    public function beforeAction($action)
    {
        $app = Yii::$app;
        $redirect_to_login = true;

        if (!$app->user->isGuest) {
            $user = Yii::$app->user;
            $user_id = $user->getId();
            $roles = Yii::$app->authManager->getRolesByUser($user_id);

            if ($roles && isset($roles['seller'])) {
                $redirect_to_login = false;
            } else {
                return $this->redirect($app->params['store_url'])->send();
            }
        }

        if ($redirect_to_login) {
            $current_url = trim($app->request->url, '/');

            if (!empty($current_url)) {
                $app->user->loginUrl = [$this->login_url, 'redirect' => $current_url];
            } else {
                $app->user->loginUrl = [$this->login_url];
            }

            return $this->redirect($app->user->loginUrl)->send();
        } else {
            return parent::beforeAction($action);
        }
    }

    /**
     * Register JS file or files
     *
     * @param [type] $file
     * @return void
     */
    public function registerJs($file)
    {
        if ($file) {
            $bundle = \seller\assets\SiteAsset::register(\Yii::$app->view);

            if (is_array($file)) {
                foreach ($file as $fi) {
                    $bundle->js[] = $fi;
                }
            } else {
                $bundle->js[] = $file;
            }
        }
    }

    /**
     * Register CSS file or files
     *
     * @param [type] $file
     * @return void
     */
    public function registerCss($file)
    {
        if ($file) {
            $bundle = \seller\assets\SiteAsset::register(\Yii::$app->view);

            if (is_array($file)) {
                foreach ($file as $fi) {
                    $bundle->css[] = $fi;
                }
            } else {
                $bundle->css[] = $file;
            }
        }
    }
}
