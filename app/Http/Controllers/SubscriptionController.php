<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Models\Subscriber;
use Illuminate\Http\Request;

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

        // Guardar en la base de datos local
        Subscriber::create(['email' => $request->email]);


        return redirect()->route('welcome')->with('success', 'Te has suscrito exitosamente.');
 
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
