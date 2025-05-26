<?php
namespace Services\Decorators;

require_once 'AlarmDecorator.php';

class GradualWakeup extends AlarmDecorator {
    private int $startVolume;
    private int $endVolume;
    private int $duration; 

    public function __construct(AlarmInterface $alarm, int $startVolume = 1, int $endVolume = 10, int $duration = 10) {
        parent::__construct($alarm);
        $this->startVolume = $startVolume;
        $this->endVolume = $endVolume;
        $this->duration = $duration;
    }

    public function ring(): string {
        $volumeIncrease = round(($this->endVolume - $this->startVolume) / $this->duration);
        return "[Starting Soft at Volume {$this->startVolume}] " . $this->alarm->ring() . " [Increasing Volume to {$this->endVolume} over {$this->duration} seconds]";
    }
}
?>