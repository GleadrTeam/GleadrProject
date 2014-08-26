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
                    <li>
                        <a href="../php/">Home</a>
                    </li>
                    <li>
                        <a href="../about.php">About</a>
                    </li>
                    <!-- Account button goes here-->
                    <li class="dropdown">
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
                                <div class="alert alert-danger alert-block" id="loginAlert">
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

        <!-- Content header: -->
        <div id="contentHeader" >
            <div class="page-header clearfix" id="regHeader">
                <h1 class="pull-left">REGISTRATION FORM
            </div>
        </div> <!-- content header ends here -->
        <!--  Info message for not logged in: -->
        <div class="alert alert-info alert-block fade in" id="loginAlert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>You're not logged in</h4>
            <p>Please log in to your account or create a new one to post a question.</p>
        </div>
        <?php
        include_once("sqlconnect.php");
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
            } else if ( empty($errors) ) {
                if(!isset($file)) {
                    $message = "Please select a file to upload";
                }

                if(checkUser($username) || checkMail($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        ?>
                        <div class="alert alert-block showAlert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>Invalid email address.</p>
                        </div> <br/>
                    <?php

                    }
                    if(checkMail($email)) {
                        ?>
                        <div class="alert alert-block showAlert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>This email address has already been registered!</p>
                        </div> <br/>
                    <?php

                    }
                    if(checkUser($username)) {
                        ?>
                        <div class="alert alert-block showAlert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>This username has been taken. Try onther one.</p>
                        </div> <br/>
                        <?php
                        /*echo '<ul>';
                        for($i = 0; $i < 5 ;$i++) {
                            echo '<li>' . $username . rand(10, 100) . '</li>';
                        }
                        echo '</ul>';*/
                    }
                }
                else {
                    if(!empty($_FILES['image']['name'])) {
                        $fileType = $_FILES['image']['type'];
                        $allowed = array("image/jpeg", "image/gif");
                        $isAllowed = in_array($fileType, $allowed);
                        $isTooLarge = $_FILES['image']['size'] > 100000;
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
                                ?>
                                <div class="alert alert-success alert-block showAlert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <p>Your profile was successfully created.
                                    <button class="btn btn-default" data-toggle="modal" data-target="#loginModal">LOGIN</button>
                                    </p>
                                </div> <br/>
                                <?php
                                $registrationSuccess = true;
                            } else {
                                ?>
                                <div class="alert alert-danger alert-block showAlert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <p>The user could not be created. <?php echo mysql_error(); ?></p>
                                </div> <br/>

                            <?php
                            }
                        } else {
                            if($isTooLarge) {
                                ?>
                                <div class="alert alert-alert alert-block showAlert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <p>File should be less than 100 KB!</p>
                                </div> <br/>
                            <?php
                            }
                            if(!$isAllowed) {
                                ?>
                                <div class="alert alert-alert alert-block showAlert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <p>Not a valid image format! Allowed formats are jpeg, gif!</p>
                                </div> <br/>
                            <?php
                            }
                        }
                    } else {
                        ?>
                        <div class="alert alert-alert alert-block showAlert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>Please upload an image.</p>
                        </div> <br/>
                    <?php
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
        <?php if (!empty($message)) {
            ?>
            <div class="alert alert-block showAlert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p><?php echo $message  ?></p>
            </div>
        <?php
        } ?>
        <?php if (!empty($errors)) {
            ?>
            <div class="alert alert-alert alert-block showAlert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p><?php echo display_errors($errors);  ?></p>
            </div> <br/>
        <?php
        } ?>
        <?php
            if ($registrationSuccess) {

            } else {
        ?>
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="user">User: </label>
                <div class="col-lg-10" >
                    <input type="text" name="username" id="user" placeholder="Your user name ..." class="form-control"/>
                </div>
            </div> <!-- end of user name field -->
            <div class="form-group">
                <label class="col-lg-2 control-label" for="pass">Password: </label>
                <div class="col-lg-10" >
                    <input type="password" name="password" id="pass" placeholder="Your password ..." class="form-control"/>
                </div>
            </div> <!-- end of password field -->
            <div class="form-group">
                <label class="col-lg-2 control-label" for="repass">Confirm Password: </label>
                <div class="col-lg-10" >
                    <input type="password" name="repeatPassword" id="repass" placeholder="Confirm your password ..." class="form-control"/>
                </div>
            </div> <!-- end of confirm password field -->
            <div class="form-group">
                <label class="col-lg-2 control-label" for="mail">Your Email: </label>
                <div class="col-lg-10" >
                    <input type="email" name="email" id="mail" placeholder="Enter your email ..." class="form-control"/>
                </div>
            </div> <!-- end of email field -->
            <div class="form-group">
                <label class="col-lg-2 control-label" for="photo">Upload avatar: </label>
                <div class="col-lg-10" >
                    <input type="file" name="image" id="photo" class="form-control" />
                </div>
            </div> <!-- end of confirm password field -->

            <div class="alert alert-success alert-block showAlert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p>Avatar image must be up to 100 kb size.</p>
            </div>
            <br/>
            <input class="btn btn-primary btn-large pull-right" type="submit" name="submition" value="REGISTER">
        </form>
        <?php
            }
        ?>

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



