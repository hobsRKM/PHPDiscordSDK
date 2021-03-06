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
    /**
     * @var Browser
     */
    private $_client;
    /**
     * @var
     */
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
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers(),
            json_encode($data['body'])
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

    /**
     * @requires channel id and message id and manage Channel Permissions
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/27/2021
     */
    public function updateChannelMessage(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->patch(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers(),
            json_encode($data['body'])
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

    /**
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 9/13/2021
     */
    public function deleteMessage(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->delete(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers(),
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

    /**
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 9/13/2021
     */
    public function deleteMessageBulk(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->post(
            $this->_helper->formatURLParams("CHANNEL", $data),
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
