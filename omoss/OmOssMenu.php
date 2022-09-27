<?php

class OmOssMenu
{

    /*
     * Om oss addresser, och liknande.
     * Stod oss -
     * */
    const verksamhet = 0;
    const kontakt = 1;
    const stod = 2;
    const bidrag = 3;
    const hyllningsgava = 4;
    const minnesgava = 5;
    const julgava = 6;
    const arv = 7;
    const inter = 8;


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
                array(1, "/omoss/", "Verksamhet", false, false),
                array(1, "/omoss/kontakt/", "Kontakt", false, false),
                array(1, "/omoss/stod.php", "Stöd stationen", false, true),
                array(2, "/omoss/bidrag.php", "Ett enkelt bidrag", false, false),
                array(2, "/omoss/hyllningsgava.php", "Hyllningsgåva", false, false),
                array(2, "/omoss/minnesgava.php", "Minnesgåva", false, false),
                array(2, "/omoss/julgava.php", "Julgåva", false, false),
                array(2, "/omoss/arvsgava.php", "Arvsgåva", false, false),
                array(1, "/omoss/internationellt.php", "Internationellt samarbete", false, false),
            );
        }

        if ($this->language == 'en'){
            $this->links = array(
                /* level in the menu, file-to-run, text, active or selected, has children */
                array(1, "/omoss/index.php?lang=en", "What we do", false, false),
                array(1, "/omoss/kontakt/?lang=en", "Contact", false, false),
                array(1, "/omoss/stod.php?lang=en", "Support us", false, true),
                array(2, "/omoss/bidrag.php?lang=en", "Immediate support", false, false),
                array(2, "/omoss/hyllningsgava.php?lang=en", "Gift donation", false, false),
                array(2, "/omoss/minnesgava.php?lang=en", "Remembrance gift", false, false),
                array(2, "/omoss/julgava.php?lang=en", "Christmas gift", false, false),
                array(2, "/omoss/arvsgava.php?lang=en", "Leave assets by a will", false, false),
                array(1, "/omoss/internationellt.php?lang=en", "International collaboration", false, false),
            );
        }
        
    }
    
    function setVerksamhetSelected(){
        $this->links[omossMenu::verksamhet][3] = true;
    }

    function setKontaktSelected(){
        $this->links[omossMenu::kontakt][3] = true;
    }

    function setBidragSelected(){
        $this->links[omossMenu::bidrag][3] = true;
    }

    function setStodSelected(){
        $this->links[omossMenu::stod][3] = true;
    }


    function setMinnesgavaSelected(){
        $this->links[omossMenu::minnesgava][3] = true;
    }


    function setHyllningsgavaSelected(){
        $this->links[omossMenu::hyllningsgava][3] = true;
    }


    function setArvSelected(){
        $this->links[omossMenu::arv][3] = true;
    }


    function setInternationelltSelected(){
        $this->links[omossMenu::inter][3] = true;
    }


    function setJulgavaSelected(){
        $this->links[omossMenu::julgava][3] = true;
    }


    function getHTML(){

        $var = "<div> \n\r" . "<ul  class=\"lokaler-menu\"> \n\r";
        $i = 0;

        while ($i < count($this->links)){

            $page = $this->links[$i];
            $link = $this->createTheLink($page);
            $var = $var . $link . "\n\r";

            if ($page[omossMenu::HasChildren]){ // OK we have children - should we show them?

                $showSubLevel = $page[omossMenu::Selected]; // if current (parent) selected - show them
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
        if ($page[omossMenu::Selected]) {
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