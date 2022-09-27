<?php

include_once "../../aahelpers/PageMetaData.php";
include_once "../../aahelpers/TopMenu.php";
include_once '../../aahelpers/common-functions.php';
include_once "../SectionMenu.php";

include_once '../GuidningsTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');

$pageMetaData->setAdditionalJavaScriptFiles('bokningar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2022-03-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$pageMenu = New TopMenu($language);

$texts = new GuidningsTexter($language);
$pageMenu->setGuidningSelected();

$sectionMenu = new SectionMenu($language);
$sectionMenu->setBokningSelected();

?>
<?php echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
<div class="basePage">

    <?= getBannerHTML('/guidning/guidevinjett.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
    <div class="d-flex mt-2">
        <div class="pb-5 mg-menu-blue">
        <?= $sectionMenu->getHTML(); ?>
        </div>
        <div class="std cal-nav-wide">
            <div id="bookingsCalendar" class="pt-2"></div>
            <div class="center-child">
                <p class="middle">
                    <small id="selectPanelSelect"></small><br/>
                </p>
            </div>
        </div>

        <div class="container-fluid pt-2">
            <div>
                <h2 id="bookingHeader">Bokningar</h2>
                <p id="bookingInfo"></p>
            </div>
            <h5 id="selectedDate"></h5>
            <div>
                <ul class="list-group list-group-flush" id="bookingList">
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center pt-3">
        <div class="row">
            <p>
                <?= $texts->getTxt('support') ?>
            </p>
        </div>
    </div>
    <div class="d-flex justify-content-center pt-3">
        <div class="d-flex justify-content-center">
            <img src="/bilder/sfrlogoh48px.gif" class="img-responsive" width="83" height="48" alt="logga"><br>
        </div>
        <div class="d-flex justify-content-center">
            &nbsp;&nbsp;
        </div>
        <div class="d-flex justify-content-center">
            <img src="/bilder/vellinge.gif" class="img-responsive" width="77" height="48" alt="logga">
        </div>
    </div>
    <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>
</div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());