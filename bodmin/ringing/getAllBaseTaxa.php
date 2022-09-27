<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getAllBaseTaxa($pdo);
echo json_encode($data);
