$(document).ready(function(){

    let v = {

        ui : {
            tblFilterBox : $('#tblFilterBox'),
            dataTableBody : $('#data tbody'),

            // control panel elements
            controlPanel : {
                infoLabel : $('#infoPanel'),
                selectedIntro : $('#selectedIntro'),
                selectedLanguageInfo : $('#selLanguage'),
                infoIntroSelectedKeywords : $('#infoIntroSelectedKeywords'),
                infoSelectedKeywords : $('#infoSelectedKeywords'),
                ddLanguage : $('#ddLanguage'),
                selectInfoBody : $('#selectInfoBody'),
                selectInfoHeader : $('#selectInfoHeader'),
                help : $('#help'),
            },


            // buttons & info section
            // left hand side
            btnEdit : $('#btnEdit'),
            btnNew : $('#btnNew'),
            btnDelete : $('#btnDelete'),
            btnShow : $('#btnShow'),
            selectedImagePanel : $('#info'),
            editActionInfo : $('#actionI'),

            // modal stuff
            mainTableModal : $('#editMainTable'),  // the modal box
            mainModalTableForm : $('#editPhotoForm'),
            modalHeader : $('#modalHeader'),

            /// sections
            editSection : $('#editSection'),
            deleteSection : $('#deleteSection'),

            /// fields
            modalTaxaDropDown : $('#slctTaxa'),
            modalLanguageDropDown : $('#slctLanguage'),
            modalKeywordsDropDown : $('#slctKeywords'),

            inputBoxTitle : $('#inpTitle'),
            inputBoxAuthor : $('#inpAuthor'),
            inputBoxJournal : $('#inpJournal'),
            inputBoxYear : $('#inpYear'),
            checkBoxPublished : $('#cbPublished'),


            /// collections
            selectedTaxa : $('#selectedTaxa'),
            selectedKeywords : $('#selectedKeywords'),

            // Modal buttons
            btnSaveMainModal : $('#btnSaveMainModal'),
            btnCancelMainModal : $('#btnCancelMainModal'),

            // warning texts for the modal
            dateWarningText : $('#dateWarningText'),
            selectedTaxaWarningText : $('#selectedTaxaWarningText'),
            selectedKeywordsWarningText : $('#selectedKeywordsWarningText'),
            selectedTitleWarningText : $('#selectedTitleWarningText'),
            
        },

        language : {
            current : $('#systemLanguageId').text()
        },

        loggedinUserId : $('#loggedInUserId').text(),
        
    
        // element we use often below

    };

    // -----------------------------------------------------------table handling -------------------------------
    $(document).on("click", ".publicationRecord", function(){
        v.selectedRow = $(this);
        handleSelectedRow();
    });


    function handleSelectedRow(){

        if (v.selectedRow.hasClass('mg-table-row-data')){
            v.selectedRow = v.selectedRow.prev();
        }

        v.selectedRow.siblings().removeClass('table-active');
        v.selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        v.selectedRowsDataRow = v.selectedRow.next();
        v.selectedRowsDataRow.removeClass('mg-hide-element');

        $('button').prop('disabled', false);

        v.mainTableId = v.selectedRow.attr('id');
        v.name = $(v.selectedRow).find(".tblMetaDataTitle").text();

        v.ui.controlPanel.infoLabel.html(v.language.controlPanel.infoLabelVald + ' ' + '<strong>' + v.name + '</strong>') ;

    }


    v.ui.tblFilterBox.on('input', function() {

        let value = $(this).val().toLowerCase();
        $("#data tbody tr").filter(function() {
            let hay = $(this).text();
            let currentRow = $(this);
            currentRow.toggle(mgCheckFilterString(hay, value));

        });

    });


    v.ui.modalTaxaDropDown.change(function() {

        let selected = $("#slctTaxa option:selected" );
        if (!getListOfSelectedTaxa().includes(selected.val())){
            $('#selectedTaxa').append('<li class="mgLiInline" id="' + selected.val() + '">'  + selected.text() + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
        }

    });


    function getListOfSelectedTaxa(){

        let taxaIds = [];
        $('#selectedTaxa li').each(function( /*index*/ ) {
            taxaIds.push($( this ).attr('id'));
        });

        return taxaIds.toString();

    }


    v.ui.modalKeywordsDropDown.change(function() {

        let selected = $("#slctKeywords option:selected" );
        if (!getListOfSelectedKeywords().includes(selected.val())){
            $('#selectedKeywords').append('<li class="mgLiInline" id="' + selected.val() + '">'  + selected.text() + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
        }

    });


    function getListOfSelectedKeywords(){

        let keywordIds = [];

        $('#selectedKeywords li').each(function( /* index*/ ) {
            keywordIds.push($( this ).attr('id'));
        });

        return keywordIds.toString();

    }


    v.ui.selectedKeywords.on('click', '.itemSelected', function(){
        $( this ).parent().remove();
    });


    v.ui.selectedTaxa.on('click', '.itemSelected', function(){
        $( this ).parent().remove();
    });


    v.ui.btnEdit.click( function(){

        $.ajax({
            type:"GET",
            url: "getPublicationViaId.php?id=" + v.mainTableId,
            success: function(data) {

                v.ui.modalHeader.text(v.language.modalHeaderEdit);
                v.modalMode = 'edit';

                clearWarningTextsInModal();

                // hide and show sections ..
                v.ui.deleteSection.toggleClass('mg-hide-element', true);
                v.ui.editSection.toggleClass('mg-hide-element', false);
                // .. and buttons
                v.ui.btnCancelMainModal.toggleClass('mg-hide-element', false);
                v.ui.btnSaveMainModal.toggleClass('mg-hide-element', false);

                // set button texts
                v.ui.btnCancelMainModal.text(v.language.cancel);
                v.ui.btnSaveMainModal.text(v.language.save);

                let obj = JSON.parse(data);
                let publication = obj[0];

                // populate edit form with gotten data
                v.ui.inputBoxYear.val(publication['YEAR']);
                v.ui.inputBoxTitle.val(publication['TITLE']);
                v.ui.inputBoxAuthor.val(publication['AUTHOR']);
                v.ui.inputBoxJournal.val(publication['JOURNAL']);

                if (publication.PUBLISHED === '1'){
                    v.ui.checkBoxPublished.prop('checked', true);
                }


                // clean previously added
                $('#selectedKeywords').empty();
                $('#selectedTaxa').empty();

                // get selected keywords
                $.ajax({
                    type:"GET",
                    url: "getKeywordsForPublication.php?id=" + v.mainTableId + "&lang=" + v.language.current,
                    success: function(data) {

                        let keywords = JSON.parse(data);
                        $.each(keywords, function(index, value) {
                            $('#selectedKeywords').append('<li class="mgLiInline" id="' + value.KEYWORD_ID + '">' + value.TEXT + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
                        });


                    }
                });

                // get already selected taxa
                $.ajax({
                    type:"GET",
                    url: "getTaxaForPublicationViaId.php?id=" + v.mainTableId + "&lang=" + v.language.current,
                    success: function(data) {

                        let keywords = JSON.parse(data);
                        $.each(keywords, function(index, value) {
                            $('#selectedTaxa').append('<li class="mgLiInline" id="' + value.TAXA_ID + '">' + value.NAME + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
                        });

                    }
                });

                v.ui.mainTableModal.modal('show');
            }

        });

    });


    v.ui.btnSaveMainModal.click(function(){

        clearWarningTextsInModal();

        let ok = true;

        if ((v.ui.modalMode === "add") || (v.ui.modalMode === "edit")) {

            // Date, species location, keywords
            ok = validateDate();

            if (ok) {
                ok = validateTaxaAndKeywords();
            }


        }

        // =======================================================================================================

        if (ok) {

            let formData = new FormData();

            formData.append('mode', v.ui.modalMode);
            formData.append('currentId', currentId);
            formData.append('taxaIds', getListOfSelectedTaxa());
            formData.append('keywordIds', getListOfSelectedKeywords());

            let published = '0';
            if (v.ui.checkBoxPublished.is(':checked')) {
                published = '1';
            }
            formData.append('published', published);

            formData.append('title', v.ui.inputBoxTitle.val());
            formData.append('author', v.ui.inputBoxAuthor.val());
            formData.append('journal', v.ui.inputBoxJournal.val());
            formData.append('year', v.ui.inputBoxYear.val());

            $.ajax({
                url: "handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (/*data, textStatus, jqXHR*/) {
                    reSetDataTable();
                }
            });


            v.ui.mainTableModal.modal('hide');

            if ((v.ui.modalMode === "add") || (v.ui.modalMode === "edit")) {

            }


        } else {
            $("#tabs").tabs("option", "active", 1);
        }

    });


    function validateDate(){

        let data = v.ui.inputBoxYear.val();
        let ok = true;

        if (data.length === 0){
            ok = false;
            dateWarningText.text(v.language.dateWarningText);
        } else {
            let year = data.substring(0,3);
            if (year < '1951'){
                ok = false;
                dateWarningText.text(v.language.tooOldDate);
            }
        }

        return ok;
    }


    function validateTaxaAndKeywords(){

        let ok = true;
        if (($('#selectedTaxa li').length === 0 ) && ($('#selectedKeywords li').length === 0 )){
            v.ui.selectedTaxaWarningText.text(v.language.selectedTaxaWarningText);
            v.ui.selectedKeywordsWarningText.text(v.selectedTaxaWarningText);
            ok = false;
        }

        return ok;
    }


    function clearWarningTextsInModal(){

        v.ui.dateWarningText.text("");
        v.ui.selectedTaxaWarningText.text("");
        v.ui.selectedKeywordsWarningText.text("");
        v.ui.selectedTitleWarningText.text("");

    }


    v.ui.btnNew.click( function(){

        v.ui.modalHeader.text(v.language.modalHeaderNew);
        v.ui.modalMode = 'add';

        v.ui.btnCancelMainModal.text(v.language.cancel);
        v.ui.btnSaveMainModal.text(v.language.save);

        clearWarningTextsInModal();

        // hide and show sections
        v.ui.deleteSection.toggleClass('mg-hide-element', true);
        v.ui.editSection.toggleClass('mg-hide-element', false);

        // .. and show buttons
        v.ui.btnCancelMainModal.toggleClass('mg-hide-element', false);
        v.ui.btnSaveMainModal.toggleClass('mg-hide-element', false);


        // empty and default field(s), date to today
        //inputBoxYear.val((new Date()).toISOString().split('T')[0]);

        v.ui.mainTableModal.modal('show');

    });


    v.ui.btnDelete.click( function(){

        v.ui.modalHeader.text(v.language.deletePublication);

        v.ui.modalMode = 'delete';

        v.ui.btnSaveMainModal.toggleClass('mg-hide-element', false);
        v.ui.btnSaveMainModal.text(v.language.ja);
        v.ui.btnCancelMainModal.text(v.language.nej);

        // hide other sections
        v.ui.editSection.toggleClass('mg-hide-element', true);
        v.ui.deleteSection.toggleClass('mg-hide-element', false);

        // populate delete section
        v.ui.deleteSection.html(currentPicURL);

        // and make it visible
        v.ui.deleteSection.removeClass('mg-hide-element');

        v.ui.mainTableModal.modal('show');

    });

/*
    function setEditButtonsOff(){

        v.ui.btnEdit.prop('disabled', true);
        v.ui.btnDelete.prop('disabled', true);
        v.ui.btnShow.prop('disabled', true);

        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type: "GET",
            async: false,
            url: "../users/getUserModulePermission.php?userid=" + v.ui.loggedinUserId + "&moduleid=9",
            success: function(data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {
                    v.ui.btnEdit.hide();
                    v.ui.btnDelete.hide();
                    v.ui.btnNew.hide();

                    $('#editButtons').html('<br/><small>' + v.language.intebehorig + '<small>');
                    v.ui.selectedImagePanel.text('');

                }

            }
        });

    }

 */


    function populateModalDropDowns(){

        // taxa
        $.ajax({
            type: "GET",
            url: "/api/getTaxaData.php?lang=" + v.language.current,
            success: function (data) {

                let thisOption = '<option value="0" selected>' + v.language.ddTaxaNoValue  + '</option>';
                v.ui.modalTaxaDropDown.append(thisOption);

                let taxa = JSON.parse(data);
                for (let i = 0; i < taxa.length; i++) {
                    v.ui.modalTaxaDropDown.append($("<option></option>").attr("value",taxa[i].ID).text(taxa[i].TEXT));
                }

            }
        });


        // keywords
        $.ajax({
            type: "GET",
            url: "/api/getKeywordsForCategory.php?cat=14&lang=" + v.language.current,
            success: function (data) {

                let thisOption = '<option value="0" selected>' + v.language.ddKeywordsNoValue  + '</option>';
                v.ui.modalKeywordsDropDown.append(thisOption);

                let keyw = JSON.parse(data);
                for (let i  = 0; i < keyw.length; i++) {
                    v.ui.modalKeywordsDropDown.append($("<option></option>").attr("value", keyw[i].ID).text(keyw[i].TEXT));
                }

            }
        });

    }


    function setLangTexts() {

        // E N G E L S K A
        if (v.language.current === '1') {

            v.language.langAsString = 'en';
            v.language.cancel = "Cancel";
            v.language.save = "Save";

            v.language.controlPanel = {
                infoLabelVald : "Selected: ",
            }

            // Button texts
            v.language.deletebutton = "Remove";
            v.language.ja = "Yes";
            v.language.nej = "No";
            v.language.ater = "Close";

            v.language.vald = 'Selected= ';


            v.language.title= 'Publications';
                // header info
            v.language.pageTitle = 'Publications';
            v.language.loggedinText = 'Logged in as ';
            v.language.logOutHere = "Log out here";
            v.language.hdrMain = 'Publications';
            v.language.infoLabel = 'Click a publication to activate the buttons';

                // Buttons
            v.language.btnNew = "New photo";
            v.language.btnEdit = "Edit";
            v.language.btnDelete = "Remove";
            v.language.btnCancel = 'Cancel';
            v.language.btnShow = 'Show';
            v.language.btnSaveEditForm = 'Save changes';


                // table
            v.language.tblFilterBox = "Filter data here";

            // modal edit table data
            v.language.modalHeaderNew = "New publication";
            v.language.modalHeaderEdit = "Edit publication";
            v.language.lblTitle = "Title";
            v.language.lblPerson = "Author";
            v.language.lblJournal = "Journal";
            v.language.lblYear = "Year";
            v.language.lblLanguage = "Language";
            v.language.lblTaxa = 'Species';
            v.language.lblKeywords = "Keywords";
            v.language.lblPublished = "Published";
            v.language.ddTaxaNoValue = "--select a species--";
            v.language.ddKeywordsNoValue = "--select a keyword--";
            v.language.headerDelete = 'Delete the publication';

            // warning messages
            v.language.dateWarningText = 'Invalid year entered.';
            v.language.tooOldDate = 'Years older than 1950 not allowed';
            v.language.selectedTaxaWarningText = 'You have to add either one species or one keyword, as a minimum.';
            v.language.selectedTitleWarningText = 'Title field cannot be blank';

            }


        // S V E N S K A
        if (v.language.current === '2') {

            v.language.langAsString = 'se';
            v.language.cancel = "Avbryt";
            v.language.save = "Spara";

            v.language.controlPanel = {
                infoLabelVald : "Vald: ",
            }

            // Button texts
            v.language.deletebutton = "Tag bort";
            v.language.ja = "Ja";
            v.language.nej = "Nej";
            v.language.ater = "Stäng";


            v.language.title= 'Publikationer';
            // header info
            v.language.notLoggedinText = 'Du är ej inloggad';
            v.language.pageTitle = 'Publikationer';
            v.language.loggedinText = 'Inloggad som ';
            v.language.logOutHere = "Logga ut här";
            v.language.hdrMain = 'Publikationer';
            v.language.infoLabel = 'Välj en publikation för att aktivera knapparna';

            // Buttons
            v.language.btnNew = "Ny publikation";
            v.language.btnEdit = "Ändra";
            v.language.btnDelete = "Tag bort";
            v.language.btnCancel = 'Avbryt';
            v.language.btnShow = 'Visa';
            v.language.btnSaveEditForm = 'Spara ändringar';

            // table
            v.language.tblFilterBox = "Filtrera data här";

            // modal edit table data
            v.language.modalHeaderNew = "Ny publikation";
            v.language.modalHeaderEdit = "Ändra publikation";

            v.language.lblTitle = "Titel";
            v.language.lblAuthor = "Författare";
            v.language.lblYear = "År";
            v.language.lblJournal = "Tidskrift";
            v.language.lblLanguage = "Språk";
            v.language.lblTaxa = 'Art(er)';
            v.language.lblKeywords = "Nyckelord";
            v.language.lblPublished = "Publicerad";
            v.language.ddTaxaNoValue = "--välj en art--";
            v.language.ddLanguageNoValue = "--välj ett språk--";
            v.language.ddKeywordsNoValue = "--välj ett nyckelord--";
            v.language.deletePublication = 'Tag bort publikationen?';

            // warning messages
            v.language.dateWarningText = 'Ogiltigt år angivet.';
            v.language.tooOldDate = 'År före 1950 är inte tillåtna.';
            v.language.selectedTaxaWarningText = 'Du måste ange antingen ett nyckelord eller en art.';
            v.language.selectedTitleWarningText = 'Titel måste anges.'

        }

        $(document).attr('title', v.language.pageTitle);
        $("html").attr("lang", v.language.langAsString);
        $('#hdrMain').text(v.language.hdrMain);
        $('#loggedinText').text(v.language.loggedinText);
        $('#selectInfo').text(v.language.selectInfo);
        $('#infoPanel').text(v.language.infoLabel);

        let loggedInInfo = v.language.notLoggedinText;
        if (v.ui.loggedinUserId !== '0'){
            loggedInInfo = '<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + v.language.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);
        $('span.yes').text(v.language.ja);
        $('span.no').text(v.language.nej);

        // all buttons
        v.ui.btnNew.text(v.language.btnNew);
        v.ui.btnEdit.text(v.language.btnEdit);
        v.ui.btnDelete.text(v.language.btnDelete);
        v.ui.btnShow.text(v.language.btnShow);

        // modal
        v.ui.btnCancelMainModal.text(v.language.btnCancel);
        v.ui.btnSaveMainModal.text(v.language.btnSaveEditForm);

        /*
        // user communication
        $('.add').text( v.language.added);
        $('.edit').text( v.language.edited);
        $('.delete').text( v.language.deleted);
*/
        // main table
        v.ui.tblFilterBox.attr('placeholder', v.language.tblFilterBox);

        // modal main
        $('#lblTitle').text(v.language.lblTitle);
        $('#lblAuthor').text(v.language.lblAuthor);        
        $('#lblJournal').text(v.language.lblJournal);
        $('#lblLanguage').text(v.language.lblLanguage);
        $('#lblTaxa').text(v.language.lblTaxa);
        $('#lblKeywords').text(v.language.lblKeywords);
        $('#lblYear').text(v.language.lblYear);
        $('#lblPublished').text(v.language.lblPublished);

    }

    function getAllMetaData(){

        $.ajax({
            type: "GET",
            url: "getAllPublicationMetaData.php",
            success: function (data) {
                v.metaData = JSON.parse(data);
                populateMetaData();
            }
        });
    }

    function reSetDataTable() {

        v.ui.dataTableBody.empty();

        $.ajax({
            type : "GET",
            async: false,
            datatype : "json",
            url: "getAllPublications.php",
            success: function (data) {

                v.publications = JSON.parse(data);

                let i;

                const l = v.publications.length;
                for (i = 0; i < l; i++) {

                    let html = '';
                    let value = v.publications[i];

                    html += html + '<tr id="' + value.ID + '" class="publicationRecord">';

                    html += '<td><strong><span class="tblMetaDataAuthor"></span>' + value.AUTHOR + '</strong> ' ;
                    html += '<span class="tblMetaDataYear"></span>' + value.YEAR + ' ';
                    html += '<span class="tblMetaDataTitle">' + value.TITEL + '</span>' + '<br/>';
                    html += '<span class="tblMetaDataJournal">' + value.JOURNAL  + '</span>';
                    html += '<br/>';
                    html += '<span class="tblMetaDataTextTaxa">' + 'Taxa'  + '</span>: <span id="metaDataTaxaForPublicationId-'+ value.ID + '"></span>';
                    html += '<br/>';
                    html += '<span class="tblMetaDataTextKeyword">' + 'Keywords'  + '</span>: <span id="metaDataKeywordForPublicationId-'+ value.ID + '"></span>';
                    html += '<br/>';
                    html += '</td></tr>';
/*
                    let publishedSection : '<span class="no"></span>';
                    if (value.published === '1'){
                        publishedSection : '<span class="yes"></span>';
                    }

                    html : html + '<span class="tblMetaDataPublished"></span>' + publishedSection + '</td></tr>';

 */
                    v.ui.dataTableBody.append(html);
                }


                if (v.ui.modalMode === "add") {
                    v.ui.editActionInfo.addClass('add');
                }

                if (v.ui.modalMode === "edit") {
                    v.ui.editActionInfo.addClass('edit');
                    v.ui.tblFilterBox.val(imageYear);
                    v.ui.tblFilterBox.trigger('input');

                }

                if (v.ui.modalMode === "delete") {
                    v.ui.editActionInfo.addClass('delete', true);
                }


                setLangTexts();

                getAllMetaData();
                //setEditButtonsOff();



            }

        });
    }

    function populateMetaData(){

        const l = v.publications.length;
        for (let i = 0; i < l; i++){

            // keywords
            $('#metaDataKeywordForPublicationId-' + v.publications[i].ID).text(getKeywordForPublication(v.publications[i].ID));

            // taxa
            $('#metaDataTaxaForPublicationId-' + v.publications[i].ID).text(getTaxaForPublication(v.publications[i].ID));

        }

    }

    function getTaxaForPublication(id){

        let answer = "";
        const l = v.metaData.taxa.length;
        for (let i = 0; i < l; i++){
            if ((v.metaData.taxa[i].ID === id) && (v.metaData.taxa[i].LANG_ID === v.language.current)){
                answer += v.metaData.taxa[i].TEXT;
            }
        }

        return answer;

    }

    function getKeywordForPublication(id){

        let answer = "";
        const l = v.metaData.keywords.length;
        for (let i = 0; i < l; i++){
            if ((v.metaData.keywords[i].ID === id) && (v.metaData.keywords[i].LANG_ID === v.language.current)){
                answer += v.metaData.keywords[i].TEXT;
            }
        }

        return answer;

    }


    $("#tabs").tabs();
    reSetDataTable();
    populateModalDropDowns();


});

