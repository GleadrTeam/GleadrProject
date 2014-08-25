<?php
session_start();
include_once("sqlconnect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>SoftUni Overflow | Home</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="wrapper">
    <h1>SoftUni Overflow | Home</h1>
    <?php
    if(isset($_SESSION['uid'])) {
        $welcome = "You are logged in as ";
        echo '<p>' . $welcome . "<a href='user_profile.php?uid=" . $_SESSION['uid'] .
            "'>" . $_SESSION['username'] ."</a>&nbsp;&bull;&nbsp;" .
            "<a href='logout.php'>Logout</a>";
    } else {
        echo "<p>Please Login</p>";
        echo '<form action="login.php" method="post">' .
            '<label for="username">Username:</label>' .
            '<input type="text" name="username" id="username"/>' .
            '<label for="pass">Password:</label>' .
            '<input type="password" name="pass" id="pass"/>' .
            '<input type="submit" name="sub" value="Log In"/>' .
            ' You are new? ' . '<a href = "create_new_user.php">Register here!</a>' .
        '</form>';
        ?>
        <form action="search_posts.php" method="get" class="search-bar">
            <input type="text" name="term" id="search-bar"/>
            <input type="submit" name="submitSearch" value="Search"/>
        </form>
        <?php
    }
    ?>
    <hr/>
<div id="content">
<?php
$sql = "SELECT * FROM categories ORDER BY category_title ASC";
$res = mysql_query($sql) or die(mysql_error());

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