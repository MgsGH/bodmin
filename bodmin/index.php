<?php
session_start();

include_once '../aahelpers/common-functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';
include_once "../aahelpers/PageMetaData.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('home.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);


if (!isLoggedIn()) {

    loggIt('Is not logged in! ');
    header( "location: ../bodmin/login/index.php");
    exit;
}

$pdo = getDataPDO();
$language = getRequestLanguage();
$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(0);

echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();
?>

<div class="container-fluid p-3 my-3">

    <div class="container row cols-6 border">

        <div class="cols-12">

            <br/>
            <h1 id="hdrMain">hdrMain</h1>
            <h2 id="hdrTwo">hdrMain</h2>
            <p id="hdrSubOne"></p>

            <br/>
            <p id="hdrSubThreeOne"></p>
            <!--
            <label id="hdrSubThreeOne" for="ddKeyWordsBlog"></label>

            <select id="ddKeyWordsBlog">

            </select>
            <br/><br/>
            <div id="newsList">
            </div>
            -->
        </div>
    </div>
</div>


<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());


