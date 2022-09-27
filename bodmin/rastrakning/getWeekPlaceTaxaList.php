<?php

include_once '../aahelpers/db.php';
echo json_encode(getWeeklyAveragePerPlace(getPDO(), $_GET['vecka'], $_GET['lokal'] , $_GET['lang']));

