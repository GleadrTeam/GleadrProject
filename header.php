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
    <link rel="stylesheet" href="includes/css/bootstrap-glyphicons.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
<!--Custom CSS-->
    <link rel="stylesheet" href="includes/css/styles.css"/>
<!--Include Modernizr in the hand, before any other JavaScript (for older browsers)-->
    <script src="includes/js/modernizr-2.6.2.min.js"></script>
</head>
<body>

<div class="container fill" id="main">
    <!--    The nav bar goes here -->
    <div class="navbar navbar-fixed-top">
        <div class="container">
            <!--            Responsive menu button goes here-->
            <button class="navbar-toggle" data-target=".navbar-responsive-collapse" data-toggle="collapse" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--            Logo goes here -->
            <a class="navbar-brand" href="/"><b>Softuni</b><br/>Overflow</a>

            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li class="active">
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                    <!--                Account button goes here-->
                    <li class="dropdown">
                        <a href="#" id="user-control" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            Account <span class="caret"></span></a> <!-- end of link -->
                        <!-- The drop down menu: -->
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#loginModal" data-toggle="modal">Login</a>

                            </li>
                            <!-- Bootstrap menu list divider: -->
                            <li class="divider"></li>
                            <li>
                                <a href="#">Sign Up</a>
                            </li>
                        </ul><!-- end dropdown menu for Login -->
                    </li>

                    <!--                Search form goes here-->
                    <form action="" class="navbar-form pull-right">
                        <input type="text" class="form-control" placeholder="Search..." id="searchInput"/>
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </ul>

            </div><!-- end nav-collapse-->

        </div><!-- end of navbar container -->
    </div> <!--end of navbar-->
