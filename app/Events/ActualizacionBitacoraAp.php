<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActualizacionBitacoraAp
{

    public $user_id;
    public $id;
    public $fecha;
    public $id_estado_solicitud;



    use SerializesModels;
    //use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $id, $fecha, $id_estado_solicitud)
    {
   
        $this->user_id = $user_id;
        $this->no_solicitud = $id;
        $this->id_estado_solicitud = $id_estado_solicitud;
        $this->fecha = $fecha;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
