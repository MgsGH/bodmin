<?php
if ($_REQUEST['sprak']=='sve')
{
$overskrift='VÄLKOMMEN till Fyrshopen - utställning och butik i Falsterbo Fyr.';
$text='Under veckosluten från slutet av augusti till slutet av oktober är Fyrshopen öppen ca. 
kl. 09:00-13:00. I Fyrshopen har vi ungefär samma sortiment som på webplatsen och dessutom finns 
oftast kaffe och nybakade kanelbullar.<br>
I anslutning till butiken finns också en mindre skärmutställning om fågelflyttning.
Utställningen kommer att uppdateras och utökas löpande under den närmaste framtiden med 
fler skärmar och även med digitala inslag.';
$bildtext_1='En del av butiken 2011.<br>Foto: Björn Malmhagen.';
$bildtext_2='Antikhörnan - nytt 2010.<br>Foto: Sophie Ehnbom.';
$bildtext_3='En del av utställningen.<br>Foto: Sophie Ehnbom.';
$bildtext_4='Monter om ringmärkning.<br>Foto: Sophie Ehnbom.';
$bildtext_5='Mera utställning.<br>Foto: Sophie Ehnbom.';
$knapptext='Tillbaka';
}
else
{
$overskrift='WELCOME to the Lighthouse Shop - in the Falsterbo Lighthouse.';
$text='The Lighthouse Shop is open  between 9 am. and 1 pm. during weekends from late August to 
late October. The shop has about the same selection of items as the web shop. Most days we also 
sell tea, coffee and the famous cinnamon buns (fresh from the oven).<br>
Adjacent to the shop is a minor exhibition about bird migration. The exhibition will be continously 
enlarged during the next two years. New posters will be added along with some digtial screens.';
$bildtext_1='Part of the shop 2011.<br>Photo: Björn Malmhagen.';
$bildtext_2='Antiques Corner - new in 2010.<br>Photo: Sophie Ehnbom.';
$bildtext_3='Part of the exhibition.<br>Photo: Sophie Ehnbom.';
$bildtext_4='Ringing showcase.<br>Photo: Sophie Ehnbom.';
$bildtext_5='Another part of the exhibition.<br>Photo: Sophie Ehnbom.';
$knapptext='Back';

}
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Fyrshopen</title>
<LINK REL=STYLESHEET HREF="../bluemall.css" TYPE="text/css">
<script type="text/javascript" language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript" language="JavaScript">
<!--
  var ol_width=140; //sätter bredden på popuprutan
//-->
</script>
<base target="_self">
</head>

</head>

<body class="alt_tab_bg" style="background-image: url('')">
<div>
<p align="center" style="margin-bottom:3px">
<?php echo '<b>'.$overskrift.'</b>'; ?></p>
<table width="700px" class="alt_tab_bg" style="border: 0; border-collapse: collapse; 
cell-spacing: 0; cell-padding: 0" align="center">
<tr><td>
<p style="margin-top: 0px; margin-bottom:3px; font-size: 11px">
<?php echo $text; ?></p>
</td></tr>
</table>
<p style="margin-top:0px; margin-bottom:3px" align="center">
<img border="0" src="bilder/shopen/shopen_2011.jpg" alt="" width="700" height="525" class="Bildram2" 
onMouseOver="overlib('<?php echo $bildtext_1; ?>');" 
onMouseOut="nd();"></p>
<p style="margin-top: 0px; margin-bottom:3px; font-size: 11px" align="center">
&nbsp;</p>
<p style="margin-top: 0px; margin-bottom:3px; font-size: 11px" align="center">
<img border="0" src="bilder/shopen/antikhornan_SE.jpg" width="700" height="525" class="Bildram2"
onMouseOver="overlib('<?php echo $bildtext_2; ?>');" 
onMouseOut="nd();"></p>
<p style="margin-top: 0px; margin-bottom:3px; font-size: 11px" align="center">
&nbsp;</p>
<p style="margin-top: 0px; margin-bottom:3px; font-size: 11px" align="center">
<img border="0" src="bilder/shopen/ingang_SE.jpg" width="400" height="531" class="Bildram2" 
OnMouseover="overlib('<?php echo $bildtext_3; ?>');"
onMouseOut="nd();"></p>
<table align="center" width="700" class="alt_tab_bg" style="border:0; border-collapse: collapse" id="table1">
 <tr><td align="center">
 &nbsp;</td>
 <td align="center">
 &nbsp;</td></tr>
 <tr><td align="center">
 <img border="0" src="bilder/shopen/ring_monter.jpg" alt="" width="350" height="263" class="Bildram2"
 Onmouseover="overlib('<?php echo $bildtext_4; ?>');"
 onMouseOut="nd();"></td>
 <td align="center">
 <img border="0" src="bilder/shopen/skarmar.jpg" alt="" width="350" height="263" class="Bildram2"
 Onmouseover="overlib('<?php echo $bildtext_5; ?>');"
 onMouseOut="nd();"></td></tr>
</table>
</p>
<p align="center">
<button style="width: 65px" OnClick="javascript:history.back()"
onMouseOver="this.style.color='blue'" 
onMouseOut="this.style.color='#FFFFFF'"><?php echo $knapptext; ?></button>
</p>
</div>
</body>
</html>
