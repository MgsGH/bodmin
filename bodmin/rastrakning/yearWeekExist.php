<?php
include_once '../aahelpers/db.php';
echo json_encode(getYearVeckaExist(getPDO(), $_GET['year'], $_GET['vecka']));