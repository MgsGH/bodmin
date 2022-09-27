<?php
session_start();

//include_once "../aahelpers/data.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "ringmarkning-functions.php";


$pdo = getDataPDO();
$language = $_GET['language'];
$dateYmd = $_GET['date'];
$year = substr($dateYmd, 0, 4);


$data = array();

$seasons = getActiveSeasonsThisDate($pdo, $dateYmd, $language);

if (count($seasons) > 0){

    $stringSevenDays = getCommaSeparatedListOfLastSevenDays($dateYmd);

    // for each ongoing season, compile the data set
    for ($i=0; $i < count($seasons); $i++){

        $season = $seasons[$i];
        $seasonString = $season["TEXT_CODE"];
        $startYear = $season["STARTYEAR"];
        $noOfSeasons = $year - $startYear -1;

        $sevenDaysData = getSevenDaysData($pdo, $language, $stringSevenDays, $seasonString);

        // compile list of taxa ringed during the last seven days this season
        $taxaAsString = buildTaxaString($sevenDaysData);

        // get data for compiling season averages and totals for the species caught
        $aSeasonTotals = getSeasonRingingTotals($pdo, $seasonString, $year, $taxaAsString);

        $sevenDaysData = updateSevenDaysDataWithSeasonTotal($sevenDaysData, $aSeasonTotals);

        $soFarSeasonTotals = getTotalsForSeasonAndYearsUntilDate($pdo, $seasonString, $dateYmd);
        $sevenDaysData = updateSevenDaysDataWithSoFarSeasonAverages($sevenDaysData, $soFarSeasonTotals, $noOfSeasons);

        $allTimeTotals = getTotalsForSeasonAllTime($pdo, $seasonString);
        $sevenDaysData = updateSevenDaysDataWithAllSeasonAverages($sevenDaysData, $allTimeTotals, $noOfSeasons);

        // fish out field names for making the table
        $tableFields = array_keys($sevenDaysData[0]);

        $aUntilTodayRingingTotals = getSeasonTotalsUntilNow($pdo, $seasonString, $dateYmd, $taxaAsString);
        $aDataForThisSeason = array(
            "data" => $sevenDaysData,
            "fields" => $tableFields,
            "season" => $season,

        );
        array_push($data, $aDataForThisSeason);

    }

}


echo json_encode($data, JSON_UNESCAPED_UNICODE);



