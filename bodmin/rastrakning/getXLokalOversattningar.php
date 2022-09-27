<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getLokalNamnOverSattningar($pdo, $_GET['id']);
echo json_encode($userData);
