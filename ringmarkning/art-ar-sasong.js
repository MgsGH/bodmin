$(document).ready(function(){

    let v = {

        sasong: {
            current: $('#sasong').text(),
        },
    }

    // https://select2.org/

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
            $('#btnradio-FC').val() === "true";
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


    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });


    getHeaderTexts();
    setHeaderTexts();

    setSasongSelected();

});





