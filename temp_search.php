<?php

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $searchvalue = trim($_POST["username"]);

    // Prepare a select statement
    $sql = "SELECT firstName FROM users WHERE firstName = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $searchvalue);
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);
            // Check if email exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $email, $firstName, $hashed_password);

                if (mysqli_stmt_fetch($stmt)) {
                    if (($password == $hashed_password)) {
                        // Password is correct, so start a new session
                        session_start();
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["firstName"] = $firstName;
                        // Redirect user to welcome page

                        header("location: submitted.php?msg=<h1>Logged in successfully</h1></br><a href='index.php'>go to index</a> ");

                    } else {
                        // Display an error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                    }

                }

            } else {
                // Display an error message if email doesn't exist
                $email_err = "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection

    mysqli_close($link);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact-form.css">
    <link rel="stylesheet" href="admin/bootstrap.min.css">
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
                <h2><em>Search</em></h2>
                <br>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input id="username" type="search" placeholder="user name" name="username">
                    <input type="submit" value="search" name="submit">
                </form>
                <br>

                <div class="table-responsive">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Password</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once "config.php";

                        $i = 0;
                        // Prepare an insert statement
                        $sql = "SELECT * FROM users";
                        if ($result = mysqli_query($link, $sql)) {

                            while ($row = mysqli_fetch_row($result)) {
                                echo "<tr><th scope='row'>" . ++$i . "</th>";
                                printf("<td>%s</td>", $row[0]);
                                printf("<td>%s</td>", $row[1]);
                                printf("<td>%s</td>", $row[2]);
                                printf("<td>%s</td>", $row[3]);
                                echo "</tr>";
                            }

                        }

                        ?>

                        </tbody>
                    </table>

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
