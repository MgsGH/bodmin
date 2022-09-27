$(document).ready(function(){

    let v = {

        currentModule : '21',

        language : {
            current : $('#systemLanguageId').text(),

        },

        loggedInUserId : $('#loggedInUserId').text(),
        mainTableId : '0',
        selectedDate : {
            ymd : '',
            asDate : ''
        },

        controlPanel : {
            ui : {
                theDatePicker : $('#datepicker'),
                btnEdit :  $('#btnChange'),
                btnDelete :  $('#btnDelete'),
                btnNew :  $('#btnNew'),
                selectedIntro : $('#selectedIntro'),
                selectedDateInfo : $('#selectedDate'),
                introTime : $('#introTime'),
                selectedTime : $('#selectedTime'),
                suffixTime : $('#suffixTime'),
                help : $('#help'),

            },
            language : {},
            ringingDates : {}
        },

        table : {
            ui : {
                weatherTableBody : $('#weatherTableBody'),
                thTime : $('#thTime'),
                thVisibility : $('#thVisibility'),
                thClouds : $('#thClouds'),
                thWindDirection : $('#thWindDirection'),
                thWindForce : $('#thWindForce'),
                thTemp : $('#thTemp'),
                thPressure : $('#thPressure'),
                thComment : $('#thComment'),
                thCreated : $('#thCreated')
            },
            language : {}
        },

        modalEditWeatherReading : {
            ui : {
                window : $('#editMain'),
                header : $('#modalMainHeader'),
                sectionDelete : $('#modalMainDeleteSection'),
                sectionEdit : $('#modalMainEditSection'),
                modalWaitSection : $('#modalWaitSection'),

                // labels, fields and warnings
                warningTextsAll : $("small[id^='warning']"),
                warningDateFrom : $('#warningDateFrom'),
                warningDateTo : $('#warningDateTo'),

                slctTime : $('#slctTime'),
                lblSlctTime : $('#lblSlctTime'),
                wrnSelectTime : $('#warningSelectTime'),

                inpVisibility : $('#inpVisibility'),
                lblInpVisibility : $('#lblInpVisibility'),
                warningInpVisibility : $('#warningInpVisibility'),

                slctClouds : $('#slctClouds'),
                lblSlctClouds : $('#lblSlctClouds'),

                slctWindDirection : $('#slctWindDirection'),
                lblSlctWindDirection : $('#lblSlctWindDirection'),

                inpVindStyrka : $('#inpVindStyrka'),
                lblInpVindStyrka : $('#lblInpVindStyrka'),
                warningInpVindStyrka : $('#warningInpVindStyrka'),

                inpTemperatur : $('#inpTemperatur'),
                lblInpTemperatur : $('#lblInpTemperatur'),
                warningInpTemperatur : $('#warningInpTemperatur'),

                inpTryck : $('#inpTryck'),
                lblInpTryck : $('#lblInpTryck'),
                warningInpTryck : $('#warningInpTryck'),

                slctComment : $('#slctComment'),
                lblSlctComment : $('#lblSlctComment'),
                selectedKeywords : $('#selectedKeywords'),

                btnSave : $('#btnModalMainSave'),
                btnCancel : $('#btnModalMainCancel')
            },
            language : {}
        },

    };

    function setLangTexts(){

        v.modalEditWeatherReading.maxMin = {
            visibilityMin : '0',
            visibilityMax : '99',
            windForceMin : '0',
            windForceMax : '45',
            temperatureMin : '-25',
            temperatureMax : '35',
            airPressureMin : '950',
            airPressureMax : '1080'
        }

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.decSign = '.';
            v.language.langAsString = 'en';
            v.language.locale = 'en-US';

            v.language.title= 'Weather';
            // header info
            v.language.loggedinText = 'Logged in as ';
            v.language.notLoggedinText = 'You are not logged in';
            v.language.logOutHere = "Log out here";
            v.language.pageTitle = "Weather";
            v.language.hdrMain = "Weather";
            v.language.calendarDisabledMessage = 'Disabled';

            v.controlPanel.language = {
                selectedIntro : 'Selected:',
                selectInfo : 'Select a weather recording',
                introTime : ', ',
                suffixTime : " o'clock",
                btnNew : 'New weather recording',
                btnEdit : 'Change',
                btnDelete : 'Remove'
            }

            v.table.language = {
                thTime : 'Observation',
                thVisibility : 'Visibility',
                thClouds : 'Cloudiness',
                thWindDirection : 'Wind direction',
                thWindForce : 'Wind force',
                thTemp : 'Temperatur',
                thPressure : 'Pressure (hPa)',
                thComment : 'Comment',
                thCreated : 'Post created'
            }

            v.modalEditWeatherReading.language = {
                headerEdit          : 'Change',
                headerNew           : 'New',
                headerDelete        : 'Delete',
                // field labels
                to                  : ' to ',
                lblSlctTime         : 'Observation',
                lblInpVisibility    : 'Visibility',
                wrnInpVisibilityLength : 'We use full Km - except when foggy (visibility less than 5 Km), then visibility in decimal Km).',
                wrnInpTempLength    : 'Give temperature with max one decimal.',
                wrnInpTryckLength    : 'Give pressure with max one decimal.',
                wrnInpIncorrectDecimalNumber    : 'Incorrect decimal number. Only digits, minus, and (correct) decimal point.',
                wrnInpIncorrectVisibility    : 'Incorrect value. Use only digits and (correct) decimal point.',
                wrnInpVindStyrka    : 'Wind force is given in whole (integer) numbers.',
                wrnDuplicateTime    : 'This time is already entered.',
                lblSlctClouds       : 'Cloudiness',
                lblSlctWindDirection: 'Wind direction',
                lblInpVindStyrka    : 'Wind force',
                lblInpTemperatur    : 'Temperature',
                lblInpTryck         : 'Pressure',
                lblSlctComment      : 'Weather comment',
                lblSlctCommentPrompt: 'Select weather comment',
                wrnMustBeFilledOut : 'Must be given',
                warningOutOfBounds  : 'Value outside the allowed range from MIN to MAX',
                // button texts
                btnSave             : 'Save',
                btnCancel           : 'Cancel',
                ja                  : "Yes",
                nej                 : "No",
            }


        }

        // S V E N S K A
        if (v.language.current === '2'){

            v.language.decSign = ',';
            v.language.langAsString = 'se';
            v.language.locale = 'sv-SE';

            v.language.title= 'Väder';
            // header info
            v.language.loggedinText = 'Inloggad som ';
            v.language.notLoggedinText = 'Du är ej inloggad';
            v.language.logOutHere = "Logga ut här";
            v.language.pageTitle = "Väder";
            v.language.hdrMain = "Väder";
            v.language.calendarDisabledMessage = 'Avstängd';

            v.controlPanel.language = {
                // vänster sidan
                selectedIntro : 'Vald:',
                introTime : ', kl: ',
                suffixTime : "",
                btnNew : 'Ny väderobs',
                btnEdit : 'Ändra',
                btnDelete : 'Tag bort'
            }
            
            v.table.language = {
                thTime : 'Obs',
                thVisibility : 'Sikt'  + String.fromCharCode(160) + '(km)',
                thClouds : 'Molnighet',
                thWindDirection : 'Vind',
                thWindForce : 'Vindstyrka'  + String.fromCharCode(160) + '(m/s)',
                thTemp : 'Temperatur'  + String.fromCharCode(160) + '(°C)',
                thPressure : 'Lufttryck' + String.fromCharCode(160) + '(hPa)',
                thComment : 'Kommentar',
                thCreated : 'Post skapad'
            }

            v.modalEditWeatherReading.language = {
                headerEdit          : 'Ändra väderobs',
                headerNew           : 'Ny väderobs',
                headerDelete        : 'Tag bort väderobs',

                // field labels
                to                  : ' till ',
                lblSlctTime         : 'Obs',
                lblInpVisibility    : 'Sikt' + String.fromCharCode(160) + '(km)',
                wrnInpVisibilityLength    : 'Ange hela km - utom när det är dimmigt (sikt < 5 km), då kan som minst 0,X km användas',
                wrnInpTempLength    : 'Temperatur anges med max en decimal',
                wrnInpTryckLength   : 'Ange tryck med som mest en decimal',
                wrnInpIncorrectDecimalNumber    : 'Inkorrekt värde. Använd endast siffror, minus, och (rätt) decimaltecken.',
                wrnInpIncorrectVisibility    : 'Inkorrekt värde. Använd endast siffror och (rätt) decimaltecken.',
                wrnInpVindStyrka    : 'Vindstyrka anges i hela meter per sekund',
                wrnDuplicateTime    : 'Denna tidpunkt (obs) är redan registrerad för denna dag.',
                lblSlctClouds       : 'Molnighet',
                lblSlctWindDirection: 'Vindriktning',
                lblInpVindStyrka    : 'Vindstyrka' + getNbSp(1) + '(m/s)',
                lblInpTemperatur    : 'Temperatur' + getNbSp(1) + '(°C)',
                lblInpTryck         : 'Lufttryck' + getNbSp(1) + '(hPa)',
                lblSlctComment      : 'Väderkommentar',
                lblSlctCommentPrompt: 'Välj väder kommentar',
                wrnMustBeFilledOut  : 'Måste anges',
                warningOutOfBounds  : 'Värde utanför tillåtet spann, från MIN till MAX',
                // button texts
                btnSave             : 'Spara',
                btnCancel           : 'Avbryt',
                ja                  : "Ja",
                nej                 : "Nej"
            }

        }

        $(document).attr('title', v.language.title);
        $("html").attr("lang", v.language.langAsString);
        $('#hdrMain').text(v.language.hdrMain);
        $('#loggedinText').text(v.language.loggedinText);
        $('#selectInfo').text(v.language.selectInfo);
        $('#infoLabel').text(v.language.infoLabel);

        let loggedInInfo = v.language.notLoggedinText;
        if (v.loggedInUserId !== '0'){
            loggedInInfo = '<a href="/bodmin/loggedout/" class="mg-hdrLink">' +  ' ' + v.language.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        v.controlPanel.ui.introTime.text(v.controlPanel.language.introTime);
        v.controlPanel.ui.selectedIntro.text(v.controlPanel.language.selectedIntro);
        v.controlPanel.ui.btnNew.text(v.controlPanel.language.btnNew);
        v.controlPanel.ui.btnEdit.text(v.controlPanel.language.btnEdit);
        v.controlPanel.ui.btnDelete.text(v.controlPanel.language.btnDelete);

        v.table.ui.thTime.text(v.table.language.thTime);
        v.table.ui.thVisibility.text(v.table.language.thVisibility);
        v.table.ui.thClouds.text(v.table.language.thClouds);
        v.table.ui.thWindDirection.text(v.table.language.thWindDirection);
        v.table.ui.thWindForce.text(v.table.language.thWindForce);
        v.table.ui.thTemp.text(v.table.language.thTemp);
        v.table.ui.thPressure.text(v.table.language.thPressure);
        v.table.ui.thComment.text(v.table.language.thComment);
        v.table.ui.thCreated.text(v.table.language.thCreated);

        // modal edit weather reading
        v.modalEditWeatherReading.ui.header.text(v.modalEditWeatherReading.language.header);
        // fields
        v.modalEditWeatherReading.ui.lblSlctTime.text(v.modalEditWeatherReading.language.lblSlctTime);
        v.modalEditWeatherReading.ui.lblInpVisibility.text(v.modalEditWeatherReading.language.lblInpVisibility);
        v.modalEditWeatherReading.ui.inpVisibility.attr('placeHolder', v.modalEditWeatherReading.maxMin.visibilityMin +
                                                                            v.modalEditWeatherReading.language.to +
                                                                            v.modalEditWeatherReading.maxMin.visibilityMax
                                                            );
        v.modalEditWeatherReading.ui.lblSlctClouds.text(v.modalEditWeatherReading.language.lblSlctClouds);
        v.modalEditWeatherReading.ui.lblSlctWindDirection.text(v.modalEditWeatherReading.language.lblSlctWindDirection);
        v.modalEditWeatherReading.ui.lblSlctWindDirection.text(v.modalEditWeatherReading.language.lblSlctWindDirection);
        v.modalEditWeatherReading.ui.lblInpVindStyrka.text(v.modalEditWeatherReading.language.lblInpVindStyrka);
        v.modalEditWeatherReading.ui.inpVindStyrka.attr('placeHolder', v.modalEditWeatherReading.maxMin.windForceMin +
                                                                               v.modalEditWeatherReading.language.to +
                                                                               v.modalEditWeatherReading.maxMin.windForceMax
                                                                );
        v.modalEditWeatherReading.ui.lblInpTemperatur.text(v.modalEditWeatherReading.language.lblInpTemperatur);
        v.modalEditWeatherReading.ui.inpTemperatur.attr('placeHolder', v.modalEditWeatherReading.maxMin.temperatureMin +
                                                                            v.modalEditWeatherReading.language.to +
                                                                            v.modalEditWeatherReading.maxMin.temperatureMax
                                                                );
        v.modalEditWeatherReading.ui.lblInpTryck.text(v.modalEditWeatherReading.language.lblInpTryck);
        v.modalEditWeatherReading.ui.inpTryck.attr('placeHolder', v.modalEditWeatherReading.maxMin.airPressureMin +
                                                                       v.modalEditWeatherReading.language.to +
                                                                       v.modalEditWeatherReading.maxMin.airPressureMax
                                                           );
        v.modalEditWeatherReading.ui.lblSlctComment.text(v.modalEditWeatherReading.language.lblSlctComment);
        // buttons
        v.modalEditWeatherReading.ui.btnSave.text(v.modalEditWeatherReading.language.btnSave);
        v.modalEditWeatherReading.ui.btnCancel.text(v.modalEditWeatherReading.language.btnCancel);


    }

    function setDateTexts(sLanguage){
        /*
        Set months, weekdays names and other date related texts - without visiting the server.
         */
        // E N G E L S K A
        if (sLanguage === '1') {

            v.language.dateTexts = {

                months : [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                daySuffixes : [
                    ' of',
                    'st',
                    'nd',
                    'rd',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'st',
                    'nd',
                    'rd',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'th',
                    'st',
                ],
                weekdays : [
                    'Sunday',
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday'
                ],
                weekDaysShort : [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ]

            }

        }

        // S V E N S K A
        if (sLanguage === '2') {

            v.language.dateTexts = {

                months : [
                    'januari',
                    'februari',
                    'mars',
                    'april',
                    'maj',
                    'juni',
                    'juli',
                    'augusti',
                    'september',
                    'oktober',
                    'november',
                    'december'
                ],
                daySuffixes : [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                ],
                weekdays : [
                    'söndag',
                    'måndag',
                    'tisdag',
                    'onsdag',
                    'torsdag',
                    'fredag',
                    'lördag'
                ],
                weekDaysShort : [ "sö", "må", "ti", "on", "to", "fr", "lö" ]

            }

        }

        datePickerSetup();

    }

    function isDatePresent(ymdDate, aCheckInThis){

        let returnValue = false;
        let iSizeOfArray = aCheckInThis.length;

        for ( let i=0; i<iSizeOfArray; i++ ){
            if (ymdDate === aCheckInThis[i].datum) {
                returnValue = true;
                break;
            }
        }

        return returnValue;

    }

    // https://stackoverflow.com/questions/6857025/highlight-dates-in-jquery-ui-datepicker
    // Load all weather days
    // Set up the datepicker and define its behaviour, including high-lighting of cells
    // IMPORTANT - no other datepicker creation.
    function datePickerSetup(){

        v.controlPanel.ui.theDatePicker.html(mgGetDivWithSpinnerImg());

        // get dates with data, for populating the calendar
        $.ajax({
            type: "GET",
            url:  "getWeatherDays.php",
            success: function(data) {
                v.controlPanel.wDates = JSON.parse(data);
            },

            complete: function() {

                v.controlPanel.ui.theDatePicker.empty();
                v.controlPanel.ui.theDatePicker.datepicker({
                    firstDay: 1,
                    changeMonth: true,
                    changeYear: true,
                    dayNamesMin: v.language.dateTexts.weekDaysShort,

                    beforeShowDay: function (d) {

                        let returnVal = [true, "", ""];

                        if (isDatePresent(getDateAsYMDString(d), v.controlPanel.wDates)) {
                            returnVal = [true, "highlight", ""];
                        }

                        if (v.controlPanel.ui.theDatePicker.datepicker("isDisabled")) {
                            returnVal = [true, "", v.language.calendarDisabledMessage];
                        }

                        return returnVal;
                    },

                    onSelect: function () {
                        handleDateChange();
                    }

                });

                v.controlPanel.ui.theDatePicker.datepicker(  "option", "maxDate", new Date() );
                handleDateChange();
                v.controlPanel.ui.theDatePicker.datepicker( "refresh" );

            }
        });

    }

    function handleDateChange(){

        v.selectedDate.ymd = v.controlPanel.ui.theDatePicker.datepicker("option", "dateFormat", "yy-mm-dd" ).val();
        v.selectedDate.asDate = v.controlPanel.ui.theDatePicker.datepicker("getDate");
        v.selectedDate.humanReadable = getFormattedDate(v.selectedDate.ymd, v).trim();

        // inform the user about current selections, left hand side below calendar
        v.controlPanel.ui.selectedIntro.text(v.controlPanel.language.selectIntro);
        v.controlPanel.ui.selectedDateInfo.text(v.selectedDate.humanReadable);

        // wipe out info about selected time
        v.controlPanel.ui.introTime.text('');
        v.controlPanel.ui.selectedTime.text('');
        v.controlPanel.ui.suffixTime.text('');

        v.controlPanel.ui.theDatePicker.datepicker( "refresh" );
        v.mainTableId = '0';
        setEditButtonsOff();

        // We may have data since before
        buildWeatherTable();

    }

    function setEditButtonsOff(){

        v.controlPanel.ui.btnEdit.prop('disabled', true);
        v.controlPanel.ui.btnDelete.prop('disabled', true);

        if (v.mainTableId !== '0') {
            v.controlPanel.ui.btnEdit.prop('disabled', false);
            v.controlPanel.ui.btnDelete.prop('disabled', false);
        }


        /*
        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type:"get",
            async: false,
            url: "../users/getUserModulePermission.php?userId=" + $('#loggedInUserId').text() + "&moduleId=9",
            success: function(data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {
                    v.cntrlPanel.ui.btnEdit.hide();
                    v.cntrlPanel.ui.btnTranslations.hide();
                    v.cntrlPanel.ui.btnDelete.hide();
                    v.cntrlPanel.ui.btnNew.hide();

                    $('#editButtons').html('<br/><small>' + v.language.noPermission + '.<small>');
                    $('#info').text('');

                }

            }
        });

         */

    }

    function buildWeatherTable(){

        // empty existing data table (if any)
        $("#weatherTableBody").empty();

        if (v.selectedDate.asDate !== 0 ){

            let newRowHTML = "<tr id='spinner'><td colspan='11'>" + mgGetDivWithSpinnerImg() + "</td></tr>";
            v.table.ui.weatherTableBody.append(newRowHTML);

            $.ajax({
                type:"GET",
                async: true,
                url: "getWeatherForDay.php?ymdDate=" + v.selectedDate.ymd,
                success: function(data) {

                    v.weatherReadings = JSON.parse(data);

                    $('#spinner').remove();
                    v.weatherReadings.forEach(function(weatherReading){

                        let row = '<tr id="' + weatherReading.id + '">';
                        row = row + '<td>' + weatherReading.TIME + '</td>';

                        row = row + '<td class="text-center">' + weatherReading.CLOUDS + '</td>';
                        row = row + '<td class="text-center">' + weatherReading.WIND + '</td>';
                        row = row + '<td class="text-end">' + weatherReading.vsty + getNbSp(2) + '</td>';
                        row = row + '<td class="text-end">' + formatTemperature(weatherReading.TEMP, v) + getNbSp(2) + '</td>';
                        row = row + '<td class="text-end">' + formatSikt(weatherReading.SIKT, v) + getNbSp(2) + '</td>';
                        row = row + '<td class="text-end">' + formatNo(weatherReading.TRYCK, v, 1) + getNbSp(2) + '</td>';
                        row = row + '<td>' + '</td>';
                        row = row + '<td>' + weatherReading.CREATED_AT + '</td>';
                        v.table.ui.weatherTableBody.append(row);
                    });


                    $.ajax({
                        type:"GET",
                        async: true,
                        url: "getWeatherObservationKeywordsForDate.php?ymdDate=" + v.selectedDate.ymd + '&lang=' + v.language.current,
                        success: function(data) {

                            // get all keywords for this day - a limited number we have only a few weather recordings
                            let weatherKeywords = JSON.parse(data);
                            let rows = v.table.ui.weatherTableBody.find('tr');

                            // for each weather observation (row in the table)
                            rows.each(function(){

                                let currentRow = $(this);
                                let id = currentRow.attr('id');

                                // filter out the relevant keywords for this observation id
                                let thisObservationKeywords = $.grep(weatherKeywords, function (element) {
                                    return parseInt(element.DAGB_VADER_ID) === parseInt(id);
                                });

                                // Make a comma separated list...
                                let s = '';
                                thisObservationKeywords.forEach((element) => { s += ', ' + element.TEXT });
                                s = s.substring(2);

                                // ...and load it in the right column
                                currentRow.find("td").eq(7).text(s);

                            });

                        }

                    });

                }

            });

        }
    }


    // select row in the table
    $(document).on("click", "#data tbody tr", function(){

        // S E L E C T
        v.selectedRow = $(this);
        v.controlPanel.ui.introTime.text(v.controlPanel.language.introTime);
        v.controlPanel.ui.selectedTime.text( v.selectedRow.find("td").eq(0).text() );
        v.controlPanel.ui.suffixTime.text( v.controlPanel.language.suffixTime );


        v.mainTableId = v.selectedRow.attr('ID');
        v.selectedRow.siblings().removeClass('table-active');
        v.selectedRow.addClass('table-active');

        setEditButtonsOff();


    });

    function populateModalDropDowns() {

        // weather types/comments
        $.ajax({
            type: "get",
            url: "getWeatherTypes.php?lang_id=" + v.language.current,
            success: function (data) {
                v.modalEditWeatherReading.weatherTypes = JSON.parse(data);
            }
        });

        // väder observationer
        $.ajax({
            type: "GET",
            url: "getWeatherTimes.php",
            success: function (data) {
                v.modalEditWeatherReading.observationTimes = JSON.parse(data);
            }
        });

        // wind directions
        $.ajax({
            type: "GET",
            url: "getWeatherWindDirections.php",
            success: function (data) {

                let w = JSON.parse(data);
                for (let i = 0; i < w.length; i++) {
                    v.modalEditWeatherReading.ui.slctWindDirection.append($("<option></option>").attr("value", w[i].ID).text(w[i].TEXT));
                }

            }
        });

        // clouds
        $.ajax({
            type: "GET",
            url: "getWeatherClouds.php",
            success: function (data) {

                let c = JSON.parse(data);
                for (let i = 0; i < c.length; i++) {
                    v.modalEditWeatherReading.ui.slctClouds.append($("<option></option>").attr("value", c[i].ID).text(c[i].TEXT));
                }

            }
        });
    }

    function populateKeywordDropDown(v){


        v.modalEditWeatherReading.ui.slctComment.empty();

        let thisOption = '<option value="" disabled selected hidden>' + v.modalEditWeatherReading.language.lblSlctCommentPrompt + '</option>';
        v.modalEditWeatherReading.ui.slctComment.append(thisOption);

        let l = v.modalEditWeatherReading.weatherTypes.length;
        for (let i = 0; i < l; i++) {
            v.modalEditWeatherReading.ui.slctComment.append($("<option></option>").attr("value", v.modalEditWeatherReading.weatherTypes[i].ID).text(v.modalEditWeatherReading.weatherTypes[i].TEXT));
        }


    }

    v.modalEditWeatherReading.ui.btnSave.click(function(){

        let ok = true;

        // Clear all potential error messages
        v.modalEditWeatherReading.ui.warningTextsAll.text('');

        if (( v.modalEditWeatherReading.action === "add") || ( v.modalEditWeatherReading.action === "edit") ) { // excluding delete

            // validate fields
            // V I N D S T Y R K A
            let value = v.modalEditWeatherReading.ui.inpVindStyrka.val();
            let placeHolderWithMinAndMax = v.modalEditWeatherReading.ui.inpVindStyrka.attr('placeHolder');
            v.modalEditWeatherReading.ui.inpVindStyrka.toggleClass('inputWarning', false);

            if (value.length === 0){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVindStyrka.text(v.modalEditWeatherReading.language.wrnMustBeFilledOut);
            }

            if ((ok) && (!checkIfStringIsDecimalNumber(value, v.language.decSign))){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVindStyrka.text(v.modalEditWeatherReading.language.wrnInpIncorrectDecimalNumber);
            }

            if ((ok) && (! mgValidateMin(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpVindStyrka.text(tunedText);
            }

            if ((ok) && (! mgValidateMax(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpVindStyrka.text(tunedText);
            }

            if ((ok) && (value.length > 2 )){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVindStyrka.text(v.modalEditWeatherReading.language.wrnInpVindStyrka);
            }

            if (!ok){
                v.modalEditWeatherReading.ui.inpVindStyrka.toggleClass('inputWarning', true);
            }


            // T E M P E R A T U R
            value = v.modalEditWeatherReading.ui.inpTemperatur.val();

            placeHolderWithMinAndMax = v.modalEditWeatherReading.ui.inpTemperatur.attr('placeHolder');
            v.modalEditWeatherReading.ui.inpTemperatur.toggleClass('inputWarning', false);

            if (value.length === 0){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTemperatur.text(v.modalEditWeatherReading.language.wrnMustBeFilledOut);
                v.modalEditWeatherReading.ui.inpTemperatur.toggleClass('inputWarning', true);
            }

            if ((ok) && (!checkIfStringIsDecimalNumber(value, v.language.decSign))){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTemperatur.text(v.modalEditWeatherReading.language.wrnInpIncorrectDecimalNumber);
            }

            if ((ok) && (! mgValidateMin(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpTemperatur.text(tunedText);
            }

            if ((ok) && (! mgValidateMax(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpTemperatur.text(tunedText);
            }


            if ((ok) && (value.length > 5 )){  // -12,4
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTemperatur.text(v.modalEditWeatherReading.language.wrnInpTempLength);
            }

            if (!ok){
                v.modalEditWeatherReading.ui.inpTemperatur.toggleClass('inputWarning', true);
            }


            // S I K T
            v.modalEditWeatherReading.ui.inpVisibility.toggleClass('inputWarning', false);

            let sikt = v.modalEditWeatherReading.ui.inpVisibility.val();
            let siktAsFloat = parseFloat(sikt.replace(',', '.') );

            placeHolderWithMinAndMax = v.modalEditWeatherReading.ui.inpVisibility.attr('placeHolder');

            if (sikt.length === 0){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVisibility.text(v.modalEditWeatherReading.language.wrnMustBeFilledOut);
            }

            if ((ok) && (!checkIfStringIsDecimalNumber(sikt, v.language.decSign))){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVisibility.text(v.modalEditWeatherReading.language.wrnInpIncorrectVisibility);
            }

            if ((ok) && (! mgValidateMin(sikt, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpVisibility.text(tunedText);
            }

            if ((ok) && (! mgValidateMax(sikt, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpVisibility.text(tunedText);
            }

            // if visibility smaller than 5, also decimals are allowed.

            let dec = siktAsFloat % 1;

            if ((siktAsFloat >= 5) && (dec > 0)){  // 0,12
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVisibility.text(v.modalEditWeatherReading.language.wrnInpVisibilityLength);
            }

            if ((ok) && (sikt.length > 3 )){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpVisibility.text(v.modalEditWeatherReading.language.wrnInpVisibilityLength);
            }

            if (!ok){
                v.modalEditWeatherReading.ui.inpVisibility.toggleClass('inputWarning', true);
            }


            // T R Y C K
            value = v.modalEditWeatherReading.ui.inpTryck.val();
            placeHolderWithMinAndMax = v.modalEditWeatherReading.ui.inpTryck.attr('placeHolder');
            v.modalEditWeatherReading.ui.inpTryck.toggleClass('inputWarning', false);

            if (value.length === 0){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTryck.text(v.modalEditWeatherReading.language.wrnMustBeFilledOut);
            }

            if ((ok) && (!checkIfStringIsDecimalNumber(value, v.language.decSign))){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTryck.text(v.modalEditWeatherReading.language.wrnInpIncorrectDecimalNumber);
            }

            if ((ok) && (value.length > 6 )){
                ok = false;
                v.modalEditWeatherReading.ui.warningInpTryck.text(v.modalEditWeatherReading.language.wrnInpTryckLength);
            }

            if ((ok) && (! mgValidateMin(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpTryck.text(tunedText);
            }

            if ((ok) && (! mgValidateMax(value, placeHolderWithMinAndMax) )){
                ok = false;
                let rawText = v.modalEditWeatherReading.language.warningOutOfBounds;
                let min = mgGetMin(placeHolderWithMinAndMax);
                let tunedText = rawText.replace('MIN', min );
                let max = mgGetMax(placeHolderWithMinAndMax);
                tunedText = tunedText.replace('MAX', max );
                v.modalEditWeatherReading.ui.warningInpTryck.text(tunedText);
            }


            if (!ok){
                v.modalEditWeatherReading.ui.inpTryck.toggleClass('inputWarning', true);
            }


            if (ok) {

                // check unique time
                let aTimes = [];
                let rows = v.table.ui.weatherTableBody.find('tr');
                // for each weather observation (row in the table)
                rows.each(function(){

                    // build array of times already in the table, except the one being edited
                    let currentRow = $(this);
                    let id = currentRow.attr('id');

                    if (id !== v.mainTableId){
                        aTimes.push(currentRow.find("td").eq(0).text());
                    }

                    if (aTimes.includes( $("#slctTime :selected").text() )) {
                        ok = false;
                        v.modalEditWeatherReading.ui.wrnSelectTime.text(v.modalEditWeatherReading.language.wrnDuplicateTime);
                    }


                });

            }

        }


        if (ok){

            let formData = new FormData();
            formData.append('mode', v.modalEditWeatherReading.action);

            if ((v.modalEditWeatherReading.action === "edit") || (v.modalEditWeatherReading.action === "delete")) {
                formData.append('id', v.mainTableId);
            }

            if ((v.modalEditWeatherReading.action === "add") || (v.modalEditWeatherReading.action === "edit")) {

                formData.append('date', v.selectedDate.ymd);
                formData.append('time', v.modalEditWeatherReading.ui.slctTime.val());
                formData.append('visibility', mgGetProperDecimalSignString(v.modalEditWeatherReading.ui.inpVisibility.val()));
                formData.append('clouds', v.modalEditWeatherReading.ui.slctClouds.val());
                formData.append('windDirection', v.modalEditWeatherReading.ui.slctWindDirection.val());
                formData.append('windForce', mgGetProperDecimalSignString(v.modalEditWeatherReading.ui.inpVindStyrka.val()));
                formData.append('temperature', mgGetProperDecimalSignString(v.modalEditWeatherReading.ui.inpTemperatur.val()));
                formData.append('pressure', mgGetProperDecimalSignString(v.modalEditWeatherReading.ui.inpTryck.val()));
                formData.append('weatherTypeIds', getListOfSelectedKeywords());
                formData.append('user', getLoggedInUserId());

            }

            $.ajax({
                url: "handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (/* data, textStatus, jqXHR */) {
                    handleDateChange();
                }
            });

            v.modalEditWeatherReading.ui.window.modal('hide');
            v.mainTableId = '0';

        }

    });

    $('.closeModal').on('click', function(){
        v.modalEditWeatherReading.ui.window.modal('hide');
    })

    v.modalEditWeatherReading.ui.slctComment.change(function() {

        let selected = $("#slctComment option:selected" );
        if (selected.val() !== '-1'){
            if (!getListOfSelectedKeywords().includes(selected.val())){
                $('#selectedKeywords').append('<li class="mgLiInline" id="' + selected.val() + '">'  + selected.text() + mgNbSp() + '<button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
            }
        }

    });

    function getListOfSelectedKeywords(){

        let keywordIds = [];

        $('#selectedKeywords li').each(function( /* index*/ ) {
            keywordIds.push($( this ).attr('id'));
        });

        return keywordIds.toString();

    }

    v.modalEditWeatherReading.ui.selectedKeywords.on('click', '.itemSelected', function(){
        $( this ).parent().remove();
    });


    // ----------------------------------------------------------------------main table maintenance------------------
    v.controlPanel.ui.btnNew.click( function(){

        v.modalEditWeatherReading.ui.header.text(v.modalEditWeatherReading.language.headerNew + ' ' + v.controlPanel.ui.selectedDateInfo.text());

        v.modalEditWeatherReading.action = "add";

        let l = v.weatherReadings.length;

        // Only not yet added times are selectable
        // Filter out not yet added times
        let timesYetToAdd = $.grep(v.modalEditWeatherReading.observationTimes, function (element) {

            // Test if this is already entered
            let answer = true;
            // For each already entered weather reading times, check if this time is one of them
            for (let i = 0; i < l; i++){

                let value = v.weatherReadings[i];

                if (parseInt(element.ID) === parseInt(value.TIME_ID)){
                    answer = false;
                    break;
                }

            }

            return answer;
        });


        v.modalEditWeatherReading.ui.slctTime.empty();
        for (let i = 0; i < timesYetToAdd.length; i++) {
            v.modalEditWeatherReading.ui.slctTime.append($("<option></option>").attr("value", timesYetToAdd[i].ID).text(timesYetToAdd[i].TEXT));
        }


        // set button texts
        v.modalEditWeatherReading.ui.btnCancel.text(v.modalEditWeatherReading.language.btnCancel);
        v.modalEditWeatherReading.ui.btnSave.text(v.modalEditWeatherReading.language.btnSave);

        // clear all potential error messages
        v.modalEditWeatherReading.ui.warningTextsAll.text('');

        // empty fields
        v.modalEditWeatherReading.ui.inpVisibility.val('');
        v.modalEditWeatherReading.ui.inpTryck.val('');
        v.modalEditWeatherReading.ui.inpTemperatur.val('');
        v.modalEditWeatherReading.ui.inpVindStyrka.val('');
        v.modalEditWeatherReading.ui.selectedKeywords.val('-1');

        v.modalEditWeatherReading.ui.slctTime.addClass("focusedInput");
        v.modalEditWeatherReading.ui.slctTime.focus();

        v.modalEditWeatherReading.ui.selectedKeywords.empty();
        populateKeywordDropDown(v)

        // hide delete section and show edit
        v.modalEditWeatherReading.ui.sectionDelete.toggleClass('mg-hide-element', true);
        v.modalEditWeatherReading.ui.sectionEdit.toggleClass('mg-hide-element', false);

        v.modalEditWeatherReading.ui.window.modal('show');

    });

    v.controlPanel.ui.btnEdit.click( function(){

        // clear all potential previous error messages
        v.modalEditWeatherReading.ui.warningTextsAll.text('');

        let timesToAdd = v.modalEditWeatherReading.observationTimes;


        v.modalEditWeatherReading.ui.slctTime.empty();
        let l = timesToAdd.length;
        for (let i = 0; i < l; i++) {
            v.modalEditWeatherReading.ui.slctTime.append($("<option></option>").attr("value", timesToAdd[i].ID).text(timesToAdd[i].TEXT));
        }

        // empty selected keywords
        v.modalEditWeatherReading.ui.selectedKeywords.empty();

        // hide delete section and show wait section until data is loaded
        v.modalEditWeatherReading.ui.sectionDelete.toggleClass('mg-hide-element', true);
        v.modalEditWeatherReading.ui.modalWaitSection.html(mgGetDivWithSpinnerImg());
        v.modalEditWeatherReading.ui.modalWaitSection.toggleClass('mg-hide-element', false);

        $.ajax({
            type:"GET",
            url: "getWeatherObservationViaId.php?id=" + v.mainTableId,
            success: function(data) {

                v.modalEditWeatherReading.ui.header.text(v.modalEditWeatherReading.language.headerEdit + ' ' + v.controlPanel.ui.selectedDateInfo.text());

                v.modalEditWeatherReading.action = "edit";

                v.modalEditWeatherReading.ui.btnCancel.text(v.modalEditWeatherReading.language.btnCancel);
                v.modalEditWeatherReading.ui.btnSave.text(v.modalEditWeatherReading.language.btnSave);

                let obj = JSON.parse(data);
                let editData = obj[0];

                //populate edit form with gotten data
                v.modalEditWeatherReading.ui.slctTime.val(editData.TIME_ID);
                v.modalEditWeatherReading.ui.slctClouds.val(editData.MOLN_ID);
                v.modalEditWeatherReading.ui.slctWindDirection.val(editData.VIRIKT_ID);
                v.modalEditWeatherReading.ui.inpVindStyrka.val(editData.vsty);
                v.modalEditWeatherReading.ui.inpTemperatur.val(mgPolishNumberString(editData.TEMP, v));
                let siktAsFloat = parseFloat(editData.SIKT.replace(',', '.') );
                if (siktAsFloat < 5){
                    siktAsFloat = Math.round(siktAsFloat * 10)/10;
                }
                let siktAsString = siktAsFloat.toLocaleString(v.language.locale);
                v.modalEditWeatherReading.ui.inpVisibility.val(siktAsString);
                v.modalEditWeatherReading.ui.inpTryck.val(mgPolishNumberString(editData.TRYCK, v));

                v.modalEditWeatherReading.ui.modalWaitSection.toggleClass('mg-hide-element', true);
                v.modalEditWeatherReading.ui.sectionEdit.toggleClass('mg-hide-element', false);
                populateKeywordDropDown(v)


                // get selected keywords
                $.ajax({
                    type:"GET",
                    url: "getWeatherObservationKeywords.php?id=" + v.mainTableId + "&lang=" + v.language.current,
                    success: function(data) {

                        let keywords = JSON.parse(data);
                        $.each(keywords, function(index, value) {
                            $('#selectedKeywords').append('<li class="mgLiInline" id="' + value.KEYWORD_ID + '">' + value.TEXT + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
                        });

                        v.modalEditWeatherReading.ui.window.modal('show');

                    }
                });

            }
        });


    });

    // reset fields on entry
    v.modalEditWeatherReading.ui.inpVindStyrka.on('focus', function() {
        v.modalEditWeatherReading.ui.warningInpVindStyrka.text('');
        v.modalEditWeatherReading.ui.inpVindStyrka.toggleClass('inputWarning', false);
    });

    v.modalEditWeatherReading.ui.inpTemperatur.on('focus', function() {
        v.modalEditWeatherReading.ui.warningInpTemperatur.text('');
        v.modalEditWeatherReading.ui.inpTemperatur.toggleClass('inputWarning', false);
    });

    v.modalEditWeatherReading.ui.inpVisibility.on('focus', function() {
        v.modalEditWeatherReading.ui.warningInpVisibility.text('');
        v.modalEditWeatherReading.ui.inpVisibility.toggleClass('inputWarning', false);
    });

    v.modalEditWeatherReading.ui.inpTryck.on('focus', function() {
        v.modalEditWeatherReading.ui.warningInpTryck.text('');
        v.modalEditWeatherReading.ui.inpTryck.toggleClass('inputWarning', false);
    });

    v.controlPanel.ui.btnDelete.click( function(){

        v.modalEditWeatherReading.ui.header.text(v.modalEditWeatherReading.language.headerDelete);

        v.modalEditWeatherReading.action = "delete";

        v.modalEditWeatherReading.ui.btnSave.text(v.modalEditWeatherReading.language.ja);
        v.modalEditWeatherReading.ui.btnCancel.text(v.modalEditWeatherReading.language.nej);

        v.modalEditWeatherReading.ui.sectionDelete.toggleClass('mg-hide-element', false);
        v.modalEditWeatherReading.ui.sectionEdit.toggleClass('mg-hide-element', true);

        let deleteInfo = v.controlPanel.ui.selectedDateInfo.text() +
            v.controlPanel.ui.introTime.text() +
            v.controlPanel.ui.selectedTime.text() +
            v.controlPanel.ui.suffixTime.text();

        // populate delete section
        v.modalEditWeatherReading.ui.sectionDelete.html('<h6>' + deleteInfo + '</h6>');

        v.modalEditWeatherReading.ui.window.modal('show');

    });

    setLangTexts();
    setDateTexts(v.language.current);
    populateModalDropDowns();

    showHelpIfItExists(v);

});
