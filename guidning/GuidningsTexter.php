<?php

class GuidningsTexter
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
            'page-title' => 'Guidning',
            'header' => 'Grupper',
            'intro-i' => 'En viktig del av fågelstationens arbete är folkbildning. Vi erbjuder därför olika typer utåtriktade och folkbildande aktiviteter.',
            'intro-ii' => '<strong>Gruppguidningarna</strong> som beskrivs på denna sida är störst i omfattning och erbjuds både vår och höst. Därutöver har vi fria <a href="/guidning/fyrbrinken">kom-som-du-är guidningar</a> under veckosluten på hösten.',
            'header-text' => 'Kom på en guidning och lär mer om fåglar och fågelflyttning vid Falsterbo! Varje år guidar vi mer än 5 000 personer här. De flesta är skolbarn, men alla grupper är välkommna. En guidning omfattar alltid ringmärkning av några fåglar, ett mycket populärt inslag.',
            'lokal' => 'Lokal, omständigheter, samt referens',
            'seasons' => 'Säsonger',
            'intro' => 'Under ringmärkningssäsongerna (april-maj samt augusti-oktober) tar vi emot grupper&nbsp; (skolklasser, dagisgrupper, föreningar, företag m.fl.). Guidningarna äger rum vid Falsterbo fyr, företrädesvis under morgnar och förmiddagar.',
            'innehall-header' => 'Innehåll',
            'innehall' => 'En ordinär gruppguidning varar ungefär en timme och bland annat ingår följande moment (anpassade efter åldersgruppen).',
            'orientering' => '<b>Orientering om Falsterbonäset</b><br>Geografiskt läge, naturtyp, koncentrationen av flyttfåglar.',
            'flyttning' => '<b>Beskrivning av fåglar och fågelflyttning</b><br>Fåglarnas utveckling och anpassning. Nutidens dinosaurier! Hur och varför flyttar fåglarna? Orientering, flyttningsstrategi, flygteknik m.m.',
            'stationen' => '<b>Fågelstationens verksamhet</b><br>Varför behövs en fågelstation? Exempel på resultat. Särskild vikt läggs vid miljöövervakning. Beståndsväxlingar hos såväl lokalt häckande fågelarter som hos nordiska flyttfåglar följs vid Falsterbo.',
            'markning' => '<b>Ringmärkning av nyinfångade fåglar</b><br>Ingår alltid.',
            'boka-header' => 'Boka tid',
            'boka-intro' => 'Telefon 0736-254 256, vardagar, helst eftermiddagar, före kl. 18:00. eller via' ,
            'boka-epost' => 'e-post',
            'klick' => 'Klicka här',
            'kalender' => 'Här kan du <a href="/guidning/bokningar/">se bokingsläget</a>',
            'pris-header' => 'Avgift',
            'pris-1' => 'För skolor, förskolor, föreningar och andra icke vinstdrivande organisationer: 50 kr/person eller minst 500 kr (för grupper med färre än 10 deltagare).',
            'pris-2' => 'För företag och andra vinstdrivande organisationer: 100 kr/person eller minst 1 000 kr (för grupper med färre än 10 deltagare).',
            'exkursioner-header' => 'Exkursioner i omgivningen',
            'exkursioner-1' => 'Kan anordnas efter särskild överenskommelse. Priset är beroende på tidsperiod och omfattning.',
            'exkursioner-2' => 'Kontakta P-G Bentz 0708-561900 eller <a href="mailto:pgb@sturnus.se">pgb@sturnus.se</a> för upplysningar och bokning.',
            'support' => 'Guidningarna stöds av:',
            '--dummy--' => '-',
            'lagom-tempo-header' => 'Fågelskådning i lagom tempo',
            'lagom-tempo-i' => 'Skåda tillsammans med P-G Bentz. Varje lördag och söndag 23 augusti – 26 oktober.',
            'lagom-tempo-ii' => 'Guiden finns på plats vid Falsterbo fyr från kl. 08. Kom när det passar. Gratis.',
            'lagom-tempo-iii' => 'Ingen förhandsanmälan. Klädsel efter väderlek. Stövlar behövs inte. Ta gärna med kikare, eller köp en fyrshopen som också är öppen!',

            );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Guiding',
            'header' => 'Groups',
            'intro-i' => 'An important part of the work at the bird observatory is outreach. We offer face-to-face guiding in two formats.',
            'intro-ii' => 'The <strong>group guidings</strong> elaborated below is the largest offered both spring and autumn. I addition, during autumn week ends, we have free <a href="/guidning/fyrbrinken/?lang=en">walk-in guidings</a>.',
            'header-text' => 'Join a guiding and learn more about the birds at Falsterbo! Every year more than 5,000 people are guided at Falsterbo Bird Observatory. A guiding always includes ringing of some birds, a very appreciated feature.',
            'lokal' => 'Locality, circumstances and reference',
            'seasons' => 'Seasons',
            'intro' => 'During ringing seasons (April-May and August-October) we guide groups (school children, birdwatchers and many others). These guidings take place at the Falsterbo Lighthouse.',
            'innehall-header' => 'Content',
            'innehall' => 'A guiding lasts for about an hour and the following topics are included (adjusted to the age of participants).',
            'orientering' => '<b>Falsterbo peninsula - site orientation</b><br>Geographic situation, nature, concentration of migratory birds.',
            'flyttning' => '<b>Birds and Bird Migration</b><br>How birds have developed and adapted from being Dinosaurs! How and why do birds migrate? Orientation, migration strategies, flight performance etc.',
            'stationen' => '<b>The Falsterbo Bird Observatory</b><br>The need and benefit of Bird Observatories. Examples of research results. Special attention is paid to monitoring and environmental surveillance. Population changes in migrants from the Nordic countries as well as in local breeding birds are registered at Falsterbo.',
            'markning' => '<b>Ringing of recently trapped birds</b><br>Always included.',
            'boka-header' => 'Booking',
            'boka-intro' => 'Telephone +46 (0)736-254 256, weekdays, preferably during afternoons until 18:00, or' ,
            'boka-epost' => 'e-mail',
            'klick' => 'Click here',
            'kalender' => 'Click here <a href="/guidning/bokningar/?lang=en"> to view the booking status</a>',
            'pris-header' => 'Fees',
            'pris-1' => 'Non-profit organisations: SEK 50 per person (minimum SEK 500 for groups of less than 10 persons).',
            'pris-2' => 'Businesses etc: SEK 100 per person (minimum SEK 1,000 for groups of less than 10 persons).',
            'exkursioner-header' => 'Excursions in the area',
            'exkursioner-1' => 'May be arranged after special agreements. Price is dependent on time and effort.',
            'exkursioner-2' => 'Please contact P-G Bentz +46 708-561900 or <a href="mailto:pgb@sturnus.se">pgb@sturnus.se</a> for more information and booking.',
            'support' => 'The guidning work is kindly supported by:',
            '--dummy--' => '-',
            'lagom-tempo-header' => 'Walk in guiding - or birdwatching at a pleasant pace',
            'lagom-tempo-i' => 'Casual quality birding together with P-G Bentz. Every saturday and sunday, 23 august – 26 october.',
            'lagom-tempo-ii' => "The guide start at 8 o'clock at the sea side of the lighthouse garden. Come whenever it suits you, stay as long as you wish. Free.",
            'lagom-tempo-iii' => 'No booking needed. English spoken. Cloths according to weather (bear in mind - it is often windy), but no boots needed. Bring binoculars if you have or buy a pair in the lighthouse shop which is open!'

        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }


}