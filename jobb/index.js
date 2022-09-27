$(document).ready( function () {

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

            h.lang.titleText = 'Falsterbo Bird Observatory - Jobs'
            h.lang.bannerHeader = 'Jobs - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Working with us is a highly rewarding way to deepen your interest in birds. Besides close encounters with many thrilling species, you will also get some insights in the world of bird research. To see and handle birds in the hand gives new perspectives, and the possibility to pick up details also useful during normal birding situations.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Jobb'
            h.lang.bannerHeader = 'Jobb - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'Arbete på fågelstation är en annorlunda och spännande form att utveckla sitt fågelintresse. Förutom mötet med många spännande arter får man också en inblick i fågelforskningens värld. Att se och hålla fåglar i handen ger en viss känsla och dessutom upptäcker man detaljer, som också kan användas vid "vanligt" fågelskådande. Vill du se miljontals fåglar? Boka en höst vid Falsterbo Fågelstation.';

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