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
<title>B�rkassar</title>
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
 margin-top: 3px;
 margin-bottom: 0px;
}
</style>
<base target="_self">
</head>


<?php
if (isset($_REQUEST['kassar']) && !empty($_REQUEST['artnr']))
//administrera best�llning
//kolla efter ikryssade checkboxar
{foreach ($_REQUEST['artnr'] AS $id => $artnr) 
 {$antal=$_REQUEST['antal'][$id];
  if (is_numeric($antal) && $antal>0)
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, buy) VALUES ('$kund', '$artnr', '$antal', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
   $best_medd='Prel. best�llning mottagen.<b> Best�llningslista</b> t.v. visar alla dina prel.    	best�llningar.';
  }
  else
  {$best_medd='Du m�ste ange ett giltigt antal!';} 
 }
}
?>

<body class="alt_tab_bg" style="background-image: url('')">
<div align="center" width="745px" margin="auto">
<center>
<form style="margin-bottom:0; margin-top:0" name="muggar" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table class="alt_tab_bg" cell-spacing="0" cellpadding="5" style="border:0; border-collapse:collapse" 
width="720">
<tr><td colspan="2">
<b><font style="font-size:12px">B�rkassar av bomull.</font></b><br>
Best�llning sker genom att kryssa i rutan och ange antal vid resp. artikel.<br>
Klicka sedan p� "L�gg till best�llning" l�ngst ned p� sidan.
<?php 
 if ($best_medd<>'')
 {echo '<p><font color="blue">
  '.$best_medd.'</font>';}
?>
</td>
</tr>
<tr><td colspan="2">
<img border="0" src="bilder/diverse/kassarna.jpg" alt="" width="700" class="bildram3"></td></tr>
<tr><td width="326">
<b>B�rkasse</b> med sk�rfl�ckor. Original av konstn�ren Hans Larsson. Bredd 38 
cm, h�jd 42 cm.<br>
Tar liten plats hopvikt och �r l�tt att ha med sig i fickan.<br>
<b>20 kr/st.</b>&nbsp;
Best�ll:<input type="checkbox" style="border:0" name="artnr[118]" value="118">&nbsp
Antal: <input type="text" size="2" name="antal[118]" value="1">
</td><td width="374"> 
<b>B�rkasse</b> med sk�rfl�ckor. Original av konstn�ren Hans Larsson. Bredd 38 
cm, h�jd 42 cm, bottenbredd 10 cm.<br>
En rej�l och stark kasse att b�ra hem mat i m.m.<br>
<b>40 kr/st.</b>&nbsp;
Best�ll:<input type="checkbox" style="border:0" name="artnr[119]" value="119">&nbsp
Antal: <input type="text" size="2" name="antal[119]" value="1">
</td>
</tr>
<tr>
<td colspan="2" align="center">
<b>OBS. Kassarna m�ste tv�ttas i kallt vatten (max. 30 grader) annars krymper de!</b>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="kassar" value="L�gg till best�llning" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="delkass" value="Radera" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Tillbaka</button>
</td>
</tr>
<tr><td colspan="2">
<?php 
 if ($best_medd<>'')
 {echo '<p align="center"><font color="blue">
  '.$best_medd.'</font>';}
?> 
</td></tr>
</table>
</form>
</center>
</div>
</body>
</html>