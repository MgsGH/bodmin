<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/incl_filer/connect_new.php';
$connect = getSQLIConnection();


//AUTOMATISK VISNING av de senast inlagda artiklarna.
//Ta ut de ett J�MNT antal (2, 4, 6 etc.) artiklar.
$sql_senaste="SELECT *, sortiment.bildmapp FROM varor, sortiment WHERE varor.katnr=sortiment.katnr ORDER BY varor.artnr DESC LIMIT 6";
$query_senaste=mysqli_query($connect, $sql_senaste) or die (mysqli_error($connect));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd"> --> 
<html lang="sv">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="content-style-type" content="text/css">
<meta name="author" content="FF">
<meta name="keywords" content="">
<meta http-equiv="imagetoolbar" content="no">
<title>Skyltf�nster</title>
<link rel="stylesheet" href="../bluemall.css" type="text/css">
<script type="text/javascript" language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript" language="JavaScript">
  var ol_width=150;
</script>
<base target="_self">
</head>

<body style="background: #E1E8F7">
<div  style="width: 770px; padding: 10px; margin: auto">
<table width="750px" cellpadding="10px" class="alt_tab_bg" align="center">
<tr><td align="center" colspan="2"><b><font size="2"><p><b>Senaste nytt i sortimentet. Klicka f�r mer info/best�llning.</b></td></tr>
<?php
$antal=4;
//r�knare f�r radskifte
$rtd=1;
while ($row=mysqli_fetch_assoc($query_senaste))
{
 if ($rtd==1)
 {echo '<tr><td align="center">';}
 else
 {echo '<td align="center">';}
 $varunr=$row['artnr'];
 $katnr=$row['katnr'];
 $varubild=$varunr.'_stor.jpg';
 $mapp=$row['bildmapp'];
 $bubbla=$row['artikel'].' '.$row['pris'].' kr. '.$row['extra_s'];
 echo '<a href="allavaror.php?sprak=sve&kat='.$katnr.'">
 <img border="0" src="bilder/'.$mapp.'/'.$varubild.'" alt="" 
 onMouseover="overlib(\''.$bubbla.'\')"
 onMouseout="nd()"></a></td>';
 if ($rtd==2)
 {echo '</tr>';
  $rtd=1;}
 else
 {$rtd=2;}
}
?>
</table>
</div>
</body>
</html>
