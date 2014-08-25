<?php
session_start();
include_once("sqlconnect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<a href="index.php">Back To Main Page</a>
<?php
if(isset($_GET['uid'])) {
    $user = $_GET['uid'];
    $result = mysql_query("SELECT * FROM users WHERE id='{$user}' LIMIT 1") or die(mysql_error());

    if($result) {
        $row = mysql_fetch_assoc($result);
        $username = $row['username'];
        $email = $row['email'];
        $image = $row['image'];

        echo '<p>Hello, <span class="info">' . $username . '</span></p>';
        echo 'Your email is: <span class="info">' . $email . '</span><br/>';
        if(!empty($row['location'])) { echo "<p>Your current locations is <span class='info'>" . $row['location'] . "</span></p>"; }
        if(!empty($row['birth_date'])) { echo "Your birth date is <span class='info'>" . $row['birth_date'] . "</span>"; }
        echo '<p>Profile picture:</p>';
        echo '<img src="data:image/jpeg;base64,'. base64_encode($image) .'" height="210" width="200"/><br/>';
        echo str_repeat('<br/>', 3);
        echo '<hr/>';
        echo '<br/>';
?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="avatar">Edit Profile Picture:</label>
            <input type="file" name="avatar" id="avatar"/>
            <input type="submit" name="changeAvatar" value="Change"/>
        </form>
        <br/>
        <br/>
<?php
        if(!empty($_FILES['avatar'])) {
            $image = addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
            $fileType = $_FILES['avatar']['type'];
            $allowed = array("image/jpeg", "image/gif");
            $isAllowed = in_array($fileType, $allowed);
            $isTooLarge = $_FILES['avatar']['size'] > 100000;
            if($isAllowed && !$isTooLarge) {
                $sql = "UPDATE users SET image='{$image}' WHERE id='{$user}'";
                $result = mysql_query($sql) or die(mysql_error());
                if($result) {
                    ?>
                    <script>
                        location.reload();
                    </script>
                    <?php
                    echo "Avatar changed!";
                } else {
                    echo "Error uploading file";
                }
            } else {
                echo "File too large or of forbidden type!";
            }
        }
    } else {
        echo "Unauthorized access";
    }
} else {
    echo '<a href="index.php">Go To Homepage</a>';
}
?>
<form action="" method="post">
    <label for="location">Please enter your City, Country&nbsp;&bull;&nbsp;</label>
    <input type="text" name="location" id="location"/>
    <input type="submit" name="submitLct" value="Add Location"/>
</form>
<?php
    if(isset($_POST['location'])) {
        $location = mysql_real_escape_string($_POST['location']);
        preg_match("/[^a-zA-Z\, ]+/", $location, $invalid);
        if(!$invalid) {
            $result = mysql_query("UPDATE users SET location='{$location}' WHERE id='{$user}'");

            if($result) {
                ?>
                <script>
                    location.reload();
                </script>
                <?php
                echo 'Location is set!';
            } else {
                echo "There was an error setting your location. Please try again later";
            }
        } else {
            echo "Invalid address format! Only letters allowed";
        }
    }
?>
<br/>
<br/>
<form action="" method="post">
    <label for="birth">Please enter your birthday in format: dd/mm/yyyy&nbsp;&bull;&nbsp;</label>
    <input type="date" name="brthdate" id="birth"/>
    <input type="submit" name="brthBtn" value="Add Birth Date"/>
</form>
<?php
if(isset($_POST['brthdate'])) {
    $date = mysql_real_escape_string($_POST['brthdate']);
    $result = mysql_query("UPDATE users SET birth_date='{$date}' WHERE id='{$user}'");

    if($result) {
        ?>
        <script>
            location.reload();
        </script>
        <?php
        echo "Birth date updated!";
    } else {
        echo "There was error in our database. Please try again later!";
    }
}
?>
</body>
</html>