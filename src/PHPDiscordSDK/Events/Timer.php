<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Events;

use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

class Timer {

    private $_socketState;
    private $_config;
    private  static $_timer = null;

    public function __construct()
    {
        $this->_config = new Config();
    }

    public function startHeartBeat($socketState)
    {
        $this->_socketState = $socketState;
        self::$_timer= Loop::addPeriodicTimer(5, function () {
            $this->_socketState->send(json_encode($this->_config->getGateWayHeartBeatBody()));
        });

    }

    public function isTimerSet(): bool
    {
        return is_object(self::$_timer);
    }
}
