<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driverId;
    public $lat;
    public $lng;

    public function __construct($driverId, $lat, $lng)
    {
        $this->driverId = $driverId;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('tracking.' . $this->driverId),
        ];
    }
}