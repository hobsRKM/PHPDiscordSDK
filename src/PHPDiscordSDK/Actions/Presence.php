<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Actions;

use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Socket\Socket;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;

class Presence
{
    /**
     * @var Socket
     */
    private $_socket;
    /**
     * @var object
     */
    private $_constants;

    /**
     * Presence constructor.
     */
    public function __construct()
    {
        $this->_socket = new Socket();
        $this->_constants = new Constants();
        $this->_constants = $this->_constants->allConstants();
    }

    public function setActivity(array $body)
    {

        if (array_key_exists("activity", $body) &&
            array_key_exists("status", $body) &&
            array_key_exists("type", $body) &&
            in_array($body['type'],array_flip($this->_constants->PRESENCE_CODE))) {
            $data = $this->prepareActivity($body);
            $this->_socket->emitEvent($data);
        } else {
            Console::printMessage($this->_constants->errors->PRESENCE_ERROR);
        }
    }

    public function prepareActivity(array $body): array
    {

        return array(
            "op" => $this->_constants->OP_CODES->PRESENCE,
            "d" => array(
                "since" => $this->_constants->SINCE,
                "activities" => array(
                    array(
                        "name" => $body['activity'],
                        "type" => $this->_constants->PRESENCE_CODE[$body['type']]
                    )
                ),
                "status" => $body['status'],
                "afk" => false
            )
        );

    }


}
