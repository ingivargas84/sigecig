<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AprobacionDocAp extends Mailable
{
    use Queueable, SerializesModels;

    public $subject='Aprobacion de Documentos Auxilio Póstumo';

   
    public $fecha_actual;
    public $solicitudAP;
    public $colegiado;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fecha_actual, $solicitudAP, $colegiado)
    {
      
        $this->fecha_actual = $fecha_actual;
        $this->solicitudAP = $solicitudAP;
        $this->colegiado = $colegiado;
       
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.aprobaciondocap');
    }
}
