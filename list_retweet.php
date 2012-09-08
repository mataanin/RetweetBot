<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('database.php');

$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

retweet_list(USER, USER_LIST,  1);

function retweet_list($username, $list_name, $num=10) {
    global $conn;

    $search = $conn->get("https://api.twitter.com/1/lists/statuses.json?slug={$list_name}&owner_screen_name={$username}&per_page=100&page=1");

    $chronological = array_reverse($search, true);    
    foreach($chronological as $item) {
        $is_rt = strpos($item->text, 'RT') OR (boolean)$item->retweeted;
		$is_in_hashtag = strpos($item->text, '#' . HASHTAG);
        $is_reply = !empty($item->in_reply_to_user_id);
        $new_text_len = strlen($item->text);
            + strlen("RT @{$item->user->name} ") ;
        $cant_be_padded = 140 <= $new_text_len;

        if ( $is_in_hashtag OR $is_rt OR $is_reply OR $cant_be_padded OR (boolean)tweet_retweeted($item->id)) {
            continue;
        }
        
		echo "Retweeting " . $item->id . "\n";
 
        $conn->post('http://api.twitter.com/1.1/statuses/retweet/'.$item->id.'.json');
           
        save_tweet($item->id);
		
        if ($num-- <= 0) {
            break;
        }
    }
}
?>
