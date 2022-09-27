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

            h.lang.titleText = 'Falsterbo Bird Observatory - Guiding'
            h.lang.bannerHeader = 'Guiding - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Visible migration monitoring has been done in Falsterbo, initially off and on, since Gustaf Rudebeck\'s pioneer studies in the early 1940s. Gradually the studies became increasingly intense, and since 1973 standardised with full coverage. Since 1978 these studies are a part of the Swedish national program for monitoring of bird population changes. The season starts 1st of August and runs until the 20th of November.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Guidning'
            h.lang.bannerHeader = 'Guidning - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'Kom på en guidning och lär mer om fåglar och fågelflyttning vid Falsterbo! Varje år guidas mer än 5 000 personer vid Falsterbo Fågelstation. De flesta är skolbarn, men även familjer och andra grupper besöker oss. Det är en perfekt aktivitet när man har många på besök - ett utflyktsmål helt enkelt. Under säsong har vi alltid öppet. En guidning omfattar alltid ringmärkning av några fåglar och visning av fåglar i handen, ett mycket populärt inslag.';

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


