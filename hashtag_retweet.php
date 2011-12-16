<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

try {
   $dbh = new PDO("sqlite:database.sdb");
} catch(PDOException $e) {
    echo $e->getMessage();
}

retweet_hashtag(HASHTAG, 1);

function retweet_hashtag($name, $num=10) {
    global $conn;

    $search = $conn->get("http://search.twitter.com/search.json?q=%23{$name}&amp;result_type=recent&amp;rpp=100&amp;page=1");

    $chronological = array_reverse($search->results, true);    
    foreach($chronological as $item) {
        if ( $item->from_user == USER OR tweet_retweeted($item->id) OR $num-- <= 0) {
            continue;
        }
 
        $conn->post('http://api.twitter.com/1/statuses/retweet/'.$item->id.'.json');
           
        save_tweet($item->id);
    }
}

function tweet_retweeted($id) {
   global $dbh;
   $res = $dbh->query("SELECT COUNT(*) FROM tweets WHERE id=".$id);

   return $res->fetchColumn() > 0;
}

function save_tweet($id) {
   global $dbh;
   return $dbh->query("INSERT INTO tweets(id) VALUES(".$id.")");
}

?>
