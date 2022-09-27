<?php


function getStracktaOchFoljdaArter($pdo, $language){

    $lastYear = getCurrentYear() - 1;
    $table = 'str_rang_' . $lastYear;

    $sql = 'SELECT DISTINCT sddagsum.art, artnamn.svnamn AS NAMN ' ;
    if ($language == 'en'){
        $sql = 'SELECT DISTINCT sddagsum.art, artnamn.engnamn AS NAMN ' ;

    }
    $sql =  $sql . ' from sddagsum, artnamn WHERE sddagsum.art=artnamn.art and sddagsum.art in (select art from ' . $table . ' where VAL="X")';
    $sql =  $sql . 'ORDER BY sddagsum.snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getStracktaArter($pdo, $language){

    $sql = 'SELECT DISTINCT sddagsum.art, artnamn.svnamn AS NAMN ' ;
    if ($language == 'en'){
        $sql = 'SELECT DISTINCT sddagsum.art, artnamn.engnamn AS NAMN ' ;
    }
    $sql =  $sql . ' from sddagsum, artnamn WHERE sddagsum.art=artnamn.art ORDER BY sddagsum.snr';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function getMax10DagSumStrack($pdo, $art){

    $sql = 'select SVNAMN AS NAMN, DATUM, SUMMA from sddagsum, artnamn where sddagsum.ART = "' . $art . '" and artnamn.ART = sddagsum.ART order by summa desc limit 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMax10ArSumStrack($pdo, $art){

    $sql = 'select  year(DATUM) AR, art, sum(summa) as ARSUMMA from sddagsum where art = "' . $art . '" 
    GROUP BY year(DATUM) order by ARSUMMA DESC LIMIT 10';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPublications($connection, $sortorder, $selectedAuthor, $selectedKeyword, $selectedArt, $page){

    $baseSql = 'SELECT fbomeddelanden.author, fbomeddelanden.year, fbomeddelanden.title, fbomeddelanden.journal, fbomeddelanden.summary, fbomeddelanden.no as ID, fbomeddelanden.pdf FROM fbomeddelanden';

    // add additional tables if needed
    if ($selectedKeyword != 'alla') {
        $baseSql = $baseSql . ', fbomedd_nyckelord ';
    }

    if ($selectedAuthor != 'alla') {
        $baseSql = $baseSql . ', fbomedd_persons ';
    }

    if ($selectedArt != 'alla') {
        $baseSql = $baseSql . ', fbomedd_arter_ii ';
    }

    // dummy so all other where clauses can have the same structure
    $baseSql = $baseSql . ' where 3 > 2 ';

    // add where clauses - if needed
    if ($selectedAuthor != 'alla') {
        $baseSql = $baseSql . ' and fbomedd_persons.PERSON_ID = ' . $selectedAuthor;
        $baseSql = $baseSql . ' and fbomeddelanden.no = fbomedd_persons.FBOMEDD_ID';

    }

    if ($selectedKeyword != 'alla') {
        $baseSql = $baseSql . ' and fbomeddelanden.no = fbomedd_nyckelord.fbomedd_id ';
        $baseSql = $baseSql . ' and fbomedd_nyckelord.nyckelord_id = ' . $selectedKeyword;
    }

    if ($selectedArt != 'alla') {
        $baseSql = $baseSql . ' and fbomeddelanden.no = fbomedd_arter_ii.FBOMEDD_ID ';
        $baseSql = $baseSql . ' and fbomedd_arter_ii.ART_ART = "' . $selectedArt .'"';
    }

    $sort = ' order by year desc';
    if ($sortorder == 'stigande'){
        $sort = ' order by year ASC';
    }

    $sql = $baseSql . $sort;

    return getDataWithPaginationInfoAsArray($connection, $sql, $page);

}


function getStrackRakningsDagar($pdo, $year, $month){

    if (ongoingYear($year)){
        $tabell = 'strtemp';
    } else {
        $tabell = 'sddagsum';
    }

    $sql = 'SELECT distinct DATUM FROM ' . $tabell .
        '    where YEAR(DATUM) = ' . $year .
        ' AND MONTH(DATUM) = ' . $month;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMostRecentMigrationMonitoringDate($pdo){

    if (ongoingYear(getCurrentDateAsYMD())){
        $tabell = 'strtemp';
    } else {
        $tabell = 'sddagsum';
    }
    $sql = 'SELECT MAX(DATUM) MAXDATUM FROM ' . $tabell;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getDataAsArray($connection, $sql): array
{

    //-------------------------------------------------------------------------------------------------
    //var_dump($sql);
    //echo('<hr>');

    $a = array();
    $q = mysqli_query($connection, $sql);
    while ($row=mysqli_fetch_assoc($q)){
        array_push($a, $row);
    }

    return $a;
}


function getDataWithPaginationInfoAsArray($connection, $sql, $page){

    $perSida = 20;
    $dataInformation = array();

    $allData = getDataAsArray($connection, $sql);
    $totAntalRecords = sizeof($allData);
    $dataPage = array();

    $start = ($page * $perSida) - $perSida;
    $stop = $start + $perSida;

    $i = 0;
    while ($i < $stop){

        if (($i < $totAntalRecords ) && ($i >= $start)){
            array_push($dataPage, $allData[$i]);
        }

        $i++;

    }

    $dataInformation['rows'] = sizeof($allData);

    $sql = $sql . ' LIMIT ' . $page . ', ' . $perSida;

    $dataInformation['data'] = $dataPage;
    $dataInformation['records'] = $totAntalRecords;
    $dataInformation['pages'] = ceil( sizeof($allData) / $perSida);
    $dataInformation['currentPage'] = $page;

    return $dataInformation;

}


function getLokalNamn($pdo, $place, $language){

    $languageAsinteger = 2;
    if ($language == 'en'){
        $languageAsinteger = 1;
    }

    $sql = 'SELECT * FROM v2v_lokaler_and_texts where TEXT_CODE = "' . $place . '" and LANGUAGE_ID = "' . $languageAsinteger . '"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPre80YearTotals($pdo, $year, $language){

    $sql = 'SELECT rm4779.snr, rm4779.art, rm4779.summa, artnamn.SVNAMN AS NAMN from rm4779, artnamn WHERE rm4779.year= "'
        . $year . '" and rm4779.art=artnamn.art ORDER BY rm4779.snr';

    if ($language == 'en'){
        $sql = 'SELECT rm4779.snr, rm4779.art, rm4779.summa, artnamn.ENGNAMN AS NAMN from rm4779, artnamn WHERE rm4779.year= "'
            . $year . '" and rm4779.art=artnamn.art ORDER BY rm4779.snr';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRingingLocations($connection, $day){

    $sql = 'SELECT TEXT_CODE as p FROM markdagar_plats_typ where datum="' . $day .'"' .
        ' ORDER BY p';

    return getDataAsArray($connection, $sql);

}


function getStartStopTimes($pdo, $ringingLocationCode){

    $sql = "select * from v2v_rm_lokaler_marktider where TEXT_CODE = :location ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":location", $ringingLocationCode, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getCompleteYearsStrackData($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = substr($idag, 0, 4);
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);;

    $md_str=$monad.'-'.$dag; 			     //ex 10-30
    $jmfdag=$md_str;
    $jmfdag30 = ($year-1) . '-' . $md_str;  //ex 2014-10-30
    $no_of_years=($year-1)-1972;	        //ex 42
    $fDat=$year.'-08-01';				    //ex 2010-08-01

    $start='1973-08-11';
    $sql="SELECT sddagsum.DATUM, sddagsum.SNR, artnamn.SVNAMN AS ART, sddagsum.SUMMA, subtot.ANTAL, medel.medelv";
     if ($language == 'en'){
         $sql="SELECT sddagsum.DATUM, sddagsum.SNR, artnamn.ENGNAMN AS ART, sddagsum.SUMMA, subtot.ANTAL, medel.medelv";
     }
     $sql = $sql .
        "
         from sddagsum, artnamn,
         (SELECT snr, art, SUM(SUMMA) AS ANTAL FROM sddagsum 
         where sddagsum.datum>='$fDat'
         and sddagsum.datum<='$idag' 
         GROUP BY sddagsum.snr) AS subtot,
         (SELECT snr, art, round(sum(SUMMA)/'$no_of_years', 0) AS medelv
         FROM sddagsum
         WHERE datum>='$start'
         AND substr(datum,6,5)<='$jmfdag'
         AND datum<='$jmfdag30'
         GROUP BY sddagsum.snr) AS medel
         WHERE datum='$idag'
         AND sddagsum.ART=artnamn.ART
         and sddagsum.ART=subtot.ART
         and sddagsum.ART=medel.ART 
         ORDER BY sddagsum.SNR";

    dbLog($sql);

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getOngoingYearStrackData($pdo, $idag, $language){

    // "2020-11-20"
    //  0123456789
    $year = substr($idag, 0, 4);
    $monad = substr($idag, 5, 2);
    $dag = substr($idag, 8, 2);;

    $md_str=$monad.'-'.$dag; 			     //ex 10-30
    $jmfdag=$md_str;
    $jmfdag30 = ($year-1) . '-' . $md_str;  //ex 2014-10-30
    $no_of_years=($year-1)-1972;	        //ex 42
    $fDat=$year.'-08-01';				    //ex 2010-08-01

    $start='1973-08-11';
    $sql="SELECT strtemp.DATUM, strtemp.SNR, artnamn.SVNAMN AS ART, strtemp.SUMMA, subtot.ANTAL, medel.medelv";
    if ($language == 'en'){
        $sql="SELECT strtemp.DATUM, strtemp.SNR, artnamn.ENGNAMN AS ART, strtemp.SUMMA, subtot.ANTAL, medel.medelv";
    }
    $sql = $sql .
        "
         from strtemp, artnamn,
         (SELECT snr, art, SUM(SUMMA) AS ANTAL FROM strtemp 
         where strtemp.datum>='$fDat'
         and strtemp.datum<='$idag' 
         GROUP BY strtemp.snr) AS subtot,
         (SELECT snr, art, round(sum(SUMMA)/'$no_of_years', 0) AS medelv
         FROM sddagsum
         WHERE datum>='$start'
         AND substr(datum,6,5)<='$jmfdag'
         AND datum<='$jmfdag30'
         GROUP BY sddagsum.snr) AS medel
         WHERE datum='$idag'
         AND strtemp.ART=artnamn.ART
         and strtemp.ART=subtot.ART
         and strtemp.ART=medel.ART         
         ORDER BY strtemp.SNR";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenYearTotals($pdo, $art){

    $sql = 'select YEAR, ARSSUMMA AS ANTAL FROM `v2v_strack_arssummor` WHERE ART="' .$art .'"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}

function getNabbenArsSumma($pdo, $art, $language){

    $sqlIntro = 'select YEAR, SNR, ART, ARSSUMMA,';
    $sqlLangPart = ' svnamn AS NAMN ';
    if ($language == 'en'){
        $sqlLangPart = ' engnamn AS NAMN ';
    }

    $sql = $sqlIntro . $sqlLangPart . ' from v2v_strack_arssummor_namn where art = "' . $art . '" order by SNR';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}




function getNabbenStatMetaData($pdo, $art, $language){

    $lastYear = getCurrentYear() - 1;
    $table = 'str_rang_' . $lastYear;

    $sql = 'select Rs, SIGN, VAL, sv_com AS KOMMENTAR_TXT ';
    if ($language == 'en'){
        $sql = 'select Rs, SIGN, VAL, eng_com AS KOMMENTAR_TXT ';
    }

    $sql = $sql . ' from ' . $table . ' where art="' . $art . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTheEventsFromStorage($pdo, $selectedYear, $selectedMonth){

    $pageDays = array();
    $sqlString = ("
                        SELECT *
                        FROM dagboksblad
                        WHERE EventYear = '" . $selectedYear . "'
                        AND EventMonth = '" . $selectedMonth . "'
                        ");

    $stmt = $pdo->prepare($sqlString);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // build an array of days when we ringed
    while ($record = mysqli_fetch_array($events)){

        $tmp = $record['dagbdatum'];
        array_push($pageDays, $tmp);
    }


    return $pageDays;

}


function getMostRecentWeekData($connection){

    $sql="select YEAR, VE, SNR, ART, KANAL, BLACK, ANGSN, NABMA, SLALH, REVLA, KNOSE, SUMMA from rastbas
    where YEAR = (select max(YEAR) from rastbas)
    and VE = (select max(VE) from rastbas where year=(select max(YEAR) from rastbas))";

    $query = mysqli_query($connection, $sql) or die (mysqli_error($connection));
    $row = mysqli_fetch_array($query);
    return $row;

}


function getMostRecentWeekNo($connection){

    $sql="select max(VE) VE from rastbas where year=(select max(YEAR) from rastbas)";
    $query=mysqli_query($connection, $sql) or die (mysqli_error($connection));
    $row=mysqli_fetch_array($query);
    return $row['VE'];

}


function getAllYears($connection, $sen_vec){

    $sql_artal="SELECT DISTINCT YEAR from rastbas where YEAR > 1992 ORDER BY YEAR";
    $query_artal=mysqli_query($connection, $sql_artal) or die (mysqli_error($connection));
    $i = 1;
    $result = '';
    while ($row=mysqli_fetch_assoc($query_artal)){

        // Default weeks for all years
        // Check if selected week is entered this year, if not show last one done
        if ($row['YEAR'] == date('Y')){
            $mostRecentWeekEntered = getMostRecentWeekNo($connection);
            if ($sen_vec > $mostRecentWeekEntered){
                $sen_vec = $mostRecentWeekEntered;
            }
        }

        if (strlen($sen_vec) == 1){
            $sen_vec = '0' . $sen_vec;
        }

        $htmlString = '<td align="center" class="restweek"><a href="'.$_SERVER['PHP_SELF'].'?yno='.$row['YEAR'].'&wno='.$sen_vec.'">'.$row['YEAR'].'</a></td>';
        if($i==10){
            $htmlString = $htmlString . '</tr><tr>';
            $i =0;
        }
        $i++;
        $result = $result . $htmlString;
        //echo $htmlString;
    }

    return $result;
}


function getSpeciesNames($pdo, $art, $language){

    $sql = 'select LATNAMN, svnamn as NAMN';
    if ($language == 'en'){
        $sql = 'select LATNAMN, engnamn as NAMN';
    }

    $sql = $sql . ' from artnamn where art = "' . $art . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





function getNabbenArligaMedeltal($pdo){

    $sql = 'select * from `strack_ar_art_medel`';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getPost79TotalData($pdo, $language ){

    $sql = 'SELECT art, snr, svnamn AS NAMN,';
    if ($language == 'en'){
        $sql = 'SELECT snr, engnamn AS NAMN,';
    }

    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) AS 'FA', " ;
    $sql = $sql . " SUM(IF(P = 'FB',  SUMMA, 0)) AS 'FB', ";
    $sql = $sql . " SUM(IF(P = 'FC',  SUMMA, 0)) AS 'FC', ";
    $sql = $sql . " SUM(IF(P = 'ÖV',  SUMMA, 0)) AS 'ÖV', ";
    $sql = $sql . " SUM(IF(P = 'PU',  SUMMA, 0)) AS 'PU', ";
    $sql = $sql . " SUM(IF(P = 'FA',  SUMMA, 0)) + SUM(IF(P = 'FB',  SUMMA, 0)) + SUM(IF(P = 'FC',  SUMMA, 0)) + SUM(IF(P = 'ÖV',  SUMMA, 0)) + SUM(IF(P = 'PU',  SUMMA, 0)) AS 'TOT' ";
    $sql = $sql . " FROM `rmdagsumwithnames_mg` ";
    $sql = $sql . " GROUP BY SNR";
    $sql = $sql . " ORDER BY snr ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}





function getPre80YearTotalsForOneSpecies($pdo, $art, $startYear, $stopYear){

    $sql ='SELECT year, summa from rm4779 WHERE art="' . $art . '" AND year>"' . $startYear . '" and year<"' . $stopYear . '" ORDER BY year desc ';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function getTenYearRingingAverages($pdo, $season, $art){

    $sql = '';
    $decade = 198;
    $currentDecade = substr(getCurrentYear(), 0, 3);

    while ($decade < $currentDecade){

        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/10,0) AS MV from rmdagsum where art="'. $art . '" AND P="' . $season .'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
        $sql = $sql . ' UNION ';

        $decade++;

    }

    $remainingYears = (getCurrentYear() - ($currentDecade * 10));
    if ($remainingYears >= 3) {
        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/' . $remainingYears . ', 0) AS MV from rmdagsum where art="'. $art . '" AND P="' . $season .'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
    }

    if (substr($sql, strlen($sql) - 7) == ' UNION ') {
        $sql = substr($sql, 0 , strrpos($sql,' UNION '));
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTenYearStrackAverages($pdo, $art){

    $sql = '';
    $decade = 198;
    $currentDecade = substr(getCurrentYear(), 0, 3);

    while ($decade < $currentDecade){

        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/10,0) AS MV from sddagsum where art="'.$art.'" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
        $sql = $sql . ' UNION ';

        $decade++;

    }

    $remainingYears = (getCurrentYear() - ($currentDecade * 10));
    if ($remainingYears >= 3) {
        $colName = $decade . '0' . ' - ' . $decade . '9';
        $column = 'select "' . $colName . '" AS PERIOD, round(sum(summa)/' . $remainingYears . ', 0) AS MV from sddagsum where art="'. $art . '" and substr(datum, 1, 3) = ' . $decade;
        $sql = $sql . $column;
    }

    $sql = substr($sql, 0 , trim(strlen($sql)) - 6);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSeasonSpeciesTotals($pdo, $sasong, $art ){

    $lastYear = getCurrentYear()-1;
    $sql = 'SELECT year(DATUM) AS YEAR, sum(SUMMA) AS ANTAL, artnamn.SVNAMN  
                         FROM rmdagsum, artnamn
                         WHERE artnamn.art="' .$art . '" 
                         AND rmdagsum.P="' . $sasong . '"
                         AND rmdagsum.art = artnamn.art
                         AND YEAR(DATUM)<=' . $lastYear . '
                         GROUP BY YEAR
                         ORDER BY YEAR';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataIncreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'str_rang_' . $last_year;

    $sql = 'SELECT * , artnamn.SVNAMN AS NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }
    $sql = $sql . ' 
                WHERE VAL="X" 
                AND num_rs>0
                AND sign<>"n.s."
                AND ' . $db_tabell . '.art=artnamn.art ';

                // default "om"
                $sort = ' order by num_rs desc, ' . $db_tabell . '.snr';
                if ($sortorder == "sy") {
                    $sort = ' order by ' . $db_tabell . '.snr';
                }
                $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataDecreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'str_rang_' . $last_year;

    $sql = 'SELECT * , artnamn.SVNAMN AS NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }
    $sql = $sql . ' 
                WHERE VAL="X" 
                AND num_rs<0
                AND sign<>"n.s."
                AND ' . $db_tabell . '.art=artnamn.art';

                // default "om"
                $sort = ' order by num_rs asc, ' . $db_tabell . '.snr';
                if ($sortorder == "sy") {
                    $sort = ' order by ' . $db_tabell . '.snr';
                }
                $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getStrackPopulationTrendsDataNonSignifant($pdo, $language, $sortorder){


    $last_year =  getCurrentYear()-1;
    $db_tabell = 'str_rang_' . $last_year;

    //ej sign
    $sql = 'SELECT * , artnamn.SVNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    if ($language == 'en'){
        $sql = 'SELECT * , artnamn.ENGNAMN NAMN FROM ' . $db_tabell . ', artnamn';
    }

    $sql = $sql . ' WHERE VAL = \'X\' and locate(\'*\', SIGN ) = 0 AND ' . $db_tabell . '.art = artnamn.art';
    // default "om"
    $sort = ' order by num_rs asc, ' . $db_tabell . '.snr';
    if ($sortorder == "sy") {
        $sort = ' order by ' . $db_tabell . '.snr';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendsDataDecreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL = 'X' 
                    AND num_rs < 0
                    AND sign <> 'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendsDataNonSignifant($pdo, $language, $sortorder){


    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL='X' 
                    AND sign = 'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingPopulationTrendDataIncreasing($pdo, $language, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = 'SELECT artnamn.SVNAMN AS NAMN, sv_com AS COMMENT, ';
    if ($language == 'en'){
        $sql = 'SELECT artnamn.ENGNAMN AS NAMN, eng_com AS COMMENT, ';
    }

    $sql = $sql . " artnamn.art AS ART, Rs, sign AS SIGN, rm_rangarter.Pkod 
                    FROM " . $db_tabell . ", artnamn, rm_rangarter 
                    WHERE VAL='X' 
                    AND num_rs>0
                    AND sign<>'n.s.'
                    AND " . $db_tabell .  ".art=artnamn.art
                    AND " . $db_tabell .  ".art=rm_rangarter.art
                    AND " . $db_tabell .  ".p=rm_rangarter.Pkod
                    AND rm_rangarter.Pkod<>'XX'
                    order by ";

    // default "om"
    $sort = ' num_rs desc ';
    if ($sortorder == "sy") {
        $sort = $db_tabell . '.SNR';
    }
    $sql = $sql . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getMonitoredRingingSpecies($pdo, $language){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = "SELECT distinct artnamn.SVNAMN AS NAMN, artnamn.art ";
    if ($language == 'en'){
        $sql = "SELECT distinct artnamn.ENGNAMN AS NAMN, artnamn.art ";
    }

    $sql = $sql . " FROM " . $db_tabell . ", artnamn where " . $db_tabell . ".art = artnamn.art";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingMonitoringResultForSeason($pdo, $language, $season, $sortorder){

    $last_year =  getCurrentYear()-1;
    $db_tabell = 'rm_rang_' . $last_year;

    $sql = "SELECT * , artnamn.SVNAMN AS NAMN, rm_rangarter.Pkod FROM $db_tabell, artnamn, rm_rangarter";
    if ($language == 'en'){
        $sql = "SELECT * , artnamn.ENGNAMN AS NAMN, rm_rangarter.Pkod FROM $db_tabell, artnamn, rm_rangarter";
    }

    $sql = $sql . " WHERE VAL='X' 
    AND $db_tabell.p='" . $season . "'
    AND $db_tabell.art=artnamn.art
    AND $db_tabell.art=rm_rangarter.art";

    if ($sortorder == 'om'){
        $sort = " order by num_rs desc";
    } else {
        $sort = " order by artnamn.SNR";
    }

    $sql = $sql . $sort;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getRingingMonths($pdo, $year, $season, $species){

    $sql = 'SELECT DISTINCT month(datum) AS MONTH FROM `rmdagsum` WHERE year(datum) = ' .  $year . ' and p = "' . $season . '" and ART="' . $species . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function getRingingDailyTotals($pdo, $year, $season, $species){

    $sql = 'SELECT datum, summa FROM `rmdagsum` WHERE year(datum) = ' .  $year . ' and p = "' . $season . '" and ART="' . $species . '"';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenTioDagasPerioder($pdo, $language){

    $sql = 'select ID, SVTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder order by manad, startdag';
    if ($language == 'en') {
        $sql = 'select ID, ENTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder order by manad, startdag';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getNabbenTioDagasPeriod($pdo, $id){

    $sql = 'select ID, SVTEXT AS PERIOD, MANAD, STARTDAG, PERIOD_LENGTH from str_tio_perioder where id = ' . $id ;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSevenDaysData($pdo, $language, $stringSevenDays, $season){


    $sql = 'SELECT art, snr, svnamn AS NAMN,';
    $sqlIn = '';
    if ($language == 'en'){
        $sql = 'SELECT art, snr, engnamn AS NAMN,';
    }

    $aSevenDays = explode(',', $stringSevenDays);
    for ($i=count($aSevenDays)-1; $i > -1 ; $i--){
        $sql = $sql . " SUM(IF(DATUM = '" . trim($aSevenDays[$i]) . "',  SUMMA, 0)) AS '" . substr(trim($aSevenDays[$i]),5) . "', ";
        $sqlIn = $sqlIn . "'" . trim($aSevenDays[$i]) . "', ";
    }

    $sqlIn = substr($sqlIn, 0, strlen($sqlIn)-2);

    $sql = $sql . " SUM(IF(DATUM = '" . trim($aSevenDays[0])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[1])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[2])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[3])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[4])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[5])  . "',  SUMMA, 0)) + 
                    SUM(IF(DATUM = '" . trim($aSevenDays[6])  . "',  SUMMA, 0))   
                     AS 'VTOT',
                      0 AS 'STOT',
                      0 AS 'SMV',
                      0 AS 'I100'";
    $sql = $sql . " FROM `rmdagsumwithnames_mg` ";
    $sql = $sql . " WHERE DATUM IN (" . $sqlIn . ") ";
    $sql = $sql . " AND P = '" . $season . "'";
    $sql = $sql . " GROUP BY SNR ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getSeasonTotalsUntilNow($pdo, $season, $ymdDataAsString, $taxaListAsString){

    $month = substr($ymdDataAsString, 5, 2);
    $day = substr($ymdDataAsString, 8, 2);

    $sql = 'SELECT art, snr, sum(summa) AS ARTTOT from rmdagsumwithnames_mg ';
    $sql = $sql . " where P = '" . $season . "'";
    $sql = $sql . ' and MONTH(DATUM) <= "' . $month . '" ';
    $sql = $sql . ' and DAY(DATUM) <= "' . $day . '" ';
    $sql = $sql . " and ART IN (" . $taxaListAsString . ")";
    $sql = $sql . " group by snr";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}


function getSeasonRingingTotals($pdo, $season, $year, $taxaListAsString){

    $sql = 'SELECT art, snr, sum(summa) ARTTOT from rmdagsumwithnames_mg ';
    $sql = $sql . " where P = '" . $season . "'";
    $sql = $sql . ' and YEAR(DATUM) = "' . $year . '"';
    $sql = $sql . " and ART IN (" . $taxaListAsString . ")";
    $sql = $sql . " group by snr";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getActiveSeasonsThisDate($pdo, $ymdString, $language){

    $dateTime = new DateTime($ymdString);
    $month = $dateTime->format('m');
    $day = $dateTime->format('d');
    $testDate = '"' . '1000-' . $month . '-' . $day . '"';

    $sql = 'select * from v2v_rm_std_lokaler where ' . $testDate .   ' BETWEEN STARTDUMMYDATE AND ENDDUMMYDATE and LANGUAGE_ID = ' . $language;

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTotalsForSeasonAndYearsUntilDate($pdo, $season, $theDate){

    $season = '"' . $season . '"';
    $theYear =  substr($theDate, 0, 4);
    $theYear = '"' . $theYear . '"';
    $theDate = '"' . $theDate . '"';
    $sql = 'select rmdagsumwithnames_mg.*, sum(summa) AS ARTTOT from rmdagsumwithnames_mg where P =' . $season .' and year(datum) =' . $theYear . ' and datum < ' . $theDate . ' group by ART';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getTotalsForSeasonAllTime($pdo, $season){

    $season = '"' . $season . '"';

    $sql = 'select rmdagsumwithnames_mg.*, sum(summa) AS ARTTOT from rmdagsumwithnames_mg where P =' . $season . ' group by ART';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getVader($connection, $datum){

    $sql="SELECT * from dagb_vader WHERE datum='$datum'";
    //$query_vader=mysqli_query($connection, $sql);

    return getDataAsArray($connection, $sql);;
}

function getNextEntry($connection, $date){

    $nextEntry = "";
    //närmast följande, ofta i morgon
    $sql="SELECT MIN(dagbdatum) AS NEXT 
        FROM dagboksblad
        WHERE dagbdatum>'$date' 
        ORDER BY dagbdatum";
    $query=mysqli_query($connection, $sql) or die(mysqli_error($connection));
    $nextEntry = "";
    if ($row=mysqli_fetch_assoc($query)){
        $nextEntry = $row['NEXT'];
    }

    return $nextEntry;

}

function getMostRecentEntry($connection){

    $previousEntry = "";
    $sql="SELECT MAX(dagbdatum) AS MOST_RECENT 
          FROM dagboksblad
          ORDER BY dagbdatum";
    $query=mysqli_query($connection, $sql) or die(mysqli_error($connection));
    $previousEntry = "";
    if ($row=mysqli_fetch_assoc($query)){
        $previousEntry = $row['MOST_RECENT'];
    }

    return $previousEntry;
}

function getPreviousEntry($connection, $date){

    $previousEntry = "";
    $sql="SELECT MAX(dagbdatum) AS PREV 
          FROM dagboksblad
          WHERE dagbdatum<'$date'
          ORDER BY dagbdatum";
    $query=mysqli_query($connection, $sql) or die(mysqli_error($connection));
    $previousEntry = "";
    if ($row=mysqli_fetch_assoc($query)){
        $previousEntry = $row['PREV'];
    }

    return $previousEntry;
}

function getRingingDataforLocationAndDay($connection, $location, $day, $language){

    $sql = "select snr, svnamn as name, ";
    if ($language == 'en'){
        $sql = "select snr, ENGNAMN as name, ";
    }

    $sql = $sql . "summa from alldagsumwithnames where p='$location' and datum='$day' order by snr";

    return getDataAsArray($connection, $sql);

}

function getNabbenAntalArterDag($connection, $dag){

    $summa = 0;

    if (ongoingYear($dag)){
        $sql='SELECT count(distinct art) ANTAL FROM `strtemp` ';
    } else {
        $sql='SELECT count(distinct art) ANTAL FROM `sddagsum` ';
    }
    $sql = $sql . "where datum = '" . $dag ."'";

    $data = getDataAsArray($connection, $sql);
    $summa = $data[0]['ANTAL'];

    // tabellen innehåller summa rader - tag därför bort en från dagssumman.
    return formatNo($summa-1);

}

function weekDone($connection, $dateAsString){

    $t = strtotime($dateAsString);
    $vecka = date('W', $t);
    $year = substr($dateAsString, 0, 4);
    $sql='SELECT * FROM rrveckor where YEAR = ' . $year . ' AND VE =' . $vecka ;
    $query=mysqli_query($connection, $sql) or die (mysqli_error($connection));
    return (mysqli_num_rows($query) > 0);

}

function getNabbenDagsSumma($connection, $dag){

    if (ongoingYear($dag)){
        $sql='SELECT SUMMA FROM `strtemp` ';
    } else {
        $sql='SELECT SUMMA FROM `sddagsum` ';
    }
    $sql = $sql . "WHERE snr = '996' and datum = '" . $dag ."'";

    $data = getDataAsArray($connection, $sql);
    $summa = $data[0]['SUMMA'];

    return formatNo($summa);
}

?>