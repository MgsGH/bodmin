<?php

/*
 *
 *     // uses https://cdnjs.com/libraries/bootstrap-multiselect
 * // https://davidstutz.github.io/bootstrap-multiselect/
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html

 *
 */

class PageMetaData
{

    const JQuery = 0;
    const MapBox = 1;
    const BootstrapFyra = 2;
    const JQueryUI = 3;
    const MultiSelect = 4;
    const Select2 = 5;
    const LeafLet = 6;
    const BootstrapFem = 7;
    const DataTables = 8;
    const Cropper = 9;
    const Jodit = 10;
    /**
     * @var array[]
     */
    private $options;
    private $additionalJavaScriptFiles = array();
    private $dirPrefix = '';


    public function __construct($dir){

        $this->options = array(
            array( 'jquery', false ),               // 0
            array( 'mapBox', false ),               // 1
            array( 'bootstrapFyra', false ),        // 2
            array( 'jqueryUI', false ),             // 3
            array( 'multiSelect', false ),          // 4
            array( 'Select2', false ),              // 5
            array( 'LeafLet', false ),              // 6
            array( 'bootstrapFem', false ),         // 7
            array( 'dataTables', false ),           // 8
            array( 'cropper', false ),              // 9
            array( 'jodit', false ),                // 10

        );

        if ($dir === '') {
            if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
                $this->dirPrefix =  '';
            }

        } else {
            $this->dirPrefix = $dir;
        }

    }

    function setAdditionalJavaScriptFiles($name){
        array_push($this->additionalJavaScriptFiles, $name);
    }


    function setJquery($onOff){
        $this->options[PageMetaData::JQuery][1] = $onOff;
    }


    function setBootstrapFyra($onOff){
        $this->options[PageMetaData::BootstrapFyra][1] = $onOff;
    }

    function setBootstrapFem($onOff){
        $this->options[PageMetaData::BootstrapFem][1] = $onOff;
    }


    function setJQueryUI($onOff){
        $this->options[PageMetaData::JQueryUI][1] = $onOff;
    }


    function setMultiSelect($onOff){
        $this->options[PageMetaData::MultiSelect][1] = $onOff;
    }

    function setSelect2($onOff){
        $this->options[PageMetaData::Select2][1] = $onOff;
    }

    function setMapBox($onOff){
        $this->options[PageMetaData::MapBox][1] = $onOff;
    }

    function setLeafLet($onOff){
        $this->options[PageMetaData::LeafLet][1] = $onOff;
    }

    function setDataTables($onOff){
        $this->options[PageMetaData::DataTables][1] = $onOff;
    }

    function setJodit($onOff){
        $this->options[PageMetaData::Jodit][1] = $onOff;
    }

    function setCropper($onOff){
        $this->options[PageMetaData::Cropper][1] = $onOff;
    }

    function getHeadStyleSheetSectionAsHTML(): string
    {

        $headSection = '';
        $linkStart = '<link rel="stylesheet" href="';

        // Always linked in
        $headSection .=  $linkStart . 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">' . PHP_EOL;

        // JQuery
        if ($this->options[PageMetaData::JQuery][1]){
            // do nothing here; Jquery
        }

        // Bootstrap - 4 (.6)
        if ($this->options[PageMetaData::BootstrapFyra][1]){
            $headSection .= $linkStart . 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">' . PHP_EOL;        }

        // Bootstrap - 5
        if ($this->options[PageMetaData::BootstrapFem][1]){
            $headSection .= $linkStart . 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">' . PHP_EOL;
        }

        // Bootstrap-UI
        if ($this->options[PageMetaData::JQueryUI][1]){
            $headSection .= $linkStart . 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">' . PHP_EOL;
        }

        // MultiSelect
        if ($this->options[PageMetaData::MultiSelect][1]){
            $headSection .= $linkStart . 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" crossorigin="anonymous" referrerpolicy="no-referrer">' . PHP_EOL;
        }

        // Select2
        if ($this->options[PageMetaData::Select2][1]){
            $headSection .= $linkStart . 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">' . PHP_EOL;
        }

        // MapBox
        if ($this->options[PageMetaData::MapBox][1]){
            $headSection .= $linkStart . 'https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" crossorigin="anonymous" referrerpolicy="no-referrer">' . PHP_EOL;
        }

        // LeafLet
        if ($this->options[PageMetaData::LeafLet][1]){
            $headSection .= $linkStart . 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin="" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==">' . PHP_EOL;
        }

        // dataTables
        if ($this->options[PageMetaData::DataTables][1]){
            $headSection .= $linkStart . '//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">' . PHP_EOL;
        }

        // Jodit
        if ($this->options[PageMetaData::Jodit][1]){
            $headSection .= $linkStart . '//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css">' . PHP_EOL;
        }

        // Cropper
        if ($this->options[PageMetaData::Cropper][1]){
            $headSection .= $linkStart . 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.css">' . PHP_EOL;
        }

        $headSection .=  $linkStart . $this->dirPrefix . '/aahelpers/fbo-bluemallXXX.css?version=' . time() . '">' . PHP_EOL;
        $headSection .=  $linkStart . $this->dirPrefix . '/aahelpers/extras.css?version=' . time() . '">' . PHP_EOL;

        return $headSection;

    }


    function getJavaScriptSection() : string {

        // always
        $htmlSection = '';
        $htmlSectionStart = '<script src=';
        $htmlSectionEnd = '></script>' . PHP_EOL;


        // JQuery
        if ($this->options[PageMetaData::JQuery][1]){
            $htmlSection .= $htmlSectionStart . '"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"' . $htmlSectionEnd;
        }


        // Jquery-UI
        if ($this->options[PageMetaData::JQueryUI][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"' . $htmlSectionEnd;
        }

        // Bootstrap 4 (.6)
        if ($this->options[PageMetaData::BootstrapFyra][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"' . $htmlSectionEnd;
        }

        // Bootstrap 5
        if ($this->options[PageMetaData::BootstrapFem][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"' . $htmlSectionEnd;
        }

        // Select2 - searchable dropdown
        if ($this->options[PageMetaData::Select2][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" crossorigin=\"anonymous\"' . $htmlSectionEnd;
        }

        // MultiSelect
        if ($this->options[PageMetaData::MultiSelect][1]){
            $htmlSection .= $htmlSectionStart . '"https://unpkg.com/bootstrap-multiselect@1.1.0/dist/js/bootstrap-multiselect.js" crossorigin="anonymous"' . $htmlSectionEnd;
        }

        // MapBox
        if ($this->options[PageMetaData::MapBox][1]){
            $htmlSection .= $htmlSectionStart . '"https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js" crossorigin="anonymous"' . $htmlSectionEnd;
        }

        // LeafLet
        if ($this->options[PageMetaData::LeafLet][1]){
            $htmlSection .= $htmlSectionStart . '"https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin="" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="' . $htmlSectionEnd;
        }

        // DataTables
        if ($this->options[PageMetaData::DataTables][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js" crossorigin=""' . $htmlSectionEnd;
            $htmlSection .= $htmlSectionStart . '"https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js" crossorigin=""' . $htmlSectionEnd;
        }

        // Jodit
        if ($this->options[PageMetaData::Jodit][1]){
            $htmlSection .= $htmlSectionStart . '//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js' . $htmlSectionEnd;
        }

        // Cropper
        if ($this->options[PageMetaData::Cropper][1]){
            $htmlSection .= $htmlSectionStart . '"https://cdnjs.cloudflare.com/ajax/libs/cropper/4.1.0/cropper.min.js"' . $htmlSectionEnd;
            $htmlSection .= $htmlSectionStart . '"https://cdnjs.cloudflare.com/ajax/libs/jquery-cropper/1.0.1/jquery-cropper.min.js"' . $htmlSectionEnd;
        }

        $t = time();
        // local additional JS file(s)
        if ( count($this->additionalJavaScriptFiles) > 0 ){

            for ($i = 0; $i < count($this->additionalJavaScriptFiles); $i++ ){
                $htmlSection .= $htmlSectionStart . '"' . $this->additionalJavaScriptFiles[$i] . '?dummy=' . $t . '"' . $htmlSectionEnd;
            }

        }

        // always

        return $htmlSection . $htmlSectionStart  . '"' . $this->dirPrefix . '/aahelpers/mg-common.js?dummy=' . $t . '"' .  $htmlSectionEnd;

    }

}