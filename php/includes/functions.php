<?php
// This file is the place to store all basic functions

function mysql_prep($value){
    return mysql_real_escape_string(stripslashes($value));
}

function validate_datetime ($datetime)
{
    if ( function_exists('date_default_timezone_set') ) {
        date_default_timezone_set('GMT');
    }
    return strtotime($datetime) !== -1;
}

function searchPosts($term) {
    $keywords = preg_split("/\s+/", mysql_real_escape_string($term));

    $title_where = "topic_title LIKE '%". implode("%' OR topic_title LIKE '%", $keywords) ."%'";

    $sql = "SELECT topic_title, category_id FROM topics WHERE {$title_where}";
    $result = mysql_query($sql) or die(mysql_error());
    $results = array();

    while($row = mysql_fetch_assoc($result)) {
        $results[] = $row;
    }

    return $results;
}


function fetchTopics($cid, $page, $perPage, $logged) {
    // minus one because if we want 1 page and 5 per page we`ll get 1 (1*5) and the starting index should be 0
    $start = (int) ($page - 1) * $perPage;
    //to prevend SQL inj
    $perPage = (int) $perPage;
    //LIMIT will get the starting row (arg 1 ) and the number of topics (arg 2)
    $sql2 = "SELECT * FROM topics WHERE category_id='".$cid."' ORDER BY topic_reply_date ASC LIMIT {$start}, {$perPage}";
    $res2 = mysql_query($sql2) or die(mysql_error());
    $topics = '';
    if(mysql_num_rows($res2) > 0) {
        $topics .= "<table width='100%' style='border-collapse: collapse;' id='topics-table'>";
        $topics .= "<tr><td colspan='3'><a href='index.php'>Return To Forum Index</a>" . $logged . "<hr/></td></tr>";
        $topics .= "<tr style='background-color:#dddddd;'><td>Topic Title</td><td width='65' align='center'>Replies</td>";
        $topics .= "<td width='65' align='center'>Views</td></tr>";
        $topics .= "<tr><td colspan='3'><hr/></td></tr>";

        while($row = mysql_fetch_assoc($res2)) {
            $tid = $row['id'];
	    $result = mysql_query("SELECT COUNT(id) FROM posts WHERE category_id='{$cid}' AND topic_id='{$tid}'") or die(mysql_error());
            $title = $row['topic_title'];
            $views = $row['topic_views'];
            $date = $row['topic_date'];
            $creator = $row['topic_creator'];
            $topics .= "<tr><td><a href='view_topic.php?cid=" . $cid . "&tid=" . $tid . "'>" . htmlentities($title) . "</a><br/>";
            $topics .= "<span class='post_info'>Posted by: " . htmlentities($creator) . " on " . $date . "</span></td>";
            $topics .= "<td align='center'>" . mysql_result($result, 0) . "</td><td align='center'>" . $views . "</td></tr>";
            $topics .= "<tr><td colspan='3'><hr/></td></tr>";
        }
        $topics .= "</table>";
        echo $topics;
    } else {
        echo "<a href='index.php'>Return To Forum Index</a><hr/>";
        echo "<p>There are no topics in this category yet." . $logged . "</p>";
    }
}

function fetchTotalTopics($cid) {
    $result = mysql_query("SELECT COUNT(id) FROM topics WHERE category_id={$cid}") or die(mysql_error());

    return mysql_result($result, 0);
}

function fetchPosts($cid, $tid, $page, $perPage) {
    // minus one because if we want 1 page and 5 per page we`ll get 1 (1*5) and the starting index should be 0
    $start = (int) ($page - 1) * $perPage;
    //to prevend SQL inj
    $perPage = (int) $perPage;
    $sql = "SELECT * FROM topics WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
    $res = mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($res) == 1) {
        echo "<table width='100%'>";
        if(isset($_SESSION['uid'])) {echo "<tr><td colspan='2'><input type='submit' value='Add Reply'" .
            "onclick=\"window.location = 'post_reply.php?cid=" . $cid . "&tid=" . $tid . "'\" /><hr/>";}
        else {
            echo '<tr><td colspan="2"><p>Please login to post your reply</p><hr/></td></tr>';
        }
        while($row = mysql_fetch_assoc($res)) {
            $sql2 = "SELECT * FROM posts WHERE category_id='".$cid."' AND topic_id='{$tid}' LIMIT {$start}, {$perPage}";
            $res2 = mysql_query($sql2) or die(mysql_error());
            while($row2 = mysql_fetch_assoc($res2)) {
                echo "<tr><td valign='top' style='1px solid #000000;'><div style='min-height: 125px;'</td>" .
                    htmlentities($row['topic_title']) . "<br/>by " . htmlentities($row2['post_creator']) .
                    " - " . $row2['post_date'] .
                    "&nbsp;&nbsp;&nbsp;<form action='' method='post'>" .
                    "<input type='hidden' name='like' value='" . $row2['id'] . "'/>" .
                    "<input type='submit' name='likeBtn' value='Upvote'/>" .
                    "</form>&nbsp;&nbsp;&bull;&nbsp;&nbsp;";
                echo $row2['votes'];
                echo "&nbsp;&nbsp;&bull;&nbsp;&nbsp;" .
                    "<form action='' method='post'>" .
                    "<input type='hidden' name='dislike' value='" . $row2['id'] . "'/>" .
                    "<input type='submit' name='dislikeBtn' value='Downvote'/>" .
                    "</form>" .


                    "<hr/>" .
                    htmlentities($row2['post_content']) .
                    "</div></td><td width='200' valign='top' align='center' style='border:1px solid #000'>" .
                    '<img src="data:image/jpeg;base64,'.base64_encode( getImage($row2['post_creator']) ).'" height="210" width="200"/>' .
                    "</td></tr><tr><td colspan='2'><hr /></td></tr>";
            }
            $old_views = $row['topic_views'];
            $new_views = $old_views + 1;
            $sql3 = "UPDATE topics SET topic_views='".$new_views."' WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
            $res3 = mysql_query($sql3) or die(mysql_error());
        }
        echo "</table>";
    } else {
        echo "This topic does not exist!";
    }


}

function getPostsCount($cid, $tid) {
    $result = mysql_query("SELECT COUNT(id) FROM posts WHERE category_id={$cid} AND topic_id={$tid}") or die(mysql_error());

    return mysql_result($result, 0);
}

?>