<?php
session_start();
$_SESSION['kundnr']=session_id();
$kund=$_SESSION['kundnr'];
require_once "../incl_filer/db_connect_skofsales.php"; //databasanslutning
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Your order</title>
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
<p><b>PRELIMINARY ORDER.</b></p>
<p>Check which items you have ordered and confirm, adjust or cancel your order.<br>
  After confirming you will be asked to fill in your name, address and email and then the order will be sent to 
  the Bird Observatory. We will deliver your items as soon as possible. 
  <br>You pay as per invoice, which is sent along with the ordered items.</p>
<?php
//bekräfta beställning
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

//ändra eller radera markerad artikel
elseif (isset($_REQUEST['andrad'])) //FORMULÄRET ÄNDRA/RADERA
//kolla efter ikryssade checkboxar
//gör formulär där man kan ändra
{if (isset($_REQUEST['andra']))
 {echo '<form name="artandr" method="POST" action="'.$_SERVER['PHP_SELF'].'">
  <table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead">
  <td colspan="6">
  Adjust order(s) for the following item(s):
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Qty.</td><td width="360">Item</td><td>Size</td><td>&nbsp;</td>
  <td align="right">Apiece</td><td align="right">Total</td></tr>';
  $farg='#FFFFFF';
  foreach ($_REQUEST['andra'] AS $andrpost) //VISAR POSTER SOM SKA ÄNDRAS
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
    <td>'.$row['item'].'</td>';
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
    echo '<td>SEK</td>
    <td align="right">'.$row['pris'].'</td>
    <td align="right">'.$row['summa'].'</td>
    </tr>';
   }
  } 
  echo '</table>
  <input type="submit" name="uppdatera" value="Update" class="submit"
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

// visa beställning
$sql_best="SELECT * , (varukorg.antal*varor.pris) AS summa from varor, varukorg
WHERE varukorg.kundnr='$kund'
AND varukorg.artnr=varor.artnr
ORDER by varukorg.artnr";
$query_best=mysqli_query($connect, $sql_best) or die (mysqli_error($connect));

//HÄR BÖRJAR VISNINGEN AV SIDAN DÅ ENDAST BEST VISAS

if (mysqli_num_rows($query_best)==0)
 {echo '<b>You have not ordered anything.</b>';
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
  Your preliminary order:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Qty.</td>
  <td width="360">Item</td>
  <td>Size</td>
  <td width="15">&nbsp;</td>
  <td align="right">Apiece</td><td align="right">Total</td><td>Adjust</td><td>Delete</td>
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
    <td width="360">'.$row['item'].'</td>
    <td>'.$row['size'].'</td>
    <td width="15" align="right">SEK</td>
    <td align="right">'.$row['pris'].'</td>
    <td align="right">'.$row['summa'].'</td>
    <td align="center"><input type="checkbox" style="border:0" name="andra['.$row['korgID'].']" 	
    value="'.$row['korgID'].'"></td>
    <td align="center"><input type="checkbox" style="border:0" name="radera['.$row['korgID'].']"
    value="'.$row['korgID'].'"></td>
    </tr>';
    $totalt=$totalt+$row['summa'];
  }
  echo '<tr class="tablehead">
  <td colspan="2">&nbsp;</td>
  <td colspan="3" align="right">All in all (SEK):</td><td align="right">'.$totalt.'.00</td>
  <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="alt_tab_bg"><td colspan="6" align="right">
  N.B. Postage is extra.</td><td colspan="2">&nbsp;</td>
 </tr>  
  </table>';
 echo '<p>
 <input type="submit" name="bekrafta" value="Confirm order" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="andrad" value="Adjust/Delete" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="tabort" value="Cancel" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></p>
 </form>';
 }
// bekräftad beställning och fyll i adressuppgifter
elseif (isset($_REQUEST['bekrafta']) || isset($_REQUEST['omstart'])) 
 {echo
  '<table cellpadding="3" cellspacing="0" width="600">
  <tr class="tablehead">
  <td colspan="6">
  You have confirmed an order for the items listed below:
  </td></tr>	  
  <tr class="tablehead">
  <td width="33" align="right">Qty.</td><td width="360">Item</td><td>Size</td><td>&nbsp;</td>
  <td align="right">Apiece</td><td align="right">Total</td></tr>';
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
    <td width="360">'.$row['item'].'</td>
    <td>'.$row['size'].'</td>
    <td>SEK</td>
    <td align="right">'.$row['pris'].'</td>
    <td align="right">'.$row['summa'].'</td>
    </tr>';
    $totalt=$totalt+$row['summa'];
  }
  echo '<tr class="tablehead">
  <td colspan="2">&nbsp;</td>
  <td colspan="3" align="right">All in all (SEK):</td><td align="right">'.$totalt.'.00</td>
  </tr>
  <tr class="alt_tab_bg"><td colspan="6" align="right">
  N.B. Postage is extra.</td></tr>  
  </table>';
 ?>
<p>N.B. You may still add new items, your order is not definite until sent.</p> 
<form name="person" method="POST" action="orderpage.php">
<table cellpadding="3" cellspacing="0" width="600" class="alt_tab_bg">
<tr class="tablehead">
<td colspan="4">Please fill in your name and address:</td>
</tr>
<td width="100">Lastname:*</td>
<td width="200"><input type="text" size="30" name="enamn"></td>
<td width="100">Firstname:*</td>
<td width="200"><input type="text" size="30" name="fnamn"></td>
</tr>
<tr>
<td width="100">Street address:*</td>
<td width="200"><input type="text" size="30" name="gata"></td>
<td width="100">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="100">Post code:*</td>
<td width="200"><input type="text" size="10" name="postnr"></td>
<td width="100">Town etc.:*</td>
<td width="200"><input type="text" size="30" name="ort"></td>
</tr>
<tr>
<td width="100">Country:</td>
<td width="200"><input type="text" size="30" name="land"></td>
</tr>
<tr>
<td width="100">E-mail:*</td>
<td width="200"><input type="text" size="30" name="epost"></td>
</tr>
</table>
<p>
 <input type="submit" name="Skicka" value="Submit order" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 <input type="submit" name="rensa" value="Cancel order" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
</p>
</form>
<?php
}
?> 
</body>
</html>
