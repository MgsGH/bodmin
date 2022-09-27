<?php


function getDataPDO(){

    // Database credentials. Assuming running MySQL/MariaDB
    // Assume production
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'hkghbhzh_skof_sales');
    define('DB_PASSWORD', 'mg1414!SKOF_SALES');
    define('DB_NAME', 'hkghbhzh_skofsales');


    dbLog('Connection details ' .  DB_SERVER . ' ' . DB_USERNAME . '  ' . DB_PASSWORD . ' ' . DB_NAME );

    /* Attempt to connect to MySQL database */
    try{
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD );
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // https://stackoverflow.com/questions/4361459/php-pdo-charset-set-names
        if (!empty($connection_options['collation'])) {
            $pdo->exec('SET NAMES utf8 COLLATE ' . $connection_options['collation']);
        }
        else {
            $pdo->exec('SET NAMES utf8');
        }

        // https://stackoverflow.com/questions/11102644/pdo-exception-questions-how-to-catch-them
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        dbLog("Connected");

    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }

    return $pdo;

}


function getSQLIConnection(){
    /*
    $mysql_server = 'localhost';
    $mysql_user = 'hkghbhzh_skof_sales';
    $mysql_password = 'mg1414!SKOF_SALES';
    $mysql_database = 'hkghbhzh_skofsales';
    */
    $mysql_server = 'localhost';
    $mysql_user = 'sales';
    $mysql_password = 'mg1414SALES';
    $mysql_database = 'skofsales';

    return mysqli_connect($mysql_server, $mysql_user, $mysql_password, $mysql_database);

}


function getSortiment($pdo){

    $sql = "SELECT * from sortiment";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function dbLog($message){

    $logFile = $_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/development.log";

    if (gettype($message) === "array"){

        error_log(count($message) . PHP_EOL, 3, $logFile);
        foreach($message as $key => $value) {
            $s = $key . ' ' . $value;
            error_log($s . PHP_EOL, 3, $logFile);
        }
    } else {
        error_log($message . PHP_EOL, 3, $logFile);
    }


}