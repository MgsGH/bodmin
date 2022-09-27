$(document).ready(function(){

    // https://select2.org/

    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    getHeaderTexts();
    setHeaderTexts();


});





