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
<title>Tea&nbsp; and coffee cups</title>
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
if (isset($_REQUEST['muggar']) && !empty($_REQUEST['artnr']))
//administrera best�llning
//kolla efter ikryssade checkboxar
{foreach ($_REQUEST['artnr'] AS $id => $artnr) 
 {$antal=$_REQUEST['antal'][$id];
  if (is_numeric($antal) && $antal>0)
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, buy) VALUES ('$kund', '$artnr', '$antal', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
   $best_medd='Preliminary order received.<b> Order list</b> (left) shows your preliminary orders.';
  }
  else
  {$best_medd='Please fill in a valid number!';}
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
<b><font style="font-size:12px">Cotton Bags.</font></b><br>
Order by marking the checkbox and fill in quantity for each item.<br>
Then, click &quot;Add order&quot; at the bottom of the page.
<?php 
 if ($best_medd<>'')
 {echo '<p><font color="blue">
  '.$best_medd.'</font>';}
?> 
</td>
</tr>
<tr><td colspan="2">
<img class="Bildram3" src="../bilder/diverse/kassarna.jpg" alt="" width="700">
</td></tr>
<tr><td width="326">
<b>Cotton Bag</b> with Pied Avocet. Original by Artist Hans Larsson. Width: 38 cm, height: 42 cm.<br>
Easily folded and carried in your pocket when not in use.<br>
<b>SEK 20.00 apiece.</b>&nbsp;
Order:<input type="checkbox" style="border:0" name="artnr[118]" value="118">&nbsp
Qty.: <input type="text" size="2" name="antal[118]" value="1">
</td><td width="374"> 
<b>Cotton bag</b> with Pied Avocet. Original by Artist Hans Larsson. Width: 38 cm, height: 42 cm, bottom width: 10 cm.<br>
A strong bag for your shopping at the supermarket.<br>
<b>SEK 40.00 apiece.</b>&nbsp;
Order:<input type="checkbox" style="border:0" name="artnr[119]" value="119">&nbsp
Qty.: <input type="text" size="2" name="antal[119]" value="1">
</td>
</tr>
<tr>
<td colspan="2" align="center">
<b>N.B. The bags must be washed in cold water (max. 30 degr. C) or they will shrink considerably!</b>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="muggar" value="Add order" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="delmugg" value="Reset" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Back</button>
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