<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$data = getRawStrackData($pdo);

foreach($data as $key1=>$taxaData){

    $i = 0;
    $snr = $taxaData['SNR'];
    $kod = $taxaData['KOD'];

    echo '<h1>' . $snr . ' ' . $kod . '</h1>' . '<br>';

    foreach($taxaData as $key=>$cell){
        if ($i > 2){
            $newDate = '2021' . substr($key, 4);
            echo 'Writing ' . $newDate . ' ' . $cell . '<br>';
            writeStrackData($pdo, $snr, $kod, $newDate, $cell);
        }
        $i++;
    }

}




