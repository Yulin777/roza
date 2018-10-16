<?php

require_once "config.php";
?>

<!--========================================================
                          main menu-included in all files
                          one menu to rule them all
=========================================================-->
<div id="stuck_container" class="stuck_container">
    <div class="container">
        <div class="brand">
            <h1 class="brand_name">
                <a href="./" style="color: whitesmoke">Cafe Roza</a>
            </h1>
        </div>

        <nav class="nav">
            <ul class="sf-menu">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="register.php">Register</a>
                </li>
                <li>
                    <a href="index-3.php">Menu</a>
                </li>
                <li>
                    <a id="navReview" href="reviews.php">Reviews</a>
                </li>
                <li>
                    <a href="search.php">Search</a>
                </li>

                <li>
                    <a
                        <?php

                        // get array from cookie by using the
                        if (isset($session_arr) && isset($session_arr["id"]) && $session_arr["id"] == 7 /*admin id*/) {
                            echo "href=\"admin/userstable.php\"";
                        } else echo " class=\"grey\" onclick=\"return nada()\"";
                        ?>
                    >
                        All Users<p style="colr: grey; font-size: 14px; text-align: center;"><em> (admin only)</em></p>
                        <!--only id 7-->
                    </a>
                </li>

                <?php

                if (isset($_COOKIE['rozacafe'])) {
                    if ($session_arr['firstName'] != "") {
                        echo "<li style='display: inline-flex;'>
                                <a href=\"logout.php\">Log out</a>
                                <p style='margin-top: 0px; margin-left: 20px; color: white; font-weight: 600;'>Hi, " . $session_arr['firstName'] . "</p>
                          </li>";
                    }
                } else {
                    echo "<li>
                                <a href=\"./login.php\">Log In</a>
                          </li>";
                }
                ?>
            </ul>
        </nav>
    </div>

</div>

<script>
    function nada() {
        return false;
    }
</script>
