<?php
require_once 'WakeUpStrategy.php';
require_once '../../Include/config.php'; // Include config for API key
require_once '../../Services/WeatherService.php';
class WeatherStrategy implements WakeUpStrategy {
    private float $tempMin;
    private float $tempMax;
    private string $city;

    public function __construct(float $tempMin = 0, float $tempMax = 35, string $city = 'Cairo') {
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->city = $city;
    }

    public function calculateWakeUpTime(string $alarmTime): string {
    $formattedTime = date('H:i:s', strtotime($alarmTime));

    $weatherService = new \WeatherService($this->city);
    $weatherData = $weatherService->getWeatherData();

    if ($weatherData && isset($weatherData['temperature_c'])) {
        $currentTempCelsius = $weatherData['temperature_c'];

        if ($currentTempCelsius < $this->tempMin || $currentTempCelsius > $this->tempMax) {
            return $this->adjustTimeForWeather($formattedTime, -10);
        } else {
            return $this->adjustTimeForWeather($formattedTime, 0);
        }
    }

    return $this->adjustTimeForWeather($formattedTime, 0);
}

    private function getWeatherData(): ?array {
        $apiKey = WEATHER_API_KEY; // Defined in config.php
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$this->city}&appid={$apiKey}";

        // Use cURL to fetch the data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the response is valid
        if ($response) {
            return json_decode($response, true);
        }

        return null; // In case of error or failure
    }

    private function adjustTimeForWeather(string $alarmTime, int $adjustmentMinutes): string {
        // Normalize the time input first
        $formattedTime = date('H:i:s', strtotime($alarmTime));
        $time = strtotime($formattedTime);
        $adjustedTime = strtotime("{$adjustmentMinutes} minutes", $time);
        return date("H:i:s", $adjustedTime);
    }

}
