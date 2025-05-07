<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SensorAlertTriggered implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public $sensor_id;
    public $sensor_name;
    public $alert_level;

    public function __construct($sensor_id, $sensor_name, $alert_level)
    {
        $this->sensor_id = $sensor_id;
        $this->sensor_name = $sensor_name;
        $this->alert_level = $alert_level;
    }

    public function broadcastOn()
    {
        return new Channel('sensor-alerts'); 
    }

    public function broadcastAs()
    {
        return 'SensorAlertTriggered'; 
    }
}

