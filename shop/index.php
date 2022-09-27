<?php

include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once 'ShopTexter.php';

// Steers linked-in CSS and JS files
include_once "../aahelpers/PageMetaData.php";
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2019-11-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new ShopTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setWebShopSelected();

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>


    <div class="basePage">

        <?php echo $pageMenu->getHTML(); ?>
        <?php echo getBannerHTML( 'fyrshopen_5x3.jpg'); ?>

        <h1>Butik</h1>

        <p>Only basePage</p>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php getHtmlEnd();