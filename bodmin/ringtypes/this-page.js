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
                filterBox : $('#tblFilterBox'),
                bodySection : $('#data tbody'),
                thName : $('#thName'),
                thType : $('#thType')
            }
        },

        modalEditRingType : {
            ui : {
                window : $('#editMain'),
                header : $('#modalMainHeader'),
                sectionDelete : $('#modalMainDeleteSection'),
                sectionEdit : $('#modalMainEditSection'),

                // labels, fields and warnings
                warningTextsAll : $("small[id^='warning']"),
                warningDateFrom : $('#warningDateFrom'),
                warningDateTo : $('#warningDateTo'),

                lblInpName     : $('#lblInpName'),
                inpName        : $('#inpName'),
                warningInpName : $('#warningInpName'),

                lblInpType     : $('#lblInpType'),
                inpType        : $('#inpType'),
                warningInpType : $('#warningInpType'),

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

        bodmin.modalEditRingType.ui.header.text(bodmin.modalEditRingType.lang.headerNew);

        bodmin.modalEditRingType.action = "add";

        // set button texts
        bodmin.modalEditRingType.ui.btnCancel.text(bodmin.modalEditRingType.lang.btnCancel);
        bodmin.modalEditRingType.ui.btnSave.text(bodmin.modalEditRingType.lang.btnSave);

        // clear all potential error messages
        bodmin.modalEditRingType.ui.warningTextsAll.text('');

        // empty fields
        bodmin.modalEditRingType.ui.inpName.val('');

        bodmin.modalEditRingType.ui.inpName.focus();
        bodmin.modalEditRingType.ui.inpName.addClass("focusedInput");

        // hide delete section and show edit
        bodmin.modalEditRingType.ui.sectionDelete.toggleClass('mg-hide-element', true);
        bodmin.modalEditRingType.ui.sectionEdit.toggleClass('mg-hide-element', false);

        bodmin.modalEditRingType.ui.window.modal('show');

    });


    bodmin.cntrlPanel.ui.btnEdit.click( function(){

        // clear all potential previous error messages
        bodmin.modalEditRingType.ui.warningTextsAll.text('');

        $.ajax({
            type:"get",
            url: "getRingTypeViaId.php?id=" + bodmin.mainTableId,
            success: function(data) {

                bodmin.modalEditRingType.ui.header.text(bodmin.modalEditRingType.lang.headerEdit);

                bodmin.modalEditRingType.action = "edit";

                bodmin.modalEditRingType.ui.btnCancel.text(bodmin.modalEditRingType.lang.btnCancel);
                bodmin.modalEditRingType.ui.btnSave.text(bodmin.modalEditRingType.lang.btnSave);

                // hide delete section and show edit
                bodmin.modalEditRingType.ui.sectionDelete.toggleClass('mg-hide-element', true);
                bodmin.modalEditRingType.ui.sectionEdit.toggleClass('mg-hide-element', false);

                let obj = JSON.parse(data);
                let editItem = obj[0];

                //populate edit form with gotten data
                bodmin.modalEditRingType.ui.inpName.val(editItem.TEXT);
                bodmin.modalEditRingType.ui.inpType.val(editItem.TYPE_CODE);

                bodmin.modalEditRingType.ui.window.modal('show');

            }
        });
    });


    bodmin.cntrlPanel.ui.btnDelete.click( function(){

        bodmin.modalEditRingType.ui.header.text(bodmin.modalEditRingType.lang.headerDelete);

        bodmin.modalEditRingType.action = "delete";

        bodmin.modalEditRingType.ui.btnSave.text(bodmin.modalEditRingType.lang.ja);
        bodmin.modalEditRingType.ui.btnCancel.text(bodmin.modalEditRingType.lang.nej);

        bodmin.modalEditRingType.ui.sectionDelete.toggleClass('mg-hide-element', false);
        bodmin.modalEditRingType.ui.sectionEdit.toggleClass('mg-hide-element', true);

        // populate delete section
        bodmin.modalEditRingType.ui.sectionDelete.html('<h6>' + bodmin.name + '</h6>');

        bodmin.modalEditRingType.ui.window.modal('show');

    });


    bodmin.modalEditRingType.ui.btnSave.click(function(){

        let ok = true;

        // Clear all potential error messages
        bodmin.modalEditRingType.ui.warningTextsAll.text('');

        if (( bodmin.modalEditRingType.action === "add") || ( bodmin.modalEditRingType.action === "edit") ) { // excluding delete

            // name cannot be blank
            ok = (bodmin.modalEditRingType.ui.inpName.val().length > 0);
            if (!ok) {
                bodmin.modalEditRingType.ui.warningInpName.text(bodmin.modalEditRingType.lang.warningInpName);
            }

            // (type_code) type, cannot be blank
            ok = (bodmin.modalEditRingType.ui.inpType.val().length > 0);
            if (!ok) {
                bodmin.modalEditRingType.ui.warningInpType.text(bodmin.modalEditRingType.lang.warningInpName);
            }

        }


        if (ok){

            let formData = new FormData();
            formData.append('mode', bodmin.modalEditRingType.action);

            if ((bodmin.modalEditRingType.action === "add") || (bodmin.modalEditRingType.action === "edit")) {
                formData.append('name', bodmin.modalEditRingType.ui.inpName.val());
                formData.append('type', bodmin.modalEditRingType.ui.inpType.val());
                bodmin.searchAfterUpdate = bodmin.modalEditRingType.ui.inpName.val();
            }

            if ((bodmin.modalEditRingType.action === "edit") || (bodmin.modalEditRingType.action === "delete")) {
                formData.append('id', bodmin.mainTableId);
            }

            if (bodmin.modalEditRingType.action === "delete") {
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

            bodmin.modalEditRingType.ui.window.modal('hide');

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
            url: "getRingTypeTranslations.php?id=" +  bodmin.mainTableId,
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
                hdrMain         : 'Ring type',
                infoLabel       : 'Chose a ring type to activate the buttons',
                infoLabelVald   : 'Chosen: ',
                noPermission    : "You have insufficient user privileges to change data here.",
                btnNew          : "New ring type",
                btnEdit         : "Edit",
                btnDelete       : "Delete",
                btnTranslations : "Translations (name)"
            };

            // table
            bodmin.table.lang = {
            filterBoxPlaceHolder        : 'Filter ring types here',
                // headers
                thName                  : 'Internal name',
                thType                  : 'Relative size',
                tdYes                   : 'Yes',
                tdNo                    : ' - ',
                tblInTblHeader          : "Translations",
                tblInTblHeaderNoContent : "No translations done - yet"
            }

            bodmin.modalEditRingType.lang = {
                headerEdit          : 'Change',
                headerNew           : 'New',
                headerDelete        : 'Delete',
                // field labels
                lblInpName          : 'Name (internal)',
                lblInpType          : 'Relative size',
                warningInpName      : 'Must be given',
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
                hdrMain: 'Ringtyper',
                infoLabel: 'Välj en ringtyp för att aktivera knapparna',
                infoLabelVald: 'Vald: ',
                noPermission: "Du har inte behörighet att ändra data här",
                btnNew: "Ny ringtyp",
                btnEdit: "Ändra",
                btnDelete: "Tag bort",
                btnTranslations: "Översättningar (Namn)"
            };

            // table
            bodmin.table.lang = {
                filterBoxPlaceHolder    : 'Filtrera ringtyper (nedan) här',
                thName                  : 'Internt namn',
                thType                  : 'Relativ storlek',
                tblInTblHeaderNoContent : "Inga översättningar gjorda än",
                tblInTblHeader          : "Översättningar"
            }

            bodmin.modalEditRingType.lang = {
                headerEdit          : 'Ändra',
                headerNew           : 'Ny ringtyp',
                headerDelete        : 'Tag bort',
                // field labels
                lblInpName          : 'Namn (internt)',
                lblInpType          : 'Relativ storlek',
                warningInpName      : 'Måste anges',
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
            $('#loggedStatus').html('<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>");
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
        bodmin.table.ui.thType.text(bodmin.table.lang.thType);

        // main modal
        bodmin.modalEditRingType.ui.lblInpName.text(bodmin.modalEditRingType.lang.lblInpName);
        bodmin.modalEditRingType.ui.lblInpType.text(bodmin.modalEditRingType.lang.lblInpType);

        // modal edit translations
        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header);
        bodmin.modalTranslations.ui.btnAdd.text(bodmin.modalTranslations.lang.btnAdd);
        bodmin.modalTranslations.ui.lblModalTranslation.text(bodmin.modalTranslations.lang.lblModalTranslation);
        bodmin.modalTranslations.ui.lblModalLanguage.text(bodmin.modalTranslations.lang.lblModalLanguage);
        bodmin.modalTranslations.ui.btnSave.text(bodmin.modalTranslations.lang.btnSave);
        bodmin.modalTranslations.ui.btnCancel.text(bodmin.modalTranslations.lang.btnCancel);

    }


    function loadTable() {


        let tmpHTML = '<tr><td colspan="3">' + mgGetImgSpinner() + '</td></tr>';
        bodmin.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"get",
            url: "getRingTypes.php",
            success: function(data) {

                let infoHTML = "";
                let tableData = JSON.parse(data);

                //create and populate the table rows
                for (let i = 0; i < tableData.length; i++) {
                    infoHTML = infoHTML + '<tr id="' + tableData[i]["ID"] + '">';
                    infoHTML = infoHTML + '<td>' + tableData[i]["TEXT"] + '</td>';
                    infoHTML = infoHTML + '<td>' + tableData[i]["TYPE_CODE"] + '</td>';
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
        row.empty().html('<td colspan="1">' + mgGetDataRow() + '</td>');

        $.get("getRingTypeTranslations.php?id=" + bodmin.mainTableId,
            function(data) {

                let translations = JSON.parse(data);

                let header = '<h6>' + bodmin.table.lang.tblInTblHeader + '</h6>';
                if (translations.length === 0){
                    header = '<h6>' + bodmin.table.lang.tblInTblHeaderNoContent +'</h6>';
                }
                let dataHTML = '<td colspan="3">' + header;

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
            formData.append('ring_type_id', bodmin.mainTableId);
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
                    refreshTranslationSection()
                }
            });

        }

    });

    $('#action-info').fadeOut(6000);
    bodmin.lang.current = $('#systemLanguageId').text();
    getLangTexts();
    loadTable();
    setLangTexts();

    setEditButtonsOff();

});

