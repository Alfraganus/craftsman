<?php
namespace base\libs;

use Yii;

class Redis
{
    public static function prefix($key = false)
    {
        $prefix = Yii::$app->params['redis_key'];

        if ($prefix) {
            return $prefix .'_'. $key;
        }

        return $key;
    }

    public static function connect()
    {
        $auth = Yii::$app->params['redis_auth'];
        $host = Yii::$app->params['redis_host'];
        $port = Yii::$app->params['redis_port'];
        $scheme = Yii::$app->params['redis_scheme'];

        $config = array(
            'scheme' => $scheme ? $scheme : 'tcp',
            'host' => $host ? $host : '127.0.0.1',
            'port' => $port ? $port : '6379',
        );

        $client = new \Predis\Client($config);

        if ($auth) {
            $client->auth($auth);
        }

        return $client;
    }

    public static function set($key, $value, $expire = 0)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        $client->set($redis_key, $value);

        if (is_numeric($expire) && $expire > 0) {
            $client->expire($redis_key, $expire);
        }
    }

    public static function rpush($key, $value, $expire = 0)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        $client->rpush($redis_key, $value);

        if (is_numeric($expire) && $expire > 0) {
            $client->expire($redis_key, $expire);
        }
    }

    public static function lpush($key, $value, $expire = 0)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        $client->rpush($redis_key, $value);

        if (is_numeric($expire) && $expire > 0) {
            $client->expire($redis_key, $expire);
        }
    }

    public static function lrange($key, $x = 0, $y = -1)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        return $client->lrange($redis_key, $x, $y);
    }

    public static function get($key)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        return $client->get($redis_key);
    }

    public static function delete($key)
    {
        $redis_key = self::prefix($key);

        $client = self::connect();
        return $client->del($redis_key);
    }
}
