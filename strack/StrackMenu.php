<?php

class StrackMenu
{
    const Senaste = 0;
    const TioDagar = 1;
    const Ar = 2;
    const ArArt = 3;
    const ArtTioITop = 5;
    const ArtSasong = 4;
    const ArtAllaAr = 6;

    const Miljo = 7;
    const MiljoOversikt = 8;
    const ArtPopTrend = 9;

    const Metodik = 10;

    const Selected = 3;
    const HasChildren = 4;

    var $links;
    var $language;

    public function __construct($lang)
    {

        if (!isset($lang)) {
            $this->language = 'sv';
        } else {
            $this->language = $lang;
        }

        if ($this->language == 'sv') {
            $this->links = array(
                /* level in the menu, file-to-run, text, active or selected, has children */
                array(1, "/strack/dagssummor/", "Dag för dag", false, false),
                array(1, "/strack/tio-dagar/", "Tiodagarssummor", false, false),
                array(1, "/strack/ar/", "Årssummor", false, false),
                array(1, "/strack/art-ar/", "Art - år", false, false),
                array(1, "/strack/art-sasong/", "Art - toppdagar", false, false),
                array(1, "/strack/art-tio-i-topp/", "Art - tio i topp", false, false),
                array(1, "/strack/art-alla-ar/", "Art - alla år", false, false),
                array(1, "/strack/miljo-overvakning/", "Miljöövervakning", false, true),
                array(2, "/strack/miljo-overvakning/oversikt", "Översikt", false, false),
                array(2, "/strack/art-trend.php", "Artrender", false, false),
                array(1, "/strack/metodik/", "Metodik", false, false)
            );
        }

        if ($this->language == 'en'){
            $this->links = array(
                /* level in the menu, file-to-run, text, active or selected, has children */
                array(1, "/strack/dagssummor/?lang=en", "Day by day", false, false),
                array(1, "/strack/tio-dagar/?lang=en", "10 days", false, false),
                array(1, "/strack/ar/?lang=en", "Annual totals", false, false),
                array(1, "/strack/art-ar/?lang=en", "Species, year", false, false),
                array(1, "/strack/art-sasong/?lang=en", "One species - top days", false, false),
                array(1, "/strack/art-tio-i-topp/?lang=en", "One species - 10 best", false, false),
                array(1, "/strack/art-alla-ar/?lang=en", "One species all years", false, false),
                array(1, "/strack/miljo-overvakning?lang=en", "Environmental monitoring", false, true),
                array(2, "/strack/miljo-overvakning/oversikt?lang=en", "Overview", false, false),
                array(2, "/strack/art-trend.php?lang=en", "Population trends by species", false, false),
                array(1, "/strack/metodik?lang=en", "Methodology", false, false)
            );
        }
        
    }



    function setArArtSelected(){
        $this->links[StrackMenu::ArArt][3] = true;
    }

    function setSenasteSelected(){
        $this->links[StrackMenu::Senaste][3] = true;
    }

    function setTioDagarSelected(){
        $this->links[StrackMenu::TioDagar][3] = true;
    }


    function setArSelected(){
        $this->links[StrackMenu::Ar][3] = true;
    }


    function setArtAllaArSelected(){
        $this->links[StrackMenu::ArtAllaAr][3] = true;
    }


    function setTioIToppSelected(){
        $this->links[StrackMenu::ArtTioITop][3] = true;
    }

    function setArtToppDagarSelected(){
        $this->links[StrackMenu::ArtSasong][3] = true;
    }

    function setMiljoOvervakningSelected(){
        $this->links[StrackMenu::Miljo][3] = true;
    }

    function setArtTrendSelected(){
        $this->links[StrackMenu::ArtPopTrend][3] = true;
    }


    function setMiljoOversiktSelected(){
        $this->links[StrackMenu::MiljoOversikt][3] = true;
    }


    function setMetodikSelected(){
        $this->links[StrackMenu::Metodik][3] = true;
    }


    function getHTML(){

        $var = "<div> \n\r" . "<ul  class=\"lokaler-menu\"> \n\r";
        $i = 0;

        while ($i < count($this->links)){

            $page = $this->links[$i];
            $link = $this->createTheLink($page);
            $var = $var . $link . "\n\r";

            if ($page[StrackMenu::HasChildren]){ // OK we have children - should we show them?

                $showSubLevel = $page[StrackMenu::Selected]; // if current (parent) selected - show them
                // if a child is selected, show the children
                if (!$showSubLevel){
                    $showSubLevel = $this->anyChildSelected($this->links, $i);
                }


                // parent done - now the first child
                $i++;
                $page = $this->links[$i];
                $level = $page[0];
                while (($i < count($this->links)) && ($page[0] == $level)) {

                    if (($showSubLevel) ) {  // show them!
                        $link = $this->createTheLink($page);
                        $var = $var . $link . "\n\r";
                    }

                    $i++;
                    if ($i < count($this->links)) {
                        $page = $this->links[$i];
                    }

                }

            } else {
                $i++;
            }

        }

        $var = $var . "</ul> \n\r </div> \n\r";
        return $var;
    }


    function createTheLink($page){


        $stylingClasses = "";
        $linkStart = "<a";
        $classString = "";
        $linkEnd = "href=\"" . $page[1] . "\">" . $page[2] . "</a>";

        // Check which level and implement styling. Only 2nd level implemented here
        // first level items defaulted, no class needed
        if ($page[0] == 2){
            $stylingClasses = "lvl-ii";
        }

        // Check if the menu item is selected, if so style it accordingly
        if ($page[StrackMenu::Selected]) {
            $stylingClasses = $stylingClasses . " active";
        }

        $stylingClasses = trim($stylingClasses);

        if (strlen($stylingClasses) > 0) {
            $classString = "class=\"" . $stylingClasses . "\" ";
        }

        $link = $linkStart . " " . $classString . $linkEnd;

        return "<li>" . $link . "</li>";
    }

    function anyChildSelected($links, $i){

        $i++;
        $page = $links[$i];
        $level = $page[0];
        $selected = false;

        while (($i < count($this->links)) && ($page[0] == $level)) {
            $selected = $page[3];

            if ($selected){
                break;
            }
            $i++;

            if ($i < count($links)){
                $page = $links[$i];
            }

        }

        return $selected;
    }

}