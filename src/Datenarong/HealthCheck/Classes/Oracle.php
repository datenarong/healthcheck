<?php

namespace Datenarong\HealthCheck\Classes;

class Oracle
{
    private $start_time;
    private $outputs = [
        'module'   => 'Oracle',
        'service'  => '',
        'url'      => '',
        'response' => 0.00,
        'status'   => 'OK',
        'remark'   => ''
    ];
    private $conf = ['host', 'port', 'username', 'password', 'dbname', 'charset'];
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
            // Connect to oracle
            $this->conn = oci_connect(
                $conf['username'],
                $conf['password'],
                "{$conf['host']}:{$conf['port']}/{$conf['db']}",
                $conf['charset']
            );
        
            if (!$this->conn) {
                $this->outputs = [
                    'status'  => 'ERROR',
                    'remark'  => 'Can\'t connect to database'
                ];
            }
        } catch (Exception $e) {
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
            $orc_parse = oci_parse($this->conn, $sql);
            $orc_exec = oci_execute($orc_parse);
            oci_free_statement($orc_parse);

            if (!$orc_exec) {
                $this->outputs = [
                    'status'  => 'ERROR',
                    'remark'  => 'Can\'t query datas'
                ];
            }
        } catch (\Exception $e) {
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
