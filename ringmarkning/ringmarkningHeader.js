
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

        h.lang.titleText = 'Falsterbo Bird Observatory - Ringing/Banding'
        h.lang.bannerHeader = 'Ringing/Banding - Falsterbo Bird Observatory';
        h.lang.bannerIntroText = 'The migration takes place day and night at different altitudes. The birds try to complete their journey as fast, efficient and safely as possible. For many birds the Baltic Sea is the first difficult barrier to cross on the southward migration route. Therefore, the birds rather follow the south and west coasts of Sweden until they finally reach Falsterbo. On good days you may see hundreds of thousands of birds passing. Most spectacular is the migration of raptors. Birdwatchers from near and far come to enjoy the show.';

    }


    // S V E N S K A
    if (h.lang.current === '2') {
        h.lang.langAsString = 'se';
        h.lang.decDelimiter = ',';
        h.lang.locale = 'sv-SE';

        h.lang.titleText = 'Falsterbo Fågelstation - Ringmärkning'
        h.lang.bannerHeader = 'Ringmärkning - Falsterbo Fågelstation';
        h.lang.bannerIntroText = 'Ringmärkning har bedrivits vid Falsterbo sedan 1940-talet. Fr.o.m. 1980 är rutinerna standardiserade. Märkning bedrivs sedan dess vid Falsterbo fyr under både vår och höst samt i Flommen på hösten. Standariseringen gör fångstsiffror från olika år direkt jämförbara och kan visa populationstrender och förändringar i flyttningsförlopp. Övrig (spontan) märkning bedrivs när tillfälle ges och personal finns till hands. Till exempel märks ugglor under vissa år vid fyren. Slutligen är återfynd av alla ringmärkta fåglar fortfarande av intresse. De kan t.ex. visa ändringar av övervintringsområden.';

    }

}

function setHeaderTexts(){

    h.titleText.text(h.lang.titleText);
    h.bannerHeader.text(h.lang.bannerHeader);
    h.bannerIntroText.text(h.lang.bannerIntroText);




}
