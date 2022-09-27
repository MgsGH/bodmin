$(document).ready(function(){

    let v = {

        lang: {
            current: $('#lang').text(),
        },
    }


    getHeaderTexts();
    setHeaderTexts();

    // https://select2.org/

    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

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

    getTexts();

});
