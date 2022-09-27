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

            h.lang.titleText = 'Falsterbo Bird Observatory - Lodging'
            h.lang.bannerHeader = 'Lodging - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Falsterbo bird observatory is located at the edge of the Falsterbo park, on the south-western side, between the church and the museum. The house was built 1955 and has gone through a couple of renovations since. Its main purpose is lodging for the staff working at the observatory. However, in addition up to ten guest beds are available, in five tiny sleeping quarters, each with two bunk beds. These beds are rented out, primarily to birders. Amenities includes a shared complete kitchen, bathroom with shower, washing machine (for a fee) and freezer (if space available).';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Logi'
            h.lang.bannerHeader = 'Logi - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'Falsterbo Fågelstation ligger i sydvästra delen av Falsterbo park, mellan kyrkan och Falsterbo Museum. Huset byggdes 1955 och har renoverats ett par gånger därefter. Det fungerar i första hand som bostad för personalen. Stationen har dessutom (som mest) tio gästplatser. De är fördelade på fem sovhytter med våningssängar. Dessa platser hyrs ut, främst till fågelskådare. Gemensamt kök med full utrustning, toalett och dusch finns, liksom tvättmaskin (avgift 20 kr) och frys (i mån av plats).';

        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.text(h.lang.bannerHeader);
        h.bannerIntroText.text(h.lang.bannerIntroText);

    }

    function setUpTheMap(data){

        let zoom = 16;

        let mymap = L.map('rmap').setView([55.391, 12.836], zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(mymap);


        L.circle([55.389, 12.8365], {
            color: 'red',
            radius: 10
        }).addTo(mymap);


    }

    getHeaderTexts();
    setHeaderTexts();
    setUpTheMap();

});