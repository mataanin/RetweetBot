<?php
try {
   $dbh = new PDO("sqlite:database.sdb");
} catch(PDOException $e) {
    $e->getMessage();
}

function tweet_retweeted($id) {
   global $dbh;
   $res = $dbh->query("SELECT COUNT(*) FROM tweets WHERE id=".$id);
   return ($res->fetchColumn() > 0);
}

function save_tweet($id) {
   global $dbh;
   return $dbh->query("INSERT INTO tweets(id) VALUES(".$id.")");
}

?>
