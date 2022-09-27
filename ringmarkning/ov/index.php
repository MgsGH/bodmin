<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . '/aahelpers/common-functions.php';
include_once $path . '/aahelpers/db.php';
include_once $path . '/logi/LogiTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);

$pdo = getDataPDO();
updateOvrigMarkning($pdo);

//footer info
$introText = ' ';
$updatedDate = '2022-09-22';
$updatedBy = ' ';

$language = getRequestLanguage();

$texts = new LogiTexter($language);

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

?>

    <div class="basePage">

        <div class="pt-1 pb-1" id="pageBanner">
            <div class="mg-logo">
                <img src="/bilder/logga-100.png" alt="Falsterbo logotype" class="mx-auto d-block">
            </div>
            <div>
                <h1 class='mt-3'id="bannerHeader">Uppdatering av 'ÖV' -> 'OV'</h1>
            </div>
            <div id="vinjett-bild" class="d-flex justify-content-end">
            </div>
        </div>

        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="text-center mt-3 mb-5">
           <h2>Är klart!</h2>
        </div>
        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

