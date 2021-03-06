<?php
session_start();
include_once("sqlconnect.php");
// check if there is a session:
if(isset($_SESSION['uid'])) {
    // gather user data:
    $isLogged = true;
    $userName = $_SESSION['username'];
    $userID = $_SESSION['uid'];
    $userProfileURL = "user_profile.php?uid=" . $_SESSION['uid'];
} else {
    // user is either not logged or not registered :
    $isLogged = false;
}
?>

<!doctype html>
<html lang="en">
<head>
    <!--Charset-->
    <meta charset="UTF-8">
    <!--Title and description for search engines-->
    <title>Softuni.bg Overflow</title>
    <meta name="description" content="Software University independent Q&A and discussions."/>
    <!--Mobile viewport optimization-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="../includes/css/bootstrap-glyphicons.css"/>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
    <!--Custom CSS-->
    <link rel="stylesheet" href="../includes/css/styles.css"/>
    <!--Include Modernizr in the hand, before any other JavaScript (for older browsers)-->
    <script src="../includes/js/modernizr-2.6.2.min.js"></script>
</head>
<body>
<div class="container fill" id="main">
    <!--    The nav bar goes here -->
    <div class="navbar navbar-fixed-top">
        <div class="container">
            <!-- Responsive menu button goes here-->
            <button class="navbar-toggle" data-target=".navbar-responsive-collapse" data-toggle="collapse" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Logo goes here -->
            <a class="navbar-brand" href="../php/"><b>Softuni</b><br/>Overflow</a>

            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li class="">
                        <a href="../php/">Home</a>
                    </li>
                    <li>
                        <a href="../php/about.php">About</a>
                    </li>
                    <!-- Account button goes here-->
                    <li class="dropdown active">
                        <a href="#" id="user-control" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php
                            if ($isLogged) {
                            echo $userName;
                            ?>
                            <span class="caret"></span></a> <!-- end of link -->
                        <!-- The drop down menu options: -->
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo $userProfileURL ?>" data-toggle="modal">My Profile</a>
                            </li>
                            <!-- Bootstrap menu list divider: -->
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php">Log Out</a>
                            </li>
                        </ul><!-- end drop down options list for User -->
                        <?php
                        } else {
                            echo "Account";
                            ?>
                            <span class="caret"></span></a> <!-- end of link -->
                                                            <!-- The drop down menu options: -->
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                                </li>
                                <!-- Bootstrap menu list divider: -->
                                <li class="divider"></li>
                                <li>
                                    <a href="create_new_user.php">Sign Up</a>
                                </li>
                            </ul><!-- end drop down options list for User -->
                        <?php
                        }
                        ?>
                    </li><!-- end User drop down here -->
                    <!--  Search form goes here-->
                    <form action="search_posts.php" method="get" class="navbar-form pull-right">
                        <input type="text" name="term" class="form-control" placeholder="Search..." id="searchInput"/>
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </ul>

            </div><!-- end nav-collapse-->

        </div><!-- end of navbar container -->
    </div> <!--end of navbar-->

    <div class="row col-12" id="mainRow">
        <!-- Modal window for LOGIN goes here -->

        <div class="modal fade <?php
        if ($_SESSION['loginAttempt'] == 'fail') {
            echo 'in';
        }
        ?>" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" id="loginClose">&times;</button><!-- this was X close button -->
                        <h4>LOGIN</h4>
                    </div><!-- end of modal header-->
                    <form action="login.php" method="post" class="form-horizontal">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="username">User: </label>
                                <div class="col-lg-10" >
                                    <input type="text" name="username" id="username" placeholder="Your user name ..." class="form-control"/>
                                </div>
                            </div> <!-- end of user name field -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="pass">Password: </label>
                                <div class="col-lg-10" >
                                    <input type="password" name="pass" id="pass" placeholder="Your password ..." class="form-control"/>
                                </div>
                            </div> <!-- end of password name field -->
                            <?php
                            if ($_SESSION['loginAttempt'] == 'fail') {
                                ?>
                                <div class="alert alert-danger alert-block showAlert">
                                    <p>Wrong username or password.</p>
                                </div>
                                <?php
                                $_SESSION['loginAttempt'] = 'ok';
                            }
                            ?>
                        </div> <!-- end of modal body -->
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button" id="loginCancel">CANCEL</button>
                            <input class="btn btn-primary" type="submit" name="sub" value="LOG IN">
                        </div> <!-- modal-footer ends here -->
                    </form>
                </div><!-- modal content end-->
            </div><!-- modal dialog end -->
        </div> <!-- end of login modal window -->



        <!--        Main header: -->
        <div id="contentHeader" >
            <div class="page-header clearfix">
                <h1 class="pull-left">My Profile
                    <small<?php
                    if ($isLogged) {
                        echo " id='helloMessage'>Hello, " . $userName;
                    } else {
                        echo ">About IT stuff and softuni.bg";
                    }
                    ?></small></h1>
                <!-- button '+ QUESTION' - only for logged users :) -->

            </div>
        </div>
        <!--  Info message for not logged in: -->
        <div class="alert alert-info alert-block fade in" id="loginAlert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>You're not logged in</h4>
            <p>Please log in to your account or create a new one to post a question.</p>
        </div>
        <div class="well well-large pull-left col-lg-3 col-md-3 col-sm-12 col-xs-12 userProfilePage">
            <?php
            if(isset($_GET['uid'])) {
            $user = $_GET['uid'];
            $result = mysql_query("SELECT * FROM users WHERE id='{$user}' LIMIT 1") or die(mysql_error());

            if($result) {
            $row = mysql_fetch_assoc($result);
            $username = $row['username'];
            $email = $row['email'];
            $image = $row['image'];
            ?>

            <?php
            echo 'email: ' . $email . '<hr/>';
            if(!empty($row['location'])) { echo "Your current locations is " . $row['location'] . "<hr/>"; }
            if(!empty($row['birth_date'])) { echo "Your birth date is " . $row['birth_date'] . "<hr/>"; }
            echo '<p>Profile picture:</p>';
            echo '<img src="data:image/jpeg;base64,'. base64_encode($image) .'" height="210" width="200"/><br/>';
            ?>
        </div>
        <div class="well well-large pull-left col-md-8 col-lg-8 col-sm-12 col-xs-12 userProfilePage">

            <form action="" method="post" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar" class="control-label col-lg-5">Edit Profile Picture:</label>
                    <input type="file" name="avatar"   id="avatar"/>
                    <input type="submit" name="changeAvatar" class="btn btn-default pull-right col-lg-2" value="Change"/>
                </div>
                <hr/>
            </form>
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
                die();
            }
            } else {
                echo '<a href="index.php">Go To Homepage</a>';
            }
            ?>
            <form action="" role="form" method="post">
                <div class="form-group clearfix">
                    <label for="location" class="control-label col-lg-5">Please enter your City, Country: </label>
                    <div class="col-lg-5">
                        <input type="text" name="location" class="form-control" id="location"/>
                    </div>
                    <input type="submit" name="submitLct" class="btn btn-default pull-right col-lg-2" value="Add Location"/>

                </div>
                <hr/>
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
            <form action="" method="post" role="form">
                <div class="form-group">
                    <label for="birth" class="control-label col-lg-5">Please enter your birthday in format: dd/mm/yyyy&nbsp;&bull;&nbsp;</label>
                    <div class="col-lg-5">
                        <input type="date" name="brthdate" class="form-control" id="birth"/>
                    </div>
                    <input type="submit" name="brthBtn" class="btn btn-default pull-right col-lg-2" value="Add Birth Date"/>
                </div>

            </form>
            <hr/>
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


        </div>




    </div><!-- end mainRow row -->


</div><!--end container-->

<!--footer goes here-->
<!--TODO ad hyperlinks to Softuni-->
<footer>
    <!--    this is bootstrap 3 container class -->
    <div class="container">
        <!--        this is bootstrap 3 row class -->
        <div class="row">
            <!--            this is bootstrap 3 col class -->

            <div class="col-sm-8">
                <h3>Coded with <span class="glyphicon glyphicon-heart"></span> by
                    <a href="http://www.softuni.bg" target="_blank">Software University, Sofia</a> students <br/>

                </h3>
            </div>
            <div class="col-sm-4" id="footer-about">
                <h4 class="pull-left">About us:</h4>
                <ul class="pull-left list-unstyled">
                    <li>Valeri</li>
                    <li>Pepi</li>
                    <li >Atanas</li>
                </ul>
                <ul class="list-unstyled">
                    <li>Vlad</li>
                    <li>Deyan</li>
                    <li>Ivan</li>
                </ul>
            </div>



        </div> <!-- end of row -->

    </div> <!-- end of container-->
</footer>
<!--All JavaScript at the bottom of the page for faster page loading-->

<!-- First try the online version of JQuery-->
<script src="//code.jquery.com/jquery.js"></script>
<!--If no online access, fallback to our hardcoded version of JQuery-->
<script>window.jQuery || document.write("<script src='../includes/js/jquery-1.8.2.min.js'><\/script>" || console.log('failed to load jquery'))</script>
<!--Bootstrap JS-->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!--Custom JS-->
<script src="../includes/js/script.js"></script>
</body>
</html>
