<?php
namespace Datenarong\HealthCheck\Classes;

class Mysql
{
    private $outputs = [
        'module'  => 'Mysql',
        'service' => '',
        'url'     => '',
        'status'  => 'OK',
        'remark'  => ''
    ];

    public function __construct()
    {
    }

    public function connect($host, $user, $pass, $db)
    {
        $this->outputs['service'] = 'Check Connection';

        try {
            $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->outputs = [
                'status'  => 'ERROR',
                'remark'  => 'Can\'t connect to database : ' . $e->getMessage()
            ];
        }

        $conn = null;
    }

    public function getData($mysql, $database, $table, $sql = null)
    {
        $this->outputs['service'] = 'Check Query Datas';

        mysql_select_db($database, $mysql);
        mysql_query('SET NAMES UTF8', $mysql);

        if (empty($sql)) {
            $sql = "SELECT * FROM " . $table;
        }

        $result = mysql_query($sql);

        return $result;
    }

    public function __destruct()
    {
        return $this->outputs;
    }
}
