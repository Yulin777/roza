<?php
require_once "config.php";
//no error reporting on production
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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

				<?php

						//get id from session var
                        if ($_SESSION["id"] == 7 /*admin id*/) {
              ?>  
                <li>
                <a href="admin/userstable.php">                    
                        All Users<p style="colr: grey; font-size: 14px; text-align: center;"><em> (admin only)</em></p>
                        </a>
               </li>
			<?php
			} 
			?>

                <?php

                if ($_SESSION["loggedin"]==true) {
                  if ($_SESSION['firstName'] != "") {
                        echo "<li style='display: inline-flex;'>
                              <a href=\"logout.php\">Log out</a>
                            <p style='margin-top: 0px; margin-left: 20px; color: white; font-weight: 600;'>Hi, " . $_SESSION['firstName'] . "</p>
                    </li>";
            }
                } else {
                    echo "<li>
                                <a href=\"../secure/login.php\">Log In</a>
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
