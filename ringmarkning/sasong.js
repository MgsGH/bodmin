$(document).ready(function(){

    let v = {

        lang : {
            current : $('#lang').text(),
        },
        sasong : {
            current : $('#sasong').text(),
        },

    }

    function getTexts() {

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';
            v.lang.decDelimiter = '.';
            v.lang.locale = 'en-US';

        }


        // S V E N S K A
        if (v.lang.current === '2') {
            v.lang.langAsString = 'se';
            v.lang.decDelimiter = ',';
            v.lang.locale = 'sv-SE';

        }

    }


    function setSasongSelected(){

        $('#btnradio-FA').checked = false;
        $('#btnradio-FB').checked = false;
        $('#btnradio-FC').checked = false;
        $('#btnradio-OV').checked = false;
        $('#btnradio-PU').checked = false;

        if (v.sasong.current === 'FA'){
            $('#btnradio-FA').checked = true;
            $('#lbl-FA').toggleClass('active', true);
        }

        if (v.sasong.current === 'FB'){
            $('#btnradio-FB').checked = true;
            $('#lbl-FB').toggleClass('active', true);
        }

        if (v.sasong.current === 'FC'){
            $('#btnradio-FC').val() == "true";
            $('#lbl-FC').toggleClass('active', true);
        }

        if (v.sasong.current === 'OV'){
            $('#btnradio-OV').checked = true;
            $('#lbl-OV').toggleClass('active', true);
        }

        if (v.sasong.current === 'PU'){
            $('#btnradio-PU').checked = true;
            $('#lbl-PU').toggleClass('active', true);
        }

    }

    getHeaderTexts();
    setHeaderTexts();

    setSasongSelected();

});