<?php
header('Location: '."userstable.php");

//if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if password is empty

  //  if (empty(trim($_POST["password"]))) {

    //    $password_err = "Please enter your password.";

    //} else {
      //  $password = trim($_POST["password"]);
        //if ($password == 'admin') {
          //  header('Location: '."userstable.php");
        //}
    //}


//}

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
