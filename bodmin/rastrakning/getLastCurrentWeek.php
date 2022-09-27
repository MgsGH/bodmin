<?php

include_once '../aahelpers/db.php';
$pdo = getPDO();
$data = getLastCurrentWeek($pdo);
echo json_encode($data);
