<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Socket;

use ErrorException;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
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
    public $_constants;
    /**
     * @var null
     */
    public static $_socketState;
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
     * @var Config
     */
    private $_config;

    /**
     * Socket constructor.
     */
    function __construct()
    {
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
        $this->_timer = new Timer();
        $this->_helper = new Console();
        $this->_config = new Config();
    }


    /**
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function connectWS(): Promise
    {
        $this->deferred = new Deferred();
        connect($this->_constants->WS)->then(function ($conn) {
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
    public function authenticateBot(array $body): Promise
    {
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
    private function socketMessageEventReceiver()
    {
        self::$_socketState->on('message', function ($msg) {
            $gatewayData = json_decode($msg, true);
            //if requesting for re-connect, force close the connection and ask for client to reconnect
            if($gatewayData['op']==$this->_constants->OP_CODES->REQUEST_RECONNECT ||
                $gatewayData['op']==$this->_constants->OP_CODES->INVALID_SESSION
            ){
                self::$_socketState->close();
            }

            if (!$this->_timer->isTimerSet()) {
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
    private function socketCloseEventReceiver()
    {
        //if any other close connection codes from Discord except auth error, ask client to re-authenticate
        //Sometimes Discord closes the gateway abnormally, re-auth is a must
        self::$_socketState->on('close', function ($code = null, $reason = null) {
            $this->_connectionError = array(
                "code" => $code,
                "reason" => $reason
            );
            $this->_timer->cancelTimer();
            if($code==$this->_constants->SOCKET_AUTH_ERROR){
                Console::printMessage($reason);
                $this->_timer->cancelTimer();
                die();
            }
            //if abnormally closed with 1006, gateway will still be open
            self::$_socketState->close();
        });
    }


    /**
     * @return null
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    public function socketStateListenerObj()
    {
        return self::$_socketState;
    }


    /**
     * Emit Gateway events
     * @param array $data
     */
    public function emitEvent(array $data)
    {
        self::$_socketState->send(json_encode($data));
    }

}
