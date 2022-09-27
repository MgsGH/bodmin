<?php

class SectionMenu
{
    const Innehall = 0;
    const Bokningar = 1;
    const Brinken = 2;
    const Exkursioner = 3;

    const Selected = 5;
    const HasChildren = 6;

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
                /* id, parent_id, level in the menu, file-to-run, text, active or selected, has children */
                array(1, 0, 1, "/guidning/", "Grupper", false, true),
                array(2, 1, 2, "/guidning/bokningar/", "Bokningar", false, false),
                array(3, 0, 1, "/guidning/fyrbrinken", "Skåda i lagom tempo", false, true),
                array(4, 0, 1, "/guidning/exkursioner", "Exkursioner i omgivningarna", false, true),
            );
        }

        if ($this->language == 'en'){
            $this->links = array(
                /* level in the menu, file-to-run, text, active or selected, has children */
                array(1, 0, 1, "/guidning/?lang=en", "Groups", false, true),
                array(2, 1, 2, "/guidning/bokningar/?lang=en", "Bookings", false, false),
                array(3, 0, 1, "/guidning/fyrbrinken", "Walk-in guiding", false, true),
                array(4, 0, 1, "/guidning/exkursioner", "Excursions in Skåne", false, true),
            );
        }
        
    }


    function setContentSelected(){
        $this->links[SectionMenu::Innehall][SectionMenu::Selected] = true;
    }

    function setBokningSelected(){
        $this->links[SectionMenu::Bokningar][SectionMenu::Selected] = true;
    }

    function setBrinkenSelected(){
        $this->links[SectionMenu::Brinken][SectionMenu::Selected] = true;
    }

    function setExkursionerSelected(){
        $this->links[SectionMenu::Exkursioner][SectionMenu::Selected] = true;
    }


    function getHTML(): string {

        $var = "<div> \n\r" . "<ul  class=\"lokaler-menu\"> \n\r";
        $i = 0;

        $menuLength = count($this->links);

        while ($i < $menuLength){

            $page = $this->links[$i];
            $link = $this->createTheLink($page);
            $var = $var . $link . "\n\r";

            if ($page[SectionMenu::HasChildren]){ // This item has children - should we show them?

                // if current (parent) selected - show children
                $showSubLevel = $page[SectionMenu::Selected];
                // or - if a child is selected, show children
                if (!$showSubLevel){
                    $showSubLevel = $this->anyChildSelected($this->links, $i);
                }

                // parent done - now the first child
                $page = $this->links[$i];
                $noOfMenuItems = count($this->links);
                $level = $page[0];
                $i++;
                while ( ( $i < $noOfMenuItems ) && ( $page[0] === $level ) ) {

                    $page = $this->links[$i];
                    if (($showSubLevel) ) {  // show them!
                        $link = $this->createTheLink($page);
                        $var = $var . $link . "\n\r";
                    }

                    $i++;

                }

            } else {
                $i++;
            }

        }

        $var .= "</ul> \n\r </div> \n\r";
        return $var;
    }


    function createTheLink($page): string
    {

        $stylingClasses = "";
        $linkStart = "<a";
        $classString = "";
        $linkEnd = "href=\"" . $page[3] . "\">" . $page[4] . "</a>";

        // Check which level and implement styling. Only 2nd level implemented here
        // first level items defaulted, no class needed
        if ($page[2] == 2){
            $stylingClasses = "lvl-ii";
        }

        // Check if the menu item is selected, if so style it accordingly
        if ($page[SectionMenu::Selected]) {
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
        // We have a parent item

        // This is the parent item, still
        $page = $links[$i];
        $level = $page[0];
        $selected = false;

        // Next item is first child
        $i++;
        while (($i < count($this->links)) && ($page[0] === $level)) {

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