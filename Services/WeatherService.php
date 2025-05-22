<?php
require_once __DIR__ . '/Observer/Subject.php';
require_once __DIR__ . '/Observer/Observer.php';
require_once __DIR__ . '/Observer/AlarmManager.php';

class WeatherService implements Subject {
    private array $observers = [];
    private array $weatherData = [];

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    public function notify(): void {
        foreach ($this->observers as $observer) {
            $observer->update($this->weatherData);
        }
    }

    public function fetchWeather(string $city): array {
        // Placeholder (normally you'd use CURL to call OpenWeatherMap API)
        $this->weatherData = [
            'city' => $city,
            'temperature' => 22,
            'condition' => 'Sunny'
        ];

        $this->notify(); // notify all observers
        return $this->weatherData;
    }
}
