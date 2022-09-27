<?php


class StrackHeaderTexter
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
            'page-title' => 'Sträckräkning',
            'header' => 'Sträckräkning' ,
            'header-text' => 'Sträckräkning har bedrivits vid Falsterbo i olika perioder sedan Gustaf Rudebecks pionjärstudier i början av 1940-talet. Den nuvarande serien har pågått oavbruten sedan hösten 1973 och ingår sedan 1978 i Naturvårdsverkets övervakning av populationsförändringar hos fåglar.'

        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Migration monitoring',
            'header' => 'Migration monitoring',
            'header-text' => 'Migration counts at Falsterbo started with Gustaf Rudebeck\'s studies in the early 1940s. Since 1973 an unbroken series of counts is running. From 1978 onwards the counts are included in the Bird Monitoring Programme run by The Swedish Environmental Protection Agency (Naturvårdsverket). '

        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }


}