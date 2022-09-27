<?php


class GalleriTexter
{

    var $texts;

    public function __construct($language)
    {
        if ($language == 'sv'){
            $this->texts = $this->getTextsSv();
        }

        if ($language == 'en'){
            $this->texts = $this->getTextsEn();
        }

    }

    function getTextsSv(){

        $texts = array(
            'page-title' => 'Galleri',
            'header' => 'Galleri',
            'header-text' => 'I vårt fotogalleri visas bilder (huvudsakligen) tagna på Falsterbonäset. Filtrera urvalet via fotograf och art om så önskas. Klicka på bilderna för att öppna en större bild. Bilderna får inte kopieras eller användas utan fotografernas tillstånd.',
            'lokal' => 'Lokal, omständigheter, samt referens',
            'visa-vad' => 'Visa vad och hur',
            'fotograf' => 'Fotograf',
            'grupp' => 'Bildgrupp',
            'art' => 'Art',
            'alla' => 'Alla',
            'xxx' => '------------------------------------------------paginering-----------------------------',

            'av' => 'av',
            'sida' => 'sida',
            'sidor' => 'sidor',
            'rubrik' => 'Alla bilder, nyast först',
            'dummy' => '----------------------------------------------------------------'

        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Gallery',
            'header' => 'Gallery',
            'header-text' => 'Our Photo Gallery shows photos taken (mainly) at the Falsterbo Peninsula. Click on the thumbnails to view full-size images. Please consider that photos must not be copied or used without permission from the photographer.',
            'lokal' => 'Locality, circumstances and reference',
            'visa-vad' => 'Show what and how',
            'fotograf' => 'Photographer',
            'grupp' => 'Group',
            'art' => 'Species',
            'alla' => 'All',
            'xxx' => '------------------------------------------------paginering-----------------------------',
            'sidan' => 'page',
            'av' => 'out of',
            'sida' => 'page',
            'sidor' => 'pages',
            'rubrik' => 'All images, newest first',
            'yyy' => '----------------------------------------------------------------'
        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }

}