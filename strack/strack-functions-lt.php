<?php



function loadChartDataAndStoreInSession($pdo, $selectedArt){

    // ------------------------------ nabben --------------------------
    $data = getNabbenYearTotals($pdo,  $selectedArt);
    $nabben_antal = array();
    $nabben_ar = array();
    foreach ($data as $aYear) {
        array_push($nabben_antal, $aYear['ANTAL']);
        array_push($nabben_ar, $aYear['YEAR']);
    }

    $fiveYearAverageYears = getPrunedTimeSeries($nabben_ar);
    $fiveYearAverage = getRollingFiveAverage($nabben_antal);

    $antalString = implode(',', $nabben_antal);
    $arString = implode(',', $nabben_ar);
    $fiveYearAverageAsString = implode(',', $fiveYearAverage);
    $fiveYearAverageYearsString = implode(',', $fiveYearAverageYears);

    $_SESSION['nabben-ar'] = $arString;
    $_SESSION['nabben-antal'] = $antalString;
    $_SESSION['nabben-antal-five'] = $fiveYearAverageAsString;
    $_SESSION['nabben-ar-five'] = $fiveYearAverageYearsString;

}


function writeStrackPopTrendsTableIncreasing($pdo, $language, $sortorder, $texts){

    $data = getStrackPopulationTrendsDataIncreasing($pdo, $language, $sortorder);
    $size = sizeof($data);

    ?>

    <table class="table table-sm table-striped">
        <thead class="thead-light">
            <tr>
                <th colspan="3"><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieStrackTrendLink($art['ART'], $art['NAMN'], $language) ?></td>
                <td><?php echo $art['Rs'];  ?></td>
                <td><?php echo $art['SIGN'];  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>


    <?php
}


function writeStrackPopTrendsTableDecreasing($connection, $language, $sortorder, $texts){

    $data = getStrackPopulationTrendsDataDecreasing($connection, $language, $sortorder);
    $size = sizeof($data);

    ?>

    <table class="table table-sm table-striped">
        <thead class="thead-light">
        <tr>
            <th colspan="3"><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieStrackTrendLink($art['ART'], $art['NAMN'], $language) ?></td>
                <td><?php echo $art['Rs'];  ?></td>
                <td><?php echo $art['SIGN'];  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <?php
}


function writeStrackPopTrendsTableNonSignificant($connection, $language, $sortorder, $texts){

    $data = getStrackPopulationTrendsDataNonSignifant($connection, $language, $sortorder);
    $size = sizeof($data);
    ?>

    <table class="table table-sm table-striped">
        <thead class="thead-light">
            <tr>
                <th><?php echo $size . ' ' . $texts->getTxt('mo-species') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $art): ?>
            <tr>
                <td><?php echo getSpecieStrackTrendLink($art['ART'], $art['NAMN'], $language) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>


    <?php
}


function getTheMostRecentMigrationMonitoringDateOrSelected($pdo){

    $data = getMostRecentMigrationMonitoringDateData($pdo);
    $date = $data[0]["MAXDATUM"];

    var_dump($date);

    return getRequestValueWithDefault('date', $data[0]["MAXDATUM"]);

}


function getSimplifiedDateDataAsPlainArray($connection, $year, $month){

    $eventData = getStrackRakningsDagar($connection, $year, $month);
    $aSimpleArray = array();

    for ($i = 0; $i < count($eventData); $i ++ ){
        array_push($aSimpleArray, $eventData[$i]['THEDATE']);
    }

    return $aSimpleArray;

}


function writeDayTable($data, $texts){

    $dagsum = 0;
    $dennaSasong = 0;
    $allaSasonger = 0;
    ?>
    <table class="table table-striped table-sm table-hover w-auto">
        <thead class="thead-light">
        <tr>
            <th rowspan="2"><?= $texts->getTxt('Art') ?></th>
            <th rowspan="2"><?= $texts->getTxt('Dagssumma') ?></th>
            <th colspan="2" class="text-center"><?= $texts->getTxt('till-idag') ?></th>
        </tr>
        <tr>
            <th class="text-center"><?= $texts->getTxt('Denna-sasong') ?></th>
            <th class="text-center"><?= $texts->getTxt('Medel-alla-ar') ?></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach( $data as $art ): ?>
            <tr>
                <td><?= $art['TAXON'] ?></td>
                <td class="no-s"><?= formatNo($art['SUMMA']) ?></td>
                <?php $dagsum = $dagsum + intval($art['SUMMA']) ?>
                <td class="no-s"><?= formatNo($art['ANTAL']) ?></td>
                <?php $dennaSasong = $dennaSasong + intval($art['ANTAL']) ?>
                <td class="no-s"><?= formatNo($art['medelv']) ?></td>
                <?php $allaSasonger = $allaSasonger + intval($art['medelv']) ?>
            </tr>
        <?php endforeach ?>
        <tr>
            <td class="summa"><?php echo $texts->getTxt('Summa') ?></td>
            <td class="no-s summa"><?php echo formatNo($dagsum) ?></td>
            <td class="no-s summa"><?php echo formatNo($dennaSasong) ?></td>
            <td class="no-s summa"><?php echo formatNo($allaSasonger) ?></td>
        </tr>
        </tbody>

    </table>

<?php

}


function writeDataTables($texts, $dagSummor, $arSummor){
?>

<div class="gallery-container">

    <div class="tio-i-topp-table">

        <h3><?php echo $texts->getTxt('strack-10-dagsumme-header') ?></h3>

        <table class="table table-striped table-sm">
            <thead class="thead-light">
            <tr>
                <th class="text-center"><?php echo $texts->getTxt('strack-10-datum') ?></th>
                <th class="text-center"><?php echo $texts->getTxt('strack-10-antal') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dagSummor as $dagSumma): ?>
                <tr>
                    <td class="date120"><?php echo (getDagBoksLink($dagSumma['DATUM'])) ?></td>
                    <td class="no-s"><?php echo (formatNo($dagSumma['SUMMA'])) ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>
    <div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>

    <div class="tio-i-topp-table">

        <h3><?php echo $texts->getTxt('strack-10-season-header') ?></h3>
        <table class="table table-striped table-sm">
            <thead class="thead-light">
                <tr>
                    <th class="text-center"><?php echo $texts->getTxt('strack-10-ar') ?></th>
                    <th class="text-center"><?php echo $texts->getTxt('strack-10-antal') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($arSummor as $arSum): ?>
                <tr>
                    <td class="date"><?php echo (getYearLink($arSum['AR'])) ?></td>
                    <td class="no-s"><?php echo (formatNo($arSum['ARSUMMA'])) ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>

</div>

<?php
}

function writeArtToppTable($texts, $dagar, $artnamn){
    ?>

    <div>
        <h3><?php echo $texts->getTxt('header-over-table') ?></h3>
        <div class="mt-2">

            <table class="table table-striped table-sm">
                <thead class="thead-light">
                <tr>
                    <th class="text-center"><?php echo $texts->getTxt('table-header-md') ?></th>
                    <th class="text-center"><?php echo $texts->getTxt('table-header-antal-i') . ' ' . strtolower($artnamn) . ' ' . $texts->getTxt('table-header-antal-ii') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dagar as $dag): ?>
                    <tr>
                        <td class="date120"><?php echo ($dag['MD']) ?></td>
                        <td class="text-center"><?php echo (formatNo($dag['ANTAL'])) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

        </div>

    </div>

    <?php
}




function writeStrackYearTable($texts, $data, $averageData){
    ?>

    <table class="table table-striped table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th><?php echo $texts->getTxt('Art') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('augusti') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('september') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('oktober') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('november') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('Summa') ?></th>
            <th class="text-center"><?php echo $texts->getTxt('alla-ar-medel') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $aSpecies): ?>

            <?php
            $artClass = '';
            $tdClass = 'no-s';
            if ($aSpecies['SNR'] == 996){
                $artClass = 'summa';
                $tdClass = 'no-s summa';
            }
            ?>
            <tr>
                <td class="<?php echo $artClass ?>"><?php echo ($aSpecies['NAMN']) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['AUG'])) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['SEP'])) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['OCT'])) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['NOV'])) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['TOT'])) ?></td>
                <td class="<?php echo $tdClass ?>"><?php echo (formatNo($aSpecies['MV'])) ?></td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>


<?php
}


function writeYearsTableForSpecies($texts, $data){

    $tableRows = 25;
    $ar = getCurrentYear() - 1;
    $antalAr = $ar - 1972;
    $numberOfTables = ceil($antalAr / $tableRows);
    $startYearForTableRows = $ar;
    ?>
    <br/>
    <br/>
    <div class="d-flex">

    <?php for ($i = 0; $i<$numberOfTables; $i++): ?>

        <div class="std tio-i-topp-table">
            <table class="table table-striped table-sm table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center"> <?php echo $texts->getTxt('ar') ?> </th>
                        <th class="text-center"> <?php echo $texts->getTxt('Summa') ?> </th>
                    </tr>
                </thead>
                <?php writeTableRows($data, $startYearForTableRows); ?>
                <?php $startYearForTableRows = $startYearForTableRows - 25; ?>
            </table>
        </div>

    <?php endfor; ?>

   </div>

    <?php

}


function writeTableRows($data, $startYearForTableRows){

    $i = 0;
    $done = false;
    while (($i<25) && (!$done)){
        $thisYear = $startYearForTableRows - $i;
        echo ('<tr>');
        echo ('<td class="year">');
        echo ( getYearLink($thisYear));
        echo ('</td>');
        echo ('<td class="no-s">');
        echo (formatNo(getStrackYearTotal($thisYear, $data)));
        echo ('</td>');
        echo ('</tr>');
        $i++;
        $done = ($thisYear == 1973);
    }

}


function writeStrackSummarySection($pdo, $texts, $selectedArt, $data, $vinjettBildsHTML){

    $ar = getCurrentYear() - 1;
    $antalAr = $ar - 1972;
    $totalt = getSummeradTotal($data);
    $medel = floor($totalt/$antalAr);

    ?>

    <div class="d-flex">
        <div>
            <br/>
            <table class="table table-striped table-small text-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th colspan="2" class="text-center"><?php echo $texts->getTxt('alla-ar-summary') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $texts->getTxt('totalt') ?>&nbsp;&nbsp;&nbsp;</td>
                        <td class="pl-2 no-s"> <?php echo formatNo($totalt) ?> </td>
                    </tr>
                    <tr>
                        <td><?php echo $texts->getTxt('medel') ?></td>
                        <td class="pl-2 no-s"><?php echo formatNo($medel) ?></td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="intro-image">
            <div><?php echo $vinjettBildsHTML ?></div>
        </div>

    </div>

    <?php
}

function getSummeradTotal($data){

    $summa = 0;
    for ($i=0; $i<sizeof($data); $i++){
        $summa = $summa + $data[$i]['ARSSUMMA'];
    }

    return $summa;

}


function getStrackYearTotal($ar, $data){

    $returnValue = '0';
    for ($i=0; $i<sizeof($data); $i++){

        if ($data[$i]['YEAR'] == $ar){
            $returnValue = $data[$i]['ARSSUMMA'];
            break;
        }

    }

    return  $returnValue;
}

function writeNabbenTioDagarTable($texts, $periodInfo, $periodData){

    $startDay = $periodInfo[0]['STARTDAG'];
    $periodLangd = $periodInfo[0]['PERIOD_LENGTH'];

    echo ('<table class="table table-striped table-hover table-sm w-auto">');
    echo ('<thead class="thead-light">');
    echo ('<tr>');
    echo ('<th>');
    echo ($texts->getTxt('Art'));
    echo ('</th>');

    for ($col = 0; $col < $periodLangd; $col++){
        $thisDay = $startDay  + $col;
        echo ('<th class="text-center">');
        echo ($thisDay);
        echo ('</th>');
    }

    echo ('<th>');
    echo ($texts->getTxt('Summa'));
    echo ('</th>');
    echo ('</thead>');
    echo ('<tbody>');
    foreach ($periodData as $art){

        $artClass = '';
        $tdClass = 'dagsum';
        $tdSumClass = 'sumdagsum';
        if ($art['SNR'] == 996){
            $artClass = 'summa';
            $tdClass = 'dagsum summa';
            $tdSumClass = 'sumdagsum summa';
        }
        echo ('<tr>');
        echo ('<td class="' . $artClass .'">'. $art['NAMN'] . '</td>');

        for ($col = 0; $col < $periodLangd; $col++){
            $thisDay = $startDay  + $col;
            echo ('<td class="' . $tdClass . '">' .  formatNo($art[$thisDay]) . '</td>' );
        }

        echo ('<td class="' . $tdSumClass . '">'. formatNo($art['TOT']) . '</td>');
        echo ('</tr>');
    }

    echo ('</tr>');
    echo ('</tbody>');
    echo ('</table>');

}



function getStrackSpeciesAverage($art, $data){

    $returnValue = '0';
    for ($i=0; $i<sizeof($data); $i++){

        if ($data[$i]['ART'] == $art){
            $returnValue = $data[$i]['MEDEL'];
            break;
        }

    }

    return  $returnValue;
}


function writeTenYearAveragesTable($data, $texts){
    ?>

    <table class="striped">
        <tr><th colspan="2"><?php echo $texts->getTxt('mo-pop-average') ?></th></tr>
        <?php foreach($data as $fiveYearPeriod): ?>
            <tr>
                <td> <?php echo $fiveYearPeriod['PERIOD'] ?></td>
                <td class="no-s"> <?php echo formatNo($fiveYearPeriod['MV']);  ?></td>
            </tr>
        <?php endforeach ?>
    </table>


    <?php
}


function getTioDagarsPerioderNabben(){

    $r = array();
    array_push($r, 'aug-1', 'aug-2', 'aug-3');
    array_push($r, 'sep-1', 'sep-2', 'sep-3');
    array_push($r, 'okt-1', 'okt-2', 'okt-3');
    array_push($r, 'nov-1', 'nov-2');

    return $r;

}

