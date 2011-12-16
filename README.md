Community Hashtag project
=========================

Agenda
------

Two simple php scripts that amplify voice of community. Created as an effort to create critical mass of tweets and visibility for lithuanian startups to use common hashtag for good news and startups relevant tweets. Lets see, how does it develop :) Follow [#LTstartups](https://twitter.com/#!/search?q=%23LTstartups).

How is it supposed to work?
---------------------------

Come up with hashtag name (*warning* it may take a while). Create new tweeter user. Get a few people posting into hashtag. Setup the scripts. Make a list of people, who are supposed to contribute.. wait.. Tweeps from the list will be constantly reminded about the hashtag, as their tweets are retweeted there. Moreover, hashtag is forever not empty. My hypothesis is that it will motivate people to tweet themselves, too.   

Journal for [#LTstartups](https://twitter.com/#!/search?q=%23LTstartups) experiment
----------------------------------

    3   Dec   Discussion for the hashtag name has started  
    8   Dec   1st name chosen
    11  Dec   Dammit! We forgot to use the urban dictionary.
    15  Dec   Pivot to another name.
    16  Dec   Scripts put on a crontab

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
