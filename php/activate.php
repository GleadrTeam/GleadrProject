<?php
include("includes/form_functions.php");

if(isset($_GET['aid'])) {
    activateAccount($_GET['aid']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Activation Page</title>
</head>
<body>
<p> Your account has been activated </p>
<hr/>
<a href="index.php">Back to the main page</a><br />
</body>
</html>	