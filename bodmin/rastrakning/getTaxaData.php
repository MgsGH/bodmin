<?php

include_once '../aahelpers/db.php';
echo json_encode(getTaxa(getPDO(), $_GET['lang']));