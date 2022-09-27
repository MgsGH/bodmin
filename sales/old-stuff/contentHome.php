<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost') {
    $path = 'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/sales/data/connect_new.php';
$connect = getSQLIConnection();


$sql_senaste = "SELECT *, sortiment.bildmapp FROM varor, sortiment WHERE varor.katnr=sortiment.katnr ORDER BY varor.artnr DESC LIMIT 6";
$query_senaste = mysqli_query($connect, $sql_senaste) or die (mysqli_error($connect));
?>

<h2>Senaste nytt</h2>
<h4>Klicka för mer info/beställning</h4>
<table class="alt_tab_bg">

    <?php
    $antal = 4;
    //räknare för radskifte
    $rtd = 1;
    while ($row = mysqli_fetch_assoc($query_senaste)) {
        if ($rtd == 1) {
            echo '<tr><td>';
        } else {
            echo '<td>';
        }
        $varunr = $row['artnr'];
        $katnr = $row['katnr'];
        $varubild = $varunr . '_stor.jpg';
        $mapp = $row['bildmapp'];
        $bubbla = $row['artikel'] . ' ' . $row['pris'] . ' kr. ' . $row['extra_s'];
        echo '<a href="allavaror.php?sprak=sve&kat=' . $katnr . '"> <img src="bilder/' . $mapp . '/' . $varubild . '" alt="bild" title="' . $bubbla . '"></a></td>';
        if ($rtd == 2) {
            echo '</tr>';
            $rtd = 1;
        } else {
            $rtd = 2;
        }
    }
    ?>
</table>

