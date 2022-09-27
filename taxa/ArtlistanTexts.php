<?php

class ArtlistanTexts
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
        'page-title' => 'Artlistan',
        'header' => 'Artlistan',
        'header-text' => 'Listan omfattar arter som anträffats väster om Falsterbokanalen. Totalt har 360 arter noterats från slutet av 1800-talet t.o.m. 2014. Urvalet är gjort enligt AERCs (Association of European Rarities Committees) riktlinjer för spontan förekomst (AERC-kategori A-C). För varje art anges förekomsten per månad enligt en 5-gradig skala samt häckningsstatus. Dra muspekaren i tabellen för teckenförklaringar.',
        'senast-ändrad' => 'Senast ändrad:',
        'sammanställt' => 'Sammanställt av Björn Malmhagen.',

     );

     return $texts;
}

function getTextsEn(){

     $texts = array(
        'page-title' => 'Species list',
        'header' => 'Species list',
        'header-text' => 'The list includes all known records of birds encountered west of Falsterbo canal from the end of the 1800 century up to 2014. In all, some 360 species have been recorded. Species listed are those that fall within the categories A-C, AERCs (Association of European Rarities Committees) guidelines for spontanious occurence. For each species a monthly occurance index is given as well as a breeding index. Hover the mouse pointer in the table for legend.',
        'senast-ändrad' => 'Last changed:',
        'sammanställt' => 'Compiled by Björn Malmhagen.',
     );

     return $texts;
}

function getTxt($txt){
    return $this->texts[$txt];
}


}