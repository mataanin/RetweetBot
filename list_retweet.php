<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('database.php');

$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

retweet_list(USER, USER_LIST,  2);

function retweet_list($username, $list_name, $num=10) {
    global $conn;

    $search = $conn->get("https://api.twitter.com/1/lists/statuses.json?slug={$list_name}&owner_screen_name={$username}&per_page=30&page=1");

    $chronological = array_reverse($search, true);    
    foreach($chronological as $item) {
        $is_rt = strpos($item->text, 'RT') OR (boolean)$item->retweeted;
        $is_reply = !empty($item->in_reply_to_user_id);
        $new_text_len = strlen($item->text)
            + /* hash symbol */ 1 + strlen(HASHTAG) 
            + strlen(" RT @{$item->user->name} ") ;
        $can_be_padded = 140 <= $new_text_len;


        echo $item->text;
        if ( $is_rt OR $is_reply OR $can_be_padded OR tweet_retweeted($item->id)) {
            echo ' NOT <br />'."\n";
            continue;
        }
            echo $num .' YES <br />'."\n";
        
        if ($num-- <= 0) {
            return;
        }

        $text = "RT @{$item->user->name} " . $item->text;
        if (rand(0, 1) == 0) {
            $text = '#' . HASHTAG . " {$text}";
        } else {
            $text = "{$text} #" . HASHTAG;
        }

        $params = array(
            'status' => $text,
            'in_reply_to_status_id' => $item->id,
        );
        $conn->post('http://api.twitter.com/1/statuses/update.json', $params);
           
        save_tweet($item->id);
    }
}
?>
