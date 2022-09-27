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
<title>T-tr�jor</title>
<LINK REL=STYLESHEET HREF="../bluemall.css" TYPE="text/css">
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
 margin-bottom: 0px;
}
</style>
<base target="_self">
</head>

<?php
if (isset($_REQUEST['trojor']) && !empty($_REQUEST['artnr']))
{
//administrera best�llning
//kolla efter ikryssade checkboxar
 foreach ($_REQUEST['artnr'] AS $id => $artnr) 
 {$antal=$_REQUEST['antal'][$id];
  $storlek=$_REQUEST['storlek'][$id];
  if (is_numeric($antal) && $antal>0 && $storlek<>'v�lj')
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, size, buy) 
   VALUES ('$kund', '$artnr', '$antal', '$storlek', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
   $best_medd='Prel. best�llning mottagen.<b> Best�llningslista</b> t.v. visar alla dina prel. 	best�llningar.';
  }
  else
  {$best_medd='Du m�ste ange ett giltigt antal och/eller storlek!';} 
 }
}
?>

<body class="alt_tab_bg" style="background-image: url('')">
<div align="center">
<center>
<form style="margin-bottom:0; margin-top:0" name="tshirt" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table width="720" class="alt_tab_bg" cell-spacing="0" background="Bilder/blaa_2.jpg" cellpadding="10"
style="color:#000080">
	<tr>
	<td colspan="2">
	<b><font size="2">T-tr�jor.</font><br>
	Finns i storlekarna Small, Medium, Large, X-Large och XX-large.<br>
	Best�llning sker genom att kryssa i rutan och ange antal vid resp. artikel.<br>
	Klicka sedan p� &quot;L�gg till best�llning&quot; l�ngst ned p� sidan.</b>
	<?php 
	 if ($best_medd<>'')
	 {echo '<p>&nbsp;&nbsp;'.$best_medd;}
	?> 
	</td>
	</tr>
	<tr>
	<td><img border="0" src="../bilder/diverse/tshirt_svart_hel.jpg" width="345" height="300"></td>
	<td><img border="0" src="../bilder/diverse/tshirt_vit_hel.jpg" width="345" height="300"></td></tr>
    <tr><td><img border="0" src="../bilder/diverse/tshirt_wings_hel.jpg" width="345" height="318"></td>
	<td>Ovan t.v.:<br>
	<b>T-tr�ja, svart med ormvr�ksdekal</b><br><b>90 kr/st.</b><br>
	Best�ll: <input type="checkbox" style="border:0" name="artnr[27]" value="27">
	&nbsp;Antal: <input type="text" size="2" name="antal[27]" value="1">
	&nbsp;Storlek: <select name="storlek[27]">
	<option selected>v�lj</option>
	<option value="S">Small</option>
	<option value="M">Medium</option>
	<option value="L">Large</option>
	<option value="XL">X-large</option>
	<option value="XXL">XX-large</option>
	</select></p>
	<p>Ovan:<br>
	<b>T-tr�ja, vit med ormvr�ksdekal</b><br><b>90 kr/st.</b><br>
	Best�ll: <input type="checkbox" style="border:0" name="artnr[28]" value="28">
	&nbsp;Antal: <input type="text" size="2" name="antal[28]" value="1">
	&nbsp;Storlek: <select name="storlek[28]">
	<option selected>v�lj</option>
	<option value="S">Small</option>
	<option value="M">Medium</option>
	<option value="L">Large</option>
	<option value="XL">X-large</option>
	<option value="XXL">XX-large</option>
	</select>
	</p>
	<p>T.v.: <br>
	<b>T-tr�ja, vit med r�d och brun glada</b><br>
	(efter original av Hans Larsson)<b>.&nbsp;<br>
	150 kr/st.</b>
	<br>
	Best�ll:<input type="checkbox" style="border:0" name="artnr[29]" value="29">
	&nbsp;Antal: <input type="text" size="2" name="antal[29]" value="1">
	&nbsp;Storlek: <select name="storlek[29]">
	<option selected>v�lj</option>
	<option value="S">Small</option>
	<option value="M">Medium</option>
	<option value="L">Large</option>
	<option value="XL">X-large</option>
	<option value="XXL">XX-large</option>
	</select>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="trojor" value="L�gg till best�llning" class="submit"
onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="deltroja" value="Radera" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;</font>
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Tillbaka</button>
<?php 
 if ($best_medd<>'')
 {echo '<p align="center">'.$best_medd;}
?> 
</td>
</tr>
</table>
</form>
</center>
</div>
</body>
</html>