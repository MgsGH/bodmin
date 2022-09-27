<?php
/**
 * Created by PhpStorm.
 * User: magnu
 * Date: 5/18/2019
 * Time: 7:01 PM
 */

class RingTexter
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
            'common-texts' => '-----------------------------------------------------------------------',
            'species' => 'Art',
            'mo-species' => 'Arter',
            'sum' => 'Summa',
            'dags-summa-rubrik' => 'Dagssummor',
            'ssums' => 'Säsongssummor',
            'tot' => 'Totalt',
            'summa' => 'Summa',
            'l-t-a' => 'I100',
            'FA' => 'Fyren, vår',
            'FB' => 'Fyren, höst',
            'FC' => 'Flommen',
            'ÖV' => 'Övrig&nbsp;fångst',
            'PU' => 'Pullmärkning',
            'foto' => 'Foto:',
            'valj-art' => 'Välj art',
            'visa-data-knapp' => 'Visa data',
            'Mo' =>'må',
            'Tu' =>'ti',
            'We' =>'on',
            'Th' =>'to',
            'Fr' =>'fr',
            'Sa' =>'lö',
            'Su' =>'sö',
            '1' =>'januari',
            '2' =>'februari',
            '3' =>'mars',
            '4' =>'april',
            '5' =>'maj',
            '6' =>'juni',
            '7' =>'juli',
            '8' =>'augusti',
            '9' =>'september',
            '10' =>'oktober',
            '11' =>'november',
            '12' =>'december',
            'detta-ar' =>'Detta år',
            'section-texts' => '--------------------header texts--------------------------------------------------',
            'page-title' => 'Ringmärkning',
            'header' => 'Ringmärkning',
            '------' => '--------------------metod texts--------------------------------------------------',
            'header-text' => 'Ringmärkning har bedrivits vid Falsterbo sedan 1940-talet. Fr.o.m. 1980 är fångstrutinerna standardiserade. Därigenom blir fångstsiffror från olika år jämförbara och kan visa populationstrender. Dessutom är återfynd av ringmärkta fåglar fortfarande av intresse. De kan t.ex. visa ändringar av övervintringsområden.',
            'm-header' => 'Metodik',
            'm-sub-header-standard' => 'Det standardiserade fångstprogrammet',
            'm-intro' => 'Sedan 1980 bedrivs ett standardiserat fångstprogram vid Falsterbo Fågelstation (Tabell 1). Graden av standardisering har baserats på lokala förhållanden, hänsyn till fåglarna och egen mångårig erfarenhet. Syftet är att få ett material som är jämförbart från år till år och därmed kan antas spegla variationer i antal hos de fågelpopulationer, som flyttar förbi Falsterbo.',
            'para-1' => 'Fångst bedrivs på två lokaler. Dels i Fyrträdgården, en 100x100 meter stor dunge som omger Falsterbo fyr (inkl. några enstaka buskage alldeles utanför) och dels i vassarna på Södra Flommen, en knapp kilometer norrut. Vid fyren pågår fångst både under vår och höst medan fångsten på Flommen bedrivs under första hälften av hösten. Användningen av två olika fångstbiotoper gör att fler arter kan inkluderas i programmet. Vid Fyren har samma nätplatser använts under alla åren medan vi tvingats flytta några vid Flommen, beroende på vassens utbredning. Alla nät har dock alltid placerats i vass.',
            'para-2' => 'Endast japanska slöjnät (9 m långa med 16 mm maskstorlek) används. Beroende på väderleken varierar antalet dagligen använda nät. Som mest används 21 nät vid Fyren och 20 vid Flommen. Fångst bedrivs dagligen under säsongerna undantaget dagar med kraftigt regn eller hård vind. Av hänsyn till fåglarna bedrivs ingen fångst in vid dylika tillfällen.',
            'para-3' => 'Näten sätts upp innan gryningen och kontrolleras en gång i halvtimmen. Oavsett antal fåglar pågår den dagliga fångsten minst fyra (vår) eller sex timmar (höst). Under dagar med god fågeltillgång fortsätter vi tills färre än tio fåglar per timme fångas. Efter avslutad fångst tas näten bort från stängerna.',
            'tbl-hdr-plats' => 'Lokal',
            'tbl-hdr-start' => 'Från',
            'tbl-hdr-stop' => 'Till',
            'tbl-hdr-dagar' => 'Dagar',
            'tbl-hdr-timmar-per-dag' => 'Tim/Dag',
            'tbl-hdr-nat' => 'Nät',
            'tbl-lokal-fyren-var' => 'Fyrträdgården (vår)',
            'tbl-lokal-fyren-host' => 'Fyrträdgården (höst)',
            'tbl-lokal-flommen' => 'Flommen, vass (höst)',
            'tbl-data-21mars' => '21 mars',
            'tbl-data-10juni' => '10 juni',
            'tbl-data-21juli' => '21 juli',
            'tbl-data-10november' => '10 november',
            'tbl-data-30september' => '30 september',
            'm-tbl-data-intro' => 'Tabell 1. De standardiserade fångstperioderna och platserna vid Falsterbo Fågelstation.',
            'm-header-antal' => 'Antal',
            'para-4' => 'Fram t.o.m. 2007 hade 627 965 fåglar märkts inom det standardiserade programmet. Knappt två tredjedelar av denna summa utgörs av fåglar ringmärkta vid Fyren under höstarna medan endast 17% märkts under vårsäsongerna. Resterande 19% har märkts vid Flommen.',
            'para-5' => 'Figurer m.m. grundas på antal fåglar per art, säsong och lokal. Siffrorna anger antalet nymärkta (eller ommärkta) fåglar, övriga kontroller av redan ringmärkta fåglar är inte inräknade.',
            'para-6' => 'Lokala häckfåglar ingår i summorna. I de flesta fall utgör de en mycket liten del av de fångade fåglarna. För mer eller mindre residenta arter som t.ex. gråsparv och pilfink kan dock det lokala eller regionala inslaget vara mera betydande.',
            'spearman' => 'Statistiska test görs med hjälp av <a href="https://sv.wikipedia.org/wiki/Spearmans_rangkorrelation">Spearmans Rangkorrelation</a>.',
            'm-header-topografi' => 'Betydelse av topografi och väder',
            'para-7' => 'För att tolka våra siffror krävs kännedom om de speciella förhållanden som råder vid Falsterbo. Näset utgör Skandinaviens sydvästligaste spets och under hösten är huvudriktningen hos många flyttfåglar sydvästlig. På grund av ledlinjeeffekt förstärks koncentrationen av flyttande fåglar under hösten ytterligare.',
            'para-8' => 'På våren är de nordflyttande fåglarna egentligen inte alls koncentrerade till Falsterbo. Däremot kan man även under våren se fåglar sträcka ut åt sydväst. Särskilt i samband med omslag till kallt väder kan mängden retursträckare vara avsevärd och ledlinjeeffekten gör att antalet utsträckande fåglar under våren lätt överstiger antalet insträckande. I vårt material finns t.ex. en rad höga fångstsiffror för bl.a. järnsparv, taltrast, rödvingetrast och bofink i mitten på 1980-talet, som vi anser huvudsakligen beror på retursträck.',
            'para-9' => 'I vad mån detsamma gäller utpräglade nattsträckare vet vi naturligvis inte, men erfarenheten av 20 vårsäsonger är att de riktigt stora mängderna rastande (och därmed fångstbara) fåglar finner man i samband med ”dåligt väder”, dvs. när fåglar som startat sitt sträck norrut från andra sidan Östersjön i relativt varmt väder möter en kallfront på vägen. Flugsnappare, t.ex., fångas på våren nästan uteslutande under sådana förhållanden.',
            'para-10' => 'Fångsten under vårsäsongerna är därför mera nyckfull än under höstarna, vilket kan vara en orsak till de relativt få korrelationerna mellan vår- och höstsiffror. Naturligtvis finns ett inflytande av vädret även under hösten, men de riktigt extrema situationerna är per definition sällsynta och blir alltmer betydelselösa i ett långtidsperspektiv, t.ex. om man jämför tioårsmedelvärden.',
            'para-11' => 'Vi anser därför att <strong>höstsiffrorna är mera tillförlitliga för övervakning av beståndsväxlingar än vårsiffrorna</strong>, dessutom är de i allmänhet högre. <br/><br/>Däremot är såväl vår- som höstsiffror synnerligen användbara för fenologiska studier.',
            'm-header-urval' => 'Urval på websidorna',
            'para-12' => 'En nedre gräns på minst 50 ex per art och säsong har valts som villkor för att ett diagram skall visas. Denna gräns kan lätt justeras vid behov. Det betyder att en del arter med små stickprov (men ibland med intressanta trender) inkluderas. För varje art, som är aktuell för övervakning av beståndsväxlingar, finns angivet vilken säsong som är förstahandsval. Dessutom visas (i relevanta fall) statistiska signifikanstest samt kommentarer som ytterligare förklarar siffrorna.',
            'para-13' => 'Alla siffror, diagram, statistik, etc. uppdateras automatiskt vid varje årsskifte.',
            'footer-text' => 'Sammanställt av Lennart Karlsson',
            'dag-title' => 'Fångstdag - ',
            'dag-cal-title' => 'Välj en dag',
            'tbl-hdr-art' => 'Art',
            'tbl-hdr-dsum' => 'Idag',
            'tbl-hdr-tom-idag' => 'Till dagens datum',
            'tbl-hdr-ssum' => 'I år',
            'tbl-hdr-smv' => 'Medelvärde',
            'ar-intro-text-1' => 'Här visas totala årssummor för ett utvalt år från och med 1947. Från och med 1980 visas även säsongssummor från såväl den standardiserade som den övriga fångsten.  Notera att ingen riggmärking förekom 1948 och 1951.',
            'ar-intro-text-2' => 'Eftersom sifforna innehåller en varierande del "övrigt" och även boungemärkning är årssummorna inte lämpliga för jämförelse med sikte på beståndsförändringar. Här måste i stället siffror från de standardiserade säsongerna användas.',
            'ar-intro-text-3' => '',
            'ar-header-art' => 'Art',
            'ar-page-header' => 'Årssumma - ',
            'ar-header-summa' => 'Summa',
            'alla-ar' => 'Alla år',
            'visa-knapp' => 'Visa valda data',
            'visa-ar-knapp' => 'Visa valt år',
            '------------------------- säsongssidan inte många texter har ---------------------------------------' => '',
            'sasong-header' => 'Säsongssummor',
            'sasong-valj-header' => 'Välj år och säsong/typ',
            'visa-sasong-knapp' => 'Visa valt år och säsong',
            'select-season-text' => 'Säsong/typ',
            'select-year-text' => 'År',
            'season-summary' => ' arter (inklusive eventuella hybrider).',
            '------------------------- år texter ---------------------------------------' => '',
            'ar-art' => 'Art',
            'ar-standard' => 'Standariserad märkning',
            'ar-fyren-var' => 'Fyren, vår',
            'ar-fyren-host' => 'Fyren höst',
            'ar-flommen' => 'Flommen',
            'ar-ovrigt' => 'Övrigt',
            'ar-flygg' => 'Flygga',
            'ar-pull' => 'Pull',
            'ar-tot' => 'Totalt',
            '------------------------- tio-i-topp ---------------------------------------' => '',
            'art-tio-i-topp-art' => 'Välj en art',
            'art-tio-i-topp-arsum' => 'År',
            'art-tio-i-topp-header' => 'Art - tio i topp',
            'art-tio-i-topp-dagsum' => 'Dagar',
            'art-tio-i-topp-sassum' => 'Säsonger',
            'art-tio-i-topp-tot' => 'Totalt',
            'art-tio-i-topp-visa-knapp' => 'Visa data',
            'art-tio-i-topp-intro-text-1' => 'Här får du de tio högsta dags-, säsongs- och årssummorna för en enskild art.',
            '------------------------- Alla Ar - texter nedan  ---------------------------------' => '',
            'art-alla-ar-summary-main-header' => 'Art alla år - sedan 1947',
            'art-alla-ar-ar' => 'År',
            'art-alla-ar-header' => 'Alla år genom tiderna sedan 1947',
            'art-alla-ar-summary-header' => 'Sammanfattning',
            'art-alla-ar-summary' => 'Period',
            'art-alla-ar-summary-tot' => 'Antal',
            'art-alla-ar-intro-i' => 'Listan uppdateras automatiskt vid varje årsskifte.',
            'art-alla-ar-intro-ii' => 'OBS. År då arten inte ringmärkts utelämnas i resultatlistorna.',
            'art-alla-ar-intro-iii' => 'Sök antal per år för en utvald art.',
            'art-alla-ar-intro-iv' => 'Artlistan omfattar endast de arter som ringmärkts sedan starten 1947.',
            'art-alla-ar-intro-v' => 'För perioden 1947-1979 visas endast årssummor.',
            'art-alla-ar-header-80+1' => 'Från senaste år (',
            'art-alla-ar-header-80+2' => 'till 1980',
            'art-alla-ar-header-tidigare' => '1979 - 1947',
            'art-alla-ar-disclaimer-i' => 'Dessa siffror är inte jämförbara med de standardiserade summorna från och med 1980.',
            'art-alla-ar-disclaimer-ii' => 'Ringmärkning bedrevs inte 1948 och 1951.',
            '------------------------- Art, ar, season - texter nedan  ---------------------------------' => '',
            'aas-main-header' => 'Art, år och säsong',
            'aas-valj-header' => 'Välj art, år, och säsong',
            'aas-intro-i' => 'Nedan visas alla månader då någon',
            'aas-intro-ii' => 'fångats under vald säsong.',
            'aas-valj-art' => 'Art',
            'aas-valj-season' => 'Säsong',
            'aas-valj-ar' => 'År',
            'aas-header' => 'Dagssummor',
            '------------------------- Alla arter - alla ar - texter nedan  ---------------------------------' => '',
            'alla-arter-alla-ar-intro-hdr' => 'Kommentarer',
            'alla-arter-alla-ar-intro-i' => 'Tabellen visar alla fåglar som ringmärkts i Falsterbo fågelstations regi. Särskilt under 1950- och 1960-talen förekom en hel del märkningar utanför Falsterbonäset. Exempel på detta är de storskaliga märkningarna av tärn- och måsungar i Foteviken 1958-65, märkningen av tornuggleungar på olika håll i Skåne 1959-67 samt märkningar vintertid av gräsand och knölsvan i Malmö 1962-65. Därtill tillkommer ett fåtal fåglar, som ringmärkts efter rehabilitering.',
            'alla-arter-alla-ar-intro-ii' => 'Uppgifterna från tiden före 1980 finns inte i digital form (än) och är inte kontrollräknade. Detta är orsaken till uppdelningen i två perioder. Kolumnen "1980-idag" innehåller således både standardiserad och all annan märkning under perioden. Antalsuppgifterna i de båda perioderna är alltså på intet sätt jämförbara.',
            'alla-arter-alla-ar-main-header' => 'Alla arter - alla år',
            'alla-arter-alla-ar-idag' => 'idag',
            '------------------------- Miljöövervakning - oversikt texter nedan ---------------------------------' => '',
            'mo-oversikt-hdr' => 'Översikt - populationstrender',
            'mo-oversikt-show-how' => 'Visa hur',
            'mo-oversikt-show-what' => 'Visa vad',
            'mo-oversikt-show-pref' => 'Starkast signifikans',
            'mo-oversikt-show-all' => 'Allt',
            'mo-oversikt-show-om' => 'Fallande signifikans',
            'mo-oversikt-show-sys' => 'Systematisk ordning',
            'mo-oversikt-intro-i' => 'Korrelationerna är beräknade för perioden 1980 - 2018.',
            'mo-oversikt-intro-ii' => 'Listorna visar de arter som för närvarande är aktuella för övervakning av beståndsväxlingar.',
            'mo-oversikt-intro-iii' => 'Systematisk ',
            'mo-oversikt-intro-iv' => 'Systematisk ',
            'mo-select-hdr' => 'Välj urval och visningsätt',
            '------------------------- Miljöövervakning - texter nedan per ART ---------------------------------' => '',
            'artTrend' => 'Arttrend',
            'mo-pop-intro-sida-hdr' => 'Miljöövervakning',
            'mo-pop-intro-sida-para-1' => 'Långsiktigheten i ringmärkningen som bedrivs vid fågelstationen gör att data blir intressant för studier av trender. Ökar eller minskar arter, eller är de stabila över tid? I så fall vilka (och i förlängningen varför)?',
            'mo-pop-intro-sida-para-2' => 'Antalet fångade fåglar och artsammansättningen varierar från år till år. Väder och vind bestämmer både hur många fåglar som passerar Falsterbo och om de är möjliga att fånga. Regn och stark vind gör till exempel att det inte går att fånga och märka fåglar.',
            'mo-pop-intro-sida-para-3' => 'Över lång tid, jämnar olikheterna mellan åren ut sig och man kan börja skönja trender. Detta kan testas statistiskt. För att detta ska gå att göra måste arterna som vi studerar fångas i hyggliga antal varje år. Enstaka arter som vi tidigare inte fångade alls, men som nu tas regelbundet kan också tas med i dessa studier.',
            'mo-pop-intro-sida-para-4' => 'Stationen bygger fyra tidsserier, varav tre är baserade på ringmärkning, som ger jämförbara data mellan åren. Ringmärkningsserierna är:',
            'mo-pop-intro-sida-ul-1' => 'Fyrträdgården - vårsäsongen',
            'mo-pop-intro-sida-ul-2' => 'Fyrträdgården - höstsäsongen',
            'mo-pop-intro-sida-ul-3' => 'Flommen (vass) - höst',
            'mo-pop-intro-sida-para-5' => 'Här delar vi de data vi har kring trender baserade på våra ringmärkningsserier.',
            'mo-pop-trender-hdr' => 'Populationstrender',
            'mo-pop-average' => 'Medeltal per år för perioden',
            'mo-legend-header' => 'Signifikansnivåer',
            'mo-increasing' => 'Ökande',
            'mo-decreasing' => 'Minskande',
            'mo-stable' => 'Oförändrade',
            'mo-all-species' => 'Alla följda arter, alla tidsserier',
            'mo-best-fit' => 'Endast det starkaste sambandet per art',
            'mo-n-s' => 'ej signifikant',
            'mo-pop-average-sum' => 'Antal',

            '------------------------- Alla arter alla standard år sedan 1980 - texter nedan  ---------------------------------' => '',
            'asa-header' => 'Alla arter - från och med 1980',
            'asa-intro-text-1' => 'Här visas säsongssummor och totalsumman per art för den standardiserade fångsten som startade 1980.',
            '------------------------- Monitoring diagram texter ----------------------------------' => '',
            'chart-header' => 'Diagrammen',
            'staplar-i' => 'Staplar',
            'staplar-ii' => 'Säsongssummor',
            'bollar-i' => 'Röd linje',
            'bollar-ii' => 'Rullande femårsmedelvärden',
            'spearman' => 'Spearman\'s rangkorrelation',
            'selected' => 'Främsta val för övervakning av beståndsförändringar',
            'not-selected' => 'Ej vald för övervakning av beståndsförändringar',
            'visas-inte-i' => 'Den valda arten har ringmärkts i mycket litet antal (eller inte alls).',
            'visas-inte-ii' => 'Diagram visas inte.',
            'aterfynd-sektion' => '---------------------Återfynd-------------------------------',
            'aterfynd' => 'Återfynd',

            'xxx' => ''

        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'common-texts' => '-----------------------------------------------------------------------',
            'species' => 'Species',
            'mo-species' => 'Species',
            'sum' => 'Sum',
            'ssums' => 'Season totals',
            'dags-summa-rubrik' => 'Daily totals',
            'tot' => 'Total',
            'summa' => 'Sum',
            'l-t-a' => 'I100',
            'FA' => 'Lighthouse garden, spring',
            'FB' => 'Lighthouse garden, autumn',
            'FC' => 'Flommen, reed beds',
            'ÖV' => 'Misc',
            'PU' => 'Juv',
            'foto' => 'Photo:',
            'Mo' =>'Mo',
            'Tu' =>'Th',
            'We' =>'We',
            'Th' =>'Th',
            'Fr' =>'Fr',
            'Sa' =>'Sa',
            'Su' =>'Su',
            '1' =>'January',
            '2' =>'February',
            '3' =>'March',
            '4' =>'April',
            '5' =>'May',
            '6' =>'June',
            '7' =>'July',
            '8' =>'August',
            '9' =>'September',
            '10' =>'October',
            '11' =>'November',
            '12' =>'December',
            'valj-art' => 'Select a species',
            'visa-data-knapp' => 'Show data',
            'detta-ar' =>'This year',
            'section-texts' => '----------------------------------------------------------------------',
            'page-title' => 'Ringing/banding',
            'header' => 'Ringing/banding',
            'header-text' => 'Ringing in Falsterbo started back in the 40s. Since 1980, trapping routines are standardised, in order to produce data that show long-term population changes. Besides, recoveries of ringed birds are still of great interest. In these days of climate change, recoveries may show that birds use new wintering areas. ',
            'm-header' => 'Metodhology',
            'm-sub-header-standard' => 'The standardised ringing scheme',
            'm-intro' => 'Since 1980, a standardised ringing scheme is carried out at Falsterbo Bird Observatory (Table 1). The degree of standardisation was chosen to fit in well with the local conditions and the necessary care for the birds as well as to match the demands for comparable data between years. The choice was also based on experience from more than ten years of ringing at Falsterbo by G. Roos and LK.',
            'para-1' => 'The work is carried out at two sites.  One is the Lighthouse Garden a small stand of mixed trees and bushes (100 x 100 m) surrounding the Falsterbo Lighthouse and situated in an open field area (golf course). The Flommen Reedbed area is situated about 0,6–1,2 km NNE of the Lighthouse. It is an area mainly covered with reeds and sedges, but with some spots of open water and meadows. The use of two sites in different habitats allows a larger number of species to be monitored.',
            'para-2' => 'Only mist-nets (9 m length and mesh size 16 mm) are used. Depending on weather conditions the daily number of nets used is varying. At the most 21 nets are used at the Lighthouse and 20 at Flommen. The work is carried out seven days a week, weather permitting. For the care of the birds no trapping efforts are carried out on days with rain or strong wind.',
            'para-3' => 'The nets are put up before dawn and then controlled every half hour. The daily trapping period lasts at least a minimum 4 (spring) or 6 (autumn) hours at each site and continues thereafter as long as the number of captured birds exceeds ten individuals per hour. Then the nets are removed from the poles.',
            'tbl-hdr-plats' => 'Site',
            'tbl-hdr-start' => 'From',
            'tbl-hdr-stop' => 'To',
            'tbl-hdr-dagar' => 'Days',
            'tbl-hdr-timmar-per-dag' => 'Hours/Day',
            'tbl-hdr-nat' => 'Net',
            'tbl-lokal-fyren-var' => 'Lighthouse garden (spring)',
            'tbl-lokal-fyren-host' => 'Lighthouse garden (autumn)',
            'tbl-lokal-flommen' => 'Flommen, reedbed (autumn)',
            'tbl-data-21mars' => 'March 21<sup>st</sup>',
            'tbl-data-10juni' => 'June 10<sup>th</sup>',
            'tbl-data-21juli' => 'July 21<sup>st</sup>',
            'tbl-data-10november' => 'November 10<sup>th</sup>',
            'tbl-data-30september' => 'September 30<sup>th</sup>',
            'm-tbl-data-intro' => 'Table 1. The standardised ringing scheme at Falsterbo Bird Observatory.',
            'm-header-antal' => 'Numbers',
            'para-4' => 'Up to and including 2007, 627 965 birds were ringed within the standardised scheme. Almost two thirds of the total are birds ringed at the Lighthouse during autumns, while only 17% were ringed during springs. The remaining 19% were ringed at Flommen.',
            'para-5' => 'Graphs etc. are based on number of ringed birds per species, season and site. The numbers show the number of ringed or reringed birds, while controls of birds ringed elsewhere are not included.',
            'para-6' => 'Local birds are included in the totals. In most cases they represent a very small part of the total numbers. However, in some fairly resident species like House Sparrow, the proportion of local or regional birds may be larger.',
            'spearman' => 'Statistic tests are performed using <a href="https://en.wikipedia.org/wiki/Spearman%27s_rank_correlation_coefficient">Spearman\'s Rank Correlation</a>.',
            'm-header-topografi' => 'Influence of topography and weather',
            'para-7' => 'The use of the figures presented here in a correct way demands knowledge of the special conditions at Falsterbo. The geographic location on the south-westernmost point of the Scandinavian peninsula in combination with the major direction of bird migration in autumn being towards south-west lead to a high concentration of birds during autumn migration. In spring the northward migration is not at all concentrated to Falsterbo. On special occasions, usually caused by periods of cold weather, however, rather strong reverse movements (towards SW) are observed. The effect of leading lines makes the numbers of birds on reverse migration larger than those on "regular" spring migration. The high spring totals in species like Dunnock, Song Thrush, Redwing and Chaffinch during the mid-1980s are all mainly effects of reverse migration caused by changes to cold weather.',
            'para-8' => 'If the same pattern is valid also in nocturnal migrants is not known, but our personal experience of 28 spring seasons with standardised trapping is, that large numbers of grounded birds often occur in connection with "bad" weather, i.e. a front zone between cold weather in the north and warm in the south. Flycatchers, for example, are caught in large numbers only under such conditions. Thus, spring captures at Falsterbo are more irregular than autumn captures, which may be an explanation why relatively few correlations were found between spring and autumn totals. Certainly there are influences of weather also in autumn, but at Falsterbo these seem less crucial for the seasonal ringing totals than in spring, except for some quite rare and extreme situations. In a long-term perspective, however, the effect of extreme weather situations will by definition be evened out.',
            'para-9' => '',
            'para-10' => '',
            'para-11' => 'Therefore, it is <strong>safer to rely on autumn totals than on spring totals</strong> for monitoring purposes. Furthermore, autumn totals are on average larger than spring totals. <br/><br/>Spring totals, however, as well as autumn totals, are very useful for phenological studies.',
            'm-header-urval' => 'Selections for the web presentation',
            'para-12' => 'A minimum of 50 individuals per season and site was set as a condition for a graph to be shown. This condition can easily be adjusted if necessary. However, this means that a number of species with small samples happens to be included, but some of them show interesting tendencies all the same. For each species the the season/site preferred for monitoring is indicated. In relevant cases, statistcal tests are shown and furthermore, comments on the results are shown.',
            'para-13' => 'All numbers, graphs, statistics etc. are automatically updated at every turn of the year.',
            'footer-text' => 'Compiled by Lennart Karlsson',
            'dag-cal-title' => 'Select a day',
            'dag-title' => 'Ringing day -',
            'tbl-hdr-art' => 'Species',
            'tbl-hdr-dsum' => 'Today',
            'tbl-hdr-sum' => 'This season',
            'tbl-hdr-ssum' => 'Season sum',
            'tbl-hdr-tom-idag' => 'Up to today\'s date',
            'tbl-hdr-smv' => 'Season average',
            'ar-header-art' => 'Species',
            'alla-ar' => 'All years',
            'ar-header-summa' => 'Sum',
            'ar-intro-text' => 'Not yet translated.',
            '------------------------- sasongssidan inte manga texter har ---------------------------------------' => '',
            'sasong-header' => 'Season total',
            'ar-page-header' => 'Year totals - ',
            'sasong-valj-header' => 'Chose year and season',
            'select-season-text' => 'Season',
            'visa-knapp' => 'Show data',
            'visa-ar-knapp' => 'Show data',
            'visa-sasong-knapp' => 'Show selected year and season',
            'season-summary' => ' species (including possible hybrids).',

            '------------------------- Ars texter nedan  ---------------------------------' => '',
            'select-year-text' => 'Year',
            'ar-intro-text-1' => 'This page presents year totals for a selected year, starting with 1947. From 1980 and onwards also season totals, split between the standardized and miscellaneous ringing are shown. Note that no ringing took place 1948 and 1951.',
            'ar-intro-text-2' => 'Since the data contains, to a varying degree, "miscellaneous" ringing as well as pullus ringing, the year gross totals are not suitable for comparisons aiming at long term population trends. Rather, use the season data, for this purpose.',
            'ar-intro-text-3' => '',
            'ar-art' => 'Species',
            'ar-standard' => 'Standardised ringing/banding',
            'ar-fyren-var' => 'Light house, spring',
            'ar-fyren-host' => 'Light house, autumn',
            'ar-flommen' => 'Flommen',
            'ar-ovrigt' => 'Misc.',
            'ar-flygg' => 'Adults',
            'ar-pull' => 'Pull',
            'ar-tot' => 'Total',
            '------------------------- tio-i-topp ---------------------------------------' => '',
            'art-tio-i-topp-art' => 'Select a species',
            'art-tio-i-topp-header' => 'Species - 10 best',
            'art-tio-i-topp-arsum' => 'Years',
            'art-tio-i-topp-dagsum' => 'Days',
            'art-tio-i-topp-sassum' => 'Seasons',
            'art-tio-i-topp-visa-knapp' => 'Show data',
            'art-tio-i-topp-tot' => 'Totals',
            'art-tio-i-topp-intro-text-1' => 'This page presents "top ten" day, season, and annual totals for a given species.',
            '------------------------- Alla Ar - texter nedan  ---------------------------------' => '',
            'art-alla-ar-header' => ' - all years since 1947',
            'art-alla-ar-ar' => 'Year',
            'art-alla-ar-intro-i' => 'Lists are updated atutomatically at every turn of the year.',
            //För perioden 1947-1979 visas endast årssummor.
            'art-alla-ar-intro-ii' => 'N.B. Years when this species was not ringed are not shown.',
            'art-alla-ar-intro-iii' => 'Choose a species and see totals per year and season.',
            'art-alla-ar-intro-iv' => 'The drop down list of species includes all species ringed at Falsterbo.',
            'art-alla-ar-intro-v' => 'For the period 1947 to 1979 only annual totals are avaialable.',
            'art-alla-ar-intro-vi' => 'N.B. Years when this species was not ringed are not shown.',
            'art-alla-ar-header-80+1' => 'Last year (',
            'art-alla-ar-header-80+2' => 'to 1980',
            'art-alla-ar-header-tidigare' => '1979 - 1947',
            'art-alla-ar-disclaimer-i' => 'Bear in mind, these figures should <em>not</em> be compared with the standardised data set from 1980 and onwards.',
            'art-alla-ar-disclaimer-ii' => 'No ringing 1948 and 1951.',
            '------------------------- Art, ar, season - texter nedan  ---------------------------------' => '',
            'aas-main-header' => 'Species, year, and season',
            'aas-header' => 'Daily totals',
            'aas-intro-i' => 'Below are all full months shown when at least one',
            'aas-intro-ii' => 'has been ringed.',
            'ass-valj-header' => 'Choose species, year, and season',
            'aas-valj-art' => 'Species',
            'aas-valj-season' => 'Season',
            'aas-valj-ar' => 'Year',
            '------------------------- Alla arter - alla ar - texter nedan  ---------------------------------' => '',
            'art-alla-ar-summary-main-header' => 'Species all years - since 1947',
            'alla-arter-alla-ar-intro-hdr' => 'Comments',
            'art-alla-ar-summary-header' => 'Summary',
            'art-alla-ar-summary' => 'Period',
            'art-alla-ar-summary-tot' => 'Number of birds',
            'alla-arter-alla-ar-intro-i' => 'The table shows all birds ringed in the name of Falsterbo Bird Observatory. Particularly during the 1950s and 1960s, many birds were ringed outside the Falsterbo peninsula. Extensive ringing of tern and gull chicks at Foteviken 1958-65, ringing of Barn Owl nestlings at various sites in Skåne 1959-67 and ringing of wintering Mute Swans and Mallards 1962-65 are good examples of such activities. Additionally a few birds were ringed after rehabilitation.',
            'alla-arter-alla-ar-intro-ii' => 'Data from the years before 1980 are not yet digitized and double-checked. This is the reason for the two periods in the table. The "1980-today" column contains both standardised and other kinds of ringing activities. Thus, numbers from the two periods are by no means comparable.',
            'alla-arter-alla-ar-main-header' => 'All species - all years',
            'alla-arter-alla-ar-idag' => 'today',
            'mo-select-hdr' => 'Chose display mode and data',
            '------------------------- Miljöövervakning - texter nedan  ---------------------------------' => '',
            'artTrend' => 'Species trends',
            'mo-pop-intro-sida-para-1' => 'The long term consistent data built year-by-year makes the data set interesting for studying trends. Are species increasing or decreasing, or are they stable over time?  Which one(s), and (further down the line) - why?',
            'mo-pop-intro-sida-para-2' => 'The number of birds caught and as well as the species mix varies between the years. Random factors as wind and general weather determines both how many birds pass Falsterbo and our chances catching them. Rain and strong wind ruin the mist netting for instance.',
            'mo-pop-intro-sida-para-3' => 'Over long time with data from earlier years, the differences between the years become less striking and it is possible to sense trends. These suspicions can be tested statistically. To be possible the species in question must be ringed in decent numbers every year. Some species not caught at all (or only rarely) earlier, but now appearing regularly, can also be included in these studies.',
            'mo-pop-intro-sida-para-4' => 'The bird observatory build four time series. Three of those are based on ringing and give comparable data over the years. These series are:',
            'mo-pop-intro-sida-ul-1' => 'Lighthouse garden - spring season',
            'mo-pop-intro-sida-ul-2' => 'Lighthouse garden - autumn season',
            'mo-pop-intro-sida-ul-3' => 'Flommen (reeds) - autumn',
            'mo-pop-intro-sida-para-5' => 'Here we showcase our data concerning trends based on our ringing data.',
            'mo-oversikt-hdr' => 'Overview - population trends',
            'mo-pop-intro-sida-hdr' => 'Environmental monitoring',
            'mo-pop-trender-hdr' => 'Population trends',
            'mo-pop-average' => 'Annual average for the period',
            'mo-oversikt-show-how' => 'Display order',
            'mo-oversikt-show-what' => 'Show what',
            'mo-oversikt-show-pref' => 'Strongest sign.',
            'mo-oversikt-show-all' => 'All',
            'mo-oversikt-show-om' => 'Significance',
            'mo-oversikt-show-sys' => 'Systematic',
            'mo-oversikt-intro-i' => 'Correlations are calculated for the period 1980 to 2018.',
            'mo-oversikt-intro-ii' => 'Species lists are restricted to those species currently subject to population monitoring. For details on this, kindly see <a href="/ringmarkning/metodik.php?lang=en">methodology section</a>',
            'mo-legend-header' => 'Levels of significance',
            'mo-increasing' => 'Increasing',
            'mo-decreasing' => 'Descreasing',
            'mo-stable' => 'No sign. change',
            'mo-all-species' => 'All monitored species, all time series',
            'mo-best-fit' => 'Best fit by species',
            'mo-n-s' => 'non significant',
            'mo-pop-average-sum' => 'No of birds',

            '------------------------- Alla arter alla standard år sedan 1980 - texter nedan  ---------------------------------' => '',
            'asa-header' => 'Totals, all species since 1980',
            'asa-intro-text-1' => 'Here are season sums as well as overall totals by species shown since the standardised ringing started back in 1980.',
            '------------------------- Monitoring diagram texter ----------------------------------' => '',
            'chart-header' => 'The charts',
            'staplar-i' => 'Bars',
            'staplar-ii' => 'Season totals',
            'bollar-i' => 'Filled<br/>circles',
            'bollar-ii' => 'Five-year rolling averages',
            'spearman' => 'Spearman\'s rank correlation',
            'selected' => 'First choice for population monitoring.',
            'not-selected' => 'Not suitable for population monitoring.',
            'visas-inte-i' => 'The selected species is caught in very low numbers (or not at all).',
            'visas-inte-ii' => 'Chart is not shown.',
            'aterfynd-sektion' => '---------------------Återfynd-------------------------------',
            'aterfynd' => 'Recoveries',
            'xxx' => ''



        );

        return $texts;
    }

    public function getTxt($txt){
        return $this->texts[$txt];
    }


}