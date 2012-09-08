Community Hashtag project
=========================

Agenda
------

Two simple php scripts that amplify voice of community. Created as an effort to create critical mass of tweets and visibility for lithuanian startups to use common hashtag for good news and startups relevant tweets. Lets see, how does it develop :) 

Follow 
	[#LTstartups](https://twitter.com/#!/search?q=%23LTstartups).
	[lithuanian-startups](https://twitter.com/#!/LStartuper/lithuanian-startups)

How is it supposed to work?
---------------------------

Come up with hashtag name (*warning* it may take a while). Create new tweeter user. Get a few people posting into hashtag. Setup the scripts. Make a list of people, who are supposed to contribute.. wait.. 

Features
	1. Retweets not blacklisted tweeps in the hashtag
	2. Retweets startups from the list
	3. Auto-follows tweeps who use the hashtag


Journal for [#LTstartups](https://twitter.com/#!/search?q=%23LTstartups) experiment
----------------------------------

    3   Dec   Discussion for the hashtag name has started  
    8   Dec   1st name chosen
    11  Dec   Dammit! We forgot to use the urban dictionary.
    15  Dec   Pivot to another name.
    16  Dec   Scripts put on a crontab
	18	Dec	  Terminated the script due to naming disputes
	7	Aug	  Hashtag is alive... but full of tweets by organisations and local accelerator
	8	Aug   Restarting project with a blacklist.

Requirements
------------

 * sqlite
 * php pdo sqlite3 extension
 * php curl extension

Installation
------------

1. git clone git://github.com/mataanin/RetweetBot.git
2. create an application at https://dev.twitter.com/apps and generate access token for Read & Write.
3. cp config.php.example config.php
4. edit config.php and fill credentials from https://dev.twitter.com/ as well as your hashtag, list name and username
5. setup cron job via your hosting provider or using the crontab
6. ...
7. profit 
