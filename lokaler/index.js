$(document).ready(function(){


    // https://ourcodeworld.com/articles/read/269/top-7-best-range-input-replacement-javascript-and-jquery-plugins
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html
    // https://www.jqueryscript.net/demo/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html
    // https://select2.org/


    let v = {

        dataArea : $('#dataArea'),
        dataTabs : $("#dataTabs"),
        language : {
            metaLang : $("#metaLang"),
            current : $('#lang').text(),
        },


        ui : {
            // text ids - for setting texts depending on language
            headerOverView  : $('#headerOverView'),
            introOverView  : $('#introOverView'),
        },
    }

    function setLangTexts(){

        // E N G E L S K A
        if (v.language.current === '1'){
            v.language.langAsString = 'en';
            v.language.localeString = 'en_GB';
            v.language.thousandSeparator = '.';

            v.ui.lang = {
                headerOverView : "Overview",
                introOverView : "Click in the map or use the menu on the left hand side.",
            };


        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.langAsString = 'se';
            v.language.localeString = 'sv_SE';
            v.language.thousandSeparator = ' ';

            v.ui.lang = {

                headerOverView : "Översikt",
                introOverView : "Klicka i kartan eller använd menyn till vänster.",
            };


        }

        v.ui.headerOverView.text(v.ui.lang.headerOverView);
        v.ui.introOverView.text(v.ui.lang.introOverView);

    }

    function buildPopUpText(locality){

        let url = locality.URL;
        if (v.language.current === "1"){
            url = url + '?lang=en' ;
        }

        return '<a href="' + url + '">' + locality.TEXT + '</a>';

    }

    function loadDataAndSetUpMap(){

        $.ajax({
            type: "get",
            url: "getLocalities.php",
            success: function (data) {

                locations = JSON.parse(data);
                setUpTheMap(locations);

            },

        });

    }

    function setUpTheMap(data){

        let zoom = 11;

        let mymap = L.map('rmap').setView([55.412, 12.88], zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(mymap);


        let markerArray = [];
        for (let i=0; i < data.length; i++){
            let lat = data[i].LAT;
            let lon = data[i].LON;
            let popupText = buildPopUpText(data[i]);
            markerArray.push( L.marker([lat, lon]).bindPopup( popupText ) );
        }

        let group = L.featureGroup(markerArray).addTo(mymap);
        mymap.fitBounds(group.getBounds());

    }

    resolveLanguage(v);
    loadDataAndSetUpMap();
    setLangTexts();
    getHeaderTexts();
    setHeaderTexts();

});





