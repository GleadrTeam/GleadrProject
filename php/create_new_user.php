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

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$email = trim(mysql_prep($_POST['email']));
		$repassword = trim(mysql_prep($_POST['repassword']));
		$hashed_password = $password;
		
		if ($password != $repassword) {
		    $message = "Your password didn't match! Please try again.";
		} elseif ( empty($errors) ) {
			$query = "INSERT INTO users (
							username, password, email
						) VALUES (
							'{$username}', '{$hashed_password}', '{$email}'
						)";
			$result = mysql_query($query, $connection);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysql_error();
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
            <form method = "post">
                <p>Fill This Form Bellow</p>
                <input type = "text" name = "username" placeholder = "User name" required="true"
		       title="The field is empty, please enter your login name" />
                <input type = "password" name = "password" placeholder = "Enter Your Password" required="true"
		       title="The field is empty, please enter your password"/>
		<input type = "password" name = "repassword" placeholder = "Repeat Passowrd" required="true"
		       title="The field is empty, please retype your password"/>
		<input type = "email" name = "email" placeholder = "Enter Your Email" required="true"
		       pattern="[a-zA-Z0-9_]{3,}@[a-zA-Z0-9_]{3,}.[a-zA-Z0-9_]{2,4}"
		       title="Please enter a valid email address"/>
                <input type = "submit" name = "submition" value = "Submit" />
		<a href="index.php">Back to the main page</a><br />
            </form>
        </body>
    </html>
    
    