<?php

namespace HobsRkm\SDK\PHPDiscordSDK;


use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Socket\Socket;
use React\Promise\Deferred;
use React\Promise\Promise;

require_once 'Constants/Constants.php';

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
    function __construct()
    {

        $this->_socket = new Socket();
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
        $this->_config = new Config();
    }



    /**
     * @param string $token
     * @return Promise
     * @throws \Error
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
                        $this->_config->getGateWayBody();
                        $this->_socket->authenticateBot($this->_config->getGateWayBody())->then(
                            function ($msg) {
                                $data = json_decode($msg, true);
                                if (!empty($data) && $data['t'] == $this->_constants->READY) {
                                    $this->_deferred->resolve($this->_socket->socketStateListenerObj());
                                } else {
                                    $this->_deferred->resolve($this->_constants->errors->DISCORD_AUTH_ERROR);
                                }
                            },
                            function (\Throwable $reason) {
                                $this->_deferred->resolve($this->_constants->errors->DISCORD_AUTH_ERROR.$reason);
                            }
                        );
                    } else {
                        throw new \Error($this->_constants->errors->DISCORD_ERROR);
                    }
                },
                function (\Throwable $reason) {
                    throw new \Error($reason);
                }
            );

        } else {
            throw new \Error($this->_constants->errors->TOKEN_EMPTY);
        }
        return $this->_deferred->promise();
    }

    /**
     * @param $event
     * @return Promise
     */
    public function formatEvent($event): Promise {
        $this->_deferred = new Deferred();
        $message = json_decode($event, true);
        if(isset($message) && $message['op'] != $this->_constants->H_CODE && !empty($message['t'])) {
            if(isset($message['d']['name']) && $message['t'] == 'GUILD_CREATE') {
                $this->printConsoleMessage("The bot is online on ".$message['d']['name']);
            }
            $this->_deferred->resolve($message);
        }

        return $this->_deferred->promise();
    }

    private function printConsoleMessage($message)
    {
        echo $message;
    }
}

