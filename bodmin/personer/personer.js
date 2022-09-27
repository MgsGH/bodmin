$(document).ready(function(){

    let bodmin = {};
    bodmin.lang = {};
    bodmin.lang.current = $('#systemLanguageId').text();

    bodmin.person = {
        id : '0',
        name : '',

    }

    bodmin.table = {
        ui : {
            tblFilterBox : $('#tblFilterBox'),
            bodySection : $('#data tbody'),
            tblHdrForNamn : $('#tblHdrForNamn'),
            tblHdrEfterNamn : $('#tblHdrEfterNamn'),
            tblHdrRefNamn : $('#tblHdrRefNamn'),
            tblHdrSkapadNar : $('#tblHdrSkapadNar'),
            tblInTblHeader : $('#tblInTblHeader')
        }
    }


    bodmin.controlPanel = {
        ui : {
            hdrMain : $('#hdrMain'),
            infoLabel : $('#infoLabel'),
            selectInfo : $('#selectInfo'),
            btnEdit : $('#btnEdit'),
            btnNew : $('#btnNew'),
            btnDelete : $('#btnDelete'),
            btnEmail : $('#btnEmail')
        }
    }


    bodmin.modalEditPerson = {
        ui : {

            window : $('#modalEditPerson'),
            header : $('#modalEditPersonHeader'),
            sectionDelete : $('#modalMainDeleteSection'),
            sectionEdit : $('#modalMainEditSection'),
            passedSection : $('#passedSection'),

            // labels, fields and warnings
            warningTextsAll : $("small[id^='warning']"),

            lblForNamn : $('#lblForNamn'),
            inpForNamn : $('#inpForNamn'),
            warningForName : $('#warningForNamn'),

            lblLastName : $('#lblLastName'),
            inpLastName : $('#inpLastName'),
            warningLastName : $('#warningLastName'),

            lblRefNamn : $('#lblRefNamn'),
            inpRefNamn : $('#inpRefNamn'),

            lblWebSajt : $('#lblWebSajt'),
            inpWebSajt : $('#inpWebSajt'),

            lblWebText : $('#lblWebText'),
            inpWebText : $('#inpWebText'),

            lblSignatureText : $('#lblSignatureText'),
            inpSignatureText : $('#inpSignatureText'),
            warningSignatureText : $('#warningSignatureText'),


            lblPassedAway : $('#lblPassedAway'),
            cbPassedAway : $('#cbPassedAway'),

            btnSave : $('#btnModalEditPersonSave'),
            btnCancel : $('#btnModalEditPersonCancel'),

            modalEditPersonExtraInfo : $('#modalEditPersonExtraInfo')

        }
    }


    bodmin.modalManageEmail = {
        ui: {
            window : $('#modalManageEmail'),
            header : $('#modalManageEmailHeader'),
            allEmailLabels : $('label.lblEmail'),
            allCheckBoxLabels : $('label.formCheckLabel'),
            btnSave : $('#btnModalManageEmailSave'),
            btnCancel : $('#btnModalManageEmailCancel'),
            btnAddEmail : $('#btnModalManageEmailAddEmail')
        }
    }


    setLangTexts();
    setEditButtonsOff();


    ///-----------------------------------  table handling ------------------
    // Select row
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

        bodmin.person.id = selectedRow.attr('id');
        bodmin.person.name = $(selectedRow).find("td").eq(0).text() + ' ' + $(selectedRow).find("td").eq(1).text();
        bodmin.controlPanel.ui.infoLabel.html(bodmin.controlPanel.lang.infoLabelVald + '<strong>' + bodmin.person.name + '</strong>') ;

        $('#info').html('Vald: <span id="fullName"><strong>' + bodmin.person.name + '</strong></span>');

        refreshPersonDataSection();

    });

    // search/filter - multi-word input OK
    bodmin.table.ui.tblFilterBox.on('input', function() {

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

    bodmin.controlPanel.ui.btnEdit.click( function(){

        $.ajax({
            type:"GET",
            url: "getPersonViaId.php?id=" + bodmin.person.id,
            success: function(data) {

                bodmin.modalEditPerson.ui.header.text(bodmin.modalEditPerson.lang.headerEdit + bodmin.person.name);

                bodmin.modalEditPerson.mode = "edit";

                bodmin.modalEditPerson.ui.btnCancel.text(bodmin.modalEditPerson.lang.btnCancel);
                bodmin.modalEditPerson.ui.btnSave.text(bodmin.modalEditPerson.lang.btnSave);

                // clear error messages
                bodmin.modalEditPerson.ui.warningTextsAll.text('');

                // hide delete section
                bodmin.modalEditPerson.ui.sectionDelete.addClass('mg-hide-element');
                // show other data
                bodmin.modalEditPerson.ui.sectionEdit.removeClass('mg-hide-element');

                bodmin.modalEditPerson.ui.passedSection.toggleClass('mg-hide-element', false);

                let obj = JSON.parse(data);
                let person = obj[0];
                //populate edit form with gotten data
                bodmin.modalEditPerson.ui.inpForNamn.val(person.FNAMN);
                bodmin.modalEditPerson.ui.inpLastName.val(person.ENAMN);
                bodmin.modalEditPerson.ui.inpRefNamn.val(person.AUTH_NAME);
                bodmin.modalEditPerson.ui.inpWebSajt.val(person.WEBSAJT);
                bodmin.modalEditPerson.ui.inpWebText.val(person.WEBTEXT);
                bodmin.modalEditPerson.ui.inpSignatureText.val(person.SIGNATURE);

                bodmin.modalEditPerson.ui.cbPassedAway.prop( "checked", false );
                if (person.PASSED === '1') {
                    bodmin.modalEditPerson.ui.cbPassedAway.prop( "checked", true );
                }

                bodmin.modalEditPerson.ui.window.modal('show');

            }
        });
    });

    bodmin.controlPanel.ui.btnNew.click( function(){

        bodmin.modalEditPerson.ui.header.text(bodmin.modalEditPerson.lang.headerNew);

        bodmin.modalEditPerson.mode = "add";

        bodmin.modalEditPerson.ui.btnCancel.text(bodmin.modalEditPerson.lang.btnCancel);
        bodmin.modalEditPerson.ui.btnSave.text(bodmin.modalEditPerson.lang.btnSave);

        // hide delete section
        bodmin.modalEditPerson.ui.sectionDelete.addClass('mg-hide-element');
        // show other data
        bodmin.modalEditPerson.ui.sectionEdit.removeClass('mg-hide-element');

        // do not show passed away on entering a new person
        bodmin.modalEditPerson.ui.passedSection.toggleClass('mg-hide-element', true);

        // clear possible error messages
        bodmin.modalEditPerson.ui.warningTextsAll.text('');

        // empty and default fields
        bodmin.modalEditPerson.ui.inpForNamn.val('');
        bodmin.modalEditPerson.ui.inpLastName.val('');
        bodmin.modalEditPerson.ui.inpRefNamn.val('');
        bodmin.modalEditPerson.ui.inpWebSajt.val('');
        bodmin.modalEditPerson.ui.inpWebText.val('');
        bodmin.modalEditPerson.ui.cbPassedAway.prop( "checked", false );

        bodmin.modalEditPerson.ui.window.modal('show');

    });

    bodmin.controlPanel.ui.btnDelete.click( function(){

        bodmin.modalEditPerson.ui.header.text(bodmin.modalEditPerson.lang.headerDelete);

        bodmin.modalEditPerson.mode = "delete";

        bodmin.modalEditPerson.ui.btnSave.text(bodmin.modalEditPerson.lang.ja);
        bodmin.modalEditPerson.ui.btnCancel.text(bodmin.modalEditPerson.lang.nej);

        // hide largest section
        bodmin.modalEditPerson.ui.sectionEdit.addClass('mg-hide-element');

        // populate delete section
        bodmin.modalEditPerson.ui.sectionDelete.html('<h6>' + bodmin.person.name + '</h6>');
        // and make it visible
        bodmin.modalEditPerson.ui.sectionDelete.removeClass('mg-hide-element');

        bodmin.modalEditPerson.ui.window.modal('show');
    });

    bodmin.controlPanel.ui.btnEmail.click( function(){

        // restore to original state - one email div
        let boxar = $('#email-list div.row');
        let antalBoxar = boxar.length;

        while (antalBoxar > 1){
            let lastId = 'email-' + antalBoxar;
            $('#' + lastId).remove();
            antalBoxar --;
        }

        // restore to default
        let firstInputBox = $('#input-email-1');
        firstInputBox.prop("disabled", false);
        firstInputBox.val('');

        $('#cb-email-1').prop("checked", false);
        $('#not-unique').text('');
        $('#enamnWarningText-1').text('');


        let firstEmailSection = $('#email-1');
        let firstCheckBoxDiv = firstEmailSection.find('#cb-section-1');
        firstCheckBoxDiv.toggleClass('mg-hide-element', false);

        $('#forVemNamn').text(bodmin.person.name);
        $('#emailPersonName').val(bodmin.person.name);


        $('#email-personId').val(bodmin.person.id);
        $.ajax({
            type:"get",
            async: false,
            url: "getPersonEMails.php?id=" + bodmin.person.id,
            success: function(data) {

                let addressList = JSON.parse(data);

        console.log(addressList);

                if (addressList.length > 0 ){
                    // the first, already present email box if we have one email already
                    firstInputBox.val(addressList[0].address);
                }

                //populate edit form, add new boxes as needed
                for (let i = 1; i < addressList.length; i++) {
                    addEmailSection(addressList[i].address);
                }

                if (addressList.length === 0){
                    firstCheckBoxDiv.toggleClass('mg-hide-element', true);
                }

            }
        });

        bodmin.modalManageEmail.ui.window.modal('show');

    });

    bodmin.modalEditPerson.ui.btnSave.click(function(){

        // clear possible error messages
        bodmin.modalEditPerson.ui.warningTextsAll.text('');

        let ok = true;

        if ((bodmin.modalEditPerson.mode === "add") || (bodmin.modalEditPerson.mode === "edit") ) { // excluding password reset and delete

            ok = (bodmin.modalEditPerson.ui.inpForNamn.val().length > 0);
            if (!ok) {
                bodmin.modalEditPerson.ui.warningForName.text(bodmin.modalEditPerson.lang.warningForName);
            } else {
                ok = (bodmin.modalEditPerson.ui.inpLastName.val().length > 0);
                if (!ok) {
                    bodmin.modalEditPerson.ui.warningLastName.text(bodmin.modalEditPerson.lang.warningLastName);
                } else {
                    ok = checkSignature();
                    if (!ok) {
                        bodmin.modalEditPerson.ui.warningSignatureText.text(bodmin.modalEditPerson.lang.warningSignatureTextNotUnique);
                    }
                }
            }
        }

        if (ok) {

            let formData = new FormData();
            formData.append('mode', bodmin.modalEditPerson.mode);

            if ((bodmin.modalEditPerson.mode === "add") || (bodmin.modalEditPerson.mode === "edit")) {
                formData.append('fname', bodmin.modalEditPerson.ui.inpForNamn.val());
                formData.append('ename', bodmin.modalEditPerson.ui.inpLastName.val());
                formData.append('refname', bodmin.modalEditPerson.ui.inpRefNamn.val());
                formData.append('websajt', bodmin.modalEditPerson.ui.inpWebSajt.val());
                formData.append('webtext', bodmin.modalEditPerson.ui.inpWebText.val());
                formData.append('signature', bodmin.modalEditPerson.ui.inpSignatureText.val().trim());
                let passed = '0';
                if (bodmin.modalEditPerson.ui.cbPassedAway.is(':checked')) {
                    passed = '1';
                }
                formData.append('passed', passed);
                bodmin.table.searchAfterUpdate = bodmin.modalEditPerson.ui.inpForNamn.val() + ' ' + bodmin.modalEditPerson.ui.inpLastName.val();
            }

            if ((bodmin.modalEditPerson.mode === "edit") || (bodmin.modalEditPerson.mode === "delete")) {
                formData.append('id', bodmin.person.id);
            }

            if (bodmin.modalEditPerson.mode === "delete") {
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

            bodmin.modalEditPerson.ui.window.modal('hide');
            
            
            
        }

    });


    function checkSignature(){

        let ok = true;

        // only is something (else than space chars) is entered
        if (!bodmin.modalEditPerson.ui.inpSignatureText.val().trim() === ""){

            for (let i = 0; i < bodmin.persons.length; i++) {

                if (bodmin.persons[i]["SIGNATURE"] === bodmin.modalEditPerson.ui.inpSignatureText.val()) {

                    if ((bodmin.modalEditPerson.mode === "edit") && (bodmin.persons[i]["ID"] === bodmin.person.id)){
                        // ignore this hit
                    } else {
                        ok = false;
                        break;
                    }
                }

            }

        }

        return ok;
    }


    //---------------------------------------------------- email ---------------------------
    bodmin.modalManageEmail.ui.window.on("click","input[type='checkbox']",function(){

        let theId = $(this).attr('id');

        // expected (example): cb-email-1
        theId = theId.substr(9, theId.length-9);

        let theEmailBox = $('#input-email-' + theId);

        let enabled = theEmailBox.prop('disabled');
        let newStatus = !enabled;

        theEmailBox.prop("disabled", newStatus);

    });

    bodmin.modalManageEmail.ui.btnAddEmail.click( function(){
        addEmailSection()
    });

    bodmin.modalManageEmail.ui.btnSave.click(function(){

        let ok = true;
        let uniqueText = $('#not-unique');
        uniqueText.text('');
        let noOfEmailBoxes = $('#email-list input[type="email"]').length;

        // build an array to use for testing
        let allEmails = [];
        for (let i=1; i <= noOfEmailBoxes; i++) {
            let theId = '#input-email-' + i;
            let emailBox = $(theId);
            if (!emailBox.prop('disabled')) {
                allEmails.push(emailBox.val());
            }
        }

        // check if any of the emails occurs more than once in the loong string
        if (hasDuplicates(allEmails)) {
            ok = false;
            uniqueText.text(bodmin.lang.uniqueText);
        }

        // if email all addresses in form are unique, check if OK as addresses
        if (ok){
            for (let i=1; i <= noOfEmailBoxes; i++) {
                let theId = '#input-email-' + i;
                let emailBox = $(theId);
                if (!emailBox.prop('disabled')) {
                    let matchThis = emailBox.val();
                    ok = validateEmail(matchThis);
                    if (!ok){
                        let theTextId = '#enamnWarningText-' + i;
                        $(theTextId).text(bodmin.modalManageEmail.lang.invalidEmail);
                        break;
                    }
                }
            }
        }

        if (ok) {

            // Check if any of the email addresses are used by someone else (is in the DB already)
            $.ajax({
                type: "GET",
                async: false,
                url: "getAllPersonsEmailsExcept.php?id=" + bodmin.person.id,
                success: function (data) {
                    let emailList = JSON.parse(data);



                    for (let i=1; i <= noOfEmailBoxes; i++) {
                        let theId = '#input-email-' + i;
                        let emailBox = $(theId);
                        if (!emailBox.prop('disabled')) {
                            let checkThis = emailBox.val();
                            for (let item=0; item < emailList.length; item++){
                                if(checkThis === emailList[item].email){
                                    ok = false;
                                    let theTextId = '#enamnWarningText-' + i;
                                    $(theTextId).text(bodmin.modalManageEmail.lang.alreadyUsed);

                                }
                            }

                        }
                    }
                }
            });
        }

        if (ok) {

            // close the edit box, plug-in the spinner, write the translations, and update the email section.
            bodmin.modalManageEmail.ui.window.modal('hide');

            let row = $('#dataFor-' + bodmin.person.id);
            row.empty().html('<td colspan="4">' + mgGetImgSpinner() + '</td>');

            let formData = new FormData();
            formData.append('id', bodmin.person.id);

            $('.form-group.row').each(function(/*i*/) {

                let rowIndex = $(this).attr('id').substr(6);
                let emailValue = $('#input-email-' + rowIndex).val();
                let cbStatus = $('#cb-email-' + rowIndex).is(":checked");

                if (!cbStatus){
                    formData.append('email-' + rowIndex, emailValue);
                }

            });

            $.ajax({
                url: "handleEmailData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function(/*data*/) {
                    refreshPersonDataSection();
                }
            });


        }
    });

    $('#action-info').fadeOut(6000);

    function setEditButtonsOff(){

        bodmin.controlPanel.ui.btnEdit.prop('disabled', true);
        bodmin.controlPanel.ui.btnEmail.prop('disabled', true);
        bodmin.controlPanel.ui.btnDelete.prop('disabled', true);

        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type:"get",
            async: false,
            url: "../users/getUserModulePermission.php?userId=" + $('#loggedInUserId').text() + "&moduleId=9",
            success: function(data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {

                    bodmin.controlPanel.ui.btnEdit.hide();
                    bodmin.controlPanel.ui.btnEmail.hide();
                    bodmin.controlPanel.ui.btnDelete.hide();
                    bodmin.controlPanel.ui.btnNew.hide();
                    $('#editButtons').html('<br/><small>' + bodmin.lang.intebehorig + '<small>');
                    $('#info').text('');

                }

            }
        });

    }

    function addEmailSection(emailAddress){

        let newEmailSection = $("#email-1").clone();
        let boxar = $('#email-list div.row').length;
        boxar ++;
        newEmailSection.attr('id', 'email-' + boxar);

        let theInputBox = newEmailSection.find('#input-email-1');
        theInputBox.attr('id', 'input-email-' + boxar);
        theInputBox.attr('name', 'name-ebox-' + boxar);
        theInputBox.attr('value', '');
        theInputBox.prop("disabled", false);
        theInputBox.val(emailAddress);

        let theCheckBox = newEmailSection.find('#cb-email-1');
        theCheckBox.attr('id', 'cb-email-' + boxar);
        theCheckBox.prop("checked", false);

        let theWarningTextSection = newEmailSection.find('#enamnWarningText-1');
        theWarningTextSection.attr('id', 'enamnWarningText-' + boxar);

        let firstCheckBoxDiv = newEmailSection.find('#cb-section-1');
        firstCheckBoxDiv.toggleClass('mg-hide-element', false);


        newEmailSection.appendTo("#email-list");


    }

    function validateEmail(emailToTest) {

        let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(emailToTest);

    }

    function hasDuplicates(array) {
        var valuesSoFar = [];
        for (var i = 0; i < array.length; ++i) {
            var value = array[i];
            if (valuesSoFar.indexOf(value) !== -1) {
                return true;
            }
            valuesSoFar.push(value);
        }
        return false;
    }

    function setLangTexts() {

        // E N G E L S K A
        if (bodmin.lang.current === '1') {

            bodmin.lang.langAsString = 'en';
            bodmin.lang.loggedinText = 'Logged in as ';
            bodmin.lang.logOutHere = "Log out here";
            bodmin.lang.intebehorig = 'You do not posses permission to change data here.';

            bodmin.table.lang = {

                tblInTblHeaderNoContent : 'No email addresses',
                tblInTblHeader : 'Email addresses',

                tblFilterBox : 'Filter persons here',
                tblHdrForNamn : 'First name',
                tblHdrEfterNamn : 'Last name',
                tblHdrRefNamn : 'Reference name',
                tblHdrSkapadNar : 'Record created'
            }

            bodmin.controlPanel.lang = {
                hdrMain : 'Persons',
                infoLabel : 'Chose a person to activate the buttons',
                infoLabelVald : 'Chosen: ',
                noPermission : "Du have insufficient user priviligiees to change data here.",
                btnNew : "New person",
                btnEdit : "Edit",
                btnDelete : "Delete",
                btnEmail : "Manage email addresses"

            };

            bodmin.modalEditPerson.lang = {
                headerEdit : 'Change data concerning ',
                headerNew : 'New person',
                headerDelete : 'Remove person',

                // field labels
                lblForNamn : 'First name',
                lblLastName : 'Last name',
                lblPassedAway : 'No longer with us',
                lblRefNamn : 'Name as reference',
                lblWebSajt : 'Web site',
                lblWebText : 'Web text',
                lblSignatureText : 'Signature',

                warningForName : 'First name must be filled out',
                warningLastName : 'Last name must be filled out',

                warningSignatureTextNotUnique : 'This signature is already in use',

                modalEditPersonExtraInfo : 'E-mail addresses, save the person and the click the button manage email addresses',

                // button texts
                btnSave : 'Save',
                btnCancel : 'Cancel',

                ja : "Yes",
                nej : "No"


            }

            bodmin.modalManageEmail.lang = {

                header : 'Manage email addresses for ',
                allEmailLabels : 'E-mail',
                formCheckBoxLabel : 'Remove this row (when saving)',
                btnAddEmail : 'Add e-mail',
                btnSave : "Save",
                btnCancel : "Cancel",
                uniqueText : 'The email addresses given are not unique. Remove the duplicate and try again.',
                invalidEmail : 'Ooops - invalid email address',
                alreadyUsed : 'This email address is already registered for someone else.'

            }

        }

        // S V E N S K A
        if (bodmin.lang.current === '2') {

            bodmin.lang.langAsString = 'se';
            bodmin.lang.loggedinText = 'Inloggad som ';
            bodmin.lang.logOutHere = "Logga ut här";

            bodmin.table.lang = {

                tblFilterBox : 'Filter persons here',
                tblHdrForNamn : 'Förnamn',
                tblHdrEfterNamn : 'Efternamn',
                tblHdrRefNamn : 'Referensnamn',
                tblHdrSkapadNar : 'Post skapad',

                tblInTblHeaderNoContent : 'No email addresses',
                tblInTblHeader : 'Email addresses'

            }

            bodmin.controlPanel.lang = {

                hdrMain : 'Personer',
                infoLabel : 'Välj en person för att aktivera knapparna',
                infoLabelVald : 'Vald: ',
                noPermission : "Du har inte behörighet att ändra data här",
                btnNew : "Ny person",
                btnEdit : "Ändra",
                btnDelete : "Tag bort",
                btnEmail : "Hantera e-post adresser"

            };

            bodmin.modalEditPerson.lang = {

                headerEdit : 'Ändra data för ',
                headerNew : 'Ny person',
                headerDelete : 'Tag bort person',

                // field labels
                lblForNamn : 'Förnamn',
                lblLastName : 'Efernamn',
                lblPassedAway : 'Avliden',
                lblRefNamn : 'Namn som referens',
                lblWebSajt : 'Websajt',
                lblWebText : 'Web text',
                lblSignatureText : 'Signatur',

                warningForName : 'Förnamn får ej vara tomt',
                warningLastName : 'Efternamn får ej vara tomt',
                warningSignatureTextNotUnique : 'Denna signatur används redan',

                modalEditPersonExtraInfo : 'E-post adreser hanteras via knappen till vänster, efter att du sparat personen.',

                // button texts
                btnSave : 'Spara',
                btnCancel : 'Avbryt',

                ja : "Ja",
                nej : "Nej"


            }

            // Error messages
            bodmin.lang.namnWarningText =  'Förnamn och efternamn måste fyllas i!';
            bodmin.lang.uniqueText = 'De listade epost adresserna är inte olika. Tag bort dubletten och försök igen.';
            bodmin.lang.invalidemail = 'Ooops - ogiltig e-post adress';
            bodmin.lang.alreadyused = 'Denna epost adress är redan registrerad för någon annan.';
            bodmin.lang.intebehorig = 'Du har inte behörighet att ändra data här.';

            bodmin.lang.emailheader = 'Epost adress(er)';

            bodmin.modalManageEmail.lang = {

                header : 'Hantera epost adresser för ',
                formCheckBoxLabel : 'Tag bort denna rad (när du sparar)',
                allEmailLabels : 'Epost',
                btnAddEmail : 'Lägg till epost adress',
                btnSave : "Spara",
                btnCancel : "Avbryt"

            }

        }

        // S E T all texts
        // control panel
        bodmin.controlPanel.ui.btnNew.text(bodmin.controlPanel.lang.btnNew);
        bodmin.controlPanel.ui.btnEdit.text(bodmin.controlPanel.lang.btnEdit);
        bodmin.controlPanel.ui.btnDelete.text(bodmin.controlPanel.lang.btnDelete);
        bodmin.controlPanel.ui.btnEmail.text(bodmin.controlPanel.lang.btnEmail);
        bodmin.controlPanel.ui.hdrMain.text(bodmin.controlPanel.lang.hdrMain);
        bodmin.controlPanel.ui.selectInfo.text(bodmin.controlPanel.lang.selectInfo);
        bodmin.controlPanel.ui.infoLabel.text(bodmin.controlPanel.lang.infoLabel);

        // modal Edit Person
        bodmin.modalEditPerson.ui.header.text(bodmin.modalEditPerson.lang.header);
        bodmin.modalEditPerson.ui.lblForNamn.text(bodmin.modalEditPerson.lang.lblForNamn);
        bodmin.modalEditPerson.ui.lblLastName.text(bodmin.modalEditPerson.lang.lblLastName);
        bodmin.modalEditPerson.ui.lblPassedAway.text(bodmin.modalEditPerson.lang.lblPassedAway);
        bodmin.modalEditPerson.ui.lblSignatureText.text(bodmin.modalEditPerson.lang.lblSignatureText);
        bodmin.modalEditPerson.ui.lblRefNamn.text(bodmin.modalEditPerson.lang.lblRefNamn);
        bodmin.modalEditPerson.ui.lblWebSajt.text(bodmin.modalEditPerson.lang.lblWebSajt);
        bodmin.modalEditPerson.ui.lblWebText.text(bodmin.modalEditPerson.lang.lblWebText);
        bodmin.modalEditPerson.ui.modalEditPersonExtraInfo.text(bodmin.modalEditPerson.lang.modalEditPersonExtraInfo);
        bodmin.modalEditPerson.ui.btnCancel.text(bodmin.modalEditPerson.lang.btnCancel);
        bodmin.modalEditPerson.ui.btnSave.text(bodmin.modalEditPerson.lang.btnSave);

        // edit email
        bodmin.modalManageEmail.ui.header.text(bodmin.modalManageEmail.lang.header);
        bodmin.modalManageEmail.ui.allCheckBoxLabels.text('xx');
        bodmin.modalManageEmail.ui.btnSave.text(bodmin.modalManageEmail.lang.btnSave);
        bodmin.modalManageEmail.ui.btnCancel.text(bodmin.modalManageEmail.lang.btnCancel);
        bodmin.modalManageEmail.ui.btnAddEmail.text(bodmin.modalManageEmail.lang.btnAddEmail);

        // table
        bodmin.table.ui.tblFilterBox.attr('placeholder', bodmin.table.lang.tblFilterBox);
        bodmin.table.ui.tblHdrForNamn.text(bodmin.table.lang.tblHdrForNamn);
        bodmin.table.ui.tblHdrEfterNamn.text(bodmin.table.lang.tblHdrEfterNamn);
        bodmin.table.ui.tblHdrRefNamn.text(bodmin.table.lang.tblHdrRefNamn);
        bodmin.table.ui.tblHdrSkapadNar.text(bodmin.table.lang.tblHdrSkapadNar);

        // modal edit emails
        bodmin.modalManageEmail.ui.header.text(bodmin.modalManageEmail.lang.header);
        bodmin.modalManageEmail.ui.allEmailLabels.text(bodmin.modalManageEmail.lang.allEmailLabels);
        bodmin.modalManageEmail.ui.allCheckBoxLabels.text(bodmin.modalManageEmail.lang.formCheckBoxLabel);
        bodmin.modalManageEmail.ui.allEmailLabels.attr('placeholder', bodmin.modalManageEmail.lang.allEmailLabels);
        bodmin.modalManageEmail.ui.btnAddEmail.text(bodmin.modalManageEmail.lang.btnAddEmail);
        bodmin.modalManageEmail.ui.btnSave.text(bodmin.modalManageEmail.lang.btnSave);
        bodmin.modalManageEmail.ui.btnCancel.text(bodmin.modalManageEmail.lang.btnCancel);

        $(document).attr('title', bodmin.controlPanel.lang.hdrMain);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.loggedinText);

        let loggedInInfo = '';
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

    }

    function loadTable() {

        let tmpHTML = '<tr><td colspan="4">' + mgGetDivWithSpinnerImg() + '</td></tr>';
        bodmin.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"get",
            url: "getPersons.php",
            success: function(data) {

                let infoHTML = "";
                let persons = JSON.parse(data);

                //create and populate the table rows
                for (let i = 0; i < persons.length; i++) {
                    infoHTML = infoHTML + '<tr id="' + persons[i]["ID"] + '">';
                    infoHTML = infoHTML + '<td>' + persons[i]["FNAMN"] + '</td>';
                    infoHTML = infoHTML + '<td>' + persons[i]["ENAMN"] + '</td>';
                    infoHTML = infoHTML + '<td>' + persons[i]["AUTH_NAME"] + '</td>';
                    infoHTML = infoHTML + '<td>' + persons[i]["created_at"] + '</td>';

                    infoHTML = infoHTML + '</tr>';
                    infoHTML = infoHTML + mgGetDataRow(persons[i]["ID"], 4);

                }
                bodmin.table.ui.bodySection.empty().append(infoHTML);
                bodmin.persons = persons;

            }
        });

    }

    function refreshPersonDataSection(){

        let row = $('#dataFor-' + bodmin.person.id);
        row.empty().html('<td colspan="4">' + mgGetImgSpinner() + '</td>');

        $.get("getPersonEMails.php?id=" + bodmin.person.id,
            function(data) {

                let emails = JSON.parse(data);

                let header = '<h6>' + bodmin.table.lang.tblInTblHeader + '</h6>';
                if (emails.length === 0){
                    header = '<h6>' + bodmin.table.lang.tblInTblHeaderNoContent +'</h6>';
                }
                let dataHTML = '<td colspan="4">' + header;

                // Populate the detail section with all translations
                let dataSectionText = "";
                const l = emails.length;
                for (let i = 0; i < l; i++) {
                    dataSectionText = dataSectionText + '<span class="mg-80-span">' + emails[i].address + '</span><br/>';
                }

                dataHTML = dataHTML + dataSectionText + '</td>';
                row.empty().append(dataHTML);

            }
        );

    }

    loadTable();

});
