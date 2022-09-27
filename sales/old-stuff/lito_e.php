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
<title>Litographies</title>
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
   $best_medd='Preliminary order received.<b> Order list</b> (left) shows your preliminary orders.';
  }
  else
  {$best_medd='Please fill in a valid number!';} 
 }
}
?>
<body class="alt_tab_bg" style="background-image: url('')">
<div align="center">
<center>
<b>Litographies</b> for the support of Falsterbo Bird Observatory.<br>
<span style="font-size: 11px">The Litographies are numbered och signed by the artist. 
Delivered in cardboard tubes. <br>
Order by marking the checkbox and fill in quantity for each item.<br>
Then, click &quot;Add order&quot; at the bottom of the page.
<?php 
 if ($best_medd<>'')
 {echo '<p><font color="blue">
  '.$best_medd.'</font>';}
?> 
</span></p>
<form style="margin-bottom:0; margin-top:0" name="lito" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table width="760" class="alt_tab_bg" style="border:0; border-collapse: collapse" id="table1">
 <tr><td>
 <img border="0" src="../bilder/diverse/lito_brus.jpg"
  align="left" hspace="5" style="border: 10px ridge #F2F2F3" width="353" height="250">
 </td>
 <td>
 <img border="0" src="../bilder/diverse/lito_fjeld.jpg"
  align="left" hspace="5" style="border: 10px ridge #F2F2F3" width="317" height="250">
 </td></tr>
 <tr><td> 
 <p align="center"><br>
 <b>Gunnar Brusewitz: Migrating Brent Geese.</b><br>
    Year of publication: 1990.<br>
    Picture size: 38x25 cm.<br>
 <b>SEK 900.00 apiece.</b><br>
 Order:<input type="checkbox" style="border:0" name="artnr[1]" value="1">&nbsp
 Qty.: <input type="text" size="2" value="1" name="antal[1]">
 </td><td>
 <p align="center"><br>
 <b>Jon Fjelds�: Pied Avocets.</b><br>
    Year of publication: 1982.<br>
    Picture size: 35x27 cm.<br>
 <b>SEK 200.00 apiece.</b><br>
 Order:<input type="checkbox" style="border:0" name="artnr[2]" value="2">&nbsp
 Qty.: <input type="text" size="2" value="1" name="antal[2]">
 </td>
 </tr>
</table>
<input type="submit" name="litos" value="Add order" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="dellito" value="Reset" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">Back</button>
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
