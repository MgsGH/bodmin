<?php
session_start();
$_SESSION['kundnr']=session_id();
$kund=$_SESSION['kundnr'];
$best_medd='';
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/incl_filer/connect_new.php';
$connect = getSQLIConnection();

// variabler som anger språk resp. varukategori

$lan=$_REQUEST['sprak'];
$varukat=$_REQUEST['kat'];

// ta ut varukategori
$sql_kat="select * from sortiment WHERE katnr=$varukat";
$query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));

// ta ut varor i kategorin - böcker och DVD sorteras efter utgivningsår t.v.
//här måste urval av varubenämn på resp. språk göras
if ($varukat==2 || $varukat==9 || $varukat==10)
{
 if ($lan=='sve') 
 { 
  if (!isset($_REQUEST['RA1']) || $_REQUEST['RA1']=='V1')
  {
   $sql_all="select * from varor WHERE katnr=$varukat ORDER BY utg_ar DESC, artnr DESC";
  }
  else
  {
   $sql_all="select * from varor WHERE katnr=$varukat ORDER BY artikel";
  }
 }
 else
 {
  if (!isset($_REQUEST['RA1']) || $_REQUEST['RA1']=='V1')
  {
   $sql_all="select * from varor WHERE katnr=$varukat AND item<>'' ORDER BY utg_ar DESC, artnr DESC";
  }
  else
  {
   $sql_all="select * from varor WHERE katnr=$varukat AND item<>'' ORDER BY item";
  }
 } 
}
else
{
 if (lan=='sve')
 {
  $sql_all="select * from varor WHERE katnr=$varukat";
 }
 else
 {
  $sql_all="select * from varor WHERE katnr=$varukat AND item<>''";
 } 
} 

echo $sql_all;

$query_all=mysqli_query($connect, $sql_all) or die (mysqli_error($connect));
// skapa variabler för kategoridata att visa på sidan
while ($row = mysqli_fetch_assoc($query_kat))
{
 if ($lan=='sve')
 {
 $headline=$row['kat_s'];
 $ingress=$row['ingr_s'];
 $bestinfo='<b>Beställning sker genom att kryssa i rutan och ange antal vid resp. artikel.<br>
 Klicka sedan på "Lägg till beställning" längst ned på sidan.</b>';
 $bildinfo=$row['txt_u_bild'];
 $tblhuvud='<td width="505">Artikel</td><td width="75">Pris</td><td width="75">Beställ</td>
 <td width="75">Antal</td>';
 $best='Beställ:';
 $ant='Antal: ';
 $bestknapp='Lägg till beställning';
 $resetknapp='Radera';
 $backknapp='Tillbaka';
//variabler för omsortering av boklista
 $var_sort='Sortera listan efter: ';
 $var_V1='UTGIVNINGSÅR (förinställt)';
 $var_V2='TITEL (alfabetiskt)';
 $var_knapp='Ändra';
 }
 else
 {
 $headline=$row['kat_e'];
 $ingress=$row['ingr_e'];
 $bestinfo='<b>Order by marking the checkbox and fill in quantity for each item.<br>
    Then, click "Add order" at the bottom of the page.</b>';
 $bildinfo=$row['txt_u_pict'];
 $tblhuvud='<td width="505">Item</td><td width="75">Price (SEK)</td><td width="75">Order</td>
 <td width="75">Qty.</td>';
 $best='Order:';
 $ant='Qty: ';
 $bestknapp='Add order';
 $resetknapp='Reset';
 $backknapp='Back';
 //variabler för omsortering av boklista
 $var_sort='Sort the list by: ';
 $var_V1='RELEASE YEAR (preselected)';
 $var_V2='TITLE (alphabetic)';
 $var_knapp='Switch';
 }
 $imgmap=$row['bildmapp'];
 $katimg=$row['kat_bild'];
 if ($row['websajt']=='')
 {
 $upper_img='<img border="0" alt="" src="bilder/'.$imgmap.'/'.$katimg.'" align="top">';
 }
 else
 {
 $upper_img='<a target="_blank" href="http://'.$row['websajt'].'">
 <img border="0" alt="" src="bilder/'.$imgmap.'/'.$katimg.'" align="top"></a>';
 }
}
?>
<!--
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Varusida</title>
<LINK REL=STYLESHEET HREF="../bluemall.css" TYPE="text/css">
<script type="text/javascript" language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript" language="JavaScript">
<!--
  var ol_width=100; //sätter bredden på popuprutan
//-->
</script>
<script type="text/javascript" language="JavaScript">
function fonster(URL)
{
//url är sökvägen till filen som öppnas i fönstret linkfonster
var oppna = open(URL, 'kikfonster', 'directories=no,location=no,menu=no,status=no,toolbar=no,scrollbars=yes,resizable=yes,width=550,height=550,top=100,left=288')
}
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
if (isset($_REQUEST['bestall']) && !empty($_REQUEST['artnr']))
{
//administrera beställning
//kolla efter ikryssade checkboxar
 foreach ($_REQUEST['artnr'] AS $id => $artnr) 
 {$antal=$_REQUEST['antal'][$id];
  if (is_numeric($antal) && $antal>0)
  {$sql_in="INSERT INTO varukorg (kundnr, artnr, antal, buy) VALUES ('$kund', '$artnr', '$antal', 'N')";
   mysqli_query($connect, $sql_in) or die (mysqli_error($connect));
   if ($lan=='sve')
   {
    $best_medd='Prel. beställning mottagen.<b> Beställningslista</b> t.v. visar alla dina prel. beställningar.';
   } 
   else
   {  
    $best_medd='Preliminary order received.<b> Order list</b> (left) shows your preliminary orders.';
   }
  }
  else
  {if ($lan=='sve')
   {
    $best_medd='Du måste ange ett giltigt antal!';
   }
   else
   {
    $best_medd='Please fill in a valid number!';
   } 
  }
 }
}
?>
<body style="background: #E1E8F7">
<div width="760px" margin="auto">
<form style="margin-bottom:0; margin-top:0" name="urval" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<table width="730" class="alt_tab_bg" cellspacing="0" cellpadding="5" border="0" align="center">
<tr>
<td valign="top" colspan="2">
<p style="margin-top: 0; margin-bottom: 0">
<?php
echo '<b><font size="2">'.$headline.'</font></b><br>'.$ingress;
?>	
<p style="margin-top: 3; margin-bottom: 3">
<?php echo $bestinfo;?>
</p>
<?php
/*
if ($varukat==2 || $varukat==10)  
{
 echo '<form method="POST" action="allavaror.php">
 <p>'.$var_sort.' 
 <input type="radio" style="border:0" checked name="RA1" value="V1">'.$var_V1.'</input>
 <input type="radio" style="border:0" name="RA1" value="V2">'.$var_V2.'</input></p>
 <p align="center">
 <input type="submit" value="'.$var_knapp.'" class="submit" name="B1"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></input> 
 </p></form>';
}
*/
?> 
 <td align="right" valign="top" width="181" colspan="2">
	<?php echo $upper_img; ?> 
    <p class="litentext">
	<?php echo $bildinfo; ?></p>
	</td>
	</tr>
	<tr class="tablehead">
	<?php echo $tblhuvud; ?>
	</tr>	
	<?php
	while ($row = mysqli_fetch_assoc($query_all))
    {$minibild='<img alt=Saknas. src=bilder/'.$imgmap.'/'.$row['artnr'].'_mini.jpg>';
	 if ($lan=='sve')
     {
	  echo '<tr><td width="505">
      <a href="javascript:fonster(\'varuspec.php?artikel='.$row['artnr'].'&artkat='.$varukat.'&lan='.$lan.'\')"
      onMouseOver="overlib(\''.$minibild.'\')" onMouseOut="nd()"><b>'.$row['artikel'].'</b></a>
	  </td>
	  <td width="75">'.number_format($row['pris'], 0, '', ' ').' kr.
	  </td>';
     } 
     else
     {
	  echo '<tr><td width="505">
      <a href="javascript:fonster(\'varuspec.php?artikel='.$row['artnr'].'&artkat='.$varukat.'&lan='.$lan.'\')"
      onMouseOver="overlib(\''.$minibild.'\')" onMouseOut="nd()"><b>'.$row['item'].'</b></a>
	  </td>
	  <td width="75">'.number_format($row['pris'], 2, '.', ',').'
      </td>';
     }  
     echo ' 
	 <td width="75">'.$best.'<input type="checkbox" style="border:0" name="artnr['.$row['artnr'].']" value="'.$row['artnr'].'"></td>
	 <td width="75">'.$ant.'<input type="text" size="2" name="antal['.$row['artnr'].']" value="1"></td></tr>';
    }
    ?>
</tr>
<tr>
<td colspan="4" align="center">
<input type="submit" name="bestall" value="<?php echo $bestknapp; ?>" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">
<input type="reset" name="delmus" value="<?php echo $resetknapp; ?>" class="submit"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'">&nbsp;
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'"><?php echo $backknapp; ?></button>
<?php 
 if ($best_medd<>'')
 {echo '<p align="center">'.$best_medd;}
?>
</td>
</tr>
</table>
</form>
</div>
</body>

</html>