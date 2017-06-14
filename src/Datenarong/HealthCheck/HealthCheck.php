<?php
namespace Datenarong\HealthCheck;

use Datenarong\HealthCheck\Classes\Output;
use Datenarong\HealthCheck\Classes\Mysql;
use Datenarong\HealthCheck\Classes\Mongo;
use Datenarong\HealthCheck\Classes\Cassandra;
use Datenarong\HealthCheck\Classes\Gearman;
use Datenarong\HealthCheck\Classes\Redis;
use Datenarong\HealthCheck\Classes\Socket;
use Datenarong\HealthCheck\Classes\File;

class HealthCheck
{
    public static function check($service)
    {
        if (empty($service)) {
            exit('No Service!');
        }

        if (!class_exists($service)) {
            exit('Class name does not exists');
        }

        return new $service;
    }

    public static function output($datas)
    {
        $output = new Output;
        return $output->html($datas);
    }
}
