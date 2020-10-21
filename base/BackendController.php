<?php

namespace base;

use backend\models\Language;
use common\models\Profile;
use Yii;
use yii\web\Controller;

/**
 * Backend controller
 */
class BackendController extends Controller
{
    private $login_url = '/auth/login';

    /**
     * Init
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        // Init container
        $container = new Container();
        $container::$prefix = 'cp';

        // Init language
        $language = new Language();
        $language->defaultLang = 'ru';
        $language->defaultLocale = 'ru_RU';

        $language->getLanguagesList(['status' => 1]);
        $language->getCurrentLanguage();
        $language->getContentLanguage();
        $language->checkAndSet();
    }

    /**
     * Before action
     * @param $action
     * @return bool|void
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $app = Yii::$app;
        $user = $app->user;
        $profile = false;

        $roles = array();
        $redirect_to_login = true;

        if (!$user->isGuest) {
            $user_id = $user->getId();
            $roles = $app->authManager->getRolesByUser($user_id);

            if ($roles && isset($roles['admin'])) {
                $redirect_to_login = false;
                $profile = Profile::find()->where(['user_id' => $user_id])->one();
            } else {
                return $this->redirect($app->params['store_url'])->send();
            }
        }

        if ($redirect_to_login) {
            $current_url = trim($app->request->url, '/');

            if (!empty($current_url)) {
                $user->loginUrl = [$this->login_url, 'redirect' => $current_url];
            } else {
                $user->loginUrl = [$this->login_url];
            }

            return $this->redirect($user->loginUrl)->send();
        } else {
            Container::push('current_user', $user->identity);
            Container::push('current_user_id', $user_id);
            Container::push('current_user_profile', $profile);
            Container::push('current_user_roles', $roles);

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
            $bundle = \backend\assets\AppAsset::register(\Yii::$app->view);

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
            $bundle = \backend\assets\AppAsset::register(\Yii::$app->view);

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
