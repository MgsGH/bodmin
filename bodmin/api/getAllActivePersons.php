<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();
$data = getAllActivePersons($pdo);

echo  json_encode($data);

