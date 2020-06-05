<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ActualizacionBitacora' => [
            'App\Listeners\RegistrarBitacora',
        ],

        'App\Events\ActualizacionBitacoraBoleta' => [
            'App\Listeners\RegistrarBitacoraBoleta',
        ],
        
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'App\Events\ActualizacionBitacoraAp' => [
            'App\Listeners\RegistrarBitacoraAp',
        ],
        


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
