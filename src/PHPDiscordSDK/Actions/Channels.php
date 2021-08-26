<?php
namespace HobsRkm\SDK\PHPDiscordSDK\Actions;

use Exception;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Helpers\Rest;
use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Promise\Deferred;
use React\Promise\Promise;

class Channels {
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
            $this->_helper->headers(),
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
        $this->_client->patch(
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
            $this->_helper->headers(),
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());
        });
        return $this->_deferred->promise();
    }
}
