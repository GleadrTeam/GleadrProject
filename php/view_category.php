<?php
session_start();
include_once("sqlconnect.php");
$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
//we want n posts per page
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
            fetchTopics($cid, $page, 5, $logged);

            $totalPages = ceil(fetchTotalTopics($cid) / 5);

            for($i = 1; $i <= $totalPages; $i++) {
                echo " <a href =\"view_category.php?cid={$cid}&page={$i}\">{$i}</a> ";
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