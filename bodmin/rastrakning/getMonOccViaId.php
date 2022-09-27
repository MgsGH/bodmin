<?php

include_once '../aahelpers/db.php';
echo json_encode(getMonitoringOccassion(getPDO(), $_GET['id']));
