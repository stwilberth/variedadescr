<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{

    public function index()
    {
        $subscribers = Subscriber::all();
        return view('subscribers.index', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Por favor verifica que no eres un robot.',
        ]);

        // Validar reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        
        if (!$recaptchaResponse) {
            return back()->withErrors(['g-recaptcha-response' => 'Por favor verifica que no eres un robot.']);
        }

        // Generar token de confirmación
        $token = Str::random(60);
        
        // Guardar en la base de datos local como no confirmado
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'confirmation_token' => $token,
            'is_confirmed' => false
        ]);

        // Enviar correo de confirmación
        $this->sendConfirmationEmail($subscriber);

        return redirect()->route('welcome')->with('success', 'Te has enviado un correo de confirmación. Por favor revisa tu bandeja de entrada.');
    }

    // Método para enviar el correo de confirmación
    private function sendConfirmationEmail($subscriber)
    {
        $confirmationLink = route('subscription.confirm', ['token' => $subscriber->confirmation_token]);
        
        Mail::send('emails.confirm-subscription', ['confirmationLink' => $confirmationLink], function ($message) use ($subscriber) {
            $message->to($subscriber->email)
                    ->subject('Confirma tu suscripción');
        });
    }

    // Método para confirmar la suscripción
    public function confirm($token)
    {
        $subscriber = Subscriber::where('confirmation_token', $token)->first();
        
        if (!$subscriber) {
            return redirect()->route('welcome')->with('error', 'El enlace de confirmación no es válido.');
        }
        
        $subscriber->is_confirmed = true;
        $subscriber->confirmation_token = null;
        $subscriber->save();
        
        return redirect()->route('welcome')->with('success', 'Tu suscripción ha sido confirmada exitosamente.');
    }

    //create
    public function create(Request $request)
    {
        return view('subscribers.create');
    }

    //edit
    public function edit(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', $id)->firstOrFail();
        return view('subscribers.edit', compact('subscriber'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate(['new_email' => 'required|email|unique:subscribers,email']);

        try {
            $subscriber = Subscriber::where('id', $id)->firstOrFail();
            
            // Actualizar en la base de datos local
            $subscriber->email = $request->new_email;
            $subscriber->save();

            // Actualizar en MailerLite
            $this->mailerLiteService->updateSubscriber($email, $request->new_email);

            return redirect()->route('subscriptionsIndex')->with('success', 'Suscriptor actualizado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar suscriptor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al actualizar el suscriptor. Por favor intenta más tarde.');
        }
    }

    //delete
    public function delete(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', $id)->firstOrFail();
        return view('subscribers.delete', compact('subscriber'));
    }

    //destroy
    public function destroy($id)
    {

        // Buscar el suscriptor
        $subscriber = Subscriber::where('id', $id)->firstOrFail();

        // Eliminar de la base de datos local
        $subscriber->delete();


        return redirect()->route('home')->with('success', 'Suscriptor eliminado exitosamente.');

    }

}
