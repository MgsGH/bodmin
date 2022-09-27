<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();
$data = getAllPersonSignatures($pdo);

echo  json_encode($data);
