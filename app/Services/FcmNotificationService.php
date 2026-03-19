<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmNotificationService
{
    private const FCM_URL = 'https://fcm.googleapis.com/fcm/send';

    private function serverKey(): string
    {
        return config('nativephp.fcm.server_key', '');
    }

    /**
     * Send a push notification to ALL registered devices (all admin users).
     * Used when a business event occurs (new order, product added, etc.)
     */
    public function sendToAll(string $title, string $body, array $data = []): void
    {
        $tokens = DeviceToken::pluck('token')->toArray();

        if (empty($tokens) || empty($this->serverKey())) {
            return;
        }

        $this->dispatch($tokens, $title, $body, $data);
    }

    /**
     * Send a push notification to a specific user's devices.
     */
    public function sendToUser(int $userId, string $title, string $body, array $data = []): void
    {
        $tokens = DeviceToken::where('user_id', $userId)->pluck('token')->toArray();

        if (empty($tokens) || empty($this->serverKey())) {
            return;
        }

        $this->dispatch($tokens, $title, $body, $data);
    }

    /**
     * Core dispatcher — sends to an array of FCM tokens.
     * Automatically removes expired/invalid tokens from the DB.
     */
    private function dispatch(array $tokens, string $title, string $body, array $data): void
    {
        // FCM allows max 1000 registration IDs per request
        foreach (array_chunk($tokens, 1000) as $chunk) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'key=' . $this->serverKey(),
                    'Content-Type'  => 'application/json',
                ])->post(self::FCM_URL, [
                    'registration_ids' => $chunk,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                        'sound' => 'default',
                    ],
                    'data' => array_merge($data, ['click_action' => 'FLUTTER_NOTIFICATION_CLICK']),
                    'android' => [
                        'priority' => 'high',
                        'notification' => [
                            'channel_id' => 'farsanhub_channel',
                            'color'      => '#e63946',
                            'sound'      => 'default',
                        ],
                    ],
                ]);

                $result = $response->json();

                // Clean up stale tokens reported by FCM
                if (!empty($result['results'])) {
                    foreach ($result['results'] as $i => $r) {
                        if (isset($r['error']) && in_array($r['error'], ['InvalidRegistration', 'NotRegistered'])) {
                            DeviceToken::where('token', $chunk[$i])->delete();
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::error('FCM dispatch error: ' . $e->getMessage());
            }
        }
    }
}
