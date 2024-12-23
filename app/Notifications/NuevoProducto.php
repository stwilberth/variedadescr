<?php

namespace anuncielo\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use anuncielo\Producto; 

class NuevoProducto extends Notification
{
    use Queueable;

    protected $producto; // Declara la propiedad $producto

    /**
     * Create a new notification instance.
     */
    public function __construct(Producto $producto) // Recibe el producto como argumento
    {
        $this->producto = $producto; // Asigna el producto a la propiedad
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo producto disponible')
            ->line('Hemos agregado un nuevo producto a nuestra tienda.')
            ->action('Ver producto', route('productoShow', ['categoria' => $this->producto->categoria, 'slug' => $this->producto->slug]))
            ->line('¡Gracias por ser parte de nuestra comunidad!');
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
