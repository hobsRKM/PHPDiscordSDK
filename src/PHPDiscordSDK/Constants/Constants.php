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
            'HEART_BEAT_INTERVAL' => '45000',
            "LOOP_TIMER" => '46',
            'OS' => 'windows',
            'WS' => 'wss://gateway.discord.gg/',
            'BROWSER' => 'disco',
            'DEVICE' => 'disco',
            'H_CODE' => 11,
            'OP_PING' => 5,
            "errors" => (object)array(
                "TOKEN_EMPTY" => "BOT TOKEN CANNOT BE EMPTY ",
                "DISCORD_ERROR" => "Discord Server Error! ",
                "DISCORD_AUTH_ERROR" => "Discord Server Authentication Error! ",
                "GATEWAY_ERROR" => "Couldn't establish connection to discord servers! ",
                "NETWORK_TIMEOUT" => "BOT was stopped / Interrupted due to network timeout ",
                "PRESENCE_ERROR" => "Incorrect Usage for Activity status Update parameters. Expected activity, status and type"
            ),
            "messages" => (object)array(
                "READY" => "BOT is up and running on.."
            ),
            "READY" => "READY",
            "SOCKET_DC_CODE" => 1001,
            "SOCKET_DC_SESSION_CODE" => 1000,
            "SOCKET_AUTH_ERROR" => 4004,
            "SOCKET_ERROR" => 1006,
            "GUILD_CREATE" => "GUILD_CREATE",
            "PRESENCE_UPDATE" => "PRESENCE_UPDATE",
            "SINCE" => 91879201,
            "PRESENCE_CODE" => array(
                "PLAYING" => 0,
                "STREAMING" => 1,
                "WATCHING" => 3,
                "LISTENING" => 2,
                "COMPETING" => 5
            ),
            "OP_CODES" => (object)array(
                "H_CODE" => 11,
                "IDENTIFY" => 2,
                "HEARTBEAT" => 1,
                "PRESENCE" => 3,
                "VOICE_STATE" => 4,
                "RESUME" => 6,
                "GUILD_MEMBERS" => 8,
                "INVALID_SESSION" => 9,
                "GATEWAY" => 10,
                "REQUEST_RECONNECT" => 7
            ),
            "PERMISSIONS" => array(
                "CREATE_INSTANT_INVITE" => 0,
                "KICK_MEMBERS" => 1,
                "BAN_MEMBERS" => 2,
                "ADMINISTRATOR " => 3,
                "MANAGE_CHANNELS" => 4,
                "MANAGE_GUILD" => 5,
                "ADD_REACTIONS" => 6,
                "VIEW_AUDIT_LOG" => 7,
                "PRIORITY_SPEAKER" => 8,
                "STREAM" => 9,
                "VIEW_CHANNEL" => 10,
                "SEND_MESSAGES" => 11,
                "SEND_TTS_MESSAGES" => 12,
                "MANAGE_MESSAGES" => 13,
                "EMBED_LINKS" => 14,
                "ATTACH_FILES" => 15,
                "READ_MESSAGE_HISTORY" => 16,
                "MENTION_EVERYONE" => 17,
                "USE_EXTERNAL_EMOJIS" => 18,
                "VIEW_GUILD_INSIGHTS" => 19,
                "CONNECT" => 20,
                "SPEAK" => 21,
                "MUTE_MEMBERS" => 22,
                "DEAFEN_MEMBERS" => 23,
                "MOVE_MEMBERS" => 24,
                "USE_VAD" => 25,
                "CHANGE_NICKNAME" => 26,
                "MANAGE_NICKNAMES" => 27,
                "MANAGE_ROLES" => 28,
                "MANAGE_WEBHOOKS" => 29,
                "MANAGE_EMOJIS_AND_STICKERS" => 30,
                "USE_APPLICATION_COMMANDS" => 31,
                "REQUEST_TO_SPEAK" => 32,
                "MANAGE_THREADS" => 34,
                "USE_PUBLIC_THREADS" => 35,
                "USE_PRIVATE_THREADS" => 36,
                "USE_EXTERNAL_STICKERS" => 37

            ),
            "PERMISSION_TYPE" => array(
                "ROLE" => 0,
                "MEMBER" => 1
            )
        );
    }


    /**
     * @return object
     * @author: Yuvaraj Mudaliar ( @HobsRKM )
     * Date: 8/21/2021
     */
    function rest(): object
    {
        return (object)array(
            "API_EP" => "https://discordapp.com/api",
            "CHANNEL" => (object)array(
                "CHANNEL_MESSAGE" => "/channels/:channel_id:/messages",
                "CHANNEL_DETAILS" => "/channels/:channel_id:",
                "CHANNEL_MESSAGE_DETAILS" => "/channels/:channel_id:/messages/:message_id:",
                "CHANNEL_MESSAGE_UPDATE" => "/channels/:channel_id:/messages/:message_id:",
                "CHANNEL_PERMISSIONS" => "/channels/:channel_id:/permissions/:overwrite_id:",
                "CHANNEL_INVITES" => "/channels/:channel_id:/invites",
                "CHANNEL_DELETE_MESSAGE" => "/channels/:channel_id:/messages/:message_id:",
                "CHANNEL_DELETE_MESSAGE_BULK" => "/channels/:channel_id:/messages/bulk-delete",
            ),
            "REACTIONS" => (object)array(
                "CREATE_REACTION" => "/channels/:channel_id:/messages/:message_id:/reactions/:emoji:/@me",
                "DELETE_REACTION" => "/channels/:channel_id:/messages/:message_id:/reactions/:emoji:/:user_id:",
                "GET_REACTIONS" => "/channels/:channel_id:/messages/:message_id:/reactions/:emoji:"
            )
        );
    }


}
