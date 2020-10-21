<?php
define('DS', DIRECTORY_SEPARATOR);
define('HOME_PATH', dirname(__FILE__) . DS);
define('BACKEND_PATH', HOME_PATH .'backend'. DS);
define('FRONTEND_PATH', HOME_PATH .'frontend'. DS);
define('MEDIA_PATH', HOME_PATH .'media'. DS);
define('SELLER_PATH', HOME_PATH .'seller'. DS);
define('UPLOADS_PATH', MEDIA_PATH .'uploads'. DS);

// URL
$config['assets_url'] = 'http://assets.avlo.loc/';
$config['admin_url'] = 'http://cp.avlo.loc/';
$config['store_url'] = 'http://avlo.loc/';
$config['seller_url'] = 'http://sotuvchi.avlo.loc/';

// Redis settings
$config['redis_key'] = 'avlouz';
$config['redis_auth'] = '';
$config['redis_host'] = '127.0.0.1';
$config['redis_port'] = 6379;
$config['redis_scheme'] = 'tcp';