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

$authors = latest_tweeps(HASHTAG);

$following = following(USER);
var_dump($authors, $following);

foreach($authors as $id) {

    if (!in_array($id, $following)) {
        $params = array(
            'user_id' => $id,
            'follow' => true,
        );        


        var_dump($conn->post("http://api.twitter.com/1/friendships/create.json", $params));
    }
}

function following($username) {
    global $conn;

    $res = $conn->get("https://api.twitter.com/1/followers/ids.json?cursor=-1&screen_name=" . $username);

    return $res->ids;
} 


function latest_tweeps($name) {
    global $conn;

    $search = $conn->get("http://search.twitter.com/search.json?q=%23{$name}&amp;result_type=recent&amp;rpp=100&amp;page=1");
    

    $authors = array();
    $chronological = array_reverse($search->results, true);    
    foreach($chronological as $item) {
        if ( $item->from_user == USER OR tweet_retweeted($item->id)) {
            continue;
        }
        
        $authors[] = $item->from_user_id;
    }


    return $authors;
}
?>
