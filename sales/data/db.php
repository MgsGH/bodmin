<?php


function getSalesPDO(){

    // Database credentials. Assuming running MySQL/MariaDB
    // Assume production
    /*
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'hkghbhzh_skof_sales');
    define('DB_PASSWORD', 'mg1414!SKOF_SALES');
    define('DB_NAME', 'hkghbhzh_skofsales');
    */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'sales');
    define('DB_PASSWORD', 'mg1414SALES');
    define('DB_NAME', 'skofsales');


    //dbLog('Connection details ' .  DB_SERVER . ' ' . DB_USERNAME . '  ' . DB_PASSWORD . ' ' . DB_NAME );

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

        //dbLog("Connected");

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


function getVaror($pdo){

    $sql = "SELECT *, sortiment.bildmapp FROM varor, sortiment WHERE varor.katnr=sortiment.katnr ORDER BY varor.artnr DESC LIMIT 6";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWareCategory($pdo, $category){

    $sql = "select * from sortiment WHERE katnr = :category";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":category", $category, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getBooks($pdo){

    $sql = "select * from varor WHERE katnr=2 ORDER BY utg_ar DESC, artnr DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getOrders($pdo, $language){

    $sql = "select * from v_orders_a_status WHERE language_id = :language ORDER BY ID desc";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getOrder($pdo, $order_id, $language){

    $sql = "select * from v_orders_a_status WHERE id = :orderId and language_id = :language ORDER BY ID desc";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->bindParam(":orderId", $order_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getOrderRows($pdo, $order_id, $language_id){

    $sql = "select ID, ARTIKEL AS ARTIKEL, ORDERED, SIZE, NOOF, round(pris, 0) as PRIS, katnr AS CATEGORY_ID,  ";
    $sqlLanguagePart = " kat_e as CATEGORY_TEXT, spectext_e AS ITEM_TEXT ";
    if ($language_id === '2'){
        $sqlLanguagePart = " kat_s as CATEGORY_TEXT, spectext_s AS ITEM_TEXT ";
    }
    $sql .= $sqlLanguagePart;
    $sql .= " from v_order_row_full WHERE CUSTOMER_ID = :orderId ORDER BY ID desc";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":orderId", $order_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSortiment($pdo){

    $sql = "SELECT * from sortiment";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function deleteOrderRowsForCustomer($pdo, $order_id){

    $sql = "delete from order_row where customer_id = :orderId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":orderId", $order_id, PDO::PARAM_INT);
    $stmt->execute();

}


function deleteCustomer($pdo, $order_id){

    $sql = "delete from customers where id = :orderId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":orderId", $order_id, PDO::PARAM_INT);
    $stmt->execute();

}


function writeCustomer($pdo, $firstName, $lastName, $address, $zipCode, $city, $country, $eMail ) {

    $sql = "insert into customers set 
            ID = :id, 
            FIRSTNAME = :firstName,
            LASTNAME = :lastName,
            ADDRESS = :address,                                   
            ZIPCODE = :zipCode,
            CITY = :city,
            COUNTRY = :country,
            EMAIL = :eMail                                
            ";

    $id = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->bindParam(":firstName", $firstName, PDO::PARAM_STR);
    $stmt->bindParam(":lastName", $lastName, PDO::PARAM_STR);

    $stmt->bindParam(":address", $address, PDO::PARAM_STR);
    $stmt->bindParam(":zipCode", $zipCode, PDO::PARAM_STR);
    $stmt->bindParam(":city", $city, PDO::PARAM_STR);
    $stmt->bindParam(":country", $country, PDO::PARAM_STR);

    $stmt->bindParam(":eMail", $eMail, PDO::PARAM_STR);


    $stmt->execute();

    $sql = "SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}


function writeOrderRow($pdo, $customer_id, $item_id, $noof, $size ) {

    $sql = "insert into order_row set 
            ID = :id, 
            CUSTOMER_ID = :customer_id,
            ITEM_ID = :item_id,
            NOOF = :noof,                                   
            SIZE = :size                               
            ";

    $id = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
    $stmt->bindParam(":item_id", $item_id, PDO::PARAM_INT);

    $stmt->bindParam(":noof", $noof, PDO::PARAM_INT);
    $stmt->bindParam(":size", $size, PDO::PARAM_STR);

    $stmt->execute();


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