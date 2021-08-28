<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Actions;

use Exception;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Helpers\Rest;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;
use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Promise\Deferred;
use React\Promise\Promise;

class Channels
{
    /**
     * @var Browser
     */
    private $_client;
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
    /**
     * @var Deferred
     */
    private $_deferred;

    /**
     * Channels constructor.
     */
    public function __construct()
    {
        $this->_client = new Browser();
        $this->_constants = (new Constants)->allConstants();
        $this->_helper = new Rest();
        $this->_config = new Config();
    }

    public function getChannelDetails(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->get(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers()
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

    /**
     *
     * For accepted $data['body'] fields
     * refer https://discord.com/developers/docs/resources/channel#modify-channel-json-params-guild-channel
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/22/2021
     */
    public function updateChannelDetails(array $data): Promise
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
     * Date: 8/25/2021
     */
    public function deleteChannel(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->delete(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers()
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());

        });
        return $this->_deferred->promise();
    }

    /**
     * @requires ReadHistory Permission
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/25/2021
     */
    public function getChannelMessages(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->get(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers()
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
     * Date: 8/28/2021
     */
    public function updateChannelPermissons(array $data): Promise
    {
        $this->_deferred = new Deferred();
        if (!empty($data['body'] = $this->validatePermission($data['body']))) {
            $this->_client->put(
                $this->_helper->formatURLParams("CHANNEL", $data),
                $this->_helper->headers(),
                json_encode($data['body'])
            )->then(function (ResponseInterface $response) {
                $this->_deferred->resolve(json_decode((string)$response->getBody()));
            }, function (Exception $e) {
                $this->_deferred->reject($e->getMessage());
            });
        } else {
            Console::printMessage("Invalid Parameters constructed!!");
            $this->_deferred->reject("Invalid Parameters constructed!!");
        }
        return $this->_deferred->promise();
    }

    /**
     * @param array $body
     * @return array
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/28/2021
     */
    private function validatePermission(array $body): array
    {
        $isValidBody = false;
        //optional
        if (isset($body['allow']) && array_key_exists($body['allow'], $this->_constants->PERMISSIONS)) {
            $body['allow'] = $this->_constants->PERMISSIONS[$body['allow']];
            $isValidBody = true;
        }
        //optional
        if (isset($body['deny']) && array_key_exists($body['deny'], $this->_constants->PERMISSIONS)) {
            $body['deny'] = $this->_constants->PERMISSIONS[$body['deny']];
            $isValidBody = true;
        }
        //required
        if (isset($body['type']) && array_key_exists($body['type'], $this->_constants->PERMISSION_TYPE)) {
            $body['type'] = $this->_constants->PERMISSION_TYPE[$body['type']];
        } else {
            $isValidBody = false;
        }
        if ($isValidBody) {
            return $body;
        } else {
            return array();
        }

    }

    function getChannelInvites($data): Promise {
        $this->_deferred = new Deferred();
        $this->_client->get(
            $this->_helper->formatURLParams("CHANNEL", $data),
            $this->_helper->headers()
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());
        });
        return $this->_deferred->promise();
    }
}
