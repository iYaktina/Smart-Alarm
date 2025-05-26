<?php
require_once __DIR__ . '/../Include/config.php';

class WeatherService {
    private string $city;

    public function __construct(string $city = 'Cairo') {
        $this->city = $city;
    }

    public function getWeatherData(): ?array {
        $apiKey = WEATHER_API_KEY;
        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($this->city) . "&appid=" . $apiKey;

        $response = file_get_contents($url);

        if (!$response) return null;

        $data = json_decode($response, true);

        if (!isset($data['main']['temp'])) return null;

        $tempCelsius = round($data['main']['temp'] - 273.15, 1);
        $condition = $data['weather'][0]['main'] ?? 'Unknown';

        return [
            'temperature_c' => $tempCelsius,
            'condition' => $condition,
        ];
    }
}
?>