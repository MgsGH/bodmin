<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$customer_id = $_GET['customer'];
$bookings = getGuidingCustomerBookings($pdo, $customer_id);
echo json_encode($bookings);
