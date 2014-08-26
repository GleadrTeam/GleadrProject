<?php require_once("includes/functions.php"); ?>
<?php include_once("includes/form_functions.php"); ?>
<?php
session_start();
include_once("sqlconnect.php");

if(isset($_POST['username'])) {
    $username = trim(mysql_prep($_POST['username']));
    $hashed_password = sha1(trim(mysql_prep($_POST['pass'])));
    $sql = "SELECT * FROM users WHERE username='".$username."' AND password='".$hashed_password."' LIMIT 1";
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
        $_SESSION['loginAttempt'] = 'fail';
        header("Location: index.php");
    }
}
?>
