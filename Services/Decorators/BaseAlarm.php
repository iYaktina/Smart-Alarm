<?php
namespace Services\Decorators;

require_once 'AlarmInterface.php';

class BaseAlarm implements AlarmInterface {
    public function ring(): string {
        return "Beep! Beep!"; 
    }
}
