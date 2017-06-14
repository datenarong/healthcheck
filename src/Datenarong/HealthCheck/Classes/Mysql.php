<?php
namespace Datenarong\HealthCheck\Classes;

class Mysql
{
    public function __construct()
    {
    }

    public function connect($host, $user, $pass)
    {
        $mysql = mysql_connect($host, $user, $pass);
        
        return $mysql;
    }

    public function getData($mysql, $database, $table, $sql = null)
    {
        mysql_select_db($database, $mysql);
        mysql_query('SET NAMES UTF8', $mysql);

        if (empty($sql)) {
            $sql = "SELECT * FROM ".$table;
        }

        $result = mysql_query($sql);

        return $result;
    }
}
