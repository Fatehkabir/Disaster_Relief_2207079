<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    public function getWeatherForCity(string $city): ?array
    {
        try {
            $apiKey = config('services.openweather.key');
            if (empty($apiKey) || $apiKey === 'your_key_here') {
                return null;
            }

            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q'     => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'temp'        => $data['main']['temp'] ?? null,
                    'description' => $data['weather'][0]['description'] ?? null,
                    'icon'        => $data['weather'][0]['icon'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Weather Service error: ' . $e->getMessage());
        }

        return null;
    }
}
