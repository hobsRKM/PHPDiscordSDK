<?php

namespace HobsRkm\SDK\PHPDiscordSDK;


use HobsRkm\SDK\PHPDiscordSDK\Actions\Channels;
use HobsRkm\SDK\PHPDiscordSDK\Actions\Messages;
use HobsRkm\SDK\PHPDiscordSDK\Actions\Presence;
use HobsRkm\SDK\PHPDiscordSDK\Actions\Reactions;

/**
 * Class PHPDiscordSDKFactory
 * @package HobsRkm\SDK\PHPDiscordSDK
 */
class PHPDiscordSDKFactory
{

    /**
     * PHPDiscordSDKFactory constructor.
     */
    function __construct()
    {
        //DO Nothing
    }

    /**
     * @param string|null $instanceType
     * @return PHPDiscordSDKClient| Messages | Presence | Channels
     */
    public static function getInstance(string $instanceType=null)
    {
        switch($instanceType){
            case "Messages":
                $instance = new Messages();
                break;
            case "Presence":
                $instance =  new Presence();
                break;
            case "Channels":
                $instance =  new Channels();
                break;
            case "Reactions":
                $instance =  new Reactions();
                break;
            default:
                $instance =  new PHPDiscordSDKClient();
        }
        return $instance;

    }



}

