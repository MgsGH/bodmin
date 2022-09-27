$(document).ready(function() {

    let h = {

        titleText: $('#titleText'),
        bannerHeader: $('#bannerHeader'),
        bannerIntroText: $('#bannerIntroText'),

        lang: {
            current: $('#lang').text(),
        },
    }

    function getHeaderTexts() {


        // E N G E L S K A
        if (h.lang.current === '1') {

            h.lang.titleText = 'Falsterbo Bird Observatory - '
            h.lang.bannerHeader = 'Guiding - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Once a week birds are counted at seven localities around the Falsterbo peninsula. The counts started the winter 1992-93. The counts are a part of the environmental monitoring programme aiming at giving a long-term consistent material which can be used for various studies.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Rasträkning'
            h.lang.bannerHeader = 'Rasträkning - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'En gång i veckan räknas rastande fåglar runt Falsterbonäsets kuster. Räkningarna startade vintern 1992-93. Avsikten är att ha ett tidsmässigt heltäckande material, som visar hur fåglarna utnyttjar olika områden och vilka antalsförändringar som sker såväl kort- som långsiktigt.';

        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.text(h.lang.bannerHeader);
        h.bannerIntroText.text(h.lang.bannerIntroText);

    }

    getHeaderTexts();
    setHeaderTexts();

});


