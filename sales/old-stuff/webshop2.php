<?php
include "../incl_filer/db_connect_skofsales.php"; //databasanslutning
?>

<!--
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
-->
<html lang="sv">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="imagetoolbar" content="no">
<title>Administrera webshopen.</title>
<LINK REL=STYLESHEET TYPE="text/css" HREF="../bluemall.css">
<script type="text/javascript" language="JavaScript" src="../overlib.js">
</script>
<script type="text/javascript" language="JavaScript">
<!--
  var ol_width=165; //sätter bredden på opuprutan
//-->
</script>
<script type="text/javascript" language="JavaScript">
function fonster(URL)
{
//url är sökvägen till filen som öppnas i fönstret linkfonster
var oppna = open(URL, 'bildfonster', 'directories=no,location=no,menu=no,status=no,toolbar=no,scrollbars=yes,resizable=yes,width=550,height=450,top=150,left=288')
}
</script>
</head>

<body style="margin-top: 10px; margin-bottom: 0px; margin-left: 10px; margin-right: 10px;">
<div style="width: 980px; margin-left: auto; margin-right: auto">
<?php 
if(isset($_REQUEST['WS1']))
{
//olika urval från första formuläret.
//LÄGG TILL NY VARUKATEGORI

if ($_REQUEST['WS1']=='K1') 
{
// ta ut senaste och nästa kategorinummer
 $sql_maxkat="SELECT MAX(katnr) AS last_kat from sortiment";
 $query_maxkat=mysqli_query($connect, $sql_maxkat) or die (mysqli_error($connect));
 while ($row = mysqli_fetch_assoc($query_maxkat))
 {
  $next_katnr=$row['last_kat']+1;
 }
//INMATNINGSFORMULÄR
 echo'<form name="form_K1" method="POST" action="webshop_nytt.php">
 <table width="100%" class="alt_tab_bg" cellspacing="0" cellpadding="10">
 <tr><td colspan="2" valign="top">
 <p align="center">
 <b>LÄGG TILL NY VARUKATEGORI: --- Aktuellt kategorinr: '.$next_katnr.'</b></p>
 </td></tr>
 <tr><td colspan="2" valign="top">
 <p><b>Ange varukategori&nbsp;</b>(svensk benämning, t.ex. Dekaler):<br>
 <input name="kat_sv" type="text" size="100"></input></p>
 <p><b>Ange varukategori&nbsp;</b>(engelsk benämning, t.ex. Stickers):<br>
 <input name="kat_en" type="text" size="100"></input></p>
 </td></tr>
 <tr><td width="50%" valign="top">
 <p><b>Skriv en ingress för varukategorin&nbsp;</b>(på svenska):<br>
 <textarea name="ingr_sv" id="spec_sv" cols="60" rows="5"></textarea></p>
 </td><td width="50%" valign="top">
 <p><b>Skriv en ingress för varukategorin&nbsp;</b>(på engelska):<br>
 <textarea name="ingr_en" id="spec_en" cols="60" rows="5"></textarea></p>
 </td></tr>
 <tr><td width="50%" valign="top">
 <p><b>Skapa bildmapp</b>&nbsp;(ofta samma som kategorinamnet<br>men utan å, ä och ö):
 <input name="bildmap" type="text" size="12"></input></p>
 <p><b>Ange bildnamn&nbsp;</b>(för vinjettbild som illustrerar kategorin inkl. filtyp,<br>
 ej å, ä och ö. <b>Kom ihåg att ladda upp!</b>):&nbsp; 
 <input name="bilden" type="text" size="25"></input></p>
 </td>
 <td width="50%" valign="top">
 <p><b>Ange bildtext&nbsp;</b>(på svenska):<br>
 <input name="bildtex_sv" type="text" size="50"></input></p>
 <p><b>Ange bildtext&nbsp;</b>(på engelska):<br>
 <input name="bildtex_en" type="text" size="50"></input></p>
 </td></tr>
 <tr><td colspan="2" valign="top">
 <input name="kategoriny" type="hidden" value="'.$next_katnr.'"></input>
 <p align="center">
 <input name="send_K1" style="margin-top: 0; margin-bottom: 0" type="submit" value="Skicka" class="submit"
 onMouseOver="this.style.color=\'blue\'; overlib(\'<b>OBS. Skicka först. Ladda upp bilden därefter</b> Saknas bild - notera kategorins nummer, se ovan, och namn.\')" 
 onMouseOut="this.style.color=\'#FFFFFF\'; nd()">
 &nbsp;&nbsp;
 <input name="reset_K1" style="margin-top: 0; margin-bottom: 0" type="reset" value="Radera" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 &nbsp;&nbsp;
 <button style="width:110px" 
 OnClick="javascript:fonster(\'upload_shop.php?bildtyp=shop_kat&mapp='.$bildmap.'&num='.$next_katnr.'\')">
 <font onMouseOver="this.color=\'blue\'"
 onMouseOut="this.color=\'#FFFFFF\'">Ladda upp bild</font></button>
 &nbsp;&nbsp;
 <button style="width: 65px" OnClick="javascript:history.back()"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button></p>
 </td></tr>
 </table>
 </form>';
}
elseif ($_REQUEST['WS1']=='K2') //Ändra kategori i SORTIMENTET
{
 $kategori=$_REQUEST['katlistaK'];
 // ta ut kategorin
 $sql_kat="SELECT katnr, kat_s from sortiment WHERE katnr='$kategori'";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 while ($row = mysqli_fetch_assoc($query_kat))
 {
  $katnr=$row['katnr'];
  $kat_text=$row['kat_s'];
 }

 echo '<p align="center"><b>ÄNDRING I VARUKATEGORI</b></p>
 <p align="center">Du har valt att göra ändringar i varukategori <b>'.$kategori.' '.$kat_text.'.</b></p>
 <p align="center">
 <button style="width: 265px" OnClick="location.href=\'webshop_andra.php?katval='.$kategori.'&act=uppdatera\'"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Klicka här för att gå vidare</button></p>
 <p align="center">
 <button style="width: 265px" OnClick="javascript:history.back()"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button></p>';
}
elseif ($_REQUEST['WS1']=='K3') //Ta bort kategori i SORTIMENTET
{
 $kategori=$_REQUEST['katlistaK'];
// ta ut LISTA PÅ alla kategorier
 $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 while ($row = mysqli_fetch_assoc($query_kat))
 {
  if($row['katnr']==$kategori)
  {
   $kat_text=$row['kat_s'];
   $bildmap=$row['bildmapp'];
  }
 }
 echo '<p align="center">Du har valt att ta bort kategorin <b>'.$kat_text.'</b> med tillhörande varor och bilder.<br>
 <b>Stämmer det?</b><br>
 <span style="color: red"><b>OBS. Åtgärden går inte att ångra!</b></span>
 <form name="tabortkat" method="post" action="webshop_tabort.php">
 <input name="kategorival" type="hidden" value="'.$kategori.'"></input>
 <input name="kategoritxt" type="hidden" value="'.$kat_text.'"></input>
 <input name="tabell" type="hidden" value="SORTIMENT"></input>
 <input name="bildmapp" type="hidden" value="'.$bildmap.'"></input>
 <input name="send_K3" style="margin-top: 0; margin-bottom: 0; width: 65px" type="submit" value="Ja" class="submit"
 onMouseOver="this.style.color=\'blue\'; overlib(\'<b>OBS. Raderar kategorin med alla varor från databasen!</b>\');" 
 onMouseOut="this.style.color=\'#FFFFFF\', nd();">
 &nbsp;&nbsp;
 <button style="width: 65px" OnClick="javascript:history.back()"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Nej</button>
 </form></p>';
}
elseif ($_REQUEST['WS1']=='V1') //Lägg till poster i VARULISTAN
{
//fyll i nästa formulär Specifikt för varje kategori
//ta ut senaste och nästa artikelnummer
 $sql_maxnr="SELECT MAX(artnr) AS last_itemnr from varor";
 $query_maxnr=mysqli_query($connect, $sql_maxnr) or die (mysqli_error($connect));
 while ($row = mysqli_fetch_assoc($query_maxnr))
 {
  $next_itemnr=$row['last_itemnr']+1;
 }
 $kategori=$_REQUEST['katlistaV']; //kategorinummer
// ta ut LISTA PÅ alla kategorier
 $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 while ($row = mysqli_fetch_assoc($query_kat))
 {
  if($row['katnr']==$kategori)
  {
   $kat_text=$row['kat_s'];
   $bildmap=$row['bildmapp'];
  }
 }
//rubriker och anvisningar
 if ($kategori==1) //litografier
 {
  $titel_s='Benämning:';
  $titelanvis_s='Skrivs: Litografi. Konstnärens namn.';
  $titel_e='Engelsk benämning:';
  $titelanvis_e='Skrivs: Litography. Konstnärens namn.';
 }
 elseif ($kategori==2 || $kategori==10) //böcker resp. äldre böcker
 {
  $titel_s='Titel:';
  $titelanvis_s='Skrivs: Titel. (utgivningsår) Författare. (ex. L. Karlsson. Finns  flera förf. skrivs m.fl.)';
  $titel_e='Engelsk titel (bara om det är en bok helt på engelska eller med  sammanfattning, tabell- eller figurtexter på engelska.):';
  $titelanvis_e='Skrivs: Titel. (utgivningsår) Författare. (ex. L. Karlsson. Finns  flera förf. skrivs et al.)<br>
  OBS. Översätt inte. Förklara i specifikationen nedan i stället.';
 }
 elseif ($kategori==9) //filmer
 {
  $titel_s='Titel:';
  $titelanvis_s='Skrivs: Titel. (utgivningsår).';
  $titel_e='Engelsk titel:';
  $titelanvis_e='Skrivs: Titel. (utgivningsår). OBS. Översätt inte. Förklara i specifikationen nedan i stället.';
 }
 else //övriga kategorier
 {
  $titel_s='Benämning:';
  $titelanvis_s='Skriv t.ex. Vykort, rördrom. T-tröja, vit med rördrom. osv.';
  $titel_e='Engelsk benämning:';
  $titelanvis_e='Skrivs t.ex. Postcard, Great Bittern. T-shirt, white with Great Bittern. osv.';
 }

//konstnärer författare och fotografer
 if ($kategori==1) //Litografier
 {$forftext='Konstnär:';}
 elseif ($kategori==2 || $kategori==10) //Böcker
 {$forftext='Författare/redaktör(er):';}
 elseif ($kategori==7) //Vykort
 {$forftext='Fotograf:';} 

 echo '<form name="form_V1" method="POST" action="webshop_nytt.php">
 <table width="100%" class="alt_tab_bg" cellspacing="0" cellpadding="10">
 <tr><td colspan="2" valign="top">';
 echo '<p align="center">
 <b>LÄGG TILL NYA VAROR --- Varukategori: '.strtoupper($kat_text).' --- Aktuellt artikelnr: '.$next_itemnr.'</b></p>';
 echo'<p><b>'.$titel_s.'</b><br><input name="stitel" type="text" size="100"></input><br>
 '.$titelanvis_s.'</p>
 <p><b>'.$titel_e.'
 </b><br><input name="etitel" type="text" size="100"><br>
 '.$titelanvis_e.'</p>';
 if ($kategori==1 || $kategori==2 || $kategori==9 || $kategori==10)
 {
  echo '<p><b>Utgivningsår:</b> <input name="rel_year" type="text" size="4"></input> Anges här för sorteringsändamål.';
  if ($kategori==9)
  {
   echo '&nbsp;&nbsp;<b>Längd (minuter):</b> <input name="filmlength" type="text" size="4"></input>';
  }
  echo '</p>';
 }
 echo '</td></tr>
 <tr><td>
 <p><b>Specifikation (sv):</b><br>
 <textarea name="spec_s" id="spec_s" cols="60" rows="5"></textarea><br>
 Kort beskrivning av innehållet (tips för böcker, DVD: se baksidorna, pärminsidor).</p>
 </td><td>
 <p><b>Specifikation (eng - om engelsk titel/benämning angetts):</b><br>
 <textarea name="spec_e" id="spec_e" cols="60" rows="5"></textarea><br>
 Kort beskrivning av innehållet på engelska (böcker, DVD: förklara titeln om det behövs).</p>
 </td></tr>';
 if ($kategori==1 || $kategori==2 || $kategori==7 || $kategori==10)
 {
  echo '<tr><td colspan="2" valign="top">
  <p><b>'.$forftext.'</b><br>
  <input name="forf" type="text" size="100"></input>
  &nbsp;&nbsp;
  <select name="forf_red" style="font-family: Verdana; font-size: 11px; color: #000080"> 
  <option value="00">-- Välj titel --</option>
  <option value="fotograf">Fotograf</option>
  <option value="en förf">En författare</option>
  <option value="flera förf">Flera författare</option>
  <option value="konstnär">Konstnär</option>
  <option value="redaktör">Redaktör</option>    
  <option value="redaktörer">Redaktörer</option>
  </select><br>';
  echo 'För- och efternamn. Ersätt förnamn med initial om det är trångt om plats.</p>
  </td></tr>';
 }
 echo '<tr><td> ';
 if ($kategori==4)
 {
  echo '<p><b>Format: </b>Diameter: <input name="bredd" type="text" size="5"></input> cm. ';
 } 
 if ($kategori!=4 && $kategori!=6 && $kategori!=9) 
 {
  echo '<p><b>Format: </b>Bredd: <input name="bredd" type="text" size="5"></input> cm. '; 
 }
 if ($kategori!=6 && $kategori!=9)
 { 
 echo 'Höjd: <input name="hojd" type="text" size="5"></input> cm.<br>
 Ange med 0,5 cm noggrannhet (helst hela).</p>';
 }
 if ($kategori==2 || $kategori==10) //böcker
 {
  echo '<p><b>Bindning:</b> <input type="checkbox" style="border:0" name="inb" value="J"></input> Markera om boken är inbunden med hårda pärmar.</p>
  </td><td valign="top">
  <p><b>Antal sidor:</b> <input name="sidantal" type="text" size="4"></input></p>
  <br>';
 } 
 echo '<p><b>Pris:</b> <input name="pris" type="text" size="4"></input> Hela kronor utan decimaler.
 </td></tr>
 <tr><td colspan="2">
 <b>Extra information (sv)</b> (rabatt, reapris etc. Kan lämnas tom.):<br>
 <input name="extra_s" type="text" size="95"></input><br>
 <b>Extra information (eng)</b> (rabatt, reapris etc. OBS. Endast om engelsk titel angetts ovan.):<br>
 <input name="extra_e" type="text" size="95"></input>
 &nbsp;
 <input name="artikelnr" type="hidden" value="'.$next_itemnr.'"></input>
 <input name="kategorival" type="hidden" value="'.$kategori.'"></input>
 <input name="kategoritxt" type="hidden" value="'.$kat_text.'"></input>
 <input name="send_V1" style="margin-top: 0; margin-bottom: 0" type="submit" value="Skicka" class="submit"
 onMouseOver="this.style.color=\'blue\'; overlib(\'<b>OBS. Är bilder på varan uppladdade?</b> Gör annars det innan du skickar. Saknas bild - notera artikelnummer, se ovan, och varans namn.\');" 
 onMouseOut="this.style.color=\'#FFFFFF\', nd();">
 &nbsp;
 <input name="reset_V1" style="margin-top: 0; margin-bottom: 0" type="reset" value="Radera" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 &nbsp;
 <button style="width:120px" 
 OnClick="javascript:fonster(\'upload_shop.php?bildtyp=shop_varor&mapp='.$bildmap.'&num='.$next_itemnr.'\')"
 onMouseOver="this.color=\'blue\'; overlib(\'<b>OBS. BÖRJA MED DETTA!!</b><br>Stor bild höjd=300 px<br>Liten bild bredd=100 px\')"
 onMouseOut="this.color=\'#FFFFFF\'; nd();">Ladda upp bild</button>
 &nbsp;
 <button style="width: 65px" OnClick="javascript:history.back()"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button>
 </td></tr>
 </table></form>';
}
elseif ($_REQUEST['WS1']=='V2')//Ändra poster i VARULISTAN
{
 $kategori=$_REQUEST['katlistaV'];
 $sql_allavaror="Select artnr, katnr, artikel, pris from varor WHERE katnr='$kategori' 
 ORDER by artikel";
 $query_allavaror=mysqli_query($connect, $sql_allavaror) or die (mysqli_error($connect));

 echo '<p align="center"><b>Markera den vara för vilken ändring skall göras:</b></p>
 <p align="center">
 <form name="send_andr" method="post" action="webshop_andra.php">
 <select name="andrlista" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 11px; color: #000080">';
 while ($row = mysqli_fetch_assoc($query_allavaror))
 {echo '<option value="'.$row['artnr'].'">'.$row['artikel'].'</option>';}
 echo '</select></p>
 <p align="center">
 <input name="send_V2" style="margin-top: 0; margin-bottom: 0" type="submit" value="Fortsätt" class="submit" 
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></input>
 &nbsp;
 <input name="reset_V2" style="margin-top: 0; margin-bottom: 0" type="reset" value="Ångra" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></input>
 &nbsp;
 <button style="width: 65px" OnClick="javascript:history.back()"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button>
 </form></p>
 <p align="center">
 <button style="width:300px" OnClick="location.href=\'webshop2.php\'"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka till startsidan</button></p>';
}
elseif ($_REQUEST['WS1']=='V3') //Ta bort poster i VARULISTAN
{
 $kategori=$_REQUEST['katlistaV'];
 if (isset($_REQUEST['send_V33']))
 {
// ta ut LISTA PÅ alla kategorier
  $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
  $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
  while ($row = mysqli_fetch_assoc($query_kat))
  {
  if($row['katnr']==$kategori)
   {
    $kat_text=$row['kat_s'];
    $bildmap=$row['bildmapp'];
   } 
  }
  echo '<p align="center"><b>Du har valt att ta bort följande varor ur kategorin '.$kat_text.' med tillhörande bilder.</b></p>
  <table align="center" width="300px" class="alt_tab_bg">
  <tr><td>';
  foreach ($_REQUEST['bortlista'] AS $vara)
  {
   $sql_visadata="SELECT artnr, katnr, artikel FROM varor
   WHERE artnr='$vara'";
   $query_visadata=mysqli_query($connect, $sql_visadata);
   while ($row=mysqli_fetch_assoc($query_visadata))
   {
    $artikeln=$row['artikel'];
    echo $vara.' '.$artikeln.'<br>';
   }
  }
  echo '</td></tr></table><p align="center"><b>Stämmer det?</b><br>
  <span style="color: red"><b>OBS. Åtgärden går inte att ångra!</b></span></p>';
  $faltlista=implode(' ', $_REQUEST['bortlista']);
  echo '<p align="center"><form name="tabortvara" method="post" action="webshop_tabort.php">
  <input name="falten" type="hidden" value="'.$faltlista.'"></input>
  <input name="tabell" type="hidden" value="VAROR"></input>
  <input name="send_V3" style="margin-top: 0; margin-bottom: 0; width: 65px" type="submit" value="Ja" class="submit"
  onMouseOver="this.style.color=\'blue\'; overlib(\'<b>OBS. Raderar utvalda varor från databasen!</b>\');" 
  onMouseOut="this.style.color=\'#FFFFFF\', nd();">
  &nbsp;&nbsp;
  <button style="width: 65px" OnClick="javascript:history.back()"
  onMouseOver="this.style.color=\'blue\'" 
  onMouseOut="this.style.color=\'#FFFFFF\'">Nej</button>
  </form></p>';
 }
 else
 {
  $sql_allavaror="Select artnr, katnr, artikel, pris from varor WHERE katnr='$kategori' 
  ORDER by artnr";
  $query_allavaror=mysqli_query($connect, $sql_allavaror) or die (mysqli_error($connect));
  echo '<p align="center"><b>Markera den/de vara/varor som skall tas bort</b><br>
  (för att markera mer än ett alternativ: håll ned CTRL och klicka):</p>
  <p align="center">
  <form name="form_V33" method="POST" action="webshop2.php">
  <select name="bortlista[]" multiple="multiple" size="30" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 11px; color: #000080">';
  while ($row = mysqli_fetch_assoc($query_allavaror))
  {echo '<option value="'.$row['artnr'].'">'.$row['artikel'].'</option>';}
  echo '</select></p>
  <input name="katlistaV" type="hidden" value="'.$kategori.'"></input>
  <input name="WS1" type="hidden" value="V3"></input>
  <p align="center">
  <input name="send_V33" style="margin-top: 0; margin-bottom: 0" type="submit" value="Fortsätt" class="submit" 
  onMouseOver="this.style.color=\'blue\'" 
  onMouseOut="this.style.color=\'#FFFFFF\'"></input>
  &nbsp;
  <input name="reset_V3" style="margin-top: 0; margin-bottom: 0" type="reset" value="Ångra" class="submit"
  onMouseOver="this.style.color=\'blue\'" 
  onMouseOut="this.style.color=\'#FFFFFF\'"></input>
  &nbsp;
  <button style="width: 65px" OnClick="javascript:history.back()"
  onMouseOver="this.style.color=\'blue\'" 
  onMouseOut="this.style.color=\'#FFFFFF\'">Tillbaka</button>
  </form></p>';
 }
}
}
else
{
// FORMULÄR FÖR ATT VÄLJA ÅTGÄRD OCH LISTA - Detta är förstasidan i formulärserien
// 
 echo '<table width="100%" class="alt_tab_bg" cellspacing="0" cellpadding="10">
 <tr><td colspan="2"> 
 <p align="center"><span style="font-size:12px"><b>ADMINISTRERA VARULAGER I WEBSHOPEN.</b></span></p>
 </td></tr>
 <tr><td width="50%" valign="top">
 <p><b>Sortiment (varukategorier)</b></p>';
 
// formulär för att välja åtgärd i KATEGORILISTAN
 echo '<form method="POST" action="webshop2.php">
 <input type="radio" style="border: 0" value="K1" name="WS1">Lägg till ny kategori i SORTIMENTET.</input></p>
 <p>';
//urval av kategori 
 $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 echo '<select name="katlistaK" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 11px; color: #000080">
 <option selected>----------------------- Välj först kategori -----------------------</option>';
 while ($row = mysqli_fetch_assoc($query_kat))
 {echo '<option value="'.$row['katnr'].'">'.$row['kat_s'].'</option>';}
// välj åtgärd 
 echo '</select><br>
 <input type="radio" style="border: 0" value="K2" name="WS1">Ändra kategori i SORTIMENTET.</input><br>
 <input type="radio" style="border: 0" value="K3" name="WS1">Ta bort en kategori från SORTIMENTET.</input><br>';

// formulär för att välja åtgärd i VARULISTAN
 echo '</td><td width="50%" valign="top">
 <p><b>Varulistan</b></p>
 <p>';
//urval av kategori
 $sql_kat="SELECT katnr, kat_s, bildmapp from sortiment ORDER BY kat_s";
 $query_kat=mysqli_query($connect, $sql_kat) or die (mysqli_error($connect));
 echo '<select name="katlistaV" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 11px; color: #000080">
 <option selected>----------------------- Välj först kategori -----------------------</option>';
 while ($row = mysqli_fetch_assoc($query_kat))
 {echo '<option value="'.$row['katnr'].'">'.$row['kat_s'].'</option>';}
 echo '</select></p>';
// välj åtgärd 
 echo '<p>
 <input type="radio" style="border: 0" value="V1" name="WS1">Lägg till nya varor i VARULISTAN.</input><br>
 <input type="radio" style="border: 0" value="V2" name="WS1">Ändra innehåll i VARULISTAN.</input><br>
 <input type="radio" style="border: 0" value="V3" name="WS1">Ta bort varor från VARULISTAN.</input><br>
 </td></tr>
 <tr><td colspan="2">
 <p align="center">
 <input type="submit" value="Fortsätt" class="submit" name="BWS1"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'"></input>
 &nbsp;&nbsp;
 <input style="margin-top: 0; margin-bottom: 0" name="BWS0" type="reset" value="Radera" class="submit"
 onMouseOver="this.style.color=\'blue\'" 
 onMouseOut="this.style.color=\'#FFFFFF\'">
 </form>
 </p>
 </td></tr></table>';
//här börjar formuläret som hanterar beställningar
 echo '<p>&nbsp;</p><p>&nbsp;</p>
 <table width="100%" class="alt_tab_bg" cellspacing="0" cellpadding="10">
 <tr><td> 
 <p align="center"><span style="font-size:12px"><b>ADMINISTRERA BESTÄLLNINGAR INKOMNA VIA MAIL.</b></span></p>';
 include "salj_adm.php";
 echo '</td></tr></table>';
}
?>
</div>
</body>
</html>