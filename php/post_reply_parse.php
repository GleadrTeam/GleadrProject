<?php
session_start();
include_once("mySQLConnect.php");
if(isset($_SESSION['uid'])) {
    if(isset($_POST['reply_submit'])) {
        $creator = $_SESSION['uid'];
        $cid = $_POST['cid'];
        $tid = $_POST['tid'];
        $reply_content = htmlentities(addslashes($_POST['reply_content']));
        $userids = array();

        $sql = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES " .
            "('".$cid."', '".$tid."', '".$creator."', '".$reply_content."', now())";
        $res = mysql_query($sql) or die(mysql_error());

        $sql2 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' " .
            "LIMIT 1";

        $res2 = mysql_query($sql2) or die(mysql_error());

        $sql3 = "UPDATE topics SET topic_reply_date=now(), topic_last_user='".$creator."' WHERE id='".$tid."' " .
            "LIMIT 1";

        $res3 = mysql_query($sql3) or die(mysql_error());

        // Email Sending
        /*$sql4 = "SELECT post_creator FROM posts WHERE category_id='".$cid."' AND '".$tid."' GROUP BY post_creator";

        $res4 = mysql_query($sql4) or die(mysql_error());

        while($row4 = mysql_fetch_assoc($res4)) {
            $userids[] .= $row4['post_creator'];
        }

        //runs through all the users and gets the id and email
        foreach ($userids as $key ) {
            //forum notification - if the flag is set to 1, the user agrees on notifications on reply
            $sql5 = "SELECT id, email FROM users WHERE id='".$key."' AND forum_notification='1' LIMIT 1";
            $res5 = mysql_query($sql5) or die(mysql_error());
            if(mysql_num_rows($res5) > 0) {
                $row5 = mysql_fetch_assoc($res5);
                //if the responce is not from the creator himself add it to email address string
                if($row5['id'] == $creator) {
                    $email[] = $row5['email'];
                }
            }
        }
        $email = implode(', ', $email);

        $to = "valericfbg@gmail.com";
        $from = "valericfbg@gmail.com";
        $bcc = "valericfbg@gmail.com";
        $subject = "There was a reply on a post that you are subscribed to!";
        $message = "Someone has replied to a topic. Please check it out!";
        $header = "From: $from\r\nReply-To: $from";
        $header .= "\r\nBcc: ($bcc)";

        mail($to, $subject, $message, $header);*/


        if($res && $res2 && $res3) {
            echo "<p>Your reply has been successfully posted</p><a href='view_topic.php?cid=" . $cid . "&tid=" . $tid .
                "'>Click here to return to topic</a>";
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