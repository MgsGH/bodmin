<?php

function loadChartDataAndStoreInSession($pdo, $selectedArt){

    // ------------------------------ fyren vår --------------------------
    $season = 'FA';
    $data = getSeasonSpeciesTotals($pdo, $season, $selectedArt);



    $fa_antal = array();
    $fa_ar = array();

    foreach ($data as $aYear) {
        array_push($fa_antal, $aYear['ANTAL']);
        array_push($fa_ar, $aYear['YEAR']);
    }

    $fiveYearAverageYears = getPrunedTimeSeries($fa_ar);
    $fiveYearAverage = getRollingFiveAverage($fa_antal);

    $antalFemString = implode(',', $fiveYearAverage);
    $arFemString = implode(',', $fiveYearAverageYears);
    $antalString = implode(',', $fa_antal);
    $arString = implode(',', $fa_ar);

    $_SESSION['fa-ar'] = $arString;
    $_SESSION['fa-antal'] = $antalString;
    $_SESSION['fa-ar-fem'] = $arFemString;
    $_SESSION['fa-antal-fem'] = $antalFemString;

    // ------------------------------ fyren höst --------------------------
    $season = 'FB';
    $data = getSeasonSpeciesTotals($pdo, $season, $selectedArt);
    $fb_antal = array();
    $fb_ar = array();

    foreach ($data as $aYear) {
        array_push($fb_antal, $aYear['ANTAL']);
        array_push($fb_ar, $aYear['YEAR']);
    }

    $fiveYearAverageYears = getPrunedTimeSeries($fb_ar);
    $fiveYearAverage = getRollingFiveAverage($fb_antal);

    $antalFemString = implode(',', $fiveYearAverage);
    $arFemString = implode(',', $fiveYearAverageYears);
    $antalString = implode(',', $fb_antal);
    $arString = implode(',', $fb_ar);

    $_SESSION['fb-antal'] = $antalString;
    $_SESSION['fb-ar'] = $arString;
    $_SESSION['fb-ar-fem'] = $arFemString;
    $_SESSION['fb-antal-fem'] = $antalFemString;

    // ------------------------------ flommen --------------------------
    $season = 'FC';
    $data = getSeasonSpeciesTotals($pdo, $season, $selectedArt);
    $fc_antal = array();
    $fc_ar = array();

    foreach ($data as $aYear) {
        array_push($fc_antal, $aYear['ANTAL']);
        array_push($fc_ar, $aYear['YEAR']);
    }

    $fiveYearAverageYears = getPrunedTimeSeries($fc_ar);
    $fiveYearAverage = getRollingFiveAverage($fc_antal);

    $antalFemString = implode(',', $fiveYearAverage);
    $arFemString = implode(',', $fiveYearAverageYears);
    $antalString = implode(',', $fc_antal);
    $arString = implode(',', $fc_ar);

    $_SESSION['fc-antal'] = $antalString;
    $_SESSION['fc-ar'] = $arString;
    $_SESSION['fc-ar-fem'] = $arFemString;
    $_SESSION['fc-antal-fem'] = $antalFemString;

}


function writeRingingTablesSection($pdo, $places, $date, $texts, $language){

    echo '<div class="gallery-container">';
    foreach ($places as $place){

        $ringingData = getRingingDataFor($pdo, $place['p'], $date, $language);
        echo '<div class="ringing-table">';

        if ($place['RM_TYPES_ID'] == 2) {
            writeStandardRingingTableAsHTML($ringingData, $texts, $pdo, $place['p'], $language);
        }

        if ($place['RM_TYPES_ID'] == 3) {
            writeOvrigRingingTableAsHTML($ringingData, $texts, $pdo, $place['p'], $language);
        }

        echo '</div>';
    }
    echo '</div>';

}


function getSelectedForMonitoringText($metaData, $texts){

    echo('<br/>');

    $returnText = $texts->getTxt('not-selected');
    if ($metaData[0]['VAL'] == 'X'){
        $returnText = '<strong>' . $texts->getTxt('selected') . '</strong>';
    }

    return $returnText;
}


function writeOvrigRingingTableAsHTML($data, $texts, $pdo, $place, $language){

    $textData = getPlaceAndTypeOfRinging($pdo, $place, $language);
    echo '<h5>' . $textData[0]['PLACE'] . ' ' . $textData[0]['TYPE']  . '</h5>';
    ?>
    <div class="ringing-table">
        <table class="table table-striped table-sm">
            <tr>
                <th>
                   <?= $texts->getTxt('tbl-hdr-art'); ?>
                </th>
                <th>
                   <?= $texts->getTxt('tbl-hdr-dsum'); ?>
                </th>
                <th>
                   <?= $texts->getTxt('detta-ar'); ?>
                </th>
            </tr>

            <?php foreach ($data as $species): ?>

                <tr>
                    <td class="art">
                        <?= $species['ART'] ?>
                    </td>
                    <td class="no-f">
                        <?= formatNo($species['SUMMA']) ?>
                    </td>
                    <td class="center">
                        <?= formatNo($species['SUBTOT']) ?>

                    </td>
                </tr>
            <?php endforeach ?>

        </table>
    </div>

<?php

}


function writeStandardRingingTableAsHTML($data, $texts, $pdo, $place, $language){

    $textData = getPlaceAndTypeOfRinging($pdo, $place, $language);
    echo '<h5>' . $textData[0]['PLACE'] . ' ' . $textData[0]['TYPE']  . '</h5>';
    $summaDag = 0;
    $summaTot = 0;
    $summaTotMedel = 0;

    ?>

    <table class="table table-striped table-sm table-hover">
        <thead class="thead-light">
        <tr>
            <th rowspan="2" class="align-middle text-center">
               <?= $texts->getTxt('tbl-hdr-art'); ?>
            </th>
            <th rowspan="2" class="align-middle text-center">
               <?= $texts->getTxt('tbl-hdr-dsum'); ?>
            </th>
            <th colspan="2" class="text-center">
               <?= $texts->getTxt('tbl-hdr-tom-idag'); ?>
            </th>
        </tr>
        <tr>
            <th class="text-center">
               <?= $texts->getTxt('tbl-hdr-ssum'); ?>
            </th>
            <th class="text-center">
               <?= $texts->getTxt('tbl-hdr-smv'); ?>
            </th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($data as $species): ?>

            <tr>
                <td class="art">
                    <?= $species['ART'] ?>
                </td>
                <td class="no-f">
                    <?php echo formatNo($species['SUMMA']);
                      $summaDag = $summaDag + $species['SUMMA'];
                    ?>
                </td>
                <td class="no-f">
                    <?php
                    echo formatNo($species['SUBTOT']);
                    $summaTot = $summaTot + $species['SUBTOT'];
                    ?>
                </td>
                <td class="no-f">
                    <?php
                    echo formatNo($species['medelv']);
                    $summaTotMedel = $summaTotMedel + $species['medelv'];
                    ?>
                </td>
            </tr>
        <?php endforeach ?>
        <tr class="summa">
            <td class="summa">
               <?= $texts->getTxt('sum'); ?>
            </td>

            <td class="no-f summa">
                <?= formatNo($summaDag) ?>
            </td>

            <td class="no-f summa">
                <?= formatNo($summaTot) ?>
            </td>

            <td class="no-f summa">
                <?= formatNo($summaTotMedel) ?>
            </td>

        </tr>
        </tbody>
    </table>

<?php

}


function writeYearTable($pdo, $year, $texts, $language){

    if ($year < 1980){
        writeOldYearTable($pdo, $year, $texts, $language);
    } else {
        writePost79Table($pdo, $language, $texts, $year);
    }

}


function writeOldYearTable($pdo, $year, $texts, $language){

    $data = getPre80YearTotals($pdo, $year, $language);

    ?>
    <br/>
    <div class="ringing-table">
        <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th width="100px"> <?php echo $texts->getTxt('ar-header-art') ?></th>
                <th width="50px"><?php echo $texts->getTxt('ar-header-summa') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $species): ?>

                <?php
                $tableRowStart = '<tr>';
                $tableCellStart = '<td>';
                $tableCellNameStart = '<td>';
                if ($species['snr'] == 996){
                    $tableRowStart = '<tr class="summa">';
                    $tableCellStart = '<td class="summa">';
                    $tableCellNameStart = '<td class="summa">';
                }
                echo $tableRowStart;
                ?>
                    <?php echo $tableCellNameStart . $species['NAMN'] ?></td>
                    <?php echo $tableCellStart . formatNo($species['summa']) ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <p class="artsummary">
            <?php echo sizeof($data)-1 . $texts->getTxt('season-summary') ?>
        </p>
    </div>
    <?php
}


function writeSasongTable($pdo, $lokal, $language, $texts, $year){

    $monthsTexts = getMonthTexts($language);
    $ringingMonths = getRingingMonthsForLocationAndYear($pdo, $lokal, $year);

    $tableDataAsArray = getSeasonAndYearData($pdo, $ringingMonths, $lokal, $year, $monthsTexts, $language );
    $standardizedData = (($lokal == 'FB') || ($lokal == 'FA') || ($lokal == 'FC') );

    echo '<div id="sasongTable">';
    echo '<table class="table table-sm table-striped table-hover w-auto">';
    // header
    echo '<tr>';
    echo '<th>';
    echo  $texts->getTxt('tbl-hdr-art');
    echo '</th>';
    foreach ($ringingMonths as $ringingMonth){
        echo '<th class="text-center">' . $monthsTexts[$ringingMonth["MM"]] .'</th>';
    }
    echo '<th class="text-center">' . $texts->getTxt('sum') .'</th>';
    if ($standardizedData){
        echo '<th class="text-center">I100</th>';
    }

    echo '</tr>';

    foreach ($tableDataAsArray as $species){

        $linkStart = '<a href="../ringmarkning/art-ar-sasong.php';
        $parameters = '?art=' . $species["ART"] . '&year=' . $year . '&sason=' . $lokal;
        if ($language == 'en'){
            $parameters = $parameters . '&lang=en';
        }
        $linkEnd = '</a>';
        $link = $linkStart . $parameters . '">' . $species["NAMN"] . $linkEnd;

        $rowStart = '<tr>';
        $cellStart = '<td class="no-s">';
        $cellNameStart = '<td>';
        $cellTotStart = '<td class="fet-stil no-s">';
        if ($species['SNR'] == 996 ){
            $rowStart = '<tr class="summa">';
            $cellStart = '<td class="no-s summa">';
            $cellNameStart = '<td class="summa">';
            $cellTotStart = '<td class="fet-stil no-s summa">';
            $link = $species["NAMN"];
        }
        echo ($rowStart);

        echo $cellNameStart . $link .'</td>';

        foreach ($ringingMonths as $ringingMonth){
            $manad = $monthsTexts[$ringingMonth["MM"]];
            echo $cellStart . formatNo($species[$manad]) .'</td>';
        }

        echo $cellTotStart . formatNo($species["TOT"]) .'</td>';
        if ($standardizedData){
            $ai100 = getLongTermAverageForSpeciesAndLocation($pdo, $lokal, $species["SNR"]);
            $i100 = $ai100[0]["MVT"];
            echo $cellStart . formatNo($i100) . '</td>';
        }

    }

    echo '</table>';
    echo '<p class="artsummary">';
    echo sizeof($tableDataAsArray)-1 . $texts->getTxt('season-summary') ;
    echo '</p>';
    echo '</div>';

}


function writePost79Table($pdo, $language, $texts, $year){

    $tableDataAsArray = getPost79YearData($pdo, $year, $language );

    ?>

    <div>
        <table class="table table-sm table-striped">
            <thead class="thead-light">
            <tr>
                <th rowspan="2">
                    <?php echo $texts->getTxt('ar-art'); ?>
                </th>
                <th colspan="3" class="text-center">
                    <?php echo $texts->getTxt('ar-standard'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-ovrigt'); ?>
                </th>
                <th rowspan="2">
                    <?php echo $texts->getTxt('ar-tot'); ?>
                </th>
            </tr>

            <tr>
                <th>
                    <?php echo $texts->getTxt('ar-fyren-var'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-fyren-host'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-flommen'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-flygg'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-pull'); ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($tableDataAsArray as $species){

                $rowStart = '<tr>';
                $cellStart = '<td class="no-s">';
                $cellNameStart = '<td>';
                if ($species['SNR'] == 996 ){
                    $rowStart = '<tr class="summa">';
                    $cellStart = '<td class="no-s summa">';
                    $cellNameStart = '<td class="summa">';
                }
                echo ($rowStart);
                echo $cellNameStart . $species["NAMN"] .'</td>';
                echo $cellStart . formatNo($species["FA"]) .'</td>';
                echo $cellStart . formatNo($species["FB"]) .'</td>';
                echo $cellStart . formatNo($species["FC"]) .'</td>';
                echo $cellStart . formatNo($species["ÖV"]) .'</td>';
                echo $cellStart . formatNo($species["PU"]) .'</td>';
                echo $cellStart . formatNo($species["TOT"]) .'</td>';

            }


?>

        <?php echo '</tbody></table>' ?>
        <p class="artsummary">
            <?php echo sizeof($tableDataAsArray)-1 . $texts->getTxt('season-summary') ?>
        </p>
    </div>

<?php

}


function writePost79AllYearsTable($pdo, $language, $texts){

    $tableDataAsArray = getPost79TotalData($pdo, $language );

    ?>

    <div>
        <table class="table table-sm table-striped hover">
        <thead class="thead-light">
            <tr>
                <th rowspan="2">
                    <?php echo $texts->getTxt('ar-art'); ?>
                </th>
                <th colspan="3" class="text-center">
                    <?php echo $texts->getTxt('ar-standard'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-ovrigt'); ?>
                </th>
                <th rowspan="2">
                    <?php echo $texts->getTxt('ar-tot'); ?>
                </th>
            </tr>

            <tr>
                <th>
                    <?php echo $texts->getTxt('ar-fyren-var'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-fyren-host'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-flommen'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-flygg'); ?>
                </th>
                <th>
                    <?php echo $texts->getTxt('ar-pull'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($tableDataAsArray as $species){

                $rowStart = '<tr>';
                $cellNoStart = '<td class="no-f">';
                $cellNameStart = '<td>';
                $artNamnLink = getEnArtAllaArLink($species["ART"], $species["NAMN"], $language);
                if ($species['SNR'] == 996 ){
                    $artNamnLink = $species["NAMN"]; // no link if it is the sum
                    $rowStart = '<tr class="summa">';
                    $cellNoStart = '<td class="no-f summa">';
                    $cellNameStart = '<td class="summa">';
                }
                echo ($rowStart);
                echo $cellNameStart . $artNamnLink .'</td>';
                echo $cellNoStart . formatNo($species["FA"]) .'</td>';
                echo $cellNoStart . formatNo($species["FB"]) .'</td>';
                echo $cellNoStart . formatNo($species["FC"]) .'</td>';
                echo $cellNoStart . formatNo($species["ÖV"]) .'</td>';
                echo $cellNoStart . formatNo($species["PU"]) .'</td>';
                echo $cellNoStart . formatNo($species["TOT"]) .'</td>';

            }


?>

        <?php echo '</tbody></table>' ?>
        <p class="artsummary">
            <?php echo sizeof($tableDataAsArray)-1 . $texts->getTxt('season-summary') ?>
        </p>


    </div>

<?php

}


function getEnArtAllaArLink($artKod, $artNamn, $language){

    $link =  '<a href="' . '../ringmarkning/art-alla-ar.php?art=' . $artKod . '&lang=' . $language . '">' . $artNamn . '</a>';

    return $link;

}


function writeOneSpeciesStandardYearsTable($tableDataAsArray, $summor, $texts, $selectedArt, $language){

    ?>

    <div>
        <table class="table table-sm table-striped w-auto">
            <thead class="thead-light">
            <tr>
                <th rowspan="2" class="text-center">
                    <?php echo $texts->getTxt('art-alla-ar-ar'); ?>
                </th>
                <th colspan="3" class="text-center">
                    <?php echo $texts->getTxt('ar-standard'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-ovrigt'); ?>
                </th>
                <th rowspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-tot'); ?>
                </th>
            </tr>

            <tr>
                <th class="text-center">
                    <?php echo $texts->getTxt('ar-fyren-var'); ?>
                </th>
                <th class="text-center">
                    <?php echo $texts->getTxt('ar-fyren-host'); ?>
                </th>
                <th class="text-center">
                    <?php echo $texts->getTxt('ar-flommen'); ?>
                </th>
                <th class="text-center pl-4">
                    <?php echo $texts->getTxt('ar-flygg'); ?>
                </th>
                <th class="text-center">
                    <?php echo $texts->getTxt('ar-pull'); ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($tableDataAsArray as $species){

                $rowStart = '<tr>';
                echo ($rowStart);
                echo '<td class="text-center">' . $species["YEAR"] .'</td>';
                echo '<td class="no-s">' . getLink($selectedArt, $species["YEAR"], "FA", $language, formatNo($species["FA"])) . '</td>';
                echo '<td class="no-s">' . getLink($selectedArt, $species["YEAR"], "FB", $language, formatNo($species["FB"])) . '</td>';
                echo '<td class="no-s">' . getLink($selectedArt, $species["YEAR"], "FC", $language, formatNo($species["FC"])) . '</td>';
                echo '<td class="no-s pl-4">' . getLink($selectedArt, $species["YEAR"], "ÖV", $language, formatNo($species["ÖV"])) . '</td>';
                echo '<td class="no-s">' . getLink($selectedArt, $species["YEAR"], "PU", $language, formatNo($species["PU"])) . '</td>';
                echo '<td class="no-s">' . formatNo($species["TOT"]) .'</td>';
                echo '</tr>';

            }

            echo '<tr class="summa">';
            echo '<td class="summa">' . $texts->getTxt('summa') . '</td>';
            echo '<td class="no-s summa">' . formatNo($summor[0]) .'</td>';
            echo '<td class="no-s summa">' . formatNo($summor[1]) .'</td>';
            echo '<td class="no-s summa">' . formatNo($summor[2]) .'</td>';
            echo '<td class="no-s summa pl-4">' . formatNo($summor[3]) .'</td>';
            echo '<td class="no-s summa">' . formatNo($summor[4]) .'</td>';
            echo '<td class="no-s summa">' . formatNo($summor[5]) .'</td>';
            echo '</tr>';


?>
        <?php echo '</tbody></table>' ?>
    </div>

<?php

}


function getLink($selectedArt, $year, $season, $language, $data){

    // Make link only if data is present
    if ($data != '-') {
        $linkStart = '<a href="../ringmarkning/art-ar-sasong.php';
        $parameters = '?art=' . $selectedArt . '&year=' . $year . '&sasong=' . $season;
        if ($language == 'en'){
            $parameters = $parameters . '&lang=en';
        }
        $answer = $linkStart . $parameters . '">' . $data . '</a>';
    } else {
        $answer = $data;
    }

    return $answer;

}


function writeOneSpeciesOldYearsTable($v47to59, $v60to69, $v70to79, $texts){

    ?>

    <div class="d-flex">
        <div>
        <table class="table table-sm table-striped">

        <?php
        writeHeader('1979-70',  $texts->getTxt('sum'));
        foreach ($v70to79 as $year){
            echo ('<tr>');
            echo '<td>' . $year["year"] .'</td>';
            echo '<td class="no-s">' . formatNo($year["summa"]) .'</td>';
            echo '</tr>';
        }
        echo '</table>';

        ?>
        </div>
        <div class="mx-3">
        <table class="table table-sm table-striped">
        <?php
        writeHeader('1969-60',  $texts->getTxt('sum'));
        foreach ($v60to69 as $year){
            echo ('<tr>');
            echo '<td>' . $year["year"] .'</td>';
            echo '<td class="no-s">' . formatNo($year["summa"]) .'</td>';
            echo '</tr>';
        }
        echo '</table>';
         ?>
        </div>
        <div >
        <table class="table table-sm table-striped">
        <?php
        writeHeader('1959-47',  $texts->getTxt('sum'));
        foreach ($v47to59 as $year){
            echo ('<tr>');
            echo '<td>' . $year["year"] .'</td>';
            echo '<td class="no-s">' . formatNo($year["summa"]) .'</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        echo '</div>';

}


function writeHeader($textett, $texttva ){
    ?>
    <thead class="thead-light">
    <tr>
        <th><?php echo $textett ?></th>
        <th><?php echo $texttva ?></th>
    </tr>
    </thead>
    <?php
}


function getSummorFor($data){

    $result = array();
    $fa = 0;
    $fb = 0;
    $fc = 0;
    $ov = 0;
    $pu = 0;
    $tot = 0;
    foreach ($data as $species){

        $fa = $fa + $species["FA"];
        $fb = $fb + $species["FB"];
        $fc = $fc + $species["FC"];
        $ov = $ov + $species["ÖV"];
        $pu = $pu + $species["PU"];
        $tot = $tot + $species["TOT"];
    }

    array_push($result, $fa);
    array_push($result, $fb);
    array_push($result, $fc);
    array_push($result, $ov);
    array_push($result, $pu);
    array_push($result, $tot);

    return $result;

}


function getSummaFor($data){

    $result = 0;
    foreach ($data as $year){
        $result = $result + $year["summa"];
    }

    return $result;

}


function writeDagsTabell($pdo, $language, $texts, $art){

    $fa = getTioIToppDag($pdo, 'FA', $art);
    $fb = getTioIToppDag($pdo, 'FB', $art);
    $fc = getTioIToppDag($pdo, 'FC', $art);
    $ov = getTioIToppDag($pdo, 'ÖV', $art);
    $pu = getTioIToppDag($pdo, 'PU', $art);

    writeTioIToppTableHeader($texts);
    for ($i=0; $i<10; $i++){
        echo '<tr>';
        echo '<td class="center">';
        echo getDataElementOrDefaultValue($i, $fa, 'DATUM', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fa, 'SUMMA', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $fb, 'DATUM', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fb, 'SUMMA', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $fc, 'DATUM', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fc, 'SUMMA', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $ov, 'DATUM', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $ov, 'SUMMA', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $pu, 'DATUM', '-');
        echo '</td>';
        echo '<td class="no-s">';
        echo formatNo(getDataElementOrDefaultValue($i, $pu, 'SUMMA', 0));
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

}


function writeSeasonsTabell($pdo, $texts, $art){

    $fa = getTioIToppSeason($pdo, 'FA', $art);
    $fb = getTioIToppSeason($pdo, 'FB', $art);
    $fc = getTioIToppSeason($pdo, 'FC', $art);
    $ov = getTioIToppSeason($pdo, 'ÖV', $art);
    $pu = getTioIToppSeason($pdo, 'PU', $art);

    writeTioIToppTableHeader($texts);
    for ($i=0; $i<10; $i++){
        echo '<tr>';
        echo '<td class="center">';
        echo getDataElementOrDefaultValue($i, $fa, 'YEAR', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fa, 'NOOF', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $fb, 'YEAR', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fb, 'NOOF', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $fc, 'YEAR', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $fc, 'NOOF', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $ov, 'YEAR', '-');
        echo '</td>';
        echo '<td class="no-s border-right">';
        echo formatNo(getDataElementOrDefaultValue($i, $ov, 'NOOF', 0));
        echo '</td>';
        echo '<td class="center pl-4">';
        echo getDataElementOrDefaultValue($i, $pu, 'YEAR', '-');
        echo '</td>';
        echo '<td class="no-s">';
        echo formatNo(getDataElementOrDefaultValue($i, $pu, 'NOOF', 0));
        echo '</td>';
        echo '</tr>';
    }


    echo '</table>';

}


function writeTioIToppTableHeader($texts){
    ?>

        <table class="table table-striped table-sm table-hover w-auto table-cell-padding">
            <tr>
                <th colspan="6" class="text-center">
                    <?php echo $texts->getTxt('ar-standard'); ?>
                </th>
                <th colspan="4" class="text-center">
                    <?php echo $texts->getTxt('ar-ovrigt'); ?>
                </th>
            </tr>

            <tr>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-fyren-var'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-fyren-host'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-flommen'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-flygg'); ?>
                </th>
                <th colspan="2" class="text-center">
                    <?php echo $texts->getTxt('ar-pull'); ?>
                </th>
            </tr>


        <?php

}


function getDataElementOrDefaultValue($index, $theArray, $key, $defaultValue){

    if ( $index <= sizeof($theArray)-1){
        $thisRow = $theArray[$index];
        $returnValue = $thisRow[$key];
    } else {
        $returnValue = $defaultValue;
    }

    return $returnValue;
}


function writeYearSection($pdo, $texts, $selectedArt, $vinjettBildsHTML){


    $yearData = getTioIToppYear($pdo, $selectedArt);
    ?>

    <div class="d-flex">
        <div class="XXtest">
            <table class="table table-striped table-sm table-hover w-auto">
            <thead class="thead-light">
                <tr>
                    <th class="text-center"><?php echo $texts->getTxt('art-tio-i-topp-tot') ?></th>
                    <th class="text-center"><?php echo $texts->getTxt('art-tio-i-topp-tot') ?></th>
                </tr>
            </thead>
            <tbody>

            <?php for($i =0; $i < 10; $i++): ?>
                <tr>
                    <td class="centered"> <?php echo getDataElementOrDefaultValue($i, $yearData, 'YEAR', '-'); ?></td>
                    <td class="no-s"> <?php echo formatNo(getDataElementOrDefaultValue($i, $yearData, 'YEARTOT', '-'));  ?></td>
                </tr>
            <?php endfor ?>
            </tbody>
            </table>


        </div>

        <div class="intro-image">
            <?php echo $vinjettBildsHTML ?>
        </div>

    </div>

    <?php
}


function writeSummarySection($pdo, $texts, $selectedArt, $nyaTidenTot, $pre80tot, $vinjettBildsHTML){

    $ar = getCurrentYear() - 1;
    $tot = $pre80tot + $nyaTidenTot;

    ?>

    <div class="d-flex">
        <div>
            <table class="table table-sm table-striped w-auto">
                <thead class="thead-light">
                    <tr>
                        <th><?php echo $texts->getTxt('art-alla-ar-summary') ?></th>
                        <th class="pl-4 text-center"><?php echo $texts->getTxt('art-alla-ar-summary-tot') ?></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $ar ?>-1980</td>
                    <td class="no-s  pl-4"> <?php echo formatNo($nyaTidenTot) ?> </td>
                </tr>
                <tr>
                    <td>1979-1947</td>
                    <td class="no-s pl-4"><?php echo formatNo($pre80tot) ?></td>
                </tr>
                <tr class="summa">
                    <td class="summa"><?php echo $texts->getTxt('summa') ?></td>
                    <td class="no-s  pl-4 summa"><?php echo formatNo($tot) ?></td>
                </tr>
                <tbody>
            </table>

            <p><?php echo $texts->getTxt('art-alla-ar-intro-i') ?></p>
            <p><?php echo $texts->getTxt('art-alla-ar-intro-ii') ?></p>

        </div>
        <div class="intro-image">
            <div><?php echo $vinjettBildsHTML ?></div>
        </div>

    </div>

    <?php
}


function writeAllSpeciesAllYearsTable($pdo, $texts, $language){

    $data = getYearTotalsForAllSpeciesSinceStart($pdo, $language);

    ?>

            <table class="table table-sm table-striped w-auto">
                <theader>
                <tr>
                    <th><?php echo $texts->getTxt('species') ?></th>
                    <th class="text-center">1947-1979</th>
                    <th class="text-center">1980-<?php echo $texts->getTxt('alla-arter-alla-ar-idag') ?></th>
                    <th class="text-center"><?php echo $texts->getTxt('tot') ?></th>
                </tr>
                </theader>
                <?php foreach ($data as $species): ?>

                    <?php
                        $cellNumberStartTag = '<td class="no-s">';
                        $cellNameStartTag = '<td>';

                        $maybeLink = getLinkArtAllaAr($species['ART'], $species['NAMN'], $language);

                        if ($species['SNR'] === 996 ){
                            $maybeLink = $species['NAMN'];
                            $cellNumberStartTag = '<td class="no-s summa">';
                            $cellNameStartTag = '<td class="summa">';
                        }
                    ?>

                    <tr>
                        <?php echo $cellNameStartTag ?>
                            <?php echo $maybeLink ?>
                        </td>
                        <?php echo $cellNumberStartTag ?>
                            <?php echo formatNo($species['PRE80']); ?>
                        </td>
                        <?php echo $cellNumberStartTag ?>
                            <?php echo formatNo($species['POST79']); ?>
                        </td>
                        <?php echo $cellNumberStartTag ?>
                            <?php echo formatNo($species['POST79'] + $species['PRE80']); ?>
                        </td>
                    </tr>

                <?php endforeach ?>
            </table>

<?php

}


function getLinkArtAllaAr($kod, $namn, $language){

    $link = '<a href="../ringmarkning/art-alla-ar.php?art=' . $kod . '&lang=' . $language;

    return $link . '">' . $namn . '</a>';

}


function writePopTrendsTableIncresing($pdo, $language, $sortorder, $texts){

    $data = getRingingPopulationTrendDataIncreasing($pdo, $language, $sortorder);
    $size = sizeof($data);

    ?>

        <table class="table table-sm table-striped hover">
        <thead class="thead-dark">
        <tr><th colspan="3"><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th></tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieRingTrendLink($art['ART'],$art['NAMN'],$language) ?></td>
                <td<?php echo getCommentAsHTMLTitle($art['COMMENT']) ?>><?php echo $art['Rs'];  ?></td>
                <td<?php echo getCommentAsHTMLTitle($art['COMMENT']) ?>><?php echo $art['SIGN'];  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
        </table>

    <?php
}


function getCommentAsHTMLTitle($comment){

    $answer = "";
    if (($comment !== 'No comment.') && ($comment !== 'Kommentar saknas.')){
        $answer = ' title="' . $comment . ' " ';
    }

    return $answer;
}


function writePopTrendsTableStable($pdo, $language, $sortorder, $texts){

    $data = getRingingPopulationTrendsDataNonSignifant($pdo, $language, $sortorder);
    $size = sizeof($data);

    ?>

        <table class="table table-sm table-striped hover">
        <thead class="thead-dark">
        <tr><th><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th></tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieRingTrendLink($art['ART'],$art['NAMN'],$language) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
        </table>

    <?php
}


function writePopTrendsTableDecreasing($pdo, $language, $sortorder, $texts){

    $data = getRingingPopulationTrendsDataDecreasing($pdo, $language, $sortorder);
    $size = sizeof($data);

    ?>

        <table class="table table-sm table-striped hover">
        <thead class="thead-dark">
        <tr><th colspan="3"><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th></tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieRingTrendLink($art['ART'],$art['NAMN'],$language) ?></td>
                <td><?php echo $art['Rs'];  ?></td>
                <td><?php echo $art['SIGN'];  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
        </table>

    <?php
}


function writePopTrendsTableSeason($pdo, $language, $sortorder, $texts, $season){

    $data = getRingingMonitoringResultForSeason($pdo, $language, $season, $sortorder);
    $size = sizeof($data);

    ?>

        <table class="table table-sm table-striped hover">
        <thead>
        <tr><th colspan="3"><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th></tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieRingTrendLink($art['ART'],$art['NAMN'],$language) ?></td>
                <td><?php echo $art['Rs'];  ?></td>
                <td><?php echo $art['SIGN'];  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
        </table>

    <?php
}


function writeDaysInMonthAsTable($startDate, $texts, $ringingDailyTotals){

    $thisMonth = getMonthFromStringDateYmd($startDate);
    echo('<table class="table table-sm table-striped hover">');
    echo('<thead class="thead-light">');
    echo('<tr>');
    echo('<th colspan="2" class="text-center">');
    echo($texts->getTxt($thisMonth));
    echo('</th>');
    echo('</tr>');
    echo('</thead>');
    echo('<tbody>');
    $workingDate = $startDate;
    while ($thisMonth == getMonthFromStringDateYmd($workingDate)){
        echo('<tr>');
        echo('<td class="day-no pr-1">');
        echo (getDayFromStringDateYmd($workingDate));
        echo('</td>');
        echo('<td class="no-f pr-2">');
        echo (formatNo(getRingingDailyTotal($workingDate, $ringingDailyTotals)));
        echo('</td>');
        echo('</tr>');
        $workingDate = getOneDayMore($workingDate);
    }
    echo('</tbody>');
    echo('</table>');

}


function getRingingDailyTotal($date, $ringingDailyTotals){

    // 2017-10-31

    $returnValue = '0';
    for ($i=0; $i<sizeof($ringingDailyTotals); $i++){

        if ($ringingDailyTotals[$i]['datum'] == $date){
            $returnValue = $ringingDailyTotals[$i]['summa'];
            break;
        }

    }

    return  $returnValue;
}


function writeLocationInfoSection($data, $metaData, $texts, $season){

    if ($metaData === null){
        echo ($texts->getTxt('visas-inte-i'));
        echo ('<br/>');
        echo ($texts->getTxt('visas-inte-ii'));
        echo ('<br/>');
        echo ('<br/>');
    } else {
        echo getSelectedForMonitoringText($metaData, $texts);
        echo '<div class="d-flex">';
        echo '<div class="std"><img src="chart-new.php?season=' . $season . '"></div>';
        echo '<div class="std"><br/><br/>';
        writeTenYearAverageTable($data, $texts);
        echo '</div>';
        echo( '</div>' );
        echo( '<div class="mt-2 mb-5">' );
                writeMetaDataInfo($metaData, $texts);
        echo( '</div>' );
        echo ('<br/>');
    }

}


function getRingingDate($pdo){

    $yearOK = (isset($_REQUEST['year'])) && (!empty($_REQUEST['year']));
    $monthOK = (isset($_REQUEST['month'])) && (!empty($_REQUEST['month']));
    $dayOK = (isset($_REQUEST['dag'])) && (!empty($_REQUEST['dag']));

    if (($yearOK) && ($monthOK) && ($dayOK)) {
        $selectedRingingDate = getDayAsYmdString($_REQUEST['year'], $_REQUEST['month'], $_REQUEST['dag']);
    } else {
        $aDate = getMostRecentRingingDate($pdo);
        $selectedRingingDate = $aDate[0]['MAXDATUM'];
    }

    return $selectedRingingDate;


}


function getCommaSeparatedListOfLastSevenDays($startDate){


    $result = "";
    $date = DateTime::createFromFormat('Y-m-d', $startDate);

    for ($i=1; $i<8; $i++){
        $modifier = '-1' . ' day';
        $date->modify($modifier);
        $result = $result . $date->format('Y-m-d') . ", ";
    }

    return substr($result, 0, strlen($result)-2);

}


function buildTaxaString($dataSet){

     $str = "";

     for ($i=count($dataSet)-1; $i > -1 ; $i--){
        $str = $str . "'" . $dataSet[$i]['ART'] . "'" . ',';
     }

     return substr($str, 0,strlen($str)-1);
}


function updateSevenDaysDataWithSeasonTotal($sevenDaysData, $aSeasonTotals){

    for ($i=0; $i<count($sevenDaysData); $i++){

        for ($ii=0; $ii<count($aSeasonTotals); $ii++){

            if ($sevenDaysData[$i]["SNR"] === $aSeasonTotals[$ii]['SNR']){
                $sevenDaysData[$i]['STOT'] = $aSeasonTotals[$ii]['ARTTOT'];
                break;
            }

        }

    }

    return $sevenDaysData;

}


function updateSevenDaysDataWithSoFarSeasonAverages($sevenDaysData, $soFarSeasonTotals, $noOfSeasons){

    for ($i=0; $i<count($sevenDaysData); $i++){

        for ($ii=0; $ii<count($soFarSeasonTotals); $ii++){

            if ($sevenDaysData[$i]["SNR"] === $soFarSeasonTotals[$ii]['SNR']){
                //$sevenDaysData[$i]['SMV'] = round($soFarSeasonTotals[$ii]['ARTTOT'] / $noOfSeasons);
                $sevenDaysData[$i]['SMV'] = round($soFarSeasonTotals[$ii]['ARTTOT']);
                break;
            }

        }
    }

    return $sevenDaysData;

}


function updateSevenDaysDataWithAllSeasonAverages($sevenDaysData, $allTimeSeasonTotals, $noOfSeasons){

    for ($i=0; $i<count($sevenDaysData); $i++){

        for ($ii=0; $ii<count($allTimeSeasonTotals); $ii++){

            if ($sevenDaysData[$i]["SNR"] === $allTimeSeasonTotals[$ii]['SNR']){
                $sevenDaysData[$i]['I100'] = round($allTimeSeasonTotals[$ii]['ARTTOT'] / $noOfSeasons);
                break;
            }

        }
    }

    return $sevenDaysData;

}


function checkIfDateExists($aToBeChecked, $ymdDate){

    $found = false;
    for ($i = 0; $i < count($aToBeChecked); $i++){

        if ($aToBeChecked[$i]["THEDATE"] == $ymdDate){

            $found = true;
            break;
        }

    }

    return $found;

}

function writeSeasonSpeciesTotalsTable($connection, $season, $art, $texts){

    $data = getSeasonSpeciesTotals($connection, $season, $art )

    ?>

        <table class="table table-striped">
        <tr><th colspan="2"><?php echo $texts->getTxt('ssums') ?></th></tr>
        <?php foreach($data as $seasonYear): ?>
            <tr>
                <td> <?php echo $seasonYear['YEAR'] ?></td>
                <td class="no-s"> <?php echo formatNo($seasonYear['ANTAL']);  ?></td>
            </tr>
        <?php endforeach ?>
        </table>


    <?php
}
