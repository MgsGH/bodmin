<?php

include '../aahelpers/db.php';

/*
foreach ($_POST as $item => $value){
    dbLog($item . ': ' . $value);
}
*/


$subject = "Julgåva - Beställning";
$msg = "Beställning - Julgåva" . "\r\n" .
    "------------------------------------------------" . "\r\n" .
    "Julgåva: " . $_POST['gift'] . "\r\n" .

    "julhälsning: " . $_POST['greeting'] . "\r\n" .
    "Till: " . $_POST['towhom'] . "\r\n" .
    "Önskar: " . $_POST['wishes'] . "\r\n" .
     "\r\n" .
    "Leveransuppgifter" . "\r\n" .
    "Överlämnas via:  " . $_POST['deliveryFirstName'] .  ' ' . $_POST['deliveryLastName'] . "\r\n" .
    "Adress " . $_POST['deliveryAddressStreet'] .  ' ' . $_POST['deliveryAddressZipCode'] .  ' ' . $_POST['deliveryAddressCity'] . "\r\n" .
    "\r\n" .
    "Beställare (inbetalare)" . "\r\n" .
    "Namn " . $_POST['payeeFirstName'] .  ' ' . $_POST['payeeLastName'] . "\r\n" .
    "E-mail " . $_POST['payeeEmail']  . "\r\n" .
    "Telefonnummer " . $_POST['payeeTelephone']  . "\r\n" .
    "\r\n" .
    "Summa " . $_POST['sum']  . "\r\n";
$msg = wordwrap($msg,70);


mail("falsterbo@skof.se",$subject, $msg);

