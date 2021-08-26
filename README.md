[![build](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml)
# PHPDiscordSDK
A Light Weight PHP Discord SDK Library to build Discord Bots with Web Panel

## PHPDiscordSDK
A DiscordSDK  to build Discord Bots using PHP, with Web Panel.
1. [Installation](Installation)
2. [Getting Started](Getting_Started)
3. [Listening to Bot Events](bot_events)
4. [APIs](APIs)
   1. [SendMessage](SendMessage)
   2. [GetChannelDetails](GetChannelDetails)
   3. [UpdateChannelDetails](UpdateChannelDetails)
   4. [DeletChannel](DeletChannel)
   5. [Activity](Presence)
   6. More coming soon....

### Installation

- Requires **PHP >=7.0**

````
composer require hobsrkm/phpdiscordsdk
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
>  See Example  [(Web Panel)](Web_Panel) (Supports both Send and Recieve)

**Start  the bot**
###  ```` $ php bot.php ````

### bot.php

```` php
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
				//call other APIs
					print_r($message);//prints server details
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
![bot.php](https://web.inmelodies.in/wp-content/uploads/2021/08/Screenshot_2.png)


## Example  1 - Send Message
#### Calling APIs inside the Bot Listener ( Send Message to Discord)
````php
<?php
require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
use \HobsRkm\SDK\PHPDiscordSDK\Actions\Channels;

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
use \HobsRkm\SDK\PHPDiscordSDK\Actions\Channels;
  
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

### SendMessage

````php
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
	}, function ($reason) {
	//message event errors
	});
});
````

### GetChannelDetails

````php
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
	}, function ($reason) {
	//message event errors
	});
});
````

### DeleteChannel

````php
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
	}, function ($reason) {
	//message event errors
	});
});
````

### UpdateChannelDetails

````php
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
	}, function ($reason) {
	//message event errors
	});
});
````

### Presence

> Cannot be used outside of bot listener events, has to be used inside the startup script



````php
<?php
require('vendor/autoload.php');

use \HobsRkm\SDK\PHPDiscordSDK\PHPDiscordSDKFactory;
use \HobsRkm\SDK\PHPDiscordSDK\Actions\Channels;

PHPDiscordSDKFactory::getInstance()
	->botConnect("<<<<BOT TOKEN><<<<")
	->then(
		function ($bot) {
			$bot->on('message', function ($event) {
				PHPDiscordSDKFactory::getInstance()
				->formatEvent($event)->then(function($message){
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
		},
		function ($reason) {
		//other errors, bot startup, authentication
		}
);

````
### Web Panel
Coming Soon - Under Development

> Project is Open for contributions , please feel free to fork


&copy;MIT License
