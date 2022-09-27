<?php


include_once '../aahelpers/db.php';
echo json_encode(getWeekTable(getPDO(), $_GET['year'], $_GET['vecka'], $_GET['lang']));
