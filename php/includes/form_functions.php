<?php
include_once("sqlconnect.php");

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

function validateMail($mail) {
    $mail = mysql_real_escape_string($mail);
}

function isActive($user) {
    $user = mysql_real_escape_string($user);
    $sql = "SELECT
                  COUNT(user_activations.user_id)
                       FROM users INNER JOIN user_activations ON users.id = user_activations.user_id
                           WHERE users.username = '{$user}'";

    $myQuery = mysql_query($sql) or die(mysql_error());

    return (mysql_result($myQuery, 0) == '0') ? true : false;
}

//activates the account related to the given activation code
function activateAccount($activationId) {
    $activationId = mysql_real_escape_string($activationId);

    mysql_query("DELETE FROM user_activations WHERE activation_code = '{$activationId}'") or die(mysql_error());
}

function getImage($user) {
    $result = mysql_query("SELECT * FROM users WHERE username='{$user}'") or die(mysql_error());

    while($row = mysql_fetch_array($result)) {
        $image = $row['image'];
        return $image;
    }
}

function getUsername($id) {
    $id = mysql_real_escape_string($id);
    $result = mysql_query("SELECT * FROM users WHERE id='{$id}' LIMIT 1");
    if($result) {
        $row = mysql_fetch_assoc($result);
        return $row['username'];
    } else {
        return "error";
    }
}

function addVotes($id) {
    $user = mysql_real_escape_string($id);

    $sql = "SELECT * FROM posts WHERE id='{$id}' LIMIT 1";

    $getVotes = mysql_query($sql) or die(mysql_error());

    if($getVotes) {
        $row = mysql_fetch_assoc($getVotes);
        $votes = $row['votes'];
        $id = $row['id'];
        $sql2 = "UPDATE posts SET votes='{$votes}' + 1 WHERE id='{$id}'";

        $result2 = mysql_query($sql2) or die(mysql_error());

        if($result2) {
            return $votes + 1;
        } else {
            return "Error in database - votes column";
        }
    }
}

function subVotes($id) {
    $user = mysql_real_escape_string($id);

    $sql = "SELECT * FROM posts WHERE id='{$id}' LIMIT 1";

    $getVotes = mysql_query($sql) or die(mysql_error());

    if($getVotes) {
        $row = mysql_fetch_assoc($getVotes);
        $votes = $row['votes'];
        if($votes == 0) { $votes = 1; }
        $id = $row['id'];
        $sql2 = "UPDATE posts SET votes='{$votes}' - 1 WHERE id='{$id}'";

        $result2 = mysql_query($sql2) or die(mysql_error());

        if($result2) {
            return $votes - 1;
        } else {
            return "Error in database - votes column";
        }
    }
}
?>	