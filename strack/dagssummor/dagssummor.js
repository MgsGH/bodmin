$(document).ready(function(){

    let v = {

        language : {
            current : $('#lang').text(),
        },

        dates : [],         // event dates
        date : {
            current : '',   // selected even date
            getParameter : $('#date').text(),
        },

        ui : {
            page : {
                strackDataHeader : $('#strackDataHeader'),
                strackDataSection : $('#strackDataSection'),
            },

        }

    }

    getHeaderTexts();
    setHeaderTexts();


    function setUpDatePicker(){

        // tie datepicker to navigation panel
        // https://stackoverflow.com/questions/6857025/highlight-dates-in-jquery-ui-datepicker
        // https://stackoverflow.com/questions/389743/in-jquery-ui-date-picker-how-to-allow-selection-of-specific-weekdays-and-disable
        $( '#datepicker' ).datepicker('destroy');
        $( '#datepicker' ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1959:+1", //
            firstDay: 1, // Start with Monday
            defaultDate: getDefaultDate(),
            onSelect: function (date) {
                v.date.current = date;
                /*
                v.blogDay = {
                    dateYMD : date,
                }
                */
                window.history.pushState('object or string', 'Title', '/strack/dagssummor/?date=' + v.date.current + '&language=' + v.language.current);
                composePage();
            },
            beforeShowDay: function(d) {
                let ymd = getDateAsYMDString(d)
                if ( v.dates.find(element => element === ymd) ){
                    return [true, "", ""];
                } else {
                    return [false, "", ""];
                }
            }


        });
        $("div.ui-datepicker").css("font-size", "70%");
        composePage();


    }

    function composePage(){

        v.ui.page.strackDataSection.empty();
        v.ui.page.strackDataSection.append(mgGetDivWithSpinnerImg());

        loadStandardStrackTable(v, v.ui.page.strackDataSection);

    }


    function getNumberOfBirdCaught(){

        v.ui.page.strackDataSection.empty();
        v.ui.page.strackDataSection.append(mgGetDivWithSpinnerImg());

        $.ajax({
            type: "GET",
            url: "getNoOfBirdsCounted.php",
            success: function (data) {

                let numbers = JSON.parse(data);
                $('#noOfBirds').text(formatNo(numbers, v, 0))

            }

        });

    }


    function getDefaultDate(){

        let answer = getDateFromYMDString(v.dates[v.dates.length-1]);
        v.date.current = v.dates[v.dates.length-1];

        if (v.date.getParameter !== ''){
            answer = getDateFromYMDString(v.date.getParameter);
            v.date.current = v.date.getParameter;
        }
        return answer;
    }


    function loadDays(){

        $.ajax({
            type: "GET",
            url: "getStrackDates.php",
            success: function (data) {
                v.dates = JSON.parse(data);
                v.date.current = getDefaultDate();
                setUpDatePicker();
            }
        });

    }


    loadDays();

    getNumberOfBirdCaught();

});