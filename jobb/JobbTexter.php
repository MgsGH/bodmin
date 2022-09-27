<?php


class JobbTexter
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
            'page-title' => 'Jobb',
            'arb-upg-header' => 'Arbetsuppgifter',
            'ersattning-header' => 'Ersättning',
            'forkunskaper-header' => 'Förkunskaper',
            'intro' => 'Inför hösten söker vi',
            'assistenter-header' => 'Ringmärkningsassistenter',
            'bullet-1' => '1 person 20 juli - 31 oktober',
            'bullet-2' => '1 person ca. 15 augusti - 31 oktober',
            'ass-arb-upg-1' => 'Assistenter hjälper till i ringmärkningsarbetet, främst med hanteringen av fåglar i näten, samt uppsättning nedtagning och underhåll av nät. Du får också tillfälle att lära dig ringmärkning (om du inte redan kan). Övriga uppgifter kan vara fågelräkningar, trädgårdsarbete och annat som hör till drift och skötsel av fågelstationen.',
            'ass-arb-upg-2' => 'I princip är det jobb sju dagar i veckan med start i gryningen men det finns också tid till eget fågelskådande mellan varven.',
            'ass-forkunskaper-1' => 'Normal artkännedom är förstås självskriven. Dessutom är det viktigt, att du har någon erfarenhet av ringmärkning, främst hantering av fåglar i nät samt att du har intresse och ambition för uppgiften. Vi letar också i första hand efter folk som kan stanna en hel säsong.',
            'ass-ersattning-1' => 'Dagtraktamente, f.n. 230 kr/dag. Dessutom betalar vi resan mellan din hemort och Falsterbo t.o.r. med billigaste färdsätt inom Sverige, om du stannar hela säsongen. Du bor gratis på fågelstationen men står själv för matkostnader.',
            'guide-header' => 'Guide',
            'guide-intro' => '1 person ca 25 augusti-31 oktober',
            'guide-arbetsuppgifter-header' => 'Arbetsuppgifter',
            'guide-arbetsuppgifter-1' => 'Som guide bokar du in och tar emot grupper. Du arbetar ihop med vår ordinarie guide Karin och ni turas om att ta emot grupperna som kan bestå av allt från små barn till pensionärer. Du ska helst också kunna guida på engelska.',
            'guide-arbetsuppgifter-2' => 'Även om du är guide innebär det i princip jobb sju dagar i veckan. Guiden deltar i ringmärkningen när det inte är guidning, inte minst för att träna på hantering av fåglar i handen och lära sig mer om arterna.',
            'guide-forkunskaper-1' => 'Normal artkännedom är förstås självskriven.	även	för en guide. Det finns också en handledning för guidning vid Falsterbo, som du noga ska gå igenom och du får inledningsvis sitta med på några av Karins guidningar.',
            'guide-forkunskaper-2' => 'Du måste gilla att tala inför folk och gärna vara den typen som "pratar med hela kroppen".',
            'guide-ersattning' => 'Lön 12 000 kr/månad. Dessutom betalar vi resan mellan din hemort och Falsterbo t.o.r. med billigaste färdsätt inom Sverige, om du stannar hela säsongen. Du bor gratis på fågelstationen men står själv för matkostnader.',
            'intresserad-header' => 'Är du intresserad?',
            'intresserad-intro' => 'Skriv eller ring och berätta:',
            'intresserad-1' => 'Vad du vill arbeta som',
            'intresserad-2' => 'Vilken tid du kan komma',
            'intresserad-3' => 'Din erfarenhet av ringmärkning eller guidning',
            'kontakt-header' => 'Kontaktperson',
            'kontakt-intro' => '<b>Sophie Ehnbom</b>',
            'kontakt-1' => 'Telefon: 0705-685810',
            'kontakt-2' => 'E-post: <a href="mailto:sophie.ehnbom@gmail.com">sophie.ehnbom@gmail.com</a>',
            'kontakt-3' => 'Brev: Falsterbo Fågelstation, Fyrvägen 35, 239 40 Falsterbo',
            'lokal' => '',
            '---------------------------- end ------------' => ''


        );

        return $texts;
    }

    function getTextsEn(){

        $texts = array(
            'page-title' => 'Jobst',
            'header' => 'Jobs - become a Falsterbo Bird Observatory team member',
            'header-text' => 'Working with us is a highly rewarding way to deepen your interest in birds. Besides close encounters with many thrilling species, you will also get some insights in the world of bird research. To see and handle birds in the hand gives new perspectives, and the possibility to pick up details also useful during normal birding situations.',
            'arb-upg-header' => 'Arbetsuppgifter',
            'ersattning-header' => 'Ersättning',
            'forkunskaper-header' => 'Förkunskaper',
            'intro' => 'Inför hösten 2018 söker vi',
            'assistenter-header' => 'Ringmärkningsassistenter',
            'bullet-1' => '1 person 20 juli - 31 oktober',
            'bullet-2' => '1 person ca. 15 augusti - 31 oktober',
            'ass-arb-upg-1' => 'Assistenter hjälper till i ringmärkningsarbetet, främst med hanteringen av fåglar i näten, samt uppsättning nedtagning och underhåll av nät. Du får också tillfälle att lära dig ringmärkning (om du inte redan kan). Övriga uppgifter kan vara fågelräkningar, trädgårdsarbete och annat som hör till drift och skötsel av fågelstationen.',
            'ass-arb-upg-2' => 'I princip är det jobb sju dagar i veckan med start i gryningen men det finns också tid till eget fågelskådande mellan varven.',
            'ass-forkunskaper-1' => 'Normal artkännedom är förstås självskriven. Dessutom är det viktigt, att du har någon erfarenhet av ringmärkning, främst hantering av fåglar i nät samt att du har intresse och ambition för uppgiften. Vi letar också i första hand efter folk som kan stanna en hel säsong.',
            'ass-ersattning-1' => 'Dagtraktamente, f.n. 230 kr/dag. Dessutom betalar vi resan mellan din hemort och Falsterbo t.o.r. med billigaste färdsätt inom Sverige, om du stannar hela säsongen. Du bor gratis på fågelstationen men står själv för matkostnader.',
            'guide-header' => 'Guide',
            'guide-intro' => '1 person ca 25 augusti-31 oktober',
            'guide-arbetsuppgifter-header' => 'Arbetsuppgifter',
            'guide-arbetsuppgifter-1' => 'Som guide bokar du in och tar emot grupper. Du arbetar ihop med vår ordinarie guide Karin och ni turas om att ta emot grupperna som kan bestå av allt från små barn till pensionärer. Du ska helst också kunna guida på engelska.',
            'guide-arbetsuppgifter-2' => 'Även om du är guide innebär det i princip jobb sju dagar i veckan. Guiden deltar i ringmärkningen när det inte är guidning, inte minst för att träna på hantering av fåglar i handen och lära sig mer om arterna.',
            'guide-forkunskaper-1' => 'Normal artkännedom är förstås självskriven.	även	för en guide. Det finns också en handledning för guidning vid Falsterbo, som du noga ska gå igenom och du får inledningsvis sitta med på några av Karins guidningar.',
            'guide-forkunskaper-2' => 'Du måste gilla att tala inför folk och gärna vara den typen som "pratar med hela kroppen".',
            'guide-ersattning' => 'Lön 12 000 kr/månad. Dessutom betalar vi resan mellan din hemort och Falsterbo t.o.r. med billigaste färdsätt inom Sverige, om du stannar hela säsongen. Du bor gratis på fågelstationen men står själv för matkostnader.',
            'intresserad-header' => 'Är du intresserad?',
            'intresserad-intro' => 'Skriv eller ring och berätta:',
            'intresserad-1' => 'Vad du vill arbeta som',
            'intresserad-2' => 'Vilken tid du kan komma',
            'intresserad-3' => 'Din erfarenhet av ringmärkning eller guidning',
            'kontakt-header' => 'Contakt person',
            'kontakt-intro' => '<b>Sophie Ehnbom</b>',
            'kontakt-1' => 'Telephone: + 46 705-685810',
            'kontakt-2' => 'E-mail: <a href="mailto:sophie.ehnbom@gmail.com">sophie.ehnbom@gmail.com</a>',
            'kontakt-3' => 'Mail: Falsterbo Fågelstation, Fyrvägen 35, 239 40 Falsterbo',
            'lokal' => '',
            '---------------------------- end ------------' => ''
        );

        return $texts;
    }

    function getTxt($txt){
        return $this->texts[$txt];
    }

}