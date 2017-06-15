<?php
namespace Datenarong\HealthCheck\Classes;

class Mysql extends Base
{
    private $conf = ['servername', 'username', 'password', 'dbname'];
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->outputs['module'] = 'Mysql';
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

        // Set url
        $this->outputs['url'] = $conf['servername'];

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

        // Connect database
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
        parent::__destruct();

        // Disconnect database
        $this->conn = null;

        return $this->outputs;
    }
}
