<?php
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$email = $firstName = $lastName = $password = $confirm_password = "";
//$username_err = $password_err = $confirm_password_err = "";
$email_err = $firstName_err = $lastName_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"])) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a correct email.";
    } else {
        // Prepare a select statement

        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    $email_err = "This email is already taken.";
                } else {

                    $email = trim($_POST["email"]);
                }
            } else {

                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement

        mysqli_stmt_close($stmt);
    }



    // Validate firstName

    if (empty(trim($_POST["firstName"])) || !(preg_match("/^[a-zA-Z ]*$/",$_POST["firstName"]))) {
        $firstName_err = "First name must conatin only letters.";
    } else {
        $firstName = trim($_POST["firstName"]);
    }


    // Validate lastName
    if (empty(trim($_POST["lastName"]))) {
        $lastName_err = "Last name must conatin only letters and cannot be empty.";
    } else {
        $lastName = trim($_POST["lastName"]);
    }



// Validate password

    if (empty(trim($_POST["password"])) || !preg_match("^([a-zA-Z0-9]+)$",$_POST["password"])) {

        $password_err = "Please enter a password without spiceal chars";
    } elseif (strlen(trim($_POST["password"])) < 6) {

        $password_err = "Password must have atleast 6 characters.";
    } else {

        $password = trim($_POST["password"]);
    }
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"])) || !preg_match("^([a-zA-Z0-9]+)$",$_POST["confirm_password"])) {
        $confirm_password_err = "Please confirm password, password cannot contain special chars";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database

    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (email,firstName,lastName,password) VALUES (?, ?, ?, ?)";
        if
        ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $email, $firstName, $lastName, $password);
            // Set parameters
            //****      $param_username = $username;
            //  $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            //****    $param_password = $password; // Creates unhashed password
            // Attempt to execute the prepared statement

            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: submitted.php?msg=<h1>Registarion Completed successfully</h1><br/>Now you can login<br/>&target=login.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
        <title>Register new user</title>
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
                        <h2><em>Register</em></h2>

                        <div class="row box-3">
                            <div class="grid_5">
                                <h2>Fill-in the following:</h2>
                                <form id='contact-form' class='contact-form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                        <label>Email</label>
                                        <input required id="emailregister" type="text" name="email" class="form-control" value="<?php echo $email; ?>"  pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" title="name@host.domain">
                                        <span class="error-message-simple"><?php echo $email_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                                        <label>First name</label>
                                        <input required="true" id="firstnameregister" type="text" name="firstName" class="form-control" value="<?php echo $firstName; ?>" pattern="^([a-zA-Z]+)$" title="spiceal chars are not allowed">
                                        <span class="error-message-simple"><?php echo $firstName_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                                        <label>Last name</label>
                                        <input required="true" id="lastnameregister" type="text" name="lastName" class="form-control" value="<?php echo $lastName; ?>" pattern="^([a-zA-Z]+)$" title="spiceal chars are not allowed">
                                        <span class="error-message-simple"><?php echo $lastName_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label>Password</label>
                                        <input  required="true" id="passwordregister" type="password" name="password" class="form-control" value="<?php echo $password; ?>" required pattern="^([a-zA-Z0-9]+)$" title="The password cannot contain special characters.">
                                        <span class="error-message-simple"><?php echo $password_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <label>Confirm Password</label>
                                        <input  required="true" id="confirmregister" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required pattern="^([a-zA-Z0-9]+)$" title="The password cannot contain special characters.">
                                        <span class="error-message-simple"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input id="submitregister" type="submit" class="btn btn-primary btn-wr" value="Submit">
                                        <input type="reset" class="btn btn-default btn-wr" value="Reset">


                                    </div>
                                    <p>Already have an account? <a href="login.php">Login here</a>.</p>
                            </div>


                            <div class="preffix_1 grid_6">
                                <h2>Register new user</h2>
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
                    <div class="copyright">
				© <span id="copyright-year"><?php echo date("Y"); ?></span> | Ivan Yulin & Evgeny Malinsky
			 </div>
                </div>

            </footer>
        </div>

<!-- <script src="js/script.js"></script> -->
    </body>
</html>
