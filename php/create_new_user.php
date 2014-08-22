<?php require_once("includes/functions.php"); ?>
<?php include_once("mySQLConnect.php"); ?>

<?php

        include_once("includes/form_functions.php");
    
        if (isset($_POST['submition'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password', 'email');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = htmlentities(trim(mysql_prep($_POST['username'])));
		$password = trim(mysql_prep($_POST['password']));
		$email = trim(mysql_prep($_POST['email']));
		$repassword = trim(mysql_prep($_POST['repassword']));
		$file = $_FILES['image']['tmp_name'];
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$hashed_password = $password;
		
		if ($password != $repassword) {
		    $message = "Your password didn't match! Please try again.";
		} elseif ( empty($errors) ) {
		    
		    if(!isset($file)) {
			$message = "Please select a file to upload";
		    } else {
			if(!empty($_FILES['image']['name'])) {
			    
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
                    echo "Please upload an image";
                }

            }
		} else {
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
                <input type = "text" name = "username" placeholder = "User name" />
                <input type = "password" name = "password" placeholder = "Enter Your Password" />
		<input type = "password" name = "repassword" placeholder = "Repeat Passowrd"/>
		<input type = "email" name = "email" placeholder = "Enter Your Email"
		       pattern="[a-zA-Z0-9_]{3,}@[a-zA-Z0-9_]{3,}.[a-zA-Z0-9_]{2,4}"
		       title="Please enter a valid email address"/>
                <input type = "submit" name = "submition" value = "Submit" /> <br/>
                    File:
                <input type="file" name="image"/><br/>
                <br/>
		<a href="index.php">Back to the main page</a><br />
            </form>
        </body>
    </html>
    
    