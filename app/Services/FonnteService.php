<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Token API Fonnte
     */
    protected ?string $token;

    /**
     * Endpoint URL API Fonnte
     */
    protected string $url;

    public function __construct()
    {
        $this->token = config('services.fonnte.token') ?? env('FONNTE_TOKEN');
        $this->url = config('services.fonnte.url') ?? env('FONNTE_URL', 'https://api.fonnte.com/send_message');
    }

    /**
     * Normalisasi nomor telepon ke format yang diterima oleh Fonnte / WhatsApp
     */
    public function formatPhoneNumber(string $phone): string
    {
        // Hapus karakter selain angka
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Kirim pesan WhatsApp menggunakan API Fonnte
     *
     * @param string $target Nomor tujuan
     * @param string $message Isi pesan
     * @return array [success => bool, message => string, data => mixed]
     */
    public function sendMessage(string $target, string $message): array
    {
        $formattedPhone = $this->formatPhoneNumber($target);

        if (empty($formattedPhone)) {
            return [
                'success' => false,
                'message' => 'Nomor WhatsApp tujuan tidak valid.',
            ];
        }

        // Jika token belum diset (misal di lokal atau testing)
        if (empty($this->token)) {
            Log::info("[FonnteService Simulation] FONNTE_TOKEN belum diatur. Simulasi pengiriman pesan ke {$formattedPhone}:\n{$message}");

            // Jika dalam environment local atau testing, kita anggap sukses agar alur testing tetap bisa berjalan
            if (app()->environment('local', 'testing')) {
                return [
                    'success' => true,
                    'simulated' => true,
                    'message' => 'Simulasi berhasil (FONNTE_TOKEN belum diisi di .env).',
                ];
            }

            return [
                'success' => false,
                'message' => 'Konfigurasi FONNTE_TOKEN belum diatur pada file .env server.',
            ];
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => $this->token,
                ])
                ->post($this->url, [
                    'target'      => $formattedPhone,
                    'message'     => $message,
                    'countryCode' => '62',
                ]);

            $result = $response->json();

            // Cek apakah response status true dari Fonnte
            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                Log::info("[FonnteService] Pesan WhatsApp berhasil dikirim ke {$formattedPhone}");
                return [
                    'success' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim.',
                    'data'    => $result,
                ];
            }

            // Jika response Fonnte false
            $errorDetail = $result['reason'] ?? $result['message'] ?? 'Gagal mengirim pesan melalui Fonnte.';
            Log::warning("[FonnteService] Gagal kirim WA ke {$formattedPhone}: {$errorDetail}", [
                'response' => $result,
            ]);

            return [
                'success' => false,
                'message' => $errorDetail,
                'data'    => $result,
            ];
        } catch (\Throwable $e) {
            Log::error("[FonnteService] Exception saat menghubungi API Fonnte: " . $e->getMessage(), [
                'target' => $formattedPhone,
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi server WhatsApp: ' . $e->getMessage(),
            ];
        }
    }
}
