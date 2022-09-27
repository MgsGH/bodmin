<?php



$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
$order_id = $_GET['order'];
$language_id = $_GET['language'];

$fullOrder = array();
include_once $path . '/sales/data/db.php';
$pdo = getSalesPDO();

$fullOrder['customer'] = getOrder($pdo, $order_id, $language_id);
$fullOrder['orderRows'] = getOrderRows($pdo, $order_id, $language_id);

echo json_encode($fullOrder, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
