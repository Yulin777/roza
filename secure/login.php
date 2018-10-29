<?php
session_start();
$secretKey = '6Lfbb2sUAAAAAGMCiCUV9SBm3xcemfJQ0VD-IlMO';

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
require_once "config.php";
//we dont want error reporting in production version
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($url);
    $response = json_decode($response);


    // Check if email is empty and if not empty that it is correct
    if (empty(trim($_POST["email"])) || !(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
        $email_err = "Please enter a correct email.";
    } else {
        $email = trim($_POST["email"]); //safe beacuse we alredy checked for it on the if
    }
    // Check if password is empty
    if (empty(trim($_POST["password"])) || !preg_match("/^([a-zA-Z0-9]+)$/", $_POST["password"])) {
        $password_err = "Please enter a password without spiceal chars";
    } else {
        $password = trim($_POST["password"]);//safe because check was made on line 21
    }

    //check login attempts:
    $ip = $_SERVER["REMOTE_ADDR"];
    mysqli_query($link, "INSERT INTO `ip` (`address` ,`timestamp`)VALUES ('$ip',CURRENT_TIMESTAMP)");
    $result = mysqli_query($link, "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 10 minute)");
    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    if ($count[0] > 3) {
        $email_err = "Your are allowed 3 attempts in 10 minutes";
    }


    // Validate credentials
    if (empty($email_err) && empty($password_err)) {//no errors
        //we dont want our login table to be too large-delete old entries on every page load:

        mysqli_query($link, "DELETE FROM ip WHERE timestamp < (NOW() - INTERVAL 11 MINUTE)");//older than 11 minutes get deleted

        // Prepare a select statement
        $sql = "SELECT id,admin, email, firstName, password FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $admin, $email, $firstName, $hashed_password);


                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {//note that only secure passwords created with password_hash will be acceppted
                            //field length in db should be 255 varchar

                            // Password is correct, so start a new session
                            session_start();
                            session_regenerate_id(); //we want a new session id so it wont be fixed
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["admin"] = $admin;
                            $_SESSION["email"] = $email;
                            $_SESSION["firstName"] = $firstName;

                            if ($response->success) {
                                echo "<script>alert(' verified');</script>";
                                if (mysqli_stmt_execute($stmt)) {
                                    // Redirect to login page
                                    header("location: submitted.php?msg=Logged in successfully.&target=index.php");
                                } else {
                                    echo "Something went wrong. Please try again later.";
                                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                                    header("location: login.php?msg=Something went wrong. Going back to Login&target=login.php");
                                }
                            } else {
//                                echo "<script>alert('captcha not verified');</script>";
                                $_SESSION["loggedin"] = false;
                                header("location: submitted.php?msg=please verify reCaptcha before submitting login.Going back to Login&target=login.php");
                            }
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    //email not found
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection

    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src='js/device.min.js'></script>
</head>

<body>
<div class="page">
    <!--========================================================
                              HEADER
    =========================================================-->
    <header>
        <?php include "../secure/menu.inc"; ?>
    </header>
    <!--========================================================
                              CONTENT
    =========================================================-->
    <main>
        <section class="well well__offset-3">
            <div class="container">
                <h2><em>Login</em></h2>

                <div class="row box-3">
                    <div class="grid_5">
                        <h2>Fill-in the following:</h2>
                        <form id='contact-form' class='contact-form'
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

                                <label>Email</label>

                                <input required id="emaillogin" type="text" name="email" class="form-control"
                                       value="<?php echo $email; ?>"
                                       pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" title="name@host.domain">

                                <span class="error-message-simple"><?php echo $email_err; ?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                                <label>Password</label>

                                <input id="passlogin" type="password" name="password" class="form-control" required
                                       pattern="^([a-zA-Z0-9]+)$"
                                       title="The password cannot contain special characters.">

                                <span class="error-message-simple"><?php echo $password_err; ?></span>

                            </div>

                            <div class="g-recaptcha" data-sitekey="6Lfbb2sUAAAAAHeJbmrg3b6SwY4Est4JIxwm-GmO"></div>

                            <div class="form-group">
                                <input id="submitlogin" type="submit" class="btn btn-primary btn-wr" value="Login">
                                <input type="reset" class="btn btn-default btn-wr" value="Reset">

                            </div>

                            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>

                        </form>

                    </div>
                    <div class="preffix_1 grid_6">
                        <h2>Login</h2>
                        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam consectetur orci sed
                            Curabitur vel lorem sit amet nulla ullamcorper fermentum. In vitae varius augue, eu
                            consectetur ligula. Etiam dui eros, laoreet sit amet est vel</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam consectetur orci sed
                            Curabitur vel lorem sit amet nulla ullamcorper fermentum. In vitae varius augue, eu
                            consectetur ligula. Etiam dui eros, laoreet sit amet est vel, commodo venenatis eros.Lamus
                            at magna non nunc tristique rhoncuseri tym.<br><br>Etiam dui eros, laoreet sit amet est vel,
                            commodo venenatis eros.Lamus at magna non nunc tristique rhoncuseri tym. Etiam dui eros,
                            laoreet sit amet est vel, commodo venenatis eros.Lamus at magna non nunc tristique.</p>
                        <address class="address-2">
                            <div class="address_container"><p>The Company Name Inc. 9870 St Vincent Place, Glasgow, DC
                                    45 Fr 45.</p></div>
                            <dl>
                                <dt>Telphone:</dt>
                                <dd>+1 800 603 6035</dd>
                                <br>
                                <dt>FAX:</dt>
                                <dd>+1 800 899 9898</dd>
                                <br>
                                <dt>E-mail:</dt>
                                <dd><a href="mailto:mail@demolink.org">mail@demolink.org</a></dd>
                            </dl>
                        </address>
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
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
