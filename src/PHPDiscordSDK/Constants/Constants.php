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

    /**
     * @return object
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
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
                "GATEWAY_ERROR" => "Couldn't establish connection to discord servers! ",
                "NETWORK_TIMEOUT" => "BOT was stopped / Interrupted due to network timeout "
            ),
            "messages" => (object)array(
                "READY" => "BOT is up and running on.."
            ),
            "READY" => "READY",
            "SOCKET_DC_CODE" => 1001,
            "GUILD_CREATE" => "GUILD_CREATE"
        );
    }


    /**
     * @return object
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    function rest()
    {
        return (object)array(
            "API_EP" => "https://discordapp.com/api",
            "CHANNEL"=>(object)array(
                "CREATE_MESSAGE" => "/channels/:channel_id:/messages"
            )
        );
    }




}
