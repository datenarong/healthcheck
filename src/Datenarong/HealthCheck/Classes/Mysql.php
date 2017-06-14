<?php
namespace Datenarong\HealthCheck\Classes;

class Mysql
{
    private $start_time;
    private $outputs = [
        'module'   => 'Mysql',
        'service'  => '',
        'url'      => '',
        'response' => 0.00,
        'status'   => 'OK',
        'remark'   => ''
    ];
    private $conn;

    public function __construct()
    {
        $this->start_time = microtime(true);
    }

    public function connect($conf)
    {
        $this->outputs['service'] = 'Check Connection';

        // Validate parameter
        $fixs = ['servername', 'username', 'password', 'dbname'];
        if (false === $this->validParams($fixs, $conf)) {
            $this->outputs = [
                'status' => 'ERROR',
                'remark' => 'Require parameter (' . implode(',', $fixs) . ')'
            ];
        }

        try {
            $this->conn = new PDO("mysql:host={$conf['servername']};dbname={$conf['dbname']};charset=utf8", $conf['username'], $conf['password']);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->outputs = [
                'status'  => 'ERROR',
                'remark'  => 'Can\'t connect to database : ' . $e->getMessage()
            ];
        }
    }

    public function query($conf, $sql)
    {
        $this->outputs['service'] = 'Check Query Datas';

        $this->connect($conf);

        // Query
        try {
            $this->conn->query($sql);
        } catch (PDOException  $e) {
            $this->outputs = [
                'status'  => 'ERROR',
                'remark'  => 'Can\'t query datas : ' . $e->getMessage()
            ];
        }
    }

    private function validParams($fixs, $params)
    {
        foreach ($fixs as $fix) {
            // Check fix params
            if (!isset($conf[$fix])) {
                return false;
            }
        }
        return true;
    }

    public function __destruct()
    {
        $this->outputs['response'] = microtime(true) - $this->start_time;

        $this->conn = null;

        return $this->outputs;
    }
}
