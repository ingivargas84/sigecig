<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreoJunta extends Mailable 
{
    use Queueable, SerializesModels;
    public $colegiado;
    public $fecha_actual;
    public $solicitudAP;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($colegiado,$fecha_actual,$solicitudAP)
    {
        $this->colegiado = $colegiado;
        $this->fecha_actual = $fecha_actual;
        $this->solicitudAP = $solicitudAP;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.correo-junta');
    }
}
