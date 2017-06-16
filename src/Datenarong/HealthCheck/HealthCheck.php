<?php
namespace Datenarong\HealthCheck;

class HealthCheck
{
    public static function check($service)
    {
        $classes = ['cassandra', 'file', 'gearman', 'mongo', 'mysql', 'oracle', 'redis', 'socket'];

        if (in_array(strtolower($service), $classes)) {
            return Self::$service();
        }

        echo 'Class name does not exists';
    }

    public static function output($datas)
    {
        $output = new \Datenarong\HealthCheck\Classes\Output;
        return $output->html($datas);
    }

    private static function cassandra()
    {
        return new \Datenarong\HealthCheck\Classes\Cassandra;
    }

    private static function file()
    {
        return new \Datenarong\HealthCheck\Classes\File;
    }

    private static function gearman()
    {
        return new \Datenarong\HealthCheck\Classes\Gearman;
    }

    private static function mongo()
    {
        return new \Datenarong\HealthCheck\Classes\Mongo;
    }

    private static function mysql()
    {
        return new \Datenarong\HealthCheck\Classes\Mysql;
    }

    private static function oracle()
    {
        return new \Datenarong\HealthCheck\Classes\Oracle;
    }

    private static function redis()
    {
        return new \Datenarong\HealthCheck\Classes\Redis;
    }

    private static function socket()
    {
        return new \Datenarong\HealthCheck\Classes\Socket;
    }
}
