<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();


$logged_in_user = $_POST['logged_in_user'];
$main_table_id = $_POST['main_table_id'];
$record_id = $_POST['record_id'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$booking_noof = $_POST['booking_noof'];
$booking_age = $_POST['booking_age'];
$booking_comment = $_POST['booking_comment'];


if ($_POST['mode'] === 'add'){

    $writtenId = writeGuidingBooking($pdo, $logged_in_user, $main_table_id, $booking_date, $booking_time, $booking_noof, $booking_age, $booking_comment );

    $record['ID'] = $writtenId;
    $jsonData = json_encode($record);
    echo($jsonData);

}


if ($_POST['mode'] === 'edit'){
    updateGuidingBooking($pdo, $logged_in_user, $record_id, $booking_date, $booking_time, $booking_noof, $booking_age, $booking_comment );
}


if ($_POST['mode'] === 'delete'){
    deleteGuideBooking($pdo, $record_id);
}




