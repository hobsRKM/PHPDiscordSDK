<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Socket;

use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Events\Timer;
use React\Promise\Deferred;
use React\Promise\Promise;
use function Ratchet\Client\connect;

class Socket
{
    /**
     * @var object
     */
    private $_constants;
    public  static $_socketState;
    public $deferred;
    private $_timer;
    function __construct()
    {
        $this->_constants = new Constants();
        $this->_constants =  $this->_constants->allConstants();
        $this->_timer = new Timer();
    }

    /**
     * Connect to discord gateway
     * @throws \Error
     * @return void
     */
    public function connectWS(): Promise
    {
        $this->deferred = new Deferred();
        connect($this->_constants->WS)->then(function ($conn)  {
            self::$_socketState = $conn;
          
           $this->socketMessageEventReceiver();
           $this->socketCloseEventReceiver();
           
        }, function ($e) {
            throw new \Error($this->_constants->errors->GATEWAY_ERROR.$e);
        });
        return $this->deferred->promise();
    }

    public function authenticateBot(Array $body): Promise {
        $this->deferred = new Deferred();
        try {
            self::$_socketState->send(json_encode($body));
        } catch (\ErrorException $e) {
            $this->deferred->reject($e);
        }
        return $this->deferred->promise();
    }

    /**
     * Listen to first incoming events on first bootstrap
     */
    private function socketMessageEventReceiver() {
        self::$_socketState->on('message', function ($msg) {
            if(!$this->_timer->isTimerSet()) {
                $this->_timer->startHeartBeat(self::$_socketState);
            }
            //if a promise to resolve, resolve it , else do nothing
            // required only during bootstrap and authentication for first time
            $this->deferred->resolve($msg);
          
        });
    }

    /**
     * Listen to close socket event
     */
    private function socketCloseEventReceiver() {
        self::$_socketState->on('close', function ($code = null, $reason = null) {
            $connectionClosed = array(
                "code" =>$code,
                "reason" => $reason
            );
            throw new \Error(json_encode($connectionClosed));
        });
    }

    /**
     * @return mixed
     */
    public function socketStateListenerObj() {
        return self::$_socketState;
    }

}
