<?php require_once("includes/functions.php"); ?>
<?php include_once("mySQLConnect.php"); ?>

<?php
    
        include_once("includes/form_functions.php");
    
        if (isset($_POST['submition'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = $password;

		if ( empty($errors) ) {
			$query = "INSERT INTO users (
							username, password
						) VALUES (
							'{$username}', '{$hashed_password}'
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
        </head>
        <body>
	    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
	    <?php if (!empty($errors)) { display_errors($errors); } ?>
            <form method = "post">
                <p>Fill This Form Bellow</p>
                <input type = "text" name = "username" placeholder = "User name" />
                <input type = "password" name = "password" placeholder = "Enter your password" />
                <input type = "submit" name = "submition" value = "Submit" />
		<a href="index.php">Back to the main page</a><br />
            </form>
        </body>
    </html>
    
    