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
        if(isActive($_POST['username']) !== false) {
            $row = mysql_fetch_assoc($res);
            $_SESSION['uid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            echo "This account hasn`t been activated yet! Please visit your email and click the activation link";
        }
    } else {
        echo "Wrong username/password. Please return to the previous page and try again!";
        echo '<br/><a href="index.php">Back to the main page</a><br />';
    }
}

?>