<?php
session_start();
include_once("sqlconnect.php");
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
if(isset($_POST['like'])) {
    $voting = addVotes($_POST['like']);
    header('Location: ' . $actual_link);
}

if(isset($_POST['dislike'])) {
    $voting = subVotes($_POST['dislike']);
    header('Location: ' . $actual_link);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | View Topics</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Viewing Topic</h1>
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
        $cid = $_GET['cid'];
        echo '<p>You are logged in as ' . "<a href='user_profile.php?uid=" . $_SESSION['uid'] .
            "'>" . $_SESSION['username'] ."</a>&nbsp;&bull;&nbsp;" . " <a href='logout.php'>Logout</a>";
        echo "&nbsp;&bull; <a href='view_category.php?cid=".$cid."'>Back</a>";
    }
    ?>
    <hr/>
    <div id="content">
        <?php
        if(isset($_GET['cid']) && isset($_GET['tid'])) {
            $cid = $_GET['cid'];
            $tid = $_GET['tid'];
            fetchPosts($cid, $tid, $page, 3);
            getPostsCount($cid, $tid);
            $allPosts = ceil(getPostsCount($cid, $tid) / 3);

            for($i = 1; $i <= $allPosts; $i++) {
                echo " <a href =\"view_topic.php?cid={$cid}&tid={$tid}&page={$i}\">{$i}</a> ";
            }
        }
        else {
            echo "This topic does not exist!";
            echo "</br><a href='index.php'>Return To Main Page</a>";
        }
        ?>
    </div>
</div>
</body>
</html>