$(document).ready(function(){

    let v = {

        modalMode : '',
        documentBody : $('body'),

        controlPanel : {
            ui : {
                hdrMain : $('#hdrMain'),
                version : $('#version'),
                infoLabel : $('#infoLabel'),
                infoSelectedRecord : $('#infoSelectedRecord'),
                infoPermissions : $('#infoPermissions'),
                btnNew : $('#btnNew'),
                btnEdit : $('#btnEdit'),
                btnDelete : $('#btnDelete'),
                btnTranslations : $('#btnTranslations')
            }
        },

        table : {
            ui : {
                filterBox : $('#tblFilterBox'),
                bodySection : $('#data tbody'),
                thName : $('#thName'),
                thStandardized : $('#thStandardized'),
                thMonitoring : $('#thMonitoring'),
                thSeasonStartDate : $('#thSeasonStartDate'),
                thSeasonEndDate : $('#thSeasonEndDate')
            }
        },

        modalEditLocality : {
            ui : {
                window : $('#editMain'),
                header : $('#modalMainHeader'),
                sectionDelete : $('#modalMainDeleteSection'),
                sectionEdit : $('#modalMainEditSection'),

                // labels, fields and warnings
                warningTextsAll : $("small[id^='warning']"),
                warningDateFrom : $('#warningDateFrom'),
                warningDateTo : $('#warningDateTo'),

                lblInpName : $('#lblInpName'),
                inpName : $('#inpName'),
                warningInpName : $('#warningInpName'),

                lblStandardized : $('#lblStandardized'),
                cbStandardized :  $('#cbStandardized'),

                lblMonitoring : $('#lblMonitoring'),
                cbMonitoring :  $('#cbMonitoring'),

                btnSave : $('#btnModalMainSave'),
                btnCancel : $('#btnModalMainCancel')
            },
        },

        modalTranslations : {
            ui: {
                window: $('#modalEditTranslation'),
                header: $('#modalTranslationsHeader'),
                allCheckBoxLabels: $('label.formCheckLabel'),
                btnAdd: $('#btnTranslationAdd'),
                btnSave: $('#btnTranslationsSave'),
                btnCancel: $('#btnTranslationsCancel')
            },
        },

        // lang : defined below in setLangTexts
        language : {},


    };

    $(document).on("click", "#data tbody tr", function(){
        v.selectedRow = $(this);
        handleSelectedRow(v);
    });


    function handleSelectedRow(v){

        handleRowSelection(v);
        refreshDetailSection();

    }


    v.table.ui.filterBox.on('input', function(){
        let needle = $(this).val().toLowerCase();
        filterTable(needle);
    });


    // ----------------------------------------------------------------------main table maintenance------------------
    v.controlPanel.ui.btnNew.on('click', function(){

        v.modalEditLocality.ui.header.text(v.modalEditLocality.language.headerNew);

        v.modalMode = "add";

        // set button texts
        v.modalEditLocality.ui.btnCancel.text(v.modalEditLocality.language.btnCancel);
        v.modalEditLocality.ui.btnSave.text(v.modalEditLocality.language.btnSave);

        // clear all potential error messages
        v.modalEditLocality.ui.warningTextsAll.text('');

        // empty fields
        v.modalEditLocality.ui.inpName.val('');
        setCheckBoxStatus(v.modalEditLocality.ui.cbMonitoring, 0);
        setCheckBoxStatus(v.modalEditLocality.ui.cbStandardized, 0);

        v.modalEditLocality.ui.inpName.focus();
        v.modalEditLocality.ui.inpName.addClass("focusedInput");

        // hide delete section and show edit
        v.modalEditLocality.ui.sectionDelete.toggleClass('mg-hide-element', true);
        v.modalEditLocality.ui.sectionEdit.toggleClass('mg-hide-element', false);

        v.modalEditLocality.ui.window.modal('show');

    });


    v.controlPanel.ui.btnEdit.on('click', function(){

        // clear all potential previous error messages
        v.modalEditLocality.ui.warningTextsAll.text('');

        $.ajax({
            type:"get",
            url: "getLocationViaId.php?id=" + v.mainTableId,
            success: function(data) {

                v.modalEditLocality.ui.header.text(v.modalEditLocality.language.headerEdit);

                v.modalMode = "edit";

                v.modalEditLocality.ui.btnCancel.text(v.modalEditLocality.language.btnCancel);
                v.modalEditLocality.ui.btnSave.text(v.modalEditLocality.language.btnSave);

                // hide delete section and show edit
                v.modalEditLocality.ui.sectionDelete.toggleClass('mg-hide-element', true);
                v.modalEditLocality.ui.sectionEdit.toggleClass('mg-hide-element', false);

                let obj = JSON.parse(data);
                let lokal = obj[0];

                //populate edit form with gotten data
                v.modalEditLocality.ui.inpName.val(lokal.TEXT);
                setCheckBoxStatus(v.modalEditLocality.ui.cbStandardized, lokal.SYSTEMATIC);
                setCheckBoxStatus(v.modalEditLocality.ui.cbMonitoring, lokal.MONITORING);


                v.modalEditLocality.ui.window.modal('show');

            }
        });
    });


    v.controlPanel.ui.btnDelete.on('click', function(){

        v.modalEditLocality.ui.header.text(v.modalEditLocality.language.headerDelete);

        v.modalMode = "delete";

        v.modalEditLocality.ui.btnSave.text(v.modalEditLocality.language.ja);
        v.modalEditLocality.ui.btnCancel.text(v.modalEditLocality.language.nej);

        v.modalEditLocality.ui.sectionDelete.toggleClass('mg-hide-element', false);
        v.modalEditLocality.ui.sectionEdit.toggleClass('mg-hide-element', true);

        // populate delete section
        v.modalEditLocality.ui.sectionDelete.html('<h6>' + v.name + '</h6>');

        v.modalEditLocality.ui.window.modal('show');

    });


    v.modalEditLocality.ui.btnSave.on('click', function(){

        let ok = true;

        // clear all potential error messages
        v.modalEditLocality.ui.warningTextsAll.text('');

        if (( v.modalMode === "add") || ( v.modalMode === "edit") ) { // excluding delete

            // name cannot be blank
            ok = (v.modalEditLocality.ui.inpName.val().length > 0);
            if (!ok) {
                v.modalEditLocality.ui.warningInpName.text(v.modalEditLocality.language.warningInpName);
            }

        }

        if (ok){

            let formData = new FormData();
            formData.append('mode', v.modalMode);

            if ((v.modalMode === "add") || (v.modalMode === "edit")) {

                formData.append('name', v.modalEditLocality.ui.inpName.val());
                formData.append('systematic', getCheckBoxStatus(v.modalEditLocality.ui.cbStandardized));
                formData.append('monitoring', getCheckBoxStatus(v.modalEditLocality.ui.cbMonitoring));

                v.searchAfterUpdate = v.modalEditLocality.ui.inpName.val();
            }

            if ((v.modalMode === "edit") || (v.modalMode === "delete")) {
                formData.append('ringing_location_id', v.mainTableId);
            }

            if (v.modalMode === "delete") {
                v.searchAfterUpdate = v.searchTerm;
            }

            $.ajax({
                url: "handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function ( data ) {

                    v.writtenId = JSON.parse(data);
                    loadTable();

                }
            });

            v.modalEditLocality.ui.window.modal('hide');

        }

    });


    //----------------------------------------------------------------------translations--------------
    v.controlPanel.ui.btnTranslations.on('click', function(){

        v.modalTranslations.ui.header.text(v.modalTranslations.language.header + ' ' + v.name);

        // Remove earlier added rows (if any)
        $('#itemRows').empty();

        // Get earlier entered data
        $.ajax({
            type:"get",
            async: false,
            url: "getLocationTranslations.php?id=" +  v.mainTableId,
            success: function(data) {

                let textsList = JSON.parse(data);

                // Populate edit form, add new rows/boxes as needed
                for (let i = 0; i < textsList.length; i++) {

                    addItemSection();
                    $('#id-select-item-' + (i+1)).val(textsList[i].LANG_ID);
                    $('#id-input-item-' + (i+1)).val(textsList[i].LOCALITY_TEXT);

                }

            }
        });

        v.modalTranslations.ui.window.modal('show');

    });


    $(document).on("click", ".deleteButton", function(){

        // button-remove-row-2
        // 012345678901234567

        const domPartToRemove = 'item-' + $(this).attr('id').substring(18);
        $('#'+domPartToRemove).remove();

    });


    v.modalTranslations.ui.btnAdd.on('click', function(){
        addItemSection()
    });


    v.modalTranslations.ui.window.on("click","input[type='checkbox']",function(){

        let theId = $(this).attr('id');

        // expected (example): cb-item-1, extract the digit(s) at the end
        //                     01234567
        theId = theId.substring(8);

        // now select the corresponding input box
        let theItemBox = $('#id-input-item-' + theId);

        // flip disabled
        let enabled = theItemBox.prop("disabled");
        let newStatus = !enabled;

        let theItemSelectBox = $('#id-select-item-' + theId);
        theItemBox.prop("disabled", newStatus);
        theItemSelectBox.prop("disabled", newStatus);
    });


    v.modalTranslations.ui.btnSave.on('click', function(){

        let ok = true;

        let noOfItemsToCheck = $('#itemRows input[type="text"]').length;

        for (let i=1; i <= noOfItemsToCheck; i++) {

            let inpBox = $('#id-input-item-' + i);

            if (inpBox.val().trim() === ''){
                ok = false;
                inpBox.toggleClass('inputWarning', true);
                $('#warning-item-' + i).text(v.modalTranslations.language.frmValNoTranslation);
            }


        }

        if (ok){

            let languageIds = [];
            for (let i=1; i <= noOfItemsToCheck; i++) {
                languageIds.push($('#id-select-item-' + i).val());
            }

            const uniqueLanguageCodes = [...new Set(languageIds)];

            if (uniqueLanguageCodes.length !== languageIds.length){

                $('#not-unique').text(v.modalTranslations.language.frmValDoubleLanguages);
                ok = false;
            }

        }

        if (ok) {

            v.modalTranslations.ui.window.modal('hide');

            // close the edit box, plug-in the spinner, write the translations, and update the translation section.
            let row = $('#dataFor-' + v.mainTableId);
            row.empty().html('<td colspan="3">' + mgGetImgSpinner() + '</td>');

            let formData = new FormData();
            formData.append('location_id', v.mainTableId);
            $('#itemRows .form-group.row').each(function(/*i*/) {

                let rowIndex = $(this).attr('id').substring(5);
                let language_id = $('#id-select-item-' + rowIndex).val();
                let translationValue = $('#id-input-item-' + rowIndex).val();
                formData.append('language-' + language_id, translationValue);

            });

            $.ajax({
                url: "handleTranslationsData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function() {
                    refreshDetailSection();
                }
            });

        }

    });

    // Reset fields on field entry
    v.documentBody.on('focus click', 'input', function(e) {

        let id = $(e.target).attr('id');
        //id-input-item-1
        //01234567890123
        let i = id.substring(14);

        $('#warning-item-' + i).text('');
        $( '#' + id ).toggleClass('inputWarning', false);

    });

    v.documentBody.on('focus', 'select', function() {
        $('#not-unique').text('');
    });


    function addItemSection(){

        // clone the template section (row)
        let newItemSection = $("#baseRow").clone();

        // Check how many existing rows we have, so we can (re)code the newly cloned one properly.
        let rows = $('#itemRows .translationRow').length;
        let newRow = rows+1;

        newItemSection.attr('id', 'item-' + newRow);
        newItemSection.toggleClass('mg-hide-element', false);

        let theInputBox = newItemSection.find('#id-input-item-x');
        theInputBox.attr('id', 'id-input-item-' + newRow);
        theInputBox.attr('name', 'name-input-box-' + newRow);
        theInputBox.attr('placeholder', v.modalTranslations.language.inpPlaceHolder);
        theInputBox.val('');

        let theRemoveButtonDiv = newItemSection.find('#div-remove-button-container-x');
        theRemoveButtonDiv.attr('id', 'div-remove-button-container-' + newRow);
        theRemoveButtonDiv.attr('title', v.modalTranslations.language.btnDeleteRow);

        let theRemoveButton = newItemSection.find('#button-remove-row-x');
        theRemoveButton.attr('id', 'button-remove-row-' + newRow);

        let theDropDown = newItemSection.find('#id-select-item-x');
        theDropDown.attr('id', 'id-select-item-' + newRow);
        theDropDown.attr('name', 'name-select-item-' + newRow);

        let theWarningText = newItemSection.find('#warning-item-x');
        theWarningText.attr('id', 'warning-item-' + newRow);
        theWarningText.text('');

        newItemSection.appendTo("#itemRows");

    }


    function getLangTexts() {

        // E N G E L S K A
        if (v.language.current === '1') {

            v.language.langAsString = 'en';

            // header info
            v.language.loggedinText = 'Logged in as ';
            v.language.logOutHere = "Log out here";

            v.language.noPermission = "You do not have permissions to change or add data here";


            // controlPanel on the left-hand side
            v.controlPanel.language = {
                hdrMain         : 'Localities',
                infoLabel       : 'Chose a locality to activate the buttons',
                infoLabelVald   : 'Chosen: ',
                noPermission    : "You have insufficient user privileges to change data here.",
                btnNew          : "New locality",
                btnEdit         : "Edit",
                btnDelete       : "Delete",
                btnTranslations : "Translations (name)"
            };

            // table
            v.table.language = {
            filterBoxPlaceHolder        : 'Filter localities here',
                // headers
                thName                  : 'Internal name',
                tdYes                   : 'Yes',
                tdNo                    : ' - ',
                thStandardized          : 'Systematic ringing here',
                thMonitoring            : 'Bird monitoring here',
                thSeasonStartDate       : 'Start date',
                thSeasonEndDate         : 'End date',
                tblInTblHeader          : "Translations",
                tblInTblHeaderNoContent : "No translations done - yet"
            }

            v.modalEditLocality.language = {
                headerEdit          : 'Change locality',
                headerNew           : 'New locality',
                headerDelete        : 'Delete locality',
                // field labels
                lblInpName          : 'Name (internal)',
                lblStandardized     : 'Standardized ringing occurs',
                lblMonitoring       : 'Monitoring here',
                warningInpName      : 'Name must be given',

                // button texts
                btnSave             : 'Save',
                btnCancel           : 'Cancel',
                ja                  : "Yes",
                nej                 : "No",

            }

            v.modalTranslations.language = {
                header: "Manage translations for ",
                formCheckLabel: 'Remove this row when saving.',
                btnAdd: "Add translation",
                btnSave: "Save",
                btnCancel: "Cancel",
                btnDeleteRow : 'Remove this translation',
                inpPlaceHolder : 'Enter the translation here',
                frmValDoubleLanguages: "You have two translations in the same language.",
                frmValNoTranslation: "You have to give a translation."
            }

        }

        // S V E N S K A
        if (v.language.current === '2') {

            v.language.langAsString = 'se';

            // header info
            v.language.loggedinText = 'Inloggad som ';
            v.language.logOutHere = "Logga ut här";

            v.language.noPermission = "Du har ej behörighet att ändra eller lägga till data här";

            // controlPanel on the left-hand side
            v.controlPanel.language = {
                hdrMain: 'Lokaler',
                infoLabel: 'Välj en lokal för att aktivera knapparna',
                infoLabelVald: 'Vald: ',
                noPermission: "Du har inte behörighet att ändra data här",
                btnNew: "Ny lokal",
                btnEdit: "Ändra",
                btnDelete: "Tag bort",
                btnTranslations: "Översättningar (Namn)"
            };

            // table
            v.table.language = {
                filterBoxPlaceHolder    : 'Filtrera data nedan här',
                // headers
                tdYes                   : 'Ja',
                tdNo                    : ' - ',
                thName                  : 'Internt namn',
                thStandardized          : 'Standardiserad märkning här',
                thMonitoring            : 'Rasträkning här',
                thSeasonStartDate       : 'Startdatum',
                thSeasonEndDate         : 'Slutdatum',
                tblInTblHeader          : "Översättningar",
                tblInTblHeaderNoContent : "Inga översättningar gjorda än"
            }

            v.modalEditLocality.language = {
                headerEdit          : 'Ändra lokal',
                headerNew           : 'Ny lokal',
                headerDelete        : 'Tag bort lokal',
                // field labels
                lblInpName          : 'Namn (internt)',
                lblStandardized     : 'Systematisk ringmärkning här',
                lblMonitoring       : 'Rasträkning här',
                warningInpName      : 'Namn måste fyllas i',

                // button texts
                btnSave             : 'Spara',
                btnCancel           : 'Avbryt',
                ja                  : "Ja",
                nej                 : "Nej",
            }

            v.modalTranslations.language = {
                header: "Hantera översättningar för ",
                formCheckLabel: 'Tag bort denna rad (vid spara).',
                btnAdd: "Lägg till översättning",
                btnSave: "Spara",
                btnCancel: "Avbryt",
                btnDeleteRow : 'Tag bort denna översättning',
                inpPlaceHolder : 'Ange översättning här',
                frmValDoubleLanguages: "Du har två översättningar på samma språk.",
                frmValNoTranslation: "Du måste ange en översättning."
            }

        }

    }


    function setLangTexts(){

        // set all texts
        $(document).attr('title', v.language.pageTitle);
        $("html").attr("lang", v.language.langAsString);

        // top, top, header
        $('#loggedinText').text(v.language.loggedinText);

        if ($('#loggedInUserId').text() !== '0'){
            $('#loggedStatus').html('<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + v.language.logOutHere +"</a>");
        }

        // left-hand panel
        v.controlPanel.ui.hdrMain.html(v.controlPanel.language.hdrMain);
        v.controlPanel.ui.btnNew.text(v.controlPanel.language.btnNew);
        v.controlPanel.ui.btnEdit.text(v.controlPanel.language.btnEdit);
        v.controlPanel.ui.btnDelete.text(v.controlPanel.language.btnDelete);
        v.controlPanel.ui.btnTranslations.text(v.controlPanel.language.btnTranslations);
        v.controlPanel.ui.infoLabel.text(v.controlPanel.language.infoLabel);


        // main table
        v.table.ui.filterBox.attr('placeholder', v.table.language.filterBoxPlaceHolder);
        v.table.ui.thName.text(v.table.language.thName);
        v.table.ui.thStandardized.text(v.table.language.thStandardized);
        v.table.ui.thMonitoring.text(v.table.language.thMonitoring);
        v.table.ui.thSeasonStartDate.text(v.table.language.thSeasonStartDate);
        v.table.ui.thSeasonEndDate.text(v.table.language.thSeasonEndDate);

        $('.systematicYes').text(v.table.language.tdYes);
        $('.systematicNo').text(v.table.language.tdNo);

        $('.monitoringYes').text(v.table.language.tdYes);
        $('.monitoringNo').text(v.table.language.tdNo);

        // main modal
        v.modalEditLocality.ui.lblInpName.text(v.modalEditLocality.language.lblInpName);
        v.modalEditLocality.ui.lblStandardized.text(v.modalEditLocality.language.lblStandardized);
        v.modalEditLocality.ui.lblMonitoring.text(v.modalEditLocality.language.lblMonitoring);


        // modal edit translations
        v.modalTranslations.ui.header.text(v.modalTranslations.language.header);
        v.modalTranslations.ui.allCheckBoxLabels.text(v.modalTranslations.language.formCheckLabel);
        v.modalTranslations.ui.btnAdd.text(v.modalTranslations.language.btnAdd);
        v.modalTranslations.ui.btnSave.text(v.modalTranslations.language.btnSave);
        v.modalTranslations.ui.btnCancel.text(v.modalTranslations.language.btnCancel);

    }


    $('.closeModal').on('click', function(){
        v.modalEditLocality.ui.window.modal('hide');
        v.modalTranslations.ui.window.modal('hide');
    })


    function loadTable() {

        let tmpHTML = '<tr><td colspan="3">' + mgGetImgSpinner() + '</td></tr>';
        v.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"get",
            url: "getLocations.php",
            success: function(data) {

                let htmlTableRows = "";
                let locations = JSON.parse(data);

                //create and populate the table rows
                let l = locations.length;
                for (let i = 0; i < l; i++) {
                    htmlTableRows +=  '<tr id="' + locations[i]["ID"] + '">';
                    htmlTableRows +=  '<td>' + locations[i]["TEXT"] + '</td>';
                    let systematic = "systematicNo";
                    if (locations[i]["SYSTEMATIC"] === '1'){
                        systematic = "systematicYes";
                    }
                    htmlTableRows += '<td class="text-center"><span class="' + systematic + '"></span>' + '</td>';

                    let monitoring = "monitoringNo";
                    if (locations[i]["MONITORING"] === '1'){
                        monitoring = "monitoringYes";
                    }
                    htmlTableRows += '<td class="text-center"><span class="' + monitoring + '"></span>' + '</td>';

                    htmlTableRows +=  '</tr>';
                    htmlTableRows +=  mgGetDataRow(locations[i]["ID"], 3);

                }
                v.table.ui.bodySection.empty().append(htmlTableRows);
                
                if ((v.modalMode === 'add') && (v.modalMode === 'edit')){

                    v.table.ui.filterBox.val( v.searchAfterUpdate );
                    v.table.ui.filterBox.trigger('input');
                    v.selectedRow = $( 'tr#' + v.writtenId );
                    handleSelectedRow(v);
                    v.modalMode = '';
                    v.writtenId = 0;

                }


            }
        });

    }


    function refreshDetailSection(){

        let row = $('#dataFor-' + v.mainTableId);
        row.empty().html('<td colspan="3">' + mgGetDataRow() + '</td>');

        $.ajax({
            type:"get",
            url: "getLocationTranslations.php?id=" + v.mainTableId,
            success: function(data) {

                let translations = JSON.parse(data);

                let header = '<h6>' + v.table.language.tblInTblHeader + '</h6>';
                if (translations.length === 0){
                    header = '<h6>' + v.table.language.tblInTblHeaderNoContent +'</h6>';
                }
                let dataHTML = '<td colspan="3">' + header;

                // Populate the detail section with all translations
                let translationTexts = "";
                let l = translations.length;
                for (let i = 0; i < l; i++) {
                    translationTexts +=  '<span class="mg-80-span">' + translations[i].LANGUAGE_TEXT + '</span>' + translations[i].LOCALITY_TEXT + '<br/>';
                }

                dataHTML += translationTexts + '</td>';
                row.empty().append(dataHTML);

            }
        });

    }

    v.controlPanel.ui.version.text('Ver 1.0');
    v.language.current = $('#systemLanguageId').text();
    getLangTexts();
    loadTable();
    setLangTexts();

    setEditButtonsOnOff(v);

});