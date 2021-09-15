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

class Reactions
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
     * @param array $data
     * @return Promise
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 9/13/2021
     */
    public function addReaction(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->put(
            $this->_helper->formatURLParams("REACTIONS", $data),
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
     * Date: 9/14/2021
     */
    public function deleteUserReaction(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->delete(
            $this->_helper->formatURLParams("REACTIONS", $data),
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
     * Date: 9/14/2021
     */
    public function getReactions(array $data): Promise
    {
        $this->_deferred = new Deferred();
        $this->_client->get(
            $this->_helper->formatURLParams("REACTIONS", $data),
            $this->_helper->headers()
        )->then(function (ResponseInterface $response) {
            $this->_deferred->resolve(json_decode((string)$response->getBody()));
        }, function (Exception $e) {
            $this->_deferred->reject($e->getMessage());
        });
        return $this->_deferred->promise();
    }

}
