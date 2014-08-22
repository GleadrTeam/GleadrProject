<?php require_once("includes/functions.php"); ?>
<?php
session_start();
include_once("mySQLConnect.php");

if(isset($_POST['username'])) {
    $username = trim(mysql_prep($_POST['username']));
    $password = trim(mysql_prep($_POST['pass']));
    $sql = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."' LIMIT 1";
    $res = mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($res) == 1) {
        $row = mysql_fetch_assoc($res);
        $_SESSION['uid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid login information. Please return to the previous page";
    }
}

?>