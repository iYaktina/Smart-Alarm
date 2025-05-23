<?php
require_once __DIR__ . '/Observer/Subject.php';
require_once __DIR__ . '/../Include/config.php'; // Contains TRAFFIC_API_KEY and TRAFFIC_API_URL

class TrafficService implements Subject {
    private array $observers = [];
    private array $trafficData = [];

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    public function notify(): void {
        foreach ($this->observers as $observer) {
            $observer->update($this->trafficData);
        }
    }

    public function fetchTraffic(string $origin, string $destination): array {
        $url = TRAFFIC_API_URL . "?origins=" . urlencode($origin) .
               "&destinations=" . urlencode($destination) .
               "&departure_time=now&traffic_model=best_guess&key=" . TRAFFIC_API_KEY;

        $response = file_get_contents($url);

        if (!$response) {
            $this->trafficData = ['error' => 'Failed to connect to API'];
            $this->notify();
            return $this->trafficData;
        }

        $data = json_decode($response, true);

        // Extract delay in seconds (if available)
        $duration = $data['rows'][0]['elements'][0]['duration']['value'] ?? 0;
        $durationInTraffic = $data['rows'][0]['elements'][0]['duration_in_traffic']['value'] ?? 0;

        $delay = $durationInTraffic - $duration;

        $this->trafficData = [
            'origin' => $origin,
            'destination' => $destination,
            'normal_time_min' => round($duration / 60),
            'traffic_time_min' => round($durationInTraffic / 60),
            'delay_minutes' => round($delay / 60),
            'status' => $delay > 0 ? 'Delayed' : 'Normal'
        ];

        $this->notify();
        return $this->trafficData;
    }
}
