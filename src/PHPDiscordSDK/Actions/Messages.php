<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Actions;

require __DIR__ . '/../../../vendor/autoload.php';


use Exception;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Helpers\Rest;

use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Promise\Deferred;
use React\Promise\Promise;

class Messages
{

    private $_client;
    private $_deferred;
    /**
     * @var object
     */
    private $_constants;
    /**
     * @var Rest
     */
    private $_helper;
    /**
     * @var Config
     */
    private $_config;

    public function __construct()
    {
        $this->_client = new Browser();
        $this->_constants = (new Constants)->allConstants();
        $this->_helper = new Rest();
        $this->_config = new Config();
    }

    /**
     * @requires SendMessage Permission on Discord
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/25/2021
     */
    public function sendMessage(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->post(
            (new Rest)->formatURLParams("CHANNEL", $data),
            $this->_helper->headers(),
            json_encode($data['body'])
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

}
