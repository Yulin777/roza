<?php

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    }
    else
    {
        $email = trim($_POST["email"]);
    }
    // Check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, firstName, password FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $firstName, $hashed_password);

                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(($password == $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["firstName"]=$firstName;
                            // Redirect user to welcome page

                            header("location: submitted.php?msg=<h1>Logged in successfully</h1></br><a href='index.php'>go to index</a> ");

                        }
                        else
                        {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }

                    }

                }
                else
                {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            }
            else
            {
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
                <h2><em>Login</em></h2>

                <div class="row box-3">
                    <div class="grid_5">
                        <h2>Fill-in the following:</h2>
                        <form id='contact-form' class='contact-form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <!--remove user admin:adminpw from db-->
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

                                <label>Email</label>

                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">

                                <span class="error-message-simple"><?php echo $email_err; ?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                                <label>Password</label>

                                <input type="password" name="password" class="form-control">

                                <span class="error-message-simple"><?php echo $password_err; ?></span>

                            </div>


                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-wr" value="Login">
                                <input type="reset" class="btn btn-default btn-wr" value="Reset">

                            </div>

                            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>

                        </form>

                    </div>
                    <div class="preffix_1 grid_6">
                        <h2>Login</h2>
                        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam consectetur orci sed Curabitur vel lorem sit amet nulla ullamcorper fermentum. In vitae varius augue, eu consectetur ligula. Etiam dui eros, laoreet sit amet est vel</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam consectetur orci sed Curabitur vel lorem sit amet nulla ullamcorper fermentum. In vitae varius augue, eu consectetur ligula. Etiam dui eros, laoreet sit amet est vel, commodo venenatis eros.Lamus at magna non nunc tristique rhoncuseri tym.<br><br>Etiam dui eros, laoreet sit amet est vel, commodo venenatis eros.Lamus at magna non nunc tristique rhoncuseri tym. Etiam dui eros, laoreet sit amet est vel, commodo venenatis eros.Lamus at magna non nunc tristique.</p>
                        <address class="address-2">
                            <div class="address_container"><p>The Company Name Inc. 9870 St Vincent Place, Glasgow, DC 45 Fr 45.</p></div>
                            <dl>
                                <dt>Telphone:</dt> <dd>+1 800 603 6035</dd><br>
                                <dt>FAX:</dt> <dd>+1 800 899 9898</dd><br>
                                <dt>E-mail:</dt> <dd><a href="mailto:mail@demolink.org">mail@demolink.org</a></dd>
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
            <div class="copyright">© <span id="copyright-year"></span> |
                <a href="#">Privacy Policy</a>
            </div>
        </div>

    </footer>
</div>

<!-- <script src="js/script.js"></script> -->
</body>
</html>
