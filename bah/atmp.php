<?php

include "../../incl_filer/db_connect.php"; //databasanslutning
date_default_timezone_set("CET");

$valdag ='0000-00-00';
if (isset($_REQUEST['q_year']) && isset($_REQUEST['q_monad']) && isset($_REQUEST['q_day'])){
    $valdag=$_REQUEST['q_year'].'-'.$_REQUEST['q_monad'].'-'.$_REQUEST['q_day'];
} elseif (isset($_REQUEST['valdag'])){
    $valdag=$_REQUEST['valdag'];
}
$sql_vader="SELECT * from dagb_vader WHERE datum='$valdag'";
$query_vader=mysqli_query($connect, $sql_vader) or die (mysqli_error($connect));

function plats($pkod) {
    switch ($pkod){
        case 'FA':
            $ptext_s='Fyren, standardiserad märkning';
            $ptext_e='Lighthouse Garden, standardised ringing';
            break;
        case 'FB':
            $ptext_s='Fyren, standardiserad märkning';
            $ptext_e='Lighthouse Garden, standardised ringing';
            break;
        case 'FC':
            $ptext_s='Flommen, standardiserad märkning';
            $ptext_e='Flommen reedbeds, standardised ringing';
            break;
        case 'ÖV':
            $ptext_s='Övrig märkning';
            $ptext_e='Miscellaneous ringing';
            break;
        case 'PU':
            $ptext_s='Pullmärkning';
            $ptext_e='Nestlings';
            break;
        //lokaler för specificerad övrigfångst Obs. Black bör ha annan kod kommer annars före standardfångsten vid visningen
        case 'BL':
            $ptext_s='Black, övrig märkning';
            $ptext_e='Black, misc. ringing';
            break;
        case 'FP':
            $ptext_s='Falsterbo park, övrig märkning';
            $ptext_e='Falsterbo Park, misc. ringing';
            break;
        case 'FM':
            $ptext_s='Flommen, övrig märkning';
            $ptext_e='Flommen reedbeds, misc. ringing';
            break;
        case 'FO':
            $ptext_s='Falsterbo samhälle, övrig märkning';
            $ptext_e='Falsterbo village, misc. ringing';
            break;
        case 'FY':
            $ptext_s='Fyren, övrig märkning';
            $ptext_e='Lighthouse Garden, misc. ringing';
            break;
        case 'KN':
            $ptext_s='Knösen, övrig märkning';
            $ptext_e='Knösen, misc. ringing';
            break;
        case 'LJ':
            $ptext_s='Skanörs Ljung, övrig märkning';
            $ptext_e='Skanörs Ljung, misc. ringing';
            break;
        case 'LH':
            $ptext_s='Ljunghusen, övrig märkning';
            $ptext_e='Ljunghusen, misc. ringing';
            break;
        case 'MÅ':
            $ptext_s='Måkläppen, övrig märkning';
            $ptext_e='Måkläppen, misc. ringing';
            break;
        case 'NA':
            $ptext_s='Nabben, övrig märkning';
            $ptext_e='Nabben, misc. ringing';
            break;
        case 'SK':
            $ptext_s='Skanör, övrig märkning';
            $ptext_e='Skanör, misc. ringing';
            break;
        case 'SL':
            $ptext_s='Slusan-Bakdjupet, övrig märkning';
            $ptext_e='Slusan-Bakdjupet, misc. ringing';
            break;
        case 'SP':
            $ptext_s='Skanörs park, övrig märkning';
            $ptext_e='Skanör Park, misc. ringing';
            break;
        case 'SR':
          $ptext_s='Skanörs revlar, övrig märkning';
          $ptext_e='Skanörs revlar, misc. ringing';
          break;
        case 'ÄN':
          $ptext_s='Ängsnäset, övrig märkning';
          $ptext_e='Ängsnäset, misc. ringing';
          break;
    }
    return $ptext_s;
}
?>

<!--DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd"-->
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<title>Läs dagboken</title>
<link rel="stylesheet" type="text/css" href="../../bluemall.css">
<base target="_self">
<script type="text/javascript" language="JavaScript">
function fonster(URL) {
    //url är sökvägen till filen som öppnas i fönstret lankfonster
    var oppna = open(URL, "lankfonster", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=350px, height=780px, top=20, left=688")
}
</script>
<script type="text/javascript" language="JavaScript" src="../../overlib.js">
</script>
<script type="text/javascript">
<!--
  var ol_width=120; //sätter bredden på popuprutan
//-->
</script>
<style type="text/css">
body {font-size: 12px;}
</style>
<base target="_self">
</head>

<body bgcolor="#FFFFFF" style="background-image: url('log_read.php')">
<p>

<?php

if ( $valdag && $valdag != '0000-00-00' ){
        $idag = $valdag;
        $txtdir = substr($idag,0,4);
        $dbokfil = $idag.'.txt';
        $eng_dbokfil = $idag.'_e.txt';
        if (file_exists($txtdir.'/'.$dbokfil) == false && file_exists($txtdir.'/'.$eng_dbokfil) == false){
            echo 'Det finns inget dagboksblad för den valda dagen...';
            echo ' <p><button style="width: 70px" OnClick="javascript:history.back()"';
            echo 'onMouseOver="this.style.color=\'blue\'"';
            echo 'onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button></p>';
        } else {

            // dagboksblad finns - ta ut föreg och nästa dag
            // igår eller närmast föregående
            $sql_igar="SELECT MAX(dagbdatum) AS PREV 
            FROM dagboksblad
            WHERE dagbdatum<'$idag'
            ORDER BY dagbdatum";
            $query_igar=mysqli_query($connect, $sql_igar) or die(mysqli_error($connect));
            while ($row=mysqli_fetch_assoc($query_igar)) {
                if ($row['PREV'] == '')
                    {$igar='finns ej';}
                else {
                    $igar=$row['PREV'];
                }
            }

            //imorgon eller närmast följande
            $sql_morrn="SELECT MIN(dagbdatum) AS NEXT 
            FROM dagboksblad
            WHERE dagbdatum>'$idag' 
            ORDER BY dagbdatum";
            $query_morrn=mysqli_query($connect, $sql_morrn) or die(mysqli_error($connect));
            while ($row=mysqli_fetch_assoc($query_morrn)){
                if ($row['NEXT'] == '') {
                    $morrn = 'finns ej';}
                else {
                    $morrn = $row['NEXT'];
                }
            }

            // HÄR NYTT HUVUD INKL VÄDER
            //fr. Dagboken_db.php
            if ($idag > '2007-01-01'){
                $year = substr($idag,0,4);
                $monad = substr($idag,5,2);
                $dag = substr($idag,8,2);
                setlocale(LC_TIME, 'sv_SE');

                $titelrad='<p><font size="4">FALSTERBO FÅGELSTATION</font></p>';
                $datering=utf8_encode(ucfirst(strftime("%A %e %B %Y", mktime(0, 0, 0, $monad, $dag, $year)))).'.';
                echo '  <table style="border: 0; cellpadding: 0; border-collapse: collapse" width="100%"> <tr><td width="65"><img border="0" src="bilder/fbodekal_3d.jpg" width="52" height="77"
                        align="left" style="float: left" hspace="0"></td>
                        <td style="vertical-align:top">'.$titelrad.'<p style="font-size:12px">'.$datering.'</p></td>
                        <td style="vertical-align:top">
                        <table width="415" class="table_none_small" align="center">
                        <tr>
                        <td width="25">Kl.</td>
                        <td width="30">Moln</td>
                        <td width="26">Vind </td>
                        <td width="20" align="right">m/s</td>
                        <td width="40" align="right">Temp</td>
                        <td width="55" align="center">Sikt</td>
                        <td width="44" align="center">Tryck</td>
                        <td width="3"></td>
                        <td width="162">Väder</td>
                        <td width="10"><img src="bilder/info8.gif" alt="" border="0"
                        onMouseover="overlib(\'<b>Väderinfo.</b><br><u>Klockslag:</u> normaltid (kl. 01,07,13,19) eller sommartid<br>(kl. 02,08,11,20). 01/02: manuell eller automatisk. Övriga: manuella.<br><u>Molnighet:</u> 9/8: tät dimma. X/8: obs från automat, anger ej total molnmängd.<br><u>Vindriktning:</u> Engelska förkortn: E=ost, W=väst.<br><u>Sikt:</u> <5 km med en decimal.<br><u>Väder:</u> Det som råder vid obsen.\')"
                        onMouseout="nd()"></td>
                        </tr>';
                while ($row=mysqli_fetch_assoc($query_vader)){
                    echo '  <tr>
                            <td width="25">'.$row['kl'].':</td>
                            <td width="30">'.$row['moln'].'/8</td>
                            <td width="26">'.$row['vrik'].'</td>
                            <td width="22" align="right">'.$row['vsty'].'</td>
                            <td width="40" align="right">'.$row['temp'].'</td>
                            <td width="50" align="right">'.$row['sikt'].' km</td>
                            <td width="44" align="right">'.$row['tryck'].'</td>
                            <td width="3"></td>
                            <td width="172" colspan="2" padding-left="3px">'.$row['s_vader'].'</td>
                            </tr>';
                }
                echo ' </table>
                      </td></tr></table></p><p>';
            }

            //HÄR SLUTAR NY DEL
            //echo utf8_encode(stripslashes(file_get_contents ($txtdir.'/'.$dbokfil, null)));
            echo stripslashes(file_get_contents ($txtdir.'/'.$dbokfil, null));
            //Dagens ringmärkning
            //kolla platskoder för aktuell dag
            $sql = mysqli_query($connect, " SELECT p FROM rmdagsum where rmdagsum.datum='$idag' and rmdagsum.p<>'ÖV'
                                                    UNION SELECT p FROM ovda2sum where ovda2sum.datum='$idag'
                                                    ORDER BY p");
            if ( mysqli_num_rows($sql) != 0 ) {
                echo '<p><b>Ringmärkning</b><br/>';
                while ($row = mysqli_fetch_assoc($sql)){
                    $pkod = ($row['p']);
                    $textrad = '';
                    $textrad2 = '';
                    $textrad3 = '';
                    if ($pkod=='FA' || $pkod=='FB' || $pkod=='FC' || $pkod=='PU') {
                        $query = mysqli_query($connect, "select rmdagsum.datum, artnamn.svnamn, rmdagsum.summa from rmdagsum, artnamn 
                        where rmdagsum.p='$pkod' and rmdagsum.art=artnamn.art and rmdagsum.datum='$idag' order by rmdagsum.snr")
                        or die (mysqli_error($connect));
                    } else {
                        $query = mysqli_query($connect, "select ovda2sum.datum, artnamn.svnamn, ovda2sum.summa from ovda2sum, artnamn 
                        where ovda2sum.p='$pkod' and ovda2sum.art=artnamn.art and ovda2sum.datum='$idag' order by ovda2sum.snr")
                        or die (mysqli_error($connect));
                    }

                    $arter = ( mysqli_num_rows($query) )-1;
                    while ($row = mysqli_fetch_assoc($query)){

                        if ($textrad == ''){
                            $textrad = $textrad . $row['svnamn'] . ' ' . $row['summa'];
                        }
                        else {
                            if ( $row['svnamn'] == 'SUMMA' ){
                                $fagelText = ' fåglar av ';
                                if ( $row['summa'] == 1 ) {
                                    $fagelText = ' fågel av ';
                                }
                                $arterText = ' arter ';
                                if ( $arter==1 ){
                                    $arterText = ' art ';
                                }
                                $textrad2 = '. <br>';
                                $textrad3 = $row['svnamn'] . ': ' . $row['summa'] .
                                $fagelText . $arter. $arterText;

                            } else {
                                $textrad = $textrad . ', ' . $row['svnamn'] . ' ' . $row['summa'];
                            }
                        }

                        $s  = mb_strtolower($textrad);
                        $s2  = mb_strtolower($textrad2);
                        $s3  = mb_strtolower($textrad3);

                        $arterna = ucfirst($s) . $s2 . ucfirst($s3);
                    }
                    //denna görs till en textfil som kan importeras till dagbokenXXX
                    file_put_contents (plats($pkod).'_idag.txt', '<b>'.plats($pkod).': </b>'.$arterna);
                    echo file_get_contents(plats($pkod).'_idag.txt', null).'<p>';
                }
            } else {

                $text = '<p>Ingen ringmärkning idag...</p>';
                if ($idag == date('Y-m-d')){
                    $text = '<p>Dagens ringmärkning inställd eller ännu ej inmatad.</p>';
                }
                echo ( $text );

            }
            // stäng databaskopplingen
            mysqli_close($connect);

  /*Dagens sträck:*/
if (substr($idag,5,5)>="08-01" && substr($idag,5,5)<="11-20"){
echo '</p><p><table border="0" cellpadding="0" 
style="border-collapse: collapse; border-top: 1px solid #3A69CB; border-bottom: 1px solid #3A69CB; border-left:0; border-right:0" width="750">
<tr>
<td><font style="font-size: 11px">
<b>Sträckräkning idag:</b><br>
Resultat från de standardiserade räkningarna vid Nabben<br>
1 augusti-20 november.</td>
<td align="right" valign="center">
<a style="cursor:pointer" onClick="javascript:fonster(\'../../arkiv/strack/strackidag.php?valdag='.$idag.'\')">
<button style="width:120px">
<font onMouseOver=this.color="blue" onMouseOut=this.color="#FFFFFF">Dagens sträck</font></button>
</a>
</td></tr></table>';
}
/*Veckans rastfågelräkning:*/
$rast='</p><p><table border="0" cellpadding="0" style="border-collapse: collapse; 
border-top: 1px solid #3A69CB; border-bottom: 1px solid #3A69CB; border-left:0; border-right:0" width="750">
 <tr>
<td><font style="font-size: 11px">
<b>Veckans rastfågelräkning:</b><br>Länken går till den vecka i vilken ovanst. datum ingår.<br> För pågående vecka föreligger resultaten oftast först i slutet av veckan.</td>';
$valdag_r=strtotime($idag);
$valvec=date('W',$valdag_r);
$yno=substr($idag,0,4);
$wno=$valvec;
$rastknapp='<td align="right" valign="center"><button style="width: 135px" 
 OnClick=parent.location.href="../../arkiv/rast/rastrakn_s.php?yno='.$yno.'&wno='.$wno.'"
 OnMouseOver="overlib(\'Vecka ' .$wno.'\');"
 OnMouseOut="nd()">
 <font onMouseOver=this.color="blue" onMouseOut=this.color="#FFFFFF">
 Rastfågelräkning</font></button></td>
 </tr></table>';
 echo $rast.$rastknapp;

 $sidfot='</p><p>';
  echo stripslashes($sidfot);
 }

echo '<p align="center">';
if ($igar != 'finns ej') {
     echo '<button style="width: 25px" 
          OnClick="parent.dagbok.location.href=\'log_read.php?valdag='.$igar.'\'"
          OnMouseOver="this.style.color=\'blue\'; overlib(\'Närmast föregående dagboksblad.\');"
          OnMouseOut="this.style.color=\'#FFFFFF\'; nd()"><</button>';
 } else {
     echo ' <button style="width: 25px" 
            OnMouseOver="this.style.color=\'blue\'; overlib(\'Det finns inga tidigare dagboksblad.\');"
            OnMouseOut="this.style.color=\'#FFFFFF\'; nd()">x</button>';
 }
echo '&nbsp;<span style="font-size:11px; font-weight:bold">Bläddra</span>&nbsp;';
if ( $morrn != 'finns ej'){
     echo ' <button style="width: 25px" 
             OnClick="parent.dagbok.location.href=\'log_read.php?valdag='.$morrn.'\'"
             OnMouseOver="this.style.color=\'blue\'; overlib(\'Närmast följande dagboksblad.\');"
             OnMouseOut="this.style.color=\'#FFFFFF\'; nd()">></button>';
 } else {
     echo '    <button style="width: 25px" 
                OnMouseOver="this.style.color=\'blue\'; overlib(\'Det finns inga senare dagboksblad.\');"
                OnMouseOut="this.style.color=\'#FFFFFF\'; nd()">x</button>';
}
echo '</p>';

}
else {
    echo '</p><p align="center">Ingen dag vald.';
    echo '  <p align="center">
            <img valign="middle" src="bilder/Dagbok.jpg" class="bildram2" alt="">
            <br>Den ursprungliga dagbokens senaste elva upplagor...';
}
?>
</p>
<p align="center"><span style="font-size: 11px;"><b>TIPS:</b> Bläddra gärna bakåt i dagboken. Nya inlägg kommer inte sällan med någon dags fördröjning.</span></p>
</body>

</html>
