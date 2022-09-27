<?php
/**
 * Created by PhpStorm.
 * User: magnu
 * Date: 5/18/2019
 * Time: 6:27 PM
 */

class RastTexter
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
            'page-title' => 'Rastfågelräkning',
            'header' => 'Rastfågelräkning',
            'header-text' => 'En gång i veckan räknas rastande fåglar runt Falsterbonäsets kuster. <br>Räkningarna startade vintern 1992-93. Avsikten är att ha ett tidsmässigt heltäckande material, som kan visa hur fåglarna utnyttjar olika områden och vilka antalsförändringar som sker såväl kort- som långsiktigt.',
            'lokal' => 'Lokal, omständigheter, samt referens',
            'second-header' => 'Senaste veckan räknad',
            'vecka' => 'vecka',
            'vecka-som-visas' => 'Vecka som visas',
            'vecko-intro' => 'Se resultat från en vald vecka! <strong>Fetstil</strong> anger senast inmatade vecka.',
            'lokaler' => 'Lokaler',
            'kanalen' => 'Falsterbokanalen',
            'art' => 'Art',
            'summa' => 'Summa',
            'intro-i' => 'Håll musen över förkortningarna i tabellhuvudet för att se lokalernas fullständiga namn.',
            'intro-ii' => 'De gula markeringarna visar lokalerna för rastfågelräkning.',
            'select-header' => 'Välj',
            'visa-knapp' => 'Visa urval',
            'lokaler-header' => 'Lokaler',
            'Ar:' => 'År:',
            'Ar' => 'År',
            'Vecka:' => 'Vecka:',
            'Vecka' => 'Vecka',
            'bladdra' => 'Bläddra',
            'bladdra-vecka' => 'vecka',
            'bladdra-ar' => 'år',
            '-' => 'end'


        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Staging birds',
            'header' => 'Staging birds',
            'header-text' => 'Once a week, throughout the year, staging birds are counted along the coast of the peninsula. These counts started in the winter of 1992-93 with the aim to obtain a long-term data set, showing how birds use certain areas at different times of the year, and how numbers change both within and between years.',
            'lokal' => 'Locality, circumstances and reference',
            'second-header' => 'Most recent count',
            'lokaler' => 'Localities',
            'vecka' => ' week ',
            'vecka-som-visas' => 'Week shown',
            'vecko-intro' => 'See the result from a selected week. <strong>Bold</strong> indicates most recently entered weekly count.',
            'kanalen' => 'Falsterbo canal',
            'art' => 'Species',
            'summa' => 'Sum',
            'intro-i' => 'Hover the mouse over the locality abbreviations to see their full names',
            'intro-ii' => 'The yellow markers indicates the staging monitoring localities.',
            'select-header' => 'Select',
            'visa-knapp' => 'Show selection',
            'lokaler-header' => 'Localities',
            'ar' => 'Year:',
            'Ar:' => 'Year:',
            'Ar' => 'Year',
            'Vecka:' => 'Week:',
            'Vecka' => 'Week',
            'bladdra' => 'Browse',
            'bladdra-vecka' => 'week',
            'bladdra-ar' => 'year',
            '-' => 'end'

        );

        return $texts;
    }

    public function getTxt($txt){
        return $this->texts[$txt];
    }


}