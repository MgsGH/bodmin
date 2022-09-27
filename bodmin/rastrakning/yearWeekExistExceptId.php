<?php

include_once '../aahelpers/db.php';
echo json_encode(getYearVeckaExistExceptId(getPDO(), $_GET['id'], $_GET['year'], $_GET['vecka']));
