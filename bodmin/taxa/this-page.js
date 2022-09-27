$(document).ready(function(){

    // uses https://cdnjs.com/libraries/bootstrap-multiselect
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html

    let bodmin = {};

    bodmin.cntrlPanel = {
        ui : {
            hdrMain : $('#hdrMain'),
            infoLabel : $('#infoLabel'),
            selectInfo : $('#selectInfo'),
            btnNew : $('#btnNew'),
            btnEdit : $('#btnEdit'),
            btnDelete : $('#btnDelete'),
            btnTranslations : $('#btnTranslations'),
            btnRings : $('#btnRings'),
            btnCodes : $('#btnCodes'),
            btnMeasurements : $('#btnMeasurements')
        }
    };

    bodmin.table = {
        ui : {
            filterBox           : $('#tblFilterBox'),
            bodySection         : $('#data tbody'),
            thShortName         : $('#thShortName'),
            thScientific        : $('#thScientific'),
            thSysNo             : $('#thSysNo'),
            thDeciGrams         : $('#thDeciGrams')
        }
    };

    bodmin.modalEditTaxa = {
        ui : {
            window                  : $('#editMain'),
            header                  : $('#modalMainHeader'),
            sectionDelete           : $('#modalMainDeleteSection'),
            sectionEdit             : $('#modalMainEditSection'),

            // labels, fields and warnings
            warningTextsAll         : $("small[id^='warning']"),

            lblInpShortName         : $('#lblInpShortName'),
            inpShortName            : $('#inpShortName'),

            warningInpShortName     : $('#warningInpName'),

            lblInpScientific        : $('#lblInpScientific'),
            inpScientific           : $('#inpScientific'),
            warningInpScientific    : $('#warningInpScientific'),

            lblDropDownTaxa         : $('#lblDropDownTaxa'),
            slctTaxa                : $('#slctTaxa'),

            btnSave                 : $('#btnModalMainSave'),
            btnCancel               : $('#btnModalMainCancel'),

            cbDeciGrams             : $('#cbDeciGrams'),
            lblCbDeciGrams          : $('#lblDeciGrams')
        }
    };

    bodmin.modalTranslations = {
        ui : {
            window              : $('#modalEditTranslation'),
            header              : $('#modalTranslationsHeader'),
            warningTextsAll     : $("small[id^='error-msg']"),
            translationsRows    : $('#translation-rows'),
            lblModalTranslation : $('#lblModalTranslation-1'),
            lblModalLanguage    : $('#lblModalLanguage-1'),
            notUniqueText       : $('#languages-not-unique'),
            notUniqueSection    : $('#div-translation-not-unique'),
            btnAdd              : $('#btnTranslationAdd'),
            btnSave             : $('#btnTranslationsSave'),
            btnCancel           : $('#btnTranslationsCancel')
        }
        // lang : defined below in setLangTexts
    };

    bodmin.modalEditTaxaCodeTypes = {
        ui : {
            window              : $('#modalEditTaxaCodeTypes'),
            header              : $('#modalEditTaxaCodeTypeHeader'),
            divNotUnique        : $('#div-taxa-code-types-not-unique'),
            notUniqueText       : $('#taxa-code-types-not-unique'),
            warningTextsAll     : $("small[id^='error-msg-code-type']"),
            taxaCodeTypeRows    : $('#taxa-code-type-rows'),
            lblModalTaxaCodeTypeCode : $('#lblModalEditTaxaCodeTypes-TaxaCodeTypeCode-1'),
            lblModalTaxaCodeType     : $('#lblModalEditTaxaCodeTypes-TaxaCodeType-1'),
            //
            btnAdd              : $('#btnTaxaCodeTypeAdd'),
            btnSave             : $('#btnTaxaCodeTypesSave'),
            btnCancel           : $('#btnTaxaCodeTypesCancel')
        }
        // lang : defined below in setLangTexts
    };

    bodmin.modalMeasurements = {
        ui: {
            window: $('#modalEditMeasurements'),
            header: $('#modalMeasurementsHeader'),
            ddSex: $('#slctSex-1'),
            ddAge: $('#slctAge-1'),
            ddMonth: $('#slctMonth-1'),
            btnAdd: $('#btnMeasurementAdd'),
            btnSave: $('#btnMeasurementsSave'),
            btnCancel: $('#btnMeasurementsCancel'),
            measurementRows: $('#measurement-rows'),
            lblModalMeasurementsType: $('#lblModalMeasurementsType-1'),
            lblModalMeasurementsSex: $('#lblModalMeasurementsSex-1'),
            lblModalMeasurementsAge: $('#lblModalMeasurementsAge-1'),
            lblModalMeasurementsMonths: $('#lblModalMeasurementsMonths-1'),
            lblModalMeasurementsMin: $('#lblModalMeasurementsMin-1'),
            lblModalMeasurementsMax: $('#lblModalMeasurementsMax-1'),
            divNotUnique: $('#div-not-unique'),
            notUniqueText: $('#measurements-not-unique')
        }
    }    
        
    // lang : defined below in setLangTexts


    bodmin.modalRingTypes = {
        ui : {
            window              : $('#modalRingTypes'),
            header              : $('#modalRingTypesHeader'),
            divNotUnique        : $('#div-ring-types-not-unique'),
            notUniqueText       : $('#ring-types-not-unique'),
            warningTextsAll     : $("div[id^='div-warning-priority-']"),
            taxaCodeTypeRows    : $('#ring-type-rows'),
            lblModalRingType    : $('#lblRingType-1'),
            lblModalRingPriority: $('#lblModalRingPriority-1'),
            //
            btnAdd              : $('#btnRingTypeAdd'),
            btnSave             : $('#btnRingTypesSave'),
            btnCancel           : $('#btnRingTypesCancel')
        }
        
    };

    bodmin.lang = {};

    $(document).on("click", "#labelMeasurements", function(event){
        event.stopPropagation();
    });

    $(document).on("click", "#labelCodes", function(event){
        event.stopPropagation();
    });

    $(document).on("click", "#labelRings", function(event){
        event.stopPropagation();
    });

    $(document).on("click", "#labelTranslations", function(event){
        event.stopPropagation();
    });

    // select a row in the table
    $(document).on("click", "#data tbody tr", function(){

        let selectedRow = $(this);

        if (selectedRow.hasClass('mg-table-row-data')){
            selectedRow = selectedRow.prev();
        }

        let currentSortOrder = $(selectedRow).find("td").eq(2).text();

        if (currentSortOrder === '10' ){
            bodmin.previousSortOrder = 0;
        } else {
            let previousRow = selectedRow.prev();
            // dummy for skipping the data row
            previousRow = previousRow.prev();
            bodmin.previousSortOrder = $(previousRow).find("td").eq(2).text();
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

        refreshSubSection();



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


    function filterTable(value){

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

    }

    // -----------------------------------------------------------------------------main table maintenance--------------
    bodmin.cntrlPanel.ui.btnNew.click( function(){

        bodmin.modalEditTaxa.ui.header.text(bodmin.modalEditTaxa.lang.headerNew);

        bodmin.modalEditTaxa.action = "add";

        // set button texts
        bodmin.modalEditTaxa.ui.btnCancel.text(bodmin.modalEditTaxa.lang.btnCancel);
        bodmin.modalEditTaxa.ui.btnSave.text(bodmin.modalEditTaxa.lang.btnSave);

        // clear all potential error messages
        bodmin.modalEditTaxa.ui.warningTextsAll.text('');

        // empty fields
        bodmin.modalEditTaxa.ui.inpShortName.val('');
        bodmin.modalEditTaxa.ui.inpScientific.val('');

        // hide delete section and show edit
        bodmin.modalEditTaxa.ui.sectionDelete.toggleClass('mg-hide-element', true);
        bodmin.modalEditTaxa.ui.sectionEdit.toggleClass('mg-hide-element', false);

        bodmin.modalEditTaxa.ui.window.modal('show');

    });

    bodmin.cntrlPanel.ui.btnEdit.click( function(){

        // clear all potential previous error messages
        bodmin.modalEditTaxa.ui.warningTextsAll.text('');

        $.ajax({
            type:"get",
            url: "getTaxaViaId.php?id=" + bodmin.mainTableId,
            success: function(data) {

                bodmin.modalEditTaxa.ui.header.text(bodmin.modalEditTaxa.lang.headerEdit);

                bodmin.modalEditTaxa.action = "edit";

                bodmin.modalEditTaxa.ui.btnCancel.text(bodmin.modalEditTaxa.lang.btnCancel);
                bodmin.modalEditTaxa.ui.btnSave.text(bodmin.modalEditTaxa.lang.btnSave);

                // hide delete section and show edit
                bodmin.modalEditTaxa.ui.sectionEdit.toggleClass('mg-hide-element', false);
                bodmin.modalEditTaxa.ui.sectionDelete.toggleClass('mg-hide-element', true);

                let obj = JSON.parse(data);
                let taxa = obj[0];

                //populate edit form with gotten data
                bodmin.modalEditTaxa.ui.cbDeciGrams.prop('checked', false);
                if (taxa.DECIGRAMS === '1') {
                    bodmin.modalEditTaxa.ui.cbDeciGrams.prop('checked', true);
                }
                bodmin.modalEditTaxa.ui.inpShortName.val(taxa.SHORTNAME);
                bodmin.modalEditTaxa.ui.inpScientific.val(taxa.SCINAME);

                bodmin.modalEditTaxa.ui.slctTaxa.val(bodmin.previousSortOrder);
                bodmin.modalEditTaxa.ui.slctTaxa.change();

                bodmin.modalEditTaxa.ui.window.modal('show');

            }
        });
    });

    bodmin.cntrlPanel.ui.btnDelete.click( function(){

        bodmin.modalEditTaxa.ui.header.text(bodmin.modalEditTaxa.lang.headerDelete);

        bodmin.modalEditTaxa.action = "delete";

        bodmin.modalEditTaxa.ui.btnSave.text(bodmin.modalEditTaxa.lang.ja);
        bodmin.modalEditTaxa.ui.btnCancel.text(bodmin.modalEditTaxa.lang.nej);

        bodmin.modalEditTaxa.ui.sectionDelete.toggleClass('mg-hide-element', false);
        bodmin.modalEditTaxa.ui.sectionEdit.toggleClass('mg-hide-element', true);

        // populate delete section
        bodmin.modalEditTaxa.ui.sectionDelete.html('<h6>' + bodmin.name + '</h6>');

        bodmin.modalEditTaxa.ui.window.modal('show');

    });

    bodmin.modalEditTaxa.ui.btnSave.click(function(){

        let ok = true;

        // clear all potential error messages
        bodmin.modalEditTaxa.ui.warningTextsAll.text('');

        if (( bodmin.modalEditTaxa.action === "add") || ( bodmin.modalEditTaxa.action === "edit") ) { // excluding delete

            // name cannot be blank
            ok = (bodmin.modalEditTaxa.ui.inpShortName.val().length > 0);
            if (!ok) {
                bodmin.modalEditTaxa.ui.warningInpShortName.text(bodmin.modalEditTaxa.lang.warningInpName);
            }

        }


        if (ok){

            let formData = new FormData();
            formData.append('mode', bodmin.modalEditTaxa.action);

            if ((bodmin.modalEditTaxa.action === "add") || (bodmin.modalEditTaxa.action === "edit")) {

                let tmp = parseInt(bodmin.modalEditTaxa.ui.slctTaxa.val())
                tmp = tmp + 5;
                tmp = tmp.toString();

                formData.append('snr',  tmp);
                formData.append('shortName', bodmin.modalEditTaxa.ui.inpShortName.val());
                formData.append('scientificName', bodmin.modalEditTaxa.ui.inpScientific.val());

                let deciGrams = 0;

                if (bodmin.modalEditTaxa.ui.cbDeciGrams.prop('checked')) {
                    deciGrams = 1;
                }
                formData.append('deciGrams',  deciGrams);

                bodmin.searchAfterUpdate = bodmin.modalEditTaxa.ui.inpShortName.val();
            }

            if ((bodmin.modalEditTaxa.action === "edit") || (bodmin.modalEditTaxa.action === "delete")) {
                formData.append('taxa_id', bodmin.mainTableId);
            }

            if (bodmin.modalEditTaxa.action === "delete") {
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
                    refreshTaxaDropDown();
                }
            });

            bodmin.modalEditTaxa.ui.window.modal('hide');

        }

    });


    //------------------------------------------------------------------------------T R A N S L A T I O N S-------------
    bodmin.cntrlPanel.ui.btnTranslations.click( function(){

        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header + ' ' + bodmin.name);

        bodmin.modalTranslations.ui.warningTextsAll.text('');

        bodmin.modalTranslations.ui.notUniqueSection.toggleClass('mg-hide-element', true);

        // restore to original state - one (invisble) row div
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
            url: "getTaxaTranslations.php?id=" +  bodmin.mainTableId,
            success: function(data) {

                let translations = JSON.parse(data);

                //Add new boxes as needed and populate the edit form.
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < translations.length; i++) {

                    addTranslationRow();
                    $('#slct-lang-' + rowId).val(translations[i].LANGUAGE_ID);
                    $('#translation-' + rowId).val(translations[i].TEXT);

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

    $(document).on("click", ".mg-delete-translation-row", function(){

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

    bodmin.modalTranslations.ui.window.on("click","input[type='checkbox']",function(){
        //changeItemBoxStatus($(this));
        let theId = $(this).attr('id');

        // expected (example): cb-item-1, extract the digit(s) at the end
        theId = theId.substr(8, theId.length-8);

        // now select the corresponding input box
        let theItemBox = $('#id-input-item-' + theId);

        // flip disabled
        let enabled = theItemBox.prop("disabled");
        let newStatus = !enabled;

        let theItemSelectBox = $('#id-select-item-' + theId);
        theItemBox.prop("disabled", newStatus);
        theItemSelectBox.prop("disabled", newStatus);
    });


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
            formData.append('taxa_id', bodmin.mainTableId);
            allRowsToHandle.each(function (){

                let thisRow = $(this);

                if (!thisRow.hasClass('mg-hide-element')){

                    const id = thisRow.attr('id').substring(16,99);

                    let val = $('#slct-lang-' + id).val();
                    name = 'language-' + val;
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
                    refreshTranslationsTab();
                }
            });

        }

    });



    bodmin.modalTranslations.ui.btnAdd.click( function(){
        addTranslationRow();
    });


    //------------------------------------------------------------------------------M E A S U R E M E N T S-------------
    bodmin.cntrlPanel.ui.btnMeasurements.click( function(){

        bodmin.modalMeasurements.ui.header.text(bodmin.modalMeasurements.lang.header + ' ' + bodmin.name);
        bodmin.modalMeasurements.ui.divNotUnique.toggleClass('mg-hide-element', true);

        // restore to original state - one row div
        let rows = $('#measurement-rows div.mg-row');
        let antalBoxar = rows.length;

        while (antalBoxar > 1){
            $('#measurement-rows div.mg-row:nth-child(' + antalBoxar + ')').remove();
            antalBoxar --;
        }

        $('.varning').toggleClass("mg-hide-element", true);

        // get earlier entered data
        $.ajax({
            type:"get",
            async: false,
            url: "getMeasurementsConfigDataForTaxa.php?taxa_id=" +  bodmin.mainTableId,
            success: function(data) {

                let taxaConfigs = JSON.parse(data);

                //populate edit form, add new boxes as needed
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < taxaConfigs.length; i++) {

                    addMeasurementSection();
                    $('#slct-measurements-' + rowId).val(taxaConfigs[i].MEASUREMENT_ID);
                    $('#slct-sex-' + rowId).val(taxaConfigs[i].SEX_ID);
                    $('#slct-age-' + rowId).val(taxaConfigs[i].AGE_ID);

                    let m = taxaConfigs[i].MONTHS;
                    let aMonths = m.split(',');
                    let months = [];


                    for (let i = 0; i < 12; i++) {

                        let thisMonth = bodmin.modalMeasurements.ui.months[i];

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

                    $('#slct-month-' + rowId).multiselect('dataprovider', months);


                    $('#id-min-' + rowId).val(taxaConfigs[i].LOWERMIN);
                    $('#id-max-' + rowId).val(taxaConfigs[i].UPPERMAX);
                    rowId++;
                }

            }
        });

        bodmin.modalMeasurements.ui.window.modal('show');

    });

    bodmin.modalMeasurements.ui.btnAdd.click( function(){
        addMeasurementSection();
    });

    function addMeasurementSection(){

        // clone the first (row)
        let newRow = $("#measurements-row-1").clone();
        newRow.toggleClass('mg-hide-element', false);

        // Check how many boxes we have, so we can name the newly cloned one properly.
        let rows = $('#measurement-rows div.mg-row').length;
        rows ++;
        newRow.attr('id', 'measurements-row-' + rows);

        // turn off labels for all, but the very first row of fields.
        // 1 invisible (start) row + first data row, subsequent turned off
        if (rows > 2) {
            let labels = newRow.find('label');
            labels.toggleClass('mg-hide-element', true);

        }

        // re-id and rename the fields
        let field = newRow.find('#slct-measurements-1');
        field.attr('id', 'slct-measurements-' + rows);
        field.attr('name', 'name-slct-measurements-' + rows);
        field.val('1');

        field = newRow.find('#slctSex-1');
        field.attr('id', 'slct-sex-' + rows);
        field.attr('name', 'name-slct-sex-' + rows);
        field.val('4');

        field = newRow.find('#slctAge-1');
        field.attr('id', 'slct-age-' + rows);
        field.attr('name', 'name-slct-age-' + rows);
        field.val('99');


        field = newRow.find('#slctMonth-1');
        field.multiselect({
            includeSelectAllOption: true,
            selectAllText: bodmin.modalMeasurements.lang.ddMonthsAll,
            allSelectedText: bodmin.modalMeasurements.lang.ddMonthsAll,
            nSelectedText: bodmin.modalMeasurements.lang.ddMonthsNoMonthsSelected,
            buttonWidth: '120px',
            nonSelectedText: 'Select'
        });
        field.multiselect('dataprovider', bodmin.modalMeasurements.ui.months);
        field.attr('id', 'slct-month-' + rows);
        field.attr('name', 'name-slct-month-' + rows);

        field = newRow.find('#id-min-1');
        field.attr('id', 'id-min-' + rows);
        field.attr('name', 'name-min-' + rows);
        field.val('0');
        field = newRow.find('#warning-min-1');
        field.attr('id', 'warning-min-' + rows);

        field = newRow.find('#id-max-1');
        field.attr('id', 'id-max-' + rows);
        field.attr('name', 'name-max-' + rows);
        field.val('0');
        field = newRow.find('#warning-max-1');
        field.attr('id', 'warning-max-' + rows);

        field = newRow.find('#div-warning-min-1');
        field.attr('id', 'div-warning-min-' + rows);

        field = newRow.find('#div-warning-max-1');
        field.attr('id', 'div-warning-max-' + rows);

        field = newRow.find('#btnRemoveRow-1');
        field.attr('id', 'btnRemoveRow-' + rows);
        field.attr('name', 'btnRemoveRow-' + rows);


        let theWarningText = newRow.find('#warning-item-1');
        theWarningText.attr('id', 'warning-item-' + rows);
        theWarningText.text('');

        newRow.appendTo(bodmin.modalMeasurements.ui.measurementRows);


    }

    bodmin.modalMeasurements.ui.btnSave.click(function(){

        let ok = true;

        let allRowsToHandle = $('#measurement-rows div.mg-row');
        let measurementsRowsIds = [];

        allRowsToHandle.each(function (){

            let thisRow = $(this);
            if (!thisRow.hasClass('mg-hide-element')){

                const id = thisRow.attr('id').substring(17,99);

                // turn off (potentially) earlier warnings
                let warningDivMin = '#div-warning-min-' + id;
                let warningDivMax = '#div-warning-max-' + id;
                $(warningDivMin).toggleClass('mg-hide-element', true);
                $(warningDivMax).toggleClass('mg-hide-element', true);

                // build ArrayForUniqueCheck
                let s = '';
                s = s + ($('#slct-measurements-' + id).val());
                s = s + ($('#slct-age-' + id).val());
                s = s + ($('#slct-sex-' + id).val());
                s = s + ($('#slct-month-' + id).val());
                measurementsRowsIds.push(s);

                // check that we have correct min/max in all rows AND that max > min
                let minBox = '#id-min-' + id;
                let minValue = mgFilterInt($(minBox).val());
                let warningTextMin = '#warning-min-' + id;
                if (isNaN(minValue)){
                    ok = false;
                    $(warningTextMin).text(bodmin.modalMeasurements.lang.invalidNumber);
                    $(warningDivMin).toggleClass('mg-hide-element', false);
                }

                let maxBox = '#id-max-' + id;
                let maxValue = mgFilterInt($(maxBox).val());
                let warningTextMax = '#warning-max-' + id;
                if (isNaN(maxValue)){
                    ok = false;
                    $(warningTextMax).text(bodmin.modalMeasurements.lang.invalidNumber);
                    $(warningDivMax).toggleClass('mg-hide-element', false);
                }

                if (ok) {
                    if (minValue >= maxValue){
                        ok = false;
                        $(warningTextMin).text(bodmin.modalMeasurements.lang.minSmaller);
                        $(warningTextMax).text(bodmin.modalMeasurements.lang.thanMax);
                        $(warningDivMin).toggleClass('mg-hide-element', false);
                        $(warningDivMax).toggleClass('mg-hide-element', false);
                    }
                }

            }
        });


        const uniqueMeasurementsRowsIds = [...new Set(measurementsRowsIds)];

        if (uniqueMeasurementsRowsIds.length !== measurementsRowsIds.length){

            bodmin.modalMeasurements.ui.divNotUnique.toggleClass('mg-hide-element', false);
            bodmin.modalMeasurements.ui.notUniqueText.text(bodmin.modalMeasurements.lang.duplicateData);
            ok = false;
        }

        if (ok){

            bodmin.modalMeasurements.ui.window.modal('hide');
            let formData = new FormData();
            formData.append('taxa_id', bodmin.mainTableId);
            allRowsToHandle.each(function (){

                let thisRow = $(this);

                if (!thisRow.hasClass('mg-hide-element')){

                    const id = thisRow.attr('id').substring(17,99);

                    let name = 'slct-measurements-' + id;
                    let val = $('#slct-measurements-' + id).val();
                    formData.append(name, val);

                    name = 'slct-sex-' + id;
                    val = $('#slct-sex-' + id).val();
                    formData.append(name, val);

                    name = 'slct-age-' + id;
                    val = $('#slct-age-' + id).val();
                    formData.append(name, val);

                    name = 'slct-month-' + id;
                    val = $('#slct-month-' + id).val();
                    formData.append(name, val);

                    name = '#id-min-' + id;
                    val = $('#id-min-' + id).val();
                    formData.append(name, val);

                    name = '#id-max-' + id;
                    val = $('#id-max-' + id).val();
                    formData.append(name, val);

                }

            });

            $.ajax({
                url: "handleMeasurementsData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    refreshMeasurementsTab();
                }
            });


        }



    });

    $(document).on("click", ".mg-delete-measurement-row", function(){

        //btnRemoveRow-1
        //1234567890123
        let idNo = $(this).attr('id').substring(13,99);
        let rowToHide = '#measurements-row-' + idNo;
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


    //------------------------------------------------------------------------------T A X A C O D E S-------------------
    bodmin.cntrlPanel.ui.btnCodes.click( function(){

        bodmin.modalEditTaxaCodeTypes.ui.header.text(bodmin.modalEditTaxaCodeTypes.lang.header + ' ' + bodmin.name);

        bodmin.modalEditTaxaCodeTypes.ui.notUniqueText.text('');
        bodmin.modalEditTaxaCodeTypes.ui.divNotUnique.toggleClass('mg-hide-element', true);

        // restore to original state - one row div
        let rows = $('#taxa-code-type-rows div.mg-row');
        let antalBoxar = rows.length;

        while (antalBoxar > 1){
            $('#taxa-code-type-rows div.mg-row:nth-child(' + antalBoxar + ')').remove();
            antalBoxar --;
        }


        // get earlier entered data
        $.ajax({
            type:"get",
            async: false,

            url: "getTaxaCodesData.php?taxa_id=" +  bodmin.mainTableId + '&lang_id=' + bodmin.lang.current,
            success: function(data) {

                let rows = JSON.parse(data);

                //populate edit form, add new boxes as needed
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < rows.length; i++) {

                    addTaxaCodeTypeRow();
                    $('#slct-code-type-' + rowId).val(rows[i].TAXACODE_TYPE_ID);
                    $('#code-' + rowId).val(rows[i].CODE);

                    rowId++;
                }

            }
        });

        bodmin.modalEditTaxaCodeTypes.ui.window.modal('show');

    });


    bodmin.modalEditTaxaCodeTypes.ui.btnAdd.click( function(){
        addTaxaCodeTypeRow();
    });

    function addTaxaCodeTypeRow(){

        // clone the first (row)
        let newRow = $("#taxa-code-type-row-1").clone();
        newRow.toggleClass('mg-hide-element', false);


        // Check how many boxes we have, so we can name the newly cloned one properly.
        let rows = $('#taxa-code-type-rows div.mg-row').length;
        rows ++;
        newRow.attr('id', 'taxa-code-type-row-' + rows);

        // turn off labels for all, but the very first row of fields.
        // 1 invisible (start) row + first data row, subsequent turned off
        if (rows > 2) {
            let labels = newRow.find('label');
            labels.toggleClass('mg-hide-element', true);
        }

        // re-id and rename the fields
        // drop down - code type
        let field = newRow.find('#slct-code-type-1');
        field.attr('id', 'slct-code-type-' + rows);
        field.attr('name', 'slct-code-type-' + rows);

        // input field - code
        field = newRow.find('#code-1');
        field.attr('id', 'code-' + rows);
        field.attr('name', 'code-' + rows);
        field.val('');
        // warning text for the input field
        field = newRow.find('#error-msg-code-type-1');
        field.attr('id', 'error-msg-code-type-' + rows);
        field.attr('name', 'error-msg-code-type-' + rows);

        let button = newRow.find('#btnRemoveRow-1');
        button.attr('id', 'btnRemoveRow-' + rows);
        button.attr('name', 'btnRemoveRow-' + rows);

        let theWarningText = newRow.find('#warning-code-type-1');
        theWarningText.attr('id', 'warning-code-type-' + rows);
        theWarningText.text('');

        newRow.appendTo(bodmin.modalEditTaxaCodeTypes.ui.taxaCodeTypeRows);

    }

    $(document).on("click", ".mg-delete-code-type-row", function(){

        //btnRemoveRow-1
        //1234567890123
        let idNo = $(this).attr('id').substring(13,99);
        let rowToHide = '#taxa-code-type-row-' + idNo;
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


    bodmin.modalEditTaxaCodeTypes.ui.btnSave.click(function(){

    // S A V E

    let allRowsToHandle = $('#taxa-code-type-rows div.mg-row');
    let taxaCodesIds = [];
    allRowsToHandle.each(function (){

        let thisRow = $(this);
        // only visible (not deleted rows)
        if (!thisRow.hasClass('mg-hide-element')){

            // taxa-code-type-row-1
            // 01234566789012345678
            const id = thisRow.attr('id').substring(19,99);
            // build ArrayForUniqueCheck - languages
            let s = ($('#slct-code-type-' + id).val());
            taxaCodesIds.push(s);

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
            const id = thisRow.attr('id').substring(19,99);
            let s = ($('#code-' + id).val());
            if (s.trim().length === 0){
                ok = false;

                let tmp = $('#warning-code-type-'+ id)
                tmp.html('<small>' +  bodmin.modalEditTaxaCodeTypes.lang.frmValNoCode + '</small>');
                tmp.toggleClass('mg-hide-element', false);
                return false;
            }

        }
    });


    // check code types - must be unique
    if (ok){
        const uniqueRowsNos = [...new Set(taxaCodesIds)];
        if (uniqueRowsNos.length !== taxaCodesIds.length){
            bodmin.modalEditTaxaCodeTypes.ui.notUniqueText.text(bodmin.modalEditTaxaCodeTypes.lang.frmValDoubleCodes);
            bodmin.modalEditTaxaCodeTypes.ui.divNotUnique.toggleClass('mg-hide-element', false);
            ok = false;
        }
    }

    if (ok){

        bodmin.modalEditTaxaCodeTypes.ui.window.modal('hide');

        let formData = new FormData();
        formData.append('taxa_id', bodmin.mainTableId);
        allRowsToHandle.each(function (){

            let thisRow = $(this);

            if (!thisRow.hasClass('mg-hide-element')){

                const id = thisRow.attr('id').substring(19,99);

                let val = $('#slct-code-type-' + id).val();
                name = 'taxaCodeType-' + val;
                val = $('#code-' + id).val();
                formData.append(name, val);

            }

        });

        $.ajax({
            url: "handleTaxaCodeData.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'POST',
            success: function() {
                refreshCodesTab();
            }
        });

    }

});


    //--------------------------------------------------------------------------- R I N G T Y P E S --------------------
    bodmin.cntrlPanel.ui.btnRings.click( function(){

        bodmin.modalRingTypes.ui.header.text(bodmin.modalRingTypes.lang.header + ' ' + bodmin.name);

        bodmin.modalRingTypes.ui.notUniqueText.text('');
        bodmin.modalRingTypes.ui.divNotUnique.toggleClass('mg-hide-element', true);

        // restore to original state - one row div
        let rows = $('#ring-type-rows div.mg-row');
        let antalBoxar = rows.length;

        while (antalBoxar > 1){
            $('#ring-type-rows div.mg-row:nth-child(' + antalBoxar + ')').remove();
            antalBoxar --;
        }


        // get earlier entered data
        $.ajax({
            type:"get",
            async: false,

            url: "getTaxaRingTypes.php?taxa_id=" +  bodmin.mainTableId,
            success: function(data) {

                let rows = JSON.parse(data);

                //populate edit form, add new boxes as needed
                let rowId = 2; // 1 already present (hidden)
                for (let i = 0; i < rows.length; i++) {
                    addRingTypeRow();
                    $('#slct-ring-type-' + rowId).val(rows[i].RING_TYPE_ID);
                    $('#inpPrioritet-' + rowId).val(rows[i].PRIO);

                    rowId++;
                }

            }
        });

        bodmin.modalRingTypes.ui.window.modal('show');

    });

    bodmin.modalRingTypes.ui.btnAdd.click( function(){
        addRingTypeRow();
    });

    function addRingTypeRow(){

        bodmin.modalRingTypes.ui.warningTextsAll.html('');
        bodmin.modalRingTypes.ui.warningTextsAll.toggleClass('mg-hide-element', true);

        // clone the first (row)
        let newRow = $("#ring-type-row-1").clone();
        newRow.toggleClass('mg-hide-element', false);


        // Check how many boxes we have, so we can name the newly cloned one properly.
        let rows = $('#ring-type-rows div.mg-row').length;
        rows ++;
        newRow.attr('id', 'ring-type-row-' + rows);

        // turn off labels for all, but the very first row of fields.
        // 1 invisible (start) row + first data row, subsequent turned off
        if (rows > 2) {
            let labels = newRow.find('label');
            labels.toggleClass('mg-hide-element', true);
        }

        // re-id and rename the fields
        // drop down - ring type
        let field = newRow.find('#slct-ring-type-1');
        field.attr('id', 'slct-ring-type-' + rows);


        // input priortiy
        field = newRow.find('#inpPrioritet-1');
        field.attr('id', 'inpPrioritet-' + rows);


        let button = newRow.find('#btnRemoveRow-1');
        button.attr('id', 'btnRemoveRow-' + rows);
        button.attr('name', 'btnRemoveRow-' + rows);

        let theWarningText = newRow.find('#warning-code-type-1');
        theWarningText.attr('id', 'warning-code-type-' + rows);
        theWarningText.text('');

        newRow.appendTo(bodmin.modalRingTypes.ui.taxaCodeTypeRows);

    }


    $(document).on("click", ".mg-delete-ring-type-row", function(){

        //btnRemoveRow-1
        //1234567890123
        let idNo = $(this).attr('id').substring(13,99);
        let rowToHide = '#ring-type-row-' + idNo;
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


    bodmin.modalRingTypes.ui.btnSave.click(function(){

        // S A V E
        bodmin.modalRingTypes.ui.warningTextsAll.html('');
        bodmin.modalRingTypes.ui.warningTextsAll.toggleClass('mg-hide-element', true);

        let allRowsToHandle = $('#ring-type-rows div.mg-row');
        let ok = true;
        let warningMessage = '';

        // validate input - all fields in all rows.

        allRowsToHandle.each(function (){

            let thisRow = $(this);
            // only visible (not deleted rows)
            if (!thisRow.hasClass('mg-hide-element')){

                // check if priority is correct and filled out
                let thePriorityField = thisRow.find("input[id^='inpPrioritet']");
                const priority = thePriorityField.val();

                if (priority.trim().length > 0) {

                    const aDigits = ["1","2","3","4","5","6","7","8","9","0"];

                    // check formally correct number
                    for(let i = 0; i < priority.length; i++){
                        let charToTest = priority.substr(i, 1);
                        if (!aDigits.includes(charToTest)){
                            ok = false;
                            warningMessage = bodmin.modalRingTypes.lang.inpPriorityInvalid;
                        }
                    }

                } else {
                    ok = false;
                    warningMessage = bodmin.modalRingTypes.lang.inpMustBeFilledOut;
                }

                if (!ok) {
                    let warningDiv = thisRow.find("div[id^='div-warning-priority-']");
                    warningDiv.html('<small>' + warningMessage + '</small>');
                    warningDiv.toggleClass('mg-hide-element', false);
                    thePriorityField.focus();
                    return false;
                }


            }
        });


        if (ok){

            // check unique ring types
            let ringTypeCodesIds = [];
            allRowsToHandle.each(function (){

                let thisRow = $(this);
                // only visible (not deleted rows)
                if (!thisRow.hasClass('mg-hide-element')){

                    // ring-type-row-1
                    // 012345667890123
                    const id = thisRow.attr('id').substring(14,99);

                    // build ArrayForUniqueCheck - languages
                    let s = ($('#slct-ring-type-' + id).val());
                    ringTypeCodesIds.push(s);

                }
            });

            const uniqueRowsNos = [...new Set(ringTypeCodesIds)];
            if (uniqueRowsNos.length !== ringTypeCodesIds.length){
                bodmin.modalRingTypes.ui.notUniqueText.text(bodmin.modalRingTypes.lang.frmValDoubleCodes);
                bodmin.modalRingTypes.ui.divNotUnique.toggleClass('mg-hide-element', false);
                ok = false;
            }


        }


        if (ok){

            bodmin.modalRingTypes.ui.window.modal('hide');

            let formData = new FormData();
            formData.append('taxa_id', bodmin.mainTableId);
            allRowsToHandle.each(function (){

                let thisRow = $(this);

                if (!thisRow.hasClass('mg-hide-element')){

                    const id = thisRow.attr('id').substring(14,99);

                    let val = $('#slct-ring-type-' + id).val();
                    name = 'ringCode-' + val;
                    val = $('#inpPrioritet-' + id).val();
                    formData.append(name, val);

                }

            });

            $.ajax({
                url: "handleRingTypesData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    refreshRingsTab();
                }
            });

        }

    });
    

    function setEditButtonsOff(){

        bodmin.cntrlPanel.ui.btnEdit.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnTranslations.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnDelete.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnRings.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnMeasurements.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnCodes.prop('disabled', true);

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
                hdrMain         : 'Taxa',
                infoLabel       : 'Chose a taxa to activate the buttons',
                infoLabelVald   : 'Chosen: ',
                noPermission    : "You have insufficient user privileges to change data here.",
                btnNew          : "New taxa",
                btnEdit         : "Edit",
                btnDelete       : "Delete",
                btnTranslations : "Names",
                btnCodes        : "Codes",
                btnRings        : "Ring(s)",
                btnMeasurements : "Measurements",
            };

            // table
            bodmin.table.lang = {
            filterBoxPlaceHolder        : 'Filter taxa here',
                // headers
                thShortName             : 'Short name',
                thScientific            : 'Scientific name',
                thSysNo                 : 'Sort order',
                thDeciGrams             : 'Weight in decigrams',
                tdYes                   : 'Yes',
                tdNo                    : ' - ',
                labelTranslations       : "Names",
                labelMeasurements       : "Measurements",
                labelCodes              : "Codes",
                labelRings              : "Ring(s)",
                inTableMeasurementsType : "Type",
                inTableMeasurementsAge  : "Age",
                inTableMeasurementsSex  : "Sex",
                inTableMeasurementsMonths : "Months",
                inTableMeasurementsMin    : "Min",
                inTableMeasurementsMax    : "Max",
                inTableMonthsAll          : "All",
                inTableCodeType           : "Code source",
                inTableCodeTypeCode       : "Code",
                inTableCodeTypeCodeNoRing : "No known ring types for this taxa. Thus, the ring No# cannot be suggested by the system.",
                inTableCodeTypeCodeNoCode : "No known codes for this taxa. Thus, this taxa cannot be exported.",
                tblInTblHeaderNoTranslations : "No translations done - yet",
                tblInTblHeaderNoMeasurements : "No measurements entered yet",
                tblInTblHeaderNoMeasurementsExtraInfo : "Due to this data entered for this species cannot be validated. Only basic field are shown in the data entry modules.",
                inTableRingType           : "Ring type (size)",
                inTableRingTypePrio       : "Priority",
                inTableRingTypesNoType    : "No ring sizes known fore this taxa. Rings are thus handled manually."
            }

            bodmin.modalEditTaxa.lang = {
                headerEdit          : 'Change taxa',
                headerNew           : 'New taxa',
                headerDelete        : 'Delete taxa',
                // field labels
                lblInpShortName     : 'Short name',
                lblInpScientific    : 'Scientific name',
                lblCbDeciGrams      : 'Weight in 10\'s of grams 6,5 grams -> 65',

                lblDropDownTaxa     : "Insert taxa after this (selected) taxa",
                introTextDropDownTaxa     : "No taxa selected - taxa will be placed at the beginning",

                // button texts
                btnSave             : 'Save',
                btnCancel           : 'Cancel',
                ja                  : "Yes",
                nej                 : "No",
                months              : ['January', 'February', 'March', 'April', 'May', 'Jun', 'July', 'August', 'September', 'October', 'November', 'December']
            }

            bodmin.modalTranslations.lang = {
                header: "Manage translations for ",
                btnAdd: "Add translation",
                btnSave: "Save",
                btnCancel: "Cancel",
                lblModalTranslation : "Translation",
                lblModalLanguage : "Language",
                frmValDoubleLanguages: "You have two translations in the same language.",
                frmValNoTranslation: "You have to give a translation."
            }

            bodmin.modalEditTaxaCodeTypes.lang = {
                header: "Manage taxa codes for ",
                btnAdd: "Add code type",
                btnSave: "Save",
                btnCancel: "Cancel",
                lblModalTaxaCodeTypeCode: "Code",
                lblModalTaxaCodeType    : "Code type",
                frmValDoubleCodes: "You have two similar code types.",
                frmValNoCode: "You have to give a code."
            }

            bodmin.modalRingTypes.lang = {
                header                  : "Manage ring types for ",
                btnAdd                  : "Add a ring type",
                btnSave                 : "Save",
                btnCancel               : "Cancel",
                lblModalRingType        : "Ring type",
                lblModalRingPriority    : "Priority",
                frmValDoubleCodes       : "You have the same ring type twice.",
                inpMustBeFilledOut      : "Must be filled out",
                inpPriorityInvalid      : "Invalid number"
            }

            bodmin.modalMeasurements.lang = {
                header                      : "Manage measurements and validation limits for ",
                formCheckLabel              : 'Remove',
                lblModalMeasurementsType    : 'Measurement',
                lblModalMeasurementsSex     : 'Sex',
                lblModalMeasurementsAge     : 'Age',
                lblModalMeasurementsMonths  : 'Months',
                lblModalMeasurementsMin     : 'Min',
                lblModalMeasurementsMax     : 'Max',
                ddAll                       : 'All',
                ddBoth                      : "All",
                ddMonthsAll                 : "Full year",
                ddMonthsNoMonthsSelected    : " selected",
                ddMonthsNonSelectedText     : "Select",
                btnAdd                      : "Add measurement",
                btnSave                     : "Save",
                btnCancel                   : "Cancel",
                frmValDoubleEntry           : "You have two measurements of the same type.",
                frmValNoValue               : "You have to give a value.",
                frmValMaiMax                : "You have to give a value.",
                placeHolderMin              : 'Min',
                placeHolderMax              : 'Max',
                invalidNumber               : 'Invalid number',
                duplicateData               : 'Two measurements (Type/sex/age/months) are the same',
                minSmaller                  : 'Min must',
                thanMax                     : 'be smaller'
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
                hdrMain         : 'Taxa',
                infoLabel       : 'Välj ett taxa för att aktivera knapparna',
                infoLabelVald   : 'Vald: ',
                noPermission    : "Du har inte behörighet att ändra data här",
                btnNew          : "Nytt taxon",
                btnEdit         : "Ändra",
                btnDelete       : "Tag bort",
                btnTranslations : "Namn",
                btnCodes        : "Koder",
                btnRings        : "Ring(ar)",
                btnMeasurements : "Mått",
            };

            // table
            bodmin.table.lang = {
                filterBoxPlaceHolder    : 'Filtrera data nedan här',
                // headers
                tdYes                   : 'Ja',
                tdNo                    : ' - ',
                thShortName             : 'Kortnamn',
                thScientific            : 'Vetenskapligt namn',
                thSysNo                 : 'Sorteringsordning',
                thDeciGrams             : 'Vikt i tiondels gram',
                labelTranslations       : "Namn",
                labelMeasurements       : "Mått",
                labelCodes              : "Koder",
                labelRings              : "Ring(ar)",
                inTableMeasurementsType : "Typ",
                inTableMeasurementsAge  : "Ålder",
                inTableMeasurementsSex  : "Kön",
                inTableMeasurementsMonths : "Månader",
                inTableMeasurementsMin    : "Min",
                inTableMeasurementsMax    : "Max",
                inTableMonthsAll          : "Alla",
                tblInTblHeaderNoTranslations : "Inga översättningar gjorda - än",
                tblInTblHeaderNoMeasurements : "Inga mått och intervaller är registrerade.",
                tblInTblHeaderNoMeasurementsExtraInfo : "På grund av detta kan data för denna art ej valideras vid inmatning. Endast grundläggande fält visas vid inmatning.",
                inTableCodeType           : "Kodkälla",
                inTableCodeTypeCode       : "Kod",
                inTableCodeTypeCodeNoRing : "No known ring types for this taxa. Thus, the ring No# cannot be suggested by the system.",
                inTableCodeTypeCodeNoCode : "Inga kända koder registrerade för detta taxa. På grund av detta kan inte data för detta taxa exporteras till någon partner (inklusive RC!)",
                inTableRingType           : "Ring typ (storlek)",
                inTableRingTypePrio       : "Prioritet",
                inTableRingTypesNoType    : "Inga ringtypes registrerade för detta taxa. Ringar hanteras därför helt manuellt."
            }

            bodmin.modalEditTaxa.lang = {
                headerEdit          : 'Ändra taxa',
                headerNew           : 'Ny taxa',
                headerDelete        : 'Tag bort taxa',

                // field labels
                lblInpShortName     : 'Kortnamn ',
                lblInpScientific    : 'Vetenskapligt namn',
                lblCbDeciGrams      : 'Vikt i tiondels gram för detta taxon',

                warningInpName      : 'Namn måste fyllas i',

                lblDropDownTaxa     : "Sätt in nya taxat efter detta (valt) taxa",
                introTextDropDownTaxa     : "Inget taxa valt - sätts in allra först",

                // button texts
                btnSave             : 'Spara',
                btnCancel           : 'Avbryt',
                ja                  : "Ja",
                nej                 : "Nej",
                months              : ['januari', 'februari', 'mars', 'april', 'maj', 'juni', 'juli', 'augusti', 'september', 'oktober', 'november', 'december']
            }

            bodmin.modalTranslations.lang = {
                header: "Hantera översättningar för ",
                btnAdd: "Lägg till översättning",
                btnSave: "Spara",
                btnCancel: "Avbryt",
                lblModalTranslation : "Översättning",
                lblModalLanguage : "Språk",
                frmValDoubleLanguages: "Du har två översättningar på samma språk.",
                frmValNoTranslation: "Du måste ange en översättning."
            }

            bodmin.modalMeasurements.lang = {
                header                      : "Hantera mått och max/min gränser för ",
                lblModalMeasurementsType    : 'Mått',
                lblModalMeasurementsSex     : 'Kön',
                lblModalMeasurementsAge     : 'Ålder',
                lblModalMeasurementsMonths  : 'Månader',
                lblModalMeasurementsMin     : 'Min',
                lblModalMeasurementsMax     : 'Max',
                ddAll                       : 'Alla',
                ddBoth                      : "Båda",
                ddMonthsAll                 : "Hela året",
                ddMonthsNoMonthsSelected    : " valda",
                ddMonthsNonSelectedText     : "Välj",
                btnAdd                      : "Lägg till mått",
                btnSave                     : "Spara",
                btnCancel                   : "Avbryt",
                frmValDoubleEntry           : "You have two measurements of the same type.",
                frmValNoValue               : "You have to give a value.",
                frmValMaiMax                : "You have to give a value.",
                placeHolderMin              : 'Min',
                placeHolderMax              : 'Max',
                invalidNumber               : 'Ogiltigt',
                duplicateData               : 'Två mått specifikationer (typ/kön/ålder/månader) är de samma.',
                minSmaller                  : 'Min måste',
                thanMax                     : 'vara mindre'

            }

            bodmin.modalEditTaxaCodeTypes.lang = {
                header                  : "Hantera taxa koder för ",
                btnAdd                  : "Lägg till en kodtyp",
                btnSave                 : "Spara",
                btnCancel               : "Avbryt",
                lblModalTaxaCodeTypeCode: "Kod",
                lblModalTaxaCodeType    : "Kodtyp",
                frmValDoubleCodes       : "Du har två likadana kodtyper.",
                frmValNoCode            : "Du måste ange en kod."
            }

            bodmin.modalRingTypes.lang = {
                header                  : "Hantera ringtyper för ",
                btnAdd                  : "Lägg till en ringtyp",
                btnSave                 : "Spara",
                btnCancel               : "Avbryt",
                lblModalRingType        : "Ringtyp",
                lblModalRingPriority    : "Prioritet",
                frmValDoubleCodes       : "Du har samma ringtyp två gånger.",
                inpMustBeFilledOut      : "Måste fyllas i",
                inpPriorityInvalid      : "Ogiltigt värde"
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
            $('#loggedStatus').html('<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>");
        }

        // left hand panel
        bodmin.cntrlPanel.ui.hdrMain.html(bodmin.cntrlPanel.lang.hdrMain);
        bodmin.cntrlPanel.ui.btnNew.text(bodmin.cntrlPanel.lang.btnNew);
        bodmin.cntrlPanel.ui.btnEdit.text(bodmin.cntrlPanel.lang.btnEdit);
        bodmin.cntrlPanel.ui.btnDelete.text(bodmin.cntrlPanel.lang.btnDelete);
        bodmin.cntrlPanel.ui.btnTranslations.text(bodmin.cntrlPanel.lang.btnTranslations);
        bodmin.cntrlPanel.ui.btnRings.text(bodmin.cntrlPanel.lang.btnRings);
        bodmin.cntrlPanel.ui.btnCodes.text(bodmin.cntrlPanel.lang.btnCodes);
        bodmin.cntrlPanel.ui.btnMeasurements.text(bodmin.cntrlPanel.lang.btnMeasurements);

        bodmin.cntrlPanel.ui.infoLabel.html(bodmin.cntrlPanel.lang.infoLabel);
        bodmin.cntrlPanel.ui.selectInfo.text(bodmin.cntrlPanel.lang.selectInfo);

        // main table
        bodmin.table.ui.filterBox.attr('placeholder', bodmin.table.lang.filterBoxPlaceHolder);
        bodmin.table.ui.thShortName.text(bodmin.table.lang.thShortName);
        bodmin.table.ui.thScientific.text(bodmin.table.lang.thScientific);
        bodmin.table.ui.thSysNo.text(bodmin.table.lang.thSysNo);
        bodmin.table.ui.thDeciGrams.text(bodmin.table.lang.thDeciGrams);

        $('.systematicYes').text(bodmin.table.lang.tdYes);
        $('.systematicNo').text(bodmin.table.lang.tdNo);

        $('.monitoringYes').text(bodmin.table.lang.tdYes);
        $('.monitoringNo').text(bodmin.table.lang.tdNo);

        // main modal
        bodmin.modalEditTaxa.ui.lblInpShortName.text(bodmin.modalEditTaxa.lang.lblInpShortName);
        bodmin.modalEditTaxa.ui.lblInpScientific.text(bodmin.modalEditTaxa.lang.lblInpScientific);
        bodmin.modalEditTaxa.ui.lblDropDownTaxa.text(bodmin.modalEditTaxa.lang.lblDropDownTaxa);
        bodmin.modalEditTaxa.ui.lblCbDeciGrams.text(bodmin.modalEditTaxa.lang.lblCbDeciGrams);

        // modal edit translations
        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header);
        bodmin.modalTranslations.ui.btnAdd.text(bodmin.modalTranslations.lang.btnAdd);
        bodmin.modalTranslations.ui.btnSave.text(bodmin.modalTranslations.lang.btnSave);
        bodmin.modalTranslations.ui.btnCancel.text(bodmin.modalTranslations.lang.btnCancel);

        // modal edit coder
        bodmin.modalEditTaxaCodeTypes.ui.header.text(bodmin.modalEditTaxaCodeTypes.lang.header);
        bodmin.modalEditTaxaCodeTypes.ui.lblModalTaxaCodeTypeCode.text(bodmin.modalEditTaxaCodeTypes.lang.lblModalTaxaCodeTypeCode);
        bodmin.modalEditTaxaCodeTypes.ui.lblModalTaxaCodeType.text(bodmin.modalEditTaxaCodeTypes.lang.lblModalTaxaCodeType);
        bodmin.modalEditTaxaCodeTypes.ui.btnAdd.text(bodmin.modalEditTaxaCodeTypes.lang.btnAdd);
        bodmin.modalEditTaxaCodeTypes.ui.btnSave.text(bodmin.modalEditTaxaCodeTypes.lang.btnSave);
        bodmin.modalEditTaxaCodeTypes.ui.btnCancel.text(bodmin.modalEditTaxaCodeTypes.lang.btnCancel);
        
        // modal ring types
        bodmin.modalRingTypes.ui.header.text(bodmin.modalRingTypes.lang.header);
        bodmin.modalRingTypes.ui.lblModalRingType.text(bodmin.modalRingTypes.lang.lblModalRingType);
        bodmin.modalRingTypes.ui.lblModalRingPriority.text(bodmin.modalRingTypes.lang.lblModalRingPriority);
        bodmin.modalRingTypes.ui.btnAdd.text(bodmin.modalRingTypes.lang.btnAdd);
        bodmin.modalRingTypes.ui.btnSave.text(bodmin.modalRingTypes.lang.btnSave);
        bodmin.modalRingTypes.ui.btnCancel.text(bodmin.modalRingTypes.lang.btnCancel);

        // modal edit measurements
        bodmin.modalMeasurements.ui.header.text(bodmin.modalMeasurements.lang.header);
        bodmin.modalMeasurements.ui.btnAdd.text(bodmin.modalMeasurements.lang.btnAdd);
        bodmin.modalTranslations.ui.lblModalTranslation.text(bodmin.modalTranslations.lang.lblModalTranslation);
        bodmin.modalTranslations.ui.lblModalLanguage.text(bodmin.modalTranslations.lang.lblModalLanguage);
        bodmin.modalMeasurements.ui.btnSave.text(bodmin.modalMeasurements.lang.btnSave);
        bodmin.modalMeasurements.ui.btnCancel.text(bodmin.modalMeasurements.lang.btnCancel);

        bodmin.modalMeasurements.ui.lblModalMeasurementsType.text(bodmin.modalMeasurements.lang.lblModalMeasurementsType);
        bodmin.modalMeasurements.ui.lblModalMeasurementsSex.text(bodmin.modalMeasurements.lang.lblModalMeasurementsSex);
        bodmin.modalMeasurements.ui.lblModalMeasurementsAge.text(bodmin.modalMeasurements.lang.lblModalMeasurementsAge);
        bodmin.modalMeasurements.ui.lblModalMeasurementsMonths.text(bodmin.modalMeasurements.lang.lblModalMeasurementsMonths);
        bodmin.modalMeasurements.ui.lblModalMeasurementsMin.text(bodmin.modalMeasurements.lang.lblModalMeasurementsMin);
        bodmin.modalMeasurements.ui.lblModalMeasurementsMax.text(bodmin.modalMeasurements.lang.lblModalMeasurementsMax);

        bodmin.modalMeasurements.lang.placeHolderMin

    }


    function loadTable() {

        let tmpHTML = '<tr><td colspan="4">' + mgGetImgSpinner() + '</td></tr>';
        bodmin.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"get",
            url: "getAllBaseTaxa.php",
            success: function(data) {

                let infoHTML = "";
                let taxa = JSON.parse(data);

                //create and populate the table rows
                for (let i = 0; i < taxa.length; i++) {
                    infoHTML = infoHTML + '<tr id="' + taxa[i]["ID"] + '">';
                    infoHTML = infoHTML + '<td>' + taxa[i]["SHORTNAME"] + '</td>';
                    infoHTML = infoHTML + '<td>' + taxa[i]["SCINAME"]  + '</td>';
                    infoHTML = infoHTML + '<td>' + taxa[i]["SNR"]  + '</td>';
                    infoHTML = infoHTML + '<td class="text-center">' + formatBoolean(taxa[i]["DECIGRAMS"])  + '</td>';
                    infoHTML = infoHTML + '</tr>';
                    infoHTML = infoHTML + mgGetDataRow(taxa[i]["ID"], 2);

                }
                bodmin.table.ui.bodySection.empty().append(infoHTML);
                setLangTexts();
                filterTable(bodmin.table.ui.filterBox.val());

            }
        });

    }


    function refreshSubSection(){

        $('#tabsInfo').remove();
        let row = $('#dataFor-' + bodmin.mainTableId);
        let dataHTML = '<td colspan="4">';
        dataHTML = dataHTML + '<div id="tabsInfo">\n' +
            '                        <ul>\n' +
            '                            <li><a href="#tabTranslations" id="labelTranslations">' + bodmin.table.lang.labelTranslations + '</a></li>\n' +
            '                            <li><a href="#tabRings" id="labelRings">' + bodmin.table.lang.labelRings + '</a></li>\n' +
            '                            <li><a href="#tabMeasurements" id="labelMeasurements">' + bodmin.table.lang.labelMeasurements + '</a></li>\n' +
            '                            <li><a href="#tabCodes" id="labelCodes">' + bodmin.table.lang.labelCodes + '</a></li>\n' +
            '                        </ul>\n' +
            '                        <div id="tabTranslations">\n' + 'translationsText' +
            '                        </div>\n' +
            '                        <div id="tabMeasurements">\n' +
            '                        </div>\n' +
            '                        <div id="tabRings">Rings here\n' +
            '                        </div>\n' +
            '                        <div id="tabCodes">Codes here\n' +
            '                        </div>\n' +
            '                    </div>\n';

        row.empty().append(dataHTML);
        refreshTranslationsTab();
        refreshMeasurementsTab();
        refreshCodesTab();
        refreshRingsTab();
        $('#tabsInfo').tabs();


    }


    function refreshTranslationsTab(){

        $.get("getTaxaTranslations.php?id=" + bodmin.mainTableId,
            function(data) {

                let translations = JSON.parse(data);

                let translationsText = "";
                for (let i = 0; i < translations.length; i++) {
                    translationsText = translationsText + '<span class="mg-80-span">' + translations[i].LANGUAGE + '</span>' + translations[i].TEXT + '<br/>';
                }

                if (translationsText.length === 0){
                    translationsText = '<h6>' + bodmin.table.lang.tblInTblHeaderNoContent +'</h6>';
                }

                $('#tabTranslations').html(translationsText)


            }
        );

    }


    function refreshMeasurementsTab(){

        let measurementsText = mgGetDivWithSpinnerImg;
        $.get("getTaxaMeasurementsConfigData.php?taxa_id=" + bodmin.mainTableId + '&lang_id=' + bodmin.lang.current,
            function(data) {

                let measurements = JSON.parse(data);

                measurementsText = '<div class="container pl-0">';

                // we have data - build header
                if (measurements.length > 0){

                    measurementsText = measurementsText + '<div class="row mg-div-header">';

                    measurementsText = measurementsText + '<div class="col-sm-5">' + bodmin.table.lang.inTableMeasurementsType;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + bodmin.table.lang.inTableMeasurementsSex;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-2">' + bodmin.table.lang.inTableMeasurementsAge;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-2">' + bodmin.table.lang.inTableMeasurementsMonths;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + bodmin.table.lang.inTableMeasurementsMin;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + bodmin.table.lang.inTableMeasurementsMax;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '</div>';


                }

                // build "table" of measurements.
                for (let i = 0; i < measurements.length; i++) {
                    measurementsText = measurementsText + '<div class="row">';

                    measurementsText = measurementsText + '<div class="col-sm-5">' + measurements[i].MEASUREMENT;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + measurements[i].AGE;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-2">' + measurements[i].SEX;
                    measurementsText = measurementsText + '</div>';

                    let m = measurements[i].MONTHS;
                    let aMonths = m.split(',');
                    let text = bodmin.table.lang.inTableMonthsAll;
                    if (aMonths.length < 12) {
                        let min = Math.min(...aMonths);
                        let max = Math.max(...aMonths);
                        text = min + '-' + max;
                    }

                    measurementsText = measurementsText + '<div class="col-sm-2">' + text;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + measurements[i].LOWERMIN;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '<div class="col-sm-1">' + measurements[i].UPPERMAX;
                    measurementsText = measurementsText + '</div>';

                    measurementsText = measurementsText + '</div>';

                }
                measurementsText = measurementsText + "</div>";

                if (measurements.length === 0){
                    measurementsText = '<strong>' + bodmin.table.lang.tblInTblHeaderNoMeasurements +'</strong><br/>' + bodmin.table.lang.tblInTblHeaderNoMeasurementsExtraInfo;
                }

                $('#tabMeasurements').html(measurementsText);

            }
        );

    }


    function refreshCodesTab(){

        let codesText = mgGetDivWithSpinnerImg;
        $.get("getTaxaCodesData.php?taxa_id=" + bodmin.mainTableId + '&lang_id=' + bodmin.lang.current,
            function(data) {

                let codes = JSON.parse(data);

                codesText = '<div class="container pl-0">';

                // we have data - build header
                if (codes.length > 0){

                    codesText = codesText + '<div class="row mg-div-header">';

                    codesText = codesText + '<div class="col-sm-10">' + bodmin.table.lang.inTableCodeType;
                    codesText = codesText + '</div>';

                    codesText = codesText + '<div class="col-sm-2">' + bodmin.table.lang.inTableCodeTypeCode;
                    codesText = codesText + '</div>';

                    codesText = codesText + '</div>';


                }


                // build table of taxa codes.
                for (let i = 0; i < codes.length; i++) {
                    codesText = codesText + '<div class="row">';

                    codesText = codesText + '<div class="col-sm-10">' + codes[i].TEXT;
                    codesText = codesText + '</div>';

                    codesText = codesText + '<div class="col-sm-2">' + codes[i].CODE;
                    codesText = codesText + '</div>';


                    codesText = codesText + '</div>';

                }
                codesText = codesText + "</div>";

                if (codes.length === 0){
                    codesText = '<strong>' + bodmin.table.lang.inTableCodeTypeCodeNoCode;
                }

                $('#tabCodes').html(codesText);

            }
        );
    }


    function refreshRingsTab(){

        let ringsText = mgGetDivWithSpinnerImg;
        $.get("getTaxaRingTypes.php?taxa_id=" + bodmin.mainTableId ,
            function(data) {

                let rings = JSON.parse(data);

                ringsText = '<div class="container pl-0">';

                // we have data - build header
                if (rings.length > 0){

                    ringsText = ringsText + '<div class="row mg-div-header">';

                    ringsText = ringsText + '<div class="col-sm-10">' + bodmin.table.lang.inTableRingType;
                    ringsText = ringsText + '</div>';

                    ringsText = ringsText + '<div class="col-sm-2">' + bodmin.table.lang.inTableRingTypePrio;
                    ringsText = ringsText + '</div>';

                    ringsText = ringsText + '</div>';


                }

                // build "table" of rings.
                for (let i = 0; i < rings.length; i++) {
                    ringsText = ringsText + '<div class="row">';

                    ringsText = ringsText + '<div class="col-sm-10">' + rings[i].TEXT;
                    ringsText = ringsText + '</div>';

                    ringsText = ringsText + '<div class="col-sm-2">' + rings[i].PRIO;
                    ringsText = ringsText + '</div>';


                    ringsText = ringsText + '</div>';

                }
                ringsText = ringsText + "</div>";

                if (rings.length === 0){
                    ringsText = '<strong>' + bodmin.table.lang.inTableCodeTypeCodeNoRing;
                }

                $('#tabRings').html(ringsText);

            }
        );

    }


    function populateModalDropDowns(){

        // m o n t h s
        $.ajax({
            type: "get",
            url: "getMonths.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let months = JSON.parse(data);
                bodmin.modalMeasurements.ui.months = [];

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
                    bodmin.modalMeasurements.ui.months.push(option);

                }

            }
        });



        // t a x a
        refreshTaxaDropDown();

        // s e x
        $.ajax({
            type: "get",
            url: "getSexes.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let sexes = JSON.parse(data);

                for (let i = 0; i < sexes.length; i++) {
                    bodmin.modalMeasurements.ui.ddSex.append($("<option></option>").attr("value",sexes[i].ID).text(sexes[i].TEXT));
                }

                bodmin.modalMeasurements.ui.ddSex.val('4');

            }

        });

        // a g e s
        $.ajax({
            type: "get",
            url: "getAgesForMeasurementOptions.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let ages = JSON.parse(data);

                for (let i = 0; i < ages.length; i++) {
                    bodmin.modalMeasurements.ui.ddAge.append($("<option></option>").attr("value",ages[i].AGE).text(ages[i].TEXT));
                }

                bodmin.modalMeasurements.ui.ddAge.val('99');

            }
        });

    }


    function refreshTaxaDropDown(){

        $.ajax({
            type: "get",
            url: "getAllBaseTaxa.php",
            success: function (data) {

                $('#slctTaxa option').remove();
                let taxa = JSON.parse(data);
                for (let i = 0; i < taxa.length; i++) {

                    const taxaText =  taxa[i]["SHORTNAME"] + ' ' + taxa[i]["SCINAME"]  + '  ' + taxa[i]["SNR"];
                    bodmin.modalEditTaxa.ui.slctTaxa.append($("<option></option>").attr("value",taxa[i].SNR).text(taxaText));
                }

            }
        });
    }


    $('#action-info').fadeOut(6000);
    bodmin.lang.current = $('#systemLanguageId').text();

    getLangTexts();
    loadTable();
    populateModalDropDowns();
    setLangTexts();
    setEditButtonsOff();

});


