<?php

namespace HobsRkm\SDK\PHPDiscordSDK\Constants;

class Constants
{

    function __construct()
    {
     /*
      * Class constructor
      */
    }

    function allConstants() {
        return (object)array(
            'HEART_BEAT_INTERVAL' => '60000',
            'OS' => 'windows',
            'WS' => 'wss://gateway.discord.gg/',
            'BROWSER' => 'disco',
            'DEVICE' => 'disco',
            'H_CODE' => 11,
            "errors" => (object)array(
                "TOKEN_EMPTY" => "BOT TOKEN CANNOT BE EMPTY ",
                "DISCORD_ERROR" => "Discord Server Error! ",
                "DISCORD_AUTH_ERROR" => "Discord Server Authentication Error! ",
                "GATEWAY_ERROR" => "Couldn't establish connection to discord servers! "
            ),
            "messages" => (object)array(
                "READY" => "BOT is up and running.."
            ),
            "READY" => "READY"
        );
    }

}
