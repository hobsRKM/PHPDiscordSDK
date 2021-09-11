<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Events;

use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;
use Ratchet\RFC6455\Messaging\Frame;
use React\EventLoop\Loop;

class Timer {

    /**
     * @var
     */
    private $_socketState;
    /**
     * @var Config
     */
    private $_config;
    /**
     * @var null
     */
    public static $_timer = null;
    /**
     * @var null
     */
    public static $_ping_timer = null;
    /**
     * @var object
     */
    private $_constants;
    /**
     * @var Console
     */
    private $_helper;

    /**
     * Timer constructor.
     */
    public function __construct()
    {
        $this->_config = new Config();
        $this->_constants =  (new Constants)->allConstants();
        $this->_helper = new Console();
    }

    /**
     * @param $socketState
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function startHeartBeat($socketState)
    {
        self::$_ping_timer =  Loop::addPeriodicTimer($this->_constants->OP_PING, function () use ($socketState) {
            try {
                $socketState->send(new Frame('', true, Frame::OP_PING));
            } catch(\Exception $e ){
                //TODO
            }
        });
        self::$_timer= Loop::addPeriodicTimer( $this->_constants->LOOP_TIMER, function () use ($socketState) {
            $socketState->send(json_encode($this->_config->getGateWayHeartBeatBody()));
            $this->networkPing();
        });

    }

    /**
     * @return bool
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function isTimerSet(): bool
    {
        return is_object(self::$_timer);
    }

    /**
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    private function networkPing() {
        if(!@fsockopen('www.discord.com', 80))
        {
            Console::printMessage($this->_constants->errors->NETWORK_TIMEOUT);
            $this->cancelTimer();
            die();
        }
    }

    /**
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function cancelTimer() {
        Loop::cancelTimer(self::$_timer);
        Loop::cancelTimer(self::$_ping_timer);
        $this->_config->clearToken();
    }
}
