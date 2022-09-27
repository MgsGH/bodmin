<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/omoss/OmStationenTexter.php';
include_once $path . '/omoss/OmOssMenu.php';
include_once $path . '/aahelpers/PageMetaData.php';
include_once $path . '/aahelpers/TopMenu.php';
include_once $path . '/aahelpers/common-functions.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('kontakt.js?dummy=' . $t);

//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';


$language = getRequestLanguage();

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setKontaktSelected();

?>

<?=  getHtmlHead('', $pageMetaData, $language); ?>
    <div class="basePage">
        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?=  $sectionMenu->getHTML(); ?>
            </div>


            <div class="std">
                <div class="pb-2">
                    <h2 id="kontakt-header"></h2>
                </div>
                <div class="container">
                    <p id="intro">Falsterbo fågelstation har inte behörighet att ta hand om skadade djur för rehabilitering, se vidare nedan.</p>
                </div>
                <div class="d-flex">
                    <div class="container">
                        <h3 id="hdrSkadadeFaglar">Skadade fåglar och ungar</h3>
                        <img class="rounded mx-auto d-block pt-3 pb-3" src="/omoss/images/redcross.jpg" alt="brevduva" width="150" height="160"/>
                        <p id="kfv"></p>

                    </div>

                    <div class="container">
                        <h3 id="hdrBrevDuvor">Brevduvor</h3>
                        <p>
                            <img src="/omoss/images/brevduva.jpg" alt="brevduva" width="210" height="140" style="float:right" class="shadow"/><span id="brevDuveIntro">Brevduvor är mycket variabla. Bilden nedan visar en ganska modest färgad individ med de typiska färgade ringarna.</span>
                        </p>
                        <p id="brevDuveLink"></p>
                    </div>
                </div>
                <h3 id="kontakt-sub-header"></h3>
                <div class="d-flex pt-3">
                    <div>

                        <div class="container">
                            <h5 id="general">Allt</h5>
                            <a href="mailto:falsterbo@skof.se">falsterbo@skof.se</a><br>
                            <span id="telefon-no">0736-254 256</span><br>
                        </div>

                        <div class="container mt-3">
                            <h5><span id="inbetalningar">Inbetalningar</span></h5>
                            <span id="payments">Betalningar (varor, logi, guidningar)</span><br>
                            <span id="mottagare">Betalningsmottagare</span>: Skånes Ornitologiska Förening<br>

                            <div class="mt-1">
                                Bg 525-9197<br>
                                Swish 123 196 2455<br>
                            </div>
                            <h5 class="mt-3"><span id="bidrag"></span></h5>
                            <p>
                                <span id="donations"></span><br>
                                <span id="mottagareTwo">Betalningsmottagare</span>: Skånes Ornitologiska Förening<br>
                                Bg 900-3013<br>
                                Pg 900301-3<br>
                            </p>

                            Sophie Ehnbom: <span id="sophie-telefon">0705-685810</span><br/>
                            Björn Malmhagen: <a href="mailto:bjorn@falsterbofagelsation.se">bjorn@falsterbofagelsation.se</a><br>

                        </div>

                    </div>
                    <div>
                        <div class="container">
                            <h5><span id="guidings">Guidningar</span></h5>
                            <span id="guidingsIntro">Guidningar</span> <a href="https://www.google.com/maps/place/Falsterbo+Fyr+-+anno+1796/@55.3837094,12.8141724,17z/data=!3m1!4b1!4m5!3m4!1s0x46530e4d17a2a291:0xcc916be587cd924b!8m2!3d55.3837094!4d12.8163611"><span id="gVar">Falsterbo Fyr</span></a>.<br>
                        </div>
                        <div class="container mt-3">
                            <h5><span id="logi">Logi</span></h5>
                            <span id="logiIntro">Sjögatan, </span><span id="l-var">Falsterbo fågelstation</span><br>
                        </div>

                        <div class="container mt-3">
                            <h5><span id="post">Post address</span></h5>
                            Fyrvägen 35<br>
                            <span id="zipPrefix"></span>239 40 Falsterbo<br/>
                            <span id="country"></span>
                        </div>

                    </div>
                </div>


            </div>

        </div>

        <?=  getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

