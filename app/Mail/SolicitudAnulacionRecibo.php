<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudAnulacionRecibo extends Mailable
{
    use Queueable, SerializesModels;

    public $fecha_actual;
    public $reciboMaestro;
    public $tipo;
    public $cajero;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fecha_actual,$reciboMaestro, $tipo, $cajero, $link)
    {
        $this->fecha_actual = $fecha_actual;
        $this->reciboMaestro = $reciboMaestro;
        $this->tipo =  $tipo;
        $this->cajero =  $cajero;
        $this->link =  $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.solicitudanulacionrecibo');
    }
}
