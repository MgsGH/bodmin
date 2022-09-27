<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}


include_once $path . '/sales/data/db.php';
$pdo = getSalesPDO();

$order_id = $_POST['order_id'];

dbLog($_POST['mode']);
dbLog($order_id);

if ($_POST['mode'] === 'delete'){

    deleteOrderRowsForCustomer($pdo, $order_id);
    deleteCustomer($pdo, $order_id);

}




