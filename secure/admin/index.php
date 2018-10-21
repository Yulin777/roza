<?php

//we dont want error reporting in production version
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require_once "../config.php";
		
		// Check if password is empty
    if (empty(trim($_POST["password"])) || !preg_match("/^([a-zA-Z0-9]+)$/", $_POST["password"])) {
        $password_err = "Please enter a password without spiceal chars";
    } else {
        $password = trim($_POST["password"]);//safe because check was made before
    }
	
	if (empty($password_err)) //no errors 
	{
	 // Prepare a select statement
     $sql = "SELECT password FROM users WHERE id = ?";
		if ($stmt = mysqli_prepare($link, $sql)) 
		{
			
            // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "s", $id);
           $id=7;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $hashed_password);
					
                    if (mysqli_stmt_fetch($stmt)) {

					 if (password_verify($password, $hashed_password)|| $password==$hashed_password) {
							//note that only secure passwords created with password_hash will be acceppted
                            //field length in db should be 255 varchar

                            // Password is correct
                             header('Location: ' . "userstable.php");

                          

                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
				}
				  // Close statement
        mysqli_stmt_close($stmt);
			}
		}    
	}
        // Close connection

    mysqli_close($link);

        
	}//if pass_err empty
	
	
	
}//if post



?>




<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Reauthentication</title>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <style type="text/css">

        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }

    </style>

</head>

<body>

<div class="wrapper">

    <h2>Reauthenticate</h2>

    <p>Hello admin, Please re-enter in your password to proceed.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

            <label>Password</label>

            <input type="password" name="password" class="form-control">

            <span class="help-block"><?php echo $password_err; ?></span>

        </div>

        <div class="form-group">

            <input type="submit" class="btn btn-primary" value="pass" name="value">

        </div>


    </form>

</div>

</body>

</html>
