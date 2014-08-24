<?php
session_start();
include_once("includes/form_functions.php");
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
        include_once("mySQLConnect.php");
        if(isset($_GET['cid']) && isset($_GET['tid'])) {
            $cid = $_GET['cid'];
            $tid = $_GET['tid'];
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
                    $sql2 = "SELECT * FROM posts WHERE category_id='".$cid."' AND topic_id='".$tid."'";
                    $res2 = mysql_query($sql2) or die(mysql_error());
                    while($row2 = mysql_fetch_assoc($res2)) {
                        echo "<tr><td valign='top' style='1px solid #000000;'><div style='min-height: 125px;'</td>" .
                            htmlentities($row['topic_title']) . "<br/>by " . htmlentities($row2['post_creator']) .
                            " - " . $row2['post_date'] . "<hr/>" .
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
        else {
            echo "This topic does not exist!";
            echo "</br><a href='index.php'>Return To Main Page</a>";
        }
        ?>
    </div>
</div>
</body>
</html>