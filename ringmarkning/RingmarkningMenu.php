<?php

class RingmarkningMenu
{

    const Senaste = 0;
    const Vecka = 1;
    const Sasong = 2;
    const Ar = 3;
    const ArtTioITop = 4;
    const ArtAllaAr = 5;
    const ArtArSasong = 6;
    const AllaArterAllaAr = 7;
    const AllaArterAllaStdAr = 8;
    const Miljo = 9;
    const PopTrender = 10;
    const ArtPopTrend = 11;
    const Metodik = 12;
    const Aterfynd = 13;


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
                array(1, "/ringmarkning/", "Dagssummor", false, false),
                array(1, "/ringmarkning/vecka.php", "Senaste sju dagarna", false, false),
                array(1, "/ringmarkning/sasong.php", "Säsongssummor", false, false),
                array(1, "/ringmarkning/ar.php", "Årssummor", false, false),
                array(1, "/ringmarkning/art-tio-i-topp.php", "Art - tio i topp", false, false),
                array(1, "/ringmarkning/art-alla-ar.php", "Art - alla år", false, false),
                array(1, "/ringmarkning/art-ar-sasong.php", "Art - år och säsong", false, false),
                array(1, "/ringmarkning/alla-arter-alla-ar.php", "Alla arter - alla år", false, false),
                array(1, "/ringmarkning/alla-arter-alla-std-ar.php", "Alla arter - 1980 ->", false, false),
                array(1, "/ringmarkning/miljo-overvakning.php", "Miljöövervakning", false, true),
                array(2, "/ringmarkning/korrelationer.php", "Översikt", false, false),
                array(2, "/ringmarkning/art-trend.php", "Arttrender", false, false),
                array(1, "/ringmarkning/metodik.php", "Metodik", false, false),
                array(1, "/ringmarkning/aterfynd.php", "Återfynd", false, false)
            );
        }

        if ($this->language == 'en'){
            $this->links = array(
                /* level in the menu, file-to-run, text, active or selected, has children */
                array(1, "/ringmarkning/?lang=en", "Most recent day", false, false),
                array(1, "/ringmarkning/vecka.php?lang=en", "Latest week", false, false),
                array(1, "/ringmarkning/sasong.php?lang=en", "Totals - season", false, false),
                array(1, "/ringmarkning/ar.php?lang=en", "Totals - year", false, false),
                array(1, "/ringmarkning/art-tio-i-topp.php?lang=en", "One species - 10 best", false, false),
                array(1, "/ringmarkning/art-alla-ar.php?lang=en", "One species all years", false, false),
                array(1, "/ringmarkning/art-ar-sasong.php?lang=en", "One species season & year", false, false),
                array(1, "/ringmarkning/alla-arter-alla-ar.php?lang=en", "All species - all years", false, false),
                array(1, "/ringmarkning/alla-arter-alla-std-ar.php?lang=en", "All species - 1980 ->", false, false),
                array(1, "/ringmarkning/miljo-overvakning.php?lang=en", "Environmental monitoring", false, true),
                array(2, "/ringmarkning/korrelationer.php?lang=en", "Overview", false, false),
                array(2, "/ringmarkning/art-trend.php?lang=en", "Species trends", false, false),

                array(1, "/ringmarkning/metodik.php?lang=en", "Methodology", false, false),
                array(1, "/ringmarkning/aterfynd.php?lang=en", "Recoveries", false, false)
            );
        }
        
    }
    
    function setSenasteSelected(){
        $this->links[RingmarkningMenu::Senaste][3] = true;
    }

    function setVeckanSelected(){
        $this->links[RingmarkningMenu::Vecka][3] = true;
    }


    function setSasongSelected(){
        $this->links[RingmarkningMenu::Sasong][3] = true;
    }


    function setArSelected(){
        $this->links[RingmarkningMenu::Ar][3] = true;
    }


    function setArtAllaArSelected(){
        $this->links[RingmarkningMenu::ArtAllaAr][3] = true;
    }


    function setArtArSasongSelected(){
        $this->links[RingmarkningMenu::ArtArSasong][3] = true;
    }


    function setAllaArterAllaArSelected(){
        $this->links[RingmarkningMenu::AllaArterAllaAr][3] = true;
    }


    function setAllaArterAllaStdAr(){
        $this->links[RingmarkningMenu::AllaArterAllaStdAr][3] = true;
    }


    function setTioIToppSelected(){
        $this->links[RingmarkningMenu::ArtTioITop][3] = true;
    }


    function setMiljoOvervakningSelected(){
        $this->links[RingmarkningMenu::Miljo][3] = true;
    }


    function setArtTrendSelected(){
        $this->links[RingmarkningMenu::ArtPopTrend][3] = true;
    }


    function setPopTrenderSelected(){
        $this->links[RingmarkningMenu::PopTrender][3] = true;
    }


    function setMetodikSelected(){
        $this->links[RingmarkningMenu::Metodik][3] = true;
    }


    function setAterfyndSelected(){
        $this->links[RingmarkningMenu::Aterfynd][3] = true;
    }


    function getHTML(){

        $var = "<div> \n\r" . "<ul  class=\"lokaler-menu\"> \n\r";
        $i = 0;

        while ($i < count($this->links)){

            $page = $this->links[$i];
            $link = $this->createTheLink($page);
            $var = $var . $link . "\n\r";

            if ($page[RingmarkningMenu::HasChildren]){ // OK we have children - should we show them?

                $showSubLevel = $page[RingmarkningMenu::Selected]; // if current (parent) selected - show them
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
        if ($page[RingmarkningMenu::Selected]) {
            $stylingClasses = $stylingClasses . " active";
        }

        $stylingClasses = trim($stylingClasses);

        if (strlen($stylingClasses) > 0) {
            $classString = "class=\"" . $stylingClasses . "\" ";
        }

        $link = $linkStart . " " . $classString . $linkEnd;

        return "<li class='sectionMenu'>" . $link . "</li>";
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