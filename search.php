

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
                <br>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input id="username" type="search" placeholder="user name" name="user_name">
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
                          
                        </tr>
                        </thead>



                        <tbody>
                          <?php
                          $search_param="";
//                           error_reporting(E_ALL);
//                          ini_set('display_errors', 1);
                          if($_SERVER["REQUEST_METHOD"] == "GET"){
                          require_once "config.php";
                          $search_param=$_GET['user_name'];
                          $sql = "SELECT firstName,lastName,email FROM users WHERE firstName = '". $search_param ."'";
										
						$result = mysqli_query($link, $sql);
//						if (mysqli_num_rows($result) > 0)
						if($result)
						{
						// output data of each row
						  $i=0;
                          while($row = mysqli_fetch_assoc($result))
							{
                                echo "<tr><th scope='row'>".++$i."</th>";
                                echo "<td>".$row["email"]."</td>";
								echo "<td>".$row["firstName"]."</td>";
								echo "<td>".$row["lastName"]."</td>";
                                         echo "</tr>";
                                      }
						
							
					} else {
						echo "0 results";
						}

					mysqli_close($link);
           
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
            <div class="copyright">
				© <span id="copyright-year"><?php echo date("Y"); ?></span> | Ivan Yulin & Evgeny Malinsky
			 </div>
        </div>

    </footer>
</div>

<!-- <script src="js/script.js"></script> -->
</body>
</html>
