<?php

namespace HobsRkm\SDK\PHPDiscordSDK;

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
     * @return PHPDiscordSDKClient
     */
    public static function getInstance(): PHPDiscordSDKClient
    {
        return new PHPDiscordSDKClient();
    }

}

