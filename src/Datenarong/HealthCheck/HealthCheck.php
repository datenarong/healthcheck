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
        $output = new Output;
        return $output->html($datas);
    }

    private function cassandra()
    {
        return new \Datenarong\HealthCheck\Classes\Cassandra;
    }

    private function file()
    {
        return new \Datenarong\HealthCheck\Classes\File;
    }

    private function gearman()
    {
        return new \Datenarong\HealthCheck\Classes\Gearman;
    }

    private function mongo()
    {
        return new \Datenarong\HealthCheck\Classes\Mongo;
    }

    private function mysql()
    {
        return new \Datenarong\HealthCheck\Classes\Mysql;
    }

    private function oracle()
    {
        return new \Datenarong\HealthCheck\Classes\Oracle;
    }

    private function redis()
    {
        return new \Datenarong\HealthCheck\Classes\Redis;
    }

    private function socket()
    {
        return new \Datenarong\HealthCheck\Classes\Socket;
    }
}
