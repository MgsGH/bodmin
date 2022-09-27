<?php
/**
 * Created by PhpStorm.
 * User: magnu
 * Date: 5/18/2019
 * Time: 6:17 PM
 */

class PublikationerTexter
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
            'page-title' => 'Publikationer',
            'header' => 'Publikationer - Meddelanden från Falsterbo Fågelstation',
            'header-text' => 'De flesta publikationer med anknytning till fågelstationens verksamhet ingår, alltsedan starten 1955, i serien  "Meddelanden från Falsterbo Fågelstation". En majoritet är uppsatser som publicerats i fågeltidskrifter. Flera böcker ingår också och, för första gången 2007 men säkert återkommande, en Internetpublicering. För nästan alla, utom böckerna, finns nedladdningsbara pdf-filer.',
            'sortering-fallande-ar' => 'Nyast',
            'sortering-stigande-ar' => 'Äldst',
            'filtrera' => 'Filtrera',
            'sortering' => 'Sortera på år',
            'sorting-desc' => 'Fallande - nyast först',
            'sorting-asc' => 'Stigande - äldst först',
            'forfattare' => 'Författare',
            'visa' => 'Välj art',
            'alla' => 'Alla',
            'nyckel-ord' => 'Nyckelord',
            'art' => 'Art',
            'visa-knapp' => 'Visa publikationer',
            'search-result-intro' => 'Här visas de publikation(er) som matchar dina val.',
            'search-result-noof' => 'Det finns ',
            'search-result-efter-flera' => ' publikationer som matchar din sökning. ',
            'search-result-efter-en' => ' publikation som matchar din sökning. ',
            'search-result-info' => 'För artiklar på svenska som har engelsk sammanfattning visas den engelska titeln efter den svenska.',
            'xxx' => '------------------------------------------------paginering-----------------------------',
            'next' => 'Nästa',
            'prev' => 'Föregående',
            'first' => 'Första',
            'last' => 'Sista',
            'sidan' => 'sidan',
            'av' => 'av',
            'sida' => 'sida',
            'sidor' => 'sidor',



         'sammanställt' => 'Sammanställt av Björn Malmhagen.'

        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Publications',
            'header' => 'Publications - Notes from Falsterbo Bird Observatory.',
            'header-text' => 'The vast majority of the publications linked to Falsterbo Bird observatory are, since the very beginning back in 1955, included in a series called “Notes from Falsterbo Birdobservatory”. Most of those are articles published in various ornithological journals. Several stand-alone books have also been published over the years. In this section, all publications can be searched, and except the books which are sold separately, also downloaded in PDF format.',
            'sorting-desc' => 'Newest first',
            'sorting-asc' => 'Oldest first',
            'sortering' => 'Sort by years as',
            'forfattare' => 'Author',
            'alla' => 'All',
            'filtrera' => 'Filter',
            'nyckel-ord' => 'Keyword',
            'art' => 'Species',
            'search-result-intro' => 'Below are/is the the publication(s) matching your choices shown.',
            'search-result-noof' => 'There are/is ',
            'search-result-efter-flera' => ' publications matching your search. ',
            'search-result-efter-en' => ' publication matching your search. ',

            'search-result-info' => 'For papers in Swedish with English summary, the English title is shown below the Swedish one.',
            'xxx' => '------------------------------------------------paginering-----------------------------',
            'next' => 'Next',
            'prev' => 'Prev',
            'first' => 'First',
            'last' => 'Last',
            'sidan' => 'page',
            'av' => 'out of',
            'sida' => 'page',
            'sidor' => 'pages',

            'dummy' => ''
        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }


}