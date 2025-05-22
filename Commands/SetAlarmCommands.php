<?php
require_once __DIR__ . '/../Factory/AlarmFactory.php';

class SetAlarmCommand {
    private int $userId;
    private string $time;
    private string $type;
    private string $tone;
    private int $volume;

    public function __construct(int $userId, string $time, string $type = 'basic', string $tone = 'default', int $volume = 5) {
        $this->userId = $userId;
        $this->time = $time;
        $this->type = $type;
        $this->tone = $tone;
        $this->volume = $volume;
    }

    public function execute(): bool {
        $alarm = AlarmFactory::create($this->type);
        return $alarm->create($this->userId, $this->time, $this->type, $this->tone, $this->volume);
    }
}
