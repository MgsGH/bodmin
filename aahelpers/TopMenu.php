<?php

class TopMenu
{

    // ease set/get
    const Start = 0;
    const Markning = 1;
    const Strack = 2;
    const Guidning = 3;
    const RastFagel = 4;
    const DagBok = 5;

    const Lokaler = 6;
    const ArtLista = 7;
    const Galleri = 8;

    const Jobb = 9;
    const Logi = 10;
    const Publikationer = 11;

    //const WebShop = 12;
    const OmOss = 12;

    var array $links;
    var string $language;

    public function __construct($lang)
    {
        $this->language = 'sv';
        if (isset($lang)) {
            $this->language = $lang;
        }

        $texts = $this->getTexts();
        $theLinks = $this->getTheLinks();

        $this->links = array(
            array($theLinks['start'], $texts['start'], false, true ),
            array($theLinks['ringing'], $texts['ringing'], false, true ),
            array($theLinks['sträck'], $texts['sträck'], false, true ),
            array($theLinks['guidning'], $texts['guidning'], false, true ),
            array($theLinks['raststfågelräkning'], $texts['raststfågelräkning'], false, true ),
            array($theLinks['dagbok'], $texts['dagbok'], false, true ),

            array($theLinks['fågellokaler'], $texts['fågellokaler'], false, true ),
            array($theLinks['artlista'], $texts['artlista'], false, true ),
            array($theLinks['galleri'], $texts['galleri'], false, true ),

            array($theLinks['jobb'], $texts['jobb'], false, true ),
            array($theLinks['logi'], $texts['logi'], false, true ),
            array($theLinks['publikationer'], $texts['publikationer'], false, true ),

            array($theLinks['OmOss'], $texts['OmOss'], false, true )
        );

    }


    function getTexts(): array {

        // default Swedish

        $texts = array(
            'start' => 'Hem',
            'ringing' => 'Ringmärkning',
            'sträck' => "Sträck",
            'guidning' => 'Guidning',
            'raststfågelräkning' => 'Rastfågelräkning',
            'dagbok' => 'Dagbok',
            'fågellokaler' => 'Lokaler',
            'artlista' => 'Artlista',
            'galleri' => 'Galleri',
            'jobb' => 'Jobb',
            'logi' => 'Logi',
            'publikationer' => 'Publikationer',
            'webshop' => 'Webshop',
            'OmOss' => 'Om stationen'
        );


        if ($this->language === 'en'){
            $texts = array(
                'start' => 'Home',
                'ringing' => 'Ringing',
                'sträck' => "Migration monitoring",
                'guidning' => 'Guiding',
                'raststfågelräkning' => 'Staging birds',
                'dagbok' => 'Blog',
                'fågellokaler' => 'Sites',
                'artlista' => 'Species',
                'galleri' => 'Gallery',
                'jobb' => 'Jobs',
                'logi' => 'Lodging',
                'publikationer' => 'Publications',
                'webshop' => 'Webshop',
                'OmOss' => 'About us'

            );
        }

        return $texts;

    }


    function getTheLinks(): array
    {

        // Default Swedish
        $theLinks = array(
            'start' => '/',
            'ringing' => '/ringmarkning/dagssummor/',
            'sträck' => "/strack/dagssummor/",
            'guidning' => '/guidning/',
            'raststfågelräkning' => '/rastrakning/',
            'dagbok' => '/blog/',
            'fågellokaler' => '/lokaler/',
            'artlista' => '/taxa/',
            'galleri' => '/galleri/',
            'jobb' => '/jobb/',
            'logi' => '/logi/',
            'publikationer' => '/publikationer/',
            'webshop' => '/shop/',
            'OmOss' => '/omoss/'
        );


        if ($this->language === 'en'){
            $theLinks = array(
                'start' => '/index.php?lang=en',
                'ringing' => '/ringmarkning/dagssummor/index.php?lang=en',
                'sträck' => "/strack/dagssummor/index.php?lang=en",
                'guidning' => '/guidning/index.php?lang=en',
                'raststfågelräkning' => '/rastrakning/index.php?lang=en',
                'dagbok' => '/blog/index.php?lang=en',
                'fågellokaler' => '/lokaler/index.php?lang=en',
                'artlista' => '/taxa/index.php?lang=en',
                'galleri' => '/galleri/index.php?lang=en',
                'jobb' => '/jobb/index.php?lang=en',
                'logi' => '/logi/index.php?lang=en',
                'publikationer' => '/publikationer/index.php?lang=en',
                'webshop' => '/shop/index.php?lang=en',
                'OmOss' => '/omoss/index.php?lang=en'
            );
        }

        return $theLinks;

    }


    function setStartSidaSelected(){
        $this->links[TopMenu::Start][2] = true;
    }

    function setArtListaSelected(){
        $this->links[TopMenu::ArtLista][2] = true;
    }

    function setDagBokSelected(){
        $this->links[TopMenu::DagBok][2] = true;
    }

    function setLokalerSelected(){
        $this->links[TopMenu::Lokaler][2] = true;
    }

    function setGalleriSelected(){
        $this->links[TopMenu::Galleri][2] = true;
    }

    function setGuidningSelected(){
        $this->links[TopMenu::Guidning][2] = true;
    }

    function setJobbSelected(){
        $this->links[TopMenu::Jobb][2] = true;
    }

    function setLogiSelected(){
        $this->links[TopMenu::Logi][2] = true;
    }

    function setPublikationerSelected(){
        $this->links[TopMenu::Publikationer][2] = true;
    }

    function setRastFagelSelected(){
        $this->links[TopMenu::RastFagel][2] = true;
    }

    function setMarkningSelected(){
        $this->links[TopMenu::Markning][2] = true;
    }

    function setStrackSelected(){
        $this->links[TopMenu::Strack][2] = true;
    }


    function setOmOssSelected(){
        $this->links[TopMenu::OmOss][2] = true;
    }


    function getHTML(): string {
        $newRow = "\n\r";
        $var = "<div class=\"topnav\"> \n\r";
        // Top-bar navigation links
        foreach($this->links as $page){

            if ($page[3]) {
                if ($page[2]) {
                    $link = "<a class=\"active\" href=\"" . $page[0] . "\">" . $page[1] . "</a>";
                } else {
                    $link = "<a href=\"" . $page[0] . "\">" . $page[1] . "</a>";
                }
            } else {
                $link = '<a href="#">' . $page[1] . "</a>";
            }


            $var = $var . $link. $newRow;
        }
        // Language switch upper right corner
        // if we run the site in Swedish - we want to be able to switch to English, and vice versa.
        $langText = 'In English ';
        $iconImageName = 'GB.png';
        if ($this->language == 'en'){
            $langText = 'På Svenska ';
            $iconImageName = 'SE.png';
        }

        $imgPart = '<img src="/bilder/icons/' . $iconImageName . '" class="img-responsive mg-top-threeX imgInLine" width="24" height="15">';
        $link = $this->getLinkToThisPageInOtherLanguae();

        $var = $var . '<a href="'. $link . '">' . $langText . $imgPart . '</a> ' . $newRow;
        $var = $var . '</div>';

        return $var;
    }



    /*
     *  Swedish is default. A somePage.php?language='en' -> somePage.php for Swedish
     *
     */
    function getLinkToThisPageInOtherLanguae(){

        $thisURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $thisBasePage = "http://$_SERVER[HTTP_HOST]";
        $thisPath = parse_url($thisURL, PHP_URL_PATH);
        $thisPage  = $thisBasePage . $thisPath;
        $queryStr = parse_url($thisURL, PHP_URL_QUERY);
        parse_str($queryStr, $queryParams);

        if (sizeof($queryParams) == 0){  // we are coming with no other params set(swedish) -> add language parameter
            $thisNewPageUrl = $thisPage . '?lang=' . $this->getTargetLanguage();
        } else {

            // We have some parameters set.

            if (array_key_exists('lang', $queryParams)){
                // and lang is one of them, thus we run the site in english, remove the language
                // remove it
                unset($queryParams['lang']);

            } else {
                // we run the sie in Swedish with some other parameters set, add the lang parameter.
                $queryParams['lang'] = 'en';
            }

            $newQueryString = http_build_query($queryParams);

            if (strlen($newQueryString) > 0 ){
                $thisPage = $thisPage . '?' . $newQueryString;
            }
            $thisNewPageUrl = $thisPage;
        }



        return $thisNewPageUrl;

    }

    function getTargetLanguage(){

        $targetLanguage = 'en';
        // the below should never occur..
        if ($this->language == 'en') {
            $targetLanguage = 'sv';
        }

        return $targetLanguage;
    }
}