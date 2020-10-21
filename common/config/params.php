<?php
require dirname(dirname(__DIR__)) . '/config.inc.php';

$params = [
    'order_prefix' => 'AV-11',
    'adminEmail' => 'admin@avlo.uz',
    'supportEmail' => 'support@avlo.uz',
    'senderEmail' => 'noreply@avlo.uz',
    'senderName' => 'AVLO UZ',
    'user.passwordResetTokenExpire' => 3600,
];

return array_merge($config, $params);
