<?php
require_once __DIR__ . '/../Services/WeatherService.php';
require_once __DIR__ . '/../Services/TrafficService.php';

class ApiController {
    public function getWeather() {
        $weatherService = new WeatherService();
        $data = $weatherService->fetchWeather("Cairo");
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getTraffic() {
        $trafficService = new TrafficService();
        $data = $trafficService->fetchTraffic("Your-Location");
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

