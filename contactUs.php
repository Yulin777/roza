﻿<?php
if (isset($_POST['submit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        echo "<script type='text/javascript'>
                $('#contact-form')[0].hide();
              </script>";
        echo "<script type='text/javascript'>
                document.getElementById('contact-form').style.display = 'none';
                $('#contact-form')[0].hide();
              </script>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
  
        echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#Modal').modal('show');
    });
    </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu</title>
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
                <h2><em>Our</em>Contacts</h2>
                <div class="map">
                    <div id="google-map" class="map_model"></div>
                    <ul class="map_locations">
                        <li data-x="-73.9874068" data-y="40.643180">
                            <p> 9870 St Vincent Place, Glasgow, DC 45 Fr 45. <span>800 2345-6789</span></p>
                        </li>
                    </ul>
                </div>
                <div class="row box-3">
                    <div class="grid_5">
                        <h2>Contacts Form</h2>

                        <form id="contact-form" class='contact-form' action="submitted.php">
                            <div class="contact-form-loader"></div>
                            <fieldset>
                                <label class="name">
                                    Your Name:
                                    <input type="text" name="name" placeholder="" value=""
                                           data-constraints="@Required @JustLetters"/>
                                    <span class="empty-message">*This field is required.</span>
                                    <span class="error-message">*This is not a valid name.</span>
                                </label>

                                <label class="email">
                                    Your E-mail:
                                    <input type="text" name="email" placeholder="" value=""
                                           data-constraints="@Required @Email"/>
                                    <span class="empty-message">*This field is required.</span>
                                    <span class="error-message">*This is not a valid email.</span>
                                </label>

                                <label class="Subject">
                                    Subject:
                                    <input type="text" name="phone" placeholder="" value=""
                                           data-constraints="@Required"/>
                                    <span class="empty-message">*This field is required.</span>
                                    <span class="error-message">*This is not a valid phone.</span>
                                </label>

                                <label class="message">
                                    Message:
                                    <textarea name="message" placeholder=""
                                              data-constraints='@Required @Length(min=20,max=999999)'></textarea>
                                    <span class="empty-message">*This field is required.</span>
                                    <span class="error-message">*The message is too short.</span>
                                </label>

                                <div class="btn-wr">
                                    <!--                                    <a class="" href="#" data-type="reset">Clear</a>-->
                                    <!--                                    <a class="" href="#" data-type="submit">Send</a>-->
                                    <input type="submit" class="submitBtn" value="submit" name="submit" alt="submit"
                                           onclick="formSubmitted()">
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
                        <h2>Contacts Information</h2>
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
                                <dd>+972 54 jenia jenia</dd>
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
            <div class="copyright">© <span id="copyright-year"></span> |
                <a href="#">Privacy Policy</a>
            </div>
        </div>

    </footer>
</div>
<div class="modal hide fade" id="Modal">
    <!--    <form method="post">-->
    <!--        <div class="modal-header">-->
    <!--            <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px">×</button>-->
    <!--        </div>-->
    <!--        <div class="modal-body">-->
    <!--            <textarea id="text" name="text">Test</textarea>-->
    <!--        </div>-->
    <!--        <div class="modal-footer">-->
    <!--        </div>-->
    <!--    </form>-->
</div>
<script src="js/script.js"></script>
<script src="js/contactUs.js"></script>
</body>
</html>
