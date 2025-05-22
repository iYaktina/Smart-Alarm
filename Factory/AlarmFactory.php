<?php
require_once __DIR__ . '/../Model/Alarm.php';

class AlarmFactory {
    public static function create(string $type): Alarm {
        switch (strtolower($type)) {
            case 'smart':
                require_once __DIR__ . '/../Services/Decorators/WeatherAwareAlarm.php';
                require_once __DIR__ . '/../Services/Decorators/GradualWakeUp.php';

                $alarm = new Alarm();
                $decorated = new WeatherAwareAlarm($alarm);
                $decorated = new GradualWakeUp($decorated);
                return $decorated;

            case 'basic':
            default:
                return new Alarm();  // Core alarm model
        }
    }
}
