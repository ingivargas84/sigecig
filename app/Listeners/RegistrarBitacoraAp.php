<?php

namespace App\Listeners;

use App\Events\ActualizacionBitacoraAp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\BitacoraAp;
use Carbon\Carbon;
class RegistrarBitacoraAp
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActualizacionBitacoraAp  $event
     * @return void
     */
    public function handle(ActualizacionBitacoraAp $event)
    {
     
        $bitacoraB = new BitacoraAp;
        $bitacoraB->usuario = $event->user_id;
        $bitacoraB->fecha = $event->fecha;
        $bitacoraB->no_solicitud = $event->no_solicitud;
        $bitacoraB->estado_solicitud = $event->id_estado_solicitud;
        $bitacoraB->id_creacion = 0;

        $bitacoraB->save();
        
    }
}
