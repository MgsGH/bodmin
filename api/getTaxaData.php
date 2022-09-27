<?php

include_once '../aahelpers/db.php';
echo json_encode(getTaxa(getDataPDO(), $_GET['lang']));