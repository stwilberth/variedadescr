<?php

namespace anuncielo\Listeners;

use anuncielo\Events\ProductoCreado;
use anuncielo\Notifications\NuevoProducto;
use anuncielo\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarNotificacionProductoCreado
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductoCreado $event)
    {
        /* 
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new NewProductNotification($event->producto));
        } 
        */

        Subscriber::chunk(100, function ($subscribers) use ($event) {
            foreach ($subscribers as $subscriber) {
                $subscriber->notify(new NuevoProducto($event->producto));
            }
        });
        
    }
}
