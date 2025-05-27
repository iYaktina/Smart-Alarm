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

   

    private function adjustTimeForWeather(string $alarmTime, int $adjustmentMinutes): string {
        $formattedTime = date('H:i:s', strtotime($alarmTime));
        $time = strtotime($formattedTime);
        $adjustedTime = strtotime("{$adjustmentMinutes} minutes", $time);
        return date("H:i:s", $adjustedTime);
    }

}
