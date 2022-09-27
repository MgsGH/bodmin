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
            h.lang.titleText = 'Falsterbo Bird Observatory - About us'
            h.lang.bannerHeader = 'About us - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Falsterbo bird observatory was founded by the regional ornitological society <a href="https://skof.se/">Skånes Ornitologiska Förening (SkOF)</a> 1955. SkOFs still provides the overall organizational structure for the work which of course has grown significantly over the years. At present we have staffing and activities throughout the year. The visible migration count, the ringing, and the public outreach are now well known in the neighbourhood.';
        }

        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.titleText = 'Falsterbo Fågelstation - Om oss'
            h.lang.bannerHeader = 'Om oss - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'Falsterbo fågelstation grundades av <a href="https://skof.se/">Skånes Ornitologiska Förening (SkOF)</a> 1955. SkOF är fortfarande huvudman för verksamheten som naturligtvis har växt betydligt genom åren. Numera har vi bemanning och verksamhet i stort sett året runt. Sträckräkningarna, ringmärkningen och inte minst guidningarna är numera välkända i trakten.';
        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.html(h.lang.bannerHeader);
        h.bannerIntroText.html(h.lang.bannerIntroText);

    }

    getHeaderTexts();
    setHeaderTexts();

});