$(document).ready(function () {

    let bodmin = {};
    bodmin.lang = {};
    bodmin.lang.current = $('#systemLanguageId').text();
    bodmin.searchAfterUpdate = "";

    bodmin.modalMode = "";

    bodmin.cntrlPanel = {
        ui: {
            hdrMain: $('#hdrMain'),
            infoLabel: $('#infoLabel'),
            selectInfo: $('#selectedRowIdentifier'),
            btnNew: $('#btnNew'),
            btnEdit: $('#btnEdit'),
            btnDelete: $('#btnDelete'),
            btnTranslations: $('#btnTranslations'),
            editActionInfo : $('#actionI'),
            dataTableSection : $('#dataTableSection'),
            infoIntro : $('#infoPanelIntro')
        }
    };

    bodmin.table = {
        ui: {
            filterBox: $('#tblFilterBox'),
            bodySection: $('#data tbody'),
            thCategory: $('#tblHdrCategory'),
            thKeyword: $('#tblHdrKeyword'),
            tableInTableHeader : $('#tblInTblHeader')
        }
    };

    bodmin.modalEditKeyword = {
        ui: {

            window: $('#editMain'),
            header: $('#modalMainHeader'),
            sectionDelete: $('#modalMainDeleteSection'),
            sectionEdit: $('#modalMainEditSection'),

            // labels, fields and warnings
            warningTextsAll: $("small[id^='warning']"),

            lblddCategory: $('#lblddCategory'),

            lblInpDescription: $('#lblInpDescription'),
            inpDescription: $('#inpDescription'),
            warningInpDescription: $('#warningInpDescription'),

            ddKeyWordCategory: $('#ddCategory'),

            btnSave: $('#btnModalMainSave'),
            btnCancel: $('#btnModalMainCancel')

        }
    };

    bodmin.modalTranslations = {
        ui: {
            window: $('#modalEditTranslation'),
            header: $('#modalTranslationsHeader'),
            allCheckBoxLabels: $('label.formCheckLabel'),
            btnAdd: $('#btnTranslationAdd'),
            btnSave: $('#btnTranslationsSave'),
            btnCancel: $('#btnTranslationsCancel')
        }
        // lang : defined below in setLangTexts
    };

    refreshKeywordTable();
    populateKeywordCategoryDropDown();


    function swapLanguage() {

        if (bodmin.lang.current === '1') {
            bodmin.lang.current = '2';
            bodmin.lang.langAsString = 'se';

        } else {
            bodmin.lang.current = '1';
            bodmin.lang.langAsString = 'en';
        }

        setLangTexts();

    }

    //-------------------------------------------------------- M A I N  T A B L E select, filter and maintenance -------

    //  select row in the table
    $(document).on("click", "#data tbody tr", function () {

        let selectedRow = $(this);

        if (selectedRow.hasClass('mg-table-row-data')) {
            selectedRow = selectedRow.prev();
        }

        selectedRow.siblings().removeClass('table-active');
        selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        selectedRow.next().removeClass('mg-hide-element');

        $('button').prop('disabled', false);

        bodmin.mainTableId = selectedRow.attr('id');

        bodmin.name = $(selectedRow).find("td").eq(0).text() + ' - ' + $(selectedRow).find("td").eq(1).text();
        bodmin.searchTerm = bodmin.name;

        bodmin.cntrlPanel.ui.infoIntro.text(bodmin.cntrlPanel.lang.introSelected);
        bodmin.cntrlPanel.ui.selectInfo.text(bodmin.name);

        refreshTranslationSection();

    });


    function refreshTranslationSection() {

        let row = $('#dataFor-' + bodmin.mainTableId);
        row.empty();
        row.html(mgGetImgSpinner());


        $.ajax({
            type: "get",
            url: "getKeywordTranslations.php?id=" + bodmin.mainTableId,
            success: function (data) {

                let translations = JSON.parse(data);

                let header = '<h6><span class="translationsHeader"></span></h6>';
                if (translations.length === 0) {
                    header = '<h6><span class="translationsHeaderNoContent">Xxxxx</span></h6>';
                }
                let dataHTML = '<td colspan="2">' + header;

                // Populate the details section with all translations
                for (let i = 0; i < translations.length; i++) {
                    dataHTML = dataHTML + translations[i].LANGUAGE + ' ' + translations[i].TEXT + '<br/>';
                }

                dataHTML = dataHTML + '</td>';

                row.empty();
                row.append(dataHTML);

                setLangTexts();
            }
        });


    }

    // filter the table
    bodmin.table.ui.filterBox.on('input', function () {

        let value = $(this).val().toLowerCase();

        $("#data tbody tr").filter(function () {
            let hay = $(this).text();
            let currentRow = $(this);

            if (currentRow.hasClass('mg-table-row-data')) {
                // The person row this data belongs to may be filtered out. Hide it.
                currentRow.addClass('mg-hide-element');
            } else {
                currentRow.toggle(checkFilterString(hay, value));
            }

        });

    });


    function checkFilterString(hay, needles) {

        let i;
        let words = needles.toLowerCase().split(" ");
        let answer = true;

        for (i = 0; i < words.length; i++) {

            answer = (hay.toLowerCase().indexOf(words[i]) > -1);
            if (answer === false) {
                break;
            }

        }

        return answer;

    }


    bodmin.cntrlPanel.ui.btnEdit.click(function () {

        bodmin.modalEditKeyword.ui.warningInpDescription.empty();
        bodmin.modalMode = "edit";

        $.ajax({
            type: "get",
            url: "getKeywordViaId.php?id=" + bodmin.mainTableId,
            success: function (data) {

                bodmin.modalMode = "edit";
                bodmin.modalEditKeyword.ui.header.text(bodmin.modalEditKeyword.lang.headerEdit);
                bodmin.modalEditKeyword.ui.btnCancel.text(bodmin.modalEditKeyword.lang.btnCancel);
                bodmin.modalEditKeyword.ui.btnSave.text(bodmin.modalEditKeyword.lang.btnSave);

                // hide delete section
                bodmin.modalEditKeyword.ui.sectionDelete.addClass('mg-hide-element');
                // show other data
                bodmin.modalEditKeyword.ui.sectionEdit.removeClass('mg-hide-element');

                let obj = JSON.parse(data);
                let keyword = obj[0];

                //populate edit form with gotten data
                bodmin.modalEditKeyword.ui.ddKeyWordCategory.val(keyword.KEYWORDCATEGORY_ID);
                bodmin.modalEditKeyword.ui.inpDescription.val(keyword.TEXT);

                bodmin.modalEditKeyword.ui.window.modal('show');

            }
        });

    });


    bodmin.cntrlPanel.ui.btnNew.click(function () {

        bodmin.modalEditKeyword.ui.warningInpDescription.empty();
        bodmin.modalMode = "add";

        bodmin.modalEditKeyword.ui.header.text(bodmin.modalEditKeyword.lang.headerNew);
        bodmin.modalEditKeyword.ui.btnCancel.text(bodmin.modalEditKeyword.lang.btnCancel);
        bodmin.modalEditKeyword.ui.btnSave.text(bodmin.modalEditKeyword.lang.btnSave);

        // hide delete section
        bodmin.modalEditKeyword.ui.sectionDelete.addClass('mg-hide-element');
        // show other data
        bodmin.modalEditKeyword.ui.sectionEdit.removeClass('mg-hide-element');

        // empty and default fields
        bodmin.modalEditKeyword.ui.inpDescription.val('');

        bodmin.modalEditKeyword.ui.window.modal('show');

    });


    bodmin.cntrlPanel.ui.btnDelete.click(function () {

        bodmin.modalEditKeyword.ui.header.text(bodmin.modalEditKeyword.lang.headerDelete);
        bodmin.modalMode = "delete";

        bodmin.modalEditKeyword.ui.btnSave.text(bodmin.modalEditKeyword.lang.ja);
        bodmin.modalEditKeyword.ui.btnCancel.text(bodmin.modalEditKeyword.lang.nej);

        // hide edit section
        bodmin.modalEditKeyword.ui.sectionEdit.addClass('mg-hide-element');

        // get some reasonable identifier for the delete warning
        $('#recInfo').attr('value', bodmin.name);

        // populate and make delete section visible
        bodmin.modalEditKeyword.ui.sectionDelete.html('<h6>' + bodmin.name + '</h6>');
        bodmin.modalEditKeyword.ui.sectionDelete.removeClass('mg-hide-element');
        bodmin.modalEditKeyword.ui.window.modal('show');

    });


    bodmin.modalEditKeyword.ui.btnSave.click(function () {

        let ok = true;

        if ((bodmin.modalMode === "add") || (bodmin.modalMode === "edit")) { // excluding delete

            // Check filled out field
            ok = bodmin.modalEditKeyword.ui.inpDescription.val().length > 0;
            if (!ok) {
                $('#descriptionWarningText').html('<span id="theDescriptionWarningTextNotFilledOut"></span>');
            }

            // Check unique description (name), within the category
            if (ok) {

                let exclude = "0"; // dummy when adding keyword, 0 does not exist. So the same SQL can be used for check below.
                if (    bodmin.modalMode === "edit") {
                    exclude = bodmin.mainTableId;
                }

                $.ajax({
                    type: "get",
                    async: false,
                    url: "getAllKeyWordsButOneWithinCategory.php?category=" + bodmin.modalEditKeyword.ui.ddKeyWordCategory.val() + '&exclude=' + exclude,
                    success: function (data) {

                        let textsList = JSON.parse(data);
                        for (let i = 0; i < textsList.length; i++) {
                            if (textsList[i].TEXT === bodmin.modalEditKeyword.ui.inpDescription.val()) {
                                ok = false;
                                bodmin.modalEditKeyword.ui.warningInpDescription.html('<span id="theDescriptionWarningTextNotUnique">hoho</span>');
                                break;
                            }
                        }

                    }
                });

            }

        }

        if (ok) {

            let formData = new FormData();
            formData.append('mode',     bodmin.modalMode);

            if ((bodmin.modalMode === "add") || (bodmin.modalMode === "edit")) {
                formData.append('keyword_category_id', bodmin.modalEditKeyword.ui.ddKeyWordCategory.val());
                formData.append('keyword_text', bodmin.modalEditKeyword.ui.inpDescription.val());
                bodmin.searchAfterUpdate = bodmin.modalEditKeyword.ui.inpDescription.val();
            }

            if (bodmin.modalMode === "edit" || (bodmin.modalMode === "delete")) {
                formData.append('keyword_id', bodmin.mainTableId);
            }

            if (bodmin.modalMode === "delete") {
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
                    refreshKeywordTable();
                }
            });

            bodmin.modalEditKeyword.ui.window.modal('hide');

        } else {
            // Not ok, set texts again so error message(s) appear Magnus -- is this needed???
            setLangTexts();
        }

    });

    // clear (if present) error messages on input
    bodmin.modalEditKeyword.ui.inpDescription.on('input', function () {
        bodmin.modalEditKeyword.ui.warningInpDescription.empty();
    });


    function refreshKeywordTable() {

        let tmpHTML = '<tr><td colspan="3">' + mgGetImgSpinner() + '</td></tr>';
        bodmin.table.ui.bodySection.empty().append(tmpHTML);

        $('#actionInfo').show().fadeOut(16000)

        $.ajax({
            type: "GET",
            async: true,
            dataType: "json",
            url: "../api/getKeywordTableData.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let i;
                let rows = "";
                for (i = 0; i < data.length; i++) {

                    let value = data[i];
                    rows = rows + '<tr id="' + value.KEYWORD_ID + '">';
                    rows = rows + '<td>' + value.KEYWORDCATEGORY_TEXT + '</td>';
                    rows = rows + '<td>' + value.KEYWORD_TEXT + '</td>';
                    rows = rows + '</tr>';
                    rows = rows + '<tr id="dataFor-' + value.KEYWORD_ID + '" class="mg-table-row-data mg-hide-element"><td colspan="2">';
                    rows = rows + '<br/>';
                    rows = rows + '<img src="../aahelpers/img/loading/ajax-loader.gif" alt="Loading" class="mx-auto d-block">';
                    rows = rows + '<br/>';
                    rows = rows + '</td></tr>';

                }

                // finalize and swap
                bodmin.table.ui.bodySection.empty().append(rows);

                bodmin.cntrlPanel.ui.editActionInfo.removeClass('add edit delete')

                if (bodmin.modalMode === "add") {
                    bodmin.cntrlPanel.ui.editActionInfo.addClass('add');
                }

                if (bodmin.modalMode === "edit") {
                    bodmin.cntrlPanel.ui.editActionInfo.addClass('edit');
                }

                if (bodmin.modalMode === "delete") {
                    bodmin.cntrlPanel.ui.editActionInfo.addClass('delete');
                }

                setLangTexts();
                setEditButtonsOff();

                bodmin.cntrlPanel.ui.infoIntro.text(bodmin.cntrlPanel.lang.initialInfo);

                bodmin.table.ui.filterBox.val(bodmin.searchAfterUpdate);
                bodmin.table.ui.filterBox.trigger('input');

            }

        });

    }


    //----------------------------------------------------------------------- translations -----------------------------
    bodmin.cntrlPanel.ui.btnTranslations.click(function () {

        $('#forVemNamn').html(bodmin.name);

        // restore to original state - one item div
        let boxar = $('#item-list-item div.row');
        let antalBoxar = boxar.length;

        while (antalBoxar > 1) {
            let lastId = 'item-' + antalBoxar;
            $('#' + lastId).remove();
            antalBoxar--;
        }

        // restore to defaults
        let inputBox = $('#id-input-item-1');
        inputBox.prop("disabled", false);
        inputBox.val('');
        $('#warning-item-1').text('');

        $('#cb-item-1').prop("checked", false);

        let theItemSelectBox = $('#id-select-item-1');
        theItemSelectBox.prop("disabled", false);

        $('#not-unique').text('');

        // get earlier entered data
        $.ajax({
            type: "get",
            async: false,
            url: "getKeywordTranslations.php?id=" + bodmin.mainTableId,
            success: function (data) {

                let textsList = JSON.parse(data);

                if (textsList.length > 0) {

                    // populate first, already present box
                    $('#id-input-item-1').val(textsList[0].TEXT);
                    $('#id-select-item-1').val(textsList[0].LANG_ID);

                    //populate the rest of the edit form, if/as needed
                    for (let i = 1; i < textsList.length; i++) {
                        addItemSection();
                        $('#id-input-item-' + (i + 1)).val(textsList[i].TEXT);
                        $('#id-select-item-' + (i + 1)).val(textsList[i].LANG_ID);
                    }
                }

            }
        });

        bodmin.modalTranslations.ui.window.modal('show');


    });


    function addItemSection() {

        // clone the whole section (row)
        let newItemSection = $("#item-1").clone();
        // Check how many boxes we have, so we can name the newly cloned one properly.
        let boxar = $('#item-list-item div.row').length;
        boxar++;
        newItemSection.attr('id', 'item-' + boxar);

        let theInputBox = newItemSection.find('#id-input-item-1');
        theInputBox.attr('id', 'id-input-item-' + boxar);
        theInputBox.attr('name', 'name-input-box-' + boxar);
        theInputBox.val('');
        theInputBox.prop("disabled", false);


        let theCheckBox = newItemSection.find('#cb-item-1');
        theCheckBox.attr('id', 'cb-item-' + boxar);
        theCheckBox.prop("checked", false);

        let theDropDown = newItemSection.find('#id-select-item-1');

        theDropDown.attr('id', 'id-select-item-' + boxar);
        theDropDown.attr('name', 'name-select-item-' + boxar);
        theDropDown.prop("disabled", false);

        let theWarningText = newItemSection.find('#warning-item-1');

        theWarningText.attr('id', 'warning-item-' + boxar);
        theWarningText.text('');

        newItemSection.appendTo("#item-list-item");

    }


    bodmin.modalTranslations.ui.btnAdd.click(function () {
        addItemSection();
        let boxar = $('#item-list-item div.row').length;
        $('#id-select-item-' + boxar).focus();
    });


    bodmin.modalTranslations.ui.btnSave.click(function () {

        let ok = true;

        // check that we have texts in all (enabled) boxes
        let noOfItemsToCheck = $('#item-list-item input[type="text"]').length;

        for (let i = 1; i <= noOfItemsToCheck; i++) {

            let emailBox = $('#id-input-item-' + i);
            if (!emailBox.prop('disabled')) {
                if (emailBox.val().trim() === '') {
                    ok = false;
                    $('#warning-item-' + i).text(bodmin.lang.frmValNoTranslation);
                }
            }

        }

        if (ok) {

            let languageIds = [];
            for (let i = 1; i <= noOfItemsToCheck; i++) {
                if (!$('#cb-item-' + i).is(":checked")) {
                    languageIds.push($('#id-select-item-' + i).val());
                }

            }

            const uniqueLanguageCodes = [...new Set(languageIds)];

            if (uniqueLanguageCodes.length !== languageIds.length) {
                $('#not-unique').text(bodmin.lang.frmValDoubleLanguages);
                ok = false;
            }

        }


        if (ok) {

            bodmin.modalTranslations.ui.window.modal('hide');

            // close the edit box, write the translations, and update the translation section.
            let formData = new FormData();
            formData.append('keyword_id', bodmin.mainTableId);
            $('.form-group.row').each(function (/*i*/) {

                let rowIndex = $(this).attr('id').substr(5);
                let language_id = $('#id-select-item-' + rowIndex).val();
                let translationValue = $('#id-input-item-' + rowIndex).val();
                let cbStatus = $('#cb-item-' + rowIndex).is(":checked")

                if (!cbStatus) {
                    formData.append('language-' + language_id, translationValue);
                }

            });

            $.ajax({
                url: "handleTranslationsData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (/*data*/) {
                    refreshTranslationSection();
                }
            });

        }

    });


    bodmin.modalTranslations.ui.window.on("click", "input[type='checkbox']", function () {
        changeItemBoxStatus($(this));
    });


    // ---------------------------------------------------------------------- miscellaneous ----------------------------
    $('#action-info').fadeOut(6000);


    function setEditButtonsOff() {

        bodmin.cntrlPanel.ui.btnEdit.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnTranslations.prop('disabled', true);
        bodmin.cntrlPanel.ui.btnDelete.prop('disabled', true);

        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type: "get",
            async: false,
            url: "../users/getUserModulePermission.php?userId=" + $('#loggedInUserId').text() + "&moduleId=9",
            success: function (data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {
                    bodmin.cntrlPanel.ui.btnNew.hide();
                    bodmin.cntrlPanel.ui.btnTranslations.hide();
                    bodmin.cntrlPanel.ui.btnDelete.hide();
                    bodmin.cntrlPanel.ui.btnNew.hide();

                    $('#editButtons').html('<br/><small>' + bodmin.lang.noPermission + '.<small>');
                    $('#info').text('');

                }

            }
        });

    }


    function changeItemBoxStatus(checkBox) {

        let theId = checkBox.attr('id');

        // expected (example): cb-item-1, extract the digit(s) at the end
        theId = theId.substr(8, theId.length - 8);

        // now select the corresponding input box
        let theItemBox = $('#id-input-item-' + theId);

        // flip the disabled
        let enabled = theItemBox.prop("disabled");
        let newStatus = !enabled;

        let theItemSelectBox = $('#id-select-item-' + theId);
        theItemBox.prop("disabled", newStatus);
        theItemSelectBox.prop("disabled", newStatus);

    }


    function setLangTexts() {

        // E N G E L S K A
        if (bodmin.lang.current === '1') {

            bodmin.lang.pageTitle = 'Keywords';
            bodmin.lang.langAsString = 'en';

            // header info
            bodmin.lang.loggedinText = 'Logged in as ';
            bodmin.lang.logOutHere = "Log out here";

            bodmin.lang.noPermission = "You do not have permissions to change data here";

            bodmin.cntrlPanel.lang = {

                hdrMain : 'Keywords',
                btnNew : 'New',
                btnEdit : 'Edit',
                btnDelete : 'Remove',
                btnTranslations : 'Translations',
                // user communication
                keywordEdited: 'Keyword updated',
                keywordAdded: ' Keyword added',
                keywordDeleted: 'Keyword and its translations removed',
                initialInfo : 'Select a keyword to activate the buttons',
                introSelected : 'Selected'

            }

            bodmin.table.lang =  {
                filterBox : "Filter keywords here",
                thCategory : "Category",
                thKeyword : "Keyword",
                tblInTblHeader: "Translations",
                tblInTblHeaderNoContent: 'No translations'
            }

            bodmin.modalEditKeyword.lang = {
                headerEdit : 'Change keyword',
                headerNew : 'New keyword',
                headerDelete : 'Remove keyword',
                // field labels
                lblddCategory : 'Category',
                lblInpName : 'Name (internal)',
                warningInpName : 'Name must be given',
                warningInpNameNotUnique: "This keyword already exists.",
                // button texts
                btnSave : 'Save',
                btnCancel : 'Cancel',
                ja : "Yes",
                nej : "No"
            }

            bodmin.modalTranslations.lang = {
                header : "Manage translations for ",
                formCheckLabel : 'Remove this row when saving.',
                btnAdd : "Add translation",
                btnSave : "Save",
                btnCancel : "Cancel",
                frmValDoubleLanguages : "You have two translations in the same language.",
                frmValNoTranslation : "You have to give a translation."
            }


        }

        // S V E N S K A
        if (bodmin.lang.current === '2') {

            bodmin.lang.pageTitle = 'Nyckelord';
            bodmin.lang.langAsString = 'se';

            // header info
            bodmin.lang.loggedinText = 'Inloggad som ';
            bodmin.lang.logOutHere = "Logga ut här";

            bodmin.lang.noPermission = "Du saknar behörigheter för att ändra data här";


            bodmin.lang.frmValDoubleLanguages = "Du har två översättningar på samma språk.";
            bodmin.lang.frmValNoTranslation = "Du måste ange en översättning.";
            bodmin.lang.initialInfo = 'Välj ett nyckelord för att aktivera knapparna.';

            bodmin.cntrlPanel.lang = {

                hdrMain : 'Nyckelord',
                btnNew : 'Nytt',
                btnEdit : 'Ändra',
                btnDelete : 'Tag bort',
                btnTranslations : 'Översättningar',
                // user communication
                keywordEdited: 'Nyckelordet uppdaterat',
                keywordAdded: ' Nyckelord tillagt',
                keywordDeleted: 'Nyckelordet och dess översättningar borttaget',
                initialInfo : 'Välj ett nyckelord för att aktivera knapparna',
                introSelected : 'Valt: '

            }

            bodmin.table.lang =  {
                filterBox : "Filtrera nyckelord här",
                thCategory : "Kategori",
                thKeyword : "Nyckelord",
                tblInTblHeader: "Översättningar",
                tblInTblHeaderNoContent: 'Inga översättningar gjorda'
            }

            bodmin.modalEditKeyword.lang = {
                headerEdit : 'Ändra Nyckelord',
                headerNew : 'Nytt nyckelord',
                headerDelete : 'Tag bort nyckelord',
                // field labels
                lblddCategory : 'Kategori',
                lblInpName : 'Namn (internt)',
                warningInpName : 'Namn måste anges',
                warningInpNameNotUnique: "detta nyckelord finns redan.",
                // button texts
                btnSave : 'Spara',
                btnCancel : 'Avbryt',
                ja : "Ja",
                nej : "Nej"
            }

            bodmin.modalTranslations.lang = {
                header : "Hantera översättningar för ",
                formCheckLabel : 'Tag bort denna rad (vid spara).',
                btnAdd : "Lägg till översättning",
                btnSave : "Spara",
                btnCancel : "Avbryt",
                frmValDoubleLanguages : "Du har två översättningar på samma språk.",
                frmValNoTranslation : "Du måste ange en översättning."
            }


        }

        $(document).attr('title', bodmin.lang.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);

        // top, top, header
        $('#loggedinText').text(bodmin.lang.loggedinText);
        $('#loggedStatus').html('<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>");

        bodmin.cntrlPanel.ui.hdrMain.text(bodmin.cntrlPanel.lang.hdrMain);
        bodmin.cntrlPanel.ui.btnNew.text(bodmin.cntrlPanel.lang.btnNew);
        bodmin.cntrlPanel.ui.btnEdit.text(bodmin.cntrlPanel.lang.btnEdit);
        bodmin.cntrlPanel.ui.btnDelete.text(bodmin.cntrlPanel.lang.btnDelete);
        bodmin.cntrlPanel.ui.btnTranslations.text(bodmin.cntrlPanel.lang.btnTranslations);

        // main table
        bodmin.table.ui.filterBox.attr('placeholder', bodmin.table.lang.filterBox);
        bodmin.table.ui.thCategory.text(bodmin.table.lang.thCategory);
        bodmin.table.ui.thKeyword.text(bodmin.table.lang.thKeyword);
            // table in table header
        bodmin.table.ui.tableInTableHeader.text(bodmin.table.lang.tblInTblHeader);
        $('.translationsHeaderNoContent').html(bodmin.table.lang.tblInTblHeaderNoContent);
        $('.translationsHeader').html(bodmin.table.lang.tblInTblHeader);

        // modal edit table data
        bodmin.modalEditKeyword.ui.header.text(bodmin.modalEditKeyword.lang.header);
        bodmin.modalEditKeyword.ui.lblddCategory.text(bodmin.modalEditKeyword.lang.lblddCategory);
        bodmin.modalEditKeyword.ui.lblInpDescription.text(bodmin.modalEditKeyword.lang.lblInpDescription);

        // user communication
        $('.add').text(bodmin.cntrlPanel.lang.keywordAdded);
        $('.edit').text(bodmin.cntrlPanel.lang.keywordEdited);
        $('.delete').text(bodmin.cntrlPanel.keywordDeleted);

        // main modal
        bodmin.modalEditKeyword.ui.lblInpDescription.text(bodmin.modalEditKeyword.lang.lblInpName);

        // modal edit translations
        bodmin.modalTranslations.ui.header.text(bodmin.modalTranslations.lang.header);
        bodmin.modalTranslations.ui.allCheckBoxLabels.text(bodmin.modalTranslations.lang.formCheckLabel);
        bodmin.modalTranslations.ui.btnAdd.text(bodmin.modalTranslations.lang.btnAdd);
        bodmin.modalTranslations.ui.btnSave.text(bodmin.modalTranslations.lang.btnSave);
        bodmin.modalTranslations.ui.btnCancel.text(bodmin.modalTranslations.lang.btnCancel);

    }


    function populateKeywordCategoryDropDown() {

        // keywords
        $.ajax({
            type: "get",
            url: "../api/getAllKeywordCategories.php?lang=" + bodmin.lang.current,
            success: function (data) {

                let keyw = JSON.parse(data);
                for (let i = 0; i < keyw.length; i++) {
                    bodmin.modalEditKeyword.ui.ddKeyWordCategory.append($("<option></option>").attr("value", keyw[i].ID).text(keyw[i].TEXT));
                }

            }
        });
    }


})

