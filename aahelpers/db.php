<?php

// prevent direct access
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
}

function getDataPDO(){

    /* Database credentials. Assuming running MySQL/MariaDB */

    $lookinto = 'something.' . $_SERVER['SERVER_NAME'];
    $t = strpos($lookinto , 'fbo.localhost');

    if ($t){
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'fbo_web');
        define('DB_PASSWORD', 'mg1414LENNART');
        define('DB_NAME', 'fbo_ver_1');
    } else {
        // assume production
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'hkghbhzh_web');
        define('DB_PASSWORD', 'mg1414WEB');
        define('DB_NAME', 'hkghbhzh_fbodata');
    }

   // dbLog('Connection details ' .  DB_SERVER . ' ' . DB_USERNAME . '  ' . DB_PASSWORD . ' ' . DB_NAME );

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

    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }

    return $pdo;

}


function deleteTheUsersModulePermisions($pdo, $userId){

    $sql = "delete from v2user_mod_perm where USER_ID = :userId";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_STR);
    $stmt->execute();

}


function getPermissionOptions($pdo, $lang){

    $sql = "SELECT * from v2v_permissions_a_texts where language_id = :langid ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langid", $lang, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getHelp($pdo, $language, $module){

    $sql = "SELECT * from v2modules_help where language_id = :langid and MODULE_ID = :moduleid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langid", $language, PDO::PARAM_INT);
    $stmt->bindParam(":moduleid", $module, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllUserNames($pdo){

    $sql = "SELECT ID, USERNAME FROM v2users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function userNameExists($pdo, $userNameToCheck){

    $result = false;
    // Prepare a select statement
    $sql = "SELECT id, username, password FROM v2users WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":username", $userNameToCheck, PDO::PARAM_STR);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Check if username exists, if yes then verify password
        if ($stmt->rowCount() === 1) {
            $result = true;
        }
    }


    return $result;
}


function passWordCorrectForUser($pdo, $userName, $passWord){

    $loggedIn = false;
    // Prepare a select statement
    $sql = "SELECT id, username, password, person_id, LANGUAGE_ID FROM v2users WHERE username = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $userName, PDO::PARAM_STR);
    if ($stmt->execute()) {

        // Check if username exists, if yes then verify password
        if ($stmt->rowCount() === 1){
            if($row = $stmt->fetch()) {
                $username = $row["username"];
                $hashed_password = $row["password"];
                if (password_verify($passWord, $hashed_password)) {

                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["userId"] = $row["id"];
                    $_SESSION["username"] = $username;
                    $_SESSION["personId"] = $row["person_id"];
                    $_SESSION["preferredLanguageId"] = $row["LANGUAGE_ID"];

                    $loggedIn = true;
                }
            }
        }
    }


    return $loggedIn;
}


function getUser($pdo, $userName){

    $sql = "SELECT id, username, password, person_id, enabled, created_by, created_at FROM v2users where username = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userName]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function deleteUser($pdo, $userId){

    $sql = "DELETE FROM v2users where id = :id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();

}


function getAllUserNamesExcept($pdo, $id){

    $sql = "SELECT username FROM v2users where id != :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getLanguagesForOptions($pdo){
    $sql = "SELECT ID, TEXT FROM v2languages";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function getUserViaId($pdo, $userId){

    // Prepare a select statement
    $sql = "SELECT id, username, password, person_id, LANGUAGE_ID, enabled, created_by, created_at FROM v2users where id = ? ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getUsers($pdo){

    $sql = "SELECT * FROM v2v_users_language_person";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeUser($pdo, $table_id, $user_name, $pwd, $person_id, $language, $activated, $logged_in_user){

    $passWord = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "insert into v2users set id = :id, 
                                    username = :userName, 
                                    password = :passWord, 
                                    person_id = :personId, 
                                    enabled = :activated,
                                    created_by = :loggedInUser,
                                    LANGUAGE_ID = :languageId";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $table_id, PDO::PARAM_INT );
    $stmt->bindParam(":userName", $user_name, PDO::PARAM_STR );
    $stmt->bindParam(":passWord", $passWord, PDO::PARAM_STR );
    $stmt->bindParam(":activated", $activated, PDO::PARAM_INT );
    $stmt->bindParam(":personId", $person_id, PDO::PARAM_INT );
    $stmt->bindParam(":languageId", $language, PDO::PARAM_INT );
    $stmt->bindParam(":loggedInUser", $logged_in_user, PDO::PARAM_INT );
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}


function updateUser($pdo, $user_id, $user_name, $person_id, $language, $activated){

    $sql = "Update v2users set username = :userName, enabled = :activated, person_id = :personid, LANGUAGE_ID = :lang where id = :userid ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":userName", $user_name, PDO::PARAM_STR );
    $stmt->bindParam(":activated", $activated, PDO::PARAM_BOOL );
    $stmt->bindParam(":personid", $person_id, PDO::PARAM_INT );
    $stmt->bindParam(":lang", $language, PDO::PARAM_INT );
    $stmt->bindParam(":userid", $user_id, PDO::PARAM_INT );

    $stmt->execute();

}


function updatePassWord($pdo, $pwd, $userId){

    $passWord = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "Update v2users set password = :passWord where id = :userid ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":passWord", $passWord, PDO::PARAM_STR);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->execute();

}


function updatePasswordForUserName($pdo, $userNameToUpdate, $passWord){

    $result = "";
    $passWord = password_hash($passWord, PASSWORD_DEFAULT);

    // Prepare a select statement
    $sql = "Update v2users set password = :password where username = :username ";

    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":username", $userNameToUpdate, PDO::PARAM_STR);
    $stmt->bindParam(":password", $passWord, PDO::PARAM_STR);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        $result = "OK!";
    }


    return $result;
}


function getGuidningCustomers($pdo){

    $sql = "SELECT ID, GROUP_NAME, CONTACT_NAME, CITY, USER_NAME, CREATED_AT FROM v2v_guide_customers_creator order by CREATED_AT DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getGuidingCustomerViaId($pdo, $id){

    $sql = "SELECT * FROM v2guiding_customers where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

};


function getGuidingCustomerBookings($pdo, $customer_id){

    $sql = "SELECT * FROM v2guiding_bookings where GUIDING_CUSTOMER_ID = :id order by BOOKING_DATE, BOOKING_TIME DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function updateGuidingCustomer($pdo, $logged_in_user, $table_id, $customer_name, $customer_address, $customer_zipcode, $customer_city, $customer_contact_person, $customer_email, $customer_telephone_one, $customer_telephone_two, $customer_invoice_name, $customer_invoice_id, $customer_invoice_address, $customer_invoice_zipcode, $customer_invoice_city){

    $sql = "UPDATE v2guiding_customers
        set  CHANGED_BY = :user,
             GROUP_NAME = :customer_name,
             ADDRESS = :customer_address,
             CITY = :customer_city,
             ZIPCODE = :customer_zipcode,
             CONTACT_NAME = :customer_contact_person,
             EMAIL = :customer_email,
             TEL_NO_1 = :customer_telephone_one,
             TEL_NO_2 = :customer_telephone_two,
             INVOICE_NAME = :customer_invoice_name,
             INVOICE_ID = :customer_invoice_id,
             INVOICE_ADDRESS = :customer_invoice_address,
             INVOICE_ZIPCODE = :customer_invoice_zipcode,
             INVOICE_CITY = :customer_invoice_city        
            where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $table_id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $logged_in_user, PDO::PARAM_STR);
    $stmt->bindParam(":customer_name", $customer_name, PDO::PARAM_STR);
    $stmt->bindParam(":customer_address", $customer_address, PDO::PARAM_STR);
    $stmt->bindParam(":customer_zipcode", $customer_zipcode, PDO::PARAM_STR);
    $stmt->bindParam(":customer_city", $customer_city, PDO::PARAM_STR);
    $stmt->bindParam(":customer_contact_person", $customer_contact_person, PDO::PARAM_STR);
    $stmt->bindParam(":customer_email", $customer_email, PDO::PARAM_STR);
    $stmt->bindParam(":customer_telephone_one", $customer_telephone_one, PDO::PARAM_STR);
    $stmt->bindParam(":customer_telephone_two", $customer_telephone_two, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_name", $customer_invoice_name, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_id", $customer_invoice_id, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_address", $customer_invoice_address, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_zipcode", $customer_invoice_zipcode, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_city", $customer_invoice_city, PDO::PARAM_STR);
    $stmt->execute();

}

function writeGuidingCustomer($pdo, $logged_in_user, $table_id, $customer_name, $customer_address, $customer_zipcode, $customer_city, $customer_contact_person, $customer_email, $customer_telephone_one, $customer_telephone_two, $customer_invoice_name, $customer_invoice_id, $customer_invoice_address, $customer_invoice_zipcode, $customer_invoice_city){

    $sql = "insert into v2guiding_customers set id = :id, 
             CHANGED_BY = :user,
             CREATED_BY = :user,
             GROUP_NAME = :customer_name,
             ADDRESS = :customer_address,
             CITY = :customer_city,
             ZIPCODE = :customer_zipcode,
             CONTACT_NAME = :customer_contact_person,
             EMAIL = :customer_email,
             TEL_NO_1 = :customer_telephone_one,
             TEL_NO_2 = :customer_telephone_two,
             INVOICE_NAME = :customer_invoice_name,
             INVOICE_ID = :customer_invoice_id,
             INVOICE_ADDRESS = :customer_invoice_address,
             INVOICE_ZIPCODE = :customer_invoice_zipcode,
             INVOICE_CITY = :customer_invoice_city        
            ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $table_id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $logged_in_user, PDO::PARAM_STR);
    $stmt->bindParam(":customer_name", $customer_name, PDO::PARAM_STR);
    $stmt->bindParam(":customer_address", $customer_address, PDO::PARAM_STR);
    $stmt->bindParam(":customer_zipcode", $customer_zipcode, PDO::PARAM_STR);
    $stmt->bindParam(":customer_city", $customer_city, PDO::PARAM_STR);
    $stmt->bindParam(":customer_contact_person", $customer_contact_person, PDO::PARAM_STR);
    $stmt->bindParam(":customer_email", $customer_email, PDO::PARAM_STR);
    $stmt->bindParam(":customer_telephone_one", $customer_telephone_one, PDO::PARAM_STR);
    $stmt->bindParam(":customer_telephone_two", $customer_telephone_two, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_name", $customer_invoice_name, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_id", $customer_invoice_id, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_address", $customer_invoice_address, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_zipcode", $customer_invoice_zipcode, PDO::PARAM_STR);
    $stmt->bindParam(":customer_invoice_city", $customer_invoice_city, PDO::PARAM_STR);
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}

function deleteGuidingCustomer($pdo, $record_id){

    $sql = "DELETE FROM v2guiding_customers where id = :record_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":record_id", $record_id, PDO::PARAM_INT);
    $stmt->execute();

}

function writeGuidingBooking($pdo, $logged_in_user, $table_id,  $booking_date, $booking_time, $booking_noof, $booking_age, $booking_comment ){

    $sql = "insert into v2guiding_bookings set 
            ID = :id, 
            GUIDING_CUSTOMER_ID = :customer_id,
            CHANGED_BY = :user,
            CREATED_BY = :user,                                   
            BOOKING_DATE = :booking_date,
            BOOKING_TIME = :booking_time,
            NO_OF = :booking_noof,
            AGE = :booking_age,
            COMMENT = :booking_comment                                  
            ";
    $id = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":customer_id", $table_id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $logged_in_user, PDO::PARAM_INT);

    $stmt->bindParam(":booking_date", $booking_date, PDO::PARAM_STR);
    $stmt->bindParam(":booking_time", $booking_time, PDO::PARAM_STR);
    $stmt->bindParam(":booking_noof", $booking_noof, PDO::PARAM_STR);
    $stmt->bindParam(":booking_age", $booking_age, PDO::PARAM_STR);
    $stmt->bindParam(":booking_comment", $booking_comment, PDO::PARAM_STR);

    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}

function updateGuidingBooking($pdo, $logged_in_user, $booking_id, $booking_date, $booking_time, $booking_noof, $booking_age, $booking_comment ){

    $sql = "update v2guiding_bookings set 
            CHANGED_BY = :user,                            
            BOOKING_DATE = :booking_date,
            BOOKING_TIME = :booking_time,
            NO_OF = :booking_noof,
            AGE = :booking_age,
            COMMENT = :booking_comment
            WHERE ID = :id
            ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $booking_id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $logged_in_user, PDO::PARAM_INT);

    $stmt->bindParam(":booking_date", $booking_date, PDO::PARAM_STR);
    $stmt->bindParam(":booking_time", $booking_time, PDO::PARAM_STR);
    $stmt->bindParam(":booking_noof", $booking_noof, PDO::PARAM_STR);
    $stmt->bindParam(":booking_age", $booking_age, PDO::PARAM_STR);
    $stmt->bindParam(":booking_comment", $booking_comment, PDO::PARAM_STR);

    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}

function deleteGuideBooking($pdo, $record_id){

    $sql = "DELETE FROM v2guiding_bookings where id = :record_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":record_id", $record_id, PDO::PARAM_INT);
    $stmt->execute();

}

function deleteGuideBookingsForCustomer($pdo, $customer_id){

    $sql = "DELETE FROM v2guiding_bookings where GUIDING_CUSTOMER_ID = :record_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":record_id", $customer_id, PDO::PARAM_INT);
    $stmt->execute();

}



function getAllPersonSignatures($pdo){

    $sql = "SELECT ID, concat(FNAMN, ' ', ENAMN) AS TEXT, SIGNATURE FROM v2persons WHERE LENGTH(SIGNATURE) > 0 order by ENAMN, FNAMN ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAllActivePersons($pdo){

    $sql = "SELECT ID, concat(FNAMN, ' ', ENAMN) AS TEXT, SIGNATURE FROM v2persons order by ENAMN, FNAMN";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getLoggedInPersonsSignature($pdo, $id){

    $sql = "SELECT SIGNATURE, FNAMN, ENAMN, PERSON_ID FROM v2v_user_a_person WHERE user_id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


//----------------------------------------------------------------------------##person------------------------
function writePerson($pdo, $id, $fname, $ename, $refname, $websajt, $passed, $webtext, $loggedInUser, $signature)
{

    $sql = "insert into v2persons set 
                        ID = :personid, 
                        FNAMN = :fnamn, 
                        ENAMN = :enamn,
                        AUTH_NAME = :authorname, 
                        WEBSAJT = :websajt,                    
                        WEBTEXT = :webtext,
                        PASSED = :passed,                        
                        SIGNATURE = :signature,                        
                        CHANGED_BY = :updatedby";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":personid", $id, PDO::PARAM_INT);
    $stmt->bindParam(":fnamn", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":enamn", $ename, PDO::PARAM_STR);

    $stmt->bindParam(":authorname", $refname, PDO::PARAM_STR);
    $stmt->bindParam(":websajt", $websajt, PDO::PARAM_STR);
    $stmt->bindParam(":webtext", $webtext, PDO::PARAM_STR);

    $stmt->bindParam(":passed", $passed, PDO::PARAM_INT);
    $stmt->bindParam(":signature", $signature, PDO::PARAM_STR);
    $stmt->bindParam(":updatedby", $loggedInUser, PDO::PARAM_INT);


    executeStatement($stmt);

}


function updatePerson($pdo, $id, $fname, $ename, $refname, $websajt, $passed, $webtext, $loggedInUser, $signature)
{

    $sql = "Update v2persons set FNAMN = :fnamn, 
                                 ENAMN = :enamn, 
                                 AUTH_NAME = :authorname, 
                                 WEBSAJT = :websajt, 
                                 PASSED = :passed, 
                                 SIGNATURE = :signature, 
                                 WEBTEXT = :webtext, 
                                 CHANGED_BY = :updatedby 
                  where ID = :personid ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":fnamn", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":enamn", $ename, PDO::PARAM_STR);
    $stmt->bindParam(":authorname", $refname, PDO::PARAM_STR);
    $stmt->bindParam(":websajt", $websajt, PDO::PARAM_STR);
    $stmt->bindParam(":webtext", $webtext, PDO::PARAM_STR);
    $stmt->bindParam(":passed", $passed, PDO::PARAM_INT);
    $stmt->bindParam(":signature", $signature, PDO::PARAM_STR);
    $stmt->bindParam(":updatedby", $loggedInUser, PDO::PARAM_INT);
    $stmt->bindParam(":personid", $id, PDO::PARAM_INT);

    executeStatement($stmt);

}


function deletePerson($pdo, $id){

    $sql = "DELETE FROM v2persons where id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

}


function executeStatement($stmt){

    try {
        $stmt->execute();
        } catch (PDOException $e) {
            error_log('Problem med skrivandet: ' . $e->getMessage() . PHP_EOL, 3, "my-errors.log");
        } catch (Exception $exception) {
            error_log('Problem med skrivandet: ' . $exception->getMessage() . PHP_EOL, 3, "my-errors.log");
        }

}


function getAlivePersons($pdo){

    $sql = "SELECT ID, FNAMN, ENAMN, AUTH_NAME, concat(FNAMN, ' ', ENAMN) AS FULLNAME, SIGNATURE, created_at FROM v2persons where PASSED = 0 order by ENAMN, FNAMN";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getPersons($pdo){

    $sql = "SELECT ID, FNAMN, ENAMN, AUTH_NAME, concat(FNAMN, ' ', ENAMN) AS FULLNAME, SIGNATURE, created_at FROM v2persons order by ENAMN, FNAMN";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPersonViaId($pdo, $id){

    $sql = "SELECT ID, FNAMN, ENAMN, AUTH_NAME, concat(FNAMN, ' ', ENAMN) AS FULLNAME, WEBSAJT, WEBTEXT, PASSED, SIGNATURE, CREATED_BY, CREATED_AT, CHANGED_BY, CHANGED_AT FROM v2persons where id = :userid";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPersonIdViaUserId($pdo, $userId){

    $sql = "SELECT person_id FROM v2users where id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function deleteEmailForPersonId($pdo, $personId){

    $sql = "DELETE FROM v2persons_emails where person_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$personId]);

}


function writeEmailForPersonId($pdo, $personId, $email){

    $defaultId = 0;
    $sql = "insert into v2persons_emails (id, address, person_id) values (?, ?, ?) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$defaultId, $email, $personId]);

}


function getPersonEMails($pdo, $id){

    $sql = "SELECT address FROM v2persons_emails where person_id = :personid";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":personid", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAllPersonEMailsExcept($pdo, $id){

    $sql = "SELECT address FROM v2persons_emails where person_id != :personid";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":personid", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeUserModulePermissionToDB($pdo, $userId, $moduleId, $permissionId){

    $sql = "insert into v2user_mod_perm set ID = :id, USER_ID = :userid, MODULE_ID = :moduleid, PERMISSION_ID = :permissionid";
    $stmt = $pdo->prepare($sql);
    $d = 0;
    $stmt->bindParam(":id", $d, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":moduleid", $moduleId, PDO::PARAM_INT);
    $stmt->bindParam(":permissionid", $permissionId, PDO::PARAM_INT);
    $stmt->execute();

}


function getModulePermissions($pdo, $userId){

    $sql = "SELECT MODULE_ID, PERMISSION_ID FROM v2user_mod_perm where USER_ID = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getUserModPermissions($pdo, $userId, $lang){

    $sql = "SELECT MODULE, PERMISSION_LEVEL FROM v2v_usr_mod_a_txt_perm where user_id = :userid and language_id = :langid order by sortorder";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":langid", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getUserModulePermission($pdo, $userId, $moduleId){

    $sql = "SELECT PERMISSION_ID FROM v2v_usr_mod_a_txt_perm where user_id = :userid and language_id = 1 and module_id = :moduleid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":moduleid", $moduleId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAppMenuTopLevel($pdo, $userId, $languageId){

    $sql = "SELECT * FROM v2v_usr_mod_a_txt_perm where user_id = :userid and language_id = :languageid and parent_id = 0 order by sortorder";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":languageid", $languageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAppMenuSubMenu($pdo, $userId, $languageId, $parentMenuItemId){

    $sql = "SELECT * FROM v2v_usr_mod_a_txt_perm where user_id = :userid and language_id = :languageid and parent_id = :$parentMenuItemId order by sortorder";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":languageid", $languageId, PDO::PARAM_INT);
    $stmt->bindParam(":$parentMenuItemId", $parentMenuItemId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getModules($pdo, $lang){

    $sql = "SELECT * FROM `v2v_modules_a_texts` where language_id = :languageid order by sortorder";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":languageid", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLocationsForDropDown($pdo, $lang){

    $sql = "SELECT ID, TEXT FROM v2v_location_dd WHERE LANG_ID = :langid order by SORTORDER";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langid", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMeasurementsOptions($pdo, $lang){

    $sql = "SELECT MEASUREMENT_ID as ID, TEXT from v2taxa_measurements_texts where LANG_ID = :lang";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getOptionalMeasurementsOptions($pdo, $lang){

    $sql = "SELECT ID as ID, TEXT from v2v_measurements_a_texts where LANG_ID = :lang and standard = 0 order by SORTORDER";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStandardMeasurementsOptions($pdo, $lang){

    $sql = "SELECT * from v2v_measurements_a_texts where LANG_ID = :lang and standard = 1 order by SORTORDER";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getSexOptions($pdo, $lang){

    $sql = "SELECT SEX_ID as ID, TEXT AS TEXT from v2sex_texts where LANGUAGE_ID = :lang order by text";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getSexMeasurementsOptions($pdo, $lang){

    $sql = "SELECT SEX_ID as ID, TEXT AS TEXT from v2sex_texts where LANGUAGE_ID = :lang and SEX_ID != 1 order by text";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMonthOptions($pdo, $lang){

    $sql = "SELECT MONTHNO, SHORTTEXT AS TEXT from v2months_texts where LANGUAGE_ID = :lang";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAgeOptionsForMeasurementOptions($pdo, $lang){

    $sql = "SELECT AGE, TEXT AS TEXT from v2ages_texts where LANGUAGE_ID = :lang order by AGE";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//-------------------------------------------------------------------------------------- Rasträkning ------------------
function getRastrakningsVeckor($pdo){

    // SELECT year, week, count(distinct TAXA_ID), SUM(ANTAL) FROM `v_rastraknings_weeks` group by YEAR, WEEK
    $sql = "SELECT id, publish, year, week as VE, count(distinct TAXA_ID) as ANTAL_ARTER, SUM(ANTAL) AS VECKO_SUMMA FROM `v2v_rastraknings_weeks` group by YEAR, WEEK order by YEAR desc, week desc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLastCurrentWeek($pdo){
    $sql = "SELECT max(year) as MAX_YEAR, max(week) as MAX_VECKA FROM v2monitoring_occasion where year = (SELECT max(year) FROM v2monitoring_occasion)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getMonitoringOccassion($pdo, $id){

    $sql = "select * from v2monitoring_occasion where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getYearVeckaExist($pdo, $year, $vecka){

    $sql = "select * from v2monitoring_occasion where year = :year and week = :week";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();
    $retreivedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $answer = 'No';
    $svar = array();
    if (sizeof($retreivedRows) > 0){
        $answer = 'Yes';
    }
    $svar[] = $answer;

    return $svar;
}


function getYearVeckaExistExceptId($pdo, $id, $year, $vecka){

    $sql = "select * from v2monitoring_occasion where year = :year and week = :week and id != :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();
    $retreivedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $answer = 'No';
    $svar = array();
    if (sizeof($retreivedRows) > 0){
        $answer = 'Yes';
    }
    $svar[] = $answer;

    return $svar;
}


function writeRastRakningVecka($pdo, $year, $vecka, $userId){

    //
    $sql = "insert into v2monitoring_occasion set year = :year, week = :week, created_by = :id, updated_by = :id, publish = :publish";
    $stmt = $pdo->prepare($sql);
    $publish = 0;
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $publish, PDO::PARAM_INT);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();

    //
    $snr = 1;
    $summa = 0;
    $art = 'BRAND';
    $sql = "insert into v2rastbas set year = :year, ve = :week, snr = :snr, art = :art, summa = :summa";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":snr", $snr, PDO::PARAM_INT);
    $stmt->bindParam(":summa", $summa, PDO::PARAM_INT);
    $stmt->bindParam(":art", $art, PDO::PARAM_STR);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();

}


function updateRastRakningVecka($pdo, $year, $vecka, $userId, $publish, $postId){

    $sql = "update v2monitoring_occasion set year = :year, week = :week, updated_by = :id, publish = :publish where id = :postId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $publish, PDO::PARAM_INT);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();

}


function deleteRastRakningVecka($pdo, $postId){

    $sql = "delete from v2monitoring_occasion where id = :postId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
    $stmt->execute();

}


function getLocationYearWeekData($pdo, $monitoringOccasion, $locality){
    $sql = "select ID, ML_ID, TAXA_ID, MO_ID, ANTAL, OBSERVER_ID, 0 AS SNR, 0 AS LONG_AVG, '' AS NAME from v2monitoring_occasion_location_count where MO_ID = :id and ML_ID = :place_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $monitoringOccasion, PDO::PARAM_INT);
    $stmt->bindParam(":place_id", $locality, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * provides the week's list of taxa and the average count
 */
function getWeeklyAveragePerPlace($pdo, $week, $place, $lang){

    $sql = "SELECT v2v_mon_summary_data.TAXA_ID, v2v_mon_summary_data.ML_ID, 
    v2v_mon_summary_data.WEEK, v2v_taxa_names.NAME, v2v_taxa_names.SNR, round(sum(v2v_mon_summary_data.ANTAL)/(SELECT count(WEEK) AS ANT_VECKOR FROM v2monitoring_occasion where WEEK = '01'),0) AS 
    AVG_ALLA_AR, 0 AS ANTAL FROM v2v_mon_summary_data, v2v_taxa_names WHERE v2v_taxa_names.ID = v2v_mon_summary_data.TAXA_ID 
    AND WEEK = :week AND ML_ID = :lokal and v2v_taxa_names.LANGUAGE_ID = :langid GROUP BY SNR, ML_ID, WEEK order by v2v_taxa_names.SNR";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":week", $week, PDO::PARAM_STR);
    $stmt->bindParam(":langid", $lang, PDO::PARAM_STR);
    $stmt->bindParam(":lokal", $place, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWeekTable($pdo, $year, $vecka, $lang){

    $sql = "SELECT
            YEAR,
            WEEK,
            NAME,
            SUM(CASE WHEN ML_ID = 5 THEN ANTAL END) BLACK,
            SUM(CASE WHEN ML_ID = 6 THEN ANTAL END) KANALEN,
            SUM(CASE WHEN ML_ID = 7 THEN ANTAL END) ANGSNASET,
            SUM(CASE WHEN ML_ID = 1 THEN ANTAL END) NABBEN,   
            SUM(CASE WHEN ML_ID = 9 THEN ANTAL END) SLUSAN,    
            SUM(CASE WHEN ML_ID = 10 THEN ANTAL END) REVLARNA,
            SUM(CASE WHEN ML_ID = 11 THEN ANTAL END) KNOSEN
        FROM
            v2v_rr_summary
        where YEAR = :year AND WEEK = :week and language_id = :lang      
        GROUP BY YEAR, WEEK, TAXA_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":week", $vecka, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeRRObservation($pdo, $mo, $ml, $taxa, $antal, $observator, $datum, $updater){

    $dummyId = 0;
    $sql = "insert into v2monitoring_occasion_location_count (id, mo_id, ml_id, taxa_id, antal, observer_id, updated_by, created_by, mo_date) values(?,?,?, ?,?,?, ?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $mo, $ml, $taxa, $antal, $observator, $updater, $updater, $datum]);

}


function updateRRObservation($pdo, $id, $antal, $observator, $datum, $updater){

    $sql = "update v2monitoring_occasion_location_count set antal = :antal, observer_id = :observer, updated_by = :updater, mo_date = :datum where id = :id ";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":antal", $antal, PDO::PARAM_INT);
    $stmt->bindParam(":observer", $observator, PDO::PARAM_INT);
    $stmt->bindParam(":updater", $updater, PDO::PARAM_INT);
    $stmt->bindParam(":datum", $datum, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();


}


function deleteRRObservation($pdo, $recordId){

    $sql = "DELETE FROM v2monitoring_occasion_location_count where id = :record_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":record_id", $recordId, PDO::PARAM_INT);
    $stmt->execute();

}


// ========================================================== D A G B O K E N =========================================
function updateBlogEntry($pdo, $id, $htmlText, $updater){

    $sql = "update v2blogtexts set TEXT = :htmlText, CHANGED_BY = :userId where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":htmlText", $htmlText, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":userId", $updater, PDO::PARAM_INT);
    $stmt->execute();

}


function getAllBlogDates($pdo){

    $sql = "SELECT BLOGDATE from v2blog_db_entries";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getBlogEntriesForDate($pdo, $d){

    $sql = "SELECT * from v2v_blogs_a_texts where BLOGDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $d, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getBlogForDate($pdo, $d){


    $sql = "SELECT * from v2blog_db_entries where BLOGDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $d, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getBlogViaId($pdo, $id){

    $sql = "SELECT * from v2blogtexts where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeBlogRecord($pdo, $dateToWrite, $userId){

    $dummyId = 0;
    $sql = "insert into v2blog_db_entries (ID, BLOGDATE, CREATED_BY ) values(?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $dateToWrite, $userId]);

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeDagBoksBladsText($pdo, $dagboksblad_id, $language_id, $text, $updater){

    $dummyId = 0;
    $published = 0;
    $sql = "insert into v2blogtexts (id, blog_id, LANGUAGE_ID, published, TEXT, CREATED_BY, CHANGED_BY) values(?,?, ?,? ,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $dagboksblad_id, $language_id, $published, $text, $updater, $updater]);

}


function changePublishingStatus($pdo, $id, $status, $userId){

    $sql = "update v2blogtexts set published = :status, CHANGED_BY = :userId where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function deleteBlogEntry($pdo, $id, $blogId ){

    $sql = "delete from v2dagboksbladstexter where id = :theId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":theId", $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "select * from v2dagboksbladstexter where dagboksblad_id = :blogId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":blogId", $blogId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($result) == 0){
        // remove the head, as all children are gone
        $sql = "delete from v2dagboksblad where id = :blogId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":blogId", $blogId, PDO::PARAM_INT);
        $stmt->execute();

        // and also keywords!
        removeKeywordsForBlog($pdo, $blogId);
    }

}


function removeKeywordsForBlog($pdo, $blogId){

    $sql = "delete from v2blog_keywords where BLOG_ID = :theId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":theId", $blogId, PDO::PARAM_INT);
    $stmt->execute();
}


function writeBlogKeyword($pdo, $blogId, $keywordId, $user){


    $sql = "insert into v2blog_keywords set ID = :id, BLOG_ID = :blogId, KEYWORD_ID = :keywordid, CREATED_BY = :userid, UPDATED_BY = :userid";

    $dummyId = 0;
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":blogId", $blogId, PDO::PARAM_INT);
    $stmt->bindParam(":keywordid", $keywordId, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $user , PDO::PARAM_INT);

    $stmt->execute();

}


function getStandardWorkSchemes($pdo, $workAreaId, $languageId, $dateYmd){

    $sql = "select * from v2v_workschemes_a_texts where WORKAREA_ID = :workAreaId and LANGUAGE_ID = :languageId and STANDARDIZED = 1 order by SORTORDER";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":workAreaId", $workAreaId, PDO::PARAM_INT);
    $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
    $stmt->execute();

    $svar = array();

    $standardWorkSchemes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ( $standardWorkSchemes as $standardWorkScheme ){
        $schemeData = array();
        $ringingData = getRingingDateTotals($pdo, $dateYmd, $languageId, $standardWorkScheme['TEXT_CODE']);
        $schemeData['ringingData'] = $ringingData;
        $schemeData['workSchemeData'] = $standardWorkScheme;

        $svar[] = $schemeData;
    }

    return $svar;

}


function removeZeroDayData($pdo, $date){

    $sql = "delete from v2workschemes_dates where ACTIVITY_DATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();

}


function writeZeroDayData($pdo, $date, $user, $workSchemeId, $status, $text ){


    $sql = "insert into v2workschemes_dates set ID = :id,
                                                ACTIVITY_DATE = :date,
                                                STATUS = :status, 
                                                WORKSCHEME_ID = :workSchemeId,                                                
                                                TEXT = :text,                                                
                                                CREATED_BY = :userId, 
                                                CHANGED_BY = :userId";

    $dummyId = 0;
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":date", $date , PDO::PARAM_STR);
    $stmt->bindParam(":workSchemeId", $workSchemeId, PDO::PARAM_INT);
    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text , PDO::PARAM_STR);
    $stmt->bindParam(":userId", $user , PDO::PARAM_INT);

    $stmt->execute();

}


function getWorkSchemesDatesStatuses($pdo, $lang){

    $sql = "SELECT WDS_ID, TEXT FROM v2workschemes_dates_status_texts WHERE LANGUAGE_ID = :lang";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getFullZeroDayData($pdo, $date, $language){

    $sql = "select * from v2v_workschemes_zero_days where ACTIVITY_DATE = :date and LANGUAGE_ID = :language";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getZeroDayData($pdo, $date){

    $sql = "select ID, WORKSCHEME_ID, ACTIVITY_DATE, STATUS, TEXT from v2workschemes_dates where ACTIVITY_DATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


// ===================================================================== G A L L E R I ==========================
function getAllMiniPics($pdo){


    $sql = "SELECT * from v2v_all_images_photographer order by IMAGE_ID desc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPicViaId($pdo, $id){

    $sql = "SELECT * FROM v2images where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAllPicDataViaId($pdo, $id, $language_id){

    $resultData = array();

    $baseData = getPicViaId($pdo, $id);
    array_push($resultData, $baseData);

    $taxaData = getTaxaDataForPhoto($pdo, $id, $language_id);
    array_push($resultData, $taxaData);

    $keywordsData = getKeywordsForPhoto($pdo, $id, $language_id);
    array_push($resultData, $keywordsData);

    return $resultData;

}


function writeImageData($pdo, $datum, $photographer, $place, $published, $keywords, $taxa, $u){

    $sql = "insert into v2images set ID = :id, DATUM = :datum, PERSON_ID = :fotograf, PLATS = :plats, PUBLISHED = :published, CREATED_BY = :userid";

    $dummyId = 0;

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":datum", $datum, PDO::PARAM_STR);
    $stmt->bindParam(":fotograf", $photographer, PDO::PARAM_INT);
    $stmt->bindParam(":plats", $place, PDO::PARAM_STR);
    $stmt->bindParam(":published", $published, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $u, PDO::PARAM_INT);
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $lastId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $writtenImageId = $lastId[0]['ID'];

    $aKeywords = explode(',', $keywords);
    foreach ($aKeywords as $keywordId) {
        writePicKeyword($pdo, $writtenImageId, $keywordId);
    }

    $aTaxa = explode(',', $taxa);
    foreach ($aTaxa as $taxaId) {
        writePicTaxa($pdo, $writtenImageId, $taxaId);
    }

    return $writtenImageId;

}


function getImageId($pdo, $photographer){

    $sql = "select max(id) as maxid from v2images where PERSON_ID = :photographer";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":photographer", $photographer, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writePicKeyword($pdo, $writtenImageId, $keywordId){

    $sql = "insert into v2images_keywords set ID = :id, IMAGE_ID = :imageId, KEYWORD_ID = :keywordid, CREATED_BY = :userid, CHANGED_BY = :userid, CHANGED_AT = :now, CREATED_AT = :now";

    $dummyId = 0;
    $d = date("Y-m-d H:i:s");
    $loggedinUserId = getLoggedInUserId();

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":imageId", $writtenImageId, PDO::PARAM_INT);
    $stmt->bindParam(":keywordid", $keywordId, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $loggedinUserId , PDO::PARAM_INT);
    $stmt->bindParam(":now", $d, PDO::PARAM_STR);

    $stmt->execute();

}


function writePicTaxa($pdo, $writtenImageId, $taxaId){

    $sql = "insert into v2images_taxa set ID = :id, IMAGE_ID = :imageId, TAXA_ID = :taxaid, CREATED_BY = :userid, CHANGED_BY = :userid, CHANGED_AT = :now, CREATED_AT = :now";

    $dummyId = 0;
    $d = date("Y-m-d H:i:s");
    $loggedInUserId = getLoggedInUserId();

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":imageId", $writtenImageId, PDO::PARAM_INT);
    $stmt->bindParam(":taxaid", $taxaId, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $loggedInUserId , PDO::PARAM_INT);
    $stmt->bindParam(":now", $d, PDO::PARAM_STR);

    $stmt->execute();

}


function removeKeywordsAndTaxaForImage($pdo, $imageId){

    $sql = "delete from v2images_taxa where IMAGE_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $imageId, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "delete from v2images_keywords where IMAGE_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $imageId, PDO::PARAM_INT);
    $stmt->execute();

}


function removeImageRecord($pdo, $imageId){

    $sql = "delete from v2images where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $imageId, PDO::PARAM_INT);
    $stmt->execute();

}


function updateImageData($pdo, $datum, $photographer, $place, $published, $imageId){


    $sql = "update v2images set DATUM = :datum, PERSON_ID = :fotograf, PLATS = :plats, PUBLISHED = :published, CHANGED_AT = :changed, CHANGED_BY = :userid where id = :imageId";
    $loggedinUserId = getLoggedInUserId();
    $d = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":datum", $datum, PDO::PARAM_STR);
    $stmt->bindParam(":fotograf", $photographer, PDO::PARAM_INT);
    $stmt->bindParam(":plats", $place, PDO::PARAM_STR);
    $stmt->bindParam(":published", $published, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $loggedinUserId , PDO::PARAM_INT);
    $stmt->bindParam(":changed", $d , PDO::PARAM_STR);
    $stmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);

    $stmt->execute();

}


// ===================================================================== K E Y W O R D S ===========================



function getKeywordTranslations($pdo, $id){

    $sql = "SELECT LANG_ID, LANGUAGE, TEXT FROM v2v_keywords_translations_a_languages where KEYWORD_ID = :id order by LANGUAGE";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeywordsOverSattningarForCategory($pdo, $kw_cat, $lang){

    $sql = "SELECT KEYWORD_ID AS ID, TEXT FROM v2v_keywords_translations_a_keywordcategories where LANG_ID = :lang AND KEYWORDCATEGORY_ID = :cat order by TEXT";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->bindParam(":cat", $kw_cat, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeyword($pdo, $id){
    $sql = "SELECT KEYWORDCATEGORY_ID, TEXT FROM v2keywords where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllKeywordsButOneWithinCategory($pdo, $category, $exclude){

    $sql = "SELECT TEXT FROM v2keywords where ID <> :exclude AND KEYWORDCATEGORY_ID = :cat";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cat", $category, PDO::PARAM_INT);
    $stmt->bindParam(":exclude", $exclude, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function updateKeyword($pdo, $keywordCategoryId, $id, $theText, $loggedInUserId){

    $sql = "update v2keywords set TEXT = :text, KEYWORDCATEGORY_ID = :category , updated_by = :updatedby where id = :id ";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":text", $theText, PDO::PARAM_STR);
    $stmt->bindParam(":updatedby", $loggedInUserId, PDO::PARAM_INT);
    $stmt->bindParam(":category", $keywordCategoryId, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
}


function deleteKeyword($pdo, $id){

    $sql = "DELETE FROM v2keywords where id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

}


function writeKeyword($pdo, $keywordCategoryId, $text, $loggedInUser){

    $dummyId = 0;
    $sql = "insert into v2keywords (ID, KEYWORDCATEGORY_ID, TEXT, CREATED_BY) values (?, ?, ?, ?) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $keywordCategoryId, $text, $loggedInUser]);

}


function deleteKeywordTranslations($pdo, $id){

    $sql = "delete from v2keywords_translations where keyword_id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function writeKeywordTranslationText($pdo, $langId, $id, $text, $loggedInUserId){

    $sql = "insert into v2keywords_translations (ID, LANG_ID, KEYWORD_ID, TEXT, CREATED_BY) values (?, ?, ?, ?, ?) ";

    $dummyId = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $langId, $id, $text, $loggedInUserId]);

}


function getKeywordsForPhoto($pdo, $photo_id, $language_id){

    $sql = "SELECT * from v2v_images_keywords where IMAGE_ID = :imageId and LANG_ID = :langid";

    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":imageId", $photo_id, PDO::PARAM_INT);
    $stmt->bindParam(":langid", $language_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeywordsForBlog($pdo, $blog_id, $language_id){

    $sql = "SELECT * from v2v_blog_keyword_texts where BLOG_ID = :recordId and LANG_ID = :langid";

    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":recordId", $blog_id, PDO::PARAM_INT);
    $stmt->bindParam(":langid", $language_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeywordsForPublication($pdo, $publication_id, $language_id){

    $sql = "SELECT * from v2v_publications_keywords_texts where PUBLICATION_ID = :publicationId and LANG_ID = :languageId";

    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":publicationId", $publication_id, PDO::PARAM_INT);
    $stmt->bindParam(":languageId", $language_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


// ----------- keyword categories ----------------------------------------------------------------------------
function getAllKeywordCategoriesOverSattningar($pdo, $lang){

    $sql = "SELECT KEYWORDCATEGORY_ID AS ID, TEXT FROM v2v_keywordcategories_translations_a_languages where LANG_ID = :lang order by TEXT";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeywordTableData($pdo){

    $sql = "select * from  v2v_keywords_keywordcategories order by KEYWORD_TEXT";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getKeywordTranslationsData($pdo){

    $sql = "select * from  v2v_keywords_keywordcategories order by KEYWORD_TEXT";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// ================================================ T A X A ===================================================
function getTaxaDataForPhoto($pdo, $imageId, $language){

    $sql = "select * from v2v_images_taxanames where IMAGE_ID = :id and LANGUAGE_ID = :language";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $imageId, PDO::PARAM_INT);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTaxaForPublication($pdo, $id, $language){

    $sql = "select * from v2v_publications_taxa_names where PUBLICATION_ID = :id and LANGUAGE_ID = :language";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTaxa($pdo, $lang){

    $sql = "SELECT TAXA_ID, SNR, NAME AS TEXT, DECIGRAMS, SHORTNAME, LANGUAGE_ID from v2v_taxa_a_names WHERE LANGUAGE_ID = :lang order by SNR ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTaxaTranslations($pdo, $id){

    $sql = "SELECT ID, NAME AS TEXT, LANGUAGE, LANGUAGE_ID  from v2v_taxa_names_lang WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function deleteTaxaTranslations($pdo, $taxa_id){

    $sql = "delete from v2taxa_names where TAXA_ID = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $taxa_id, PDO::PARAM_INT);
    $stmt->execute();


}

function deleteTaxa($pdo, $id){

    $sql = "delete from v2taxa where ID = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function deleteTaxaMeasurementConfiguration($pdo, $taxa_id){

    $sql = "delete from v2taxa_measurements_configuration where TAXA_ID = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $taxa_id, PDO::PARAM_INT);
    $stmt->execute();

}


function writeTaxaMeasurementConfiguration($pdo, $taxa_id, $measurementType, $sex, $age, $months, $min, $max){

    logg("writing");

    $sql = "insert into v2taxa_measurements_configuration set ID = :id, 
                                                TAXA_ID = :taxa_id, 
                                                MEASUREMENT_ID = :measurementType, 
                                                SEX_ID = :sex,
                                                AGE_ID = :age, 
                                                MONTHS = :months, 
                                                LOWERMIN = :min, 
                                                UPPERMAX = :max";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":taxa_id", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":measurementType", $measurementType, PDO::PARAM_INT);
    $stmt->bindParam(":sex", $sex, PDO::PARAM_INT);
    $stmt->bindParam(":age", $age, PDO::PARAM_INT);
    $stmt->bindParam(":months", $months, PDO::PARAM_STR);
    $stmt->bindParam(":min", $min, PDO::PARAM_STR);
    $stmt->bindParam(":max", $max, PDO::PARAM_STR);

    $stmt->execute();

}


function getMeasurementConfigurationData($pdo, $taxa_id, $lang_id){

    $sql = "SELECT * from v2v_taxa_measurements_configurations WHERE taxa_id = :taxa_id and MEASUREMENT_LANG = :lang_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxa_id", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang_id", $lang_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllMeasurementConfigurationData($pdo){

    $sql = "SELECT * from v2taxa_measurements_configuration";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMeasurementConfigurationDataForTaxa($pdo, $taxa_id){

    $sql = "SELECT * from v2taxa_measurements_configuration WHERE taxa_id = :taxa_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxa_id", $taxa_id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


// --------------------------------------------------------------------------------- TAXA CODE TYPES--------------------
function getTaxaCodesAndTexts($pdo, $taxa_id, $lang_id){

    $sql = "SELECT * from v2v_taxacode_types_texts WHERE TAXA_ID = :taxa_id and LANG_ID = :lang_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxa_id", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang_id", $lang_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTaxaCodesTypes($pdo){

    $sql = "SELECT ID AS ID, TEXT from v2taxacode_types";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllTaxaCodesTypes($pdo, $lang_id){

    $sql = "SELECT TAXACODE_TYPE_ID AS ID, TEXT from v2v_taxacode_types_texts_a_language where LANGUAGE = :lang_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang_id", $lang_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTaxaCodeTypeViaId($pdo, $id){

    $sql = "SELECT ID, TEXT from v2taxacode_types where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function deleteTaxaCodeTypeCodes($pdo, $taxa_id){

    $sql = "delete from v2taxacode_types_codes where TAXA_ID = :taxaId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxaId", $taxa_id, PDO::PARAM_INT);
    $stmt->execute();

}

function deleteTaxaRingTypes($pdo, $taxa_id){

    $sql = "delete from v2taxa_ring_types where TAXA_ID = :taxaId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxaId", $taxa_id, PDO::PARAM_INT);
    $stmt->execute();

}

function writeTaxaRingType($pdo, $ring_type_id, $taxa_id, $value, $user){

    $sql = "insert into v2taxa_ring_types set ID = :id, RING_TYPE_ID = :ringTypeId, PRIO = :value, TAXA_ID = :taxaId, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":taxaId", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":ringTypeId", $ring_type_id, PDO::PARAM_INT);
    $stmt->bindParam(":value", $value, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);

    $stmt->execute();

}

function writeTaxaCodeTypeCode($pdo, $codeType_id, $taxa_id, $value, $user){

    $sql = "insert into v2taxacode_types_codes set ID = :id, TAXACODE_TYPE_ID = :codeTypeId, CODE = :code, TAXA_ID = :taxaId, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":taxaId", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":codeTypeId", $codeType_id, PDO::PARAM_INT);
    $stmt->bindParam(":code", $value, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);

    $stmt->execute();

}

function updateTaxaCodeType($pdo, $id, $name, $user){

    $sql = "update v2taxacode_types set TEXT = :name, CHANGED_BY = :user where ID = :id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();
}

function deleteTaxaCodeType($pdo, $taxacode_type_id){

    $sql = "delete from v2taxacode_types where ID = :id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $taxacode_type_id, PDO::PARAM_INT);

    $stmt->execute();
}


function writeTaxaCodeType($pdo, $name, $user){

    $dummyId = 0;
    $sql = "insert into v2taxacode_types set ID = :id, TEXT = :name, CREATED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();
}



function writeTaxaCodeTypeTranslationText($pdo, $language_id, $taxacode_type_id, $text){

    $sql = "insert into v2taxacode_types_texts set ID = :id, TAXACODE_TYPE_ID = :taxacode_type_id, TEXT = :text, LANG_ID = :language_id";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":taxacode_type_id", $taxacode_type_id, PDO::PARAM_INT);
    $stmt->bindParam(":language_id", $language_id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);

    $stmt->execute();

}


function deleteTaxaCodeTypeTranslationTexts($pdo, $taxacode_type_id){

    $sql = "delete from v2taxacode_types_texts where TAXACODE_TYPE_ID = :taxacode_type_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxacode_type_id", $taxacode_type_id, PDO::PARAM_INT);
    $stmt->execute();

}



function getTaxaCodeTypeTranslations($pdo, $id){

    $sql = "select * from v2v_taxacode_types_texts_a_language where TAXACODE_TYPE_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



//--------------------------------------------------------------------------------------------------------T A X A-------
function writeTaxaTranslationText($pdo, $language_id, $taxa_id, $name){

    $sql = "insert into v2taxa_names set ID = :id, TAXA_ID = :taxa_id, NAME = :name, LANGUAGE_ID = :language_id";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":taxa_id", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":language_id", $language_id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);

    $stmt->execute();

}



function getBaseTaxa($pdo, $id){

    $sql = "SELECT * from v2taxa WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getBaseTaxaViaShortName($pdo, $art){

    $sql = "SELECT ID from v2taxa WHERE SHORTNAME = :art";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":art", $art, PDO::PARAM_STR);
    $stmt->execute();
    $aResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $answer = '-1';
    if (count($aResult) > 0) {
        $t = $aResult[0];
        $answer = $t["ID"];
    }

    return $answer;

}


function updateTaxaInList($pdo, $shortName, $taxaId){

$sql = "update v2taxa_local_list_records set TAXA_ID = :taxaId where SHORTNAME = :shortName";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":taxaId", $taxaId, PDO::PARAM_INT);
$stmt->bindParam(":shortName", $shortName, PDO::PARAM_STR);

$stmt->execute();


}


function getAllBaseTaxa($pdo){

    $sql = "SELECT * from v2taxa order by SNR ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updateTaxa($pdo, $id, $snr, $shortName, $scientificName, $deciGrams){

    $sql = "update v2taxa set SNR = :snr, SHORTNAME = :shortName, SCINAME = :scientificName, DECIGRAMS = :deci where ID = :id ";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":snr", $snr, PDO::PARAM_INT);
    $stmt->bindParam(":deci", $deciGrams, PDO::PARAM_INT);
    $stmt->bindParam(":shortName", $shortName, PDO::PARAM_STR);
    $stmt->bindParam(":scientificName", $scientificName, PDO::PARAM_STR);

    $stmt->execute();
}


function writeTaxa($pdo, $snr, $shortName, $scientificName, $deciGrams){

    $id = 0;
    $sql = "insert into v2taxa set ID = :id, SNR = :snr, SHORTNAME = :shortName, SCINAME = :scientificName, DECIGRAMS = :deci";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":snr", $snr, PDO::PARAM_INT);
    $stmt->bindParam(":deci", $deciGrams, PDO::PARAM_INT);
    $stmt->bindParam(":shortName", $shortName, PDO::PARAM_STR);
    $stmt->bindParam(":scientificName", $scientificName, PDO::PARAM_STR);

    $stmt->execute();
}


function updateTaxaSnr($pdo, $id, $snr){

    $sql = "update v2taxa set SNR = :snr where ID = :id";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":snr", $snr, PDO::PARAM_INT);

    $stmt->execute();

}


// ===================================================================================================================
function logTheLogin($pdo, $id){

    $dummyId = 0;
    $sql = "insert into v2user_activity (id, USER_ID) values(?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $id]);

}


// ======= P U B L I C A T I O N S ==================================================================================
function getAllPublications($pdo){

    $sql = "SELECT ID, AUTHOR, YEAR, TITLE AS TITEL, JOURNAL from v2publications";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPublicationViaId($pdo, $id){

    $sql = "SELECT * FROM v2publications where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updatePublicationData($pdo, $id, $title, $journal, $author, $year, $published){


    $sql = "update v2publications set TITLE = :title, JOURNAL = :journal, AUTHOR = :author, YEAR = :year, PUBLISHED = :published, CHANGED_AT = :changed, CHANGED_BY = :userid where id = :id";
    $loggedinUserId = getLoggedInUserId();
    $d = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":journal", $journal, PDO::PARAM_STR);
    $stmt->bindParam(":author", $author, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":published", $published, PDO::PARAM_INT);

    $stmt->bindParam(":userid", $loggedinUserId , PDO::PARAM_INT);
    $stmt->bindParam(":changed", $d , PDO::PARAM_STR);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
    
}


function writePublicationData($pdo, $title, $journal, $author, $year, $published, $keywords, $taxa){

    $sql = "insert into v2publications set ID = :id, DATUM = :datum, PERSON_ID = :fotograf, PLATS = :plats, PUBLISHED = :published, CREATED_BY = :userid";

    $dummyId = 0;
    $u = getLoggedInUserId();

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":author", $author, PDO::PARAM_STR);
    $stmt->bindParam(":journal", $journal, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":published", $published, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $u, PDO::PARAM_INT);
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $lastId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $writtenId = $lastId[0]['ID'];

    $aKeywords = explode(',', $keywords);
    foreach ($aKeywords as $keywordId) {
        //writePicKeyword($pdo, $writtenId, $keywordId);
    }

    $aTaxa = explode(',', $taxa);
    foreach ($aTaxa as $taxaId) {
        //writePicTaxa($pdo, $writtenId, $taxaId);
    }

    return $writtenId;

}


// ================================================================================= R I N G I N G ====================
function getLocations($pdo){

    $sql = "SELECT * FROM v2locations order by TEXT";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLocation($pdo, $id){

    $sql = "SELECT * FROM v2locations where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLocationTranslations($pdo, $id){

    $sql = "SELECT LOCATION_ID, TRANSLATION_ID, LANG_ID, LOCALITY_TEXT, LANGUAGE_TEXT FROM v2v_localities_a_translations where LOCATION_ID = :id order by LANG_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLocationsOptions($pdo, $langId){

    $sql = "SELECT LOCATION_ID, LOCATION FROM v2v_locations_a_texts where lang_id = :langId order by LOCATION";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $langId, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function deleteLocationTranslations($pdo, $id){

    $sql = "delete from v2locations_translations where LOCATION_ID = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function deleteLocation($pdo, $id){

    $sql = "delete from v2locations where ID = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function writeLocationText($pdo, $langId, $id, $text, $loggedInUserId){

    $sql = "insert into v2locations_translations (ID, LOCATION_ID, LANG_ID, TEXT, CREATED_BY, CHANGED_BY) values (?, ?, ?, ?, ?, ?) ";

    $dummyId = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $id, $langId, $text, $loggedInUserId, $loggedInUserId]);

}


function writeLocation($pdo, $name, $systematic, $monitoring, $loggedInUser){

    $dummyId = 0;
    $sql = "insert into v2locations (ID, TEXT, SYSTEMATIC, MONITORING, CREATED_BY, CHANGED_BY) values (?, ?, ?, ?,  ?, ? ) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$dummyId, $name, $systematic, $monitoring, $loggedInUser, $loggedInUser]);

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data[0]['ID'];

}


function updateLocation($pdo, $id, $name, $systematic, $monitoring, $loggedInUser){

    $sql = "update v2locations set TEXT = :text, SYSTEMATIC = :systematic, MONITORING = :monitoring, CHANGED_BY = :changedby where id = :id ";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":text", $name, PDO::PARAM_STR);
    $stmt->bindParam(":systematic", $systematic, PDO::PARAM_INT);
    $stmt->bindParam(":monitoring", $monitoring, PDO::PARAM_INT);
    $stmt->bindParam(":changedby", $loggedInUser, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
}


function getAllNewBlogTexts($pdo){

    $sql = "select * from v2dagboksbladstexter";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeImportImageData($pdo, $datum, $photographer, $place, $published){

    $sql = "insert into v2images set ID = :id, DATUM = :datum, PERSON_ID = :fotograf, PLATS = :plats, PUBLISHED = :published, CREATED_BY = :userid";

    $dummyId = 0;
    $u = 1;

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);
    $stmt->bindParam(":datum", $datum, PDO::PARAM_STR);
    $stmt->bindParam(":fotograf", $photographer, PDO::PARAM_INT);
    $stmt->bindParam(":plats", $place, PDO::PARAM_STR);
    $stmt->bindParam(":published", $published, PDO::PARAM_INT);
    $stmt->bindParam(":userid", $u, PDO::PARAM_INT);
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $lastId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $writtenImageId = $lastId[0]['ID'];

    writePicKeyword($pdo, $writtenImageId, '94');

    return $writtenImageId;

}

// --------------------------------------------------------------------- measurements ---------------------------------
function getAllMeasurements($pdo){

    $sql = "select * from v2taxa_measurements order by STANDARD, SORTORDER";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMeasurementViaId($pdo, $id){

    $sql = "select * from v2taxa_measurements where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
//                        1     2        3                     4          5              6  7     8         9    10    11
function writeMeasurement($pdo, $name, $standardMeasurement, $sortOrder, $displaySpecified, $sex, $age, $months, $valCommon, $min, $max, $user){

    $id = 0;
    $sql = "insert into v2taxa_measurements set TEXT = :name, 
                                           STANDARD = :standard,
                                           SORTORDER = :sortOrder,
                                           DISP_SPEC = :displaySpecified, 
                                           SEX = :sex,
                                           AGE = :age,
                                           MONTHS = :months,
                                           VAL_COMMON = :valCommon,
                                           LOWERMIN = :min,
                                           UPPERMAX = :max,
                                           CHANGED_BY = :user, 
                                           ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":standard", $standardMeasurement, PDO::PARAM_INT);
    $stmt->bindParam(":sortOrder", $sortOrder, PDO::PARAM_INT);
    $stmt->bindParam(":displaySpecified", $displaySpecified, PDO::PARAM_INT);
    $stmt->bindParam(":sex", $sex, PDO::PARAM_INT);
    $stmt->bindParam(":age", $age, PDO::PARAM_INT);
    $stmt->bindParam(":months", $months, PDO::PARAM_STR);
    $stmt->bindParam(":valCommon", $valCommon, PDO::PARAM_INT);
    $stmt->bindParam(":min", $min, PDO::PARAM_INT);
    $stmt->bindParam(":max", $max, PDO::PARAM_INT);
    $stmt->execute();

}

//
// $pdo, $id, $name, $standardMeasurement, $sortOrder, $displaySpecified, $sex, $age, $months, $valCommon, $min, $max, $_SESSION['loggedin']
//updateMeasurement(Object(PDO), '12', 'ManuXXXXXXXXXXX', '1', '1', '1',                    '4',  '99',  '',     '2',  '5',    1)
function updateMeasurement($pdo, $id, $name, $standardMeasurement, $sortOrder, $displaySpecified, $sex, $age, $months, $valCommon, $min, $max, $user){

    $sql = "update v2taxa_measurements set TEXT = :name, 
                                           STANDARD = :standard,
                                           SORTORDER = :sortOrder,
                                           DISP_SPEC = :displaySpecified,
                                           SEX = :sex,
                                           AGE = :age,
                                           MONTHS = :months,
                                           VAL_COMMON = :valCommon,                               
                                           LOWERMIN = :min,
                                           UPPERMAX = :max,
                                           CHANGED_BY = :user 
                                           where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":standard", $standardMeasurement, PDO::PARAM_INT);
    $stmt->bindParam(":sortOrder", $sortOrder, PDO::PARAM_INT);
    $stmt->bindParam(":displaySpecified", $displaySpecified, PDO::PARAM_INT);
    $stmt->bindParam(":sex", $sex, PDO::PARAM_INT);
    $stmt->bindParam(":age", $age, PDO::PARAM_INT);
    $stmt->bindParam(":months", $months, PDO::PARAM_STR);
    $stmt->bindParam(":valCommon", $valCommon, PDO::PARAM_INT);
    $stmt->bindParam(":min", $min, PDO::PARAM_INT);
    $stmt->bindParam(":max", $max, PDO::PARAM_INT);
    $stmt->execute();


}

function getMeasurementsTranslations($pdo, $id){

    $sql = "select * from v2v_taxa_measurement_a_language where MEASUREMENT_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function deleteMeasurementTranslations($pdo, $id){

    $sql = "delete from v2taxa_measurements_texts where MEASUREMENT_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}

function deleteMeasurement($pdo, $id){

    $sql = "delete from v2taxa_measurements where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}

function writeMeasurementTranslationText($pdo, $language_id, $measurement_id, $text, $user){

    $id = 0;
    $sql = "insert into v2taxa_measurements_texts set TEXT = :text, LANG_ID = :language_id, ID = :id, MEASUREMENT_ID = :measurementId, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":language_id", $language_id, PDO::PARAM_INT);
    $stmt->bindParam(":measurementId", $measurement_id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();


}

function getMeasurements($pdo, $locationAndDateId, $lang){

    $sql = "select * from v2v_ringing_measurements where LANG_ID = :langId and RINGING_DATA_ID IN (select ID from v2ringing_dates_locations_data where RINGING_DATES_LOCATIONS_ID = :locationAndDateId)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":locationAndDateId", $locationAndDateId, PDO::PARAM_INT);
    $stmt->bindParam(":langId", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getStandardMeasurementsIsUsed($pdo, $locationAndDateId, $lang){

    $sql = "select * from v2v_ringing_measurements where LANG_ID = :langId and RINGING_DATA_ID IN (select ID from v2ringing_dates_locations_data where RINGING_DATES_LOCATIONS_ID = :locationAndDateId)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":locationAndDateId", $locationAndDateId, PDO::PARAM_INT);
    $stmt->bindParam(":langId", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//-------------------------------------------------------------------------------- trapping methods -----------------
function getTrappingMethods($pdo, $language){

    $sql = "select TRAPPING_METHOD_ID as ID, TEXT from v2v_trapping_method_a_language where language = :language";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTrappingMethodViaId($pdo, $id){

    $sql = "select * from v2trapping_methods where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTrappingMethodTranslations($pdo, $id){

    $sql = "select * from v2v_trapping_method_a_language where TRAPPING_METHOD_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function updateTrappingMethod($pdo, $id, $name){

    $sql = "update v2trapping_methods set TEXT = :name where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();

}

function writeTrappingMethod($pdo, $name){

    $id = 0;
    $sql = "insert into v2trapping_methods set TEXT = :name, ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();

}

function writeTrappingTranslationText($pdo, $language_id, $trap_id, $text, $user){

    $id = 0;
    $sql = "insert into v2trapping_methods_texts set TEXT = :text, LANG_ID = :language_id, ID = :id, TRAPPING_METHOD_ID = :trapId, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":language_id", $language_id, PDO::PARAM_INT);
    $stmt->bindParam(":trapId", $trap_id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();

}

function deleteTrappingMethodsTranslations($pdo, $id){

    $sql = "delete from v2trapping_methods_texts where TRAPPING_METHOD_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}

function getAllTrappingMethods($pdo){

    $sql = "select * from v2trapping_methods";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function deleteTrappingMethod($pdo, $id){

    $sql = "delete from v2trapping_methods where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}

//------------------------------------------------------------------------------------------------R I N G T Y P E-------
//

function writeRingTypeTranslationText($pdo, $language_id, $ring_type_id, $text, $user){

    $id = 0;
    $sql = "insert into v2ring_types_texts set TEXT = :text, LANG_ID = :language_id, ID = :id, RING_TYPES_ID = :ringTypeId, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":language_id", $language_id, PDO::PARAM_INT);
    $stmt->bindParam(":ringTypeId", $ring_type_id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();


}

function deleteRingTypeTranslations($pdo, $id){

    $sql = "delete from v2ring_types_texts where RING_TYPES_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

}


function getRingTypeTranslations($pdo, $id){

    $sql = "select * from v2v_ring_types_texts_a_language where RING_TYPES_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingTypes($pdo){

    $sql = "select * from v2ring_types order by TYPE_CODE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingTypesForDropDown($pdo, $langId){

    $sql = "select RING_TYPES_ID AS ID,TEXT from v2v_ring_types_texts_a_language where LANGUAGE = :langId order by SIZE";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $langId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingTypeViaId($pdo, $id){

    $sql = "select * from v2v_ring_type where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updateRingType($pdo, $id, $name, $type, $user){

    $sql = "update v2ring_types set TEXT = :name, TYPE_CODE = :type, CHANGED_BY = :user where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":type", $type, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();


}

function deleteRingType($pdo, $id){

    $sql = "delete from v2ring_types where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();


}

function writeRingType($pdo, $name, $type, $user){

    $sql = "insert into v2ring_types set ID = :id, TEXT = :name, TYPE_CODE = :type, CREATED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":type", $type, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();

}

function writeRingTypeLocationRing($pdo, $location_id, $ringtype_id, $ring_no){

    $sql = "insert into v2ringtype_locality_no set ID = :id, RINGTYPE_ID = :ringTypeId, LOCATIONS_ID = :locationId, RINGNO = :ringNo, CREATED_BY = :userId";

    $id = 0;
    $u = getLoggedInUserId();

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":ringTypeId", $ringtype_id, PDO::PARAM_INT);
    $stmt->bindParam(":locationId", $location_id, PDO::PARAM_INT);
    $stmt->bindParam(":ringNo", $ring_no, PDO::PARAM_STR);
    $stmt->bindParam(":userId", $u, PDO::PARAM_INT);
    $stmt->execute();

}


function deleteRingTypeLocationRingNo($pdo, $location_id){

    $sql = "delete from v2ringtype_locality_no where LOCATIONS_ID = :locationId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":locationId", $location_id, PDO::PARAM_INT);
    $stmt->execute();

}

function getLocalityRingTypesNumbers($pdo, $location_id){

    $sql = "select * from v2ringtype_locality_no where LOCATIONS_ID = :locationId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":locationId", $location_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updateUsedRingNo($pdo, $ringTypesLocationId, $ringNo){

    $sql = "update v2ringtype_locality_no set RINGNO = :ringNo  where ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $ringTypesLocationId, PDO::PARAM_INT);
    $stmt->bindParam(":ringNo", $ringNo, PDO::PARAM_STR);
    $stmt->execute();

}


function getTaxaValidationData($pdo){

    $sql = "select * from v2taxa_measurements_configuration ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTaxaRingTypesData($pdo, $taxa_id, $lang_id){

    $sql = "select * from v2v_taxa_a_ring_types where TAXA_ID = :taxaId AND LANG_ID = :langId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxaId", $taxa_id, PDO::PARAM_INT);
    $stmt->bindParam(":langId", $lang_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getAllTaxaRingTypesData($pdo){
    $sql = "SELECT TAXA_ID, RING_TYPE_ID, PRIO FROM v2taxa_ring_types";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function ringingDateLocationAlreadyEntered($pdo, $date, $location){

    $sql = "SELECT * FROM v2ringing_dates_locations where LOCALITY_ID = :id and THEDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":id", $location, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $id = -1;
    if (sizeof($data) > 0){
        $row = $data[0];
        $id = $row['ID'];
    }

    return $id;

}


function writeRingingDateLocation($pdo, $date, $location, $status, $user){

    $sql = "INSERT INTO v2ringing_dates_locations set LOCALITY_ID = :id, THEDATE = :date, STATUS_ID = :status, CREATED_BY = :user, CHANGED_BY = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":id", $location, PDO::PARAM_INT);
    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();

}


function updateRingingDateLocation($pdo, $date, $location, $status, $user){

    $sql = "UPDATE v2ringing_dates_locations set STATUS_ID = :status, CHANGED_BY = :user where LOCALITY_ID = :id and THEDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":id", $location, PDO::PARAM_INT);
    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);
    $stmt->execute();

}


function getRingingRecordId($pdo, $ringNo){

    $sql = "SELECT ID FROM v2ringing_dates_locations_data WHERE RINGNO = :ring";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ring", $ringNo, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeRingingRecord($pdo, $day_id, $hour, $systematic, $trap, $extra, $taxon, $ring, $age, $sex, $user){

    $success = true;
    $sql = "INSERT INTO v2ringing_dates_locations_data set
                                              	ID = :id,
                                              	RINGING_DATES_LOCATIONS_ID = :dayId,
                                                HOUR = :hour,
                                                SYSTEMATIC = :systematic,
                                                TRAPPING_METHOD_ID = :trap,                                               
                                                OBS = :obs,                                            
                                                RINGNO = :ring,                                               
                                                TAXA_ID = :taxon,
                                                AGE = :age,
                                                SEX = :sex,                                           
                                                CREATED_BY = :user,                                               
                                                CHANGED_BY = :user";
    $dummyId = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);                  //0
    $stmt->bindParam(":dayId", $day_id, PDO::PARAM_INT);                //1
    $stmt->bindParam(":hour", $hour, PDO::PARAM_STR);                   //2
    $stmt->bindParam(":systematic", $systematic, PDO::PARAM_INT);       //3
    $stmt->bindParam(":trap", $trap, PDO::PARAM_INT);                   //4
    $stmt->bindParam(":obs", $extra, PDO::PARAM_STR);                   //5
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_INT);                 //6
    $stmt->bindParam(":ring", $ring, PDO::PARAM_STR);                   //7
    $stmt->bindParam(":age", $age, PDO::PARAM_STR);                     //8
    $stmt->bindParam(":sex", $sex, PDO::PARAM_STR);                     //9
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);                   //10
    try {
        $stmt->execute();
    } catch (PDOException $e){
        $success = false;
    }

    return $success;

}


function deleteMeasurements($pdo, $ringingRecId){

    $sql = "delete from v2ringing_dates_locations_data_measurements where RINGING_DATA_ID = :ringingRecId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ringingRecId", $ringingRecId, PDO::PARAM_INT);
    $stmt->execute();

}


function writeMeasurementData($pdo, $ringingRecId, $measurementId, $value, $user){

    $success = true;

    $sql = "INSERT INTO v2ringing_dates_locations_data_measurements set
                                              	ID = :id,
                                              	MEASUREMENT_ID = :measurementId,
                                                RINGING_DATA_ID = :ringingRecId,
                                                VALUE = :value,                                              
                                                CREATED_BY = :user,                                               
                                                CHANGED_BY = :user";
    $dummyId = 0;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $dummyId, PDO::PARAM_INT);                  //0
    $stmt->bindParam(":ringingRecId", $ringingRecId, PDO::PARAM_INT);   //1
    $stmt->bindParam(":measurementId", $measurementId, PDO::PARAM_INT); //2
    $stmt->bindParam(":value", $value, PDO::PARAM_INT);                 //3
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);                   //4
    try {
        $stmt->execute();
    } catch (PDOException $e){
        $success = false;
    }

    return $success;

}


function updateRingingRecord($pdo, $id, $hour, $systematic, $trap, $extra, $taxon, $ring, $age, $sex, $user){

    $sql = "UPDATE v2ringing_dates_locations_data set
                                              	
                                                HOUR = :hour,
                                                SYSTEMATIC = :systematic,
                                                TRAPPING_METHOD_ID = :trap,                                               
                                                OBS = :obs,                                            
                                                RINGNO = :ring,                                               
                                                TAXA_ID = :taxon,
                                                AGE = :age,
                                                SEX = :sex,                                                                                             
                                                CHANGED_BY = :user  
            WHERE ID = :id                                    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);                       //1
    $stmt->bindParam(":hour", $hour, PDO::PARAM_STR);                   //2
    $stmt->bindParam(":systematic", $systematic, PDO::PARAM_INT);       //3
    $stmt->bindParam(":trap", $trap, PDO::PARAM_INT);                   //4
    $stmt->bindParam(":obs", $extra, PDO::PARAM_STR);                   //5
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_INT);                 //6
    $stmt->bindParam(":ring", $ring, PDO::PARAM_STR);                   //7
    $stmt->bindParam(":age", $age, PDO::PARAM_STR);                     //8
    $stmt->bindParam(":sex", $sex, PDO::PARAM_STR);                     //9
    $stmt->bindParam(":user", $user, PDO::PARAM_INT);                   //16
    $stmt->execute();

}


function getRingingDayPlaces($pdo){

    $sql = "select ID, THEDATE, LOCALITY_ID, STATUS_ID from v2ringing_dates_locations";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherDays($pdo){

    $sql = "select datum from v2dagb_vader";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherTimes($pdo){

    $sql = "select ID, TEXT, SHOW_IN_BLOG, SORTORDER from v2dagb_vader_times order by SORTORDER ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherClouds($pdo){

    $sql = "select ID, TEXT from v2dagb_vader_clouds order by SORTORDER ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWeatherWindDirections($pdo){

    $sql = "select ID, TEXT from v2dagb_vader_wind_directions order by SORTORDER ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherForDay($pdo, $ymdDate){

    $sql = "select * from v2v_dagboks_vader where DATUM = :ymdDate order by TIME ASC ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ymdDate", $ymdDate, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherObservationViaId($pdo, $id){

    $sql = "select * from v2dagb_vader where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWeatherTypes($pdo, $lang_id){

    $sql = "select DAGB_VADER_TYPE_ID AS ID, TEXT from v2v_dagboks_vader_types_a_texts where LANG_ID = :lang_id order by SORTORDER ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang_id", $lang_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updateWeatherObservation($pdo, $id, $time, $visibility, $clouds, $windDirection, $windForce, $temperature, $pressure ){

    $sql = "UPDATE v2dagb_vader set
                                              	
                TIME_ID = :time,
                SIKT = :visibility,                                               
                MOLN_ID = :clouds,                                            
                VIRIKT_ID = :windDirection,                                               
                vsty = :windForce,
                TEMP = :temperature,
                TRYCK = :pressure                                                                                             
  
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);                       //1
    $stmt->bindParam(":time", $time, PDO::PARAM_INT);                   //3
    $stmt->bindParam(":visibility", $visibility, PDO::PARAM_STR);       //4
    $stmt->bindParam(":clouds", $clouds, PDO::PARAM_INT);               //5
    $stmt->bindParam(":windDirection", $windDirection, PDO::PARAM_INT); //6
    $stmt->bindParam(":windForce", $windForce, PDO::PARAM_STR);         //7
    $stmt->bindParam(":temperature", $temperature, PDO::PARAM_STR);     //8
    $stmt->bindParam(":pressure", $pressure, PDO::PARAM_STR);           //9

    $stmt->execute();

}

function writeWeatherObservation($pdo, $date, $time, $visibility, $clouds, $windDirection, $windForce, $temperature, $pressure, $keywords ){

    $sql = "INSERT INTO v2dagb_vader set
                ID = :id,       
                DATUM = :date,                             
                TIME_ID = :time,
                SIKT = :visibility,                                               
                MOLN_ID = :clouds,                                            
                VIRIKT_ID = :windDirection,                                               
                vsty = :windForce,
                TEMP = :temperature,
                TRYCK = :pressure                                                                                             
  
          ";
    $stmt = $pdo->prepare($sql);
    $id = 0;
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);                   //1
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);               //2
    $stmt->bindParam(":time", $time, PDO::PARAM_INT);               //2
    $stmt->bindParam(":visibility", $visibility, PDO::PARAM_STR);   //3
    $stmt->bindParam(":clouds", $clouds, PDO::PARAM_INT);                   //4
    $stmt->bindParam(":windDirection", $windDirection, PDO::PARAM_INT);              //5
    $stmt->bindParam(":windForce", $windForce, PDO::PARAM_STR);                 //6
    $stmt->bindParam(":temperature", $temperature, PDO::PARAM_STR);                   //7
    $stmt->bindParam(":pressure", $pressure, PDO::PARAM_STR);                     //8
    $stmt->execute();

    $sql ="SELECT LAST_INSERT_ID() AS ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $lastId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $writtenId = $lastId[0]['ID'];

    $aKeywords = explode(',', $keywords);
    foreach ($aKeywords as $keywordId) {
        writeWeatherObservationWeatherType($pdo, $writtenId, $keywordId);
    }

}

function deleteWeatherObservation($pdo, $id){

    $sql = "delete from v2dagb_vader where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);                   //1
    $stmt->execute();

}

function deleteWeatherObservationWeatherType($pdo, $id){

    $sql = "delete from v2dagb_vader_and_dv_types where DAGB_VADER_ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);                   //1
    $stmt->execute();

}

function writeWeatherObservationWeatherType($pdo, $id, $keyWordId){

    $sql = "insert into v2dagb_vader_and_dv_types set
              DAGB_VADER_TYPE_ID = :keyWordId,
              DAGB_VADER_ID = :id
           ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":keyWordId", $keyWordId, PDO::PARAM_INT);
    $stmt->execute();

}

function getWeatherObservationKeywords($pdo, $id, $lang){

    $sql = "select KEYWORD_ID, TEXT from v2v_weather_keywords where DAGB_VADER_ID = :id and LANG_ID = :lang ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherObservationKeywordsForDate($pdo, $date, $lang){

    $sql = "select DAGB_VADER_ID, TEXT from v2v_weather_keywords where DATUM = :date and LANG_ID = :lang ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingingDataForDayPlace($pdo, $date_locality_id){

    $sql = "select * from v2v_ringing_dates_locations_data where RINGING_DATES_LOCATIONS_ID = :id order by ID DESC ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $date_locality_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMostRecentWeather($pdo){

    $sql = "select max(date) AS MAXDATE from v2v_dagboks_vader";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $maxDate = $result[0]["MAXDATE"];

    $sql = "select * from v2v_dagboks_vader where date = :date order by TIMESORT DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $maxDate, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMostRecentWeatherOldTable($pdo, $lang){

    $sql = "select max(datum) AS MAXDATE from dagb_vader";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $maxDate = $result[0]["MAXDATE"];
    $sqlFields = 'select kl AS TIME, moln AS MOLN, vrik AS WIND , vsty AS WIND_FORCE, temp AS TEMP, sikt AS SIKT, tryck AS TRYCK, ';
    $sqlLangField = ' s_vader AS TEXT';
    if ($lang === '1') {
        $sqlLangField = ' e_vader AS TEXT';
    }
    $sql = $sqlFields . $sqlLangField . " from dagb_vader where datum = :date order by kl DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $maxDate, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWeatherObservationKeywordsForObservation($pdo, $id, $lang){

    $sql = "select DAGB_VADER_ID, TEXT from v2v_weather_keywords where DAGB_VADER_ID = :id and LANG_ID = :lang ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllOldWeatherObservationKeywords($pdo){

    $sql = "select * FROM v2dagb_vader";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeWeatherKeyword($pdo, $id, $text){

    $sql = "insert into a_tmp_w
            set  id = 0,
                text = :text,
                kod = :id
            ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);
    $stmt->execute();


}


function getAllWeatherTypesTexts($pdo){

    $sql = "select * FROM a_tmp_koder";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function updateWeatherKeyword($pdo, $id, $text){

    $sql = "update a_tmp_w
            set DAGB_VADER_TYPE_ID = :id
            where TEXT = :text
            ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":text", $text, PDO::PARAM_STR);
    $stmt->execute();


}


function getMostRecentNewsText($pdo, $lang){

    $sql = "SELECT blogdate AS DATE, TEXT FROM  v2v_blog_a_texts_published where language_id = :lang               
            order by blogdate desc LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNewsTextForDate($pdo, $lang, $date){

    $sql = "SELECT blogdate AS DATE, TEXT FROM v2v_blog_a_texts_published where language_id = :lang and BLOGDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getPublishedNewsTextForDate($pdo, $lang, $date){

    $sql = "SELECT blogdate AS DATE, TEXT FROM v2v_blog_a_texts_published 
                                          where language_id = :lang 
                                          and published = 1 
                                          and BLOGDATE = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getFeaturedNewsTexts($pdo, $lang){

    $sql = "SELECT blogdate AS DATE, TEXT FROM  v2v_blog_a_texts_keywords 
            where published = 1 
            and language_id = :lang
            and keyword_id = 96
            order by BLOGDATE desc LIMIT 3";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMarkDagar($pdo){

    $sql = "select DATUM AS THEDATE from v2v_markdagar";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}

function getRingingDates($pdo){

    $sql = "select DATUM AS THEDATE from v2v_markdagar";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);

}


function getImagesData($pdo){

    $sql = "select * from v2images";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingedAndRecoveredTaxa($pdo, $language){

    $sql = 'SELECT *, ART AS SHORTNAME FROM v2v_taxa_ringed_and_recovered where language_id = :language ORDER BY snr';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getMostRecentRingingDate($pdo){

    $sql = "SELECT MAX(DATUM) MAXDATUM FROM v2v_markdagar";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingLocationsThisDate($pdo, $date){

    $sql = "SELECT P, RM_TYPES_ID FROM v2v_rmdatesplacestypes where DATUM = :datum";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":datum", $date, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingingLocationsAndRingingTypesThisDate($pdo, $date){

    $sql = "SELECT P, RM_TYPES_ID FROM v2v_rmdatesplacestypes where DATUM = :datum";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":datum", $date, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function getRingingDataFor($pdo, $place, $date, $language){

    $year = substr($date,0, 4);

    // get the start date
    // All other ringing than standard ringing
    $startManad = '01';
    $startDay = '01';

    // ugly hack below :-/
    if ($place == 'FB' || $place == 'FA' || $place == 'FC'){

        $startStopTime = getStartStopTimes($pdo, $place);
        $startManad = $startStopTime[0]['START_MAN'];
        if (strlen($startManad) === 1){
            $startManad = '0' . $startManad;
        }
        $startDay = $startStopTime[0]['START_DAG'];
        if (strlen($startDay) === 1){
            $startDay = '0' . $startDay;
        }

    }

    $thisYearStartDatum = $year . '-' . $startManad . '-' . $startDay;

    $no_of_years=($year-1)-1980;	        //ex 42
    //2022-10-03
    //0123456789
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);;
    $dayMonad = $month . '-' . $day;

    $startDayMonad = $startManad . '-' . $startDay;

    $totalToTodayQuery = '(SELECT snr, art, substr(datum,5,5), SUM(SUMMA) AS SUBTOT
        FROM 
            v2v_rmdagsumWithNames
        WHERE
            P="' . $place . '" AND datum >= "' . $thisYearStartDatum .'" AND datum <= "' . $date . '" 
        GROUP BY
            v2v_rmdagsumWithNames.snr) as subtot';

    $medelToTodayQuery = '(SELECT snr, art, ROUND(SUM(SUMMA) / ' . $no_of_years . ', 0) AS medelv
        FROM
            v2v_rmdagsumWithNames
        WHERE
            substr(datum,6,5) >= "' . $startDayMonad . '" and substr(datum,6,5) <= "' . $dayMonad . '" and P="' . $place . '"
        GROUP BY
            v2v_rmdagsumWithNames.snr ) as medel';

    $sql = 'SELECT v2v_rmdagsumWithNames.DATUM, v2v_rmdagsumWithNames.SNR,';
    $langSektion = 'v2v_rmdagsumWithNames.SVNAMN AS ART,';
    if ($language == 'en'){
        $langSektion = 'v2v_rmdagsumWithNames.ENGNAMN AS ART,';
    }

    $sql = $sql . $langSektion . ' v2v_rmdagsumWithNames.SUMMA AS SUMMA, subtot.SUBTOT, medel.medelv FROM v2v_rmdagsumWithNames, ' .
        $totalToTodayQuery . ', ' . $medelToTodayQuery . '
        where DATUM = "' . $date . '"  and P="' . $place . '"' . ' AND v2v_rmdagsumWithNames.ART = subtot.ART AND v2v_rmdagsumWithNames.ART = medel.ART AND v2v_rmdagsumWithNames.SNR <> 996';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStartStopTimes($pdo, $ringingLocationCode){

    $sql = "select * from v2v_rm_lokaler_marktider where TEXT_CODE = :location ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":location", $ringingLocationCode, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPlaceAndTypeOfRinging($pdo, $place, $language){

    $languageAsInteger = 2;
    if ($language == 'en'){
        $languageAsInteger = 1;
    }

    $sql = 'SELECT * FROM v2v_rm_places_types_texts where TEXT_CODE = :place and LANGUAGE_ID = :lang';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":place", $place, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $languageAsInteger, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRecoveriesByTaxonCode($pdo, $taxon ): array {

    $sql = 'SELECT * FROM v2v_aterfynd_and_omstandigheter where ART = :taxon';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSnrByTaxonCode($pdo, $taxon ): int {

    $sql = 'SELECT SNR FROM v2v_aterfynd_and_omstandigheter where ART = :taxon LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]["SNR"];

}


function getRecoveriesByTaxonSNR($pdo, $snr ): array {

    $sql = 'SELECT * FROM v2v_aterfynd_and_omstandigheter where SNR = :snr';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":snr", $snr, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingedPre80($pdo, $taxon){

    $sql = "SELECT sum(SUMMA) AS PRE80SUM from rm4779 WHERE ART = :taxon";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ( is_null($result[0]["PRE80SUM"]) ){
        return 0;
    } else {
        return $result[0]["PRE80SUM"];
    }

}

function getRingedSubSpeciesPost79($pdo, $taxon){

    $sql = "SELECT sum(SUMMA) AS RINGSUM from rasdagsum WHERE ART = :taxon";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ( is_null($result[0]["RINGSUM"]) ){
        return 0;
    } else {
        return $result[0]["RINGSUM"];
    }


}

function getRingedSpeciesPost79($pdo, $taxon){

    $sql = "SELECT sum(SUMMA) AS RINGSUM from rmdagsum WHERE ART = :taxon";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxon", $taxon, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ( is_null($result[0]["RINGSUM"]) ){
        return 0;
    } else {
        return $result[0]["RINGSUM"];
    }
}

function getPost79YearData($pdo, $year, $language ){

    $sql = 'SELECT snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT snr, engnamn AS NAMN,';
    }

    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) AS 'FA', " ;
    $sql = $sql . " SUM(IF(P = 'FB',  SUMMA, 0)) AS 'FB', ";
    $sql = $sql . " SUM(IF(P = 'FC',  SUMMA, 0)) AS 'FC', ";
    $sql = $sql . " SUM(IF(P = 'ÖV',  SUMMA, 0)) AS 'ÖV', ";
    $sql = $sql . " SUM(IF(P = 'PU',  SUMMA, 0)) AS 'PU', ";
    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) + SUM(IF(P = 'FB',  SUMMA, 0)) + SUM(IF(P = 'FC',  SUMMA, 0)) + SUM(IF(P = 'ÖV',  SUMMA, 0)) + SUM(IF(P = 'PU',  SUMMA, 0)) AS 'TOT' ";
    $sql = $sql . " FROM `v2v_rmdagsumWithNames` ";
    $sql = $sql . " WHERE YEAR(DATUM) = " . $year;
    $sql = $sql . " GROUP BY SNR";
    $sql = $sql . " ORDER BY snr ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingingMonthsForLocationAndYear($pdo, $location, $year){

    $sql = 'SELECT DISTINCT MONTH(DATUM) AS MM FROM `markdagar`
    where YEAR(DATUM) = :year 
    and p = :location order by MM';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":location", $location, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getSeasonAndYearData($pdo, $ringingMonths, $lokal, $year, $texts, $language ){

    $sql = 'SELECT ART, snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT ART, snr, engnamn AS NAMN,';
    }

    foreach ($ringingMonths as $ringingMonth){
        $i = $ringingMonth["MM"];
        $sql = $sql . 'SUM(IF(MONTH(DATUM) = ' . $i . ', SUMMA, 0)) AS ' . $texts[$i] . ', ';
    }

    $sql = $sql . ' SUM(SUMMA) AS TOT FROM `v2v_rmdagsumWithNames` WHERE YEAR(DATUM) = ' . $year . ' AND P = "' . $lokal . '"
    GROUP BY SNR ORDER BY snr';

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getLongTermAverageForSpeciesAndLocation($pdo, $lokal, $snr){

    $sql = 'SELECT ROUND(SUM(SUMMA) / 30, 0) MVT FROM rmdagsum ';
    $sql = $sql . ' WHERE P = "'. $lokal . '" AND YEAR(DATUM) > 1979 AND YEAR(DATUM) < 2010 AND SNR = ' . $snr ;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingmarktaArter($pdo, $language){

    $sql = 'SELECT DISTINCT rmdagsum.art, artnamn.svnamn AS NAMN from rmdagsum, artnamn';
    if ($language == 'en'){
        $sql = 'SELECT DISTINCT rmdagsum.art, artnamn.engnamn AS NAMN from rmdagsum, artnamn ';

    }
    $sql =  $sql . ' WHERE rmdagsum.art=artnamn.art ORDER BY rmdagsum.snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getVinjettBildsFotograf($pdo, $kod){

    $sql = 'select fotograf as FOTO from tioitoppics where ART = "' . $kod .'"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTioIToppYear($pdo, $art){

    $sql = 'SELECT SUM(SUMMA) AS YEARTOT, YEAR(DATUM) AS YEAR FROM rmdagsum WHERE rmdagsum.art = "' . $art . '" GROUP BY YEAR ORDER BY YEARTOT DESC , YEAR DESC LIMIT 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTioIToppDag($pdo, $lokal, $art){

    $sql = 'select rmdagsum.DATUM, rmdagsum.SUMMA from rmdagsum
          WHERE rmdagsum.art="' . $art . '"
          AND rmdagsum.P="' . $lokal . '"
          ORDER BY rmdagsum.SUMMA desc, DATUM desc
          Limit 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTioIToppSeason($pdo, $lokal, $art){

    $sql = 'SELECT sum(SUMMA) AS NOOF, year(DATUM) AS YEAR from rmdagsum 
                  WHERE P = "' . $lokal . '" 
                  AND ART = "' . $art . '" 
                  GROUP BY YEAR
                  ORDER BY NOOF desc, YEAR desc
                  LIMIT 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMaxRastRakningsYear($pdo){

    $sql = 'SELECT max(year) MAXYEAR from rastbas';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMaxRastRakningsWeekForYear($pdo, $year){

    $sql = 'SELECT max(VE) MAXWEEK from rastbas where year="' . $year .'"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function getDataRastRakningForSpecificWeek($pdo, $year, $week, $language){

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, '; ;
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, ';
    }

    $sql = $sql . 'rastbas.YEAR, rastbas.VE, rastbas.SNR, rastbas.ART, rastbas.KANAL, rastbas.BLACK, rastbas.ANGSN, 
    rastbas.NABMA, rastbas.SLALH, rastbas.REVLA, rastbas.KNOSE, rastbas.SUMMA, artnamn.ART  FROM rastbas, artnamn';
    $sql = $sql . ' WHERE rastbas.YEAR=' .$year . ' and rastbas.VE=' . $week . ' and rastbas.ART=artnamn.ART 
    order by rastbas.SNR';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getWebLocalities( $pdo, $langId ){

    $sql = 'SELECT * from v2v_website_localities where LANG_ID = :langId';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $langId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getWebReserves( $pdo, $langId ){

    $sql = 'SELECT * from v2v_reserves_and_texts where LANG_ID = :langId';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $langId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getNabbenDailyTotals($pdo, $selectYear, $selectedArt){

    $sql = 'SELECT datum, summa FROM `sddagsum` WHERE year(datum) = ' .  $selectYear .  ' and ART="' . $selectedArt . '"';

    // ongoing year and season
    if (($selectYear == getCurrentYear()) && (getCurrentMonth() > 7)) {
        $sql = 'SELECT datum, summa FROM `strtemp` WHERE ART="' . $selectedArt . '"';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getArtlista($pdo, $languageId){

    $sql = 'SELECT * from v2v_taxa_local_list_status_a_names where language_id = :languageId order by SNR ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getArtNamnAlfaKod($pdo, $species_code, $lang_code) {

    $nameField = 'SVNAMN';
    if ($lang_code == 'en') {
        $nameField = 'ENGNAMN';
    }
    $sql = 'select ' . $nameField . ' AS NAME, LATNAMN FROM artnamn WHERE ART = "' . $species_code . '"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTaxonRecords ($pdo, $taxaId, $languageId){
    $sql = 'select * from v2v_taxa_local_list_records_full where TAXA_ID = :taxaId and language_id = :languageId order by FYND DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxaId", $taxaId, PDO::PARAM_INT);
    $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function loggIt($message){

    if (gettype($message) === "array"){

        error_log(count($message) . PHP_EOL, 3, "development.log");
        foreach($message as $key => $value) {
            $s = $key . ' ' . $value;
            error_log($s . PHP_EOL, 3, "development.log");
        }
    } else {
        error_log($message . PHP_EOL, 3, "development.log");
    }


}


function getDropDownPublicationKeywords($pdo, $language){


    $sql = 'SELECT keyword_id AS KEYWORD_ID, text AS TEXT, COUNT(publication_id) NO_OF FROM v2v_publications_keywords_texts WHERE lang_ID = :langId GROUP BY KEYWORD_ID order by TEXT';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function getAuthors($pdo){

    $sql = "SELECT AUTHOR_ID, concat(AUTH_NAME, ' (', COUNT(PUBLICATION_ID), ')') AS TEXT FROM `v2v_publications_authors_names` GROUP BY AUTHOR_ID ORDER BY AUTH_NAME  ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getPublicationsAuthors($pdo){

    $sql = "SELECT PUBLICATION_ID, AUTHOR_ID FROM `v2publications_authors`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPublicationsTaxa($pdo){

    $sql = "SELECT PUBLICATION_ID, TAXA_ID FROM `v2publications_taxa`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getPublicationsTaxaMetaData($pdo){

    $sql = "SELECT * FROM `v2v_publications_keywords_texts`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getPublicationsKeyWordsMetaData($pdo){

    $sql = "SELECT * FROM `v2v_publications_keywords_texts`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPublicationsKeywords($pdo){

    $sql = "SELECT PUBLICATION_ID, KEYWORD_ID FROM `v2publications_keywords`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getDropDownPublicationTaxa($pdo, $language){

    $sql =  "SELECT TAXA_ID, LANGUAGE_ID, concat(NAME, ' (', COUNT(PUBLICATION_ID), ')') AS TEXT FROM v2v_publications_taxa_names  WHERE LANGUAGE_ID = :langId GROUP BY LANGUAGE_ID, TAXA_ID ORDER BY SNR";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":langId", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function getImageKeywords($pdo, $language){


    $sql = 'SELECT distinct `LANG_ID`, `KEYWORD_ID`, `TEXT` FROM `v2v_images_keywords` where LANG_ID = :languageId';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":languageId", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getPhotographers($pdo){

    $sql = 'SELECT trim(NAME) AS NAME, ID AS PERSON_ID, NOOF FROM v2v_images_persons';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getImageTaxaNamesViaPhotoId($pdo, $imageId, $languageId){

    $sql = 'SELECT * FROM v2v_images_taxanames where IMAGE_ID = :imageId and LANGUAGE_ID = :languageId';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);
    $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTaxaWithImages($pdo, $language){

    $sql = 'SELECT * FROM v2v_taxanames_with_images where language_id = :language';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getImages($pdo): array
{

    $sql = 'select * from v2v_images_photographer order by DATUM desc';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getImagesTaxa($pdo){

    $sql = 'select IMAGE_ID, TAXA_ID from v2images_taxa';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getImagesPhotographers($pdo){

    $sql = 'select ID AS IMAGE_ID, PERSON_ID  from v2images';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTaxonLocalListReferences($pdo, $taxon, $languageId){

    $sql = 'select * from v2v_taxa_local_list_records_a_references_full where TAXA_ID = :taxaId and LANGUAGE_ID = :languageId';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxaId", $taxon, PDO::PARAM_INT);
    $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function writeTaxaRecordReference($pdo, $recordId, $referenceId){

    $sql = "insert into `v2taxa_local_list_records_references` set REFERENCE_ID = :referenceId, RECORD_ID = :recordId";
    $stmt = $pdo->prepare($sql);

    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":referenceId", $referenceId, PDO::PARAM_INT);
    $stmt->bindParam(":recordId", $recordId, PDO::PARAM_INT);

    $stmt->execute();

}



function getTaxaIdViaName($pdo, $name){

    $sql = 'select * from v2artnamn where lower(svnamn) = :name';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getKeywordViaName($pdo, $name){

    $sql = 'select * from v2keywords where lower(TEXT) = :name';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPublications($pdo){

    $sql = 'select v2publications.*, ID AS PUBLICATION_ID from v2publications';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMostRecentMigrationMonitoringDateData($pdo){

    if (ongoingYear(getCurrentDateAsYMD())){
        $tabell = 'strtemp';
    } else {
        $tabell = 'sddagsum';
    }
    $sql = 'SELECT MAX(DATUM) MAXDATUM FROM ' . $tabell;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackRakningsDagar($pdo, $year, $month){

    if (ongoingYear($year)){
        $tabell = 'strtemp';
    } else {
        $tabell = 'sddagsum';
    }

    $sql = 'SELECT distinct DATUM AS THEDATE FROM ' . $tabell .
        '    where YEAR(DATUM) = ' . $year .
        ' AND MONTH(DATUM) = ' . $month;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAllStrackDagar($pdo){

    $sql = 'SELECT * FROM v2v_all_strack_dagar order by DATUM ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);

}


function getStrackData($pdo, $strYmdDate, $language){


    // current year, now
    $d = getdate();
    $currentYear = $d['year'];

    // year of the date requested
    $t = strtotime($strYmdDate);
    $d = getdate($t);
    $dateYear = $d['year'];

    if ( $dateYear === $currentYear ){
        $data = getOngoingYearStrackDataMaxMin($pdo, $strYmdDate, $language);
    } else {
        $data = getCompleteYearsStrackDataMaxMin($pdo, $strYmdDate, $language);
    }

    return $data;
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


function testLog(){
    dblog('Anka!');
}


function getOngoingYearStrackDataMaxMin($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = substr($idag, 0, 4);
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);;

    $md_str = $monad.'-'.$dag; 			     // ex 10-30
    $no_of_years = ($year-1)-1972;	         // ex 42
    $seasonStartDate = $year . '-08-01';	 // ex 2010-08-01
    $taxaNameField  = "artnamn.SVNAMN";

    if ($language === '1'){
        $taxaNameField = "artnamn.ENGNAMN";
    }

    $sql =
        '
        SELECT 
            strtemp.DATUM, 
            strtemp.ART AS ART, 
            strtemp.SNR, ' .
            $taxaNameField . ' AS TAXON, 
            strtemp.SUMMA AS TODAY, 
            TOTODAY,
            MINI,
            MEDEL,
            MAXI
        from strtemp
        join artnamn on MD5(strtemp.ART) = MD5(artnamn.ART) 
        left join (SELECT snr, art, SUM(SUMMA) AS TOTODAY FROM strtemp where strtemp.datum >= "' . $seasonStartDate .'" and strtemp.datum <= "' . $idag . '" GROUP BY strtemp.ART) season on strtemp.ART = season.ART 
        
        left join (SELECT snr, art, round(sum(SUMMA)/' . $no_of_years . ', 0) AS MEDEL FROM sddagsum WHERE substr(datum,6,5) <= "' . $md_str . '"  
        GROUP BY sddagsum.ART ) medel on strtemp.ART = medel.ART
        
        left join (SELECT snr, art, MIN(TOT) MINI FROM ( SELECT YEAR(datum) AS MINIAR, snr, art, SUM(SUMMA) AS TOT FROM sddagsum WHERE year(datum) < "' . $year .'" AND SUBSTR(datum, 6, 5) <= "' . $md_str . '" GROUP BY sddagsum.ART, YEAR(datum) ) mini GROUP BY art) mini on strtemp.ART = mini.ART 
        left join (SELECT snr, art, MAX(TOT) MAXI FROM ( SELECT YEAR(datum) AS MAXIAR, snr, art, SUM(SUMMA) AS TOT FROM sddagsum WHERE year(datum) < "' . $year .'" AND SUBSTR(datum, 6, 5) <= "' . $md_str . '" GROUP BY sddagsum.ART, YEAR(datum) ) maxi GROUP BY art) MAX on strtemp.ART = MAX.ART         
        WHERE datum = "' . $idag . '"  
        AND strtemp.ART != "SUMMA"
        ORDER BY strtemp.SNR
        ';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function getOngoingYearStrackData($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = substr($idag, 0, 4);
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);;

    $md_str=$monad.'-'.$dag; 			     //ex 10-30
    $jmfdag=$md_str;
    $jmfdag30 = ($year-1) . '-' . $md_str;  //ex 2014-10-30
    $no_of_years = ($year-1)-1972;	        //ex 42
    $fDat = $year.'-08-01';				    //ex 2010-08-01

    $start = '1973-08-11';
    $sql = "SELECT strtemp.DATUM, strtemp.ART AS ART, strtemp.SNR, artnamn.SVNAMN AS TAXON, strtemp.SUMMA, subtot.ANTAL, medel.medelv";
    if ($language === '1'){
        $sql="SELECT strtemp.DATUM, strtemp.ART AS ART, strtemp.SNR, artnamn.ENGNAMN AS TAXON, strtemp.SUMMA, subtot.ANTAL, medel.medelv";
    }

    $sql = $sql .
        "
         from strtemp, artnamn,
         (SELECT snr, art, SUM(SUMMA) AS ANTAL FROM strtemp 
         where strtemp.datum>='$fDat'
         and strtemp.datum<='$idag' 
         GROUP BY strtemp.ART) AS subtot,
         (SELECT snr, art, round(sum(SUMMA)/'$no_of_years', 0) AS medelv
         FROM sddagsum
         WHERE datum>='$start'
         AND substr(datum,6,5)<='$jmfdag'
         AND datum<='$jmfdag30'         
         GROUP BY sddagsum.ART) AS medel
         WHERE datum='$idag'
         AND MD5(strtemp.ART) = MD5(artnamn.ART)
         AND strtemp.ART != 'SUMMA'  
         and strtemp.ART=subtot.ART
         and strtemp.ART=medel.ART        
         ORDER BY strtemp.SNR";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getCompleteYearsStrackDataMaxMin($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = intval(substr($idag, 0, 4));
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);;

    $md_str = $monad.'-'.$dag; 			     //ex 10-30
    $no_of_years = ($year-1)-1972;	        //ex 42
    $seasonStartDate = $year . '-08-01';				    //ex 2010-08-01
    $seriesStartDate = '1973-08-11';
    $taxaNameField  = "artnamn.SVNAMN";

    if ($language === '1'){
        $taxaNameField = "artnamn.ENGNAMN";
    }

    $sql =
        '
        SELECT 
            sddagsum.DATUM, 
            sddagsum.ART AS ART, 
            sddagsum.SNR, ' .
            $taxaNameField . ' AS TAXON, 
            sddagsum.SUMMA AS TODAY, 
            TOTODAY,
            MINI,
            MEDEL,
            MAXI
        from sddagsum
        join artnamn on MD5(sddagsum.ART) = MD5(artnamn.ART) 
        left join (SELECT snr, art, SUM(SUMMA) AS TOTODAY FROM sddagsum where sddagsum.datum >= "' . $seasonStartDate .'" and sddagsum.datum <= "' . $idag . '" GROUP BY sddagsum.ART) season on sddagsum.ART = season.ART
        
        left join (SELECT snr, art, round(sum(SUMMA)/' . $no_of_years . ', 0) AS MEDEL FROM sddagsum WHERE substr(datum,6,5) <= "' . $md_str . '"   
        GROUP BY sddagsum.ART) medel on sddagsum.ART = medel.ART
        
        left join (SELECT snr, art, MIN(TOT) MINI FROM ( SELECT YEAR(datum) AS MINIAR, snr, art, SUM(SUMMA) AS TOT FROM sddagsum WHERE year(datum) < "' . $year .'" AND SUBSTR(datum, 6, 5) <= "' . $md_str . '" GROUP BY sddagsum.ART, YEAR(datum) ) mini GROUP BY art) mini on sddagsum.ART = mini.ART 
        left join (SELECT snr, art, MAX(TOT) MAXI FROM ( SELECT YEAR(datum) AS MAXIAR, snr, art, SUM(SUMMA) AS TOT FROM sddagsum WHERE year(datum) < "' . $year .'" AND SUBSTR(datum, 6, 5) <= "' . $md_str . '" GROUP BY sddagsum.ART, YEAR(datum) ) maxi GROUP BY art) MAX on sddagsum.ART = MAX.ART           
        WHERE datum = "' . $idag . '"  
        AND sddagsum.ART != "SUMMA"
        ORDER BY sddagsum.SNR
        ';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getXCompleteYearsStrackData($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = intval(substr($idag, 0, 4));
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);

    $md_str = $monad.'-'.$dag; 			     //ex 10-30
    $jmfdag = $md_str;
    $jmfdag30 = ($year-1) . '-' . $md_str;  //ex 2014-10-30
    $no_of_years = ($year-1)-1972;	        //ex 42
    $fDat = $year.'-08-01';				    //ex 2010-08-01

    $start = '1973-08-11';
    $sql = "SELECT sddagsum.DATUM, sddagsum.ART AS ART, sddagsum.SNR, artnamn.SVNAMN AS TAXON, sddagsum.SUMMA, subtot.ANTAL, medel.medelv";
    if ($language == '1'){
        $sql="SELECT sddagsum.DATUM, sddagsum.ART AS ART, sddagsum.SNR, artnamn.ENGNAMN AS TAXON, sddagsum.SUMMA, subtot.ANTAL, medel.medelv";
    }
    $sql = $sql .
        "
         from sddagsum, artnamn,
         (SELECT snr, art, SUM(SUMMA) AS ANTAL FROM sddagsum 
         where sddagsum.datum>='$fDat'
         and sddagsum.datum<='$idag' 
         GROUP BY sddagsum.art) AS subtot,
         (SELECT snr, art, round(sum(SUMMA)/'$no_of_years', 0) AS medelv
         FROM sddagsum
         WHERE datum>='$start'
         AND substr(datum,6,5)<='$jmfdag'
         AND datum<='$jmfdag30'
         GROUP BY sddagsum.art) AS medel
         WHERE datum='$idag'
         AND MD5(sddagsum.ART) = MD5(artnamn.ART)
         and sddagsum.ART != 'SUMMA' 
         and sddagsum.ART=subtot.ART
         and sddagsum.ART=medel.ART 
         ORDER BY sddagsum.SNR";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $sql;
    //return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNabbenTioDagasPerioder($pdo, $language){

    $sql = 'select ID, SVTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder order by manad, startdag';
    if ($language == 'en') {
        $sql = 'select ID, ENTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder order by manad, startdag';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNabbenTioDagasPeriod($pdo, $id){

    $sql = 'select ID, SVTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder where id = ' . $id ;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSevenDaysData($pdo, $language, $stringSevenDays, $season){


    $sql = 'SELECT art, snr, svnamn AS NAMN,';
    $sqlIn = '';
    if ($language == 'en'){
        $sql = 'SELECT art, snr, engnamn AS NAMN,';
    }

    $aSevenDays = explode(',', $stringSevenDays);
    for ($i=count($aSevenDays)-1; $i > -1 ; $i--){
        $sql = $sql . " SUM(IF(DATUM = '" . trim($aSevenDays[$i]) . "',  SUMMA, 0)) AS '" . substr(trim($aSevenDays[$i]),5) . "', ";
        $sqlIn = $sqlIn . "'" . trim($aSevenDays[$i]) . "', ";
    }

    $sqlIn = substr($sqlIn, 0, strlen($sqlIn)-2);

    $sql = $sql . " SUM(IF(DATUM = '" . trim($aSevenDays[0])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[1])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[2])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[3])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[4])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[5])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[6])  . "',  SUMMA, 0))   
                     AS 'VTOT',
                      0 AS 'STOT',
                      0 AS 'SMV',
                      0 AS 'I100'";
    $sql = $sql . " FROM `v2v_rmdagsumWithNames` ";
    $sql = $sql . " WHERE DATUM IN (" . $sqlIn . ") ";
    $sql = $sql . " AND P = '" . $season . "'";
    $sql = $sql . " GROUP BY SNR ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSeasonTotalsUntilNow($pdo, $season, $ymdDataAsString, $taxaListAsString){

    $month = substr($ymdDataAsString, 5, 2);
    $day = substr($ymdDataAsString, 8, 2);

    $sql = 'SELECT art, snr, sum(summa) AS ARTTOT from v2v_rmdagsumWithNames ';
    $sql = $sql . " where P = '" . $season . "'";
    $sql = $sql . ' and MONTH(DATUM) <= "' . $month . '" ';
    $sql = $sql . ' and DAY(DATUM) <= "' . $day . '" ';
    $sql = $sql . " and ART IN (" . $taxaListAsString . ")";
    $sql = $sql . " group by snr";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function getSeasonRingingTotals($pdo, $season, $year, $taxaListAsString){

    $sql = 'SELECT art, snr, sum(summa) ARTTOT from v2v_rmdagsumWithNames ';
    $sql = $sql . " where P = '" . $season . "'";
    $sql = $sql . ' and YEAR(DATUM) = "' . $year . '"';
    $sql = $sql . " and ART IN (" . $taxaListAsString . ")";
    $sql = $sql . " group by snr";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getActiveSeasonsThisDate($pdo, $ymdString, $language){

    $dateTime = new DateTime($ymdString);
    $month = $dateTime->format('m');
    $day = $dateTime->format('d');
    $testDate = '"' . '1000-' . $month . '-' . $day . '"';

    $sql = 'select * from v2v_rm_std_lokaler where ' . $testDate .   ' BETWEEN STARTDUMMYDATE AND ENDDUMMYDATE and LANGUAGE_ID = ' . $language;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTotalsForSeasonAndYearsUntilDate($pdo, $season, $theDate){

    $season = '"' . $season . '"';
    $theYear =  substr($theDate, 0, 4);
    $theYear = '"' . $theYear . '"';
    $theDate = '"' . $theDate . '"';
    $sql = 'select v2v_rmdagsumWithNames.*, sum(summa) AS ARTTOT from v2v_rmdagsumWithNames where P =' . $season .' and year(datum) =' . $theYear . ' and datum < ' . $theDate . ' group by ART';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTotalsForSeasonAllTime($pdo, $season){

    $season = '"' . $season . '"';

    $sql = 'select v2v_rmdagsumWithNames.*, sum(summa) AS ARTTOT from v2v_rmdagsumWithNames where P =' . $season . ' group by ART';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNabbenTioPeriod($pdo, $year, $language, $periodInfo){

    $paramYearAsInt = intval($year);
    $currentYearAsInt = intval(date("Y"));
    $currentMonthAsInt = intval(date("m"));
    $seasonIsOnGoing = (($paramYearAsInt === $currentYearAsInt) && ($currentMonthAsInt > 7));

    $startDay = $periodInfo[0]['STARTDAG'];
    $periodLangd = $periodInfo[0]['PERIOD_LENGTH'];
    $manad = $periodInfo[0]['MANAD'];

    $sql = 'SELECT snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT snr, engnamn AS NAMN,';
    }

    $sql = $sql . " ART, " ;
    $summaSql = '';
    for ($col = 0; $col < $periodLangd; $col++){
        $thisDay = $startDay  + $col;
        $thisColumn = " SUM(IF(DAY(DATUM) = " . $thisDay . ", SUMMA, 0)) AS '" . $thisDay .  "'," ;
        $sql = $sql . $thisColumn;
        $thisSumStatement = " SUM(IF(DAY(DATUM) = " . $thisDay . ", SUMMA, 0)) +";
        $summaSql = $summaSql . $thisSumStatement;
    }

    $summaSql = getStringPrunedRemoveAtTheEnd($summaSql, '+');
    $sql = $sql . $summaSql . ' AS TOT ';
    $from = " FROM `v2v_all_strack_dagsum_with_names`";
    if ( $seasonIsOnGoing ) {
        $from = " FROM `v2v_ongoing_year_strack_dagsum_with_names`";
    }
    $sql = $sql . $from;
    $sql = $sql . " WHERE YEAR(DATUM) = " . $year . " AND MONTH(DATUM) = " . $manad;
    $sql = $sql . " GROUP BY SNR";
    $sql = $sql . " ORDER BY SNR ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNabbenYearData($pdo, $year, $language ){

    $paramYearAsInt = intval($year);
    $currentYearAsInt = intval(date("Y"));
    $currentMonthAsInt = intval(date("m"));
    $seasonIsOnGoing = (($paramYearAsInt === $currentYearAsInt) && ($currentMonthAsInt > 7));

    $table = "`v2v_all_strack_dagsum_with_names`";
    if ( $seasonIsOnGoing ) {
        $table = "`v2v_ongoing_year_strack_dagsum_with_names`";
    }

    $numberOfYears = 1 + getCurrentYear() - 1972;
    $sql = 'SELECT snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT snr, engnamn AS NAMN,';
    }

    $sql = $sql . " " . $table . ".ART, " ;
    $sql = $sql . " SUM(IF(MONTH(DATUM) = 8,  SUMMA, 0)) AS 'AUG', " ;
    $sql = $sql . " SUM(IF(MONTH(DATUM) = 9,  SUMMA, 0)) AS 'SEP', " ;
    $sql = $sql . " SUM(IF(MONTH(DATUM) = 10,  SUMMA, 0)) AS 'OCT', " ;
    $sql = $sql . " SUM(IF(MONTH(DATUM) = 11,  SUMMA, 0)) AS 'NOV', " ;
    $sql = $sql . " SUM(IF(MONTH(DATUM) = 8,  SUMMA, 0)) + SUM(IF(MONTH(DATUM) = 9,  SUMMA, 0)) + SUM(IF(MONTH(DATUM) = 10,  SUMMA, 0)) + SUM(IF(MONTH(DATUM) = 11,  SUMMA, 0)) AS 'TOT', ";
    $sql = $sql . " MEDEL.MV ";
    $sql = $sql . " FROM " . $table . ", ";
    $sql = $sql . " (SELECT `sddagsum`.art, round(sum(`sddagsum`.SUMMA)/" . $numberOfYears . ", 0) as MV FROM `sddagsum` group by ART " . ') as MEDEL ';
    $sql = $sql . " WHERE YEAR(DATUM) = " . $year;
    $sql = $sql . " AND MEDEL.ART = " . $table . ".ART";
    $sql = $sql . " GROUP BY SNR";
    $sql = $sql . " ORDER BY SNR ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNabbenArligaMedeltal($pdo){

    $sql = 'select * from `v2v_strack_ar_art_medel`';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStracktaArter($pdo, $language){

    $sql = 'SELECT DISTINCT sddagsum.art, artnamn.svnamn AS NAMN ' ;
    if ($language == 'en'){
        $sql = 'SELECT DISTINCT sddagsum.art, artnamn.engnamn AS NAMN ' ;
    }
    $sql =  $sql . ' from sddagsum, artnamn WHERE sddagsum.art=artnamn.art ORDER BY sddagsum.snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackMonths($pdo, $year, $species){

    $sql = 'SELECT DISTINCT month(datum) AS MONTH FROM `sddagsum` WHERE year(datum) = ' .  $year .  ' and ART="' . $species . '"';

    if ($year == getCurrentYear()){
       $sql = 'SELECT DISTINCT month(datum) AS MONTH FROM `strtemp` WHERE ART="' . $species . '"';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMax10DagSumStrack($pdo, $art){

    $sql = 'select SVNAMN AS NAMN, DATUM, SUMMA from sddagsum, artnamn where sddagsum.ART = "' . $art . '" and artnamn.ART = sddagsum.ART order by summa desc limit 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMax10ArSumStrack($pdo, $art){

    $sql = 'select  year(DATUM) AR, art, sum(summa) as ARSUMMA from sddagsum where art = "' . $art . '" 
    GROUP BY year(DATUM) order by ARSUMMA DESC LIMIT 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function getSpeciesNames($pdo, $art, $language){

    $sql = 'select LATNAMN, svnamn as NAMN';
    if ($language == 'en'){
        $sql = 'select LATNAMN, engnamn as NAMN';
    }

    $sql = $sql . ' from artnamn where art = "' . $art . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getNabbenArsSumma($pdo, $art, $language){

    $sqlIntro = 'select YEAR, SNR, ART, ARSSUMMA,';
    $sqlLangPart = ' svnamn AS NAMN ';
    if ($language == 'en'){
        $sqlLangPart = ' engnamn AS NAMN ';
    }

    $sql = $sqlIntro . $sqlLangPart . ' from v2v_strack_arssummor_namn where art = "' . $art . '" order by SNR';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataIncreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-2;
    $db_tabell = 'str_rang_' . $last_year;

    $sql = 'SELECT * , artnamn.SVNAMN AS NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }
    $sql = $sql . ' 
                WHERE VAL="X" 
                AND num_rs>0
                AND sign<>"n.s."
                AND ' . $db_tabell . '.art=artnamn.art ';

    // default "om"
    $sort = ' order by num_rs desc, ' . $db_tabell . '.snr';
    if ($sortorder == "sy") {
        $sort = ' order by ' . $db_tabell . '.snr';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataDecreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-2;
    $db_tabell = 'str_rang_' . $last_year;

    $sql = 'SELECT * , artnamn.SVNAMN AS NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }
    $sql = $sql . ' 
                WHERE VAL="X" 
                AND num_rs<0
                AND sign<>"n.s."
                AND ' . $db_tabell . '.art=artnamn.art';

    // default "om"
    $sort = ' order by num_rs asc, ' . $db_tabell . '.snr';
    if ($sortorder == "sy") {
        $sort = ' order by ' . $db_tabell . '.snr';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataNonSignifant($pdo, $language, $sortorder){


    $last_year =  getCurrentYear()-2;
    $db_tabell = 'str_rang_' . $last_year;

    //ej sign
    $sql = 'SELECT * , artnamn.SVNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }

    $sql = $sql . ' WHERE VAL = \'X\' and locate(\'*\', SIGN ) = 0 AND ' . $db_tabell . '.art = artnamn.art';
    // default "om"
    $sort = ' order by num_rs asc, ' . $db_tabell . '.snr';
    if ($sortorder == "sy") {
        $sort = ' order by ' . $db_tabell . '.snr';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStracktaOchFoljdaArter($pdo, $language){

    $lastYear = getCurrentYear() - 2;
    $table = 'str_rang_' . $lastYear;

    $sql = 'SELECT DISTINCT sddagsum.art, artnamn.svnamn AS NAMN ' ;
    if ($language == 'en'){
        $sql = 'SELECT DISTINCT sddagsum.art, artnamn.engnamn AS NAMN ' ;

    }
    $sql =  $sql . ' from sddagsum, artnamn WHERE sddagsum.art=artnamn.art and sddagsum.art in (select art from ' . $table . ' where VAL="X")';
    $sql =  $sql . 'ORDER BY sddagsum.snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTenYearStrackAverages($pdo, $art){

    $sql = '';
    $decade = 198;
    $currentDecade = substr(getCurrentYear(), 0, 3);

    while ($decade < $currentDecade){

        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/10,0) AS MV from sddagsum where art="'.$art.'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
        $sql = $sql . ' UNION ';

        $decade++;

    }

    $remainingYears = (getCurrentYear() - ($currentDecade * 10));
    if ($remainingYears >= 3) {
        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/' . $remainingYears . ', 0) AS MV from sddagsum where art="'. $art . '" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
    }

    $sql = substr($sql, 0 , trim(strlen($sql)) - 6);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenStatMetaData($pdo, $art, $language){

    $lastYear = getCurrentYear() - 2;
    $table = 'str_rang_' . $lastYear;

    $sql = 'select Rs, SIGN, VAL, sv_com AS KOMMENTAR_TXT ';
    if ($language == 'en'){
        $sql = 'select Rs, SIGN, VAL, eng_com AS KOMMENTAR_TXT ';
    }

    $sql = $sql . ' from ' . $table . ' where art="' . $art . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenYearTotals($pdo, $art){

    $sql = 'select YEAR, ARSSUMMA AS ANTAL FROM `v2v_strack_arssummor` WHERE ART="' .$art .'"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getNextEntry($pdo, $date){

    $entry = "";
    //närmast följande, ofta i morgon
    $sql="SELECT MIN(dagbdatum) AS NEXT FROM dagboksblad WHERE dagbdatum > '$date' ORDER BY dagbdatum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (count($result) > 0){
        $tmp = $result[0];
        $entry = $tmp["NEXT"];
    }

    return $entry;

}


function getMostRecentEntry($pdo){

    $entry = "";
    $sql = "SELECT MAX(dagbdatum) AS MOST_RECENT FROM dagboksblad ORDER BY dagbdatum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (count($result) > 0){
        $tmp = $result[0];
        $entry = $tmp["MOST_RECENT"];
    }

    return $entry;
}


function getAllPublishedDates($pdo, $lang){

    $sqlString = ("SELECT DISTINCT BLOGDATE FROM v2v_blogdates_all where language_id = :lang order by BLOGDATE DESC");
    $stmt = $pdo->prepare($sqlString);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);

}


function getBookingDates($pdo){

    $sqlString = "SELECT DISTINCT BOOKING_DATE FROM v2guiding_bookings order by BOOKING_DATE DESC";
    $stmt = $pdo->prepare($sqlString);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);

}


function getBookingsForDate($pdo, $datum){

    $sql = 'SELECT DATE, TIME, PARTY, PARTICIPANTS from v2v_booked_guidings where date = :datum order by time';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":datum", $datum, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingLocations($pdo, $day){

    $sql = 'SELECT TEXT_CODE FROM markdagar_plats_typ where datum = :datum ORDER BY TEXT_CODE';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":datum", $day, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendsDataDecreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL = 'X' 
                    AND num_rs < 0
                    AND sign <> 'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendsDataNonSignifant($pdo, $language, $sortorder){


    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL='X' 
                    AND sign = 'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendDataIncreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL='X' 
                    AND num_rs>0
                    AND sign<>'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMonitoredRingingSpecies($pdo, $language){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = "SELECT distinct artnamn.SVNAMN AS NAMN, artnamn.art ";
    if ($language == 'en'){
        $sql = "SELECT distinct artnamn.ENGNAMN AS NAMN, artnamn.art ";
    }

    $sql = $sql . " FROM " . $db_tabell . ", artnamn where " . $db_tabell . ".art = artnamn.art";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTenYearRingingAverages($pdo, $season, $art){

    $sql = '';
    $decade = 198;
    $currentDecade = substr(getCurrentYear(), 0, 3);

    while ($decade < $currentDecade){

        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/10,0) AS MV from rmdagsum where art="'. $art . '" AND P="' . $season .'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
        $sql = $sql . ' UNION ';

        $decade++;

    }

    $remainingYears = (getCurrentYear() - ($currentDecade * 10));
    if ($remainingYears >= 3) {
        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/' . $remainingYears . ', 0) AS MV from rmdagsum where art="'. $art . '" AND P="' . $season .'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
    }

    if (substr($sql, strlen($sql) - 7) == ' UNION ') {
        $sql = substr($sql, 0 , strrpos($sql,' UNION '));
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingmarkningArtTrendMetaData($pdo, $art, $sasong, $language){

    $lastYear = getCurrentYear() - 1;
    $table = 'rm_rang_' . $lastYear;

    $sql = 'select sv_com AS KOMMENTAR_TXT, ';
    if ($language == 'en'){
        $sql = 'select eng_com AS KOMMENTAR_TXT, ';
    }

    $sql = $sql . '  Rs, SIGN, VAL from ' . $table . ' where art="' . $art . '" and P="' . $sasong . '"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSeasonSpeciesTotals($pdo, $sasong, $art ){

    $lastYear = getCurrentYear()-1;
    $sql = 'SELECT year(DATUM) AS YEAR, sum(SUMMA) AS ANTAL, artnamn.SVNAMN  
                         FROM rmdagsum, artnamn
                         WHERE artnamn.art="' .$art . '" 
                         AND rmdagsum.P="' . $sasong . '"
                         AND rmdagsum.art = artnamn.art
                         AND YEAR(DATUM)<=' . $lastYear . '
                         GROUP BY YEAR
                         ORDER BY YEAR';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getWeatherForDateX($pdo, $date, $lang){

    $sql = 'SELECT * FROM  v2v_dagboks_vader where DATUM = :date';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();


    $w = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = getWeatherCommentsForDate($pdo, $date, $lang);
    $completeData = array( 'weatherInfo' => $w, 'weatherComments' => $data);

    $result = array();
    array_push($result, $completeData);

    return $result;

}


function getWeatherForDateLegacyTable($pdo, $date, $lang){

    $sql = 'select DATE, TIME, CLOUDS, WIND_DIRECTION, WIND_FORCE, TEMP, VISIBILITY, PRESSURE,';
    $sqlLangPart = ' SWECOMMENT';
    if ($lang === '1'){
        $sqlLangPart = ' ENGCOMMENT';
    }
    $sql = $sql . $sqlLangPart . " AS COMMENT from v2v_blog_weather_tmp where DATE = :date order by TIME";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}



function getWeatherCommentsForDate($pdo, $date, $lang){

    $sql = 'select * from v2v_blog_weather_comments where DATE = :date and LANG_ID = :lang';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getThisDateRingingData($pdo, $date, $lang){

    $sql = 'select * from v2v_ringing_dates_places_types_texts where datum = :date and LANGUAGE_ID = :lang ORDER BY SORT_ORDER';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    $result = array();
    $ringingPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ( $i=0; $i < count($ringingPlaces); $i++){

        $placeData = $ringingPlaces[$i];


        $ringingData = getRingingDateTotals($pdo, $date, $lang, $placeData['TEXT_CODE']);
        $completePlaceData = array( 'placeInfo' => $placeData, 'ringingData' => $ringingData);
        array_push($result, $completePlaceData);

    }

    return $result;

}


function getThisDateNonSystematicRingingData($pdo, $date, $lang){

    $sql = 'select * from v2v_workschemes_by_date where datum = :date and LANGUAGE_ID = :lang and systematic = 0 ORDER BY SORTORDER';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    $result = array();
    $ringingPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ( $i=0; $i < count($ringingPlaces); $i++){

        $placeData = $ringingPlaces[$i];

        $ringingData = getRingingDateTotals($pdo, $date, $lang, $placeData['P']);
        $completePlaceData = array( 'placeInfo' => $placeData, 'ringingData' => $ringingData);
        array_push($result, $completePlaceData);

    }

    return $result;

}

function getThisDateRingingDataWithAverages($pdo, $date, $lang){

    $sql = 'select * from v2v_ringing_dates_places_types_texts where datum = :date and LANGUAGE_ID = :lang ORDER BY SORT_ORDER';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    $result = array();
    $ringingPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ( $i=0; $i < count($ringingPlaces); $i++){

        $placeData = $ringingPlaces[$i];
        $ringingData = getRingingDataFor($pdo, $placeData['TEXT_CODE'], $date, $lang);
        $completePlaceData = array( 'placeInfo' => $placeData, 'ringingData' => $ringingData);
        array_push($result, $completePlaceData);

    }

    return $result;

}


function getRingingDateTotals($pdo, $date, $lang, $place){

    $sql = 'select * from v2v_rm_dagsum_snr_names where datum = :date and LANGUAGE_ID = :lang and P = :place and TAXA_ID != 811 ORDER BY SNR';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":place", $place, PDO::PARAM_STR);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMostRecentPics($pdo, $lang){

    $sql = 'select * from v2v_images_photographers_taxanames where LANGUAGE_ID = :lang AND PUBLISHED = 1 ORDER BY DATUM DESC limit 3';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function getPost79YearDataForOneSpecies($pdo, $art, $language ){

    $artNamn = 'svnamn';
    if ($language == 'en'){
        $artNamn = 'engnamn';
    }

    $sql = 'SELECT ' . $artNamn . '  AS NAMN,';
    $sql .= " YEAR(DATUM) AS YEAR, snr, " ;
    $sql .= " SUM(IF(P = 'FA',  SUMMA, 0)) AS 'FA', " ;
    $sql .= " SUM(IF(P = 'FB',  SUMMA, 0)) AS 'FB', ";
    $sql .= " SUM(IF(P = 'FC',  SUMMA, 0)) AS 'FC', ";
    $sql .= " SUM(IF((P = 'ÖV' || P = 'OV') ,  SUMMA, 0)) AS 'OV', ";
    $sql .= " SUM(IF(P = 'PU',  SUMMA, 0)) AS 'PU', ";
    $sql .= " SUM(IF(P = 'FA',  SUMMA, 0)) + SUM(IF(P = 'FB',  SUMMA, 0)) + SUM(IF(P = 'FC',  SUMMA, 0)) + SUM(IF((P = 'ÖV' || P = 'OV'),  SUMMA, 0)) + SUM(IF(P = 'PU',  SUMMA, 0)) AS 'TOT' ";
    $sql .= " FROM `v2v_rmdagsumWithNames` ";
    $sql .= " WHERE ART = '" . $art . "'";
    $sql .= " GROUP BY YEAR(DATUM)";
    $sql .= " ORDER BY YEAR(DATUM) DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}

function getPost79TotalData($pdo, $language ){

    $sql = 'SELECT art, snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT art, snr, engnamn AS NAMN,';
    }

    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) AS 'FA', " ;
    $sql = $sql . " SUM(IF(P = 'FB',  SUMMA, 0)) AS 'FB', ";
    $sql = $sql . " SUM(IF(P = 'FC',  SUMMA, 0)) AS 'FC', ";
    $sql = $sql . " SUM(IF(P = 'ÖV',  SUMMA, 0)) AS 'ÖV', ";
    $sql = $sql . " SUM(IF(P = 'PU',  SUMMA, 0)) AS 'PU', ";
    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) + SUM(IF(P = 'FB',  SUMMA, 0)) + SUM(IF(P = 'FC',  SUMMA, 0)) + SUM(IF(P = 'ÖV',  SUMMA, 0)) + SUM(IF(P = 'PU',  SUMMA, 0)) AS 'TOT' ";
    $sql = $sql . " FROM `v2v_rmdagsumWithNames` ";
    $sql = $sql . " GROUP BY SNR";
    $sql = $sql . " ORDER BY snr ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPre80YearTotalsForOneSpecies($pdo, $art, $startYear, $stopYear){

    $sql ='SELECT year, summa from rm4779 WHERE art="' . $art . '" AND year>"' . $startYear . '" and year<"' . $stopYear . '" ORDER BY year desc ';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingMonths($pdo, $year, $season, $species){

    $sql = 'SELECT DISTINCT month(datum) AS MONTH FROM `rmdagsum` WHERE year(datum) = ' .  $year . ' and p = "' . $season . '" and ART="' . $species . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingDailyTotals($pdo, $year, $season, $species){

    $sql = 'SELECT datum, summa FROM `rmdagsum` WHERE year(datum) = ' .  $year . ' and p = "' . $season . '" and ART="' . $species . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getLokalNamn($pdo, $place, $language){

    $languageAsinteger = 2;
    if ($language == 'en'){
        $languageAsinteger = 1;
    }

    $sql = 'SELECT * FROM v2v_workschemes_a_texts where TEXT_CODE = "' . $place . '" and LANGUAGE_ID = "' . $languageAsinteger . '"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getYearTotalsForAllSpeciesSinceStart($pdo, $language){

    $sql = 'select art, snr, svnamn AS NAMN, ';
    if ($language == 'en') {
        $sql = 'select art, snr, engnamn AS NAMN, ';
    }

    $sql = $sql . ' SUM(IF(ERA = "PRE80", NOOF, 0)) AS "PRE80", SUM(IF(ERA = "POST79", NOOF, 0)) AS "POST79" from v2v_rm_allyears_names GROUP BY ART order by snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAgesOptions($pdo, $ages, $lang) : array {

    $sql = 'SELECT ATERFYND_AGE, TEXT AS TEXT FROM v2v_aterfynd_ages_texts  
     where ATERFYND_AGE in ' . $ages . ' AND LANGUAGE_ID = :lang ORDER BY SORTORDER ASC ';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getRingingMonitoringResultForSeason($pdo, $language, $season, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = "SELECT * , artnamn.SVNAMN AS NAMN, rm_rangarter.Pkod FROM $db_tabell, artnamn, rm_rangarter";
    if ($language == 'en'){
        $sql = "SELECT * , artnamn.ENGNAMN AS NAMN, rm_rangarter.Pkod FROM $db_tabell, artnamn, rm_rangarter";
    }

    $sql = $sql . " WHERE VAL='X' 
    AND $db_tabell.p='" . $season . "'
    AND $db_tabell.art=artnamn.art
    AND $db_tabell.art=rm_rangarter.art";

    if ($sortorder == 'om'){
        $sort = " order by num_rs desc";
    } else {
        $sort = " order by artnamn.SNR";
    }

    $sql = $sql . $sort;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSystematicSeasonsData($pdo, $language) : array {

    $sql = 'SELECT *  FROM v2v_workschemes_a_texts  
     where STANDARDIZED = 1 AND LANGUAGE_ID = :language ';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":language", $language, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function logDBPostData(){

    dbLog('  ');
    dbLog('Log DB post data');
    dbLog('$_POST size: ' . sizeof($_POST));

    dbLog('  ');
    foreach ($_POST as $item => $value){
        dbLog($item . ': ' . $value);
    }
    dbLog('  ');
    dbLog('  ');

}


function weekDone($pdo, $dateAsString){

    $t = strtotime($dateAsString);
    $vecka = date('W', $t);
    $year = substr($dateAsString, 0, 4);
    $sql='SELECT * FROM rrveckor where YEAR = ' . $year . ' AND VE =' . $vecka ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPreviousEntry($pdo, $date){

    $entry = "";
    $sql="SELECT MAX(dagbdatum) AS PREV FROM dagboksblad WHERE dagbdatum < '$date' ORDER BY dagbdatum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0){
        $tmp = $result[0];
        $entry = $tmp["PREV"];
    }

    return $entry;
}


function writeBlogDate($pdo, $date){

    $sql = 'INSERT INTO V2blogdates SET ID = 0, BLOGDATE = :date ';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();

}


function logDataToBePosted(){

    dbLog('$_POST size: ' . sizeof($_POST));

    dbLog('  ');
    foreach ($_POST as $item => $value){
        dbLog($item . ': ' . $value);
    }
    dbLog('  ');

}


function writeDbVader($pdo, $datum, $kl, $moln, $vrik, $vsty, $temp, $sikt, $tryck, $s_vader, $e_vader){

    // remove possible previous record
    $sql = 'delete from dagb_vader where DATUM = :date and kl = :kl';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $datum, PDO::PARAM_STR);
    $stmt->bindParam(":kl", $kl, PDO::PARAM_STR);
    $stmt->execute();

    // write or re-write the record
    $sqlInsert = "insert into dagb_vader set DATUM = :date,       /* 1 */
                                       kl = :kl,            /* 2 */
                                       moln = :moln,        /* 3 */
                                       vrik = :vrik,        /* 4 */
                                       vsty = :vsty,        /* 5 */
                                       temp = :temp,       /* 6 */
                                       sikt = :sikt,        /* 7 */
                                       tryck = :tryck,      /* 8 */
                                       s_vader = :s_vader,  /* 9 */
                                       e_vader = :e_vader"; /* 10 */
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->bindParam(":date", $datum, PDO::PARAM_STR);          // 1
    $stmt->bindParam(":kl", $kl, PDO::PARAM_STR);               // 2
    $stmt->bindParam(":moln", $moln, PDO::PARAM_STR);           // 3
    $stmt->bindParam(":vrik", $vrik, PDO::PARAM_STR);           // 4
    $stmt->bindParam(":vsty", $vsty, PDO::PARAM_INT);           // 5
    $stmt->bindParam(":temp", $temp, PDO::PARAM_STR);           // 6
    $stmt->bindParam(":sikt", $sikt, PDO::PARAM_STR);           // 7
    $stmt->bindParam(":tryck", $tryck, PDO::PARAM_STR);         // 8
    $stmt->bindParam(":s_vader", $s_vader, PDO::PARAM_STR);     // 9
    $stmt->bindParam(":e_vader", $e_vader, PDO::PARAM_STR);     // 10
    $stmt->execute();

}


function getNoOfTaxaToTodayThisYear($pdo, $scheme, $date ) {

    $year = substr($date, 0, 4);
    $manDag = substr($date, 5, 5);

    $sql = 'select count(ART) AS NOOF_TAXA from (
            SELECT distinct ART FROM `v2v_rmdagsumWithNames` 
            WHERE p = :scheme 
            AND year(datum) = :year 
            AND SNR != 996
            AND SUBSTR(datum, 6, 5) <= :manDag
            ) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAverageNoOfTaxaToToday($pdo, $scheme, $date ) {

    $year = date("Y");
    $manDag = substr($date, 5, 5);

    $sql = 'SELECT round(AVG(NOOF_TAXA)) AVERAGE FROM
            (SELECT
                COUNT(ART) AS NOOF_TAXA,
                YEAR AS YEAR
            FROM
                (
                SELECT DISTINCT
                    ART,
                    YEAR(datum) AS YEAR
                FROM
                    `v2v_rmdagsumWithNames`
                WHERE
                    P = :scheme 
                    AND SNR != 996
                    AND YEAR(datum) < :year
                    AND SUBSTR(datum, 6, 5) <= :manDag
            ) AS T
            GROUP BY
                YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMaxNoOfTaxaToToday($pdo, $scheme, $date ) {

    $year = date("Y");
    $manDag = substr($date, 5, 5);

    $sql = 'SELECT MAX(NOOF_TAXA) MAX FROM
            (SELECT
                COUNT(ART) AS NOOF_TAXA,
                YEAR AS YEAR
            FROM
                (
                SELECT DISTINCT
                    ART,
                    YEAR(datum) AS YEAR
                FROM
                    `v2v_rmdagsumWithNames`
                WHERE
                    P = :scheme 
                    AND SNR != 996
                    AND YEAR(datum) < :year
                    AND SUBSTR(datum, 6, 5) <= :manDag
            ) AS T
            GROUP BY
                YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMaxNoOfTaxaForThisScheme($pdo, $scheme ) {

    $year = date("Y");

    $sql = 'SELECT MAX(NOOF_TAXA) MAX FROM
            (SELECT
                COUNT(ART) AS NOOF_TAXA,
                YEAR AS YEAR
            FROM
                (
                SELECT DISTINCT
                    ART,
                    YEAR(datum) AS YEAR
                FROM
                    `v2v_rmdagsumWithNames`
                WHERE
                    P = :scheme 
                    AND SNR != 996
                    AND YEAR(datum) < :year
            ) AS T
            GROUP BY
                YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNoOfBirdsToTodayThisYear($pdo, $scheme, $date ) {

    $year = substr($date, 0, 4);
    $manDag = substr($date, 5, 5);

    $sql = 'SELECT sum(summa) NOOF FROM `v2v_rmdagsumWithNames` 
            WHERE p = :scheme 
            AND year(datum) = :year 
            AND SNR != 996
            AND SUBSTR(datum, 6, 5) <= :manDag' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":year", $year, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);
    $stmt->execute();

   // $stmt->debugDumpParams();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getAverageNoOfBirdsToToday($pdo, $scheme, $date ) {

    $manDag = substr($date, 5, 5);

    $sql = 'select round(AVG(NOOF)) AVERAGE FROM 
            (SELECT sum(summa) NOOF, year(datum) YEAR FROM `v2v_rmdagsumWithNames` 
            WHERE p = :scheme             
            AND SNR != 996
            AND SUBSTR(datum, 6, 5) <= :manDag
            group by YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getMaxNoOfBirdsToToday($pdo, $scheme, $date ) {

    $manDag = substr($date, 5, 5);

    $sql = 'select MAX(NOOF) MAX FROM 
            (SELECT sum(summa) NOOF, year(datum) YEAR FROM `v2v_rmdagsumWithNames` 
            WHERE p = :scheme             
            AND SNR != 996
            AND SUBSTR(datum, 6, 5) <= :manDag
            group by YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->bindParam(":manDag", $manDag, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMaxNoOfBirdsForThisScheme($pdo, $scheme, $date ) {

    $sql = 'select MAX(NOOF) MAX FROM 
            (SELECT sum(summa) NOOF, year(datum) YEAR FROM `v2v_rmdagsumWithNames` 
            WHERE p = :scheme             
            AND SNR != 996
            group by YEAR) AS T' ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":scheme", $scheme, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMostRecentWeatherReading($pdo, $lang){

    $sql = "SELECT * FROM  v2v_dagboks_vader order by ID DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $result = array();
    array_push($result, $data);


    $id = $data[0]['id'];

    $weatherComments = array();
    $sql = "SELECT * FROM `v2v_weather_keywords` where DAGB_VADER_ID = :id and LANG_ID = :lang";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($comments as  $comment){
        array_push($weatherComments, $comment);
    }


    array_push($result, $weatherComments);

    return $result;

}

function getWeatherForDate($pdo, $date, $lang){

    $sql = "SELECT * FROM  v2v_dagboks_vader where SHOW_IN_BLOG = 1 and DATUM = :date order by SORTORDER";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = array();
    array_push($result, $data);
    $weatherComments = array();

    foreach ($data as $time){

        $id = $time['id'];
        $sql = "SELECT * FROM `v2v_weather_keywords` where DAGB_VADER_ID = :id and LANG_ID = :lang";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":lang", $lang, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($comments as  $comment){
            array_push($weatherComments, $comment);
        }

    }

    array_push($result, $weatherComments);

    return $result;

}


function getArtMaxDagarStrack($pdo, $selectedArt){

    $sql = 'select * from v2v_strack_max_day_year_taxa where art = :taxa';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":taxa", $selectedArt, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenNumberOfBirdsCounted($pdo){

    $sql = 'select sum(summa) as untilLastYear from sddagsum where snr != 996';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $partOne = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'select sum(summa) as thisYear from strtemp where snr != 996';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $partTwo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $partOne[0]['untilLastYear'] + $partTwo[0]['thisYear'];

}

function updateOvrigMarkning($pdo){

    $sql = "update rmdagsum set P = 'OV' where p = 'ÖV'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

}