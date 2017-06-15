<?php
namespace Datenarong\HealthCheck\Classes;

use Datenarong\HealthCheck\Interfaces\BaseInterface;
use Datenarong\HealthCheck\Classes\Output;

abstract class Base implements BaseInterface
{
    private $start_time;
    protected $outputs = [
        'module'   => '',
        'service'  => '',
        'url'      => '',
        'response' => 0.00,
        'status'   => 'OK',
        'remark'   => ''
    ];

    public function __construct()
    {
        $this->start_time = microtime(true);
    }

    public function output($datas)
    {
        $output = new Output;
        echo $output->html($datas);
    }

    public function __destruct()
    {
        $this->outputs['response'] = microtime(true) - $this->start_time;
    }
}
