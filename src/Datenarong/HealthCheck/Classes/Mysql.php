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
    private $conf = ['servername', 'username', 'password', 'dbname'];
    private $conn;

    public function __construct()
    {
        $this->start_time = microtime(true);
    }

    public function connect($conf)
    {
        $this->outputs['service'] = 'Check Connection';

        // Validate parameter
        if (false === $this->validParams($conf)) {
            $this->outputs = [
                'status' => 'ERROR',
                'remark' => 'Require parameter (' . implode(',', $this->conf) . ')'
            ];
        }

        try {
            // Connect to mysql
            $this->conn = new PDO("mysql:host={$conf['servername']};dbname={$conf['dbname']};charset=utf8", $conf['username'], $conf['password']);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!$this->conn) {
                $this->outputs = [
                    'status'  => 'ERROR',
                    'remark'  => 'Can\'t connect to database'
                ];
            }
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

    private function validParams($conf)
    {
        foreach ($this->conf as $k) {
            // Check fix params
            if (!isset($conf[$k])) {
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
