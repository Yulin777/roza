<?php

define('DB_SERVER', 'sql305.byethost7.com');
define('DB_USERNAME', 'b7_22581034');
define('DB_PASSWORD', 'rozaiitc909');
define('DB_NAME', 'b7_22581034_roza_main_db');

/*connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function break_cookie($cookie_string)
{
    $array = explode("|", $cookie_string);
    foreach ($array as $i => $stuff) {
        $stuff = explode("=", $stuff);
        $array[$stuff[0]] = $stuff[1];
        unset($array[$i]);
    }
    return $array;
}
$session_arr=array();
// get array from cookie by using the
if (isset($_COOKIE['rozacafe'])) {
    $session_arr = break_cookie($_COOKIE['rozacafe']);
}
else {
  $session_arr = array(
      'loggedin' => 'false',
      'id' => '0',
      'email' => '',
      'firstName' => ''
  );

}
?>
