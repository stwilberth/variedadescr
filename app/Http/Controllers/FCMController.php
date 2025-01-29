<?php

namespace anuncielo\Http\Controllers;

use Illuminate\Http\Request;
use anuncielo\Models\FcmToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\FirebaseCloudMessaging;

class FCMController extends Controller
{
    private $accessToken;

    public function __construct()
    {
        $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/firebase-service-account.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        
        $this->accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
    }

    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $userId = auth()->id(); // Será null para usuarios no autenticados
        
        FcmToken::updateOrCreate(
            ['token' => $request->token],
            [
                'user_id' => $userId,
                'topic' => 'all'
            ]
        );

        return response()->json(['message' => 'Token saved successfully']);
    }

    public function sendNotificationToAll($title, $body, $data = [])
    {
        $tokens = FcmToken::pluck('token')->toArray();
        
        if (empty($tokens)) {
            return false;
        }

        return $this->sendToTokens($tokens, $title, $body, $data);
    }

    public function sendNotificationToUser($userId, $title, $body, $data = [])
    {
        $tokens = FcmToken::where('user_id', $userId)->pluck('token')->toArray();
        
        if (empty($tokens)) {
            return false;
        }

        return $this->sendToTokens($tokens, $title, $body, $data);
    }

    private function sendToTokens($tokens, $title, $body, $data = [])
    {
        Log::info('Sending FCM notification', [
            'tokens' => $tokens,
            'title' => $title,
            'body' => $body,
            'data' => $data
        ]);

        $projectId = config('services.firebase.project_id');
        
        $response = Http::withToken($this->accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'tokens' => $tokens,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $data,
                    'webpush' => [
                        'headers' => [
                            'Urgency' => 'high'
                        ],
                        'notification' => [
                            'icon' => '/icon.png'
                        ]
                    ]
                ]
            ]);

        Log::info('FCM Response', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        return $response->successful();
    }

    public function sendNotification(Request $request)
    {
        try {
            $url = 'https://fcm.googleapis.com/v1/projects/variedadescr-com/messages:send';
            
            // Validar los datos de entrada
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'topic' => 'nullable|string|max:255'
            ]);

            // Obtener tokens registrados
            $tokens = FcmToken::pluck('token')->toArray();
            Log::info('Tokens disponibles:', ['count' => count($tokens), 'tokens' => $tokens]);

            if (empty($tokens)) {
                return back()->with('error', 'No hay dispositivos registrados para recibir notificaciones.');
            }

            // Construir el mensaje base
            $notification = [
                'message' => [
                    'notification' => [
                        'title' => $request->title,
                        'body' => $request->body
                    ],
                    'webpush' => [
                        'headers' => [
                            'Urgency' => 'high'
                        ],
                        'notification' => [
                            'title' => $request->title,
                            'body' => $request->body,
                            'icon' => '/icon.png',
                            'click_action' => url('/'),
                            'badge' => '/badge.png',
                            'vibrate' => [100, 50, 100],
                            'renotify' => true,
                            'requireInteraction' => true,
                            'tag' => 'notification-' . time()
                        ],
                        'fcm_options' => [
                            'link' => url('/')
                        ]
                    ]
                ]
            ];

            // Enviar a cada token individualmente para mejor tracking
            $successCount = 0;
            $failureCount = 0;
            $errors = [];

            foreach ($tokens as $token) {
                $notification['message']['token'] = $token;
                
                Log::info('Enviando notificación a token:', [
                    'token' => $token,
                    'payload' => $notification
                ]);

                $response = Http::withToken($this->accessToken)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                    ])
                    ->post($url, $notification);

                Log::info('Respuesta FCM para token:', [
                    'token' => $token,
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                if ($response->successful()) {
                    $successCount++;
                } else {
                    $failureCount++;
                    $errors[] = [
                        'token' => $token,
                        'error' => $response->json()['error']['message'] ?? 'Error desconocido'
                    ];
                }
            }

            if ($successCount > 0) {
                $message = "Notificación enviada correctamente a {$successCount} dispositivo(s)";
                if ($failureCount > 0) {
                    $message .= ". Falló en {$failureCount} dispositivo(s).";
                }
                return back()->with('success', $message);
            }

            Log::error('Errores al enviar notificaciones:', ['errors' => $errors]);
            return back()->with('error', 'Error al enviar las notificaciones: ' . collect($errors)->pluck('error')->implode(', '));

        } catch (\Exception $e) {
            Log::error('Exception al enviar notificación FCM', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error al enviar la notificación: ' . $e->getMessage());
        }
    }
}
