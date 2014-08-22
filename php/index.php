<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | Home</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Categories</h1>
    <p>Please login</p>
    <?php
        if(!isset($_SESSION['uid'])) {
            echo '<form action="login.php" method="post">' .
                '<label for="username">Username:</label>' .
                '<input type="text" name="username" id="username"/>' .
                '<label for="pass">Password:</label>' .
                '<input type="password" name="pass" id="pass"/>' .
                '<input type="submit" name="sub" value="Log In"/>' .
                ' You are new? ' . '<a href = "create_new_user.php">Register here!</a>';
                '</form>';
        } else {
            echo '<p>You are logged in as ' . htmlentities($_SESSION['username']) . " &bull; <a href='logout.php'>Logout</a>";
        }
    ?>
    <hr/>
<div id="content">
<?php
include_once("mySQLConnect.php");
$sql = "SELECT * FROM categories ORDER BY category_title ASC";
$res = mysql_query($sql) or die(sqlite_error());

if(mysql_num_rows($res) > 0) {
    $categories = "";
    while($row = mysql_fetch_assoc($res)) {
        $id = $row['id'];
        $title = $row['category_title'];
        $description = $row['category_description'];
        $categories .= "<a href='view_category.php?cid=".$id."' class='cat_links'>".$title ." - <font size='-1'>".$description."</font></a></br>";
    }
    echo $categories;
} else {
    echo "<p>There are no categories available yet";
}
?>
</div>
</div>
</body>
</html>