$(document).ready(function(){

    let v = {

        lang : {
            current : $('#lang').text(),
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



    getHeaderTexts();
    setHeaderTexts();

});