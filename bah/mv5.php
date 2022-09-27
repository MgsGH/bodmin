<?php
//array skapad av antal ringmärkta/sträckande fåglar under x säsonger
//$arr_antal=explode(',', $str_antal);
$arr_antal = $ydata1;
$rulle = 'x,x,';
$rull50 = 0;
$rull51 = 1;
$rull52 = 2;
$rull53 = 3;
$rull54 = 4;
$rullmax = count($arr_antal); //antal element -år- i arrayen
$max_rakn = $rullmax - 4;
//kör slingan tills $rull54 är (rullmax) dvs (rullmax-4) gånger
for ($rakn = 1; $rakn <= $max_rakn; $rakn++) {
    $rull5 = ROUND(($arr_antal[$rull50] + $arr_antal[$rull51] + $arr_antal[$rull52] + $arr_antal[$rull53] + $arr_antal[$rull54]) / 5, 0);
    $rull50 = $rull50 + 1;
    $rull51 = $rull51 + 1;
    $rull52 = $rull52 + 1;
    $rull53 = $rull53 + 1;
    $rull54 = $rull54 + 1;
    $rulle = $rulle . $rull5 . ',';
}
$rulle = $rulle . 'x';
?>