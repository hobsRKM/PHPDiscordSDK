<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Socket;

use ErrorException;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Events\Timer;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;
use React\Promise\Deferred;
use React\Promise\Promise;
use Throwable;
use function Ratchet\Client\connect;

class Socket
{
    /**
     * @var object
     */
    private $_constants;
    /**
     * @var null
     */
    public  static $_socketState;
    /**
     * @var
     */
    public $deferred;
    /**
     * @var Timer
     */
    private $_timer;
    /**
     * @var
     */
    private $_connectionError;
    /**
     * @var Console
     */
    private $_helper;

    /**
     * Socket constructor.
     */
    function __construct()
    {
        $this->_constants = new Constants();
        $this->_constants =  $this->_constants->allConstants();
        $this->_timer = new Timer();
        self::$_socketState = null;
        $this->_helper = new Console();
    }


    /**
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function connectWS(): Promise
    {
        $this->deferred = new Deferred();
        connect($this->_constants->WS)->then(function ($conn)  {
            self::$_socketState = $conn;
          
           $this->socketMessageEventReceiver();
           $this->socketCloseEventReceiver();
           
        }, function ($e) {
            $this->deferred->reject($e);
        });
        return $this->deferred->promise();
    }

    /**
     * @param array $body
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function authenticateBot(Array $body): Promise {
        $this->deferred = new Deferred();
        try {
            self::$_socketState->send(json_encode($body));
        } catch (ErrorException $e) {
            $this->deferred->reject($e);
        }
        return $this->deferred->promise();
    }


    /**
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
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
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    private function socketCloseEventReceiver() {
        self::$_socketState->on('close', function ($code = null, $reason = null) {
            $this->_connectionError = array(
                "code" =>$code,
                "reason" => $reason
            );
            //re connect try
            if($code == $this->_constants->SOCKET_DC_CODE) {
                $this->connectWS()->then(function(){
                    //DO NOTHING
                },function(Throwable $reason){
                   Console::printMessage($reason->getMessage());
                   $this->_timer->cancelTimer();
                });
            }
        });
    }


    /**
     * @return null
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function socketStateListenerObj() {
        return self::$_socketState;
    }

}
