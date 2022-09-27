<?php


class LogiTexter
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
            'page-title' => 'Logi',
            'header' => 'Logi - övernatta billigt och bra på Falsterbo fågelstation',
            'header-text' => 'Falsterbo Fågelstation ligger i sydvästra delen av Falsterbo park, mellan kyrkan och Falsterbo Museum. Huset byggdes 1955 och har renoverats ett par gånger därefter. Det fungerar i första hand som bostad för personalen. Stationen har dessutom (som mest) tio gästplatser. De är fördelade på fem sovhytter med våningssängar. Dessa platser hyrs ut, främst till fågelskådare. Gemensamt kök med full utrustning, toalett och dusch finns, liksom tvättmaskin (avgift 20 kr) och frys (i mån av plats).',
            'covid-header' => 'Covid-19 - tillfälligt stängt',
            'covid-text' => 'På grund av covid-19-pandemin tillåter vi tills vidare endast personal att bo på stationen. Detta beslut kvarstår tills pandemin är på så stor tillbakagång att Folkhälsomyndighetens rekommendationer ändras.',
            'avbokning' => '<b>Avbokning</b> måste alltid göras, om man inte kan komma. Annars debiteras logiavgift för den inbokade perioden (160 kr/natt och bädd).',
            'valkommen' => 'Välkommen!',
            'avgift' => '<b>Avgiften</b> är 160 kr/natt och bädd för medlemmar i Skånes Ornitologiska Förening (SkOF) och 200 kr/natt och bädd för övriga. Vill du inte dela rum betalar du för två bäddar. Medlemsavgiften för SkOF är f.n. 225 kr/år. På fem övernattningar tjänar du in medlemsavgiften och får som extra bonus fyra nummer av Sveriges bästa fågeltidskrift, ANSER!',
            'lakan' => '<b>Lakan </b>Medtag egna lakan (ej sovsäck) och handduk. Lakan finns också att hyra (50 kr/set).',
            'incheckning' => '<b>Incheckning</b> sker kl. 17:00-21:00 eller, om så krävs, efter särskild överenskommelse.',
            'uthyrning' => '',
            'info' => 'Vänligen notera - stationspersonal och gäster delar utrymme och alla förväntas ta vederbörlig hänsyn till varandra. Kom ihåg att ringmärkare har extrema arbetstider (speciellt "sommartid") och därför måste sova mitt på dagen.',
            'adress' => '<b>Stationens gatuadress:</b> Sjögatan, Falsterbo',
            'booking-intro' => '<b>Bokning</b> (boka i god tid, särskilt inför hösten):',
            'booking-bullet-1' => 'E-post: <a href="mailto:falsterbo@skof.se">falsterbo@skof.se</a>',
            'booking-bullet-2' => 'Telefon: 0736-254 256',
            'booking-bullet-3' => 'Brev: Falsterbo Fågelstation, Fyrvägen 35, 239 40 Falsterbo',
            'booking-end' => 'Vänligen ring helst under sen eftermiddag eller tidig kväll, särskilt under fältsäsongerna (21 mars-10 juni samt 21 juli-10 november). Tack!',
            'vagbeskrivning-header' => 'Vägbeskrivning',
            'vagbeskrivning-0' => 'Stationen är markerad med röd cirkel i kartan ovan.',
            'vagbeskrivning-1' => 'Om man kommer med buss stiger man av vid hållplatsen Norra Vånggatan. Åtminstone när det är ljust kan man med fördel gå genom Falsterbo park till fågelstationen (prickad blå linje på kartan).',
            'vagbeskrivning-2' => 'Annars är den gängse vägen för såväl gående som bilåkande att följa Östergatan tills den slutar och sedan ta till höger längs Kyrkogatan tills man kommer till torget. Där tar man till vänster längs Sjögatan tills man har passerat Falsterbo Museum. Till vänster finns en infart till P-plats för boende i en rad nybyggda hus. I slutet av P-platsen finner man en mindre väg in i parken. Denna väg leder till fågelstationen.',
            'alternativ' => 'För andra boendealternativ i trakten vänligen följ denna länk ',

            '----- dummy -----' => ''


        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Lodging',
            'header' => 'Lodging',
            'header-text' => 'Falsterbo Fågelstation (Observatory) is situated in the south-western part of the Falsterbo Park, between the church and the Town Museum. It was built in 1955 and has been renovated a couple time since then. It serves mainly as staff accommodation.',
            'covid-header' => 'Covid-19 - temporary closed',
            'covid-text' => 'Due to the ongoing Covid-19 outbreak we only allow staff on the premises of the bird observatory at the moment. This decision will remain in force until the Swedish authority (FHM) change their recommendations. ',
            'valkommen' => 'Welcome!',
            'avbokning' => '<b>Cancellation</b> has to be done, should plans change. Otherwise the booked lodging will have to be paid (160 SEK/night and bed).',
            'avgift' => '<b>Price</b> is 160 SEK/night and bed, for members of Skånes Ornitologiska Förening (SkOF) and 200 SEK/night and bed for others. If you want a single room you simply pay for two beds.',
            'lakan' => '<b>Bedsheets </b>(not sleeping bag) och towel are expected to be brought. Bedsheets are available for renting (50 SEK/set).',
            'incheckning' => '<b>Checkning in</b> is between 17:00 and 21:00 or, if needed at other times, <i>after prior agreement</i>.',
            'uthyrning' => '<b>To let</b>, primarily for birders, up to ten guest beds in five sleeping compartments (bunkbeds) are offered. A large combined living room and fully equipped is open for all. Toilet and shower is of course also available as well as washing machine (fee 20 SEK) and freezer (if space available).',
            'info' => 'Observatory staff and guests share living space and mutual respect is expected. Please remember that staff has <strong><i>very odd</i></strong> (early) working hours, especially during "summertime", requiring a "lunch nap". Thus, approximately 11.00 to 15.00 should be considered quiet hours.',
            'adress' => '<b>Observatory street address:</b> Sjögatan, Falsterbo',
            'booking-intro' => '<b>Booking</b> (book well in advance, especially before the autumn season):',
            'booking-bullet-1' => 'Email: <a href="mailto:falsterbo@skof.se">falsterbo@skof.se</a>',
            'booking-bullet-2' => 'Telephone: +46 (0)736-254 256',
            'booking-bullet-3' => 'Mail: Falsterbo Fågelstation, Fyrvägen 35, 239 40 Falsterbo',
            'booking-end' => 'Kindly call late afternoon, or early evening, especially during the seasons (21<sup>th</sup> March-10<sup>th</sup> June and 21<sup>th</sup> July-10<sup>th</sup> November). Thanks!',
            'vagbeskrivning-header' => 'How to get here',
            'vagbeskrivning-0' => 'The red circle in the map above indicates the location of the birdobservatory.',
            'vagbeskrivning-1' => 'If arriving by buss, kindly get off at the buss-stop "Norra Vånggatan", (stops are displayed in the buss). During daytime it is a pleasent walk through the Falsterbo park to the observatory (dotted blue line on the map).',
            'vagbeskrivning-2' => 'If arriving by car, or by bus after nightfall, the same route can be used. Follow Östergatan until it ends. Here turn right and follow Kyrkogatan until reaching the square. Here you take an immediate left, (sign-posted Museum) and follow Sjögatan a couple of hundred meters. You pass Falsterbo Museum, to the left. Immediately after the museum, you will find an entrance to the parking place for a few newly built, posh, houses. Cross the parking place and follow the small road leading into the park. This road take you to the observatory building.',
            'alternativ' => 'For other lodging alternatives in the area kindly follow this link ',
            '----- dummy -----' => ''
        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }


}