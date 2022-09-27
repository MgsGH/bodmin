<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();

$id = $_POST['id'];
$status = $_POST['status'];
$userId = $_POST['updater'];

changePublishingStatus($pdo, $id, $status, $userId);
