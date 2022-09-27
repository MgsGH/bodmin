<?php
session_start();

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/sales/data/db.php';


$pdo = getSalesPDO();


$items = $_POST['items'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$address = $_POST['postalAddress'];
$zipCode = $_POST['zipCode'];
$city = $_POST['city'];
$country = $_POST['country'];
$eMail = $_POST['email'];

$customerId = writeCustomer($pdo, $firstName, $lastName, $address, $zipCode, $city, $country, $eMail );

dbLog( 'Customer id: ' . $customerId );

$aOrders = json_decode($items, true);
for ($i = 0; $i < count($aOrders); $i++){

    writeOrderRow($pdo, $customerId, $aOrders[$i]['articleId'] , $aOrders[$i]['noof'], 'XL');
    dbLog($aOrders[$i]);
}






