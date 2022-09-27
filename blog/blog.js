$(document).ready( function () {

    // on select date central here @ approx ...


    // https://pagination.js.org/docs/index.html
    // https://getbootstrap.com/docs/4.0/utilities/flex/
    // https://forum.jquery.com/topic/how-do-i-change-datepicker-cell-background


    let v = {

        language: {
            metaLang: $("#metaLang"),
            current : $('#langAsNo').text(),
        },

        date : {
            oldest : '1959-07-01',
            current : '',
            currentIndex : '',
            currentYMD : '',
            allDates : [],
        },

        displaySettings : {
            // 0 -> All
            // keyword : '0',
            taxon : '0',
            photographer : '0',
        },

        bannerHeader  : $('#bannerHeader'),

        bannerIntroText : $('#bannerIntroText'),

        smhi : getSmhiIds(),

        ringingSection : getRingingSectionIds(),

        visibleMigrationSection : getVisibleMigrationSectionIds(),

        stagingSection : getStagingSectionIds(),

        featuredNews : $('#featuredNewsBody'),

        gallerySection : $('#gallerySectionBody'),

        blogDay : getBlogDaySection(),

        controlPanel : {
            ui : {
            blogCalendar : $('#blogCalendar'),
            selectPanelSelect : $('#selectPanelSelect'),
            selectPanelSignaturesOne : $('#selectPanelSignaturesOne'),
            selectPanelSignaturesTwo : $('#selectPanelSignaturesTwo'),
            },
        },

        blogSection : {
            theSectionItself: $('#blogSection'),
            browseTip: $('#browseTip'),

        },

        mainPageSections : {
            dateHeader: $('#dateHeader'),
            oldStyle  : $('#oldPage'),
            pdfIframe : $('#pdfIframe'),
            btnBackTop: $('#btnBackTop'),
            btnBackBottom: $('#btnBackBottom'),
            btnNextTop: $('#btnNextTop'),
            btnNextBottom: $('#btnNextBottom'),
        },

     };


    function setLangTexts(){

        //let nbsp = String.fromCharCode(160);
        v.language.dateTexts = getDateTexts(v.language.current);
        v.visibleMigrationSection.language = getTextsBlogVisibleMigration(v.language.current);
        v.ringingSection.language = getTextsBlogRinging(v.language.current);
        v.smhi.language = getTextsBlogSmhi(v.language.current);
        v.stagingSection.language = getTextsBlogStagingSection(v.language.current);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.titleText = 'Falsterbo Fågelstation - Hem'
            v.language.bannerHeader = 'Blog';
            v.language.bannerIntroText = "Throughout the years, ever since the 50's, a daily log has been written at the Bird Observatory. The basic structure remained unchanged for many years. With the arrival of the web site this has changed towards a blog with a more open content. Data is still the backbone, but also anecdotal content is welcome as well as photos. There are no expectations for an every-day-prose update and many days are empty, especially during off-season. Ringing, staging, and migration data is automatically retrieved from our own database.";

            v.language.langAsString = 'en';
            v.language.locale = "en-US";
            v.language.thousandSeparator = '.';

            v.language.dateTexts = getDateTexts(v.language.current);
            v.visibleMigrationSection.language = getTextsBlogVisibleMigration(v.language.current);
            v.ringingSection.language = getTextsBlogRinging(v.language.current);
            v.smhi.language = getTextsBlogSmhi(v.language.current);
            v.stagingSection.language = getTextsBlogStagingSection(v.language.current);

            v.controlPanel.language = {
                selectPanelSignaturesOne : "Signatures (name)",
                selectPanelSignaturesTwo : "Hover the mouse pointer over the signatures in the text.",
                selectPanelSelect : "Select a day in the calendar above.",
            };

            v.blogSection.language = {
                browseTip : 'Browse previous/next day in the blog, links above.',
            };

        }

        // S V E N S K A
        if (v.language.current === '2'){

            v.language.titleText = 'Falsterbo Fågelstation - Dagboken'
            v.language.bannerHeader = 'Dagboken';
            v.language.bannerIntroText = 'Ända sedan 1950-talet har det skrivits en "dagbok" vid fågelstationen. Den hade i princip  samma uppbyggnad under lång tid. I och publiceringen av websajten så öppnades nya möjligheter. Här satsar vi på en friare stil där själva upplevelserna av vad-det-nu-vara-månde också ges plats. Tanken är dessutom att alla i personalen skall kunna bidra till dagboken. Det finns inga anspråk på att varje dag skall ha text bortom ringmärknings-, sträck- och rastfågelsiffror som hämtas direkt ur egen databas.';

            v.language.langAsString = 'se';
            v.language.locale = "sv-SE";
            v.language.thousandSeparator = ' ';


            v.controlPanel.language = {
                selectPanelSignaturesOne : "Signaturer (namn)",
                selectPanelSignaturesTwo : "Håll muspekaren över signaturen i texten.",
                selectPanelSelect : "Välj en dag i kalendern ovan.",
            }

            v.blogSection.language = {
                browseTip : 'Bläddra gärna bakåt/framåt i dagboken.',
            };

        }

        // banner
        v.bannerHeader.text(v.language.bannerHeader);
        v.bannerIntroText.text(v.language.bannerIntroText);
        v.controlPanel.ui.selectPanelSelect.text(v.controlPanel.language.selectPanelSelect);
        v.controlPanel.ui.selectPanelSignaturesOne.text(v.controlPanel.language.selectPanelSignaturesOne);
        v.controlPanel.ui.selectPanelSignaturesTwo.text(v.controlPanel.language.selectPanelSignaturesTwo);

        v.ringingSection.ui.ringingSectionHeader.text(v.ringingSection.language.header);

        // visible migration section
        v.visibleMigrationSection.ui.visibleMigrationSectionHeader.text(v.visibleMigrationSection.language.visibleMigrationSectionHeader);
        v.visibleMigrationSection.ui.visibleMigrationHeaderTaxa.text(v.visibleMigrationSection.language.visibleMigrationHeaderTaxa);
        v.visibleMigrationSection.ui.visibleMigrationHeaderDayTotal.text(v.visibleMigrationSection.language.visibleMigrationHeaderDayTotal);
        v.visibleMigrationSection.ui.visibleMigrationSeasonTot.text(v.visibleMigrationSection.language.visibleMigrationSeasonTot);
        v.visibleMigrationSection.ui.visibleMigrationHeaderAverageThisSeason.text(v.visibleMigrationSection.language.visibleMigrationHeaderAverageThisSeason);
        v.visibleMigrationSection.ui.visibleMigrationHeaderAverageAllSeasons.text(v.visibleMigrationSection.language.visibleMigrationHeaderAverageAllSeasons);

        v.stagingSection.ui.header.text(v.stagingSection.language.header);
        v.stagingSection.ui.rrInfo.text(v.stagingSection.language.rrInfo);
        v.stagingSection.ui.rrHere.text(v.stagingSection.language.rrHere);

    }


    function composePage(){

        // default visibility
        v.blogDay.node.toggleClass("mg-hide-element", false);
        v.mainPageSections.oldStyle.toggleClass("mg-hide-element", true);

        if ( isSelectedDateOld() ) {  // earlier than 2007

            //hide new section
            v.blogDay.node.toggleClass("mg-hide-element", true);
            // and show pdf section
            v.mainPageSections.oldStyle.toggleClass("mg-hide-element", false);

            // create pdf-source and update page
            let pdfLink = '/blog/' + v.date.current.substring( 0, 4) + "/" + v.date.current + '.pdf';
            v.mainPageSections.pdfIframe.attr('src', pdfLink);


        } else {                   // later than 2006 compose a new page

            v.blogDay.blogText = "";  // important when we list several days
            v.blogDay.node.html(mgGetDivWithSpinnerImg());

            $.ajax({
                type: "GET",
                url: "getAllBlogDayData.php?lang=" + v.language.current + '&ymd=' + v.date.current,
                success: function (data) {

                    let pageData = JSON.parse(data);
                    let newsData = pageData['newsData'];

                    if (newsData.length > 0){
                        v.blogDay.dateYMD = newsData["DATE"];
                        v.blogDay.blogText = newsData["TEXT"];
                    }

                    // the slot where the page will be put in the DOM.
                    v.blogDay.node.empty();
                    compileBlogDayAllPageSections(pageData, v, '2');

                }
            });

        }

    }


    function isSelectedDateOld(){
        const currentYear = v.date.current.substring(0,4);
        return currentYear < 2007;
    }


    v.mainPageSections.btnBackBottom.on('click', function(){
        handlePreviousDay();
    });

    v.mainPageSections.btnBackTop.on('click', function(){
        handlePreviousDay()
    });

    v.mainPageSections.btnNextBottom.on('click', function() {
        handleNextDay();
    });

    v.mainPageSections.btnNextTop.on('click', function() {
        handleNextDay();
    });

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

    function handleNextDay(){
        v.blogDay.dateYMD = getNextBlogDay();
        v.controlPanel.ui.blogCalendar.datepicker('setDate', getDateFromYMDString(v.blogDay.dateYMD) );
        $('.ui-datepicker-current-day').click();
        composePage();
    }


    function handlePreviousDay(){
        v.blogDay.dateYMD = getOlderBlogDay();
        v.controlPanel.ui.blogCalendar.datepicker('setDate', getDateFromYMDString(v.blogDay.dateYMD) );
        $('.ui-datepicker-current-day').click();
        composePage();
    }


    function reSetDatePicker(date){

        v.controlPanel.ui.blogCalendar.datepicker('destroy');
        v.controlPanel.ui.blogCalendar.datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            defaultDate : date,
            changeMonth: true,
            changeYear: true,
            yearRange: "1959:+0", //
            firstDay: 1, // Start with Monday
            onSelect: function (date) {
                v.date.current = date;
                v.blogDay.dateYMD = date;
                window.history.pushState('object or string', 'Title', '/blog/?date=' + v.blogDay.dateYMD);
                enableDisAbleBrowseButtons();
                composePage();
            },
            beforeShowDay: function(d) {
                let ymd = getDateAsYMDString(d)
                if ( v.date.allDates.find(element => element === ymd) ){
                    return [true, "", ""];
                } else {
                    return [false, "", ""];
                }
            }
        });
        $("div.ui-datepicker").css("font-size", "80%");

    }


    function enableDisAbleBrowseButtons(){

        // before (older dates) buttons
        let d = getOlderBlogDay(v.date.current);
        v.mainPageSections.btnBackTop.prop('disabled', false);
        v.mainPageSections.btnBackBottom.prop('disabled', false);
        if (d === "1000-10-10"){
            v.mainPageSections.btnBackTop.prop('disabled', true);
            v.mainPageSections.btnBackBottom.prop('disabled', true);
        }

        d = getNextBlogDay();
        v.mainPageSections.btnNextTop.prop('disabled', false);
        v.mainPageSections.btnNextBottom.prop('disabled', false);
        if (d === "1000-10-10"){
            v.mainPageSections.btnNextTop.prop('disabled', true);
            v.mainPageSections.btnNextBottom.prop('disabled', true);
        }

    }


    function getOlderBlogDay(){

        let index = 0;
        const l = v.date.allDates.length;
        for ( let i = 0; i < l; i++){
            if (v.date.allDates[i] === v.blogDay.dateYMD){
                index = i;
                break;
            }
        }

        let answer = "1000-10-10";
        if ((index + 1) < v.date.allDates.length){
            answer = v.date.allDates[index+1];
        }

        return answer;

    }


    function getNextBlogDay(){

        let index = 0;
        const l = v.date.allDates.length;
        for ( let i = 0; i < l; i++){
            if (v.date.allDates[i] === v.blogDay.dateYMD){
                index = i;
                break;
            }
        }

        let answer = "1000-10-10";
        if ( index > 0 ){
            answer = v.date.allDates[index-1];
        }

        return answer;

    }

    function checkIfDateIsAmongAllDates(ymdString){

        let result = false;
        const l = v.date.allDates.length;
        for (let i  =0; i < l; i++){

            if ( v.date.allDates[i] === ymdString ){
                result = true;
                break;
            }

        }

        return result;

    }


    function getAllDates(){

        $.ajax({
            type: "GET",
            url: "getAllPublishedDates.php?lang=" + v.language.current,
            success: function (data) {
                v.date.allDates = JSON.parse(data);
                // default most recent date as selected.
                v.date.current = v.date.allDates[0];
                v.blogDay.dateYMD = v.date.allDates[0];

                // unless date is set in the URL
                let url_string = window.location.href;
                let url = new URL(url_string);
                let date = url.searchParams.get("date");

                if ( checkIfDateIsAmongAllDates(date) ){
                    v.date.current = date;
                    v.blogDay.dateYMD = date;
                }

                reSetDatePicker(v.date.allDates[0]);
                enableDisAbleBrowseButtons();
                composePage();
            }
        });

    }

    resolveLanguage(v);

    setLangTexts();
    getAllDates();

});