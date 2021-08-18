<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Config;

use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;

/**
 * Class Config
 * @package HobsRkm\SDK\PHPDiscordSDK\Config
 */
class Config
{

    /**
     * @var
     */
    private static $_token;

    /**
     * @var object
     */
    private $_constants;

    function __construct()
    {
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
    }

    /**
     * @return array
     */
    function getGateWayBody(): array
    {
        return array(
            "op" => 2,
            "d" => array(
                "heartbeat_interval" => $this->_constants->HEART_BEAT_INTERVAL,
                "token" => self::$_token,
                "properties" => array(
                    '$os' => $this->_constants->OS,
                    '$browser' => $this->_constants->BROWSER,
                    '$device' => $this->_constants->DEVICE
                )
            )
        );
    }

    /**
     * @return array
     */
    function getGateWayHeartBeatBody(): array
    {
        return array(
            "op" => 1,
            "d" => 251
        );
    }

    /**
     * @param string $token
     */
    function setToken(string $token)
    {
        self::$_token = $token;
    }


}
