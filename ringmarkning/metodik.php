<?php

include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";

include_once "RingTexter.php";
include_once "RingmarkningMenu.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('metodik.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);


//footer info
$introText = ' ';
$updatedDate = '2021-09-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setMetodikSelected();

echo getHtmlHead('', $pageMetaData, $language);

?>

    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('m-header') ?> </h2>
                <h3><?php echo $texts->getTxt('m-sub-header-standard') ?> </h3>
                <p><?php echo $texts->getTxt('m-intro') ?> </p>
                <p><?php echo $texts->getTxt('para-1') ?> </p>
                <?php echo $texts->getTxt('m-tbl-data-intro') ?>

                <table class="table table-striped table-sm w-auto">
                    <thead class="thead-light">
                        <tr>
                            <th class="x"><?php echo $texts->getTxt('tbl-hdr-plats') ?></th>
                            <th class="text-nowrap"><?php echo $texts->getTxt('tbl-hdr-start') ?></th>
                            <th class="text-nowrap"><?php echo $texts->getTxt('tbl-hdr-stop') ?></th>
                            <th class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $texts->getTxt('tbl-hdr-dagar') ?></th>
                            <th class="xw45 text-center"><?php echo $texts->getTxt('tbl-hdr-timmar-per-dag') ?></th>
                            <th class="xw45 text-center"><?php echo $texts->getTxt('tbl-hdr-nat') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="lokal text-nowrap"><?php echo $texts->getTxt('tbl-lokal-fyren-var') ?></td>
                            <td class="text-nowrap"><?php echo $texts->getTxt('tbl-data-21mars') ?></td>
                            <td class="to text-nowrap"><?php echo $texts->getTxt('tbl-data-10juni') ?></td>
                            <td class="right-with-margin">82</td>
                            <td class="centered">4</td>
                            <td class="centered">max 21</td>
                        </tr>
                        <tr>
                            <td class="lokal text-nowrap"><?php echo $texts->getTxt('tbl-lokal-fyren-host') ?></td>
                            <td class="text-nowrap"><?php echo $texts->getTxt('tbl-data-21juli') ?></td>
                            <td class="to text-nowrap"><?php echo $texts->getTxt('tbl-data-10november') ?></td>
                            <td class="right-with-margin">113</td>
                            <td class="centered">6</td>
                            <td class="centered">max 21</td>
                        </tr>
                        <tr>
                            <td class="lokal text-nowrap"><?php echo $texts->getTxt('tbl-lokal-flommen') ?></td>
                            <td class="text-nowrap"><?php echo $texts->getTxt('tbl-data-21juli') ?></td>
                            <td class="to text-nowrap"><?php echo $texts->getTxt('tbl-data-30september') ?></td>
                            <td class="right-with-margin">72</td>
                            <td class="centered">6</td>
                            <td class="centered">max 20</td>
                        </tr>
                    </tbody>
                </table>
                <p><?php echo $texts->getTxt('para-2') ?> </p>
                <p><?php echo $texts->getTxt('para-3') ?> </p>
                <h2><?php echo $texts->getTxt('m-header-antal') ?> </h2>
                <p><?php echo $texts->getTxt('para-4') ?> </p>
                <p><?php echo $texts->getTxt('para-5') ?> </p>
                <p><?php echo $texts->getTxt('para-6') ?> </p>
                <p><?php echo $texts->getTxt('spearman') ?> </p>

                <h2><?php echo $texts->getTxt('m-header-topografi') ?> </h2>
                <p><?php echo $texts->getTxt('para-7') ?> </p>
                <p><?php echo $texts->getTxt('para-8') ?> </p>
                <p><?php echo $texts->getTxt('para-9') ?> </p>
                <p><?php echo $texts->getTxt('para-10') ?> </p>
                <p><?php echo $texts->getTxt('para-11') ?> </p>

                <h2><?php echo $texts->getTxt('m-header-urval') ?> </h2>
                <p><?php echo $texts->getTxt('para-12') ?> </p>
                <p><?php echo $texts->getTxt('para-13') ?> </p>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());