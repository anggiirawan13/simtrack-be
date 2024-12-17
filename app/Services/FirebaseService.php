<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $firebaseUrl = 'POST https://fcm.googleapis.com/v1/projects/simtrack-mobile/messages:send';
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
    public function sendNotification(array $tokens, string $title, string $body, array $data = null)
    {
        $payload = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data ?? [],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post($this->firebaseUrl, $payload);

        return $response->json();
    }
}
