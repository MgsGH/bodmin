<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$userNameToUpdate = 'magnus.grylle@gmail.com';
$passWord = 'ztest';

updatePasswordForUserName($pdo, $userNameToUpdate, $passWord);

?>

<h1>klart!</h1>


