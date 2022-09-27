<?php
session_start();
$_SESSION['kundnr']=session_id();
$kund=$_SESSION['kundnr'];
require_once "../incl_filer/db_connect_skofsales.php"; //databasanslutning
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Slutlig beställning</title>
<LINK REL=STYLESHEET HREF="../bluemall.css" TYPE="text/css">
<script language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript">

<!--
  var ol_width=140; //sätter bredden på popuprutan
//-->
</script>
<style>
p
{
 margin-top: 6px;
 margin-bottom: 6px;
}
</style>
<base target="_self">
</head>

<body class="alt_tab_bg" style="background-image: url('')">
<?php
// fyll i kunduppgifter i tab varukund
if (isset($_REQUEST['Skicka']) && !empty($_REQUEST['enamn']) && !empty($_REQUEST['fnamn'])
&& !empty($_REQUEST['gata']) && !empty($_REQUEST['postnr']) && !empty($_REQUEST['ort'])
&& !empty($_REQUEST['epost']))
{$enamn=$_REQUEST['enamn'];
 $fnamn=$_REQUEST['fnamn'];
 $gata=$_REQUEST['gata'];
 $postnr=$_REQUEST['postnr'];
 $ort=$_REQUEST['ort'];
 $epost=$_REQUEST['epost'];
 $sql_kund="INSERT INTO varukund (kundnr, enamn, fnamn, adress, postnr, ort, epost)
 VALUES ('$kund','$enamn','$fnamn','$gata','$postnr','$ort', '$epost')";
 mysqli_query($connect, $sql_kund)or die (mysqli_error($connect));
 
//beställning
 $sql_best="SELECT * , (varukorg.antal*varor.pris) AS summa from varor, varukorg
 WHERE varukorg.kundnr='$kund'
 AND varukorg.artnr=varor.artnr
 ORDER by varukorg.artnr";
 $query_best=mysqli_query($connect, $sql_best) or die (mysqli_error($connect));
 
 echo '<table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead">
  <td colspan="6">
  Din beställning:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Antal</td><td>Artikel</td><td>Storlek</td><td>&nbsp;</td>
  <td align="right">Pris/st.</td><td align="right">Summa</td></tr>';
  $farg='#FFFFFF';
  $totalt=0.00;
  while ($row=mysqli_fetch_assoc($query_best))
  {if ($farg=='#FFFFFF')
   {$farg='#E1E8F7';}
   else
   {$farg='#FFFFFF';}
   echo 
   '<tr bgcolor='.$farg.'>
    <td width="33" align="right">'.$row['antal'].'</td>
    <td>'.$row['artikel'].'</td>
    <td>'.$row['size'].'</td>
    <td>Kr.</td>
    <td align="right">'.str_replace('.', ',', $row['pris']).'</td>
    <td align="right">'.str_replace('.', ',', $row['summa']).'</td>
    </tr>';
    $totalt=$totalt+$row['summa'];
  }
  echo '<tr class="tablehead">
  <td colspan="4">&nbsp;</td>
  <td align="right">Totalt:</td><td align="right">'.$totalt.',00</td>
  </tr>
  <tr class="alt_tab_bg"><td colspan="6" align="right">
  Postens avgifter tillkommer på ovanstående summa.</td></tr>
  </table>';
  echo '<p>&nbsp;</p>';
//beställare
  echo '<table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead"><td>Beställt av:</td></tr>
  <tr><td>'.$fnamn.' '.$enamn.', '.$gata.',  '.$postnr.' '.$ort.'</td></tr>
  <tr><td>'.$epost.'</td></tr>
  </table>';

//mail
 $to='falsterbo@skof.se';
 $subject='Beställning';
 $message="Beställning, skickad via formuläret på hemsidan från:\r\n
 $kund\r\n$fnamn $enamn\r\n$gata\r\n$postnr $ort\r\n $epost\r\n";
 $headers = "From:<$epost>\r\n";
 ini_set('SMTP','mail5.axbyte.com');
 ini_set('sendmail_from', 'mail5@axbyte.com'); 
 if (mail($to, $subject, $message, $headers))
 {$formstatus='Tack för Din beställning. Den har nu skickats till fågelstationen.';
  unset ($_SESSION['kundnr']);
  unset ($kund); 
  $_SESSION=array();
  session_destroy();
 }
 else
 {$formstatus='Ett fel uppstod. V.g. försök igen. Om felet kvarstår - meddela oss.';}
}
elseif (isset($_REQUEST['rensa']))
{$sql_tabort="DELETE from varukorg WHERE kundnr='$kund'";
 mysqli_query($connect, $sql_tabort);
 unset ($_SESSION['kundnr']);
 unset ($kund); 
 $_SESSION=array();
 session_destroy();
 $formstatus='Beställningen har annulerats. Välkommen tillbaka en annan gång.';
}  
else
{$formstatus='Formuläret är ofullständigt ifyllt, v.g. försök igen.<br>
 <form method="post" action="bestall.php" target="_self">
 <input type="hidden" name="omstart" value="omstart">
 <input type="submit" name="Skicka" value="Tillbaka" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">';
}
echo '<p><b>'.$formstatus.'</b></p>';
?>
</body>

</html>
