[![build](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/hobsRKM/PHPDiscordSDK/actions/workflows/php.yml)
# PHPDiscordSDK
A Light Weight PHP Discord SDK Library to build Discord Bots with Web Panel

Requires PHP >=7.0

1. [Installation](Installation)
2. [Getting Started](Getting_Started)
3. [Listening to Bot Events](bot_events)
4. [APIs](APIs)
   1. SendMessage
   2. GetChannelDetails
   3. UpdateChannelDetails
   4.

### Installation
````
composer require
````
### Getting Started

> To start the bot you need to start it using **CLI (Command Line)**
>
> Once the bot is up and running, you can start using the [APIs](apis)
>
> You can  also use the APIs outside of bot  event listener
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

