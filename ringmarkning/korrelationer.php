<?php
session_start();
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "ringmarkning-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('korrelationer.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2021-11-29';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();


$_SESSION['lang'] = $language;
$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$selectShowHow = getSessionThenRequestLastDefaultValue('showHow', 'om');
$_SESSION['showhow'] = $selectShowHow;
$selectShowWhat = getSessionThenRequestLastDefaultValue('showWhat', 'pr');
$_SESSION['showwhat'] = $selectShowWhat;

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setPopTrenderSelected();
$radioGroupName = "showHow";
$radioGroupNameWhat = "showWhat";

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

            <div class="std cal-nav">
                <div class="pt-2">
                    <h5><?php echo $texts->getTxt('mo-select-hdr') ?></h5>
                </div>

                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                    <br/>
                    <strong><?php echo $texts->getTxt('mo-oversikt-show-how') ?></strong><br/>
                    <?php echo getRadioButton("om", $radioGroupName, "om", $selectShowHow ) ?><label for="om"><?php echo $texts->getTxt('mo-oversikt-show-om') ?></label> <br>
                    <?php echo getRadioButton("sy", $radioGroupName, "sy", $selectShowHow ) ?><label for="sy"><?php echo $texts->getTxt('mo-oversikt-show-sys') ?></label><br>
                    <br/>
                    <strong><?php echo $texts->getTxt('mo-oversikt-show-what') ?></strong><br/>
                    <?php echo getRadioButton("pr", $radioGroupNameWhat, "pr", $selectShowWhat ) ?><?php echo $texts->getTxt('mo-oversikt-show-pref') ?><br/>
                    <?php echo getRadioButton("all", $radioGroupNameWhat, "all", $selectShowWhat ) ?><?php echo $texts->getTxt('mo-oversikt-show-all') ?><br/>
                    <br/>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $texts->getTxt('visa-data-knapp') ?>
                        </button>
                    </div>

                </form>
                <hr>
                <div>
                    <p><?php echo $texts->getTxt('mo-oversikt-intro-i') ?></p>
                    <p><?php echo $texts->getTxt('mo-oversikt-intro-ii') ?></p>
                    <?php writeSignificanceLegend($texts) ?>
                    <br/>
                </div>
            </div>

            <div class="std">
                <h2> <?php echo $texts->getTxt('mo-oversikt-hdr') ?> </h2>
                <?php
                if ($selectShowWhat == 'all'){  ?>

                    <h3><?php echo $texts->getTxt('mo-all-species') ?> </h3>
                    <div class="d-flex">
                        <div>
                            <h4><?php echo $texts->getTxt('FA') ?> </h4>
                            <?php writePopTrendsTableSeason($pdo, $language, $selectShowHow, $texts, 'FA') ?>
                        </div>
                        <div class="px-2">
                            <h4><?php echo $texts->getTxt('FB') ?></h4>
                            <?php writePopTrendsTableSeason($pdo, $language, $selectShowHow, $texts, 'FB') ?>
                        </div>
                        <div>
                            <h4><?php echo $texts->getTxt('FC') ?></h4>
                            <?php writePopTrendsTableSeason($pdo, $language, $selectShowHow, $texts, 'FC') ?>
                        </div>
                    </div>

                <?php } ?>


                <?php
                if ($selectShowWhat == 'pr'){  ?>
                    <h3><?php echo $texts->getTxt('mo-best-fit') ?> </h3>

                    <div class="d-flex">
                        <div>
                            <h4 class="green"><?php echo $texts->getTxt('mo-increasing') ?> </h4>
                            <?php writePopTrendsTableIncresing($pdo, $language, $selectShowHow, $texts) ?>
                        </div>
                        <div class="px-2">
                            <h4><?php echo $texts->getTxt('mo-stable') ?></h4>
                            <?php writePopTrendsTableStable($pdo, $language, $selectShowHow, $texts) ?>
                        </div>
                        <div>
                            <h4 class="alarm"><?php echo $texts->getTxt('mo-decreasing') ?></h4>
                            <?php writePopTrendsTableDecreasing($pdo, $language, $selectShowHow, $texts) ?>
                        </div>
                    </div>
                <?php } ?>

                <p class="info"></p>

            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());