<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$logged_in_user = $_POST['logged_in_user'];
$table_id = $_POST['table_id'];
$customer_name = $_POST['customer_name'];
$customer_address = $_POST['customer_address'];
$customer_zipcode = $_POST['customer_zipcode'];
$customer_city = $_POST['customer_city'];
$customer_contact_person = $_POST['customer_contact_person'];
$customer_email = $_POST['customer_email'];
$customer_telephone_one = $_POST['customer_telephone_one'];
$customer_telephone_two = $_POST['customer_telephone_two'];
$customer_invoice_name = $_POST['customer_invoice_name'];
$customer_invoice_id = $_POST['customer_invoice_id'];
$customer_invoice_address = $_POST['customer_invoice_address'];
$customer_invoice_zipcode = $_POST['customer_invoice_zipcode'];
$customer_invoice_city = $_POST['customer_invoice_city'];


if ($_POST['mode'] === 'edit'){
    updateGuidingCustomer($pdo, $logged_in_user, $table_id, $customer_name, $customer_address, $customer_zipcode, $customer_city, $customer_contact_person, $customer_email, $customer_telephone_one, $customer_telephone_two, $customer_invoice_name, $customer_invoice_id, $customer_invoice_address, $customer_invoice_zipcode, $customer_invoice_city);
}


if ($_POST['mode'] === 'add'){

    $writtenId = writeGuidingCustomer($pdo, $logged_in_user, $table_id, $customer_name, $customer_address, $customer_zipcode, $customer_city, $customer_contact_person, $customer_email, $customer_telephone_one, $customer_telephone_two, $customer_invoice_name, $customer_invoice_id, $customer_invoice_address, $customer_invoice_zipcode, $customer_invoice_city);

    $record['ID'] = $writtenId;
    $jsonData = json_encode($record);
    echo($jsonData);


}


if ($_POST['mode'] === 'delete'){

    deleteGuideBookingsForCustomer($pdo, $table_id);
    deleteGuidingCustomer($pdo, $table_id);

}




