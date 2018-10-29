<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex"/>

    <link rel="stylesheet" href="bootstrap.min.css">

</head>
<body>
<div class="table-responsive">

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Password</th>
        </tr>
        </thead>
        <tbody>
        <?php

        require_once "../config.php";

        if ($_SESSION['reauth'] == 'true') {


            // Prepare an insert statement
            $sql = "SELECT * FROM users";
            if ($result = mysqli_query($link, $sql)) {

                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr><th scope='row'>" . htmlspecialchars($row[0], ENT_QUOTES) . "</th>";
                    printf("<td>%s</td>", htmlspecialchars($row[1], ENT_QUOTES));
                    printf("<td>%s</td>", htmlspecialchars($row[2], ENT_QUOTES));
                    printf("<td>%s</td>", htmlspecialchars($row[3], ENT_QUOTES));
                    printf("<td>%s</td>", htmlspecialchars($row[4], ENT_QUOTES));
                    echo "</tr>";
                }
            }
            session_start();
            $_SESSION['reauth'] = 'false';
        } else {
            header('Location: ' . "index.php");
        }
        ?>

        </tbody>
    </table>

</div>
</body>
