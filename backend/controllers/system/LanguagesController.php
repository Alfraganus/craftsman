<?php

namespace backend\controllers\system;

use backend\models\Language;
use base\BackendController;
use common\models\Languages;

/**
 * Languages controller
 */
class LanguagesController extends BackendController
{
    /**
     * Displays main page
     *
     * @return string
     */
    public function actionIndex()
    {
        // Get ajax action
        $ajax = input_post('ajax');

        if ($ajax == 'update-action') {
            $output['error'] = true;
            $output['success'] = false;

            $id = input_post('id');
            $checked = input_post('checked');
            $language = new Language();

            if ($checked == 'true') {
                $status = true;
                $update = $language->updateStatus($id, 1);
            } else {
                $status = false;
                $update = $language->updateStatus($id, 0);
            }

            if ($update) {
                $output['error'] = false;
                $output['success'] = true;
                $log_data[$update->lang_code] = $status;

                set_log('admin', [
                    'type' => 'settings',
                    'action' => 'update',
                    'data' => json_encode($log_data),
                ]);
            }

            echo json_encode($output);
            exit();
        }

        $languages = Languages::find()
            ->orderBy('name')
            ->asArray()
            ->all();

        return $this->render('index', ['languages' => $languages]);
    }
}
