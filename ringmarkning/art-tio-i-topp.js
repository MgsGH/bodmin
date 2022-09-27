$(document).ready(function(){

    // https://select2.org/


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

    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });



});





