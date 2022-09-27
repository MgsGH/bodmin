<?php

//extension=php_mysqli.dll

/* Database credentials. Assuming running MySQL */
if ($_SERVER['SERVER_NAME'] === 'fbo.localhost'){
    $server = 'localhost';
    $user =  'fbo_web';
    $password = 'mg1414LENNART';
    $database = 'fbo_ver_1';
} else {
    // assume production
    $server = 'localhost';
    $user = 'hkghbhzh_web';
    $password = 'mg1414WEB';
    $database = 'hkghbhzh_fbodata';
}


$connect = mysqli_connect($server, $user, $password, $database);

mysqli_query($connect, 'SET NAMES utf8');
mysqli_query($connect, 'SET COLLATE utf8');
mysqli_query($connect, 'SET CHARSET utf8');


/*
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
*/

/*
Se till att det inte finns n�gra dolda tecken, typ radbyte
eller mellanslag, efter den avslutande PHP-taggen !!!
*/
?>
