<?php
session_start();
include_once("sqlconnect.php");
if(isset($_SESSION['uid'])) {
    if(isset($_POST['reply_submit'])) {
        $creator = $_SESSION['uid'];
        $cid = $_POST['cid'];
        $tid = $_POST['tid'];
        $reply_content = trim(mysql_prep($_POST['reply_content']));
        $userids = array();

        $sql = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES " .
            "('".$cid."', '".$tid."', '".getUsername($creator)."', '".$reply_content."', now())";
        $res = mysql_query($sql) or die(mysql_error());

        $sql2 = "UPDATE categories SET last_post_date=now(), last_user_posted='".getUsername($creator)."' WHERE id='".$cid."' " .
            "LIMIT 1";

        $res2 = mysql_query($sql2) or die(mysql_error());

        $sql3 = "UPDATE topics SET topic_reply_date=now(), topic_last_user='".getUsername($creator)."' WHERE id='".$tid."' " .
            "LIMIT 1";

        $res3 = mysql_query($sql3) or die(mysql_error());

        if($res && $res2 && $res3) {
            $urlToGo = 'Location: view_topic.php?cid=' . $cid . "&tid=" . "$tid";
            header($urlToGo);
        } else {
            echo "There was a problem posting your response. Try again later";
        }

    } else {
        echo '<h1>This page is out of your reach</h1>';
        echo "</br><a href='index.php'>Return To Main Page</a>";
    }
} else {
    exit();
}

?>