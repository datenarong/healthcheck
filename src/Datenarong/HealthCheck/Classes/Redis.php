<?php
namespace Datenarong\HealthCheck\Classes;

class Redis
{
    public function connect($server, $port = 6379)
    {
        $redis = new Predis\Client([
                "scheme" => "tcp",
                "host"   => $server,
                "port"   => $port,
            ]);
        
        return $redis;
    }

    public function numberOfJobInQueue($redis, $keys)
    {
        //Define output
        $output = 0;

        //loop by keys
        foreach ($keys as $key) {
            $output += (int)$redis->llen("resque:queue:".$key);
        }

        return $output;
    }
}
