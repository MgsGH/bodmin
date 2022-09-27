<?php

include_once '../aahelpers/db.php';

$existingCount = getLocationYearWeekData(getPDO(), $_GET['occasion'], $_GET['place']);
echo json_encode($existingCount);