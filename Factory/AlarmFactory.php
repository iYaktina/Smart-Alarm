<?php
require_once __DIR__ . '/../Services/Decorators/BaseAlarm.php';
require_once __DIR__ . '/../Services/Decorators/GradualWakeup.php';

class AlarmFactory {
    public static function create(string $type = 'basic'): \Services\Decorators\AlarmInterface {
        $base = new \Services\Decorators\BaseAlarm();

        switch (strtolower($type)) {
            case 'smart':
                return new \Services\Decorators\GradualWakeup($base);

            case 'basic':
            default:
                return $base;
        }
    }
}
