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
<title>T-shirts</title>
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
  if (is_numeric($antal) && $antal>0 && $storlek<>'Select')
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, size, buy) 
   VALUES ('$kund', '$artnr', '$antal', '$storlek', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
   $best_medd='Preliminary order received.<b> Order list</b> (left) shows your preliminary orders.';
  }
  else
  {$best_medd='Please fill in a valid number or size!';} 
 }
}
?>

<body class="alt_tab_bg" style="background-image: url('')">
<div align="center">
<center>
<form style="margin-bottom:0; margin-top:0" name="tshirt" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table width="720" class="alt_tab_bg" cell-spacing="0" background="../bilder/blaa_2.jpg" cellpadding="10"
       style="color:#000080">
	<tr>
	<td colspan="2">
	<b><font size="2">T-shirts.</font><br>
	Sizes: Small, Medium, Large, X-Large och XX-Large.<br>
	Order by marking the checkbox and fill in quantity and size for each item.<br>
	Then, click &quot;Add order&quot; at the bottom of the page.</b>
	<?php 
	 if ($best_medd<>'')
	 {echo '<p>&nbsp;&nbsp;
	  '.$best_medd;}
	?> 
	</td>
	</tr>
	<tr>
	<td><img border="0" src="../bilder/diverse/tshirt_svart_hel.jpg" width="345" height="300"></td>
	<td><img border="0" src="../bilder/diverse/tshirt_vit_hel.jpg" width="345" height="300"></td>
</tr>
<tr>
 	<td><img border="0" src="../bilder/diverse/tshirt_wings_hel.jpg" width="345" height="318">
 	</td>
	<td>Upper left:<br>
	<b>T-shirt, black with Buzzard-logo</b><br><b>SEK 90.00 apiece.</b><br>
	Order:<input type="checkbox" style="border:0" name="artnr[27]" value="27">&nbsp
	Qty.: <input type="text" size="2" name="antal[27]" value="1">&nbsp;
	Size: <select name="storlek[27]">
	<option selected>Select</option>
	<option value="S">Small</option>
	<option value="M">Medium</option>
	<option value="L">Large</option>
	<option value="XL">X-large</option>
	<option value="XXL">XX-large</option>
	</select></p>
	<p>Above:<br>
	<b>T-shirt, white with Buzzard-logo</b><br><b>SEK 90.00 apiece.</b><br>
	Order:<input type="checkbox" style="border:0" name="artnr[28]" value="28">&nbsp
	Qty.: <input type="text" size="2" name="antal[28]" value="1">&nbsp;
	Size: <select name="storlek[28]">
	<option selected>Select</option>
	<option value="S">Small</option>
	<option value="M">Medium</option>
	<option value="L">Large</option>
	<option value="XL">X-large</option>
	<option value="XXL">XX-large</option>
	</select>
	</p>
	<p>Left: <br>
	<b>T-shirt, white with Red and Black Kite</b><br>(from original paiting by Hans Larsson).<br>	 
	<b>SEK 150.00 apiece.</b><br>
	Order:<input type="checkbox" style="border:0" name="artnr[29]" value="29">&nbsp
	Qty.: <input type="text" size="2" name="antal[29]" value="1">&nbsp;
	Size: <select name="storlek[29]">
	<option selected>Select</option>
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
<input type="submit" name="trojor" value="Add order" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="deltroja" value="Reset" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Back</button>
<?php 
 if ($best_medd<>'')
 {echo '<p align="center">
  '.$best_medd;}
?> 
</td>
</tr>
</table>
</form>
</center>
</div>
</body>
</html>