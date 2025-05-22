<?php
namespace Services\Decorators;

require_once 'AlarmDecorator.php';

class WeatherAwareAlarm extends AlarmDecorator {
    public function ring(): string {
        return "[Weather Checked] " . $this->alarm->ring();
    }
}
?>