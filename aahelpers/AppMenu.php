<?php


class AppMenu
{
    public $menu;
    public $pdo;
    public $userId;
    public $languageId;


    /*
     * This class handles application menu creation
     */

    public function __construct($pdo, $userId)
    {

        $this->pdo = $pdo;
        $this->userId = $userId;
        $langid = '1';
        if (isset($_SESSION["preferredLanguageId"])){
            $langid = $_SESSION["preferredLanguageId"];
        }
        $this->languageId = $langid;
        $this->menu = getAppMenuTopLevel($pdo, $userId, $langid);

    }

    function setSidaSelected($page){
        if ($page < count($this->menu)){
            $this->menu[$page]['SELECTED'] = '1';
        }

    }

    function getAsHTML(){

        $var =  '<nav class="navbar navbar-expand-sm navbar-dark bg-dark">';
        $var .= '   <div class="container-fluid">';
        $var .= '      <div class="collapse navbar-collapse" id="navbarSupportedContent">';
        $var .= '         <ul class="navbar-nav me-auto mb-2 mb-lg-0">';

        $l = count($this->menu);
        for ( $i=0; $i < $l; $i++ ){

            $module = $this->menu[$i];
            $linkFull = "";

            if ((isset($module['PERMISSION_ID'])) && ($module['PERMISSION_ID'] > '1')) {
                // The module must have set permissions larger than 1 to even be created
                $linkFull =  $this->getMenuItemSection($module);
            }

            $var .= $linkFull;

        }

        $var .= '         </ul>';
        $var .= '      </div>';
        $var .= '   </div>';
        $var .= '</nav>';

        return $var;
    }

    function getMenuItemSection( $module ){
        //

        $r = '<li class="' . $this->getMenuItemBaseClasses($module) . '">';

        if (($module['PARENT_ID'] === '0') && ($module['ISPARENT'] === '0')) { // a normal item
            $r .=  '<a id="anka"' . ' class="' . $this->getLinkCssClasses($module) . '" href="/bodmin' .  $module['LINK'] . '">' . $module['MODULE'] . '</a>';
        }

        if ($module['ISPARENT'] > '0') {

            $r .= '<a class="nav-link dropdown-toggle" href="#" id="test" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $module['MODULE'] . '</a>';
            // build submenu
            $r .= '<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="test">';
            $r .= $this->getAppMenuSubMenuItemsAsHTML( $module['MODULE_ID'] );
            $r .= '</ul>';

        }

       $r .= '</li>';

        return $r;

    }


    function getAppMenuSubMenuItemsAsHTML( $parentMenuItemId ){

        $r = '';

        $subMenuItems = getAppMenuSubMenu($this->pdo, $this->userId, $this->languageId, $parentMenuItemId);

        $length = count($subMenuItems);
        for ( $i=0; $i < $length; $i++ ){

            $subMenuItem = $subMenuItems[$i];
            $r .= '<li><a class="' . $this->getSubMenuLinkCssClasses($subMenuItem)  . '" href="/bodmin' . $subMenuItem['LINK']  .  '">' . $subMenuItem['MODULE'] .'</a></li>';

        }

        return $r;

    }


    function getMenuItemBaseClasses($module){

        $class = 'nav-link';

        if ($module['PERMISSION_ID'] < '2') {
            $class .= ' disabled';
        }

        if ($module["SELECTED"] === '1') {
            $class .= ' active';
        }

        if ($module["ISPARENT"] > '0'){ /* we have a submenu item */
            $class .= ' dropdown';
        }

        return $class;
    }


    function getLinkCssClasses($module){

        $r = 'nav-link';

        if ($module['PERMISSION_ID'] < '2') {
            $r .= ' disabled';
        }

        if ($module["SELECTED"] === '1') {
            $r .= ' active';
        }

        if ($module["ISPARENT"] > '0'){ /* we have a submenu item */
            $r .= ' dropdown-toggle';
        }

        return $r;
    }

    function getSubMenuLinkCssClasses($module){

        $r = 'dropdown-item';

        if ($module['PERMISSION_ID'] < '2') {
            $r .= ' disabled';
        }

        if ($module["SELECTED"] === '1') {
            $r .= ' active';
        }

        if ($module["ISPARENT"] > '0'){ /* we have a submenu item */
            $r .= ' dropdown-toggle';
        }

        return $r;
    }

}



