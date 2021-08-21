<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Helpers;

use Exception;
use HobsRkm\SDK\PHPDiscordSDK\Config\Config;
use HobsRkm\SDK\PHPDiscordSDK\Constants\Constants;
use HobsRkm\SDK\PHPDiscordSDK\Utils\Console;
use ValueError;

class Rest
{

    /**
     * @var \string[][]
     */
    private $_constants;
    /**
     * @var Config
     */
    private $_config;

    public function __construct()
    {
        $this->_constants = (new Constants)->rest();
        $this->_config = new Config();
    }


    /**
     * @param string $route
     * @param array $data
     * @return string
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/19/2021
     */
    public function formatURLParams(string $route, array $data): string
    {
        $type = $data['TYPE'];
        $ep =  $this->_constants->$route->$type;
        try {
            preg_match_all('#:(.*?):#', $ep, $match);
            foreach ($match[0] as $key => $value) {
                $ep = str_replace($value, $data['body'][$match[1][$key]], $ep);
            }
            $ep = $this->_constants->API_EP . $ep;
        } catch(Exception $e) {
          throw new ValueError("Malformed Request params");
        }
        return  $ep;
    }


    /**
     * @return string[]
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/19/2021
     */
    public function headers(): array
    {
        if(empty($this->_config->getToken())){
            Console::printMessage("Unauthorized Access, Ensure Bot is up and running!");
            exit();
        }
        return array(
            "Authorization" => "Bot ".$this->_config->getToken(),
            'Content-Type' => 'application/json'
        );
    }
}
