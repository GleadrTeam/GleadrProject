<?php require_once("includes/functions.php"); ?>
<?php include_once("mySQLConnect.php"); ?>

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
    $hashed_password = $password;

    if ($password != $repassword) {
        $message = "Your password didn't match! Please try again.";
    } elseif ( empty($errors) ) {
        if(!isset($file)) {
            $message = "Please select a file to upload";
        }

        if(checkUser($username) || checkMail($email)) {
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
    <input type = "text" name = "username" placeholder = "User Name" />
    <input type = "password" name = "password" placeholder = "Enter Your Password" />
    <input type = "password" name = "repeatPassword" placeholder = "Repeat Password"/>
    <input type = "email" name = "email" placeholder = "Enter Your Email"
           pattern="[a-zA-Z0-9_]{3,}@[a-zA-Z0-9_]{3,}.[a-zA-Z0-9_]{2,4}"
           title="Please enter a valid email address format: some@name.com"/>
    <input type = "submit" name = "submition" value = "Submit" /> <br/>
    File:
    <input type="file" name="image"/><br/>
    <br/>
    <a href="index.php">Back to the main page</a><br />
</form>
</body>
</html>

