<?php
namespace Services\Decorators;

require_once 'AlarmDecorator.php';

class GradualWakeup extends AlarmDecorator {
    public function ring(): string {
        return "[Starting Soft] " . $this->alarm->ring() . " [Volume Increasing]";
    }
}
?>