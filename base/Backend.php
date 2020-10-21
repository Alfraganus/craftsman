<?php
namespace base;

use Yii;

class Backend
{
    /**
     * Get current user data
     *
     * @param [type] $type
     * @return mixed
     */
    public static function current_user($type = 'user')
    {
        if ($type == 'id') {
            return Yii::$app->user->getId();
        } elseif ($type == 'roles') {
            return Container::get('current_user_roles');
        }

        return Yii::$app->user;
    }

    /**
     * Get language
     *
     * @param [type] $type
     * @return mixed
     */
    public static function language($type)
    {
        if ($type == 'current') {
            return Container::get('current_language');
        } elseif ($type == 'content') {
            return Container::get('content_language');
        } elseif ($type == 'list') {
            return Container::get('languages_list');
        }
    }

    public static function registerJsFiles($app, $files, $config = array())
    {
        if (is_array($files) && $files) {
            foreach ($files as $file) {
                $app->registerJsFile(
                    $file
                );
            }
        }

        return $app;
    }
}
