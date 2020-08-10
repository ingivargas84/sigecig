<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;


class ActualizarTimbresReserva extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:estadoTimbre';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizacion de estado de timbre en reserva, con tiempo mayor a 10 minutos de creacion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $timbresEnReserva=\App\SigecigReservaTimbres::where('estado','1')->get();
        foreach ($timbresEnReserva as $key => $timbre) {
            $fechaTimbre = Carbon::parse($timbre->fecha_hora);
            $diffMinutes = $fechaTimbre->diffInMinutes($now,false);
            if($diffMinutes >11){
                $timbre->estado=0;
                $timbre->update();
            }
        }

      
        
    }
}
