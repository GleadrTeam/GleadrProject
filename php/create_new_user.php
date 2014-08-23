<?php include_once("mySQLConnect.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
include_once("includes/form_functions.php");

if (isset($_POST['submition']) && !empty($_FILES['image'])) { // Form has been submitted.
    $errors = array();

    // perform validations on the form data
    $required_fields = array('username', 'password', 'repeatPassword', 'email');
    $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

    $fields_with_lengths = array('username' => 30, 'password' => 30, 'repeatPassword' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

    $username = trim(mysql_prep($_POST['username']));
    $password = trim(mysql_prep($_POST['password']));
    $repassword = trim(mysql_prep($_POST['repeatPassword']));
    $email = $_POST['email'];
    $file = $_FILES['image']['tmp_name'];
    if(!empty($_FILES['image']['tmp_name'])) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    }
    $hashed_password = sha1($password);

    if ($password != $repassword) {
        $message = "Your password didn't match! Please try again.";
    } elseif ( empty($errors) ) {
        if(!isset($file)) {
            $message = "Please select a file to upload";
        }

        if(checkUser($username) || checkMail($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p>Invalid email address</p>";
            }
            if(checkMail($email)) {
                echo "<p>This email address has already been registered!</p>";
            }
            if(checkUser($username)) {
                echo "This username has been taken. You can try some of the following suggestions:";
                echo '<ul>';
                for($i = 0; $i < 5 ;$i++) {
                    echo '<li>' . $username . rand(10, 100) . '</li>';
                }
                echo '</ul>';
            }
        }
        else {
            if(!empty($_FILES['image']['name'])) {
                $fileType = $_FILES['image']['type'];
                $allowed = array("image/jpeg", "image/png", "image/gif");
                $isAllowed = in_array($fileType, $allowed);
                $isTooLarge = $_FILES['image']['size'] > 200000;
                if(!$isTooLarge && $isAllowed) {
                    $query = "INSERT INTO users (
                                    username, password, email, image
                                ) VALUES (
                                    '" . $username . "', '{$hashed_password}', '{$email}', '{$image}'
                                )";
                    $userId = addslashes(mysql_insert_id());
                    $charset = array_flip(array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9)));
                    $activationId = mysql_real_escape_string(implode(array_rand($charset, 10)));

                    $body = <<<EMAIL

                    Hi, thanks for registering in SoftUni Overflow!
                    before continuing you will have to activate your account
                    Please follow this link http://softunioverflow.webuda.com/php/activate.php?aid={$activationId}

EMAIL;
                    mail($email, "Your new account on SoftUni Overflow!", $body, "From: admin@softunioverflow.webuda.com");

                    $newQuery = "INSERT INTO user_activations (user_id, activation_code) VALUES ('', '{$activationId}')";

                    mysql_query($newQuery, $connection) or die(mysql_error());
                    $result = mysql_query($query, $connection);
                    if ($result) {
                        $message = "The user was successfully created.";
                    } else {
                        $message = "The user could not be created.";
                        $message .= "<br />" . mysql_error();
                    }
                } else {
                    if($isTooLarge) {echo "File should be less than 200 KB!" . PHP_EOL; }
                    if(!$isAllowed) { echo "Not a valid image format! Allowed formats are jpeg, gif and png!" . PHP_EOL; }
                }
            } else {
                echo "Please upload an image";
            }

        }
    }
    else {
        if (count($errors) == 1) {
            $message = "There was 1 error in the form.";
        } else {
            $message = "There were " . count($errors) . " errors in the form.";
        }
    }

} else { // Form has not been submitted.
    $username = "";
    $password = "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>

    </style>
</head>
<body>
<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
<?php if (!empty($errors)) { display_errors($errors); } ?>
<form method = "post" enctype="multipart/form-data">
    <p>Fill This Form Below</p>
    <label for = "user">Your Username</label>
    <input type = "text" name = "username" placeholder = "User Name" id = "user" />
    <label for = "pass">Your Password</label>
    <input type = "password" name = "password" placeholder = "Enter Your Password" id = "pass" />
    <label for = "repass">Retype Your Password</label>
    <input type = "password" name = "repeatPassword" placeholder = "Repeat Password" id = "repass"/>
    <label for = "mail">Your Email</label>
    <input type = "email" name = "email" placeholder = "Enter Your Email" id = "mail"/>
    <input type = "submit" name = "submition" value = "Submit" /> <br/>
    <label for = "photo">Choose a Photo</label>
    <input type="file" name="image" id = "photo"/><br/>
    <br/>
    <a href="index.php">Back to the main page</a><br />
</form>
</body>
</html>

