$(document).ready(function(){

    let v = {

        titleText : $('#titleText'),
        bannerHeader  : $('#bannerHeader'),
        bannerIntroText : $('#bannerIntroText'),

        featuredNewsIntroSection : $('#featuredNewsIntroSection'),
        featuredNewsIngress : $('#featuredNewsIngress'),

        language : {
            current : $('#langAsNo').text(),
        },

        date : {
            current : '',
        },

        smhi : getSmhiIds(),

        dayIntro : {
                ui : {
                    introSunUp : $('#introSunUp'),
                    introSunDown : $('#introSunDown'),
                    introNamesSuffix : $('#introNamesSuffix'),
               },
               language : {},
        },

        visibleMigrationSection : getVisibleMigrationSectionIds(),

        stagingSection : getStagingSectionIds(),

        ringingSection : getRingingSectionIds(),

        gallerySection : $('#gallerySectionBody'),

        blogDay : getBlogDaySection(),


    };


    function getTexts() {

        v.language.dateTexts = getDateTexts(v.language.current);
        v.visibleMigrationSection.language = getTextsBlogVisibleMigration(v.language.current);
        v.ringingSection.language = getTextsBlogRinging(v.language.current);
        v.smhi.language = getTextsBlogSmhi(v.language.current);
        v.stagingSection.language = getTextsBlogStagingSection(v.language.current);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.lang = {
                langAsString : 'en',
                locale : 'en-US',
            };
            v.language.decDelimiter = '.';
            v.language.locale = 'en-US';

            v.language.titleText = 'Falsterbo Bird Observatory - Home'
            v.language.bannerHeader = 'Home - Falsterbo Bird Observatory';
            v.language.bannerIntroText = 'The migration takes place day and night at different altitudes. The birds try to complete their journey as fast, efficient and safely as possible. For many birds the Baltic Sea is the first difficult barrier to cross on the southward migration route. Therefore, the birds rather follow the south and west coasts of Sweden until they finally reach Falsterbo. On good days you may see hundreds of thousands of birds passing. Most spectacular is the migration of raptors. Birdwatchers from near and far come to enjoy the show.';

            v.dayIntro.language = {
                introSunUp  : 'Sunrise at ',
                introSunDown: ' and sunset ',
                introAnd : ' and ',
                introSuffixNameDay : ' have their name day.'
            };

            v.language.photo = 'Photo: ';
            v.language.ringFound = 'Found a ring?';
            v.language.ringReportHere = 'Report it here';
            v.language.galleryHeader = 'Gallery';
            v.language.galleryIntro = 'The 3 most recent pics.';
            v.language.lokalt = '';
            v.language.supporters = 'Financial supporters';

            v.language.webShopHeader = 'Newest in the Webshop';
            v.language.headerSenasteNytt = 'News';
            v.language.headerAndraNyheter = 'Featured news';
            v.language.featuredNewsDisclaimer = 'No featured news published at the moment.';
            v.language.featuredNewsIngress = 'This section contains the tree most recent featured news, deemed to be a little more interesting than the <a href="/blog/?lang=en">average daily update.</a>';
        }


        // S V E N S K A
        if (v.language.current === '2') {
            v.language.langAsString = 'sv';
            v.lang = {
                langAsString : 'sv',
                locale : 'sv-SE',
            };
            v.language.decDelimiter = ',';
            v.language.locale = 'sv-SE';

            v.language.titleText = 'Falsterbo Fågelstation - Hem'
            v.language.bannerHeader = 'Hem - Falsterbo Fågelstation';
            v.language.bannerIntroText = 'Varje höst passerar omkring 500 miljoner flyttfåglar över södra Sverige. Flyttfåglarna måste genomföra sina resor så snabbt, säkert och effektivt som möjligt. För många fåglar är Östersjön det första svåra hindret på vägen söderut. Därför följer de kusterna så länge som möjligt. Till sist hamnar många vid Sveriges sydvästspets - Falsterbo. Därav uppstår koncentrationen av flyttfåglar vid Falsterbo under hösten. Särskilt omtalat är sträcket av rovfåglar. Ingen annanstans i Sverige ser man fler fåglar än under en bra dag vid Falsterbo.';

            v.dayIntro.language = {

                introSunUp  : 'Solen går upp ',
                introSunDown: ' och ned ',
                introAnd : ' och ',
                introSuffixNameDay : ' har namnsdag.'

            };


            v.language.photo = 'Foto: ';
            v.language.ringFound = 'Upphittad ring?';
            v.language.ringReportHere = 'Rapportera här';
            v.language.galleryHeader = 'Galleri';
            v.language.galleryIntro = 'De tre senaste bilderna.';
            v.language.lokalt = 'Lokalt';
            v.language.supporters = 'Finansiella supporters';

            v.language.webShopHeader = 'Senaste i webshopen';
            v.language.headerSenasteNytt = 'Senaste nytt';
            v.language.headerAndraNyheter = 'Äldre extra läsvärda dagboksblad';
            v.language.featuredNewsIngress = 'Nedan publiceras de tre senaste dagboksbladen som anses mer läsvärda än de vanliga <a href="/blog/?lang=en">dagliga blog sidorna.</a>';
            v.language.pageHeader = 'Falsterbo Fågelstation';
            v.language.featuredNewsDisclaimer = 'Inga extra läsvärda dagboksblad publicerade för stunden.';
            v.language.pageIntro = 'Page intro!';

        }

    }


    function setTexts(){

        // banner
        v.titleText.text(v.language.titleText);
        v.bannerHeader.text(v.language.bannerHeader);
        v.bannerIntroText.text(v.language.bannerIntroText);

        v.dayIntro.ui.introSunUp.text(v.dayIntro.language.introSunUp);
        v.dayIntro.ui.introSunDown.text(v.dayIntro.language.introSunDown);
        v.dayIntro.ui.introNamesSuffix.text(v.dayIntro.language.introSuffixNameDay);

        v.smhi.ui.smhiHeader.text(v.smhi.language.smhiHeader);

        v.smhi.ui.smhiHeaderTime.text(v.smhi.language.smhiHeaderTime);


        v.smhi.ui.smhiHeaderClouds.text(v.smhi.language.smhiHeaderClouds);
        v.smhi.ui.smhiHeaderClouds.attr('title', v.smhi.language.smhiHeaderCloudsTitle);

        v.smhi.ui.smhiHeaderWind.text(v.smhi.language.smhiHeaderWind);
        v.smhi.ui.smhiHeaderWind.attr('title', v.smhi.language.smhiHeaderWindTitle);

        v.smhi.ui.smhiHeaderTemp.text(v.smhi.language.smhiHeaderTemp);
        v.smhi.ui.smhiHeaderTemp.attr('title', v.smhi.language.smhiHeaderTempTitle);

        v.smhi.ui.smhiHeaderWindChill.text(v.smhi.language.smhiHeaderChillFactor);
        v.smhi.ui.smhiHeaderWindChill.attr('title', v.smhi.language.smhiHeaderChillFactorTitle);

        v.smhi.ui.smhiHeaderVisibility.text(v.smhi.language.smhiHeaderVisibility);
        v.smhi.ui.smhiHeaderVisibility.attr('title', v.smhi.language.smhiHeaderVisibilityTitle);

        v.smhi.ui.smhiHeaderPressure.text(v.smhi.language.smhiHeaderPressure);
        v.smhi.ui.smhiHeaderPressure.attr('title', v.smhi.language.smhiHeaderPressureTitle);

        v.smhi.ui.smhiHeaderUpdated.text(v.smhi.language.smhiHeaderUpdated);
        v.smhi.ui.smhiHeaderHour.text(v.smhi.language.smhiHeaderHour);
        v.smhi.ui.smhiHeaderMinute.text(v.smhi.language.smhiHeaderMinute);
        v.smhi.ui.smhiHeaderSecond.text(v.smhi.language.smhiHeaderSecond);
        v.smhi.ui.smhiHeaderSedan.text(v.smhi.language.smhiHeaderSedan);
        v.smhi.ui.smhiHeaderWeatherType.text(v.smhi.language.smhiHeaderWeatherType);

        v.smhi.ui.smhiHeaderComment.text(v.smhi.language.smhiHeaderComment);

        v.ringingSection.ui.ringingSectionHeader.text(v.ringingSection.language.header);

        v.stagingSection.ui.header.text(v.stagingSection.language.header);
        v.stagingSection.ui.rrInfo.text(v.stagingSection.language.rrInfo);
        v.stagingSection.ui.rrHere.text(v.stagingSection.language.rrHere);

        $('#galleryHeader').text(v.language.galleryHeader);
        $('#galleryIntro').text(v.language.galleryIntro);

        $('#ringFound').text(v.language.ringFound);
        $('#ringReportHere').text(v.language.ringReportHere);

        $('#lokalt').text(v.language.lokalt);
        $('#supporters').text(v.language.supporters);

        $('#smhiInfo').text(v.smhi.language.smhiInfo);
        $('#smhiInfoII').text(v.smhi.language.smhiInfoII);
        $('#webShopHeader').text(v.language.webShopHeader);
        $('#headerSenasteNytt').text(v.language.headerSenasteNytt);
        $('#headerAndraNyheter').text(v.language.headerAndraNyheter);
        $('#featuredNewsIngress').html(v.language.featuredNewsIngress);

        $('#pageHeader').text(v.language.pageHeader);
        $('#pageIntro').html(v.language.pageIntro);
        $('#smhiShortPrognosisText').html(v.smhi.language.smhiShortPrognosisText);

    }


    function populateWeatherInfo(){

        // Get the most recent weather reading - in current language
        let weatherData = v.allData['weatherData'];

        let general = weatherData[0];
        let comments = weatherData[1];

        let timme = getRightTime(general[0].TIME, general[0].DATUM );
        v.smhi.ui.smhiDataTime.text(timme);
        v.smhi.ui.smhiDataClouds.text(general[0].CLOUDS);
        v.smhi.ui.smhiDataWindDirection.text(general[0].WIND);
        v.smhi.ui.smhiDataWindForce.text(general[0].vsty);

        v.smhi.ui.smhiDataTemp.text( formatTemperatureValueAsString( v, general[0].TEMP ) + ' °C');
        let sikt = parseFloat(general[0].SIKT);
        if (sikt > 5){
            sikt = Math.round(sikt);
        }
        v.smhi.ui.smhiDataVisibility.text(sikt);

        let tryck = Math.round(parseFloat(general[0].TRYCK)*10)/10;
        tryck = tryck.toLocaleString(v.language.locale, {minimumFractionDigits: 1, maximumFractionDigits: 1});

        v.smhi.ui.smhiDataPressure.text(tryck);
        let l = comments.length;
        let txt = '';
        for (let i = 0; i < l; i++) {
            txt += ', ' + comments[i].TEXT;
        }
        v.smhi.ui.smhiDataComment.text(txt.substring(2));

        //plug in "n. appl." if temperature is outside the range of applicability
        const intTemp = parseFloat(general[0]["TEMP"]);
        const intWind = parseInt(general[0].vsty)

        if ((intTemp > 10) || (intWind <= 2)) {
            v.smhi.ui.smhiDataChillFactor.text("-----");
            v.smhi.ui.smhiDataChillFactor.attr('title', v.smhi.language.smhiChillFactorNotApplicable);
        } else {
            let wc = getWindChillValue(intTemp, intWind);
            v.smhi.ui.smhiDataChillFactor.text( formatTemperatureValueAsString( v, wc ) + ' °C' ) ;
            v.smhi.ui.smhiDataChillFactor.attr('title', v.smhi.language.smhiHeaderChillFactorTitle);
        }

    }


    function buildNewsSection() {

        // first (most recent entry
        v.blogDay.node = $('#theMostRecentBlogEntry');
        v.blogDay.node.empty();
        v.blogDay.node.toggleClass('blogPage', true);
        v.blogDay.node.toggleClass('container', true);

        // Get the most recent news item -> most recently published (in current language)
        let pageData = v.allData['firstBlogEntry'];

        compileBlogDayAllPageSections(pageData, v, '1');


        // Build a "blogPage" for each featured news (day)
        const featuredNews = $('#featuredNewsBody');
        let featuredNewsPieces = v.allData['featuredNews'];
        let numberOfNewsPieces = featuredNewsPieces.length;
        if (numberOfNewsPieces > 0){
            v.featuredNewsIntroSection.toggleClass('mg-hide-element', false);
        }

        for (let i = 0; i < numberOfNewsPieces; i++) {

            let pageData = featuredNewsPieces[i];
            let ymd = pageData['newsData']["DATE"];

            let featuredNewPiece = '<div id="featuredNewsItem-' + ymd + '" class="blogPage container"></div>';
            featuredNews.append(featuredNewPiece);
            v.blogDay.node = $('#featuredNewsItem-' + ymd);
            compileBlogDayAllPageSections(pageData, v, '1');

        }

    }


    function populateIntro(){

        let d = new Date();
        let y = d.getFullYear();

        let m = d.getMonth() + 1; // javaScript!
        if (m < 10){
            m = '0' + m;
        }

        let dag = d.getDate();
        if (dag < 10){
            dag = '0' + dag;
        }

        const url = 'https://sholiday.faboul.se/dagar/v2.1/' + y + '/' + m + '/' + dag;

        fetch(url).then(function(response) {

            // Examine the text in the response, make comma delimited list of names
            // Format it nicely depending on the number of names, one, two (or three).
            response.json().then(function(data) {
                let x = data.dagar;
                let names = x[0]["namnsdag"];

                let str = '';

                names.forEach(function( item ) {
                    str = str + item + ', ';
                });

                str = str.substring(0, str.length-2);
                if (str.indexOf(',', str) > 0){
                    let str1 = str.substring(0, str.lastIndexOf(','));
                    let str2 = str.substring(str.lastIndexOf(',') + 1);
                    str = str1 + v.dayIntro.language.introAnd + str2;
                }
                $('#introNamesData').text(str);

            });

        });
    }


    function loadImages(){

        v.gallerySection.empty();

        let pics = v.allData['picData'];

        pics.forEach(function (pic) {

            const titleText = pic['PLATS'] + ', ' + pic['DATUM'].substring(0,10) + ', ' + v.language.photo + pic['FNAMN'] + ' ' + pic['ENAMN'] + pic['WEBTEXT'];
            let photo = '<div class="photo d-flex justify-content-center">' +
           '<a href="/galleri/#maxipic-' + pic['ID'] + '.jpg"><img src="/v2images/minipics/minipic-' +  pic['ID'] + '.jpg" alt="icon" class="shadow rounded" title="' + titleText +'"></a>'
            photo = photo + '</div>';
            v.gallerySection.append(photo);

        })

    }


    function loadAllData(){

        v.gallerySection.empty();

        $.ajax({
            type:"GET",
            async: true,
            url: "../api/getHomePageData.php?lang=" + v.language.current,
            success: function(d) {

                v.allData = JSON.parse(d);

                loadImages();
                populateWeatherInfo();

                buildNewsSection();

            }

        })

    }


    $(document).on('click', '.btnVisibleMigration', function(){

        const clickedId = $(this).attr('id');
        const s = 'visibleMigrationSectionBody-' + clickedId.substring(clickedId.length-10);

        let visibleMigrationSection = $('#'+s);

        if (visibleMigrationSection.hasClass('mg-hide-element')){
            visibleMigrationSection.toggleClass('mg-hide-element', false);
            $(this).text(v.visibleMigrationSection.language.hideData);
        } else {
            visibleMigrationSection.toggleClass('mg-hide-element', true);
            $(this).text(v.visibleMigrationSection.language.showData);
        }

    });

    getTexts();
    setTexts();
    v.blogDay.node.html(mgGetDivWithSpinnerImg());

    v.date.current = getNowAsYMD();
    $('#introDayData').text(capitalizeFirstLetter(getFormattedDate(v.date.current, v)));


    populateIntro();
    loadAllData();


});