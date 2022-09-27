
let h = {

    titleText: $('#titleText'),
    bannerHeader: $('#bannerHeader'),
    bannerIntroText: $('#bannerIntroText'),

    lang : {
        current : $('#lang').text(),
    },

}

function getHeaderTexts() {


    // E N G E L S K A
    if (h.lang.current === '1'){

        h.lang.titleText = 'Falsterbo Bird Observatory - Visible migration monitoring'
        h.lang.bannerHeader = 'Visible migration monitoring - Falsterbo Bird Observatory';
        h.lang.bannerIntroText = 'Visible migration monitoring has been done in Falsterbo, initially off and on, since Gustaf Rudebeck\'s pioneer studies in the early 1940s. Gradually the studies became increasingly intense, and since 1973 standardised with full coverage. Since 1978 these studies are a part of the Swedish national program for monitoring of bird population changes. The season starts 1st of August and runs until the 20th of November.';
    }


    // S V E N S K A
    if (h.lang.current === '2') {
        h.lang.langAsString = 'sv';
        h.lang.decDelimiter = ',';
        h.lang.locale = 'sv-SE';

        h.lang.titleText = 'Falsterbo Fågelstation - Sträckräkning'
        h.lang.bannerHeader = 'Sträckräkning - Falsterbo Fågelstation';
        h.lang.bannerIntroText = 'Sträckräkning har bedrivits vid Falsterbo i olika perioder sedan Gustaf Rudebecks pionjärstudier i början av 1940-talet. Den nuvarande serien har pågått oavbruten sedan hösten 1973 och ingår sedan 1978 i Naturvårdsverkets övervakning av populationsförändringar hos fåglar.';

    }

}

function setHeaderTexts(){

    h.titleText.text(h.lang.titleText);
    h.bannerHeader.text(h.lang.bannerHeader);
    h.bannerIntroText.text(h.lang.bannerIntroText);

}
