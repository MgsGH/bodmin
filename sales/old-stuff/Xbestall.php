<?php
session_start();
$_SESSION['kundnr']=session_id();
$kund=$_SESSION['kundnr'];
require_once "../incl_filer/db_connect_skofsales.php"; //databasanslutning
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Din best�llning</title>
<LINK REL=STYLESHEET HREF="../bluemall.css" TYPE="text/css">
<script language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript">

<!--
  var ol_width=140; //s�tter bredden p� popuprutan
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
<p><b>BEST�LLNING.</b></p>
<p>H�r kan du kontrollera vilka varor du har best�llt samt bekr�fta, justera eller radera 
  din best�llning.<br>
  V�ljer du att bekr�fta skickas best�llningen med e-post till oss och vi levererar varorna s� fort vi kan.
  <br>Betalning sker mot faktura som medf�ljer leveransen.</p>
<?php
//bekr�fta best�llning
if (isset($_REQUEST['bekrafta']))
{$sql_conf="UPDATE varukorg SET buy='J' WHERE kundnr='$kund'";
 mysqli_query($connect, $sql_conf);
}

elseif (isset($_REQUEST['uppdatera'])) 
{foreach ($_REQUEST['antal'] AS $apost => $antal)
 {$ny_ant=$_REQUEST['antal'][$apost];
  if (isset($_REQUEST['size'][$apost]))
  {$ny_storl=$_REQUEST['size'][$apost];
   $sql_upd="UPDATE varukorg SET antal='$ny_ant', size='$ny_storl' WHERE korgID='$apost'";}
  else
  {$sql_upd="UPDATE varukorg SET antal='$ny_ant' WHERE korgID='$apost'";}
  mysqli_query($connect, $sql_upd);
 }
}

//�ndra eller radera markerad artikel
elseif (isset($_REQUEST['andrad'])) //FORMUL�RET �NDRA/RADERA
//kolla efter ikryssade checkboxar
//g�r formul�r d�r man kan �ndra
{if (isset($_REQUEST['andra']))
 {echo '<form name="artandr" method="POST" action="'.$_SERVER['PHP_SELF'].'">
  <table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead">
  <td colspan="6">
  �ndra best�llning av f�ljande varor:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Antal</td>
  <td width="360">Artikel</td>
  <td>Storlek</td>
  <td>&nbsp;</td>
  <td align="right">Pris/st.</td>
  <td align="right">Summa</td></tr>';
  $farg='#FFFFFF';
  foreach ($_REQUEST['andra'] AS $andrpost) //VISAR POSTER SOM SKA �NDRAS
  {if ($farg=='#FFFFFF')
   {$farg='#E1E8F7';}
   else
   {$farg='#FFFFFF';}
   $sql_and="SELECT *, (varukorg.antal*varor.pris) AS summa from varor, varukorg 
   WHERE varukorg.kundnr='$kund'
   AND varukorg.artnr=varor.artnr
   AND korgID='$andrpost'";
   $query_and=mysqli_query($connect, $sql_and);
   while ($row=mysqli_fetch_assoc($query_and))
   {echo 
    '<tr bgcolor='.$farg.'>
    <td width="33" align="right">
    <input type="text" size="2" name="antal['.$row['korgID'].']" value="'.$row['antal'].'"></td>
    <td width="360">'.$row['artikel'].'</td>';
    if ($row['artnr']==27 || $row['artnr']==28 || $row['artnr']==29)
    {echo '<td>
     <select name="size['.$row['korgID'].']">
	 <option selected>'.$row['size'].'</option>
	 <option value="S">S</option>
	 <option value="M">M</option>
	 <option value="L">L</option>
	 <option value="XL">XL</option>
	 <option value="XXL">XXL</option>
	 </select></td>';}
    else
    {echo '<td>&nbsp;</td>';}
    echo '<td width="15">Kr.</td>
    <td align="right">'.str_replace('.', ',', $row['pris']).'</td>
    <td align="right">'.str_replace('.', ',', $row['summa']).'</td>
    </tr>';
   }
  } 
  echo '</table>
  <input type="submit" name="uppdatera" value="Uppdatera" class="submit"
  onMouseOver="this.style.color=\'blue\'" 
  onMouseOut="this.style.color=\'#FFFFFF\'">
  </form>';
 }
  
//radera
 if (isset($_REQUEST['radera']))
 {foreach ($_REQUEST['radera'] AS $tabortpost) 
  {$sql_rad="DELETE from varukorg WHERE kundnr='$kund' AND korgID='$tabortpost'";
   mysqli_query($connect, $sql_rad);
  } 
 }
}
//radera allt
elseif (isset($_REQUEST['tabort']))
{$sql_tabort="DELETE from varukorg WHERE kundnr='$kund'";
 mysqli_query($connect, $sql_tabort);
 $kund='';
 unset ($_SESSION['kundnr']); 
 $_SESSION=array();
 session_destroy();
}  

// visa best�llning
$sql_best="SELECT * , (varukorg.antal*varor.pris) AS summa from varor, varukorg
WHERE varukorg.kundnr='$kund'
AND varukorg.artnr=varor.artnr
ORDER by varukorg.artnr";
$query_best=mysqli_query($connect, $sql_best) or die (mysqli_error($connect));

//H�R B�RJAR VISNINGEN AV SIDAN D� ENDAST BEST VISAS

if (mysqli_num_rows($query_best)==0)
 {echo '<b>Du har inte best�llt n�got.</b>';
  if (isset($_SESSION['kundnr']))
  {unset ($_SESSION['kundnr']);
   unset ($kund); 
   $_SESSION=array();
   session_destroy();
  } 
 }
elseif (!isset($_REQUEST['bekrafta'])) 
 {echo 
  '<form name="bestallning" method="POST", action="'.$_SERVER['PHP_SELF'].'">
  <table cellpadding="3" cellspacing="0" width="700">
  <tr class="tablehead">
  <td colspan="8">
  Du har prelimin�rt best�llt f�ljande varor:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Antal</td>
  <td width="360">Artikel</td>
  <td>Storlek</td>
  <td width="15">&nbsp;</td>
  <td align="right">Pris/st.</td>
  <td align="right">Summa</td>
  <td>�ndra</td>
  <td>Radera</td>
  </tr>';
  $farg='#FFFFFF';
  $totalt=0.00;
  while ($row=mysqli_fetch_assoc($query_best))
  {if ($farg=='#FFFFFF')
   {$farg='#E1E8F7';}
   else
   {$farg='#FFFFFF';}
   $korgnr=$row['korgID'];
   echo 
   '<tr bgcolor='.$farg.'>
    <td width="33" align="right">'.$row['antal'].'</td>
    <td width="360">'.$row['artikel'].'</td>
    <td>'.$row['size'].'</td>
    <td width="15">Kr.</td>
    <td align="right">'.str_replace('.', ',', $row['pris']).'</td>
    <td align="right">'.str_replace('.', ',', $row['summa']).'</td>
    <td align="center"><input type="checkbox" style="border:0" name="andra['.$row['korgID'].']" 	
    value="'.$row['korgID'].'"></td>
    <td align="center"><input type="checkbox" style="border:0" name="radera['.$row['korgID'].']"
    value="'.$row['korgID'].'"></td>
    </tr>';
    $totalt=$totalt+$row['summa'];
  }
  echo '<tr class="tablehead">
  <td colspan="4">&nbsp;</td>
  <td align="right">Totalt:</td><td align="right">'.$totalt.',00</td>
  <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="alt_tab_bg"><td colspan="6" align="right">
  Postens avgifter tillkommer p� ovanst�ende summa.</td><td colspan="2">&nbsp;</td>
 </tr>  
  </table>';
 echo '<p>
 <input type="submit" name="bekrafta" value="Bekr�fta best�llning" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="andrad" value="�ndra/radera" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="tabort" value="Radera allt" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></p>
 </form>';
 }
// bekr�ftad best�llning och fyll i adressuppgifter
elseif (isset($_REQUEST['bekrafta']) || isset($_REQUEST['omstart'])) 
 {echo
  '<table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead">
  <td colspan="6">
  Du har bekr�ftat best�llning av f�ljande varor:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Antal</td><td width="360">Artikel</td><td>Storlek</td><td>&nbsp;</td>
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
    <td width="360">'.$row['artikel'].'</td>
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
  Postens avgifter tillkommer p� ovanst�ende summa.</td></tr>  
  </table>';
 ?>
<p>OBS. Du kan fortfarande handla mer, best�llningen �r inte definitiv f�rr�n den har skickats.</p> 
<form name="person" method="POST" action="ordersida.php">
<table cellpadding="3" cellspacing="0" width="600" class="alt_tab_bg">
<tr class="tablehead">
<td colspan="4">Fyll i namn och adress h�r:</td>
</tr>
<td width="100">Efternamn:*</td>
<td width="200"><input type="text" size="30" name="enamn"></td>
<td width="100">F�rnamn:*</td>
<td width="200"><input type="text" size="30" name="fnamn"></td>
</tr>
<tr>
<td width="100">Gatuadress:*</td>
<td width="200"><input type="text" size="30" name="gata"></td>
<td width="100">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="100">Postnummer:*</td>
<td width="200"><input type="text" size="10" name="postnr"></td>
<td width="100">Ort:*</td>
<td width="200"><input type="text" size="30" name="ort"></td>
</tr>
<!--- <tr>
<td width="100">Land:</td>
<td width="200"><input type="text" size="30" name="land" value="Sverige" class="textruta"></td>
</tr> -->
<tr>
<td width="100">E-post:*</td>
<td width="200"><input type="text" size="30" name="epost"></td>
</tr>
</table>
<p>
 <input type="submit" name="Skicka" value="Skicka best�llning" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="rensa" value="Radera allt" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
</p>
</form>
<?php
}
?> 
</body>
</html>
