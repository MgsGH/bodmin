<?php
session_start();
$_SESSION['kundnr']=session_id();
$kund=$_SESSION['kundnr'];
$best_medd='';
require_once "../incl_filer/db_connect_skofsales.php"; //databasanslutning
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Litografier</title>
<LINK REL=STYLESHEET HREF="../bluemall_cal.css" TYPE="text/css">
<script language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript">
<!--
  var ol_width=125; //s�tter bredden p� popuprutan
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

<?php
if (isset($_REQUEST['litos']) && !empty($_REQUEST['artnr']))
//administrera best�llning
//kolla efter ikryssade checkboxar
{foreach ($_REQUEST['artnr'] AS $id => $artnr) 
 {$antal=$_REQUEST['antal'][$id];
  if (is_numeric($antal) && $antal>0)
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, buy) VALUES ('$kund', '$artnr', '$antal', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
	$best_medd='Prel. best�llning mottagen.<b> Best�llningslista</b> t.v. visar alla dina prel. 	best�llningar.';
  }
  else
  {$best_medd='Du m�ste ange ett giltigt antal!';} 
 }
}
?>
<body class="alt_tab_bg" style="background-image: url('')">
<div align="center">
<center>
<b>Litografier</b> till st�d f�r Falsterbo F�gelstation.<br>
<span style="font-size: 11px">Litografierna �r numrerade och signerade av respektive konstn�r. 
Levereras i pappr�r. <br>
Best�llning sker genom att kryssa i rutan och ange antal vid resp. artikel.<br>
Klicka sedan p� &quot;L�gg till best�llning&quot; l�ngst ned p� sidan.
<?php 
 if ($best_medd<>'')
 {echo '<p><font color="blue">
  '.$best_medd.'</font>';}
?> 
</span></p>
<form style="margin-bottom:0; margin-top:0" name="lito" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table width="760" class="alt_tab_bg" style="border:0; border-collapse: collapse" id="table1">
 <tr><td>
 <img border="0" src="../bilder/diverse/lito_brus.jpg" alt=""
      align="left" hspace="5" style="border: 10px ridge #F2F2F3" width="353" height="250">
 </td>
 <td>
 <img border="0" src="../bilder/diverse/lito_fjeld.jpg" alt=""
      align="left" hspace="5" style="border: 10px ridge #F2F2F3" width="317" height="250">
 </td></tr>
 <tr><td> 
 <p align="center"><br>
 <b>Gunnar Brusewitz: Str�ckande prutg�ss.</b><br>
    Utgiven 1990.<br>
    Bildyta 38x25 cm.<br>
 <b>900 kr/st.</b><br>
 Best�ll:<input type="checkbox" style="border:0" name="artnr[1]" value="1">&nbsp
 Antal: <input type="text" size="2" value="1" name="antal[1]">
 </td><td>
 <p align="center"><br>
 <b>Jon Fjelds�: Sk�rfl�ckor.</b><br>
    Utgiven 1982.<br>
    Bildyta 35x27 cm.<br>
 <b>200 kr/st.</b><br>
 Best�ll:<input type="checkbox" style="border:0" name="artnr[2]" value="2">&nbsp
 Antal: <input type="text" size="2" value="1" name="antal[2]">
 </td>
 </tr>
</table>
<input type="submit" name="litos" value="L�gg till best�llning" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="dellito" value="Radera" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Tillbaka</button>
</form>
<?php 
 if ($best_medd<>'')
 {echo '<p align="center" style="font-size:11px; margin-top:3px"><font color="blue">
  '.$best_medd.'</font></p>';}
?> 
</center>
</div>
</body>
</html>
