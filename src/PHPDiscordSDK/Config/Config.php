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
    public static $_token = null;

    /**
     * @var object
     */
    private $_constants;
    /**
     * @var string
     */
    private $_settings;

    /**
     * Config constructor.
     */
    function __construct()
    {
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
        $this->_settings = dirname(__DIR__, 1) . "/settings.ini";
    }


    /**
     * @return array
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    function getGateWayBody(): array
    {
        return array(
            "op" => $this->_constants->OP_CODES->IDENTIFY,
            "d" => array(
                "heartbeat_interval" => $this->_constants->HEART_BEAT_INTERVAL,
                "token" => self::$_token,
                "properties" => array(
                    '$os' => $this->_constants->OS,
                    '$browser' => $this->_constants->BROWSER,
                    '$device' => $this->_constants->DEVICE
                ),

            ),
        );
    }


    /**
     * @return int[]
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    function getGateWayHeartBeatBody(): array
    {
        return array(
            "op" => $this->_constants->OP_CODES->HEARTBEAT,
            "d" => 251
        );
    }


    /**
     * @param string $token
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    function setToken(string $token)
    {
        self::$_token = $token;
        $this->saveToken();
    }

    /**
     * @return string
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function getToken(): string
    {
        $data = parse_ini_file($this->_settings);
        return isset($data['token'])?$data['token']:"";
    }

    /**
     * Save the token for HTTP Requests,
     * especially if the requests are sent outside of socket listener
     *
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function saveToken()
    {

        $fp = fopen($this->_settings,"w");
        ftruncate($fp, 0);
        fwrite($fp, "token=".self::$_token);
        fclose($fp);
    }

    /**
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function clearToken() {
        $fp = fopen($this->_settings,"w");
        ftruncate($fp, 0);
        fclose($fp);
    }


}
