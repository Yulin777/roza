<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Success</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact-form.css">

    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>

    <!--[if lt IE 9]>
    <html class="lt-ie9">
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
            <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a>
    </div>
    <script src="js/html5shiv.js"></script>
    <![endif]-->

    <script src='js/device.min.js'></script>
</head>

<body>
<div class="page">
    <!--========================================================
                              HEADER
    =========================================================-->
    <header>
        <?php include "menu.inc"; ?>

    </header>
    <!--========================================================
                                  CONTENT
        =========================================================-->
    <main>
        <section class="well well__offset-3">
            <div class="container">

                <div class="row box-3">
                    <div class="grid_5" style="font-size:22px">
                        <?php
                        // echo $_GET['msg'];
                        echo filter_input(INPUT_GET, "msg", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        if ($_GET['target']) {
                            echo " you will be redirected in 5 seconds<br/>";
                            $target = filter_input(INPUT_GET, "target", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $url = 'http://' . $_SERVER['HTTP_HOST'];            // Get the server
                            $url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); // Get the current directory
                            $url .= '/' . $target;                                    // relative path
                            header('Refresh: 5; URL=' . $url);
                            exit();//important:http://thedailywtf.com/articles/WellIntentioned-Destruction
                        }

                        ?>

                    </div>
                </div>
            </div>
        </section>
    </main>


    <!--========================================================
                              FOOTER
    =========================================================-->
    <footer>
        <div class="container">
            <ul class="socials">
                <li><a href="#" class="fa fa-facebook"></a></li>
                <li><a href="#" class="fa fa-tumblr"></a></li>
                <li><a href="#" class="fa fa-google-plus"></a></li>
            </ul>
            <div class="copyright">© <span id="copyright-year"><?php echo date("Y"); ?></span> | Ivan Yulin & Evgeny
                Malinsky
            </div>

    </footer>
</div>
<script src="js/script.js"></script>
</body>
</html>
