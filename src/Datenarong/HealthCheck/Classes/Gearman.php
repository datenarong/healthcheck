<?php
namespace Datenarong\HealthCheck\Classes;

class Gearman
{
    public function connect($host, $port, $timeout = 500)
    {
        require_once(BASE_DIR.'classes/gearmanAdmin/GearmanAdmin.php');
        $gmAdmin = new GearmanAdmin($host, $port, $timeout);
        return $gmAdmin;
    }

    // This method want to get amount worker
    // But response $gmAdmin->getWorkers() is Bug! can't get array[0]
    public function workerRunning($gmAdmin)
    {
        $workers = (array) $gmAdmin->getWorkers();
        $wk = [];
        foreach ($workers as $key => $value) {
            if (strpos($key, 'GearmanAdminWorkers') !== false && strpos($key, '_workers') !== false) {
                $wk = $value;
                break;
            }
        }

        return count($wk);
    }


    // Method for format execute output
    private function getNumberOfQueueFromExecuteOutput($res)
    {
        // Define output
        $total = 0;
        $datas = explode("\n", $res);
        if (! empty($datas)) {
            foreach ($datas as $data) {
                if (!empty($data) || $data !== '.') {
                    // Get number of queue
                    $queues = explode("\t", $data);
                    $total += ((isset($queues['1']) && ! empty($queues['1'])) ? (int)$queues['1'] : 0);
                }
            }
        }
        
        return $total;
    }
    
    // Method for format admin status output
    private function getNumberOfQueueFromStatusOutput($datas)
    {
        // Define output
        $total = 0;
        foreach ($datas as $queues) {
            // Loop for queue
            foreach ($queues as $queue) {
                if (isset($queue[0])) {
                    $total += (int)$queue[0];
                }
            }
        }
        
        return $total;
    }

    // Method for get total queue in german server
    public function getTotalQueue($server, $port = 4730)
    {
        // Coonnect by gearman admin
        $gm_admin   = new GearmanAdmin($server, $port);

        // Get queue
        $res = (array)$gm_admin->getStatus();
        // $res = shell_exec( "(echo status ; sleep 0.1) | netcat {$server} {$port}" );
        
        $total = $this->getNumberOfQueueFromStatusOutput($res);
        
        return $total;
    }
}
