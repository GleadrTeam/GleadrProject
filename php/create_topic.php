<?php
session_start();
?>
<?php
if(!isset($_SESSION['uid']) || !isset($_GET['cid'])) {
    header("Location: index.php");
    exit();
}

$cid = $_GET['cid'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | Create New Topic</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Create New Topic</h1>
    <p>Viewing Category Topics and Creating New Topics</p>
    <?php
    echo '<p>You are logged in as ' . $_SESSION['username'] . " &bull; <a href='logout.php'>Logout</a>";
    ?>
    <hr/>
    <div id="content">
        <form action="create_topic_parse.php" method="post">
            <p>Topic Title</p>
            <input type="text" name="topic_title" size="98" maxlength="150"/>
            <p>Topic Content</p>
            <textarea name="topic_content" cols="75" rows="5"></textarea>
            <br/>
            <br/>
            <input type="hidden" name="cid" value="<?php echo $cid; ?>"/>
            <input type="submit" name="topic_submit" value="Create your Topic"/>
        </form>
    </div>
</div>
</body>
</html>