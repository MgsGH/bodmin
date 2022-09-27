<?php
require_once "../incl_filer/db_connect_skofsales.php"; //databasanslutning
//AUTOMATISK VISNING PÅ NYHETSSIDAN
//Ta ut de TRE senast inlagda posterna.
$sql_senaste="SELECT *, sortiment.bildmapp FROM varor, sortiment 
WHERE varor.katnr=sortiment.katnr ORDER BY varor.artnr DESC LIMIT 3";
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
<title>test av autouppdat</title>
<link rel="stylesheet" href="../bluemall.css" type="text/css">
<script type="text/javascript" language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript" language="JavaScript">
  var ol_width=100;
</script>
</head>

<body>
<div  style="width: 770px; background-color: #FFFFFF; padding: 10px; margin: auto">
<?php
while ($row=mysqli_fetch_assoc($query_senaste))
{
echo '<p style="margin-top: 3px; margin-bottom: 6px;" align="center">';
$varunr=$row['artnr'];
$varubild=$varunr.'_mini.jpg';
$mapp=$row['bildmapp'];
$bubbla=$row['artikel'].' '.$row['pris'].' kr. '.$row['extra_s'];
echo '<img border="0" src="bilder/'.$mapp.'/'.$varubild.'" alt="" 
 onmouseover="overlib(\''.$bubbla.'\')"
 onmouseout="nd()"></p>';
}
?>
</div>
</body>
</html>
