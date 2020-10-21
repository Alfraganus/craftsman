<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@base', dirname(dirname(__DIR__)) . '/base');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@seller', dirname(dirname(__DIR__)) . '/seller');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

require dirname(dirname(__DIR__)) . '/base/helpers/global.php';
require dirname(dirname(__DIR__)) . '/base/helpers/types.php';
require dirname(dirname(__DIR__)) . '/base/helpers/strings.php';
require dirname(dirname(__DIR__)) . '/base/helpers/url.php';
require dirname(dirname(__DIR__)) . '/base/helpers/security.php';
