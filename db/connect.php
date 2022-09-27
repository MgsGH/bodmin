<?php

function getADBConnection(){


/*
    $server = 'cpsrv11.misshosting.com';
    $user = 'cekbkxow_web';
    $password = 'mg1414WEB';
    $database = 'cekbkxow_fbodata';
*/

/*
 *
 *         define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'system');
        define('DB_PASSWORD', 'mg1414LENNART');
        define('DB_NAME', 'fbo');
 */

    $server = 'localhost';
    $user = 'system';
    $password = 'mg1414LENNART';
    $database = 'fbo';

    $connection = mysqli_connect($server, $user, $password, $database);

    /*
    if (!$connection) {
        $txt = 'Ooooops problem med ' . $server ;
    } else {
        $txt = 'Successfully connected to the server ' . $server ;
    }

   // var_dump($txt);
*/

    $sql = "SET NAMES 'utf8' COLLATE 'utf8_general_ci'";
    mysqli_query($connection, $sql);

    $sql = "SET CHARACTER_SET utf8";
    mysqli_query($connection, $sql);

    return $connection;

}


function getAInfoSchemaDBConnection(){


    $server = 'localhost';
    $user = 'web';
    $password = 'mg1414WEB';
    $database = 'information_schema';

    $connection = mysqli_connect($server, $user, $password, $database);

    /*
    if (!$connection) {
        $txt = 'Ooooops problem med ' . $server ;
    } else {
        $txt = 'Successfully connected to the server ' . $server ;
    }
*/
    $sql = "SET NAMES 'utf8' COLLATE 'utf8_general_ci'";
    mysqli_query($connection, $sql);

    $sql = "SET CHARACTER_SET utf8";
    mysqli_query($connection, $sql);

    return $connection;

}


function getMySqli(){

/*
    $server = 'localhost';
    $user = 'web';
    $password = 'mg1414WEB';
    $database = 'fbodata';
*/

    $server = 'cpsrv11.misshosting.com';
    $user = 'cekbkxow_web';
    $password = 'mg1414WEB';
    $database = 'cekbkxow_fbodata';

    $mysqli = new mysqli($server, $user, $password, $database);

    $mysqli->set_charset("utf8mb4");

    return $mysqli;

}

