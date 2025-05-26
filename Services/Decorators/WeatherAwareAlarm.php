<?php
namespace Services\Decorators;

require_once 'AlarmDecorator.php';
require_once '../../Services/WeatherService.php'; 

class WeatherAwareAlarm extends AlarmDecorator {
    private float $tempMin;
    private float $tempMax;
    private string $city;

    public function __construct(AlarmInterface $alarm, float $tempMin = 0, float $tempMax = 35, string $city = 'Cairo') {
        parent::__construct($alarm);
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->city = $city;
    }

    public function ring(): string {
        $weatherService = new \WeatherService($this->city);
        $weatherData = $weatherService->getWeatherData();

        if ($weatherData && isset($weatherData['temperature_c'])) {
            $temp = $weatherData['temperature_c'];

            if ($temp < $this->tempMin) {
                return "[Weather Checked: Cold] " . $this->alarm->ring() . " [Wake Up Earlier!]";
            } elseif ($temp > $this->tempMax) {
                return "[Weather Checked: Hot] " . $this->alarm->ring() . " [Wake Up Earlier!]";
            } else {
                return "[Weather Checked: Normal] " . $this->alarm->ring();
            }
        }

        return "[Weather Check Failed] " . $this->alarm->ring();
    }
}

?>