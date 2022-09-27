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
                thName : $('#thName')
            }
        },

        modalEditTrappingMethod : {
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

        bodmin.modalEditTrappingMethod.ui.header.text(bodmin.modalEditTrappingMethod.lang.headerNew);

        bodmin.modalEditTrappingMethod.action = "add";

        // set button texts
        bodmin.modalEditTrappingMethod.ui.btnCancel.text(bodmin.modalEditTrappingMethod.lang.btnCancel);
        bodmin.modalEditTrappingMethod.ui.btnSave.text(bodmin.modalEditTrappingMethod.lang.btnSave);

        // clear all potential error messages
        bodmin.modalEditTrappingMethod.ui.warningTextsAll.text('');

        // empty fields
        bodmin.modalEditTrappingMethod.ui.inpName.val('');
        bodmin.modalEditTrappingMethod.ui.inpName.focus();
        bodmin.modalEditTrappingMethod.ui.inpName.addClass("focusedInput");

        // hide delete section and show edit
        bodmin.modalEditTrappingMethod.ui.sectionDelete.toggleClass('mg-hide-element', true);
        bodmin.modalEditTrappingMethod.ui.sectionEdit.toggleClass('mg-hide-element', false);

        bodmin.modalEditTrappingMethod.ui.window.modal('show');

    });


    bodmin.cntrlPanel.ui.btnEdit.click( function(){

        // clear all potential previous error messages
        bodmin.modalEditTrappingMethod.ui.warningTextsAll.text('');

        $.ajax({
            type:"get",
            url: "getTrappingMethodViaId.php?id=" + bodmin.mainTableId,
            success: function(data) {

                bodmin.modalEditTrappingMethod.ui.header.text(bodmin.modalEditTrappingMethod.lang.headerEdit);

                bodmin.modalEditTrappingMethod.action = "edit";

                bodmin.modalEditTrappingMethod.ui.btnCancel.text(bodmin.modalEditTrappingMethod.lang.btnCancel);
                bodmin.modalEditTrappingMethod.ui.btnSave.text(bodmin.modalEditTrappingMethod.lang.btnSave);

                // hide delete section and show edit
                bodmin.modalEditTrappingMethod.ui.sectionDelete.toggleClass('mg-hide-element', true);
                bodmin.modalEditTrappingMethod.ui.sectionEdit.toggleClass('mg-hide-element', false);

                let obj = JSON.parse(data);
                let trappingMethod = obj[0];

                //populate edit form with gotten data
                bodmin.modalEditTrappingMethod.ui.inpName.val(trappingMethod.TEXT);

                bodmin.modalEditTrappingMethod.ui.window.modal('show');

            }
        });
    });


    bodmin.cntrlPanel.ui.btnDelete.click( function(){

        bodmin.modalEditTrappingMethod.ui.header.text(bodmin.modalEditTrappingMethod.lang.headerDelete);

        bodmin.modalEditTrappingMethod.action = "delete";

        bodmin.modalEditTrappingMethod.ui.btnSave.text(bodmin.modalEditTrappingMethod.lang.ja);
        bodmin.modalEditTrappingMethod.ui.btnCancel.text(bodmin.modalEditTrappingMethod.lang.nej);

        bodmin.modalEditTrappingMethod.ui.sectionDelete.toggleClass('mg-hide-element', false);
        bodmin.modalEditTrappingMethod.ui.sectionEdit.toggleClass('mg-hide-element', true);

        // populate delete section
        bodmin.modalEditTrappingMethod.ui.sectionDelete.html('<h6>' + bodmin.name + '</h6>');

        bodmin.modalEditTrappingMethod.ui.window.modal('show');

    });


    bodmin.modalEditTrappingMethod.ui.btnSave.click(function(){

        let ok = true;

        // Clear all potential error messages
        bodmin.modalEditTrappingMethod.ui.warningTextsAll.text('');

        if (( bodmin.modalEditTrappingMethod.action === "add") || ( bodmin.modalEditTrappingMethod.action === "edit") ) { // excluding delete

            // name cannot be blank
            ok = (bodmin.modalEditTrappingMethod.ui.inpName.val().length > 0);
            if (!ok) {
                bodmin.modalEditTrappingMethod.ui.warningInpName.text(bodmin.modalEditTrappingMethod.lang.warningInpName);
            }

        }


        if (ok){

            let formData = new FormData();
            formData.append('mode', bodmin.modalEditTrappingMethod.action);

            if ((bodmin.modalEditTrappingMethod.action === "add") || (bodmin.modalEditTrappingMethod.action === "edit")) {
                formData.append('name', bodmin.modalEditTrappingMethod.ui.inpName.val());
                bodmin.searchAfterUpdate = bodmin.modalEditTrappingMethod.ui.inpName.val();
            }

            if ((bodmin.modalEditTrappingMethod.action === "edit") || (bodmin.modalEditTrappingMethod.action === "delete")) {
                formData.append('id', bodmin.mainTableId);
            }

            if (bodmin.modalEditTrappingMethod.action === "delete") {
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

            bodmin.modalEditTrappingMethod.ui.window.modal('hide');

        }

    });


    //-----------------------------------------------------------------------translations--------------
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

        bodmin.modalTranslations.ui.warningTextsAll.text('');

        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header + ' ' + bodmin.name);
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
            url: "getTrappingMethodTranslations.php?id=" +  bodmin.mainTableId,
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
                hdrMain         : 'Trapping methods',
                infoLabel       : 'Chose a trapping method to activate the buttons',
                infoLabelVald   : 'Chosen: ',
                noPermission    : "You have insufficient user privileges to change data here.",
                btnNew          : "New trapping method",
                btnEdit         : "Edit",
                btnDelete       : "Delete",
                btnTranslations : "Translations (name)"
            };

            // table
            bodmin.table.lang = {
            filterBoxPlaceHolder        : 'Filter trapping methods here',
                // headers
                thName                  : 'Internal name',
                tdYes                   : 'Yes',
                tdNo                    : ' - ',
                tblInTblHeader          : "Translations",
                tblInTblHeaderNoContent : "No translations done - yet"
            }

            bodmin.modalEditTrappingMethod.lang = {
                headerEdit          : 'Change',
                headerNew           : 'New',
                headerDelete        : 'Delete',
                // field labels
                warningInpName      : 'Name must be given',
                // button texts
                btnSave             : 'Save',
                btnCancel           : 'Cancel',
                ja                  : "Yes",
                nej                 : "No",
            }

            bodmin.modalTranslations.lang = {
                header: "Manage translations for ",
                formCheckLabel: 'Remove this row when saving.',
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
                hdrMain: 'Fångstmetoder',
                infoLabel: 'Välj en fångstmetod för att aktivera knapparna',
                infoLabelVald: 'Vald: ',
                noPermission: "Du har inte behörighet att ändra data här",
                btnNew: "Ny fångstmetod",
                btnEdit: "Ändra",
                btnDelete: "Tag bort",
                btnTranslations: "Översättningar (Namn)"
            };

            // table
            bodmin.table.lang = {
                filterBoxPlaceHolder    : 'Filtrera data nedan här',
                thName                  : 'Internt namn',
                tblInTblHeaderNoContent : "Inga översättningar gjorda än",
                tblInTblHeader          : "Översättningar"
            }

            bodmin.modalEditTrappingMethod.lang = {
                headerEdit          : 'Ändra',
                headerNew           : 'Ny fångstmetod',
                headerDelete        : 'Tag bort',
                // field labels
                lblInpName          : 'Namn (internt)',
                // button texts
                btnSave             : 'Spara',
                btnCancel           : 'Avbryt',
                ja                  : "Ja",
                nej                 : "Nej"
            }

            bodmin.modalTranslations.lang = {
                header: "Hantera översättningar för ",
                formCheckLabel: 'Tag bort denna rad (vid spara).',
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

        // main modal
        bodmin.modalEditTrappingMethod.ui.lblInpName.text(bodmin.modalEditTrappingMethod.lang.lblInpName);

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
            url: "getTrappingMethods.php",
            success: function(data) {

                let infoHTML = "";
                let tableData = JSON.parse(data);

                //create and populate the table rows
                for (let i = 0; i < tableData.length; i++) {
                    infoHTML = infoHTML + '<tr id="' + tableData[i]["ID"] + '">';
                    infoHTML = infoHTML + '<td>' + tableData[i]["TEXT"] + '</td>';
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

        $.get("getTrappingMethodTranslations.php?id=" + bodmin.mainTableId,
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
            formData.append('trapping_method_id', bodmin.mainTableId);
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

