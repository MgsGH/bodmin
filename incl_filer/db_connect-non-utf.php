<?php

$server = 'localhost';
$user = 'hkghbhzh_lennart';
$password = 'PEPSpersson2021';
$database = 'hkghbhzh_lennart';

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'fbo_web');
define('DB_PASSWORD', 'mg1414LENNART');
define('DB_NAME', 'fbo_ver_1');


$connect = mysqli_connect($server, $user, $password, $database);

mysqli_query($connect, 'SET NAMES utf8');
mysqli_query($connect, 'SET COLLATE utf8');
mysqli_query($connect, 'SET CHARSET utf8');


// En funktion att anv�ndas n�r magic_quotes_gpc inte �r satt.
// F�r att f�rhindra SQL-injections, eller i lindrigare fall MySQl-fel.
//S�TT  if (isset($_POST['submit'])){   $_POST = db_escape($_POST);}  I FORMUL�RMOTTAGNINGEN
function db_escape ($post)
{
   if (is_string($post)) {
     if (get_magic_quotes_gpc()) {
        $post = stripslashes($post);
     }
     return mysql_real_escape_string($post);
   }
   
   foreach ($post as $key => $val) {
      $post[$key] = db_escape($val);
   }
   
   return $post;
}

/* 
Se till att det inte finns n�gra dolda tecken, typ radbyte 
eller mellanslag, efter den avslutande PHP-taggen !!! 
*/ 
?>