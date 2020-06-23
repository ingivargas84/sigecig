<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioReciboElectronico extends Mailable
{
    use Queueable, SerializesModels;

    public $fecha_actual;
    public $datos_colegiado;
    public $reciboMaestro;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fecha_actual, $datos_colegiado,$reciboMaestro)
    {
        $this->fecha_actual = $fecha_actual;
        $this->datos_colegiado = $datos_colegiado;
        $this->reciboMaestro = $reciboMaestro;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.envioreciboelectronico');
    }
}
