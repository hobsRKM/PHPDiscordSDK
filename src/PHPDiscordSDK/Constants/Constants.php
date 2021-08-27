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
    public function allConstants()
    {
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
                "NETWORK_TIMEOUT" => "BOT was stopped / Interrupted due to network timeout ",
                "PRESENCE_ERROR"=>"Incorrect Usage for Activity status Update parameters. Expected activity, status and type"
            ),
            "messages" => (object)array(
                "READY" => "BOT is up and running on.."
            ),
            "READY" => "READY",
            "SOCKET_DC_CODE" => 1001,
            "GUILD_CREATE" => "GUILD_CREATE",
            "PRESENCE_UPDATE" => "PRESENCE_UPDATE",
            "SINCE"=>91879201,
            "PRESENCE_CODE"=>array(
              "PLAYING"=>0,
              "STREAMING"=>1,
              "WATCHING"=>3,
              "LISTENING"=>2,
              "COMPETING"=>5
            ),
            "OP_CODES" => (object)array(
                "H_CODE" => 11,
                "IDENTIFY" => 2,
                "HEARTBEAT" => 1,
                "PRESENCE" => 3,
                "VOICE_STATE" => 4,
                "RESUME" => 5,
                "RECONNECT" => 6,
                "GUILD_MEMBERS" => 7,
                "INVALID_SESSION" => 8,
                "HELLO" => 9
            )
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
                "CHANNEL_MESSAGE" => "/channels/:channel_id:/messages",
                "CHANNEL_DETAILS" => "/channels/:channel_id:",
                "CHANNEL_MESSAGE_DETAILS"=>"/channels/:channel_id:/messages/:message_id:",
            )
        );
    }


}
