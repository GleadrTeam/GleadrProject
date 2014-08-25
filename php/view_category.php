<?php
session_start();
include_once("sqlconnect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | Viewing Categories</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Viewing Category</h1>
    <?php
    if(!isset($_SESSION['uid'])) {
        echo '<form action="login.php" method="post">' .
            '<label for="username">Username:</label>' .
            '<input type="text" name="username" id="username"/>' .
            '<label for="pass">Password:</label>' .
            '<input type="password" name="pass" id="pass"/>' .
            '<input type="submit" name="sub" value="Log In"/>' .
            '</form>';
    } else {
        echo '<p>You are logged in as ' . "<a href='user_profile.php?uid=" . $_SESSION['uid'] .
            "'>" . $_SESSION['username'] ."</a>&nbsp;&bull;&nbsp;" . " <a href='logout.php'>Logout</a>";
    }
    ?>
    <form action="search_posts.php" method="get" class="search-bar">
        <input type="text" name="search" id="search-bar"/>
        <input type="submit" name="submitSearch" value="Search"/>
    </form>
    <hr/>
    <div id="content">
        <?php
        $cid = $_GET['cid'];

        if(isset($_SESSION['uid'])) {
            $logged = " | <a href='create_topic.php?cid=".$cid."'>Click Here to Create a Topic</a>";
        } else {
            $logged = " | Please login to create topics in this forum";
        }
        $sql = "SELECT id FROM categories WHERE id='".$cid."' LIMIT 1";
        $res = mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($res) == 1) {
            $sql2 = "SELECT * FROM topics WHERE category_id='".$cid."' ORDER BY topic_reply_date DESC";
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
                    $title = $row['topic_title'];
                    $views = $row['topic_views'];
                    $date = $row['topic_date'];
                    $creator = $row['topic_creator'];
                    $topics .= "<tr><td><a href='view_topic.php?cid=" . $cid . "&tid=" . $tid . "'>" . htmlentities($title) . "</a><br/>";
                    $topics .= "<span class='post_info'>Posted by: " . htmlentities($creator) . " on " . $date . "</span></td>";
                    $topics .= "<td align='center'>0</td><td align='center'>" . $views . "</td></tr>";
                    $topics .= "<tr><td colspan='3'><hr/></td></tr>";
                }
                $topics .= "</table>";
                echo $topics;
            } else {
                echo "<a href='index.php'>Return To Forum Index</a><hr/>";
                echo "<p>There are no topics in this category yet." . $logged . "</p>";
            }
        } else {
            echo "<a href='index.php'>Return To Forum Index</a><hr/>";
            echo "<p>You are trying to view a category that doesn`t exist yet";
        }
        ?>
    </div>
</div>
</body>
</html>