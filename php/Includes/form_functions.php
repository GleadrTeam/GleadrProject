<?php
include_once("mySQLConnect.php");

function check_required_fields($required_array) {
    $field_errors = array();
    foreach($required_array as $fieldname) {
        if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]))) {
            $field_errors[] = $fieldname;
        }
    }
    return $field_errors;
}

function check_max_field_lengths($field_length_array) {
    $field_errors = array();
    foreach($field_length_array as $fieldname => $maxlength ) {
        if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
    }
    return $field_errors;
}

function display_errors($error_array) {
    echo "<p class=\"errors\">";
    echo "Please review the following fields:<br />";
    foreach($error_array as $error) {
        echo " - " . $error . "<br />";
    }
    echo "</p>";
}

function checkMail($mail) {
    $sql = "SELECT * FROM users WHERE email ='{$mail}'";

    $res = mysql_query($sql) or die(mysql_error());

    $data = mysql_fetch_array($res);
    if($data[0] > 0) { return true;}
    return false;
}

function checkUser($user) {
    $sql = "SELECT * FROM users WHERE username ='{$user}'";

    $res = mysql_query($sql) or die(mysql_error());

    $data = mysql_fetch_array($res);
    if($data[0] > 0) { return true;}
    return false;
}

?>	