<?php


function rss_formatDates($days, $noOfDays){


    $allDays = array();

    for ($i = 0; $i <= $noOfDays; $i++){

        $day = mysqli_fetch_assoc($days);
        $dag = $day['DAG'];
        $rssDate = DateTime::createFromFormat('Y-m-d', $dag)->format('r');
        $dateVariants = array($dag, $rssDate);
        $allDays = array_merge($dateVariants);
    }

    return $allDays;

}


/*---------------------------------------------------------------------------------------------*/
function rss_getTextForDay($datum){

    $dagBokTextFilSw = $datum . '.txt';
    $txtDirectory = substr($datum, 0, 4);
    $baseDirectory = dirname(__FILE__ );
    $baseDirectory = substr($baseDirectory, 0, 39);
    $txtFilSwedish = $baseDirectory . DIRECTORY_SEPARATOR . $txtDirectory . DIRECTORY_SEPARATOR . $dagBokTextFilSw;

    if (file_exists($txtFilSwedish)) {
        $dagBokText = file_get_contents($txtFilSwedish);
        $imgUrl = 'https://www.falsterbofagelstation.se/news/dagbok/' . $txtDirectory . DIRECTORY_SEPARATOR . 'upl_bilder' . DIRECTORY_SEPARATOR;
        $replace = $txtDirectory.'/upl_bilder/';

        $dagBokText = str_replace($replace, $imgUrl, $dagBokText );
        $dagBokText = strip_tags($dagBokText, '<img><p><br><b><h1><h2><h3>');

    } else {
        $dagBokText = 'Ingen ringmärkning idag. - No ringing/banding today.';
    }

    return $dagBokText;

}


function rss_getLocationDataAsHTML($connection, $location, $day){

    $str = "Inga arter fångade";
    $dataBySpecies = rss_getRingingDataforLocationAndDay($connection, $location, $day);
    if (mysqli_num_rows($dataBySpecies) > 0) {

        $str = "";
        $noOfSpecies = mysqli_num_rows($dataBySpecies)-1; // summa raden
        $fagelText = "birds";
        $artText = "species";
        if ($noOfSpecies == 0){
            $fagelText = "bird";
        }

        $locationName = '<strong>' . rss_getLocationName($location, 'en') . ':</strong>';

        while ($species = mysqli_fetch_assoc($dataBySpecies)) {
            if ($species['svnamn'] != "SUMMA"){
                $str = $str . $species['ENGNAMN'] . ' ' . '<i>' . $species['LATNAMN'] . '</i>' . ': ' . $species['summa'] .', ';
            } else {
                // last record - summa
                $str = substr($str, 0 , strlen($str)-2); // prune last ", "
                //$str = ucfirst(strtolower($str));
                $str = $str . '.' . '</br>';
                $str = $str . '<u>' . 'Total: ' . $species['summa'] .' ' . $fagelText . ' of '. $noOfSpecies .' ' . $artText . '</u>';
            }
        }

        $str = $locationName . ' ' . $str;
    }

    return $str;

}


function rss_getRingingInfo($connection, $datum){

    // For all ringing locations,
    // Check if we actually took some birds this day anywhere
    $ringingDataAsHTML = 'Ingen ringmärkning idag. - No ringing/banding today.';
    $locationsQuery = rss_getRingingLocations($connection, $datum);
    if (mysqli_num_rows($locationsQuery) > 0) {

        $ringingDataAsHTML = '<b>Banding/ringing - ringmärkning</b><br/>';

        // extract ringing data
        while ($location = mysqli_fetch_assoc($locationsQuery)) {
            $ringingDataAsHTML = $ringingDataAsHTML . '<p>' . rss_getLocationDataAsHTML($connection, $location['p'], $datum) . '</p>';
        }

    }

    return $ringingDataAsHTML;

}


function rss_getLocationName($pkod, $language){

    $str = "";
    switch ($pkod){
        case 'FA':
            $str='Fyren, standardiserad märkning';
            $e='Lighthouse Garden, standardised ringing';
            break;
        case 'FB':
            $str='Fyren, standardiserad märkning';
            $e='Lighthouse Garden, standardised ringing';
            break;
        case 'FC':
            $str='Flommen, standardiserad märkning';
            $e='Flommen reedbeds, standardised ringing';
            break;
        case 'ÖV':
            $str='Övrig märkning';
            $e='Miscellaneous ringing';
            break;
        case 'PU':
            $str='Pullmärkning';
            $e='Nestlings';
            break;
        //lokaler för specificerad övrigfångst Obs. Black bör ha annan kod kommer annars före standardfångsten vid visningen
        case 'BL':
            $str='Black, övrig märkning';
            $e='Black, misc. ringing';
            break;
        case 'FP':
            $str='Falsterbo park, övrig märkning';
            $e='Falsterbo Park, misc. ringing';
            break;
        case 'FM':
            $str='Flommen, övrig märkning';
            $e='Flommen reedbeds, misc. ringing';
            break;
        case 'FO':
            $str='Falsterbo samhälle, övrig märkning';
            $e='Falsterbo village, misc. ringing';
            break;
        case 'FY':
            $str='Fyren, övrig märkning';
            $e='Lighthouse Garden, misc. ringing';
            break;
        case 'KN':
            $str='Knösen, övrig märkning';
            $e='Knösen, misc. ringing';
            break;
        case 'LJ':
            $str='Skanörs Ljung, övrig märkning';
            $e='Skanörs Ljung, misc. ringing';
            break;
        case 'LH':
            $str='Ljunghusen, övrig märkning';
            $e='Ljunghusen, misc. ringing';
            break;
        case 'MÅ':
            $str='Måkläppen, övrig märkning';
            $e='Måkläppen, misc. ringing';
            break;
        case 'NA':
            $str='Nabben, övrig märkning';
            $e='Nabben, misc. ringing';
            break;
        case 'SK':
            $str='Skanör, övrig märkning';
            $e='Skanör, misc. ringing';
            break;
        case 'SL':
            $str='Slusan-Bakdjupet, övrig märkning';
            $e='Slusan-Bakdjupet, misc. ringing';
            break;
        case 'SP':
            $str='Skanörs park, övrig märkning';
            $e='Skanör Park, misc. ringing';
            break;
        case 'SR':
            $str='Skanörs revlar, övrig märkning';
            $e='Skanörs revlar, misc. ringing';
            break;
        case 'ÄN':
            $str='Ängsnäset, övrig märkning';
            $e='Ängsnäset, misc. ringing';
            break;
    }
    if ($language == 'en'){
        $str = $e;
    }
    return $str;
}




