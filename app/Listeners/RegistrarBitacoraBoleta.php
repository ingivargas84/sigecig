<?php

namespace App\Listeners;

use App\Events\ActualizacionBitacoraBoleta;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\BitacoraBoleta;
use Carbon\Carbon;
class RegistrarBitacoraBoleta
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
     * @param  ActualizacionBitacoraBoleta  $event
     * @return void
     */
    public function handle(ActualizacionBitacoraBoleta $event)
    {
        $bitacoraB = new BitacoraBoleta;
        $bitacoraB->no_boleta = $event->no_boleta;
        $bitacoraB->accion = $event->accion;
        $bitacoraB->user_id = $event->user_id;
        $bitacoraB->fecha = $event->fecha;
        $bitacoraB->save();
    }
}
