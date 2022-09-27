<?php

class SalesMenu
{

    const Senaste = 0;
    const Books = 1;
    const Stickers = 2;
    const DVD = 3;
    const Binoculars = 4;
    const Litographies = 5;
    const Mousemats = 6;
    const Mugs = 7;
    const Tablemats = 8;
    const Tshirts = 9;
    const Bags = 10;
    const Postcards = 11;
    const Sale = 12;
    // 13 not used
    const Orders = 14;


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
                array(1, "/sales/", "Startsida", false, false),
                array(1, "/sales/books/", "Böcker och häften", false, false),
                array(1, "/sales/dekaler/", "Dekaler", false, false),
                array(1, "/sales/dvd", "DVD-film", false, false),
                array(1, "/sales/kikare", "KITE kikare", false, false),
                array(1, "/sales/litografier", "Litografier", false, false),
                array(1, "/sales/musmattor", "Musmattor", false, false),
                array(1, "/sales/muggar", "Muggar", false, false),
                array(1, "/sales/tallriksunderlagg", "Tallriksunderlägg", false, false),
                array(1, "/sales/outfits", "T-tröjor", false, false),
                array(1, "/sales/bags", "Tygkassar", false, false),
                array(1, "/sales/postcards", "Vykort och julkort", false, false),
                array(1, "/sales/overskottslagret", "Överskottslagret", false, false),
                array(1, "", "", false, false),
                array(1, "/sales/orders/", "Beställningslista", false, false),
                array(1, "", "", false, false),
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
                array(2, "/ringmarkning/art-trend.php?lang=en", "Species pop. trends", false, false),

                array(1, "/ringmarkning/metodik.php?lang=en", "Methodology", false, false),
                array(1, "/ringmarkning/aterfynd.php?lang=en", "Recoveries", false, false)
            );
        }
        
    }
    
    function setSenasteSelected(){
        $this->links[SalesMenu::Senaste][3] = true;
    }

    function setBooksSelected(){
        $this->links[SalesMenu::Books][3] = true;
    }


    function setDekalerSelected(){
        $this->links[SalesMenu::Stickers][3] = true;
    }


    function setDvdSelected(){
        $this->links[SalesMenu::DVD][3] = true;
    }


    function setKikareSelected(){
        $this->links[SalesMenu::Binoculars][3] = true;
    }


    function setLitografierSelected(){
        $this->links[SalesMenu::Litographies][3] = true;
    }


    function setMusmattorSelected(){
        $this->links[SalesMenu::Mousemats][3] = true;
    }


    function setMugsSelected(){
        $this->links[SalesMenu::Mugs][3] = true;
    }


    function setTablematsSelected(){
        $this->links[SalesMenu::Tablemats][3] = true;
    }


    function setTshirtsSelected(){
        $this->links[SalesMenu::Tshirts][3] = true;
    }


    function setBagsSelected(){
        $this->links[SalesMenu::Bags][3] = true;
    }


    function setPostcardsSelected(){
        $this->links[SalesMenu::Postcards][3] = true;
    }


    function setSaleSelected(){
        $this->links[SalesMenu::Sale][3] = true;
    }

    function setOrdersSelected(){
        $this->links[SalesMenu::Orders][3] = true;
    }


    function getHTML(){

        $var = "<div> \n\r" . "<ul  class=\"lokaler-menu\"> \n\r";
        $i = 0;

        while ($i < count($this->links)){

            $page = $this->links[$i];
            $link = $this->createTheLink($page);
            $var = $var . $link . "\n\r";

            if ($page[SalesMenu::HasChildren]){ // OK we have children - should we show them?

                $showSubLevel = $page[SalesMenu::Selected]; // if current (parent) selected - show them
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

        $link = '&nbsp;';
        if ($page[1] !== '' ){

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
            if ($page[SalesMenu::Selected]) {
                $stylingClasses = $stylingClasses . " active";
            }

            $stylingClasses = trim($stylingClasses);

            if (strlen($stylingClasses) > 0) {
                $classString = "class=\"" . $stylingClasses . "\" ";
            }

            $link = $linkStart . " " . $classString . $linkEnd;
        }

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