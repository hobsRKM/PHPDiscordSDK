[![build](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml)  [![Codacy Security Scan](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/codacy-analysis.yml/badge.svg?branch=master)](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/codacy-analysis.yml)

# PHPDiscordSDK
A Light Weight PHP Discord SDK Library to build Discord Bots with Web Panel

## PHPDiscordSDK
A DiscordSDK  to build Discord Bots using PHP, with Web Panel.
1. [Installation](#Installation)
2. [Getting Started](#getting-started)
3. [Listening to Bot Events](#botphp)
4. [APIs](#APIs)
   1. [SendMessage](#SendMessage)
   2. [GetChannelDetails](#GetChannelDetails)
   3. [UpdateChannelDetails](#UpdateChannelDetails)
   4. [DeletChannel](#DeletChannel)
   5. [Activity](#Presence)
   6. Visit  documentation site for complete list

####  Documentation
**[Complete Docs of PHPDiscordSDK](https://phpdiscordsdk.gitbook.io/)**

####  API Demo with Web Panel Integration
**[discordapidemo.com](https://discordapidemo.com/)**

### Installation

- Requires **PHP >=7.0**

````
composer require phpdiscordsdk/phpdiscordsdk
````
### Getting Started

> To start the bot you need to start it using **CLI (Command Line)**
>
> Once the bot is up and running, you can start using the [APIs](apis)
>
> You can  also use the APIs outside of bot  event listener , but it is recomended to first start the bot using CLI before consuming the APIs
>
> If you want to integerate into a framework and communicate with bot  you can implement something like  Web Panel
>
>  See Example  [(Web Panel)](https://github.com/hobsRKM/DiscordAPIWeb) (Supports both Send and Recieve)

**Start  the bot**
###  ```` $ php bot.php ````

### bot.php

```` php
<?php

require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;

class Bot {

    public function start() {
        PHPDiscordSDKFactory::getInstance()
            ->botConnect(<<<<BOT TOKEN>>>>>)
            ->then(
                function ($bot) {
                    $bot->on('message', function ($event) {
                        PHPDiscordSDKFactory::getInstance()
                        ->formatEvent($event)->then(function($message){
                        //Bot Event Listener
                        //call other APIs
                            print_r($message);//prints server details
                        }, function ($reason) {
                        //message event errors
                    });
                     $bot->on('close', function ($event) {
                       $this->start();
                    });
                });
            },
            function ($reason) {
            //other errors, bot startup, authentication
            }
        );
    }
}

$bot = new Bot();
$bot->start();
````
![bot.php](https://web.inmelodies.in/wp-content/uploads/2021/08/Screenshot_2.png)


## Example  1 - Send Message
#### Calling APIs inside the Bot Listener ( Send Message to Discord)
````php
<?php
require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;

PHPDiscordSDKFactory::getInstance()
	->botConnect("<<<<BOT TOKEN><<<<")
	->then(
		function ($bot) {
			$bot->on('message', function ($event) {
				PHPDiscordSDKFactory::getInstance()
				->formatEvent($event)->then(function($message){
				//Bot Event Listener
				//Server details
				print_r($message);
				/**call Message API**/
				$body = array(
                                        "TYPE"=>"CHANNEL_MESSAGE",
                                        "body"=>array(
                                            "channel_id"=><<YOUR CHANNEL ID>>>,
                                            "content"=>"Test Message"
                                            )
                                        );
				PHPDiscordSDKFactory::getInstance('Messages')
					->sendMessage($body)
					->then(function($data){
						//Sent message details, including message id
						print_r($data);
					}, 
					function ($error) {
						//message event errors
						print_r($error->getMessage());
					});
				}, function ($reason) {
				//message event errors
			});
		});
	},
	function ($reason) {
	//other errors, bot startup, authentication
	}
);

````
## Example  2 - Get Channel Messages
#### Calling APIs From Anywhere outside of   listener( Get Channel Messages)
````php
<?php
require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
  
/**
Required Parameters
**/
$body = array(
        "TYPE"=>"CHANNEL_DETAILS",
        "body"=>array(
            "channel_id"=><<YOUR CHANNEL ID>>>,
            )
        );

PHPDiscordSDKFactory::getInstance('Channels')
	->getChannelMessages($body)
	->then(function($data){
		//Channel Messages
		print_r($data);
	}, 
	function ($error) {
		//message event errors
		print_r($error->getMessage());
		//echo $error->getMessage();	
	});
````

## Important

The following APIs cannot be called outside of Listener

- **Presence**: This is used to Update your bot status such as
   - Online
   - DND
   - AFK
   - Actvity - Streaming, Playing or Watching Status

# APIs

> The bot should have necessary Permissions on Discord Server
>
> Ex: Send message requires Send Message Perms on a channel
>
> For more information on specific permission, check the response body on each APIs.
####  API Demo with Web Panel Integration
**[discordapidemo.com](https://discordapidemo.com/)**
### SendMessage

````php
    require('vendor/autoload.php');

    use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
	
    /**
    Required - Channel Id
    Content - You message, embeds supported - see Example Folder	
    **/
    $body = array(
    "TYPE"=>"CHANNEL_MESSAGE",
    "body"=>array(
        "channel_id"=><<YOUR CHANNEL ID>>>,
        "content"=>"Test Message"
        )
    );
    PHPDiscordSDKFactory::getInstance('Messages')
        ->sendMessage($body)
        ->then(function($data){
            //Sent message details, including message id
            print_r($data);
        }, 
        function ($error) {
            //message event errors
            print_r($error->getMessage());
        });
	
````

### GetChannelDetails

````php
    require('vendor/autoload.php');

    use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
	
    /**
    Required - Channel Id
    **/
    $body = array(
    "TYPE"=>"CHANNEL_DETAILS",
    "body"=>array(
        "channel_id"=><<YOUR CHANNEL ID>>>,
        )
    );
    PHPDiscordSDKFactory::getInstance('Channels')
        ->getChannelDetails($body)
        ->then(function($data){
            //channel details
            print_r($data);
        }, 
        function ($error) {
            //message event errors
            print_r($error->getMessage());
        });

````

### DeleteChannel

````php
    require('vendor/autoload.php');

    use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
	
    /**
    Required - Channel Id
    **/
    $body = array(
    "TYPE"=>"CHANNEL_DETAILS",
    "body"=>array(
        "channel_id"=><<YOUR CHANNEL ID>>>,
        )
    );
    PHPDiscordSDKFactory::getInstance('Channels')
        ->deleteChannel($body)
        ->then(function($data){
            //channel details
            print_r($data);
        }, 
        function ($error) {
            //message event errors
            print_r($error->getMessage());
        });

````

### UpdateChannelDetails

````php
    require('vendor/autoload.php');

    use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
	
	/**
	Required - Channel Id
	Name - New channel Name
	icon - base64 encoded icon
	**/
	$body = array(
	"TYPE"=>"CHANNEL_DETAILS",
	"body"=>array(
		"channel_id"=><<YOUR CHANNEL ID>>>,
		"name"=><<YOUR NEW CHANNEL NAME>>,
		"icon"=><<<BASE 64 ENCODED ICON>>
		)
	);
	PHPDiscordSDKFactory::getInstance('Channels')
		->updateChannelDetails($body)
		->then(function($data){
			//channel details
			print_r($data);
		}, 
		function ($error) {
			//message event errors
			print_r($error->getMessage());
		});

````

### Presence

> Cannot be used outside of bot listener events, has to be used inside the startup script



````php
<?php
require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;

PHPDiscordSDKFactory::getInstance()
            ->botConnect("<<<<BOT TOKEN><<<<")
            ->then( 
                function ($bot) {
                    $bot->on('message', function ($event) {
                        PHPDiscordSDKFactory::getInstance()->formatEvent($event)->then(function($message){
                         //All events sent from client will be available here, including the server details the bot is listening on
                        /**
                        call Presence API
                        The change is not instant, discord has a delay to update your status not to often
                        status - dnd | offline |online | afk
                        type - one of PLAYING,STREAMING,
                        LISTENING,WATCHING,COMPETING
                        **/
                        PHPDiscordSDKFactory::getInstance('Presence')
                        ->setActivity(
                            array(
                                "activity"=>"Playing CS:GO",
                                "status"=>"dnd",
                                "type"=>'PLAYING'
                                )
                            );                        
                        }, function ($reason) {
                            //message event errors
                            print_r($reason->getMessage());
                            //echo $reason->getMessage();
                        });
                    });
                },
                function ($reason) {
                    print_r($reason);
                    //other errors, bot startup, authentication
                }
            );

````
####  Documentation
### **[Complete Docs of PHPDiscordSDK](https://phpdiscordsdk.gitbook.io/)**

### Web Panel
### **[discordapidemo.com](https://github.com/hobsRKM/DiscordAPIWeb)**

> Project is Open for contributions , please feel free to fork

**Contribution Guide**

- All Pull requests should be from a Local Branch of Develop
- Be sure to check out Develop Branch
- Any other pull requests to master  or other branches will be rejected

&copy;MIT License
