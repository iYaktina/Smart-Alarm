<?php
require_once '../../Model/Alarm.php';
require_once '../../Factory/AlarmFactory.php';
require_once '../../Services/Strategy/WeatherStrategy.php';
require_once '../../Services/WeatherService.php';
require_once '../../Services/TrafficService.php';
require_once '../../Services/Observer/AlarmManager.php';

class SetAlarmCommand {
    private int $userId;
    private string $time;
    private string $type;
    private string $tone;
    private int $volume;

    private bool $useTraffic;
    private ?string $trafficStart;
    private ?string $trafficEnd;

    private bool $useWeather;
    private ?float $tempMin;
    private ?float $tempMax;
    private ?string $city;

    public function __construct(
        int $userId,
        string $time,
        string $type = 'basic',
        string $tone = 'default',
        int $volume = 5,
        bool $useTraffic = false,
        ?string $trafficStart = null,
        ?string $trafficEnd = null,
        bool $useWeather = false,
        ?float $tempMin = null,
        ?float $tempMax = null,
        ?string $city = 'Cairo'
    ) {
        $this->userId = $userId;
        $this->time = $time;
        $this->type = $type;
        $this->tone = $tone;
        $this->volume = $volume;

        $this->useTraffic = $useTraffic;
        $this->trafficStart = $trafficStart;
        $this->trafficEnd = $trafficEnd;

        $this->useWeather = $useWeather;
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->city = $city;
    }

    public function execute(): bool {
        $alarmModel = new Alarm();
        $finalTime = $this->time;

        if ($this->useWeather && $this->tempMin !== null && $this->tempMax !== null) {
            $weatherStrategy = new \WeatherStrategy($this->tempMin, $this->tempMax, $this->city);
            $finalTime = $weatherStrategy->calculateWakeUpTime($this->time);
        }

        $alarmInstance = \AlarmFactory::create($this->type);
        $ringPreview = $alarmInstance->ring(); 

        $success = $alarmModel->create(
            $this->userId,
            $finalTime,
            $this->type,
            $this->tone,
            $this->volume,
            $this->useTraffic,
            $this->trafficStart,
            $this->trafficEnd,
            $this->useWeather,
            $this->tempMin,
            $this->tempMax
        );

        if ($success && $this->useTraffic && $this->trafficStart && $this->trafficEnd) {
            $alarmId = $alarmModel->getLastInsertedId();
            $trafficService = new \TrafficService();
            $alarmManager = new \AlarmManager();
            $trafficService->attach($alarmManager);

            $trafficService->fetchTraffic(
                $this->trafficStart,
                $this->trafficEnd,
                $finalTime,
                $alarmId
            );
        }

        return $success;
    }
}
