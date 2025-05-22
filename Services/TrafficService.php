<?php
require_once __DIR__ . '/Observer/Subject.php';
require_once __DIR__ . '/Observer/Observer.php';

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

    public function fetchTraffic(string $location): array {
        $this->trafficData = [
            'location' => $location,
            'delay' => 10,
            'status' => 'Heavy'
        ];

        $this->notify();
        return $this->trafficData;
    }
}
