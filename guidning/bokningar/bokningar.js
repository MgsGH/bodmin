$(document).ready( function () {

    // on select date central here @ approx 495.


    // https://pagination.js.org/docs/index.html
    // https://getbootstrap.com/docs/4.0/utilities/flex/
    // https://forum.jquery.com/topic/how-do-i-change-datepicker-cell-background


    let v = {

        language: {
            metaLang: $("#metaLang"),
            current : $('#lang').text(),
        },

        date : {
            oldest : '1959-07-01',
            current : '',
            currentIndex : '',
            currentYMD : '',
            allDates : [],
        },


        bannerHeader  : $('#bannerHeader'),
        bannerIntroText : $('#bannerIntroText'),

        bokningsSection : {
            bokningsInfo : $('#bokningsInfo'),
            selectedDate : $('#selectedDate'),
            bookingHeader : $('#bookingHeader'),
            bookingList : $('#bookingList'),

        },

        ui : {

            mainPageSections : {
                dateHeader: $('#dateHeader'),
                btnBackTop: $('#btnBackTop'),
                btnBackBottom: $('#btnBackBottom'),
                btnNextTop: $('#btnNextTop'),
                btnNextBottom: $('#btnNextBottom'),
            },

            controlPanel : {
                bookingsCalendar: $('#bookingsCalendar'),
            },

            bookingList : $('#bookingList'),

         },


    }

    function setLangTexts(){

        //let nbsp = String.fromCharCode(160);
        v.language.dateTexts = getDateTexts(v.language.current);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.titleText = 'Falsterbo Fågelstation - Hem'
            v.language.bannerHeader = 'Blog';
            v.language.bannerIntroText = "Throughout the years, ever since the 50's, a daily log has been written at the Bird Observatory. The basic structure remained unchanged for many years. With the arrival of the web site this has changed towards a blog with a more open content. Data is still the backbone, but also anecdotal content is welcome as well as photos. There are no expectations for an every-day-prose update and many days are empty, especially during off-season. Ringing, staging, and migration data is automatically retrieved from our own database.";

            v.language.langAsString = 'en';
            v.language.localeString = "en_US";
            v.language.thousandSeparator = '.';

            v.language.personer = 'personer';
            v.language.bokningarHeader = 'Bokningar';
            v.language.bokningarInfo = 'Here you can see our booking status. Use the calendar to the left. Only days with at least one booking are clickable. All days within season are possible to book.';

        }

        // S V E N S K A
        if (v.language.current === '2'){

            v.language.titleText = 'Falsterbo Fågelstation - Dagboken'
            v.language.bannerHeader = 'Dagboken';
            v.language.bannerIntroText = 'Ända sedan 1950-talet har det skrivits en "dagbok" vid fågelstationen. Den hade i princip  samma uppbyggnad under lång tid. I och publiceringen av websajten så öppnades nya möjligheter. Här satsar vi på en friare stil där själva upplevelserna av vad-det-nu-vara-månde också ges plats. Tanken är dessutom att alla i personalen skall kunna bidra till dagboken. Det finns inga anspråk på att varje dag skall ha text bortom ringmärknings-, sträck- och rastfågelsiffror som hämtas direkt ur egen databas.';

            v.language.langAsString = 'se';
            v.language.localeString = "sv_SE";
            v.language.thousandSeparator = ' ';

            v.language.personer = 'personer';
            v.language.bokningarHeader = 'Bokningar';
            v.language.bokningarInfo = 'Här kan du se bokningsläget. Använd kalendern till vänster. Endast dagar då vi redan har minst en bokning är klickbara. Alla dagar inom säsongerna är bokningsbara.';

        }

        // banner
        v.bannerIntroText.text(v.language.bannerIntroText);
        $('#bookingInfo').text(v.language.bokningarInfo);
        $('#bookingHeader').text(v.language.bokningarHeader);

    }



    v.ui.mainPageSections.btnBackBottom.on('click', function(){
        handlePreviousDay();
    });

    v.ui.mainPageSections.btnBackTop.on('click', function(){
        handlePreviousDay()
    });

    v.ui.mainPageSections.btnNextBottom.on('click', function() {
        handleNextDay();
    });

    v.ui.mainPageSections.btnNextTop.on('click', function() {
        handleNextDay();
    });


    function handleNextDay(){
        v.blogDay.dateYMD = getNextBlogDay();
        v.ui.controlPanel.blogCalendar.datepicker("setDate", getDateFromYMDString(v.blogDay.dateYMD) );
        $('.ui-datepicker-current-day').click();
        composePage();
    }


    function handlePreviousDay(){
        v.blogDay.dateYMD = getOlderBlogDay();
        v.ui.controlPanel.blogCalendar.datepicker("setDate", getDateFromYMDString(v.blogDay.dateYMD) );
        $('.ui-datepicker-current-day').click();

    }


    function reSetDatePicker(date){

        v.ui.controlPanel.bookingsCalendar.datepicker('destroy');
        v.ui.controlPanel.bookingsCalendar.datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1959:+1", //
            firstDay: 1, // Start with Monday
            defaultDate: new Date(),
            onSelect: function (date) {
                v.date.current = date;
                window.history.pushState('object or string', 'Title', '/guidning/bokningar/?date=' + v.date.current);
                enableDisAbleBrowseButtons();
                populateBookingStatus();
            },
            beforeShowDay: function(d) {
                let ymd = getDateAsYMDString(d)

                let selectable  = false;
                let theClass = "";
                if (isDayStandardRingingDay(ymd)){
                    theClass = "boldText";
                }
                if ( v.date.allDates.find(element => element === ymd) ){
                    selectable  = true;
                }

//                console.log(ymd + '  ' + theClass);

                let answer = Array();
                answer.push(selectable);
                answer.push(theClass);
                answer.push("");
                return answer;
            }
        });
        $("div.ui-datepicker").css("font-size", "70%");

    }


    function enableDisAbleBrowseButtons(){

        /*

        // before (older dates) buttons
        let d = getOlderBlogDay(v.date.current);
        v.ui.mainPageSections.btnBackTop.prop('disabled', false);
        v.ui.mainPageSections.btnBackBottom.prop('disabled', false);
        if (d === "1000-10-10"){
            v.ui.mainPageSections.btnBackTop.prop('disabled', true);
            v.ui.mainPageSections.btnBackBottom.prop('disabled', true);
        }

        d = getNextBlogDay();
        v.ui.mainPageSections.btnNextTop.prop('disabled', false);
        v.ui.mainPageSections.btnNextBottom.prop('disabled', false);
        if (d === "1000-10-10"){
            v.ui.mainPageSections.btnNextTop.prop('disabled', true);
            v.ui.mainPageSections.btnNextBottom.prop('disabled', true);
        }

         */

    }


    function getNextBlogDay(){

/*
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


 */

        return true;

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
            url: "getBookingDates.php",
            success: function (data) {
                v.date.allDates = JSON.parse(data);
                // default most recent date as selected.
                v.date.current = v.date.allDates[0];

                // unless date is set in the URL
                let url_string = window.location.href;
                let url = new URL(url_string);
                let date = url.searchParams.get("date");

                if ( checkIfDateIsAmongAllDates(date) ){
                    v.date.current = date;

                }

                reSetDatePicker(v.date.allDates[0]);

            }
        });

    }


    function populateBookingStatus(){

        v.ui.bookingList.empty();
        $('#selectedDate').text(v.date.current);

        $.ajax({
            type: "GET",
            url: "getBookingsForDate.php?datum=" + v.date.current,
            success: function (data) {

                let bookings = JSON.parse(data);

                let l = bookings.length;
                let html = '';
                for (let i = 0; i < l; i++) {
                    console.log(bookings[i]);

                    html += '<li class="list-group-item">';
                    html += bookings[i].TIME + ' ' + bookings[i].PARTY + ', ' + bookings[i].PARTICIPANTS + ' ' + v.language.personer;
                    html += '</li>';

                }

                v.ui.bookingList.append(html);

            }
        });

    }

    resolveLanguage(v);

    setLangTexts();
    getAllDates();

});