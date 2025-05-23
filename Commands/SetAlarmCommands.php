<?php
require_once __DIR__ . '/../Factory/AlarmFactory.php';

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
        ?float $tempMax = null
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
    }

    public function execute(): bool {
        $alarm = AlarmFactory::create($this->type);  

        return $alarm->create(
            $this->userId,
            $this->time,
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
    }
}
?>
