<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();

$data = getAllBlogDates($pdo);
echo json_encode($data);


