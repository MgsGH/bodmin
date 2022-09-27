<?php
include "../incl_filer/db_connect_skofsales.php"; //databasanslutning

//variabler för skickade artikelnr, varukategori och språk

$kategori=$_REQUEST['artkat']; //kategorinr
$modell=$_REQUEST['artikel'];  //artikelnr
$sprak=$_REQUEST['lan'];       //sve eng

//ta ut kategori ger bildmapp
$sql_kate="select * from sortiment WHERE katnr='$kategori'"; //en post
$query_kate=mysqli_query($connect, $sql_kate) or die (mysqli_error($connect));

// ta ut artikeln i kategorin ger artnr, katnr, item, spectext_s+e, pris
$sql_artikel="select * from varor WHERE artnr='$modell'"; //en post
$query_artikel=mysqli_query($connect, $sql_artikel) or die (mysqli_error($connect));

//skapa variabler som fungerar för alla varor
while ($row=mysqli_fetch_assoc($query_kate))
{
 $imgmap=$row['bildmapp'];
}
while ($row=mysqli_fetch_assoc($query_artikel))
{
 if ($sprak=='sve')
 {
  $rad_1='<p align="center"><b>'.$row['artikel'].'<br>  
  Pris: '.number_format($row['pris'], 0, '', ' ').' kr.</b></p>';
  $spectext=$row['spectext_s'].'<br>'.$row['extra_s'];
  $backtext='Stäng fönstret'; 
 }
 else
 {
  $rad_1='<p align="center"><b>'.$row['item'].'<br> 
  Price: SEK '.number_format($row['pris'], 2, '.', ',').'</b></p>';
  $spectext=$row['spectext_e'].'<br>'.$row['extra_e'];
  $backtext='Close window';
 }
// ingen bildram runt böcker och musmattor
 if ($kategori==2 || $kategori==5 || $kategori==10)
 {
 $visastorbild='<p align="center"><img alt="" src="bilder/'.$imgmap.'/'.$row['artnr'].'_stor.jpg"></p>';
 }
 else
 {
 $visastorbild='<p align="center"><img alt="" src="bilder/'.$imgmap.'/'.$row['artnr'].'_stor.jpg" class="bildram2"></p>';
 }
}
// specialfall: kikare
if ($kategori==8)
{$sql_kikfakt="SELECT * from kikarfakta WHERE artnr='$modell'";
 $query_kikfakt=mysqli_query($connect, $sql_kikfakt) or die (mysqli_error($connect));
//skapa variabler för sve resp eng sidor
 while ($row=mysqli_fetch_assoc($query_kikfakt))
 {if ($sprak=='sve')
  {$specrubr='Specifikationer:<br>';
   $spec_1='Förstoring: '.$row['ggr'].' ggr.';
   $spec_2='Objektivdiameter: '.$row['obj'].' mm.';
   $spec_3='Närgräns: '.$row['nargrans'].' m.';
   $spec_4='Synfält: '.$row['synfalt'].' m.';
   $spec_5='Höjd: '.$row['hojd'].' mm.';
   $spec_6='Bredd: '.$row['bredd'].' mm.';
   $spec_7='Vikt: '.$row['vikt'].' g.';
   $spec_8='Garanti: '.$row['gar'].' år.';
  }
 else
  {$specrubr='Specifications:<br>';
   $spec_1='Magnification: '.$row['ggr'].'x';
   $spec_2='Objective lens diameter: '.$row['obj'].' mm.';
   $spec_3='Min. focus: '.$row['nargrans'].' m.';
   $spec_4='Field of view: '.$row['synfalt'].' m.';
   $spec_5='Height: '.$row['hojd'].' mm.';
   $spec_6='Width: '.$row['bredd'].' mm.';
   $spec_7='Weight: '.$row['vikt'].' g.';
   $spec_8='Warranty: '.$row['gar'].' years.';
  }
 }
}
//visa
?>
<!--
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Specifikation</title>
<link rel=stylesheet href="../bluemall.css" type="text/css">
</head>

<body>
<table width="500" class="alt_tab_bg" cellspacing="0" cellpadding="5" border="0" align="center">
<tr>
<td colspan="3">
<?php
//visar sidan
echo $rad_1;
echo $visastorbild;
echo $spectext;
if ($kategori==8)
{echo '</td></tr><tr><td>';
//tabell som visar specdata
 echo '<table width="490" style="border: 0" cellspacing="0" cellpadding="0" align="center" class="alt_tab_bg">
 <tr><td colspan="3">';
 echo $specrubr;
 echo '</td></tr><tr><td>';
 echo $spec_1.'</td><td>';echo $spec_2.'</td><td>';echo $spec_3.'</td></tr><tr><td>';
 echo $spec_4.'</td><td>';echo $spec_5.'</td><td>';echo $spec_6.'</td></tr><tr><td>';
 echo $spec_7.'</td><td>';echo $spec_8;
}
?>
</td>
</tr>
</table>
</td></tr></table>
<p align="center">
<button style="width:165px"OnClick="javascript:window.close()"
 onMouseOver="this.style.color='blue'" 
 onMouseOut="this.style.color='#FFFFFF'"><?php echo $backtext; ?></button>
</p>  
</body>
</html>
