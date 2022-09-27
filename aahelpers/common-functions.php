<?php


function getRequestLanguage(){

    $language = 'sv';
    if (isset($_REQUEST['lang'])) {
        $language=$_REQUEST['lang'];
    }

    return $language;

}


function getLang($l): string{

    $language = '2';
    if ($l === 'en') {
        $language = '1';
    }

    return $language;

}


function getBannerHTML($imgName): string {


    $str = '
            <div class="pt-1 pb-1" id="pageBanner">
                <div class="mg-logo">
                    <img src="/bilder/logga-100.png" alt="Falsterbo logotype" class="mx-auto d-block"> 
                </div>
                <div>
                    <h1 class="fboh1" id="bannerHeader">Hem - Falsterbo Fågelstation</h1>
                    <p class="fbop" id="bannerIntroText">To be replaced</p> 
                </div>    
                <div id="vinjett-bild" class="d-flex justify-content-end">
                    <img src="' . $imgName . '" alt="Modulvinjett">
                </div>
            </div>               
            ';

    return $str;

}


function getLoggedInHeader(){

    $tmpUserName = '';
    $tmpUserId = '0';
    if (isLoggedIn()){
        $tmpUserId = getLoggedInUserId();
        $tmpUserName = getLoggedInUser();
    }

    $loggedLanguageSection       = '<span class="mg-hide-element" id="systemLanguageId">' . $_SESSION["preferredLanguageId"] . '</span>';
    $userIdSection               = '<span id="loggedInUserId" class="mg-hide-element">' . $tmpUserId . '</span>';
    $loggedInTextIntro           = '<span id="loggedinText"></span>';  // Is set by JS: logged in as:
    $loggedStatusSection         = '<span id="loggedStatus"></span>';
    $userNameSection             = '<span id="userName">' . $tmpUserName .'</span> ';
    //$test                        = '<a href="javascript:swapLanguage();">test</a>';
    $test                        = '';

    return '<div class="super-header"><small>' . $loggedLanguageSection . $userIdSection . $loggedInTextIntro . $userNameSection . $loggedStatusSection . $test .'</small></div>';

}


function getLoggedInUser(){
    $loggedIn = 'none';
    if (isset($_SESSION["username"] )){
        $loggedIn = $_SESSION["username"];
    }
    return $loggedIn;
}


function getLoggedInUserId(){
    $loggedIn = 999;
    if (isset($_SESSION["userId"] )){
        $loggedIn = $_SESSION["userId"];
    }
    return $loggedIn;
}


function getRequestValueWithDefault($value, $default){

    $r = $default;
    if (isset($_REQUEST[$value])) {
        if (!empty($_REQUEST[$value])){
            $r = $_REQUEST[$value];
        }

    }

    return $r;

}


function getSessionThenRequestLastDefaultValue($value, $default){

    if (isset($_REQUEST[$value])) {
        $r = $_REQUEST[$value];
    } elseif (isset($_SESSION[$value])){
        $r=$_SESSION[$value];
    } else {
        $r = $default;
    }

    return $r;

}


function getDropDownOption($text, $value, $selected){

    $html = ' <option value="' . $value . '"';
    if ($value == $selected){
        $html = $html . ' selected' ;
        $_SESSION['last-selected'] = $text;
    }

    $html = $html . '>' . $text . '</option>';

    return $html;
}


function getRadioButton($id, $name, $value, $selected ){

    //<input type="radio" id="FB" name="sason" value="FB" checked>

    $html = '<input class="form-check-input" type="radio" id="' . $id . '" name="' . $name .'" value="' . $value . '"' ;
    if ($value == $selected){
        $html = $html . ' checked' ;
    }

    $html = $html . '>';

    return $html;
}


function getRewrittenURL($parameter, $value, $url)
{

    $tmp = parse_url($url);

    $base = $tmp['scheme'] . '://' . $tmp['host'] . $tmp['path'];
    $queryPart = '';

    if (!isset($tmp['query'])){
        if (!$value == '') {
            $queryPart = '?' . $parameter . '=' .$value;
        }
    } else {

        parse_str($tmp['query'], $queryParams);

        if ($value=='') {
            unset($queryParams[$parameter]);
        } else {
            $queryParams[$parameter] = $value;
        }

        $queryPart = '?' . http_build_query($queryParams);

    }

    return $base . $queryPart;

}


function ongoingYear($year){
    return $year == getCurrentYear();
}


function getCurrentYear(){
    $d = getdate();
    return $d['year'];
}


function getCurrentDayNo(){
    return date("d");
}


function getCurrentDateAsYMD(){

    return date('Y-m-d');
}


function getCurrentMonth(){

    $d = getdate();
    return $d['mon'];

}


function getMonthFromStringDateYmd($strYmdDate){

    $t = strtotime($strYmdDate);
    $d = getdate($t);

    return $d['mon'];

}


function getYearFromStringDateYmd($strYmdDate){

    $t = strtotime($strYmdDate);
    $d = getdate($t);

    return $d['year'];

}


function getDayFromStringDateYmd($strYmdDate){

    $t = strtotime($strYmdDate);
    $d = getdate($t);
    return $d['mday'];

}


function getDropDownYears($startYear){

    $years = array();
    $stopYear = getCurrentYear();
    for ($y = $stopYear; $y >=$startYear; $y--){
        array_push($years, $y);
    }

    $noRingingYearsArray = array();
    array_push($noRingingYearsArray, 1948 );
    array_push($noRingingYearsArray, 1951 );

    return array_diff($years, $noRingingYearsArray);
}


function getDropDownWeeks($start){

    $data = array();
    $stop = 52;
    for ($y = $stop; $y >=$start; $y--){
        array_push($data, $y);
    }

    return $data;
}


function getMonthTexts($language){

    $texts['1'] = 'januari';
    $texts['2'] = 'februari';
    $texts['3'] = 'mars';
    $texts['4'] = 'april';
    $texts['5'] = 'maj';
    $texts['6'] = 'juni';
    $texts['7'] = 'juli';
    $texts['8'] = 'augusti';
    $texts['9'] = 'september';
    $texts['10'] = 'oktober';
    $texts['11'] = 'november';
    $texts['12'] = 'december';

    if ($language == 'en'){
        $texts['1'] = 'January';
        $texts['2'] = 'February';
        $texts['3'] = 'March';
        $texts['4'] = 'April';
        $texts['5'] = 'May';
        $texts['6'] = 'June';
        $texts['7'] = 'July';
        $texts['8'] = 'August';
        $texts['9'] = 'September';
        $texts['10'] = 'October';
        $texts['11'] = 'November';
        $texts['12'] = 'December';

    }

    return $texts;
}


function formatSpeciesName($name, $language){

    $svar = $name;
    if ($language == 'sv' ) {
        $svar = $name;
        //$svar = ucfirst(strtolower($name));
    }

    return $svar;
}


function formatNo($strNo){

    $r = $strNo;
    if ($strNo === "0"){
        $r = '-';
    } else {

        if ($strNo !== '-'){
            $r = number_format($strNo, 0, ",", " " );
        }

    }

    return str_replace(' ', '&nbsp;', $r);


}


function numberToString($number){

    $str = strval($number);
    if ($number < 10){
        $str = '0' . $str;
    }

    return $str;

}


function reCodeArtCode($selectedArt){

    //work around for SVRÖD for example
    $selectedArt = strtoupper($selectedArt);
    $selectedArt = str_replace('Ö', 'O', $selectedArt);
    $selectedArt = str_replace('Å', 'A', $selectedArt);
    $selectedArt = str_replace('Ä', 'A', $selectedArt);

    return $selectedArt;

}


function getVinjettBildHTMLSection($pdo, $selectedArt, $photographer): string
{

    //work around for SVRÖD for example -> SVROD
    $selectedArt = reCodeArtCode($selectedArt);
    $imgSource = ' /bilder/artvinjetter/' . $selectedArt . '.jpg';
    $htmlStr = '<img src="' . $imgSource . '" class="shadow" alt="Vinjettbild på arten" title="' . $photographer . '"/>';
    return $htmlStr;

}


function getStringPrunedRemoveAtTheEnd($s, $toRemove){

    return rtrim($s, $toRemove);

}


function getRollingFiveAverage($arrayWithNumbers): array {

    $arrayWithAverages = array();

    for ($i=0; $i<sizeof($arrayWithNumbers); $i++) {

        if (($i < 2) || ($i > (sizeof($arrayWithNumbers) -3))) {
            //array_push($arrayWithAverages, 0);
        } else {
            $tot = 0;
            for ($ii = $i-2; $ii < $i+3; $ii++ ){
                $tot = $tot + $arrayWithNumbers[$ii];
            }
            array_push($arrayWithAverages, round($tot/5));
        }

    }

    return $arrayWithAverages;

}


function getPrunedTimeSeries($timeSeries){

    $ar = count($timeSeries);
    $prunedResult = array();
    for ($i=2; $i<$ar-2; $i++){
        array_push($prunedResult, $timeSeries[$i]);
    }

    return $prunedResult;
}


function getOneDayMore($startdate){

    $enddate = date('Y-m-d',strtotime($startdate . ' +1 day'));
    return $enddate;
}


function getDagBoksLink($date){

    $link = '<a href="/blog/?date=' . $date . '">' . $date . '</a>';
    return $link;
}


function getYearLink($year){

    $link = '<a href="/strack/ar/?year=' . $year . '">' . $year . '</a>';
    return $link;
}


function getSpecieStrackTrendLink($kod, $namn, $language){

    $link = '<a href="/strack/art-trend.php?art=' . $kod ;
    if ($language == 'en') {
        $link = $link . '&lang=en';
    }

    $link = $link . '">' . $namn . '</a>';
    return $link;

}


function getSpecieRingTrendLink($kod, $namn, $language){

    $link = '<a href="../ringmarkning/art-trend.php?art=' . $kod ;
    if ($language == 'en') {
        $link = $link . '&lang=en';
    }

    $link = $link . '">' . $namn . '</a>';
    return $link;

}


/*
 * Används både av ringing arttrends and strack arttrends, when showing ten year averages.
 *
 */
function writeTenYearAverageTable($data, $texts){

    ?>
    <table class="table table-striped table-sm w-auto">
        <thead class="thead-light">
        <tr>
            <th><?php echo $texts->getTxt('mo-pop-average') ?></th>
            <th><?php echo $texts->getTxt('mo-pop-average-sum') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $fiveYearPeriod): ?>
            <tr>
                <td> <?php echo $fiveYearPeriod['PERIOD'] ?></td>
                <td class="no-s"> <?php echo formatNo($fiveYearPeriod['MV']);  ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <?php
}


function writeSignificanceLegend($texts){

    ?>

    <div class="legend">
        <table class="table-invisible top">
        <tr>
            <td colspan="2"><h5><?php echo $texts->getTxt('mo-legend-header') ?></h5></td>
        </tr>
        <tr>
            <td>***</td>
            <td>p<0.001</td>
        </tr>
        <tr>
            <td>**</td>
            <td>p<0.01</td>
        </tr>
        <tr>
            <td>*</td>
            <td>p<0.05</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    </div>

    <?php
}


function writeMetaDataInfo($data, $texts){

   // var_dump($data[0]);

    echo '<p>';
    echo $texts->getTxt('spearman') . ': ' . $data[0]['Rs'] . ' ' . $data[0]['SIGN'];
    echo '<br/>';
    echo '<br/>';



    if (($data[0]['KOMMENTAR_TXT'] !== 'Kommentar saknas.') && ($data[0]['KOMMENTAR_TXT'] !== 'No comment.')){
        echo $data[0]['KOMMENTAR_TXT'];
    }
    echo '</p>';

}


function writeArtTrendChartForklaring($texts){
    ?>
    <div class="legend">
    <table class="table-invisible top">
        <tr>
            <td colspan="2"><h5><?php echo $texts->getTxt('chart-header') ?></h5></td>
        </tr>
        <tr>
            <td class="top"><?php echo $texts->getTxt('staplar-i') ?></td>
            <td class="top"><?php echo $texts->getTxt('staplar-ii') ?><br/><br/></td>
        </tr>
        <tr>
            <td class="top"><?php echo $texts->getTxt('bollar-i') ?></td>
            <td class="top"><?php echo $texts->getTxt('bollar-ii') ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    </div>

    <?php
}


function getFormattedPageFooter($introText, $lastChange, $updatedBy): string {
    $str = '<hr class="footer">' . PHP_EOL;
    $str .= '<p class="center">' . $introText . ' ' . $lastChange . ' ' . $updatedBy . '<br>Copyright© 2022, Falsterbo Fågelstation.</p>'. PHP_EOL;
    $str .= '<p class="center"><a href="/bodmin/index.php"><small>Logga in</small></a></p>';
    return $str . "<br/>". PHP_EOL;
}


function getHtmlHead($pageTitle, $pageMetaData, $language): string {

    $str = '<!DOCTYPE html>' . PHP_EOL;
    $str .= '<html lang="en">' . PHP_EOL;
    $str .= '<head>'. PHP_EOL;
    $str .= '<meta charset="utf-8">' . PHP_EOL;
    $str .= '<meta name="viewport" content="width=device-width, initial-scale=1">' . PHP_EOL;
    $str .= '<meta name="credits" content="Magnus Grylle">' . PHP_EOL;
   // $str .= '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90283624-2"></script>'. PHP_EOL;
    $str .= '<title id="titleText">' . $pageTitle . '</title>'. PHP_EOL;

    $str .= '<meta name="google-site-verification" content="iuiHDjer7xDcD3GFuskOeQlXVHVCZN3zNEi41FYfjJ8">' . PHP_EOL;
    $str .= '<meta id="metaLang" name="lang" content="' . $language . '">' . PHP_EOL;
    $str .= $pageMetaData->getHeadStyleSheetSectionAsHTML();
    $str .= "</head>" . PHP_EOL;
    return $str . getHtmlBodyStart();

}


function outputYouAreNotLoggedInPage( $pageMetaData ): string {

    $str = '<!DOCTYPE html>' . PHP_EOL;
    $str .= '<html lang="en">' . PHP_EOL;
    $str .= '<head>'. PHP_EOL;
    $str .= '<meta charset="utf-8">' . PHP_EOL;
    $str .= '<meta name="viewport" content="width=device-width, initial-scale=1">' . PHP_EOL;
    $str .= '<meta name="credits" content="Magnus Grylle">' . PHP_EOL;
    $str .= '<title id="titleText">' . 'Not logged in' . '</title>'. PHP_EOL;
    $str .= '<meta id="metaLang" name="lang" content="en">' . PHP_EOL;
    $str .= $pageMetaData->getHeadStyleSheetSectionAsHTML();
    $str .= "</head>" . PHP_EOL;
    $str .= "<body>" . PHP_EOL;
    $str .= '<div class="pt-5 mt-5 mb-5 pb-5 text-center">' . ' Du är inte inloggad. ' . '<br>' .  PHP_EOL;
    $str .= "<div class='mt-3'>" . PHP_EOL;
    $str .= "Antingen har du kommit hit direkt utan att logga in, eller så har du haft denna sida öppen så länge utan att göra något, att servern har 'glömt' dej. " . PHP_EOL;
    $str .= "</div>" . PHP_EOL;
    $str .= "</div>" . PHP_EOL;
    $str .= '<div class="pt-5 mt-5 mb-5 pb-5 text-center">' . ' Logga in <a href="/bodmin">här</a>' . PHP_EOL;
    $str .= "</div>" . PHP_EOL;
    return $str;

}



function getHtmlHeadEnd(){
    return "</head>" . PHP_EOL;
}


function getHtmlBodyStart(){
    return "<body>" . PHP_EOL;
}


function getHtmlHeadStart($pageTitle){

    $newRow = "\n\r";
    $str = '<!DOCTYPE html>' . $newRow;
    $str = $str . '<html lang=\"en-US\">' . $newRow;
    $str = $str . '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . $newRow;
    $str = $str . '<head><title>Falsterbo fågelstation - ' . $pageTitle . '</title>'. $newRow;
    return $str . '<meta http-equiv="content-type" content="text/html; charset=UTF-8">' .$newRow;

}


function getPageFooter($textToDisplay, $lastChange){
    $newRow = "\n\r";
    echo ('<script src="home.js?version=' . time() . '"></script>  ');
    echo('<hr class="footer">' . $newRow);
    echo('<p class="center">' . $lastChange . $textToDisplay . "<br>Copyright© 2021, Falsterbo Fågelstation.</p>". $newRow);
    echo("<br/>". $newRow);
}


function getHTMLEnd(){
    $time = time();
    return '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.12/js/bootstrap-multiselect.js"></script>
             </body>
             </html>
           ';
}


function getHTMLEndWithJS($jsSection){

    return $jsSection . '
             </body>
             </html>
           ';
}


function dumpArray($aToBeDumped){

    var_dump(count($aToBeDumped));

    for ($i = 0; $i < count($aToBeDumped); $i++){
        var_dump($aToBeDumped[$i]);
        echo ("<br/>");
    }

}


function sol_upp_ned($language){

    date_default_timezone_set('Europe/Copenhagen');
    $lat = 55.3833;
    $long = 12.8167;
    $date = date("Y-m-d");
    $sunInfo = date_sun_info(strtotime($date), $lat, $long);
    $aSolen = [];

    if ($language === 'en') {
        array_push($aSolen, date('h:i a', $sunInfo['sunrise']));
        array_push($aSolen, date('h:i a', $sunInfo['sunset']));
    }

    if ($language === 'sv') {
        array_push($aSolen, date('H:i', $sunInfo['sunrise']));
        array_push($aSolen, date('H:i', $sunInfo['sunset']));
    }


    return $aSolen;
}


function dateHumanReadable($sprak){
    setlocale(LC_ALL, 'swedish');
    if ($sprak==='en'){
        setlocale(LC_ALL, 'english');
    }

    setlocale(LC_TIME,'sv_SE');

    $dagen = ucfirst(strftime('%A'));
    $dato = date('j');
    $manad = strftime('%B');

    $artal = strftime('%Y');
    $alla = $dagen.' '.$dato.' '.$manad.' '.$artal.'.';
    return utf8_encode($alla);

}


function writeMonthTable($startDate, $texts, $data, $languageISO2){

    $thisMonth = getMonthFromStringDateYmd($startDate);
    echo('<table class="table table-sm table-striped hover">');
    echo('<thead class="thead-light">');
    echo('<tr>');
    echo('<th colspan="2" class="text-center">');
    echo($texts->getTxt($thisMonth));
    echo('</th>');
    echo('</tr>');
    echo('</thead>');
    echo('<tbody>');
    $workingDate = $startDate;
    $monthSum = 0;
    while ($thisMonth == getMonthFromStringDateYmd($workingDate)){
        echo('<tr>');
        echo('<td class="day-no pr-1">');
        $thisDay = getDayFromStringDateYmd($workingDate);
        echo ($thisDay);
        echo('</td>');
        echo('<td class="no-f pr-2">');
        $link = '<a href="/strack/dagssummor/?date=' . $workingDate . '&lang='. $languageISO2 . '">';
        $dayTotal = getDayTotal($workingDate, $data);
        $monthSum  += $dayTotal;
        echo ($link . formatNo($dayTotal) . '</a>');
        echo('</td>');
        echo('</tr>');
        $workingDate = getOneDayMore($workingDate);
    }

    if ($thisDay == 30){
        // out put an empty row in the table, so lines up with 31 day months
        echo('<tr>');
        echo('<td class="summa text-center" colspan="2">');
        echo ('-');
        echo('</td>');

        echo('</tr>');
    }
    echo('<tr>');
    echo('<td class="summa">');
    echo (' ');
    echo('</td>');
    echo('<td class="summa pr-1 no-f">');
    echo (formatNo($monthSum));
    echo('</td>');
    echo('</tr>');
    echo('</tbody>');
    echo('</table>');

}


function getDayTotal($date, $data){

    // 2017-10-31

    $returnValue = '0';
    for ($i=0; $i<sizeof($data); $i++){

        if ($data[$i]['datum'] == $date){
            $returnValue = $data[$i]['summa'];
            break;
        }

    }

    return  $returnValue;
}


function getNoCode($lang){

    $numberCode = 1; // default english
    if ($lang == 'sv'){
        $numberCode = 2;
    }

    return $numberCode;
}


function logPostData(){

    logg('$_POST size: ' . sizeof($_POST));
    //logg('No of records: ' . (sizeof($_POST)-1)/6);
    logg('  ');
    foreach ($_POST as $item => $value){
        logg($item . ': ' . $value);
    }
    logg('  ');
    logg('  ');

}


// --------------------security--------------------------------------------------------------------------
function isLoggedIn(){

    $loggedIn = false;
    if (isset($_SESSION["loggedin"])) {
        $t = $_SESSION["loggedin"];
        if ($t == '1'){
            $loggedIn = true;
        }
    }

    return $loggedIn;
}


function checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo){

    // Check loggedIn
    $allowedToSeePage = isLoggedIn();
    if (!$allowedToSeePage){
        dbLog("User is not logged in - access denied");
    } else {

        // Check referer
        if (!$allowedComingFromPage === 'anywhere'){
            $allowedToSeePage = array_search(getPreviousPage(), $allowedComingFromPage);
            if (!$allowedToSeePage){
                dbLog("Not from the right from page - access denied");
            }
        }

        // Check permissions
        if ($allowedToSeePage){

            $permissionGiven = getUserPermission($pdo, $module);

            //dbLog( 'Permission given ' . $permissionGiven );
            //dbLog( 'Permission req ' . $permissionRequired );

            $allowedToSeePage = ( $permissionGiven >= $permissionRequired );

            if (!$allowedToSeePage){
                dbLog("User has not sufficient permissions - access denied");
            }

        }

    }

    return $allowedToSeePage;
}


function getUserPermission($pdo, $module){

    $userId = $_SESSION['userId'];

    $permissionSetting = getUserModulePermission($pdo, $userId, $module);
    $thisSetting = $permissionSetting[0];
    return $thisSetting['PERMISSION_ID'];

}


function writeUserModulePermissions($pdo, $userId){

    for ($module=1; $module < 22; $module++){
        writeUserModulePermissionToDB($pdo, $userId, $module, $_POST[$module]);
    }

}


function selectedTaxaAmongArterData($selectedArt, $arterData){

    $answer = false;
    foreach ($arterData as $art){

        if ($art['SHORTNAME'] === $selectedArt){
            $answer = true;
            break;
        }
    }

    return $answer;
}


//--------------------------------------------------------------------------------- languages ----------
function getLanguageOptionsAsHTML($pdo, $selectedLanguage){

    $data = getLanguagesForOptions($pdo);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  $selectedLanguage);
    }

    return $html;
}


function removeFile($file){

    if (file_exists($file)){
        unlink($file);
    }

}


function getPermissionOptionsAsHTML($pdo, $lang){

    $permissionData = getPermissionOptions($pdo, $lang);
    $html = "";
    foreach ($permissionData as $permission){
        $html = $html . getDropDownOption($permission['TEXT'], $permission['PERMISSION_ID'],  '');
    }

    return $html;
}


function getPermissionsSectionAsHTML($data, $permissionOptions){

    $html = '';
    foreach ($data as $module) {

        $html .= '<div class="form-group mb-1">';
        $html .= '<label for="mod-' . $module['MODULE_ID'] . '" class="mg-140-span">' . $module['TEXT'] . '</label>';
        $html .= '<select id="mod-' . $module['MODULE_ID'] . '" form="edit-permissions" name="' . $module['MODULE_ID'] . '" class="form-select-sm permissionSelect">';
        $html .= $permissionOptions;
        $html .= '</select>';
        $html .= '</div>';

    }

    return $html;
}


//--------------------------------------------------------------------------------- measurements ----------
function getMeasurementsOptionsAsHTML($pdo, $selectedLanguage){

    $data = getMeasurementsOptions($pdo, $selectedLanguage);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  $selectedLanguage);
    }

    return $html;
}


function getOptionalMeasurementsOptionsAsHTML($pdo, $selectedLanguage){

    $data = getOptionalMeasurementsOptions($pdo, $selectedLanguage);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  $selectedLanguage);
    }

    return $html;
}


function getBlogDayData($pdo, $lang, $date){

    $blogEntry = array();

    $search = "/bilder/maxipics";
    $replace =  "/v2images/maxipics";

    $day = getPublishedNewsTextForDate($pdo,$lang, $date);
    $day[0]["TEXT"] = str_replace($search, $replace, $day[0]["TEXT"]);

    $blogEntry['newsData'] = $day[0];
    $blogEntry['seasonData'] = getStandardWorkSchemes($pdo, 1, $lang, $date);
    $blogEntry['nonSystematicRingingData'] = getThisDateNonSystematicRingingData($pdo, $date, $lang);
    $blogEntry['weatherData'] = getWeatherForDate($pdo, $date, $lang);
    $blogEntry['allZeroDayData'] = getFullZeroDayData($pdo, $date, $lang);
    $blogEntry['strackData'] = getStrackData($pdo, $date, $lang);

    return $blogEntry;

}


function checkIfLoggedIn($loggedInUser, $pageMetaData){

    if ($loggedInUser === null){
        echo outputYouAreNotLoggedInPage($pageMetaData);
        echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
        exit;
    }


}

?>