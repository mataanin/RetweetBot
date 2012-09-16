<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('database.php');

$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

try {
   $dbh = new PDO("sqlite:database.sdb");
} catch(PDOException $e) {
    echo $e->getMessage();
}

$blacklist = $conn->get("https://api.twitter.com/1/lists/members.json?slug=".BLACKLIST."&owner_screen_name=".USER."&cursor=-1");

retweet_hashtag(HASHTAG, 1);

function in_black_list($uid) {
	global $blacklist;

	foreach($blacklist->users as $user) {
			
		if ($user->id === $uid) {
			return true;
		}
	}
	
	return false;
}

function retweet_hashtag($name, $num=10) {
    global $conn, $dbh;

    $search = $conn->get("http://search.twitter.com/search.json?q=%23{$name}&amp;result_type=recent&amp;rpp=100&amp;page=1");

    $chronological = array_reverse($search->results, true);    
    foreach($chronological as $item) {

        if ($item->from_user == USER OR 
			tweet_retweeted($item->id) OR 
			in_black_list($item->from_user_id)) {
            continue;
        }
 
		echo "Retweeting " . $item->id . "\n";
        $conn->post('http://api.twitter.com/1.1/statuses/retweet/'.$item->id.'.json');
           
        save_tweet($item->id);
		
		if (--$num <= 0) {
			break;
		}
    }
}
?>
