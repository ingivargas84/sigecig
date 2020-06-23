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
    public $tipoDeCliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fecha_actual, $datos_colegiado,$reciboMaestro, $tipoDeCliente)
    {
        $this->fecha_actual = $fecha_actual;
        $this->datos_colegiado = $datos_colegiado;
        $this->reciboMaestro = $reciboMaestro;
        $this->tipoDeCliente =  $tipoDeCliente;
        
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
