<?php

class ShopTexter
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
            'page-title' => 'Webshop',
            'header' => 'Välkommen till SkOFs och Falsterbo Fågelstations webshop.',
            'header-text' => 'SkOFs och Falsterbo Fågelstations verksamheter bygger i hög grad på ideellt arbete med ringa ekonomisk ersättning. Genom att köpa våra böcker, dekaler, vykort m.m. stöder du arbetet för ett starkare fågelskydd i Skåne och den fortsatta verksamheten vid Falsterbo Fågelstation. Du beställer varorna här och betalar mot faktura som medföljer leveransen. Postens avgifter tillkommer.',
            'lokal' => 'Lokal, omständigheter, samt referens'

        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Web shop',
            'header' => 'Web shop',
            'header-text' => 'Most activities at SkOF and Falsterbo B.O. relays on voluntary efforts and work with little or no economic benefit. By purchasing books, postcards, stickers binoculars and other items from our webshop you make a contribution to the protection of birds in southern Sweden and to the work at Falsterbo Bird Observatory. You order your items here and then you pay at delivery. Invoice comes with the ordered items. N.B. Postage is always extra.',
            'lokal' => 'Locality, circumstances and reference'
        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }


}