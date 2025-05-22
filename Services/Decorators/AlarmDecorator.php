<?php
namespace Services\Decorators;

require_once 'AlarmInterface.php';

abstract class AlarmDecorator implements AlarmInterface {
    protected AlarmInterface $alarm;

    public function __construct(AlarmInterface $alarm) {
        $this->alarm = $alarm;
    }

    public function ring(): string {
        return $this->alarm->ring();
    }
}
?>