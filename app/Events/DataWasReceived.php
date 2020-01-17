<?php

namespace App\Events;

use App\Models\Data;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataWasReceived implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected $data;

    public function __construct(Data $data)
    {
        $this->data = $data;
    }

    public function broadcastWith()
    {
        return $this->data->toArray();
    }

    public function broadcastAs()
    {
        return 'dataWasReceived';
    }

    public function broadcastOn()
    {
        return new Channel('messages');
    }
}
