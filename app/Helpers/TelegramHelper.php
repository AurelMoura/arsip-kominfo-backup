<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    /**
     * Kirim pesan ke Telegram
     */
    public static function kirimTelegram($pesan)
    {
        try {
            $token = config('services.telegram.token');
            $chat_id = config('services.telegram.chat_id');

            if (!$token || !$chat_id) {
                \Log::warning('Telegram credentials belum dikonfigurasi', [
                    'token' => !$token ? 'empty' : 'set',
                    'chat_id' => !$chat_id ? 'empty' : 'set'
                ]);
                return false;
            }

            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            \Log::info('Mengirim pesan Telegram', [
                'url' => $url,
                'chat_id' => $chat_id,
                'message' => $pesan
            ]);

            // Gunakan GET request dengan verifyFalse untuk menghindari SSL error di Laragon/Windows
            $response = Http::withoutVerifying()->get($url, [
                'chat_id' => $chat_id,
                'text' => $pesan,
                'parse_mode' => 'Markdown'
            ]);

            \Log::info('Respons Telegram', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            \Log::error('Error kirim Telegram', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }
}
