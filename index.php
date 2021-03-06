<?php
    $APP_appName = "Training Catalog";
    $APP_appPath = "http://" . $_SERVER['HTTP_HOST'] . "/bootstrap/apps/training_catalog/";
    $APP_homepage = "catalog";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $APP_appName; ?></title>

    <!-- Linked stylesheets -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/js/jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">
    <link href="/bootstrap/scripts/DataTables-1.10.7/media/css/jquery.dataTables.css" rel="stylesheet">
    <link href="/bootstrap/css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jqc-1.12.0,dt-1.10.11,r-2.0.2,se-1.1.2/datatables.min.css"/>

    <link href="../css/master.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">
    <link href="../css/navbar-custom1.css" rel="stylesheet">


    <?php
        // Include functions
        require_once "../shared/query_UDFs.php";
        require_once "./includes/functions.php";

        // Include my database info
        require "../shared/dbInfo.php";

        // Connect to DB
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';
    ?>    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
        // Start session or regenerate session id
        sec_session_start();

        // Check to see if User is logged in
        $loggedIn = login_check($conn);
    ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <!-- Included Scripts -->
    <script src="/bootstrap/scripts/DataTables-1.10.7/media/js/jquery.datatables.js"></script>
    <script src="/bootstrap/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
    <script src="./js/main.js"></script>

    <!-- Scripts needed for login -->
    <script src="./js/login.js"></script>
    <script src="/bootstrap/js/sha512.js"></script>
  </head>
  <body>
    <!-- Google Analytics Tracking -->
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "\bootstrap\apps\shared\analyticstracking.php") ?>
    
    <!-- Fixed Header -->
    <div class="fixed-header-container">
        <div class="container">
            <img id="famuLogo" src="/bootstrap/images/famulogo2014.png" alt="" style="padding-bottom:2px;padding-left:95px;"/>
        </div>

        <!-- Nav Bar -->
        <nav
            id="pageNavBar"
            class="navbar navbar-default navbar-custom1"
            role="navigation"
            style="margin-bottom:0;">

            <div class="container">
                <div class="navbar-header">
                    <button
                        type="button"
                        class="navbar-toggle"
                        data-toggle="collapse"
                        data-target="#navbarCollapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?= $APP_appName ?></a>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <!-- Nav links -->
                    <ul class="nav navbar-nav">
                        <li id="homepage-link" class="active">
                            <a id="navLink-homepage" href="./?page=<?=$APP_homepage?>">Homepage</a>
                        </li>

                        <?php if ($loggedIn) { ?>
                        <li id="catalogAdmin-link">
                            <a id="navLink-catalogAdmin" href="./?page=catalog_admin">Admin</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($loggedIn) { ?>
                        <li class="dropdown" style="cursor:pointer;">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-user" style="margin-right:8px;"></span><?= $_SESSION['firstName'] ?> <span class="glyphicon glyphicon-triangle-bottom" style="margin-left:4px;"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a id="settings-link" href="?page=settings">Settings</a>
                                </li>
                                <li>
                                    <a id="logout-link" href="./content/act_logout.php"> Log out</a>
                                </li>
                            </ul>
                        </li>
                        <?php } else { ?>
                        <li>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Log in</a>
                                <ul class="dropdown-menu" style="padding:0px;">
                                    <li>
                                        <?php include_once './includes/inc_login_form.php'; ?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>

                <script>
                    // Check to see which page is active by getting url page var (use PHP).
                    <?php 
                        if (isset($_GET['page'])) {
                    ?>
                            // Loop through each link to see which one matches the current page
                            $('a[id^=navLink-]').each(function() {

                                // If link has same page variable as current page
                                if ($(this).attr('href').indexOf($.urlParam('page')) >= 0) {

                                    // Remove 'active' class from all navlinks
                                    $('a[id^=navLink-]').each(function() {
                                        $(this).parent().removeClass('active');
                                    });

                                    /*
                                        Distinguish between the details page and the details page with the edit flag when marking the navLinks with the 'active' class.
                                    */
                                    if ($.urlParam('page') == 'jobSpec_details' && $.urlParam('edit') == 1) {
                                        $('#navLink-detailsEdit').parent().addClass('active');
                                    }
                                    else if ($.urlParam('page') == 'jobSpec_details') {
                                        $('#navLink-details').parent().addClass('active');
                                    }
                                    else {
                                        $(this).parent().addClass('active');
                                    }
                                }
                            });
                    <?php      
                        }
                        else {
                    ?>
                            // Remove 'active' class from all navlinks
                            $('a[id^=navLink-]').each(function() {
                                $(this).parent().removeClass('active');
                            });

                            // Add 'active' class to homepage link
                            $('#homepage-link').addClass('active');
                    <?php
                        }
                    ?>
                </script>
            </div>
        </nav>
    </div>
    <div class="fixed-header-spacer"></div>

    <?php

        /**************************/
        /* Include Requested Page */
        /**************************/
        if (isset($_GET["page"])){
            $filePath = './content/' . $_GET["page"] . '.php';
        }
        else{
            $filePath = './content/' . $APP_homepage . '.php';
        }

    	if (file_exists($filePath)){
			include $filePath;
		}
		else{
			include './includes/inc_404.php';
		}
    ?>

    <!-- Footer -->
    <?php include "../templates/footer_1.php"; ?>
</body>
</html>
