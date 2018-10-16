<?php

// Include config file

require_once "config.php";
$sql = "SELECT user_id FROM reviews WHERE user_id = ?";

if ($stmt = mysqli_prepare($link, $sql)) {


    mysqli_stmt_bind_param($stmt, "s", strval($session_arr['id']));

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {    /* store result */
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $err_voted = 1;//1-user already voted
        } else {
            $err_voted = 0;//0-user didnt voted yet
        }
    } else {

        echo "Oops! Something went wrong. Please try again later.";
    }
}
//------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $message = trim($_POST["message"]);
    $rating = 6 - trim($_POST["rating"]);
   
    $userIP = $_SERVER['REMOTE_ADDR'];
 
  

//     Prepare an insert statement
    $sql = "INSERT INTO reviews (rating,content,user_id) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (isset($session_arr) && isset($session_arr["id"])) {
        }
        if (!isset($_COOKIE['rozacafe'])) {
            $session_arr = break_cookie($_COOKIE['rozacafe']);
        }
        if (isset($_COOKIE['rozacafe'])) {
            $session_arr = break_cookie($_COOKIE['rozacafe']);
        }
        mysqli_stmt_bind_param($stmt, "isi", $rating, $message, $session_arr["id"]);

        
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: submitted.php?msg=<h1>Vote success</h1></br>View your and other reviews<br/>&target=reviews.php");
            } else {
                echo "Something went wrong. Please try again later.";
                printf("Error: %s.\n", mysqli_stmt_error($stmt));
            }
      

    }
//     // Close statement
    mysqli_stmt_close($stmt);
//     // Close connection
    mysqli_close($link);
}
//

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <title>Reviews</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact-form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
                <h2><em>Our</em> Reviews</h2>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3337.1765856621732!2d35.5768700718988!3d33.23567692778632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ebd7769d1ff5d%3A0xa4fefd54a8b8767c!2sTel+Hai+College+West!5e0!3m2!1sen!2sil!4v1534751921701"
                            width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="row box-3">
                    <div class="grid_5">
                        <h2>Review Form</h2>

                        <form id="contact-form" class='contact-form'
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="contact-form-loader"></div>
                            <fieldset <?php if (voted == 1 || $session_arr['loggedin']=='false' || $session_arr['loggedin']=='') echo "disabled"; ?> >

                                <label class="Rating">
                                    Rating:

                                    <div class="star-rating" style="display: inline-flex; padding: 0; ">
                                        <input id="1" type="radio" name="rating" value="1"
                                               style="visibility: hidden;">
                                        <label id="star1" for="1" title="1 star">
                                            <i class="active fa fa-star" aria-hidden="true" style="padding: 2px"></i>
                                        </label>
                                        <input id="2" type="radio" name="rating" value="2"
                                               style="visibility: hidden;">
                                        <label id="star2" for="2" title="2 stars ">
                                            <i class="active fa fa-star " aria-hidden="true" style="padding: 2px"></i>
                                        </label>
                                        <input id="3" type="radio" name="rating" value="3"
                                               style="visibility: hidden;">
                                        <label id="star3" for="3" title="3 stars">
                                            <i class="active fa fa-star " aria-hidden="true" style="padding: 2px"></i>
                                        </label>
                                        <input id="4" type="radio" name="rating" value="4"
                                               style="visibility: hidden;">
                                        <label id="star4" for="4" title="4 stars">
                                            <i class="active fa fa-star " aria-hidden="true" style="padding: 2px"></i>
                                        </label>
                                        <input id="5" type="radio" name="rating" value="5"
                                               style="visibility: hidden;">
                                        <label id="star5" for="5" title="5 stars">
                                            <i class="active fa fa-star " aria-hidden="true" style="padding: 2px"></i>
                                        </label>
                                    </div>
                                </label>
                                <br>
                                <label class="message">
                                    Your review:
                                    <textarea id="reviewtext"
                                              name="message"
                                              placeholder="Loved it!!!"
                                              data-constraints='@Required @Length(min=20,max=100)'></textarea>
                                    <span class="empty-message">*This field is required.</span>
                                    <span class="error-message">*The message is too short.</span>
                                </label>
                            
                                <div class="btn-wr">
                                    <input id="submitreview" type="submit" class="submitBtn" value="submit"
                                           name="submit" alt="submit">
                                </div>

                            </fieldset>
                            <div class="modal fade response-message">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">
                                                &times;
                                            </button>
                                            <h4 class="modal-title">Modal title</h4>
                                        </div>
                                        <div class="modal-body">
                                            You message has been sent! We will be in touch soon.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="preffix_1 grid_6">
                        <h2>Reviews</h2>
                        <div style=" max-height: 400px; overflow-y: scroll;">
                            <table>

                                <tbody>
                                <?php
                                // Prepare an insert statement
                                $sql = "SELECT * FROM reviews";
                                if ($result = mysqli_query($link, $sql)) {
                                    // Fetch one and one row
                                    while ($row = mysqli_fetch_row($result)) {
                                        //echo "\n while ok\n";
                                        $sql_userName = "SELECT firstName,lastName FROM users WHERE id=" . $row[2];

                                        if ($result2 = mysqli_query($link, $sql_userName)) {
                                            $row2 = mysqli_fetch_row($result2);
                                            printf("<h3 style='margin-bottom: 10px; margin-top: 50px; '>%s %s</h3>"
                                                , $row2[0], $row2[1]); /*name*/
                                        }
                                        for ($i = 0; $i < $row[0]; $i++) {
                                            printf("<span class=\"fa fa-star checked\" ></span> "); /*stars*/
                                        }
                                        printf("<p class='user-review' style='margin-top: 10px'>%s</p>
                                                <br>
                                              <hr size='1' style='height: 1px; opacity: 0.5;'>", $row[1]/*review*/);
                                    }
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>

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
<script src="js/script.js"></script>


</body>
</html>
