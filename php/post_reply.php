<?php
session_start();
?>
<?php
if(!isset($_SESSION['uid']) || !isset($_GET['cid'])) {
    header("Location: index.php");
    exit();
}

$cid = $_GET['cid'];
$tid = $_GET['tid'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | Post Forum Reply</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Post Forum Reply</h1>
    <p>Viewing Category Topics and Creating New Topics</p>
    <?php
    echo '<p>You are logged in as ' . htmlentities($_SESSION['username']) . " &bull; <a href='logout.php'>Logout</a>";
    ?>
    <hr/>
    <div id="content">
        <form action="post_reply_parse.php" method="post">
            <label for="reply">Post Reply:</label>
            <textarea name="reply_content" id="reply" cols="75" rows="5"></textarea>
            <br/>
            <br/>
            <input type="hidden" name="cid" value="<?php echo $cid?>"/>
            <input type="hidden" name="tid" value="<?php echo $tid ?>"/>
            <input type="submit" name="reply_submit" value="Post Your Reply"/>
        </form>
    </div>
</div>
</body>
</html>