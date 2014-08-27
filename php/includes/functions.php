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
        $topics .= "<table class='table table-striped' width='100%' style='border-collapse: collapse;' id='topics-table'>";
        $topics .= "<tr style='background-color:#dddddd;'><td>TOPIC TITLE</td><td width='65' align='center'>REPLIES</td>";
        $topics .= "<td width='65' align='center'>VIEWS</td></tr>";

        while($row = mysql_fetch_assoc($res2)) {
            $tid = $row['id'];
	    $result = mysql_query("SELECT COUNT(id) FROM posts WHERE category_id='{$cid}' AND topic_id='{$tid}'") or die(mysql_error());
            $title = $row['topic_title'];
            $views = $row['topic_views'];
            $date = $row['topic_date'];
            $creator = $row['topic_creator'];
            $topics .= "<tr><td><a href='view_topic.php?cid=" . $cid . "&tid=" . $tid . "'><span class='glyphicon glyphicon-file'></span> " . htmlentities($title) . "</a><br/>";
            $topics .= "<span class='post_info'>Posted by: " . htmlentities($creator) . " on " . $date . "</span></td>";
            $topics .= "<td align='center'>" . mysql_result($result, 0) . "</td><td align='center'>" . $views . "</td></tr>";
        }
        $topics .= "</table>";
        echo $topics;
    } else {
        echo "<a href='index.php'>Back </a><hr/>";
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
        echo "<table class='table table-striped'>";

        while($row = mysql_fetch_assoc($res)) {
            $sql2 = "SELECT * FROM posts WHERE category_id='".$cid."' AND topic_id='{$tid}' LIMIT {$start}, {$perPage}";
            $res2 = mysql_query($sql2) or die(mysql_error());
            while($row2 = mysql_fetch_assoc($res2)) {
                echo "<tr><td><div class='content' style='min-height: 150px; '</td> <h4>" .
                    htmlentities($row['topic_title']) . "<br/><small>by " . htmlentities($row2['post_creator']) .
                    " - " . $row2['post_date'] .
                    "</small></h4><div class='well well-small pull-right voteBox' style='text-align: center; color: grey;'><form  action='' method='post'>" .
                    "<input type='hidden' name='like' value='" . $row2['id'] . "'/>" .
                    "<input type='submit' class='btn btn-success btn-small voteBtn' style='width:100%'  name='likeBtn' value='Vote +'/>" .
                    "</form> ";
                echo $row2['votes'];
                echo "<form action='' method='post'>" .
                    "<input type='hidden' name='dislike' value='" . $row2['id'] . "'/>" .
                    "<input type='submit' class='btn btn-default btn-small voteBtn' style='width:100%' name='dislikeBtn' value='Vote -'/>" .
                    "</form></div>" .
                    "<hr/>" .
                    htmlentities($row2['post_content']) .
                    "</div></td><td width='200' valign='top' align='center'>" .
                    '<img src="data:image/jpeg;base64,'.base64_encode( getImage($row2['post_creator']) ).'" style="border-radius: 15px; margin: 25px 0;" height="120" width="120"/>';

            }
            if(isset($_SESSION['uid'])) {echo "<tr><td colspan='2'><input type='submit' class='btn btn-default pull-right'  value='POST REPLY'" .
                "onclick=\"window.location = 'post_reply.php?cid=" . $cid . "&tid=" . $tid . "'\" />";}
            else {
                echo '<tr><td colspan="2"><p>Log in to post reply.</p><hr/></td></tr>';
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

function getCurrentCategory($cid) {
    $sql = "SELECT * FROM categories WHERE id={$cid}";
    $result = mysql_query($sql) or die(mysql_error());

    $row = mysql_fetch_assoc($result);
    return $row['category_title'];
}
?>