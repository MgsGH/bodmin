$(document).ready(function(){

    let bodmin = {

        cntrlPanel : {
            ui : {
                hdrMain : $('#hdrMain'),
                infoLabel : $('#infoLabel'),
                selectInfo : $('#selectInfo'),
                btnNew : $('#btnNew'),
                btnEdit : $('#btnEdit'),
                btnDelete : $('#btnDelete'),
                btnTranslations : $('#btnTranslations')
            }
        },

        table : {
            ui : {
                filterBox   : $('#tblFilterBox'),
                bodySection : $('#data tbody'),
                thName      : $('#thName'),
                thStandard  : $('#thStandard'),
                thDisplaySpecified  : $('#thDisplaySpecified'),
                thCommonValidation : $('#thCommonValidation'),
                thSortOrder : $('#thSortOrder')
            }
        },

        modalEditMeasurement : {
            ui : {
                window : $('#editMain'),
                header : $('#modalMainHeader'),
                sectionDelete : $('#modalMainDeleteSection'),
                sectionEdit : $('#modalMainEditSection'),

                checkBoxStandard : $('#checkBoxStandard'),
                labelCheckBoxStandard : $('#labelCheckBoxStandard'),

                // labels, fields and warnings
                lblInpName : $('#lblInpName'),
                inpName : $('#inpName'),
                warningInpName : $('#warning-inpname'),

                inpSortOrder : $('#inpSortOrder'),
                sectionSortOrder : $('#sectionSortOrder'),
                labelSortOrder : $('#labelSortOrder'),
                warningSortOrder : $('#warning-sortorder'),

                warningTextsAll : $("[id^='warning']"),
                warningDateFrom : $('#warningDateFrom'),
                warningDateTo : $('#warningDateTo'),

                ddSex: $('#slctSex'),
                labelSex : $('#labelSex'),

                labelAge : $('#labelAge'),
                ddAge: $('#slctAge'),

                ddMonth: $('#slctMonth'),
                labelMonths : $('#labelMonths'),
                warningMonths : $('#warning-months'),

                labelCheckBoxValByTaxon : $('#labelCheckBoxValByTaxon'),
                checkBoxCommonDisplay : $('#checkBoxCommonDisplay'),

                sectionMeasurementData : $('#sectionMeasurementData'),
                sectionStandardMatt : $('#sectionStandardMatt'),

                checkBoxCommonValidation : $('#checkBoxCommonValidation'),
                sectionMeasurementValidationData : $('#sectionMeasurementValidationData'),
                labelCheckBoxCommonValidation : $('#labelCheckBoxCommonValidation'),

                inpMin : $('#inpMin'),
                warningInpMin : $('#warning-inpMin'),
                labelMin : $('#labelMin'),

                inpMax : $('#inpMax'),
                warningInpMax : $('#warning-inpMax'),
                labelMax : $('#labelMax'),

                btnSave : $('#btnModalMainSave'),
                btnCancel : $('#btnModalMainCancel')
            }
        },

        modalTranslations : {
            ui : {
                window : $('#modalEditTranslation'),
                header : $('#modalTranslationsHeader'),
                warningTextsAll : $("small[id^='error-msg']"),
                translationsRows : $('#translation-rows'),
                lblModalTranslation : $('#lblModalTranslation-1'),
                lblModalLanguage : $('#lblModalLanguage-1'),
                notUniqueText : $('#languages-not-unique'),
                notUniqueSection : $('#div-not-unique'),
                btnAdd : $('#btnTranslationAdd'),
                btnSave : $('#btnTranslationsSave'),
                btnCancel : $('#btnTranslationsCancel')
            }
            // lang : defined below in setLangTexts
        },

        lang : {}

    };  //bodmin end

    //  select row in the table
    $(document).on("click", "#data tbody tr", function(){

        let selectedRow = $(this);

        if (selectedRow.hasClass('mg-table-row-data')){
            selectedRow = selectedRow.prev();
        }

        selectedRow.siblings().removeClass('table-active');
        selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        selectedRow.next().removeClass('mg-hide-element');

        $('button').prop('disabled', false);

        bodmin.mainTableId = selectedRow.attr('id');
        bodmin.name = $(selectedRow).find("td").eq(0).text();
        bodmin.cntrlPanel.ui.infoLabel.html(bodmin.cntrlPanel.lang.infoLabelVald + '<strong>' + bodmin.name + '</strong>') ;

        $('#info').html('Vald: <span id="fullName"><strong>' + bodmin.name + '</strong></span>');

        refreshTranslationSection();

    });


    // filter the table
    bodmin.table.ui.filterBox.on('input', function() {

        let value = $(this).val().toLowerCase();

        $("#data tbody tr").filter(function() {
            let hay = $(this).text();
            let currentRow = $(this);

            if (currentRow.hasClass('mg-table-row-data')){
                // The parent row this data belongs to may be filtered out. Hide it.
                currentRow.toggleClass('mg-hide-element', true);
            } else {
                currentRow.toggle(mgCheckFilterString(hay, value));
            }

        });

    });


    // ----------------------------------------------------------------------main table maintenance------------------
    bodmin.cntrlPanel.ui.btnNew.click( function(){

        bodmin.modalEditMeasurement.ui.header.text(bodmin.modalEditMeasurement.lang.headerNew);

        bodmin.modalEditMeasurement.action = "add";

        // set button texts
        bodmin.modalEditMeasurement.ui.btnCancel.text(bodmin.modalEditMeasurement.lang.btnCancel);
        bodmin.modalEditMeasurement.ui.btnSave.text(bodmin.modalEditMeasurement.lang.btnSave);

        // clear all potential error messages
        bodmin.modalEditMeasurement.ui.warningTextsAll.text('');

        // empty fields
        bodmin.modalEditMeasurement.ui.inpName.val('');
        bodmin.modalEditMeasurement.ui.inpName.addClass("focusedInput");

        // hide delete section and show edit
        bodmin.modalEditMeasurement.ui.sectionDelete.toggleClass('mg-hide-element', true);
        bodmin.modalEditMeasurement.ui.sectionEdit.toggleClass('mg-hide-element', false);

        // default edit section
        bodmin.modalEditMeasurement.ui.checkBoxStandard.prop('checked', false);
        bodmin.modalEditMeasurement.ui.sectionStandardMatt.toggleClass('mg-hide-element', true);

        bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.prop('checked', false);
        bodmin.modalEditMeasurement.ui.sectionMeasurementData.toggleClass('mg-hide-element', true);

        bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.prop('checked', false);
        bodmin.modalEditMeasurement.ui.section.toggleClass('mg-hide-element', true);

        bodmin.modalEditMeasurement.ui.window.modal('show');

    });


    bodmin.cntrlPanel.ui.btnEdit.click( function(){

        // clear all potential previous error messages
        bodmin.modalEditMeasurement.ui.warningTextsAll.text('');

        $.ajax({
            type:"get",
            url: "getMeasurementViaId.php?id=" + bodmin.mainTableId,
            success: function(data) {

                bodmin.modalEditMeasurement.ui.header.text(bodmin.modalEditMeasurement.lang.headerEdit);

                bodmin.modalEditMeasurement.action = "edit";

                bodmin.modalEditMeasurement.ui.btnCancel.text(bodmin.modalEditMeasurement.lang.btnCancel);
                bodmin.modalEditMeasurement.ui.btnSave.text(bodmin.modalEditMeasurement.lang.btnSave);

                // hide delete section and show edit
                bodmin.modalEditMeasurement.ui.sectionDelete.toggleClass('mg-hide-element', true);
                bodmin.modalEditMeasurement.ui.sectionEdit.toggleClass('mg-hide-element', false);

                let obj = JSON.parse(data);
                let measurement = obj[0];

                //populate edit form with gotten data
                bodmin.modalEditMeasurement.ui.inpName.val(measurement.TEXT);
                bodmin.modalEditMeasurement.ui.checkBoxStandard.prop('checked', measurement.STANDARD === '1');
                bodmin.modalEditMeasurement.ui.sectionStandardMatt.toggleClass('mg-hide-element', measurement.STANDARD !== '1');
                bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.prop('checked', measurement.DISP_SPEC === '1');
                bodmin.modalEditMeasurement.ui.sectionMeasurementData.toggleClass('mg-hide-element', measurement.DISP_SPEC !== '1');
                bodmin.modalEditMeasurement.ui.inpSortOrder.val(measurement.SORTORDER);
                bodmin.modalEditMeasurement.ui.ddSex.val(measurement.SEX);
                bodmin.modalEditMeasurement.ui.ddAge.val(measurement.AGE);

                let m = measurement.MONTHS;
                let aMonths = m.split(',');
                let months = [];

                for (let i = 0; i < 12; i++) {

                    let thisMonth = bodmin.modalEditMeasurement.ui.months[i];

                    let option = {};

                    let label = 'label';
                    option[label] = thisMonth["label"];

                    let title = 'title'
                    option[title] = thisMonth["title"];

                    let value = 'value'
                    option[value] = thisMonth["value"];

                    let selected = 'selected'

                    option[selected] = aMonths.includes(thisMonth.value);
                    months.push(option);

                }

                $('#slctMonth').multiselect('dataprovider', months);

                bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.prop('checked', measurement.VAL_COMMON === '1');
                bodmin.modalEditMeasurement.ui.sectionMeasurementValidationData.toggleClass('mg-hide-element', measurement.VAL_COMMON !== '1');
                bodmin.modalEditMeasurement.ui.inpMin.val(measurement.LOWERMIN);
                bodmin.modalEditMeasurement.ui.inpMax.val(measurement.UPPERMAX);

                bodmin.modalEditMeasurement.ui.window.modal('show');
                bodmin.modalEditMeasurement.ui.inpName.addClass("focusedInput");

            }
        });
    });


    bodmin.cntrlPanel.ui.btnDelete.click( function(){

        bodmin.modalEditMeasurement.ui.header.text(bodmin.modalEditMeasurement.lang.headerDelete);

        bodmin.modalEditMeasurement.action = "delete";

        bodmin.modalEditMeasurement.ui.btnSave.text(bodmin.modalEditMeasurement.lang.ja);
        bodmin.modalEditMeasurement.ui.btnCancel.text(bodmin.modalEditMeasurement.lang.nej);

        bodmin.modalEditMeasurement.ui.sectionDelete.toggleClass('mg-hide-element', false);
        bodmin.modalEditMeasurement.ui.sectionEdit.toggleClass('mg-hide-element', true);

        // populate delete section
        bodmin.modalEditMeasurement.ui.sectionDelete.html('<h6>' + bodmin.name + '</h6>');

        bodmin.modalEditMeasurement.ui.window.modal('show');

    });

    bodmin.modalEditMeasurement.ui.checkBoxStandard.change(function(){

        let newState = (! bodmin.modalEditMeasurement.ui.checkBoxStandard.prop('checked'));
        bodmin.modalEditMeasurement.ui.sectionStandardMatt.toggleClass('mg-hide-element', newState);

    });

    bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.change(function(){

        let newState = (! bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.prop('checked'));
        bodmin.modalEditMeasurement.ui.sectionMeasurementData.toggleClass('mg-hide-element', newState);

    });

    bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.change(function(){

        let newState = (! bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.prop('checked'));
        bodmin.modalEditMeasurement.ui.sectionMeasurementValidationData.toggleClass('mg-hide-element', newState);

    });

    bodmin.modalEditMeasurement.ui.btnSave.click(function(){

        // S A V E  M E A S U R E M E N T

        let ok = true;

        // Clear all potential error messages
        bodmin.modalEditMeasurement.ui.warningTextsAll.text('');

        if (( bodmin.modalEditMeasurement.action === "add") || ( bodmin.modalEditMeasurement.action === "edit") ) { // excluding delete

            // name cannot be blank
            ok = (bodmin.modalEditMeasurement.ui.inpName.val().length > 0);
            if (!ok) {
                bodmin.modalEditMeasurement.ui.warningInpName.text(bodmin.modalEditMeasurement.lang.warningInpName);
            }

            if (ok){
                ok = (bodmin.modalEditMeasurement.ui.inpSortOrder.val().length > 0);
                if (!ok) {
                    bodmin.modalEditMeasurement.ui.warningSortOrder.text(bodmin.modalEditMeasurement.lang.warningSortOrder);
                }
            }

            if (ok){
                ok = checkIfStringIsInteger(bodmin.modalEditMeasurement.ui.inpSortOrder.val());
                if (!ok) {
                    bodmin.modalEditMeasurement.ui.warningSortOrder.text(bodmin.modalEditMeasurement.lang.warningSortOrder);
                }
            }

            // fields below only shown when checkBoxValByTaxon is checked
            if (bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.prop('checked')){

                if (ok){
                    ok = (bodmin.modalEditMeasurement.ui.ddMonth.val().length > 0);
                    if (!ok) {
                        bodmin.modalEditMeasurement.ui.warningMonths.text(bodmin.modalEditMeasurement.lang.warningMonths);
                    }
                }

                if (ok){
                    ok = (bodmin.modalEditMeasurement.ui.inpMin.val().length > 0);
                    if (!ok) {
                        bodmin.modalEditMeasurement.ui.warningInpMin.text(bodmin.modalEditMeasurement.lang.warningMinMax);
                    }
                }

                if (ok){
                    ok = checkIfStringIsInteger(bodmin.modalEditMeasurement.ui.inpMin.val());
                    if (!ok) {
                        bodmin.modalEditMeasurement.ui.warningInpMin.text(bodmin.modalEditMeasurement.lang.warningMinMax);
                    }
                }

                if (ok){
                    ok = (bodmin.modalEditMeasurement.ui.inpMax.val().length > 0);
                    if (!ok) {
                        bodmin.modalEditMeasurement.ui.warningInpMax.text(bodmin.modalEditMeasurement.lang.warningMinMax);
                    }
                }


                if (ok){
                    ok = checkIfStringIsInteger(bodmin.modalEditMeasurement.ui.inpMax.val());
                    if (!ok) {
                        bodmin.modalEditMeasurement.ui.warningInpMax.text(bodmin.modalEditMeasurement.lang.warningMinMax);
                    }
                }

                if (bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.prop('checked')){

                    if (ok){
                        const integerMax = parseInt(bodmin.modalEditMeasurement.ui.inpMax.val());
                        const integerMin = parseInt(bodmin.modalEditMeasurement.ui.inpMin.val());
                        ok = ( integerMax > integerMin );
                        if (!ok) {
                            bodmin.modalEditMeasurement.ui.warningInpMax.text(bodmin.modalEditMeasurement.lang.warningMaxMustBeBigger);
                            bodmin.modalEditMeasurement.ui.warningInpMin.text(bodmin.modalEditMeasurement.lang.warningMaxMustBeBigger);
                        }
                    }

                }
            }

        }

        if (ok){

            let formData = new FormData();
            formData.append('mode', bodmin.modalEditMeasurement.action);

            if ((bodmin.modalEditMeasurement.action === "add") || (bodmin.modalEditMeasurement.action === "edit")) {
                formData.append('name', bodmin.modalEditMeasurement.ui.inpName.val());
                let standardMeasurement = 0;
                if (bodmin.modalEditMeasurement.ui.checkBoxStandard.prop('checked')){
                    standardMeasurement = 1;
                }
                formData.append('standard', standardMeasurement);
                formData.append('sortOrder', bodmin.modalEditMeasurement.ui.inpSortOrder.val());
                let val_common = '0';
                if (bodmin.modalEditMeasurement.ui.checkBoxCommonValidation.prop('checked')){
                    val_common = '1';
                }
                formData.append('val_common', val_common);

                let disp_common = '0';
                if (bodmin.modalEditMeasurement.ui.checkBoxCommonDisplay.prop('checked')){
                    disp_common = '1';
                }
                formData.append('disp_common', disp_common);

                let sex = bodmin.modalEditMeasurement.ui.ddSex.val();
                let age = bodmin.modalEditMeasurement.ui.ddAge.val();
                let months = bodmin.modalEditMeasurement.ui.ddMonth.val();
                if (disp_common === '0') /* same settings for all taxa */{
                    // set all fields to "all"
                    sex = 4;
                    age = 99;
                    months = '1,2,3,4,5,6,7,8,9,10,11,12';
                }
                formData.append('sex', sex);
                formData.append('age', age);
                formData.append('months', months);

                let min = bodmin.modalEditMeasurement.ui.inpMin.val();
                let max = bodmin.modalEditMeasurement.ui.inpMax.val();
                if (val_common === '0'){
                    min = 0;
                    max = 0;
                }
                formData.append('min', min);
                formData.append('max', max);

                bodmin.searchAfterUpdate = bodmin.modalEditMeasurement.ui.inpName.val();
            }

            if ((bodmin.modalEditMeasurement.action === "edit") || (bodmin.modalEditMeasurement.action === "delete")) {
                formData.append('id', bodmin.mainTableId);
            }

            if (bodmin.modalEditMeasurement.action === "delete") {
                bodmin.searchAfterUpdate = bodmin.searchTerm;
            }

            $.ajax({
                url: "handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (/* data, textStatus, jqXHR */) {
                    loadTable();
                }
            });

            bodmin.modalEditMeasurement.ui.window.modal('hide');

        }

    });


    //------------------------------------------------------------------------------T R A N S L A T I O N S-------------
    $(document).on("click", ".btn-outline-danger", function(){

        //btnRemoveRow-1
        //1234567890123
        let idNo = $(this).attr('id').substring(13,99);

        let rowToHide = '#translation-row-' + idNo;
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


    bodmin.cntrlPanel.ui.btnTranslations.click( function(){

        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header + ' ' + bodmin.name);

        bodmin.modalTranslations.ui.warningTextsAll.text('');

        bodmin.modalTranslations.ui.notUniqueSection.toggleClass('mg-hide-element', true);

        // restore to original state - one row div
        let rows = $('#translation-rows div.mg-row');
        let antalBoxar = rows.length;

        while (antalBoxar > 1){
            $('#translation-rows div.mg-row:nth-child(' + antalBoxar + ')').remove();
            antalBoxar --;
        }

        $('.varning').toggleClass("mg-hide-element", true);

        $('#not-unique').text('');

        // get earlier entered data
        $.ajax({
            type:"get",
            async: false,
            url: "getMeasurementTranslations.php?id=" +  bodmin.mainTableId,
            success: function(data) {

                let textsList = JSON.parse(data);

                //populate edit form, add new boxes as needed
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < textsList.length; i++) {

                    addTranslationRow();
                    $('#slct-lang-' + rowId).val(textsList[i].LANGUAGE);
                    $('#translation-' + rowId).val(textsList[i].TEXT);

                    rowId++;
                }

            }
        });

        bodmin.modalTranslations.ui.window.modal('show');

    });


    function addTranslationRow(){

        // clone the first (row)
        let newRow = $("#translation-row-1").clone();
        newRow.toggleClass('mg-hide-element', false);


        // Check how many boxes we have, so we can name the newly cloned one properly.
        let rows = $('#translation-rows div.mg-row').length;
        rows ++;
        newRow.attr('id', 'translation-row-' + rows);

        // turn off labels for all, but the very first row of fields.
        // 1 invisible (start) row + first data row, subsequent turned off
        if (rows > 2) {
            let labels = newRow.find('label');
            labels.toggleClass('mg-hide-element', true);
        }

        // re-id and rename the fields
        // drop down - language
        let field = newRow.find('#slct-lang-1');
        field.attr('id', 'slct-lang-' + rows);
        field.attr('name', 'slct-lang-' + rows);

        // input field - translation
        field = newRow.find('#translation-1');
        field.attr('id', 'translation-' + rows);
        field.attr('name', 'translation-' + rows);
        field.val('');
        // warning text for the input field
        field = newRow.find('#error-msg-1');
        field.attr('id', 'error-msg-' + rows);
        field.attr('name', 'error-msg-' + rows);

        let button = newRow.find('#btnRemoveRow-1');
        button.attr('id', 'btnRemoveRow-' + rows);
        button.attr('name', 'btnRemoveRow-' + rows);

        let theWarningText = newRow.find('#warning-item-1');
        theWarningText.attr('id', 'warning-item-' + rows);
        theWarningText.text('');

        newRow.appendTo(bodmin.modalTranslations.ui.translationsRows);

    }


    bodmin.modalTranslations.ui.btnAdd.click( function(){
        addTranslationRow();
    });


    function setEditButtonsOff(){

        bodmin.cntrlPanel.ui.btnEdit.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnTranslations.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnDelete.prop('disabled', true);

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

    }


    function getLangTexts() {

        // E N G E L S K A
        if (bodmin.lang.current === '1') {

            bodmin.lang.langAsString = 'en';

            // header info
            bodmin.lang.loggedinText = 'Logged in as ';
            bodmin.lang.logOutHere = "Log out here";


            // controlPanel on the left hand side
            bodmin.cntrlPanel.lang = {
                hdrMain         : 'Measurements',
                infoLabel       : 'Chose a measurement to activate the buttons',
                infoLabelVald   : 'Chosen: ',
                noPermission    : "You have insufficient user privileges to change data here.",
                btnNew          : "New measurement",
                btnEdit         : "Edit",
                btnDelete       : "Delete",
                btnTranslations : "Translations (name)"
            };

            // table
            bodmin.table.lang = {
            filterBoxPlaceHolder        : 'Filter measurements here',
                // headers
                thName                  : 'Internal name',
                thStandard              : 'All species',
                thDisplaySpecified      : 'Specified display rules',
                thCommonValidation      : 'Common validation',
                thSortOrder             : 'Sort order',
                tdYes                   : 'Yes',
                tdNo                    : ' - ',
                tblInTblHeader          : "Translations",
                tblInTblHeaderNoContent : "No translations done - yet"
            }

            bodmin.modalEditMeasurement.lang = {
                headerEdit            : 'Change measurement',
                headerNew             : 'New measurement',
                headerDelete          : 'Delete measurement?',
                // field labels
                lblInpName            : 'Name (internal)',
                warningInpName        : 'Name must be given',

                labelCheckBoxStandard : 'Standard measurement',
                labelCheckBoxValByTaxon : 'Specified display rules',

                labelSortOrder          : 'Display order (tab-order)',
                warningSortOrder        : 'Must be given - in digits, whole numbers',

                warningMonths           : 'At least one moth must be selected',

                warningMinMax           : 'Must be given - in digits, whole numbers',
                warningMaxMustBeBigger  : 'Max must be bigger than min',

                labelCheckBoxCommonValidation: 'Common validation rule for all taxa',
                labelSex                     : 'Sex',
                labelAge                     : 'Age',
                labelMonths                  : 'Months',
                labelMin                     : 'Min',
                labelMax                     : 'Max',

                ddMonthsAll                 : "full year",
                ddMonthsNoMonthsSelected    : " selected",
                ddMonthsNonSelectedText     : "Select",

                // button texts
                btnSave             : 'Save',
                btnCancel           : 'Cancel',
                ja                  : "Yes",
                nej                 : "No",
            }

            bodmin.modalTranslations.lang = {
                header: "Manage translations for ",
                btnAdd: "Add translation",
                btnSave: "Save",
                btnCancel: "Cancel",
                lblModalTranslation : "Translation",
                lblModalLanguage : "Language",
                frmValDoubleLanguages: "You have two translations in the same language.",
                frmValNoTranslation: "You have to give a translation for all languages."
            }

        }

        // S V E N S K A
        if (bodmin.lang.current === '2') {

            bodmin.lang.langAsString = 'se';

            // header info
            bodmin.lang.loggedinText = 'Inloggad som ';
            bodmin.lang.logOutHere = "Logga ut här";

            // controlPanel on the left hand side
            bodmin.cntrlPanel.lang = {
                hdrMain: 'Mått',
                infoLabel: 'Välj ett mått för att aktivera knapparna',
                infoLabelVald: 'Vald: ',
                noPermission: "Du har inte behörighet att ändra data här",
                btnNew: "Nytt mått",
                btnEdit: "Ändra",
                btnDelete: "Tag bort",
                btnTranslations: "Översättningar (Namn)"
            };

            // table
            bodmin.table.lang = {
                filterBoxPlaceHolder    : 'Filtrera data nedan här',
                thName                  : 'Internt namn',
                thStandard              : 'Standardmått',
                thDisplaySpecified      : 'Specificerad visning',
                thCommonValidation      : 'Gemensam valideringsregel',
                thSortOrder             : 'Visningsordning',
                tblInTblHeaderNoContent : "Inga översättningar gjorda än",
                tblInTblHeader          : "Översättningar"
            }

            bodmin.modalEditMeasurement.lang = {
                headerEdit          : 'Ändra mått',
                headerNew           : 'Nytt mått',
                headerDelete        : 'Tag bort mått?',
                // fields
                lblInpName          : 'Namn (internt)',
                warningInpName      : 'Namn måste anges',

                labelCheckBoxStandard   : 'Standardmått - visas för alla taxa',
                labelCheckBoxValByTaxon : 'Specificerad visningsregel för alla taxa',
                labelSortOrder          : 'Visningsordning (tab-ordning)',
                warningSortOrder        : 'Måste anges - i siffror',

                warningMonths           : 'Åtminstone en månad måste anges',

                warningMinMax           : 'Måste anges',
                warningMaxMustBeBigger  : 'Max måste vara större än min',

                labelSex                     : 'Kön',
                labelAge                     : 'Ålder',

                labelCheckBoxCommonValidation: 'Gemensam valideringsregel för alla taxa',
                labelMin                     : 'Min',
                labelMax                     : 'Max',

                labelMonths                  : 'Månader',
                ddMonthsAll                  : "Hela året",
                ddMonthsNoMonthsSelected     : " valda",
                ddMonthsNonSelectedText      : "Välj",

                // button texts
                btnSave             : 'Spara',
                btnCancel           : 'Avbryt',
                ja                  : "Ja",
                nej                 : "Nej"
            }

            bodmin.modalTranslations.lang = {
                header: "Hantera översättningar för ",
                btnAdd: "Lägg till översättning",
                lblModalTranslation : "Översättning",
                lblModalLanguage : "Språk",
                btnSave: "Spara",
                btnCancel: "Avbryt",
                frmValDoubleLanguages: "Du har två översättningar på samma språk.",
                frmValNoTranslation: "Du måste ange en översättning för alla språk."
            }

        }

    }


    function setLangTexts(){

        // set all texts
        $(document).attr('title', bodmin.lang.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);

        // top, top, header
        $('#loggedinText').text(bodmin.lang.loggedinText);

        if ($('#loggedInUserId').text() !== '0'){
            $('#loggedStatus').html('<a href="/loggedout/index.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>");
        }

        // left hand panel
        bodmin.cntrlPanel.ui.hdrMain.html(bodmin.cntrlPanel.lang.hdrMain);
        bodmin.cntrlPanel.ui.btnNew.text(bodmin.cntrlPanel.lang.btnNew);
        bodmin.cntrlPanel.ui.btnEdit.text(bodmin.cntrlPanel.lang.btnEdit);
        bodmin.cntrlPanel.ui.btnDelete.text(bodmin.cntrlPanel.lang.btnDelete);
        bodmin.cntrlPanel.ui.btnTranslations.text(bodmin.cntrlPanel.lang.btnTranslations);
        bodmin.cntrlPanel.ui.infoLabel.html(bodmin.cntrlPanel.lang.infoLabel);
        bodmin.cntrlPanel.ui.selectInfo.text(bodmin.cntrlPanel.lang.selectInfo);

        // main table
        bodmin.table.ui.filterBox.attr('placeholder', bodmin.table.lang.filterBoxPlaceHolder);
        bodmin.table.ui.thName.text(bodmin.table.lang.thName);
        bodmin.table.ui.thSortOrder.text(bodmin.table.lang.thSortOrder);
        bodmin.table.ui.thStandard.text(bodmin.table.lang.thStandard);
        bodmin.table.ui.thDisplaySpecified.text(bodmin.table.lang.thDisplaySpecified);
        bodmin.table.ui.thCommonValidation.text(bodmin.table.lang.thCommonValidation);

        // main modal
        bodmin.modalEditMeasurement.ui.lblInpName.text(bodmin.modalEditMeasurement.lang.lblInpName);
        bodmin.modalEditMeasurement.ui.labelCheckBoxValByTaxon.text(bodmin.modalEditMeasurement.lang.labelCheckBoxValByTaxon);
        bodmin.modalEditMeasurement.ui.labelCheckBoxStandard.text(bodmin.modalEditMeasurement.lang.labelCheckBoxStandard);
        bodmin.modalEditMeasurement.ui.labelSortOrder.text(bodmin.modalEditMeasurement.lang.labelSortOrder);
        bodmin.modalEditMeasurement.ui.labelSex.text(bodmin.modalEditMeasurement.lang.labelSex);
        bodmin.modalEditMeasurement.ui.labelAge.text(bodmin.modalEditMeasurement.lang.labelAge);
        bodmin.modalEditMeasurement.ui.labelMonths.text(bodmin.modalEditMeasurement.lang.labelMonths);
        bodmin.modalEditMeasurement.ui.labelCheckBoxCommonValidation.text(bodmin.modalEditMeasurement.lang.labelCheckBoxCommonValidation);
        bodmin.modalEditMeasurement.ui.labelMax.text(bodmin.modalEditMeasurement.lang.labelMax);
        bodmin.modalEditMeasurement.ui.labelMin.text(bodmin.modalEditMeasurement.lang.labelMin);

        // modal edit translations
        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header);
        bodmin.modalTranslations.ui.btnAdd.text(bodmin.modalTranslations.lang.btnAdd);
        bodmin.modalTranslations.ui.lblModalTranslation.text(bodmin.modalTranslations.lang.lblModalTranslation);
        bodmin.modalTranslations.ui.lblModalLanguage.text(bodmin.modalTranslations.lang.lblModalLanguage);
        bodmin.modalTranslations.ui.btnSave.text(bodmin.modalTranslations.lang.btnSave);
        bodmin.modalTranslations.ui.btnCancel.text(bodmin.modalTranslations.lang.btnCancel);

    }


    function loadTable() {

        let tmpHTML = '<tr><td colspan="5">' + mgGetImgSpinner() + '</td></tr>';
        bodmin.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"get",
            url: "getMeasurements.php",
            success: function(data) {

                let infoHTML = "";
                let tableData = JSON.parse(data);

                //create and populate the table rows
                for (let i = 0; i < tableData.length; i++) {
                    infoHTML = infoHTML + '<tr id="' + tableData[i]["ID"] + '">';
                    infoHTML = infoHTML + '<td>' + tableData[i]["TEXT"] + '</td>';
                    infoHTML = infoHTML + '<td class="text-center">' + formatBoolean(tableData[i]["STANDARD"]) + '</td>';
                    infoHTML = infoHTML + '<td class="text-center">' + formatBoolean(tableData[i]["DISP_SPEC"]) + '</td>';
                    infoHTML = infoHTML + '<td class="text-center">' + formatBoolean(tableData[i]["VAL_COMMON"]) + '</td>';
                    infoHTML = infoHTML + '<td>' + tableData[i]["SORTORDER"] + '</td>';
                    infoHTML = infoHTML + '</tr>';
                    infoHTML = infoHTML + mgGetDataRow(tableData[i]["ID"], 1);
                }
                bodmin.table.ui.bodySection.empty().append(infoHTML);
                setLangTexts();

            }
        });

    }


    function refreshTranslationSection(){

        let row = $('#dataFor-' + bodmin.mainTableId);
        row.empty().html('<td colspan="5">' + mgGetDataRow(999,4) + '</td>');

        $.get("getMeasurementTranslations.php?id=" + bodmin.mainTableId,
            function(data) {

                let translations = JSON.parse(data);

                let header = '<h6>' + bodmin.table.lang.tblInTblHeader + '</h6>';
                if (translations.length === 0){
                    header = '<h6>' + bodmin.table.lang.tblInTblHeaderNoContent +'</h6>';
                }
                let dataHTML = '<td colspan="5">' + header;

                // Populate the details section with all translations
                let translationTexts = "";
                for (let i = 0; i < translations.length; i++) {
                    translationTexts = translationTexts + '<span class="mg-80-span">' + translations[i].LANGUAGETEXT + '</span>' + translations[i].TEXT + '<br/>';
                }

                dataHTML = dataHTML + translationTexts + '</td>';
                row.empty().append(dataHTML);

            }
        );

    }


    bodmin.modalTranslations.ui.btnSave.click(function(){

        // S A V E

        bodmin.modalTranslations.ui.notUniqueText.text('');

        let allRowsToHandle = $('#translation-rows div.mg-row');
        let languageIds = [];
        allRowsToHandle.each(function (){

            let thisRow = $(this);
            // only visible (not deleted rows)
            if (!thisRow.hasClass('mg-hide-element')){

                // translation-row-1
                // 01234566789012345
                const id = thisRow.attr('id').substring(16,99);
                // build ArrayForUniqueCheck - languages
                let s = ($('#slct-lang-' + id).val());
                languageIds.push(s);

            }
        });


        // check no empty translation field
        let ok = true;
        allRowsToHandle.each(function (){
            let thisRow = $(this);
            // only visible (not deleted rows)
            if (!thisRow.hasClass('mg-hide-element')){

                // translation-row-1
                // 01234566789012345
                const id = thisRow.attr('id').substring(16,99);
                let s = ($('#translation-' + id).val());
                if (s.trim().length === 0){
                    ok = false;
                    $('#error-msg-'+ id).text(bodmin.modalTranslations.lang.frmValNoTranslation);
                    //bodmin.modalTranslations.ui.notUniqueSection.toggleClass('mg-hide-element', false);
                    return false;
                }

            }
        });


        // check languages - must be unique
        if (ok){
            const uniqueRowsNos = [...new Set(languageIds)];
            if (uniqueRowsNos.length !== languageIds.length){
                bodmin.modalTranslations.ui.notUniqueText.text(bodmin.modalTranslations.lang.frmValDoubleLanguages);
                bodmin.modalTranslations.ui.notUniqueSection.toggleClass('mg-hide-element', false);
                ok = false;
            }
        }

        if (ok){

            bodmin.modalTranslations.ui.window.modal('hide');

            let formData = new FormData();
            formData.append('trapping_method_id', bodmin.mainTableId);
            allRowsToHandle.each(function (){

                let thisRow = $(this);

                if (!thisRow.hasClass('mg-hide-element')){

                    const id = thisRow.attr('id').substring(16,99);

                    let val = $('#slct-lang-' + id).val();
                    let name = 'language-' + val;
                    val = $('#translation-' + id).val();
                    formData.append(name, val);

                }

            });

            $.ajax({
                url: "handleTranslationsData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    refreshTranslationSection()
                }
            });

        }

    });

    function populateModalDropDowns(){

        // m o n t h s
        $.ajax({
            type: "get",
            url: "getMonths.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let months = JSON.parse(data);
                bodmin.modalEditMeasurement.ui.months = [];

                for (let i = 0; i < months.length; i++) {
                    let option = {};

                    let label = 'label';
                    option[label] = months[i].TEXT;

                    let title = 'title'
                    option[title] = months[i].TEXT;

                    let value = 'value'
                    option[value] = months[i].MONTHNO;

                    let selected = 'selected'
                    option[selected] = true;
                    bodmin.modalEditMeasurement.ui.months.push(option);

                }

                console.log(bodmin.modalEditMeasurement.ui.months);

                bodmin.modalEditMeasurement.ui.ddMonth.multiselect({
                    includeSelectAllOption: true,
                    selectAllText: bodmin.modalEditMeasurement.lang.ddMonthsAll,
                    allSelectedText: bodmin.modalEditMeasurement.lang.ddMonthsAll,
                    nSelectedText: bodmin.modalEditMeasurement.lang.ddMonthsNoMonthsSelected,
                    buttonWidth: '120px',
                    nonSelectedText: 'Select'
                });
                bodmin.modalEditMeasurement.ui.ddMonth.multiselect('dataprovider', bodmin.modalEditMeasurement.ui.months);


            }
        });


        // s e x
        $.ajax({
            type: "get",
            url: "getSexes.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let sexes = JSON.parse(data);

                console.log(sexes);

                for (let i = 0; i < sexes.length; i++) {
                    bodmin.modalEditMeasurement.ui.ddSex.append($("<option></option>").attr("value",sexes[i].ID).text(sexes[i].TEXT));
                }

                bodmin.modalEditMeasurement.ui.ddSex.val('4');

            }

        });

        // a g e s
        $.ajax({
            type: "get",
            url: "getAgesForMeasurementOptions.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let ages = JSON.parse(data);

                for (let i = 0; i < ages.length; i++) {
                    bodmin.modalEditMeasurement.ui.ddAge.append($("<option></option>").attr("value",ages[i].AGE).text(ages[i].TEXT));
                }

                bodmin.modalEditMeasurement.ui.ddAge.val('99');

            }
        });

    }

    $('#action-info').fadeOut(6000);
    bodmin.lang.current = $('#systemLanguageId').text();
    getLangTexts();
    loadTable();
    setLangTexts();

    setEditButtonsOff();
    populateModalDropDowns();


});

