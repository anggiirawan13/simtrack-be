<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $firebaseUrl = 'https://fcm.googleapis.com/v1/projects/simtrack-mobile/messages:send';
    protected $serverKey;

    public function __construct()
    {
        // Ambil server key dari file .env
        $this->serverKey = env('FIREBASE_SERVER_KEY');

        if (!$this->serverKey) {
            throw new \Exception('Firebase Server Key is not configured.');
        }
    }

    /**
     * Kirim notifikasi menggunakan Firebase Cloud Messaging.
     *
     * @param array $tokens Array token perangkat tujuan
     * @param string $title Judul notifikasi
     * @param string $body Isi notifikasi
     * @param array|null $data Data tambahan opsional
     * @return mixed
     */
    public function sendNotification($token, string $title, string $body)
    {
        // Prepare the payload for the notification
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body
                ]
            ]
        ];

        // Send the notification via Firebase Cloud Messaging
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->serverKey,  // Use 'key=' for Firebase Cloud Messaging
            'Content-Type' => 'application/json',
        ])->post($this->firebaseUrl, $payload);  // Send the POST request to FCM

        // Return the JSON response from Firebase
        return $response->json();
    }

}
