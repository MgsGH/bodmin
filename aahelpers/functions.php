<?php

// prevent direct access
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
}


// ------------ bread and butter HTML --------------------------------------------------------------------
function getHTMLHeader(){

    $time = time();
    $html = '<!doctype html>
             <html lang="en">
             <head>
                <title></title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"">
                <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
                <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
                <link rel="manifest" href="/site.webmanifest">                                                       
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" integrity="sha512-urpIFwfLI9ZDL81s6eJjgBF7LpG+ROXjp1oNwTj4gSlCw00KiV1rWBrfszV3uf5r+v621fsAwqvy1wRJeeWT/A==" crossorigin="anonymous" />                        
                <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css"> 
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
                <link rel="stylesheet" href="../aahelpers/extras.css?version=' . $time . '">  
                <link rel="stylesheet" href="../aahelpers/multiselect/css/bootstrap-multiselect.css" type="text/css"/>                
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.css"> 
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.4.28/jodit.min.css">                                                                                                                       
            </head>
            <body>';


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
    $test                        = '<a href="javascript:swapLanguage();">test</a>';

    $html = $html . '<div class="super-header"><small>' . $loggedLanguageSection . $userIdSection . $loggedInTextIntro . $userNameSection . $loggedStatusSection . $test .'</small></div>';

    return $html;
}


function getHTMLEnd(){
    $time = time();
    return '    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>                       
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>                  
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>                        	
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"></script>
                <script src="../aahelpers/cropper/jquery-cropper.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.4.28/jodit.min.js"></script> 
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>                                                       
                <script type="text/javascript" src="../aahelpers/multiselect/js/bootstrap-multiselect.js"></script>                                                                    
                <script src="../aahelpers/mg-common.js?version=' . $time . '"></script>                                              
                <script src="home.js?version=' . $time . '"></script>  
                </body>
            </html>';
}




function getMeTheDate(){
    return date("Y-m-d");
}


function getCurrentLanguage(){

    $langId = 1; // default english
    if (isset( $_SESSION["preferredLanguageId"] )){
        $langId = $_SESSION["preferredLanguageId"];
    }
    return $langId;

}


function logSessionData(){

    logg('  ');
    logg('$_SESSION' . '  ' . sizeof($_SESSION) . ' variables set.');
    foreach ($_SESSION as $item => $value){
        logg($item . ': ' . $value);
    }

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


function getPreviousPage(){

    $refURL = 'not known';
    if (isset($_SERVER['HTTP_REFERER'])) {
        // Store Referral URL in a variable
        $refURL = $_SERVER['HTTP_REFERER'];
    }
    return $refURL;

}


function getUsersTableAsHTML($personData, $data){

    $html = '<table id="data" class="table table-hover w-auto">
            <thead><tr>
            <th id="tblHdrUserNamn"></th>
            <th id="tblHdrPersonNamn"></th>
            <th id="tblHdrAktiverad"></th>
            <th id="tblHdrDefaultLanguage"></th>
            <th id="tblHdrSkapadNar"></th>
            </thead>
            <tbody>';
        foreach($data as $user){
            $infoId = 'extra-user-info-' . $user['id'];
            $html = $html . '<tr id="' . $user['id'] . '">';
            $html = $html . '
                <td>' .  trim($user['username']) . '</td>
                <td>' .  getUsersName($personData, $user['person_id']) . '</td>';
            $html = $html . getPublishedCell($user['enabled']);
            $html = $html .
                '<td>' .  $user['LANGUAGE'] . '</td>
                <td>' .  $user['created_at'] . '</td>
            </tr>
            <tr class="mg-hide-element mg-table-row-data">
                <td colspan="5" id="' . $infoId . '"><h6>' . 'xxxx' . '</h6>' . 'xxxx' . '<br/><br/><br/><br/><br/><br/>
            </tr>';
        }

        $html = $html . '
           </tbody>
           </table>';

    return $html;

}


function getUsersName($data, $needle){

    $answer = "Not linked";
    foreach($data as $item){
        if ($item['ID'] == $needle){
            $answer = $item['FULLNAME'];
        }
    }

    return $answer;
}


function getDropDownOption($text, $value, $selected){

    $html = ' <option value="' . $value . '"';
    if ($value == $selected){
        $html = $html . ' selected' ;
    }

    $html = $html . '>' . $text . '</option>';

    return $html;
}


function getOptionsAsHTML($data, $selected){

    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  $selected);
    }

    return $html;
}



//--------------------------------------------------------------------------------- code types ----------
function getTaxaCodeTypesOptionsAsHTML($pdo, $selectedLanguage){

    $data = getAllTaxaCodesTypes($pdo, $selectedLanguage);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  1);
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


function showPostVariablesByName(){

    $t = '<div><strong>Post variables by name</strong><br/>';
    $t = $t . 'Number of items: ' . sizeof($_POST) . '<br/>';
    foreach ($_POST as $varName => $var) {
        $t = $t . $varName . ' is ' . $var . '<br/>';
    }

    return $t . '</div>';

}


// ----------------------------------------------------------------------------Rasträkning -----------------

function getRastRakningTableAsHTML($data){

    $html = '
            <table id="data" class="table table-hover w-auto">
            <thead>
                <tr>
                    <th id="tblYear"></th>
                    <th id="tblWeek"></th>
                    <th id="tblAntRast"></th>
                    <th id="tblAntAarter"></th>
                    <th id="tblPubl"></th>                    
                </tr>
            </thead>
            <tbody>';
    foreach($data as $arVecka){

dumpArray($arVecka);

        $infoId = 'extra-user-info-' . $arVecka['ID'];

        $html = $html . '<tr id="occasion-' . $arVecka['ID'] . '">';
        $html = $html . '
                <td class="text-center">' .  $arVecka['YEAR'] . '</td>
                <td class="text-center">' .  $arVecka['VE'] . '</td>
                <td class="mg-no-right">' .  formatNo($arVecka['VECKO_SUMMA']) . '</td>
                <td class="mg-no-right">' .  $arVecka['ANTAL_ARTER'] . '</td>';
        $html = $html . getPublishedCell($arVecka['PUBLISH']);
        $html = $html . '</tr>
            <tr id="detailed-data-' . $arVecka['ID'] . '" class="mg-hide-element mg-table-row-data">
                <td colspan="5" id="' . $infoId . '">
                <div id="loaderdiv-' . $arVecka['YEAR'] . '-' . $arVecka['VE'] . '" class="text-center"><img src="../aahelpers/img/loading/ajax-loader.gif" alt="wait"></div>
                <div id="vecko-detalj-tabell-' . $arVecka['YEAR'] . '-' . $arVecka['VE'] . '">
                    <h6 id="detaljTblHdr"></h6> 
                    <table class="xmg-hide-element table-sm" id="' . $arVecka['YEAR'] . '-' . $arVecka['VE'] . '">
                        <thead>
                            <tr>
                                <th name="art"></th>
                                <th name="kanalen"></th>
                                <th name="black"></th>
                                <th name="angsnaset"></th>
                                <th name="nabben"></th>
                                <th name="slusan"></th>
                                <th name="revlarna"></th>
                                <th name="knosen"></th>
                                <th name="summa"></th>
                            </tr>
                        </thead>
                        <tbody>
                             <tr id="noll" class="mg-hide-element">
                                <td>anka</td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                                <td class="mg-no-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </tr>';
    }

    $html = $html . '
           </tbody>
           </table>';

    return $html;

}


function getPublishedCell($published){

    $html = '<td class="text-center';
    $publishedClass = " notPublished";
    if ($published === '1' ){
        $publishedClass = ' published';
    }
    $html = $html . $publishedClass .'">' . $published . '</td>';

    return $html;
}


function logg($message){

    if (gettype($message) === "array"){

        error_log(count($message) . PHP_EOL, 3, "development.log");
        foreach($message as $key => $value) {
            $s = $key . ' ' . $value;
            error_log($s . PHP_EOL, 3, "development.log");
        }
    } else {
            error_log($message . PHP_EOL, 3, "development.log");
    }


}


function getPermissionSectionAsHTML($data, $permissionOptions){

    $html = '';

    foreach ($data as $module) {

        if ($module['MODULE_ID'] > 1) { /* module 1, start is always available so no permissions needs to be set */
            $html = $html . '<div class="form-control mg-top">';
            $html = $html . ' <label for="mod-' . $module['MODULE_ID'] . '" class="mg-140-span">' . $module['TEXT'] . '</label>&nbsp;';
            $html = $html . '<select id="mod-' . $module['MODULE_ID'] . '" form="edit-permissions" name="' . $module['MODULE_ID'] . '">';
            $html = $html . $permissionOptions;
            $html = $html . '</select></div>';
        }

    }

    return $html;
}


function getLocationsOptionsAsHTML($pdo, $selectedLanguage){

    $data = getLocationsOptions($pdo, $selectedLanguage);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['LOCATION'], $option['LOCATION_ID'],  $selectedLanguage);
    }

    return $html;
}


function getTrappingMethodsOptionsAsHTML($pdo, $selectedLanguage){

    $data = getTrappingMethods($pdo, $selectedLanguage);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  '9999');
    }

    return $html;
}


function getRingTypesOptionsAsHTML($pdo, $langId){

    $data = getRingTypesForDropDown($pdo, $langId);
    $html = "";
    foreach ($data as $option){
        $html = $html . getDropDownOption($option['TEXT'], $option['ID'],  '9999');
    }

    return $html;
}


function getLang($l){

    $language = '2';
    if ($l === 'en') {
        $language = '1';
    }

    return $language;

}


function getHtmlHeadStart($pageTitle){

    $newRow = "\n\r";
    $str = '<!DOCTYPE html>' . $newRow;
    $str = $str . '<html lang=\"en-US\">' . $newRow;
    $str = $str . '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . $newRow;
    $str = $str . '<head><title>Falsterbo fågelstation - ' . $pageTitle . '</title>'. $newRow;
    $str = $str . '<meta http-equiv="content-type" content="text/html; charset=UTF-8">' .$newRow;
    return $str;
}


function getHtmlHeadStylesheetSection(){

    $newRow = "\n\r";
    $time = time();
    $str = '<link rel="stylesheet" type="text/css" href="../aahelpers/fbo-bluemallXXX.css?version=' . $time . '">' . $newRow;
    $str = $str . '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">' . $newRow;
    $str = $str . '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">' . $newRow;
    $str = $str . '<link rel="stylesheet" href="../aahelpers/extras.css?version=' . $time .  '">  ' . $newRow;
    $str = $str . '<link rel="stylesheet" href="../aahelpers/multiselect/css/bootstrap-multiselect.css" type="text/css"/> ' . $newRow;

    return $str;
}


function getHtmlHeadEnd(){
    $newRow = "\n\r";
    $str = "</head>" . $newRow;
    return $str;
}


function getHtmlBodyStart(){
    $newRow = "\n\r";
    $str = "<body>" . $newRow;
    return $str;
}



