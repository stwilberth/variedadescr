<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    public function sendNewProductNotification($subscriber, $producto)
    {
        try {
            Mail::send('emails.nuevo-producto', [
                'producto' => $producto,
                'subscriber' => $subscriber
            ], function ($message) use ($subscriber) {
                $message->to($subscriber->email)
                    ->subject('¡Nuevo producto disponible!');
            });

            Log::info('Email enviado exitosamente', [
                'subscriber' => $subscriber->email,
                'producto_id' => $producto->id
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email: ' . $e->getMessage(), [
                'subscriber' => $subscriber->email,
                'producto_id' => $producto->id
            ]);
            
            throw $e;
        }
    }
}
