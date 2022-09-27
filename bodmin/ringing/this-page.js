
$(document).ready(function(){

    let bodmin = {
        
        lang : {
            current : $('#systemLanguageId').text(),
            editing : '0'
        },

        loggedInUserId : $('#loggedInUserId').text(),
        selectedDate : {
            ymd : '',
            asDate : ''
        },
        location : 0,

        currentTaxa : {
            id : "0",
            decigrams : "0"
        },
        tabs : $('#tabs-min'),
        dataTabs : $("#dataTabs"),
        controlPanel : {

            ui : {
                theDatePicker : $('#datepicker'),
                ddLocation : $('#ddLocations'),
                btnEdit :  $('#btnEdit'),
                btnFinish :  $('#btnFinish'),
                btnRingCheck :  $('#btnRingCheck'),
                btnEffort :  $('#btnEffort'),
                selectedIntro : $('#selectedIntro'),
                selectedLocationInfo : $('#selLocation'),
                selectedDateInfo : $('#selDate'),
                selectedStatusHeader : $('#selectStatusHeader'),
                selectedStatusBody : $('#selectStatusBody')
            },
            lang : {},
            ringingDates : {},
            currentRingingDateLocation : 0,

        },

        dataSection : {
            ringedBirds     : [],
            spinnerArea     : $('#spinner-area'),
            workingArea     : $('#working-area'),
            ui : {
                btnMoveOn                 : $('#btnMoveOn'),
                dataEntrySection          : $('#dataEntrySection'),
                dataEntrySectionHeader    : $('#dataEntrySectionHeader'),

                // data entry tabs
                tabOneByOne        : $('#labelDataTabOneByOne'),
                tabBatches         : $('#labelDataTabBatches'),
                tabReTraps         : $('#labelDataTabReTraps'),

                baseRow                   : $('#baseRow'),
                speciesDataEntryTableBody : $('#speciesDataEntryTableBody'),

                secondRow                 : $('#secondRow'),

                // fields
                inpHour             : $('#inpHour'),
                lblInpHour          : $('#lblInpHour'),
                dataListHours       : $('#dataListHours'),
                warningInpHour      : $('#warning-inpHour'),
                thHour              : $('#thHour'),

                inpSystematic         : $('#cbSystematic'),
                lblCheckBoxSystematic : $('#lblCheckBoxSystematic'),
                // nothing to validate, so no warning texts

                ddTrappingMethod    : $('#ddTrappingMethod'),
                lblTrappingMethod   : $('#lblTrappingMethod'),
                // no warning element
                // Not shown in "result" table no header needed.

                inpObservation      : $('#inpObservation'),
                lblOther            : $('#lblOther'),
                // free text no warning needed
                // not shown in result table

                inpTaxa             : $('#inpSpecies'),
                lblInpTaxa          : $('#lblInpTaxa'),
                warningInpTaxa      : $('#warning-inpSpecies'),
                thTaxa              : $('#thTaxa'),
                dataListTaxa        : $('#dataListTaxa'),

                inpRing             : $('#inpRing'),
                lblRing             : $('#lblRing'),
                warningInpRing      : $('#warning-inpRing'),
                thRingNo            : $('#thRingNo'),
                ringSection         : $('#ringSection'),

                inpAge              : $('#inpAge'),
                lblInpAge           : $('#lblInpAge'),
                warningInpAge       : $('#warning-inpAge'),
                thAge               : $('#thAge'),

                inpSex              : $('#ddSex'),
                lblInpSex           : $('#lblInpSex'),
                // drop-down always a value
                thSex               : $('#thSex'),

                thWing              : $('#thWing'),
                thFat               : $('#thFat'),
                thWeight            : $('#thWeight'),
                thMoultPull         : $('#thPullMoult'),
                thMoultSecondaries  : $('#thSecondariesMoult'),
                thMoultPrimaries    : $('#thPrimariesMoult'),

                // additional measurements
                ddMoreMeasurements       : $('#dd-more-measurements'),
                oneByOneForm             : $('#one-by-one-form'),
                moreMeasurementsBaseRow  : $('#additional-measurement-row'),
                moreMeasurementsSection  : $("#extra-measurements"),

                hdrEnteredData           : $('#hdrEnteredData'),
                // tabs for data info
                tabDataFullList          : $('#tabDataFullList'),
                tabDataSummaryHour       : $('#tabDataSummaryHour'),
                tabDataSummaryAgeSpecies : $('#tabDataSummaryAgeSpecies'),
                tabDataComparisons       : $('#tabDataComparisons'),
                editControls             : $('#editControls'),
                btnRingingRecordSave     : $('#btnRingingRecordSave'),
                btnRingingRecordCancel   : $('#btnRingingRecordCancel')

            }
        },

        modalRings : {
            ui : {
                window                  : $('#modalEditRings'),
                modalRingTypesAvert     : $('#modal-ring-types-avert'),
                modalRingTypesBody      : $('#modal-ring-types-body'),
                header                  : $('#modalRingsHeader'),
                ddRingType              : $('#slct-rings-1'),
                btnAdd                  : $('#btnRingAdd'),
                btnSave                 : $('#btnRingSave'),
                btnCancel               : $('#btnRingCancel'),
                ringsRows               : $('#ring-types-rows'),
                lblModalRingType1       : $('#lblModalRingType-1'),
                lblModalRingNo1         : $('#lblModalRingNo-1'),
                divNotUnique            : $('#div-not-unique'),
                notUniqueText           : $('#rings-not-unique')
            }
        },

        modalPromptRingCheck : {
            ui : {
                window                          : $('#modalPromptRingCheck'),
                modalPromptRingCheckHeader      : $('#modalPromptRingCheckHeader'),
                modalPromptRingCheckMessage     : $('#modalPromptRingCheckMessage'),
                btnModalPromptRingCheckClose    : $('#btnModalPromptRingCheckClose')

            }
        },

        modalDayDone : {
            ui : {
                window                  : $('#modalDayDone'),
                modalDayDoneHeader      : $('#modalDayDoneHeader'),
                modalDayDoneMessage     : $('#modalDayDoneMessage'),
                btnModalDayDoneYes      : $('#btnModalDayDoneYes'),
                btnModalDayDoneNo       : $('#btnModalDayDoneNo')

            }
        }

    };

    function RingingRecord(){

        let age = "0";
        let changed_at = Date.now;
        let changed_by = getLoggedInUserId();
        let created_by = getLoggedInUserId();
        let created_at = Date.now();
        let hour = "-";
        let id = 0;
        let obs = "";

        let ringing_dates_locations_id = 0;
        let ringNo = "";
        let sex = "";
        let shortname = "";
        let systematic = '1';
        let taxa_id = 0;
        let trapping_method_id = "0";

        let measurements = [];
        let standardMeasurementsData = [];

        this.getMeasurements = function(){
            return measurements;
        }

        this.addMeasurement = function(dataToSet){
            measurements.push(dataToSet);
        }

        this.getStandardMeasurementsData = function(){
            return standardMeasurementsData;
        }

        this.addStandardMeasurementsData = function(dataToSet){
            standardMeasurementsData.push(dataToSet);
        }

        this.setCreated_at = function(theCreated_at){
            created_at = theCreated_at;
        }

        this.setCreated_by = function(theCreated_by){
            created_by = theCreated_by;
        }

        this.setChanged_by = function(theChanged_by){
            changed_by = theChanged_by;
        }

        this.setChanged_at = function(theChanged_at){
            changed_at = theChanged_at;
        }

        this.getChanged_at = function(){
            return changed_at;
        }

        this.setTrapping_method_id = function(theTrapping_method_id){
            trapping_method_id = theTrapping_method_id;
        }

        this.getTrapping_method_id = function(){
            return trapping_method_id;
        }

        this.setTaxa_Id = function(theTaxa_Id){
            taxa_id = theTaxa_Id;
        }

        this.getTaxa_Id = function(){
            return taxa_id;
        }

        this.setSystematic = function(theSystematic){
            systematic = theSystematic;
        }

        this.getSystematic = function(){
            return systematic;
        }

        this.setShortname = function(theShortname){
            shortname = theShortname;
        }

        this.getShortname = function(){
            return shortname;
        }

        this.getAge = function(){
            return age;
        }

        this.setAge = function(theAge){
            age = theAge;
        }

        this.getHour = function(){
            return hour;
        }

        this.setHour = function(theHour){
            hour = theHour;
        }

        this.getId = function(){
            return id;
        }

        this.setId = function(theId){
            id = theId;
        }

        this.getObs = function(){
            return obs;
        }

        this.setObs = function(theObs){
            obs = theObs;
        }

        this.setRinging_dates_locations_id = function(theRinging_dates_locations_id){
            ringing_dates_locations_id = theRinging_dates_locations_id;
        }

        this.getRinging_dates_locations_id = function(){
            return ringing_dates_locations_id;
        }

        this.setRingNo = function(theRingNo){
            ringNo = theRingNo;
        }

        this.getRingNo = function(){
            return ringNo;
        }

        this.setSex = function(theSex){
            sex = theSex;
        }

        this.getSex = function(){
            return sex;
        }

    }

    function Measurement(){

        let ringingDataId = '0';
        let measurementId = '0';
        let value = '0';
        let text = "";

        this.setRingingDataId = function(dataToSet){
            ringingDataId = dataToSet;
        }

        this.getMeasurementId = function(){
            return measurementId;
        }

        this.setMeasurementId = function(dataToSet){
            measurementId = dataToSet;
        }

        this.getValue = function(){
            return value;
        }

        this.setValue = function(dataToSet){
            value = dataToSet;
        }

        this.getMeasurementText = function(){
            return text;
        }

        this.setText = function(dataToSet){
            text = dataToSet;
        }

    }

    function isDatePresent(ymdDate, location, aCheckInThis){

        let returnValue = false;
        let iSizeOfArray = aCheckInThis.length;

        for (let i=0; i<iSizeOfArray; i++){

            if ((ymdDate === aCheckInThis[i].THEDATE) && ( location === aCheckInThis[i].LOCALITY_ID )) {
                returnValue = true;
                break;
            }
        }

        return returnValue;

    }

    // https://stackoverflow.com/questions/6857025/highlight-dates-in-jquery-ui-datepicker
    // Load all ringing days
    // Set up the datepicker and define its behaviour, including high-lighting of cells
    function datePickerSetup(){

        bodmin.controlPanel.ui.theDatePicker.html(mgGetDivWithSpinnerImg());
        // get dates with ringing entries, for populating the calender
        $.ajax({
            type:"GET",
            async: true,
            url: "getRingingDays.php",
            success: function(data) {
                bodmin.controlPanel.ringingDates = JSON.parse(data);
            },

            complete: function() {
                bodmin.controlPanel.ui.theDatePicker.empty();
                bodmin.controlPanel.ui.theDatePicker.datepicker({
                    firstDay: 1,
                    changeMonth: true,
                    changeYear: true,
                    dayNamesMin: bodmin.lang.dateTexts.weekDaysShort,

                    beforeShowDay: function (d) {

                        let returnVal = [true, "", ""];

                        if (isDatePresent(getDateAsYMDString(d), bodmin.location, bodmin.controlPanel.ringingDates)) {
                            returnVal = [true, "highlight", ""];
                        }

                        if (bodmin.controlPanel.ui.theDatePicker.datepicker("isDisabled")) {
                            returnVal = [true, "", bodmin.lang.calendarDisabledMessage];
                        }

                        return returnVal;
                    },

                    onSelect: function () {
                        handleDateOrLocationChange('When selecting date');
                    }

                });

                bodmin.controlPanel.ui.theDatePicker.datepicker(  "option", "maxDate", new Date() );
                handleDateOrLocationChange('When setting up date picker');
                bodmin.controlPanel.ui.theDatePicker.datepicker( "refresh" );
            }
        });

    }

    bodmin.controlPanel.ui.ddLocation.change(function(){
        handleDateOrLocationChange('Location change');
    });

    bodmin.controlPanel.ui.btnFinish.click(function(){
        bodmin.modalDayDone.ui.window.modal('show');
    });

    bodmin.modalDayDone.ui.btnModalDayDoneYes.click(function(){

        bodmin.modalDayDone.ui.window.modal('hide');

        bodmin.dataSection.ui.dataEntrySection.toggleClass('mg-hide-element', true);
        bodmin.controlPanel.ui.btnFinish.prop('disabled', true);
        bodmin.controlPanel.ui.btnEdit.prop('disabled', false);

        bodmin.controlPanel.ui.theDatePicker.datepicker( "option" , {
            changeMonth: true,
            changeYear: true,
            stepMonths: 1,
            stepYear : 1
        } );

        bodmin.controlPanel.ui.theDatePicker.attr('title', bodmin.controlPanel.lang.calendarDisabledMessage);
        bodmin.controlPanel.ui.theDatePicker.datepicker( "option", "disabled", false );

        bodmin.controlPanel.ui.ddLocation.prop('disabled', false);
        bodmin.controlPanel.ui.ddLocation.attr('title', bodmin.controlPanel.lang.locationDropDownDisabledMessage);

        //update the status
        bodmin.controlPanel.currentRingingDateLocationStatus = '2';
        updateDateLocationStatus(mode, 'done');
        handleDateOrLocationChange('Simulating location change after editing');

    });

    bodmin.modalDayDone.ui.btnModalDayDoneNo.click(function(){
       bodmin.modalDayDone.ui.window.modal('hide');
    });

    bodmin.modalPromptRingCheck.ui.btnModalPromptRingCheckClose.click(function(){
        bodmin.modalPromptRingCheck.ui.window.modal('hide');
    });

    function handleDateOrLocationChange(where){

        console.log(where);

        // Selected date
        bodmin.selectedDate.ymd = bodmin.controlPanel.ui.theDatePicker.datepicker("option", "dateFormat", "yy-mm-dd" ).val();
        bodmin.selectedDate.asDate = bodmin.controlPanel.ui.theDatePicker.datepicker("getDate");
        bodmin.selectedDate.humanReadable = getFormattedDate(bodmin.selectedDate.ymd, bodmin);

        // Selected location - is it changed?
        if ( bodmin.location !== bodmin.controlPanel.ui.ddLocation.val() ){
            bodmin.location = bodmin.controlPanel.ui.ddLocation.val();
            bodmin.ringsUsed = [];
        }

        bodmin.name = $( "#ddLocations option:selected" ).text();
        bodmin.locationText = bodmin.name + ', ';

        bodmin.controlPanel.ui.selectedIntro.text(bodmin.controlPanel.lang.selectIntro);

        bodmin.controlPanel.currentRingingDateLocation = '0';
        bodmin.controlPanel.currentRingingDateLocationStatus = '0';
        loadCurrentDatePlaceIDIfAny();

        // inform the user about current selections, left hand side below calendar
        bodmin.controlPanel.ui.selectedDateInfo.html(bodmin.selectedDate.humanReadable);
        bodmin.controlPanel.ui.selectedLocationInfo.html(bodmin.locationText);
        if (bodmin.controlPanel.currentRingingDateLocationStatus > 0){
            bodmin.controlPanel.ui.selectedStatusBody.html(bodmin.lang.datePlaceStatus[bodmin.controlPanel.currentRingingDateLocationStatus]);
        }

        bodmin.controlPanel.ui.theDatePicker.datepicker( "refresh" );
        setEditButtonsOff();

        // we may have data since before
        buildRingedBirdsTable();

    }

    function loadCurrentDatePlaceIDIfAny(){

        for (let i = 0; i < bodmin.controlPanel.ringingDates.length; i++){

            if ((bodmin.controlPanel.ringingDates[i].THEDATE === bodmin.selectedDate.ymd) && (bodmin.controlPanel.ringingDates[i].LOCALITY_ID === bodmin.location)){
                bodmin.controlPanel.currentRingingDateLocation = bodmin.controlPanel.ringingDates[i].ID;
                bodmin.controlPanel.currentRingingDateLocationStatus = bodmin.controlPanel.ringingDates[i].STATUS_ID;
                break;
            }

        }

    }

    function setDateTexts(sLanguage){
        /*
        Set months, weekdays names and other date related texts - without visiting the server.
         */
        // E N G E L S K A
        if (sLanguage === '1') {

            bodmin.lang.dateTexts = {

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

            bodmin.lang.dateTexts = {

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

    }

    function setLangTexts(){

        // E N G E L S K A
        if (bodmin.lang.current === '1'){

            bodmin.lang.datePlaceStatus = {
                1:"Data entry ongoing.",
                2:"Data entry done.",
                3:"Data sent to RC - No changes possible."
            }

            bodmin.lang.langAsString = 'en';

            bodmin.lang.title= 'Ringing';
            // header info
            bodmin.lang.loggedinText = 'Logged in as ';
            bodmin.lang.notLoggedinText = 'You are not logged in';
            bodmin.lang.logOutHere = "Log out here";
            bodmin.lang.pageTitle = "Ringing";
            bodmin.lang.hdrMain = "Ringing";

            // vänster sidan
            bodmin.controlPanel.lang.selectIntro = 'Selected';
            bodmin.lang.selectInfo = 'Select a location and date';
            bodmin.controlPanel.lang.btnEdit = 'Create/edit data';
            bodmin.controlPanel.lang.btnFinish = "Wrap up the place/date";
            bodmin.controlPanel.lang.btnRingCheck = "Check rings";
            bodmin.controlPanel.lang.btnEffort =  "Edit effort";
            bodmin.controlPanel.lang.locationDropDownDisabledMessage = 'You cannot change location while you are editing data.';
            bodmin.controlPanel.lang.calendarDisabledMessage = 'You cannot change date when you are editing data.';


            // data input
            bodmin.dataSection.lang = {
                mustBeGiven             : "Must be given",

                dataEntrySectionHeader  : "Data entry",
                dataEntrySectionHeaderEdit  : "Data - edit",
                lblInpHour              : "Hour",
                thHour                  : "Hour",
                inpHourInvalid          : "Valid: 00-23",

                lblCheckBoxSystematic   : "Systematic",
                lblTrappingMethod       : "Trapping method",
                lblOther                : "Extra info",

                lblRing                 : "Ring No#",
                thRingNo                : "Ring no#",

                inpRingNoProvide        : "Please provide ring no#",
                inpRingNoSelect         : "Please select ring no#",
                inpRingInvalid          : "Invalid ring no#",

                lblInpTaxa              : "Taxon",
                thTaxa                  : "Taxa",
                inpSpeciesInvalid       : "Proper code, please!",

                lblInpAge               : "Age",
                thAge                   : "Age",
                inpAgeInvalid           : "Invalid age. Write: 1, 1+, 2, 2+, etc. without 'k', or 'cy'",
                inpAgeTitle             : "1, 1+, 2, 2+, etc. Max. 9",
                inpAgeMustBeFilled      : "Must be given",

                lblInpSex               : "Sex",
                thSex                   : "Sex",

                thWing                  : "Wing",
                thFat                   : "Fat",
                thWeight                : "Weight",
                thMoultSecondaries       : "SecMoult",
                thMoultPrimaries         : "PriMoult",
                thMoultPull              : "PullMoult",


                btnMoveOn               : "Next",
                labelDataTabOneByOne    : "One by one",
                labelDataTabBatches     : "Batches",
                labelDataTabReTraps     : "Re-traps",

                hdrEnteredData          : "Entered data",
                tabDataFullList         : "Full list",
                tabDataSummaryHour      : "Summary by hour",
                tabDataSummaryAgeSpecies : "Summary by taxa and age",
                tabDataComparisons      : "Comparisons",

                btnRingingRecordSave     : "Save",
                btnRingingRecordCancel   : "Cancel"

            }

            bodmin.modalRings.lang = {
                header                  : "Manage (check) rings for ",
                btnAdd                  : "Add ring type",
                btnSave                 : "Save",
                btnCancel               : "Cancel",
                duplicateRingType       : "You have two identical ringtypes.",
                duplicateRingNo         : "You have two identical ringnumbers",
                frmValNoTranslation     : "Du have to give a ring number.",
                lblModalRingType1       : "Ring type (size)",
                lblModalRingNo1         : "Current No#",
            }

            bodmin.modalPromptRingCheck.lang = {
                modalPromptRingCheckHeader    : "Rings, rings...",
                modalPromptRingCheckMessage   : "Please click Check rings button, check the rings, and save. A ring check is mandatory before starting a new data entry session.",
                btnModalPromptRingCheckClose  : "Close"

            }

            bodmin.modalDayDone.lang = {
                modalDayDoneHeader   : 'Wrap up the day?',
                modalDayDoneMessage  : "Are you ready with the day?<br/>If you answer yes below, an entry will be created in the daily blog.",
                btnModalDayDoneYes   : "Yes",
                btnModalDayDoneNo    : "No"
            }

        }


        // S V E N S K A
        if (bodmin.lang.current === '2'){

            bodmin.lang.datePlaceStatus = {
                1:"Data inmatning pågående.",
                2:"Data inmatning avslutad.",
                3:"Data skickat till RC - Inga ändringar möjliga"
            }

            bodmin.lang.langAsString = 'se';

            bodmin.lang.title = 'Ringmärkning';
            // header info
            bodmin.lang.loggedinText = 'Inloggad som ';
            bodmin.lang.notLoggedinText = 'Du är ej inloggad';
            bodmin.lang.logOutHere = "Logga ut här";
            bodmin.lang.pageTitle = "Ringmärkning";
            bodmin.lang.hdrMain = "Ringmärkning";

            bodmin.controlPanel.lang.selectInfo = 'Välj plats och datum';
            bodmin.controlPanel.lang.selectIntro = 'Valt';
            bodmin.controlPanel.lang.btnEdit = 'Skapa/ändra data';
            bodmin.controlPanel.lang.btnFinish = "Avsluta platsen/dagen";
            bodmin.controlPanel.lang.btnRingCheck = "Kolla ringar";
            bodmin.controlPanel.lang.btnEffort =  "Ange märkinsats";
            bodmin.controlPanel.lang.locationDropDownDisabledMessage = 'Du kan ej välja en ny plats medan du editerar data. Avsluta pågående plats först.';
            bodmin.controlPanel.lang.calendarDisabledMessage = 'Du kan ej välja ett nytt datum medan du editerar data. Avsluta pågående dag först.';


            bodmin.dataSection.lang = {

                mustBeGiven             : "Måste anges",

                dataEntrySectionHeader  : "Data nyinmatning",
                dataEntrySectionHeaderEdit  : "Data - ändra",
                lblInpHour              : "Timme",
                thHour                  : "Timme",
                inpHourInvalid          : "Valbara: 00-23",

                lblCheckBoxSystematic   : "Systematisk",
                lblTrappingMethod       : "Fångstmetod",
                lblOther                : "Extra info",

                lblRing                 : "Ringnummer",
                thRingNo                : "Ringnummer",

                inpRingNoProvide        : "Ange ringnummmer",
                inpRingNoSelect         : "Välj ringnummer",
                inpRingInvalid          : "Ogiltigt ringnummer",

                lblInpTaxa              : "Taxon",
                thTaxa                  : "Taxa",
                inpSpeciesInvalid       : "Giltig kod, hörrö!",

                lblInpAge               : "Ålder",
                thAge                   : "Ålder",
                inpAgeInvalid           : "Felaktig ålder. Skriv: 1, 1+, 2, 2+, etc. utan 'k'. ",
                inpAgeTitle             : "1, 1+, 2, 2+, etc. Max 9",
                inpAgeMustBeFilled      : "Måste anges.",

                lblInpSex               : "Kön",
                thSex                   : "Kön",

                lblInpWing              : "Vinge",
                thWing                  : "Vinge",
                inpWingInvalid          : "Ogiltig vinglängd angiven. Enbart siffror, tack.",

                thFat                   : "Fett",
                thWeight                : "Vikt",
                thMoultSecondaries      : "ApRuggn",
                thMoultPrimaries        : "HpRuggn",
                thMoultPull             : "UngRuggn",

                btnMoveOn               : "Nästa",
                labelDataTabOneByOne    : "En i taget",
                labelDataTabBatches     : "Stötar",
                labelDataTabReTraps     : "Återfångster",

                hdrEnteredData          : "Inknappade data",
                tabDataFullList         : "Fullständig lista",
                tabDataSummaryHour      : "Summa timme för timme",
                tabDataSummaryAgeSpecies : "Summa, art och ålder",
                tabDataComparisons      : "Jämförelser",

                btnRingingRecordSave     : "Spara",
                btnRingingRecordCancel   : "Avbryt"

            }

            bodmin.modalRings.lang = {
                header                  : "Hantera ringar för ",
                formCheckLabel          : 'Tag bort denna rad (vid spara).',
                btnAdd                  : "Lägg till ringtyp",
                btnSave                 : "Spara",
                btnCancel               : "Avbryt",
                duplicateRingType       : "Du har två identiska ringtyper.",
                duplicateRingNo         : "Du har två identiska ringnummer",
                frmValNoTranslation     : "Du måste ange ett ringnummer.",
                lblModalRingType1       : "Ringtyp (storlek)",
                lblModalRingNo1         : "Ringnummer"

            }

            bodmin.modalPromptRingCheck.lang = {
                modalPromptRingCheckHeader    : "Ringar, ringar...",
                modalPromptRingCheckMessage   : "Vänligen klicka Kolla ringar knappen, kontrollera ringnummren och spara detta. Du måste göra en ringkontroll innan du kan börja knappa in data.",
                btnModalPromptRingCheckClose  : "Close"

            }

            bodmin.modalDayDone.lang = {
                modalDayDoneHeader   : 'Avsluta dagen?',
                modalDayDoneMessage  : "Är du klar med dagen?<br/>Om du svarar ja nedan uppdateras dagens dagboksblad med en sammanställning.",
                btnModalDayDoneYes   : "Ja",
                btnModalDayDoneNo    : "Nej"
            }

        }

        $(document).attr('title', bodmin.lang.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#hdrMain').text(bodmin.lang.hdrMain);
        $('#loggedinText').text(bodmin.lang.loggedinText);
        $('#selectInfo').text(bodmin.lang.selectInfo);
        $('#infoLabel').text(bodmin.lang.infoLabel);

        let loggedInInfo = bodmin.lang.notLoggedinText;
        if (bodmin.loggedInUserId !== '0'){
            loggedInInfo = '<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        // data entry section
        bodmin.dataSection.ui.dataEntrySectionHeader.text(bodmin.dataSection.lang.dataEntrySectionHeader);
        bodmin.dataSection.ui.tabOneByOne.text(bodmin.dataSection.lang.labelDataTabOneByOne);
        bodmin.dataSection.ui.tabBatches.text(bodmin.dataSection.lang.labelDataTabBatches);
        bodmin.dataSection.ui.tabReTraps.text(bodmin.dataSection.lang.labelDataTabReTraps);

        bodmin.dataSection.ui.lblInpHour.text(bodmin.dataSection.lang.lblInpHour);
        bodmin.dataSection.ui.lblCheckBoxSystematic.text(bodmin.dataSection.lang.lblCheckBoxSystematic);
        bodmin.dataSection.ui.lblTrappingMethod.text(bodmin.dataSection.lang.lblTrappingMethod);
        bodmin.dataSection.ui.lblOther.text(bodmin.dataSection.lang.lblOther);
        bodmin.dataSection.ui.lblRing.text(bodmin.dataSection.lang.lblRing);
        bodmin.dataSection.ui.lblInpTaxa.text(bodmin.dataSection.lang.lblInpTaxa);
        bodmin.dataSection.ui.lblInpAge.text(bodmin.dataSection.lang.lblInpAge);
        bodmin.dataSection.ui.inpAge.attr('title', bodmin.dataSection.lang.inpAgeTitle);
        bodmin.dataSection.ui.lblInpSex.text(bodmin.dataSection.lang.lblInpSex);
        bodmin.dataSection.ui.btnMoveOn.text(bodmin.dataSection.lang.btnMoveOn);
        bodmin.dataSection.ui.btnRingingRecordCancel.text(bodmin.dataSection.lang.btnRingingRecordCancel);
        bodmin.dataSection.ui.btnRingingRecordSave.text(bodmin.dataSection.lang.btnRingingRecordSave);

        // results table
        bodmin.dataSection.ui.hdrEnteredData.text(bodmin.dataSection.lang.hdrEnteredData);
        bodmin.dataSection.ui.tabDataFullList.text(bodmin.dataSection.lang.tabDataFullList);
        bodmin.dataSection.ui.tabDataSummaryHour.text(bodmin.dataSection.lang.tabDataSummaryHour);
        bodmin.dataSection.ui.tabDataSummaryAgeSpecies.text(bodmin.dataSection.lang.tabDataSummaryAgeSpecies);
        bodmin.dataSection.ui.tabDataComparisons.text(bodmin.dataSection.lang.tabDataComparisons);
        bodmin.dataSection.ui.thRingNo.text(bodmin.dataSection.lang.thRingNo);
        bodmin.dataSection.ui.thHour.text(bodmin.dataSection.lang.thHour);
        bodmin.dataSection.ui.thTaxa.text(bodmin.dataSection.lang.thTaxa);
        bodmin.dataSection.ui.thAge.text(bodmin.dataSection.lang.thAge);
        bodmin.dataSection.ui.thSex.text(bodmin.dataSection.lang.thSex);
        bodmin.dataSection.ui.thWing.text(bodmin.dataSection.lang.thWing);
        bodmin.dataSection.ui.thFat.text(bodmin.dataSection.lang.thFat);
        bodmin.dataSection.ui.thWeight.text(bodmin.dataSection.lang.thWeight);
        bodmin.dataSection.ui.thMoultPull.text(bodmin.dataSection.lang.thMoultPull);
        bodmin.dataSection.ui.thMoultPrimaries.text(bodmin.dataSection.lang.thMoultPrimaries);
        bodmin.dataSection.ui.thMoultSecondaries.text(bodmin.dataSection.lang.thMoultSecondaries);


        //
        bodmin.controlPanel.ui.btnEdit.text(bodmin.controlPanel.lang.btnEdit);
        bodmin.controlPanel.ui.btnFinish.text(bodmin.controlPanel.lang.btnFinish);
        bodmin.controlPanel.ui.btnRingCheck.text(bodmin.controlPanel.lang.btnRingCheck);
        bodmin.controlPanel.ui.btnEffort.text(bodmin.controlPanel.lang.btnEffort);

        bodmin.controlPanel.ui.selectedDateInfo.html(bodmin.controlPanel.lang.selectInfo);
        bodmin.controlPanel.ui.selectedIntro.text("");

        // Ring types MODAL
        bodmin.modalRings.ui.btnAdd.text(bodmin.modalRings.lang.btnAdd);
        bodmin.modalRings.ui.btnSave.text(bodmin.modalRings.lang.btnSave);
        bodmin.modalRings.ui.btnCancel.text(bodmin.modalRings.lang.btnCancel);

        bodmin.modalRings.ui.lblModalRingType1.text(bodmin.modalRings.lang.lblModalRingType1);
        bodmin.modalRings.ui.lblModalRingNo1.text(bodmin.modalRings.lang.lblModalRingNo1);

        //ring types check prompt
        bodmin.modalPromptRingCheck.ui.modalPromptRingCheckHeader.text(bodmin.modalPromptRingCheck.lang.modalPromptRingCheckHeader);
        bodmin.modalPromptRingCheck.ui.modalPromptRingCheckMessage.text(bodmin.modalPromptRingCheck.lang.modalPromptRingCheckMessage);
        bodmin.modalPromptRingCheck.ui.btnModalPromptRingCheckClose.text(bodmin.modalPromptRingCheck.lang.btnModalPromptRingCheckClose);

        // done for the day prompt
        bodmin.modalDayDone.ui.modalDayDoneHeader.text(bodmin.modalDayDone.lang.modalDayDoneHeader);
        bodmin.modalDayDone.ui.modalDayDoneMessage.html(bodmin.modalDayDone.lang.modalDayDoneMessage);
        bodmin.modalDayDone.ui.btnModalDayDoneYes.text(bodmin.modalDayDone.lang.btnModalDayDoneYes);
        bodmin.modalDayDone.ui.btnModalDayDoneNo.text(bodmin.modalDayDone.lang.btnModalDayDoneNo);

    }

    bodmin.controlPanel.ui.btnEdit.click(function() {

        // D A T A
        let ok = true;
        if (bodmin.ringsUsed.length === 0) {
            bodmin.modalPromptRingCheck.ui.window.modal('show');
            ok = false;
        }

        if (ok) {

            bodmin.controlPanel.ui.btnFinish.prop('disabled', false);
            bodmin.controlPanel.ui.btnEdit.prop('disabled', true);


            bodmin.controlPanel.mode = "dataManagementOngoing";     // steers if we can edit selected row in the table
            accommodateMeasurementFields();
            determineMeasurementFieldsVisibility();
            bodmin.dataSection.ui.dataEntrySection.toggleClass('mg-hide-element', false);

            // default the editing UI, adding data
            bodmin.dataSection.mode = 'add';

            bodmin.controlPanel.ui.theDatePicker.datepicker( "option" , {
                changeMonth: false,
                changeYear: false,
                stepMonths: 0,
                stepYear : 0
            });

            bodmin.controlPanel.ui.ddLocation.prop('disabled', true);

            bodmin.controlPanel.ui.theDatePicker.attr('title', bodmin.controlPanel.lang.calendarDisabledMessage);
            bodmin.controlPanel.ui.theDatePicker.datepicker( "option", "disabled", true );

            bodmin.controlPanel.ui.ddLocation.prop('disabled', true);
            bodmin.controlPanel.ui.ddLocation.attr('title', bodmin.controlPanel.lang.locationDropDownDisabledMessage);

            if (bodmin.controlPanel.currentRingingDateLocation === '0'){
                updateDateLocationStatus('ongoing');
            }

        }

    });

    function updateDateLocationStatus(mode){

        // we come here only if there's no DateLocation given for an "ongoing" mode.
        // if mode is "done" we pass it on.
        //
        let formData = new FormData();
        formData.append('mode', mode);
        formData.append('date', bodmin.selectedDate.ymd);
        formData.append('location', bodmin.location);

        $.ajax({
            url: "handleRingingDayData.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'POST',
            success: function(data) {
                //let theId = JSON.parse(data);
                bodmin.controlPanel.currentRingingDateLocation = JSON.parse(data);
                // Now ongoing data entry - although we have not yet entered any record
                bodmin.controlPanel.currentRingingDateLocationStatus = 1;
            }
        });

    }

    function buildRingedBirdsTable(){

        /*
        Build the table structure first, using the bodmin.standardMeasurementsConfigs
        Then fetch the base data and populate internal data structure.
        After this retrieve all measurements and make the data set complete.
        Finally create a row for each "Ringed bird" (the internal data structure).
         */

        // empty the data structure used for the table building
        bodmin.dataSection.ringedBirds = [];

        // empty existing data table (if any)
        $("#speciesDataEntryTableBody").find("tr:gt(0)").remove();

        // remove possibly already added standard fields
        $('.standardCol').remove();

        // add standard fields based on month, ignoring settings for sex/age (as this change bird-by-bird) - for the table
        bodmin.standardMeasurementsConfigs.forEach(function(standardMeasurementsConfig){

            const aMonths = standardMeasurementsConfig.MONTHS.split(',');
            const month = mgGetMonthAsIntegerString(bodmin.selectedDate.ymd);
            const include = aMonths.includes(month);

            if (include){

                const tableHeaderCol = '<th class="col-1 standardCol">' + standardMeasurementsConfig.TEXT  + '</th>';
                $('#dataTableHeader').append(tableHeaderCol);
                const tableRowCol = '<td class="col-1 standardCol" id="measurement-' + standardMeasurementsConfig.ID + '">' + '-'  + '</td>';
                $('#baseRow').append(tableRowCol);

            }

        });


        if (bodmin.controlPanel.currentRingingDateLocation !== 0 ){

            let newRowHTML = "<tr id='spinner'><td colspan='11'>" + mgGetDivWithSpinnerImg() + "</td></tr>";
            bodmin.dataSection.ui.speciesDataEntryTableBody.append(newRowHTML);


            // Load first data into internal ArrayOfObjects structure bodmin.datasection.ringedBirds[]
            // data for each ringed bird is kept in an object: RingingRecord,
            // as we have more data than we show in the table row.
            // Once all base data is loaded, load extra/optional measurements into a structure. Then populate main structure.
            $.ajax({
                type:"GET",
                async: true,
                url: "getRingingRecords.php?id=" + bodmin.controlPanel.currentRingingDateLocation,
                success: function(data) {

                    let ringedBirds = JSON.parse(data);
                    ringedBirds.forEach(function(aRingedBird){

                        let aRingingRecord = new RingingRecord();
                        //
                        aRingingRecord.setId(aRingedBird.ID);
                        aRingingRecord.setRingNo(aRingedBird.RINGNO);
                        aRingingRecord.setShortname(aRingedBird.SHORTNAME);
                        aRingingRecord.setHour(aRingedBird.HOUR);
                        aRingingRecord.setAge(aRingedBird.AGE);
                        aRingingRecord.setSex(aRingedBird.SEX);
                        //
                        aRingingRecord.setTaxa_Id(aRingedBird.TAXA_ID);
                        aRingingRecord.setTrapping_method_id(aRingedBird.TRAPPING_METHOD_ID);
                        aRingingRecord.setSystematic(aRingedBird.SYSTEMATIC);
                        aRingingRecord.setObs(aRingedBird.OBS);
                        aRingingRecord.setRinging_dates_locations_id(aRingedBird.RINGING_DATES_LOCATIONS_ID);
                        aRingingRecord.setChanged_at(aRingedBird.CHANGED_AT);
                        aRingingRecord.setChanged_by(aRingedBird.CHANGED_BY);
                        aRingingRecord.setCreated_by(aRingedBird.CREATED_BY);
                        aRingingRecord.setCreated_at(aRingedBird.CREATED_AT);
                        bodmin.dataSection.ringedBirds.push(aRingingRecord);

                    });

                    $.ajax({
                        type: "GET",
                        async: true,
                        url: "getMeasurements.php?id=" + bodmin.controlPanel.currentRingingDateLocation + "&lang_id=" + bodmin.lang.current,
                        success: function (data) {

                            let aMeasurements = JSON.parse(data);

                            aMeasurements.forEach(function(aMeasurement){

                                let measurement = new Measurement();
                                measurement.setRingingDataId(aMeasurement.RINGING_DATA_ID);
                                measurement.setMeasurementId(aMeasurement.MEASUREMENT_ID);
                                measurement.setText(aMeasurement.TEXT);
                                measurement.setValue(aMeasurement.VALUE);

                                let t = aMeasurement.RINGING_DATA_ID;
                                // find the main data structure element
                                let aRingingRecord = $.grep(bodmin.dataSection.ringedBirds, function(aRingingRecord){return aRingingRecord.getId() === t;})[0];
                                if (typeof aRingingRecord !== 'undefined') {
                                    aRingingRecord.addMeasurement(measurement);
                                }

                            });

                            $('#spinner').remove();

                            // reload the table
                            bodmin.dataSection.ringedBirds.forEach(function(aRingingRecord){
                                // create a new complete data row
                                // populate it with data from data structure
                                populateAndAddTableRow(aRingingRecord);

                            });
                        }
                    });



                }

            });

        }
    }

    function populateAndAddTableRow(ringedBird){

        let tableRow = $("#baseRow").clone();
        bodmin.addedRow = tableRow;
        updateTableRow(tableRow, ringedBird);

        // add the new row to the table and show it
        tableRow.toggleClass('mg-hide-element', false);
        tableRow.toggleClass('d-flex', true);
        tableRow.toggleClass('mg-ringed-bird-row', true);
        tableRow.appendTo('#speciesDataEntryTableBody');

    }

    bodmin.controlPanel.ui.btnRingCheck.click(function(){

        bodmin.modalRings.ui.header.text(bodmin.modalRings.lang.header + ' ' + bodmin.name);
        bodmin.modalRings.ui.divNotUnique.toggleClass('mg-hide-element', true);

        bodmin.modalRings.ui.modalRingTypesAvert.html(mgGetDivWithSpinnerImg());
        bodmin.modalRings.ui.modalRingTypesAvert.toggleClass('mg-hide-element', false);
        bodmin.modalRings.ui.ringsRows.toggleClass('mg-hide-element', true);

        // restore to original state - one row div
        let rows = $('#ring-types-rows div.mg-row');
        let antalBoxar = rows.length;

        while (antalBoxar > 1){
            $('#ring-types-rows div.mg-row:nth-child(' + antalBoxar + ')').remove();
            antalBoxar --;
        }

        $('.varning').toggleClass("mg-hide-element", true);

        // get earlier entered data
        $.ajax({
            type:"get",
            async: true,
            url: "getLocalityRingTypesNumbers.php?locality_id=" +  bodmin.location,
            success: function(data) {

                let rings = JSON.parse(data);

                //populate edit form, add new boxes as needed
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < rings.length; i++) {

                    addRingTypeSection();
                    $('#slct-rings-' + rowId).val(rings[i].RINGTYPE_ID);
                    $('#ring-no-' + rowId).val(rings[i].RINGNO);

                    rowId++;
                }

                bodmin.modalRings.ui.modalRingTypesAvert.toggleClass('mg-hide-element', true);
                bodmin.modalRings.ui.modalRingTypesAvert.empty();
                bodmin.modalRings.ui.ringsRows.toggleClass('mg-hide-element', false);

            }
        });

       bodmin.modalRings.ui.window.modal('show');

    });

    bodmin.modalRings.ui.btnAdd.click( function(){
        addRingTypeSection();
    });

    function addRingTypeSection(){

        // clone the first (row)
        let newRow = $("#rings-row-1").clone();
        newRow.toggleClass('mg-hide-element', false);


        // Check how many boxes we have, so we can name the newly cloned one properly.
        let rows = $('#ring-types-rows div.mg-row').length;
        rows ++;
        newRow.attr('id', 'rings-row-' + rows);

        // turn off labels for all, but the very first row of fields.
        // 1 invisible (start) row + first data row, subsequent turned off
        if (rows > 2) {
            let labels = newRow.find('label');
            labels.toggleClass('mg-hide-element', true);

        }

        // re-id and rename the fields
        let field = newRow.find('#slct-rings-1');
        field.attr('id', 'slct-rings-' + rows);
        field.attr('name', 'name-slct-rings-' + rows);
        //field.val('1');

        field = newRow.find('#ring-no-1');
        field.attr('id', 'ring-no-' + rows);
        field.attr('name', 'ring-no-' + rows);
        field.val('');

        let button = newRow.find('#btnRemoveRow-1');
        button.attr('id', 'btnRemoveRow-' + rows);
        button.attr('name', 'btnRemoveRow-' + rows);

        let theWarningText = newRow.find('#warning-item-1');
        theWarningText.attr('id', 'warning-item-' + rows);
        theWarningText.text('');

        newRow.appendTo(bodmin.modalRings.ui.ringsRows);

    }

    bodmin.dataSection.ui.btnMoveOn.click(function() {
        addAndContinue();
    })

    function validateAllFields(){

        let ok = validateHour(bodmin.dataSection.ui.inpHour.val())

        if (ok) {
            ok = validateRing(bodmin.dataSection.ui.inpRing.val());
        }

        if (ok) {
            ok = validateAge(bodmin.dataSection.ui.inpAge.val());
        }

        // sex not validated, always one selected.

        if (ok) {
            ok = validateStandardFields();
        }

        return ok;

    }

    function addAndContinue(){

        // A D D
        let ok = validateAllFields();

        if (ok) {

            // create a new Data object and add it to the others
            let aRingingRecord = new RingingRecord();
            updateRingedBirdFromForm(aRingingRecord);

            populateAndAddTableRow(aRingingRecord);
            bodmin.dataSection.ringedBirds.push(aRingingRecord);

            // clear (some) fields
            // Keep hour and taxon in first row, wipe out only observation in the first
            emptyFields();

            bodmin.curentRingNo = aRingingRecord.getRingNo();
            updateUsedRing(bodmin.curentRingNo);

            let formData = getFormDataFromRingedBird("add", aRingingRecord);
            $.ajax({
                url: "writeRingingRecord.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function(data) {
                    if (JSON.parse(data)) {

                        console.log("Ringing record written -> conclude");

                        concludeWrittenRecord(aRingingRecord);
                    }
                }
            });

            bodmin.dataSection.ui.inpTaxa.focus();

        }
    }

    bodmin.dataSection.ui.ddMoreMeasurements.change(function(){

        if (bodmin.dataSection.ui.ddMoreMeasurements.val() !== '0'){

            // compile list of existing measurements
            let arrayMeasurmentIds = [];
            $('.mg-active-row').each(function() {
                //additional-measurement-row-6
                //0123456789012345678901234567
                arrayMeasurmentIds.push($(this).attr('id').substr(27,99));
            });

            // if selected id not yet listed ... include it!
            if (!arrayMeasurmentIds.includes(bodmin.dataSection.ui.ddMoreMeasurements.val())){

                const measurementId = bodmin.dataSection.ui.ddMoreMeasurements.val();
                const measurementName = $( "#dd-more-measurements option:selected" ).text();
                const value = '';
                addOptionalMeasurement(measurementId, measurementName, value);

                bodmin.dataSection.ui.moreMeasurementsSection.toggleClass('mg-hide-element', false);

                bodmin.dataSection.ui.ddMoreMeasurements.val(0);
            }

        }

    });

    function addOptionalMeasurement(measurementId, measurementName, value){

        let newRow = bodmin.dataSection.ui.moreMeasurementsBaseRow.clone();
        newRow.attr('id', 'measurementRow-' + measurementId) ;
        newRow.find('#basic-addon1').text(measurementName);
        newRow.find('#btnRemoveMeasurementRow-').attr('id', 'btnRemoveMeasurementRow-' + bodmin.dataSection.ui.ddMoreMeasurements.val() );
        newRow.find('input').val(value);
        newRow.toggleClass('mg-hide-element', false);
        newRow.toggleClass('mg-active-row', true);
        newRow.attr('id', "additional-measurement-row-" + measurementId );

        bodmin.dataSection.ui.moreMeasurementsSection.prepend(newRow);

    }

    bodmin.dataSection.ui.btnRingingRecordSave.click(function(){

        // E D I T  S A V E
        let ok = validateAllFields();

        if (ok) {

            // taxa-id not in the form itself, we use shortname as a proxy to get it, kept in bodmin.currentTaxa.id
            // taxa names and ids kept in data structure: bodmin.dataSection.ui.taxaNamesAndCodes
            // the user *may* have changed the taxa shortname in the form, thus look up the taxa id anew
            setCurrentTaxaInfo(bodmin.dataSection.ui.inpTaxa.val());

            let selectedRecord = bodmin.dataSection.ringedBirds.find(thisRecord => thisRecord.getId() === bodmin.mainTableId);
            updateRingedBirdFromForm(selectedRecord);


            bodmin.dataSection.mode = "edit";
            let formData = getFormDataFromRingedBird( bodmin.dataSection.mode, selectedRecord );

            $.ajax({
                url: "updateRingingRecord.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function () {
                    handleMeasurements(selectedRecord);
                }
            });

            updateTableRow(bodmin.selectedRow, selectedRecord);
            emptyFields();
            bodmin.selectedRow.removeClass('table-active');
            bodmin.dataSection.mode = 'add';
            setDataUserInterfaceAccordingToMode();

        }

    });

    function updateTableRow(tableRow, ringedBird){
        /*
        Update an existing table row with data in the data structure
        */

        tableRow.attr("id", ringedBird.getId());
        tableRow.find("td").eq(0).text(ringedBird.getRingNo());

        tableRow.find("td").eq(1).text(ringedBird.getShortname());
        tableRow.find("td").eq(2).text(ringedBird.getHour());
        tableRow.find("td").eq(3).text(ringedBird.getAge());
        tableRow.find("td").eq(4).text(ringedBird.getSex());

        let aOfMeasurementObjects = ringedBird.getStandardMeasurementsData();
        aOfMeasurementObjects.forEach(function(arrayMeasurementData){

            let val = arrayMeasurementData.value;
            if ( val < '1'){
                val = '-';
            }

            tableRow.find("#measurement-" + arrayMeasurementData.id).text(val);
        });

    }

    function emptyFields(){

        bodmin.dataSection.ui.inpObservation.val('');
        bodmin.dataSection.ui.inpRing.val('')
        bodmin.dataSection.ui.inpAge.val('');
        bodmin.dataSection.ui.inpSex.val('-');
        $('input[id^="inp-"]').each(function() {
            $(this).val('');
        });

        bodmin.dataSection.ui.moreMeasurementsSection.empty();
        bodmin.dataSection.ui.moreMeasurementsSection.toggleClass('mg-hide-element', true);
        bodmin.dataSection.ui.moreMeasurementsSection.append('<hr>');

    }

    function updateRingedBirdFromForm(aRingingRecord){
        /*
        Harvest all entered data into a data structure
        Two one-to-many relationships
        * Standard measurements
        * Extra (optional) measurements
        */

        aRingingRecord.setRingNo(bodmin.dataSection.ui.inpRing.val());
        aRingingRecord.setShortname(bodmin.dataSection.ui.inpTaxa.val());
        aRingingRecord.setHour(bodmin.dataSection.ui.inpHour.val());
        aRingingRecord.setAge(bodmin.dataSection.ui.inpAge.val());
        aRingingRecord.setSex(bodmin.dataSection.ui.inpSex.val());
        aRingingRecord.setTaxa_Id(bodmin.currentTaxa.id);
        aRingingRecord.setTrapping_method_id(bodmin.dataSection.ui.inpTaxa.val());
        let sys = "0";
        if (bodmin.dataSection.ui.inpSystematic.prop('checked')) {
            sys = "1";
        }
        aRingingRecord.setSystematic(sys);
        aRingingRecord.setObs(bodmin.dataSection.ui.inpObservation.val());
        aRingingRecord.setRinging_dates_locations_id(bodmin.controlPanel.currentRingingDateLocation);

        // taken care of by the DB, not needed here
        //aRingingRecord.setChanged_at();
        //aRingingRecord.setChanged_by();
        //aRingingRecord.setCreated_by();
        //aRingingRecord.setCreated_at();

        // standard-measurements)
        $('input[id^="inp-"]').each(function() {
            //inp-1
            //01234

            const measurementId = $(this).attr('id').substr(4,99);
            let val = $('#inp-' + measurementId).val();

            console.log('measurement id ' + measurementId);
            console.log('value ' + val);

            if (measurementId === '2') /* weight */ {
                if (bodmin.currentTaxa.decigrams === '1'){
                    if (val > 0){
                        val = val/10;
                    } else {
                        val = '-1';
                    }
                }

            }

            let arrayMeasurementData = {"id":measurementId, "value":val};
            aRingingRecord.addStandardMeasurementsData(arrayMeasurementData);
        });

        // extra data (if any)
        $('.mg-active-row').each(function() {
            //additional-measurement-row-6
            //0123456789012345678901234567
            let measurementId = $(this).attr('id').substr(27,99);
            let val = $(this).find('input').val();
            let arrayMeasurementData = {"id":measurementId, "value":val};
            aRingingRecord.addMeasurement(arrayMeasurementData);
        });

    }

    function getFormDataFromRingedBird(mode, aRingingRecord){
        /*
        Data is stored in aRingingRecord data structure is moved over to a formData object.
        */

        let formData = new FormData();
        let id = 0;
        if (mode === 'edit'){
            formData.append('mode', 'edit');
            id = bodmin.mainTableId;
        }

        if (mode === 'add'){
            formData.append('mode', 'add');
        }

        formData.append('ongoing_day_id', aRingingRecord.getRinging_dates_locations_id());
        formData.append('id', id);
        formData.append('hour', aRingingRecord.getHour());
        formData.append('systematic', aRingingRecord.getSystematic());
        formData.append('trap', aRingingRecord.getTrapping_method_id());
        formData.append('extra', aRingingRecord.getObs());
        formData.append('ring', aRingingRecord.getRingNo());
        formData.append('taxon', aRingingRecord.getTaxa_Id());
        formData.append('age', aRingingRecord.getAge());
        formData.append('sex', aRingingRecord.getSex());
        return formData;

    }

    function concludeWrittenRecord(aRingingRecord){

        /*
        get the witten record id via ring no# for populating the shadow structure properly (so it is possible to edit later).
        */

        $.ajax({
            type    :"GET",
            async   : true,
            url     : "getRingingRecordId.php?ring=" + aRingingRecord.getRingno(),
            success : function(data) {

                let result = JSON.parse(data);

                console.log('In conclude written record');
                console.log(aRingingRecord.getRingno());
                console.log(result);

                if (result.length > 0) {
                    aRingingRecord.setId(result[0].ID);
                    bodmin.addedRow.attr('ID', result[0].ID);
                    bodmin.addedRow.toggleClass('notYetWrittenToDB', false);

                    handleMeasurements(aRingingRecord);
                }

            }
        });

    }

    function handleMeasurements(aRingingRecord){

        let formData = new FormData;
        formData.append('ringing_record_id', aRingingRecord.getId());

        let aMeasurements = aRingingRecord.getMeasurements();

        aMeasurements.forEach(function(measurement){
            formData.append('measurementId-' + measurement.id, measurement.value);
        });

        let aStandardMeasurements = aRingingRecord.getStandardMeasurementsData();
        aStandardMeasurements.forEach(function(measurement){
            formData.append('measurementId-' + measurement.id, measurement.value);
        });

        $.ajax({
            url: "handleMeasurements.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'POST',
            success: function() {
                //
            }
        });


    }

    function updateUsedRing( ringNo ){

        let nextRingNo = getNextRingNumber( ringNo );
        let ringNoLocationsRecId = '0';
        for (let i = 0; i < bodmin.ringsUsed.length; i++){
            if (bodmin.ringsUsed[i].RINGNO === ringNo){
                bodmin.ringsUsed[i].RINGNO = nextRingNo;
                ringNoLocationsRecId = bodmin.ringsUsed[i].ID;
                break;
            }
        }

        if (ringNoLocationsRecId !== '0'){
            let formData = new FormData;
            formData.append('ringNoLocationsId', ringNoLocationsRecId);
            formData.append('nextRingNo', nextRingNo);
            $.ajax({
                url: "updateUsedRing.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    //
                }
            });
        }

    }

    function getNextRingNumber( oldRingNo ){

        let ringSeries = oldRingNo.substring(0, oldRingNo.length - 3);
        let noPart = oldRingNo.substring(oldRingNo.length - 3, oldRingNo.length);
        let iNoPart = parseInt(noPart);

        let newRingNo = '';
        if (!isNaN(iNoPart)){
            iNoPart = iNoPart + 1;
            if (iNoPart < 10){
                newRingNo = ringSeries + '00' + iNoPart;
            } else {
                if (iNoPart < 100){
                    newRingNo = ringSeries + '0' + iNoPart;
                } else {
                    newRingNo = ringSeries + iNoPart;
                }
            }

        }

        return newRingNo;
    }

    bodmin.dataSection.ui.inpTaxa.keyup(function() {
        bodmin.dataSection.ui.inpTaxa.val(bodmin.dataSection.ui.inpTaxa.val().toUpperCase());
    });

    bodmin.dataSection.ui.inpHour.focusout(function() {
        validateHour(bodmin.dataSection.ui.inpHour.val());
    });

    bodmin.dataSection.ui.inpTaxa.focusout(function() {

        bodmin.dataSection.ui.inpTaxa.toggleClass('mg-warning', false);
        bodmin.dataSection.ui.warningInpTaxa.toggleClass('mg-hide-element', true);
        let toTest = $.trim(bodmin.dataSection.ui.inpTaxa.val());

        let ok = validateShortName(toTest);

        if (ok) {

            if (bodmin.dataSection.mode === 'add'){

                // we have a proper short name - get the taxon code
                setCurrentTaxaInfo(toTest);

                // check the ring types for this taxon
                getRingTypes(bodmin.currentTaxa.id);

                let nextRingNos = getRingNoForRingTypes(bodmin.currentTaxaRingTypes);

                // reset to no-list if we (perhaps) have a list already
                if (bodmin.dataSection.ui.inpRing.attr('list')) {
                    let list = '#' + bodmin.dataSection.ui.inpRing.attr('list');
                    $(list).remove();
                    bodmin.dataSection.ui.inpRing.removeAttr('list');
                }

                if (nextRingNos.length === 0){
                    bodmin.dataSection.ui.inpRing.val('');
                    bodmin.dataSection.ui.inpRing.attr("placeholder", bodmin.dataSection.lang.inpRingNoProvide);
                    bodmin.ringNoValidationScenario = 'any';
                } else if (nextRingNos.length === 1){
                    bodmin.dataSection.ui.inpRing.val(nextRingNos[0]);
                    bodmin.ringNoValidationScenario = 'checkInList';
                } else {
                    bodmin.dataSection.ui.inpRing.val('');
                    bodmin.ringNoValidationScenario = 'checkInList';
                    bodmin.dataSection.ui.inpRing.attr("placeholder", bodmin.dataSection.lang.inpRingNoSelect);
                    bodmin.dataSection.ui.inpRing.attr("list", "dataListRingNos");
                    let listHTML = '<datalist id="dataListRingNos">'
                    for (let i=0; i < nextRingNos.length; i++){
                        listHTML = listHTML + '<option value="' + nextRingNos[i] +'">';
                    }
                    listHTML = listHTML + '</datalist>';
                    bodmin.dataSection.ui.ringSection.append(listHTML);

                }

            }

            // Get possible taxa dependent validation rules, and set them for relevant fields
            const aTaxaValidations = getStandardFieldsTaxaDependentValidations();
            aTaxaValidations.forEach(setValidationRules);

        }


        if (!ok){
            bodmin.dataSection.ui.inpTaxa.toggleClass('mg-warning', true);
            bodmin.dataSection.ui.warningInpTaxa.toggleClass('mg-hide-element', false);
            bodmin.dataSection.ui.inpTaxa.focus();
        }

    });

    function setValidationRules(item){

        let currentField = $('#inp-' + item.MEASUREMENT_ID);
        const placeHolder = item.LOWERMIN + '-' + item.UPPERMAX;
        currentField.attr('placeholder', placeHolder);
        currentField.attr('title', placeHolder);
        currentField.attr('maxlength', item.UPPERMAX.length);

    }

    function accommodateMeasurementFields(){

        /*
        Output all measurement to DOM as a template. Subsequently, check which ones should be shown/hidden via determineExtraFieldVisibility().
         */

        for (let i=0; i<bodmin.standardMeasurementsConfigs.length; i++){

            let currentConfig = bodmin.standardMeasurementsConfigs[i];

            let htmlString = '<div class="form-group col-md-1 mg-hide-elementX" id="standardMeasurement-' + currentConfig.ID + '">';
            htmlString = htmlString + '<label for="' + currentConfig.TEXT + '" id="lbl' + currentConfig.TEXT + '">' + currentConfig.TEXT + '</label>';
            const maxLength = currentConfig.UPPERMAX.length;
            htmlString = htmlString + '<input type="text" id="inp-' + currentConfig.ID + '" class="form-control" placeholder="' + currentConfig.LOWERMIN +'-' + currentConfig.UPPERMAX + '" title="' + currentConfig.LOWERMIN + '-' + currentConfig.UPPERMAX + '" maxlength="' + maxLength + '">';
            htmlString = htmlString + '<span><small id="warning-inp-' + currentConfig.ID + '" class="mg-warning-input mg-hide-element"></small></span>';
            htmlString = htmlString + '</div>';

            bodmin.dataSection.ui.secondRow.append(htmlString);

        }

    }

    function determineMeasurementFieldsVisibility(){

        /*
        Turns on/off visibility of measurement fields based on config settings and current data in form
        Called when form is shown and when data in certain fields (age, sex, date) changes
         */

        for (let i=0; i<bodmin.standardMeasurementsConfigs.length; i++) {

            let currentConfig = bodmin.standardMeasurementsConfigs[i];
            let fieldName = 'standardMeasurement-' + currentConfig.ID;
            let fieldSection = $('#' + fieldName);
            fieldSection.toggleClass('mg-hide-element', true);
            if (includeThisField(currentConfig)){
                fieldSection.toggleClass('mg-hide-element', false);
            }

        }



    }

    function includeThisField(configData){
        let include = true;

        // age
        // three options here, all (99) 1k (year) 2k+
        if (configData.AGE !== '99'){

            if (configData.AGE === '1k'){
                include = (bodmin.dataSection.ui.inpAge.val() === '1');
            }

            if (configData.AGE === '2k+'){
                const nConfig = parseInt(configData.AGE);
                const nValue = parseInt(bodmin.dataSection.ui.inpAge.val() );
                include = (nValue >= nConfig);
            }

        }

        if (include){

            // sex
            // three options here, all (4) male (3) female (2)
            if (configData.SEX !== '4'){
                include = (bodmin.dataSection.ui.inpSex.val() === configData.SEX);
            }

        }

        if (include){

            // timing - months
            // 2002-10-12
            let aMonths = configData.MONTHS.split(',');
            let inpDateMonth = bodmin.selectedDate.ymd.substr(5,2);
            if (inpDateMonth.substr(0,1) === '0'){
                inpDateMonth = inpDateMonth.substr(1,1);
            }

            include = aMonths.includes(inpDateMonth);

        }

        return include;

    }

    bodmin.dataSection.ui.inpRing.focusout(function() {
        validateRing(bodmin.dataSection.ui.inpRing.val());
    });

    bodmin.dataSection.ui.inpAge.focusout(function() {
       validateAge( bodmin.dataSection.ui.inpAge.val() )
    });


    function setCurrentTaxaInfo(shortName){

        for (let i = 0; i < bodmin.dataSection.ui.taxaNamesAndCodes.length; i++) {

            if (bodmin.dataSection.ui.taxaNamesAndCodes[i].SHORTNAME === shortName){
                bodmin.currentTaxa.id = bodmin.dataSection.ui.taxaNamesAndCodes[i].ID;
                bodmin.currentTaxa.decigrams = bodmin.dataSection.ui.taxaNamesAndCodes[i].DECIGRAMS;
                break;
            }

        }

    }

    function getRingTypes(taxaId){

        bodmin.currentTaxaRingTypes = [];
        for (let i = 0; i < bodmin.allRingData.length; i++) {

            if (bodmin.allRingData[i].TAXA_ID === taxaId){
                bodmin.currentTaxaRingTypes.push(bodmin.allRingData[i].RING_TYPE_ID);
            }

        }

    }

    function getRingNoForRingTypes(arrayTypeIds){

        let aCurrentRingNos = [];

        for (let r = 0; r < arrayTypeIds.length; r++) {
            for (let i = 0; i < bodmin.ringsUsed.length; i++) {
                if (bodmin.ringsUsed[i].RINGTYPE_ID === arrayTypeIds[r]){
                    aCurrentRingNos.push(bodmin.ringsUsed[i].RINGNO);
                    break;
                }
            }
        }

        return aCurrentRingNos;
    }

    function validateHour( hour ){

        bodmin.dataSection.ui.inpHour.toggleClass('mg-warning', false);
        bodmin.dataSection.ui.warningInpHour.toggleClass('mg-hide-element', true);
        let toTest = hour.trim();
        let ok = true;
        if ($.trim(toTest).length === 0) {
            // Empty, not allowed.
            bodmin.dataSection.ui.warningInpHour.text(bodmin.dataSection.lang.mustBeGiven);
            ok = false;
        } else {

            // Check if the entered value is OK.
            const hours = [
                "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12",
                "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"
            ]

            if (!hours.includes(toTest)){
                bodmin.dataSection.ui.warningInpHour.text(bodmin.dataSection.lang.inpHourInvalid);
                ok = false;
            }
        }

        if (!ok){
            bodmin.dataSection.ui.inpHour.toggleClass('mg-warning', true);
            bodmin.dataSection.ui.warningInpHour.toggleClass('mg-hide-element', false);
            bodmin.dataSection.ui.inpHour.focus();
        }

        return ok;
    }

    function validateShortName(toTest){

        let ok = true;
        if (toTest.length === 0) {
            // Empty not allowed.
            ok = false;
            bodmin.dataSection.ui.warningInpTaxa.text(bodmin.dataSection.lang.mustBeGiven);
        }

        if (toTest.length < 5) {
            // Must be fully filled out.
            ok = false;
            bodmin.dataSection.ui.warningInpTaxa.text(bodmin.dataSection.lang.inpSpeciesInvalid);
        }

        if (ok) {
            // Check if the entered value is OK.
            if (!bodmin.dataSection.arrayTaxaCodes.includes(toTest)) {
                ok = false;
                bodmin.dataSection.ui.warningInpTaxa.text(bodmin.dataSection.lang.inpSpeciesInvalid);
            }
        }

        return ok;

    }

    function validateRing( ring ){

        let ok = true;
        bodmin.dataSection.ui.inpRing.toggleClass('mg-warning', false);
        bodmin.dataSection.ui.warningInpRing.toggleClass('mg-hide-element', true);
        let toTest = $.trim( ring );

        if (toTest.length === 0) {
            ok = false;
            bodmin.dataSection.ui.warningInpRing.text(bodmin.dataSection.lang.mustBeGiven);
        } else {

            // we have a ring number
            if (bodmin.ringNoValidationScenario === 'checkInList'){
                // the ring number *must* be present in the list of used numbers - determined by the taxon
                ok = false;
                for (let i = 0; i < bodmin.ringsUsed.length; i++){

                    if (bodmin.ringsUsed[i].RINGNO === toTest){
                        ok = true;
                        break;
                    }

                }

                if (!ok){
                    bodmin.dataSection.ui.warningInpRing.text(bodmin.dataSection.lang.inpRingInvalid);
                }
            } else {  /* A taxon entered which does not have any ring info, or takes a ring size not present in the list of known rings # */
                // the user enters the number freely. The number cannot be a substring of anyone that we have.
                // if the entered number is one we have - fine.

                let f = false;
                for (let i = 0; i < bodmin.ringsUsed.length; i++){

                    if (bodmin.ringsUsed[i].RINGNO === toTest){
                        f = true;
                        break;
                    }

                }

                if (!f){
                    // it can still be "ok" although it wasn't found above

                    for (let i = 0; i < bodmin.ringsUsed.length; i++){

                        if (toTest.length < bodmin.ringsUsed[i].RINGNO.length){

                            if (bodmin.ringsUsed[i].RINGNO.substr(0, toTest.length) === toTest){
                                ok = false;
                                bodmin.dataSection.ui.warningInpRing.text(bodmin.dataSection.lang.inpRingInvalid);
                                break;
                            }
                        }

                    }
                }

            }

        }

        if (!ok) {
            bodmin.dataSection.ui.warningInpRing.toggleClass('mg-hide-element', false);
            bodmin.dataSection.ui.inpTaxa.focus();
        }

        return ok;

    }

    function validateAge( age ){

        let ok = true;
        const aDigits = ["1","2","3","4","5","6","7","8","9","0"];
        let warningMessage = '';

        bodmin.dataSection.ui.warningInpAge.text("");
        bodmin.dataSection.ui.warningInpAge.toggleClass('mg-hide-element', true);

        // pre-check
        let firstPlus = age.indexOf('+');
        let lastPlus = age.lastIndexOf('+');

        if (age.trim().length === 0){
            ok = false;
            warningMessage = bodmin.dataSection.lang.inpAgeMustBeFilled;
        }

        // only one + in the string
        if ((firstPlus > -1) && (lastPlus > firstPlus)) {
            ok = false;
            warningMessage = bodmin.dataSection.lang.inpAgeInvalid;
        }

        // if one +, but not at the end
        if (ok){
            if ((firstPlus > -1) && (!age.endsWith("+"))) {
                ok = false;
                warningMessage = bodmin.dataSection.lang.inpAgeInvalid;
            }
        }

        // if only +
        if (ok){
            if (age.trim() === '+') {
                ok = false;
                warningMessage = bodmin.dataSection.lang.inpAgeInvalid;
            }
        }

        // if pluses are ok...
        if (ok){

            let stop = age.length;
            if (firstPlus > -1) {
                stop = firstPlus;
            }
            // check formally correct age
            for(let i = 0; i < stop; i++){

                let charToTest = age.substr(i, 1);
                if (!aDigits.includes(charToTest)){
                    ok = false;
                    warningMessage = bodmin.dataSection.lang.inpAgeInvalid;
                }

            }


        }


        if (!ok) {
            bodmin.dataSection.ui.warningInpAge.text(warningMessage);
            bodmin.dataSection.ui.warningInpAge.toggleClass('mg-hide-element', false);
            bodmin.dataSection.ui.inpAge.focus();
        }

        if (ok){
            // now when we know taxa, and age - check and perhaps populate extra fields
            determineMeasurementFieldsVisibility();

        }

        return ok;

    }

    function validateStandardFields(){

        let ok = true;
        let allStandardFieldsWarnings = $('small[id^="warning-inp-"]');
        allStandardFieldsWarnings.text('');
        allStandardFieldsWarnings.toggleClass('mg-hide-element, true');

        $('input[id^="inp-"]').each(function() {
            ok = validateThisStandardField( $(this) );
        });

        return ok;

    }

    $(document).on('focusout', 'input[id^="inp-"]', function(/*event*/){
        validateThisStandardField($(this));
    });

    function validateThisStandardField(thisField){

        //inp-1
        //01234
        let measurementId = $(thisField).attr('id').substr(4,99);

        let thisFieldWarning = $('#warning-inp-' + measurementId);
        thisFieldWarning.text('');
        thisFieldWarning.toggleClass('mg-hide-element', true);

        let ok = true;
        if (thisField.val().length > 0) {

            ok = checkIfStringIsInteger(thisField.val());

            if (ok){

                // get max and min.
                const aMinMax = thisField.attr('placeholder').split('-');
                const min = parseInt(aMinMax[0]);
                const max = parseInt(aMinMax[1]);
                const nVal = parseInt(thisField.val());
                ok = ((nVal >= min) && (nVal <= max));

            }

        }

        if (!ok) {
            thisFieldWarning.text(thisField.attr('placeholder'));
            thisFieldWarning.toggleClass('mg-hide-element', false);
            thisField.focus();
        }

        return ok;

    }

    function getStandardFieldsTaxaDependentValidations(){

        return bodmin.allTaxaMeasurementsConfigs.filter(taxaMeasurementsConfig => taxaMeasurementsConfig.TAXA_ID === bodmin.currentTaxa.id);

    }

    function setEditButtonsOff(){

        bodmin.controlPanel.ui.btnEdit.prop('disabled', true);
        bodmin.controlPanel.ui.btnFinish.prop('disabled', true);
        bodmin.controlPanel.ui.btnRingCheck.prop('disabled', true);
        bodmin.controlPanel.ui.btnEffort.prop('disabled', true);

        if ((bodmin.selectedDate.ymd !== '') && (bodmin.selectedDate.asDate <= Date.now())){
            bodmin.controlPanel.ui.btnEdit.prop('disabled', false);
            bodmin.controlPanel.ui.btnRingCheck.prop('disabled', false);
            bodmin.controlPanel.ui.btnEffort.prop('disabled', false);
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
                    bodmin.cntrlPanel.ui.btnEdit.hide();
                    bodmin.cntrlPanel.ui.btnTranslations.hide();
                    bodmin.cntrlPanel.ui.btnDelete.hide();
                    bodmin.cntrlPanel.ui.btnNew.hide();

                    $('#editButtons').html('<br/><small>' + bodmin.lang.noPermission + '.<small>');
                    $('#info').text('');

                }

            }
        });

         */

    }

    bodmin.controlPanel.ui.btnEffort.click(function() {

    })

    function loadTaxaCodesAndValidationData(){

        bodmin.dataSection.arrayTaxaCodes = [];

        // get taxa codes and names. Keep the data for subsequent re-use.
        $.ajax({
            type:"GET",
            async: true,
            url: "../api/getTaxaData.php?lang=" + bodmin.lang.current,
            success: function(data) {

                bodmin.dataSection.ui.taxaNamesAndCodes = JSON.parse(data);

                for (let i = 0; i < bodmin.dataSection.ui.taxaNamesAndCodes.length; i++) {
                    bodmin.dataSection.ui.dataListTaxa.append('<option value="' + bodmin.dataSection.ui.taxaNamesAndCodes[i].SHORTNAME + '">');
                    bodmin.dataSection.arrayTaxaCodes.push(bodmin.dataSection.ui.taxaNamesAndCodes[i].SHORTNAME);
                }

            }
        });

        // get taxa validation data. Keep the data for subsequent re-use.
        $.ajax({
            type:"GET",
            async: true,
            url: "getTaxaValidationData.php",
            success: function(data) {
                bodmin.dataSection.ui.validationData = JSON.parse(data);
            }
        });

    }

    $(document).on("click", ".additional-measurement-row", function(){
        //btnRemoveMeasurementRow-1
        //0123456789012345678901234
        let idNo = $(this).attr('id').substring(24,99);
        $('#additional-measurement-row-' + idNo).remove();
    });

    $(document).on("click", ".btn-outline-danger", function(){

        //btnRemoveRow-1
        //1234567890123
        let idNo = $(this).attr('id').substring(13,99);

        let rowToHide = '#rings-row-' + idNo;
        $(rowToHide).toggleClass('mg-hide-element', true);

        let rows = $('div.mg-row');

        // find first visible row, and ensure labels are visible
        // they may already be so, but we run the same check always.
        let oneMore = true;
        rows.each(function( /*index*/ ) {

            let thisRow = $(this);

            if (!thisRow.hasClass('mg-hide-element')){
                let labels = thisRow.find('label');
                labels.toggleClass('mg-hide-element', false);
                oneMore = false;
            }

            return oneMore;
        });


    });

    bodmin.modalRings.ui.btnSave.click(function(){

        // S A V E

        let ok = true;
        bodmin.modalRings.ui.notUniqueText.text('');

        let allRowsToHandle = $('#ring-types-rows div.mg-row');
        let ringsRowsIds = [];
        let ringsRowsNos = [];

        allRowsToHandle.each(function (){

            let thisRow = $(this);
            if (!thisRow.hasClass('mg-hide-element')){

                // rings-row-2
                // 0123456678
                const id = thisRow.attr('id').substring(10,99);

                // build ArrayForUniqueCheck
                // ring types
                let s = ($('#slct-rings-' + id).val());
                ringsRowsIds.push(s);
                // ring numbers
                s = ($('#ring-no-' + id).val());
                ringsRowsNos.push(s);

            }
        });

        // check ring types - must be unique
        const uniqueRowsIds = [...new Set(ringsRowsIds)];
        if (uniqueRowsIds.length !== ringsRowsIds.length){
            bodmin.modalRings.ui.notUniqueText.text(bodmin.modalRings.lang.duplicateRingType);
            bodmin.modalRings.ui.divNotUnique.toggleClass('mg-hide-element', false);
            ok = false;
        }

        // check ring numbers - must be unique
        if (ok){
            const uniqueRowsNos = [...new Set(ringsRowsNos)];
            if (uniqueRowsNos.length !== ringsRowsNos.length){
                bodmin.modalRings.ui.notUniqueText.text(bodmin.modalRings.lang.duplicateRingNo);
                bodmin.modalRings.ui.divNotUnique.toggleClass('mg-hide-element', false);
                ok = false;
            }
        }

        if (ok){

            bodmin.modalRings.ui.window.modal('hide');

            bodmin.dataSection.spinnerArea.toggleClass('mg-hide-element', false);
            bodmin.dataSection.workingArea.toggleClass('mg-hide-element', true);

            let formData = new FormData();
            formData.append('location_id', bodmin.location);
            allRowsToHandle.each(function (){

                let thisRow = $(this);

                if (!thisRow.hasClass('mg-hide-element')){

                    const id = thisRow.attr('id').substring(10,99);

                    let name = 'slct-rings-' + id;
                    let val = $('#slct-rings-' + id).val();
                    formData.append(name, val);

                    name = 'ring-no-' + id;
                    val = $('#ring-no-' + id).val();
                    formData.append(name, val);

                }

            });

            $.ajax({
                url: "handleLocationRingTypeNumberData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    getRingsForLocation();
                }
            });


        }

    });

    function loadAllMeasurementsConfigurationData(){

        $.ajax({
            type: "get",
            url: "getAllTaxaMeasurementConfigurations.php",
            success: function (data) {
                bodmin.allTaxaMeasurementsConfigs = JSON.parse(data);
            },
            complete: function (){
                $.ajax({
                    type: "get",
                    url: "getStandardMeasurementsConfigurations.php?lang_id=" + bodmin.lang.current,
                    success: function (data) {
                        bodmin.standardMeasurementsConfigs = JSON.parse(data);
                    },
                    complete: function (){
                        datePickerSetup();
                    }
                });
            }
        });

    }

    function loadTaxaRingData(){
        $.ajax({
            type: "get",
            url: "getTaxaRingTypes.php",
            success: function (data) {
                bodmin.allRingData = JSON.parse(data);
            }
        });
    }

    function getRingsForLocation(){

        $.ajax({
            type: "get",
            async: true,
            url: "getLocalityRingTypesNumbers.php?locality_id=" +  bodmin.location,
            success: function(data) {
                bodmin.ringsUsed = JSON.parse(data);
                bodmin.dataSection.spinnerArea.toggleClass('mg-hide-element', true);
                bodmin.dataSection.workingArea.toggleClass('mg-hide-element', false);

            }
        });
    }

    // select row in the table
    $(document).on("click", "#data tbody tr", function(){

        // S E L E C T

        let toBeSelectedRow = $(this);

        // only possible to select when we are maintaining data and record has been saved
        if (( bodmin.controlPanel.mode === "dataManagementOngoing") && ( toBeSelectedRow.attr('ID') !== "not-set")){

            bodmin.dataSection.mode = 'edit';
            bodmin.mainTableId = toBeSelectedRow.attr('ID');
            bodmin.selectedRow = toBeSelectedRow;
            bodmin.selectedRow.siblings().removeClass('table-active');
            bodmin.selectedRow.addClass('table-active');

            setDataUserInterfaceAccordingToMode();
            emptyFields();

            let selectedRecord = bodmin.dataSection.ringedBirds.find(thisRecord => thisRecord.getId() === bodmin.mainTableId);
            bodmin.currentTaxa.id = selectedRecord.getTaxa_Id();

            // move data over to the "form"
            // first row
            bodmin.dataSection.ui.inpHour.val(selectedRecord.getHour());

            bodmin.dataSection.ui.inpSystematic.prop('checked', false);
            if (selectedRecord.getSystematic() === '1' ){
                bodmin.dataSection.ui.inpSystematic.prop('checked', true);
            }

            bodmin.dataSection.ui.ddTrappingMethod.val(selectedRecord.getTrapping_method_id());
            bodmin.dataSection.ui.inpObservation.val(selectedRecord.getObs());

            // second row
            bodmin.dataSection.ui.inpTaxa.val(bodmin.selectedRow.find("td").eq(1).text()) ;
            bodmin.dataSection.ui.inpRing.val(selectedRecord.getRingNo());
            bodmin.dataSection.ui.inpAge.val(selectedRecord.getAge());
            bodmin.dataSection.ui.inpSex.val(selectedRecord.getSex());

            // handle possible extra measurements
            // empty extra section and add perhaps new ones
            bodmin.dataSection.ui.moreMeasurementsSection.empty();
            bodmin.dataSection.ui.moreMeasurementsSection.toggleClass('mg-hide-element', true);
            bodmin.dataSection.ui.moreMeasurementsSection.append('<hr>');

            let aMeasurements = selectedRecord.getMeasurements();
            aMeasurements.forEach( function(aMeasurement){

                const measurementId = aMeasurement.getMeasurementId();
                const measurementName = aMeasurement.getMeasurementText();
                let value = aMeasurement.getValue();
                if (measurementId === '2'){

                    // if weight for this taxon is entered in deci-grams, convert it back to deci-grams
                    // pay attention to "not available" -1
                    if (bodmin.currentTaxa.decigrams === '1'){
                        if (value > 0){
                            value = value * 10;
                        }
                    }

                }

                if (value < '1') /* -1 used to indicate n.available. */{
                    value = '';
                }

                // check if we have a field for this measurementId laid out on the form (i.e. it is a standard measurement)
                // if so fill it out
                let field = $('#inp-' + measurementId);
                if (field.length) {
                    field.val(value);
                } else {
                    addOptionalMeasurement(measurementId, measurementName, value);
                }

            });

            bodmin.dataSection.ui.moreMeasurementsSection.toggleClass('mg-hide-element', (!aMeasurements.length > 0));


        }

    });


    function setDataUserInterfaceAccordingToMode(){

        if (bodmin.dataSection.mode === 'add'){

            bodmin.dataSection.ui.btnMoveOn.toggleClass('mg-hide-element', false);
            bodmin.dataSection.ui.dataEntrySectionHeader.text(bodmin.dataSection.lang.dataEntrySectionHeader);
            bodmin.dataSection.ui.editControls.toggleClass('mg-hide-element', true);

            bodmin.tabs.tabs( "enable");
            bodmin.dataTabs.tabs( "enable");

        }

        if (bodmin.dataSection.mode === 'edit'){

            bodmin.dataSection.ui.btnMoveOn.toggleClass('mg-hide-element', true);
            bodmin.dataSection.ui.dataEntrySectionHeader.text(bodmin.dataSection.lang.dataEntrySectionHeaderEdit);
            bodmin.dataSection.ui.editControls.toggleClass('mg-hide-element', false);

            bodmin.tabs.tabs( "option", "disabled", [ 1, 2, 3 ] );
            bodmin.dataTabs.tabs( "option", "disabled", [ 1, 2 ] );

        }

    }

    bodmin.dataSection.ui.btnRingingRecordCancel.click(function(){

        bodmin.dataSection.mode = 'add';
        emptyFields();
        bodmin.selectedRow.removeClass('table-active');
        setDataUserInterfaceAccordingToMode();

    });


    setDateTexts(bodmin.lang.current);

    // load all help data
    loadTaxaRingData();  // ring types per taxon
    loadAllMeasurementsConfigurationData();
    setLangTexts();
    loadTaxaCodesAndValidationData();

    bodmin.tabs.tabs();
    bodmin.dataTabs.tabs();
    bodmin.dataSection.ui.dataEntrySection.toggleClass('mg-hide-element', true);
    bodmin.dataSection.mode = 'add';
    bodmin.controlPanel.mode = "idle";
    bodmin.dataSection.spinnerArea.toggleClass('mg-hide-element', true);
    bodmin.dataSection.workingArea.toggleClass('mg-hide-element', false);

    setEditButtonsOff();


});