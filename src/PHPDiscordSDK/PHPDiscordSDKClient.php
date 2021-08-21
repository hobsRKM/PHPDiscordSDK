<?php

namespace HobsRkm\SDK\PHPDiscordSDK;


use Error;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Events\Timer;
use HobsRkm\SDK\PHPDiscordSDK\Socket\Socket;
use InvalidArgumentException;
use React\Promise\Deferred;
use React\Promise\Promise;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;
use Throwable;

/**
 * Class PHPDiscordSDKClient
 * @package HobsRkm\SDK\PHPDiscordSDK
 */
class PHPDiscordSDKClient
{

    /**
     * @var Socket
     */
    private $_socket;
    /**
     * @var Config
     */
    private $_config;
    /**
     * @var object
     */
    private $_constants;
    /**
     * @var
     */
    private $_token;
    /**
     * @var
     */
    private $_deferred;

    /**
     * PHPDiscordSDKClient constructor.
     */
    private $_helper;
    private $_timer;

    function __construct()
    {

        $this->_socket = new Socket();
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
        $this->_config = new Config();
        $this->_helper = new Console();
        $this->_timer = new Timer();
    }


    /**
     * @param string $token
     * @return Promise
     * @throws InvalidArgumentException
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     * Time: 11:14 AM
     */
    public function botConnect(string $token): Promise
    {
        $this->_deferred = new Deferred();
        if (!empty($token)) {
            $this->_token = $token;
            //wait for gateway
            $this->_socket->connectWS()->then(
                function ($msg) {
                    //start authentication
                    $gatewayData = json_decode($msg, true);
                    if (array_key_exists('t', $gatewayData)) {
                        $this->_config->setToken($this->_token);
                        $this->_socket->authenticateBot($this->_config->getGateWayHeartBeatBody())->then(
                            function ($msg) {

                                $data = json_decode($msg, true);
                                if (!empty($data) && $data['t'] == $this->_constants->READY) {
                                    $this->_deferred->resolve($this->_socket->socketStateListenerObj());
                                } else {
                                    $this->_timer->cancelTimer();
                                    $this->_deferred->reject($this->_constants->errors->DISCORD_AUTH_ERROR);
                                }
                            },
                            function (Throwable $reason) {
                                $this->_deferred->reject($this->_constants->errors->DISCORD_AUTH_ERROR.$reason);
                            }
                        );
                    } else {
                        //if gateway response is incorrect, on bootstrap
                        $this->_timer->cancelTimer();
                        throw new Error($this->_constants->errors->DISCORD_ERROR);
                    }
                },
                function (Throwable $reason) {
                    //If gateway socket error has occurred
                    $this->_timer->cancelTimer();
                    Console::printMessage($reason->getMessage());
                }
            );

        } else {
            throw new InvalidArgumentException($this->_constants->errors->TOKEN_EMPTY);
        }
        return $this->_deferred->promise();
    }


    /**
     * @param $event
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     * Time: 11:13 AM
     */
    public function formatEvent($event): Promise {
        $this->_deferred = new Deferred();
        $message = json_decode($event, true);
        if(isset($message) && $message['op'] != $this->_constants->H_CODE && !empty($message['t'])) {
            if(isset($message['d']['name']) && $message['t'] == $this->_constants->GUILD_CREATE) {
                Console::printMessage($this->_constants->messages->READY.$message['d']['name']);
            }
            $this->_deferred->resolve($message);
        }

        return $this->_deferred->promise();
    }


}

