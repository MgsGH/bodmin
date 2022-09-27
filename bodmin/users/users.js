$(document).ready(function(){

    let v = {

        cntrlPanel : {
            ui : {
                hdrMain : $('#hdrMain'),
                infoLabel : $('#infoLabel'),
                selectInfo : $('#selectInfo'),
                btnNew : $('#btnNew'),
                btnEdit : $('#btnEdit'),
                btnDelete : $('#btnDelete'),
                btnPasswordReset : $('#btnPasswordReset'),
                btnPermissions : $('#btnPermissions')
            },
        },

        table : {
            ui : {
                tblFilterBox : $('#tblFilterBox'),
                bodySection : $('#data tbody'),
                thName : $('#thName'),
                thSeasonStartDate : $('#thSeasonStartDate'),
                thSeasonEndDate : $('#thSeasonEndDate')
            },
            dataRows : $('#dataRows')
        },

        modalEditUser : {
            ui : {
                window : $('#editUser'),
                header : $('#modalHeaderEdit'),
                sectionDelete : $('#modalMainDeleteSection'),
                sectionEdit : $('#modalMainEditSection'),

                pwd : $('#pwdone'),
                pwdCopy : $('#pwdtwo'),

                lblInpUserName : $('#lblInpUserName'),
                inpUserName : $('#editUserName'),
                warningInpUserName : $('#warningInpUserName'),

                lblSignature : $('#lblSignature'),
                inputSignature : $('#inputSignature'),
                signatureWarning : $('#signatureWarning'),

                personSelect : $('#personSelect'),
                languageSelect : $('#languageSelect'),
                userActivated : $('#activated'),

                btnSave : $('#btnModalMainSave'),
                btnCancel : $('#btnModalMainCancel'),

            },
            modalMode : '',
        },

        modalEditPermissions : {
            ui : {
                window : $('#editPermissions'),
                btnPermCancel : $('#btnPermCancel'),
                btnPermSave : $('#btnPermSave'),
            },
        },

        lang : {

        },

        loggedInUser : $('#coolLevel').text(),

    };


    $(document).on("click", "#data tbody tr", function(){
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
        v.name = $(v.selectedRow).find("td").eq(0).text();


        v.cntrlPanel.ui.infoLabel.html(v.cntrlPanel.lang.infoLabelVald + ' ' + '<strong>' + v.name + '</strong>') ;

        populateUsersPermissionInfo();

    }

    v.cntrlPanel.ui.btnEdit.on('click', function(){
        // Edit user

        v.modalEditUser.modalMode = 'edit';

        $.ajax({
            type:"GET",
            url: "getUserViaId.php?id=" +  v.mainTableId,
            success: function(data) {

                v.modalEditUser.ui.header.text(v.lang.editUser);

                $('#modal-mode').text("edit");
                $('#action').attr('value', "edit");

                v.modalEditUser.ui.btnCancel.text(v.lang.cancel);
                v.modalEditUser.ui.btnSave.text(v.lang.save);

                // clear error messages
                $('#userNameWarning').text('');

                // hide password and delete sections
                $('#pwd-section').addClass('mg-hide-element');
                $('#delete-section').addClass('mg-hide-element');
                // show other data
                $('#user-section').removeClass('mg-hide-element');
                $('#activated-section').removeClass('mg-hide-element');


                let obj = JSON.parse(data);
                let userFromDb = obj[0];

                //populate edit form with gotten data
                // user-name
                v.modalEditUser.ui.inpUserName.val(userFromDb.username);

                // Person drop-down - setting value, if any, here
                let selectedPersonInDropDown = 0;
                if (userFromDb.person_id !== null) {
                    selectedPersonInDropDown = userFromDb.person_id;
                }
                $('#personSelect').val( selectedPersonInDropDown );

                $('#languageSelect').val( userFromDb.LANGUAGE_ID );

                // Enabled
                let status = (userFromDb.enabled === '1');
                $("#activated").attr("checked", status);

                v.modalEditUser.ui.window.modal('show');

            }
        });

    });

    v.cntrlPanel.ui.btnNew.on('click', function(){
        // New user

        v.modalEditUser.modalMode = 'add';

        v.modalEditUser.ui.header.text(v.lang.newUser);

        v.modalEditUser.ui.btnCancel.text(v.lang.cancel);
        v.modalEditUser.ui.btnSave.text(v.lang.spara);

        // un-hide all sections, except delete info section
        $('#pwd-section').removeClass('mg-hide-element');
        $('#user-section').removeClass('mg-hide-element');
        $('#activated-section').removeClass('mg-hide-element');
        $('#delete-section').addClass('mg-hide-element');

        // clear possible error messages
        $('#userNameWarning').text('');

        // empty and default fields
        v.modalEditUser.ui.inpUserName.val('');

        v.modalEditUser.ui.personSelect.val('0');
        v.modalEditUser.ui.languageSelect.val('2');
        // password boxes not needed

        // default enabled
        $("#activated").attr("checked", true);

        v.modalEditUser.ui.window.modal('show');

    });


    function populateUsersPermissionInfo(){

        $.ajax({
            type:"GET",
            url: "getUsersPermissionsAsTexts.php?id=" +  v.mainTableId + '&lang=' + v.lang.current,
            success: function(data) {

                let infoHTML = "<div class='pb-3'>";
                infoHTML += "<h6>" + v.lang.permissions +"</h6>";

                let permissions = JSON.parse(data);
                // Populate the info section with permission info
                const l = permissions.length;
                for (let i = 0; i < l; i++) {
                    infoHTML +=  '<span class="mg-140-span"> ' + permissions[i].MODULE + '</span>' + permissions[i].PERMISSION_LEVEL + '<br/>';
                }
                infoHTML += '</div>';

                const dataCell = v.selectedRowsDataRow.find("td").eq(0);
                dataCell.html(infoHTML);
            }
        });
    }

    v.cntrlPanel.ui.btnDelete.on('click', function(){
        // Delete user

        v.modalEditUser.modalMode = 'delete';
        v.modalEditUser.ui.header.text(v.lang.deleteuser);

        v.modalEditUser.ui.btnCancel.text(v.lang.cancel);
        v.modalEditUser.ui.btnSave.text(v.lang.ja);

        // hide most sections
        $('#pwd-section').addClass('mg-hide-element');
        $('#user-section').addClass('mg-hide-element');
        $('#activated-section').addClass('mg-hide-element');

        // except delete section
        let deleteSection = $('#delete-section');

        // find additional info
        let username = v.name;
        let userPerson = $('.table-active').find("td").eq(1).text();

        // populate and show delete info section
        deleteSection.html('<h6>' + username + ' / ' + userPerson + '</h6>');
        deleteSection.removeClass('mg-hide-element');

        $('#btnSaveMainModal').text(v.lang.ja);
        $('#btnCancelMainModal').text(v.lang.nej);

        v.modalEditUser.ui.window.modal('show');

    });

    v.cntrlPanel.ui.btnPasswordReset.on('click', function(){

        v.modalEditUser.modalMode = 'pwd-reset';
        v.modalEditUser.ui.header.text(v.lang.resetpwd);

        v.modalEditUser.ui.btnCancel.text(v.lang.cancel);
        v.modalEditUser.ui.btnSave.text(v.lang.save);

        // hide most of them
        $('#user-section').addClass('mg-hide-element');
        $('#activated-section').addClass('mg-hide-element');
        $('#delete-section').addClass('mg-hide-element');
        // unhide password section
        $('#pwd-section').removeClass('mg-hide-element');

        v.modalEditUser.ui.window.modal('show');

    });


    $('.closeModal').on('click', function(){
        v.modalEditUser.ui.window.modal('hide');
    });


    $('.closeModalPermissions').on('click', function(){
        v.modalEditPermissions.ui.window.modal('hide');
    });


    v.cntrlPanel.ui.btnPermissions.on('click',function(){
        // Edit permissions

        $('#editPermissionsFor').text(v.name);

        $.ajax({
            type:"get",
            async: false,
            url: "getUserModulesPermissions.php?userId=" +  v.mainTableId,
            success: function(data) {

                let obj = JSON.parse(data);

                // Set all drop-down box values to "no permission" as default
                $('.permissionSelect').val('1');

                // Populate edit form with (eventual) values
                const l = obj.length;
                for (let i = 1; i < l; i++) {

                    let module = obj[i].MODULE_ID;
                    let setting = obj[i].PERMISSION_ID;
                    $('#mod-' + module).val(setting);

                }

                v.modalEditPermissions.ui.window.modal('show');

            }
        });
    });


    v.modalEditPermissions.ui.btnPermSave.on('click', function(){
        // Save permissions
        // Rewrite all permission

        let permissionsToSend = {
            userId : v.mainTableId,
        };

        // We have a list of select boxes.
        let allPermissions = [];
        let allSelectionBoxes = $('.permissionSelect');
        allSelectionBoxes.each(function(){
            let data = [];
            data.push($( this ).attr('id').substring(4, 6));
            data.push($( this ).val());
            allPermissions.push(data);
        })

        permissionsToSend.permissions = allPermissions;

        v.modalEditPermissions.ui.window.modal('hide');

        // spin while we wait for permissions to be updated
        const dataCell = v.selectedRowsDataRow.find("td").eq(0);
        dataCell.html(mgGetDivWithSpinnerImg())

        $.ajax({
            type: "POST",
            url: window.location.origin + "/bodmin/users/handlePermissionData.php",
            data: permissionsToSend,
            success: function(/*data*/){
                populateUsersPermissionInfo();
            },

        });

    });


    function setEditButtonsOff(){

        v.cntrlPanel.ui.btnEdit.prop('disabled', true);
        v.cntrlPanel.ui.btnPermissions.prop('disabled', true);
        v.cntrlPanel.ui.btnDelete.prop('disabled', true);
        v.cntrlPanel.ui.btnPasswordReset.prop('disabled', true);

        // if not sufficient permissions let the buttons be hidden altogether - at least for now!
        $.ajax({
            type:"GET",
            async: false,
            url: "getUserModulePermission.php?userId=" + v.loggedInUser + "&moduleId=10",
            success: function(data) {

                let obj = JSON.parse(data);

                console.log(v.loggedInUser);
                console.log(obj);

                // default no permissions
                let permission = 1;
                if (obj.length > 0){

                    permission = obj[0].PERMISSION_ID;

                    if (permission < 5) {
                        v.cntrlPanel.ui.btnEdit.hide();
                        v.cntrlPanel.ui.btnPermissions.hide();
                        v.cntrlPanel.ui.btnDelete.hide();
                        v.cntrlPanel.ui.btnPasswordReset.hide();
                        v.cntrlPanel.ui.btnNew.hide();

                        $('#editButtons').html('<br/><small>Du har inte behörighet att ändra data här.<small>');
                        $('#info').text('');

                    }

                }


            }
        });

    }


    function loadTable(v) {

        let tmpHTML = '<tr><td colspan="6">' + mgGetDivWithSpinnerImg() + '</td></tr>';
        v.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"GET",
            url: "getAllUsers.php",
            success: function(data) {

                let rows = "";
                let users = JSON.parse(data);

                //create and populate the table rows
                const l = users.length;
                for (let i = 0; i < l; i++) {
                    rows += '<tr id="' + users[i]["USER_ID"] + '">';

                    rows += '<td>' + users[i]["USERNAME"] + '</td>';

                    let fname = users[i]["FNAMN"];
                    if (fname === null){
                        fname = '';
                    }
                    let ename = users[i]["ENAMN"];
                    if (ename === null){
                        ename = '';
                    }
                    rows += '<td>' + fname + ' ' + ename + '</td>';

                    let signature = users[i]["SIGNATURE"];
                    if (signature === null){
                        signature = '';
                    }
                    rows += '<td>' + signature + '</td>';


                    let enabled = users[i]["ENABLED"];
                    if (enabled === '1'){
                        enabled = v.lang.tblActivatedYes;
                    } else {
                        enabled = "";
                    }
                    rows += '<td class="text-center">' + enabled + '</td>';

                    rows += '<td>' + users[i]["LANGUAGE"] + '</td>';

                    let created = users[i]["CREATED_AT"];
                    if (created === null){
                        created = '';
                    } else {
                        created = created.substring(0,10);
                    }
                    rows += '<td>' + created + '</td>';

                    rows += '</tr>';
                    rows += mgGetDataRow(users[i]["USER_ID"], 6);

                }


                v.table.ui.bodySection.empty().append(rows);
                v.users = users;

            }
        });

    }

    // search/filter - multi-word input OK
    v.table.ui.tblFilterBox.on('input', function() {

        let value = $(this).val().toLowerCase();

        $("#data tbody tr").filter(function() {
            let hay = $(this).text();
            let currentRow = $(this);

            if (currentRow.hasClass('mg-table-row-data')){
                // The parent row this data belongs to might be filtered out. Hide it.
                currentRow.toggleClass('mg-hide-element', true);
            } else {
                currentRow.toggle(mgCheckFilterString(hay, value));
            }

        });

    });


    function PopulateDropDowns(){
        // get data for drop-downs and some additional data we need

        // Get users - not in a drop-down, but we need the data for client side username checking
        $.ajax({
            type: "GET",
            url: "getAllUserNames.php",
            success: function (data) {
                v.userNames = JSON.parse(data);
            }

        });

        // get persons
        $.ajax({
            type: "GET",
            url: "getAlivePersons.php",
            success: function (data) {

                v.persons = JSON.parse(data);

                const l = v.persons.length;
                for (let i = 0; i < l; i++) {
                    v.modalEditUser.ui.personSelect.append($("<option></option>").attr("value", v.persons[i].ID).text(v.persons[i].FULLNAME));
                }

                v.modalEditUser.ui.personSelect.val('99');

            }

        });

        // get languages
        $.ajax({
            type: "GET",
            url: "getLanguages.php",
            success: function (data) {

                let languages = JSON.parse(data);

                const l = languages.length;
                for (let i = 0; i < l; i++) {
                    v.modalEditUser.ui.languageSelect.append($("<option></option>").attr("value", languages[i].ID).text(languages[i].TEXT));
                }

                v.modalEditUser.ui.languageSelect.val('99');

            }

        });

        // get permissions

        // get modules

        /*

        $permissionOptions = getPermissionOptionsAsHTML($pdo,  $_SESSION["preferredLanguageId"]); // dropdowns for selecting permission level in perm-modal
        $modules = getModules($pdo, $_SESSION["preferredLanguageId"]); // create the module form dynamically - kind of - all boxes the same for all users.


         */

    }


    v.modalEditUser.ui.btnSave.on('click', function(){
        // Save user

        // Clear warning texts in modal
        $('.formWarning').text('');

        let ok = true;
        if (v.modalEditUser.modalMode === "delete"){
            // No tests what-so-ever - we delete whatever we have.
        }

        if ((v.modalEditUser.modalMode === "add") || (v.modalEditUser.modalMode === "edit")) {
            // Normal fields - person optional, language pre-set

            // Here only username (email address)
            // is formally OK?
            if (!checkEmailAddress(v.modalEditUser.ui.inpUserName.val())){
                ok = false;
                $('#userNameWarning').text(v.lang.invalidemail);
            }

        }

        if (v.modalEditUser.modalMode === "add") {

            // Is the proposed username (email) used by someone?
            if (ok) {

                let l = v.userNames.length;
                for (let i = 0; i < l; i++) {

                    // scrub test data
                    let toTest = v.modalEditUser.ui.inpUserName.val();
                    toTest = toTest.trim().toLowerCase();
                    let against = v.userNames[i].USERNAME;
                    against = against.trim().toLowerCase();

                    if (toTest === against) {
                        ok = false;
                        $('#userNameWarning').text(v.lang.emailAlreadyInUse);
                    }

                }

            }
        }

        if (v.modalEditUser.modalMode === "edit") {

            // Is the proposed username (email) used by someone *else*?
            if (ok) {

                let l = v.userNames.length;
                for (let i = 0; i < l; i++) {

                    // scrub test data
                    let toTest = v.modalEditUser.ui.inpUserName.val();
                    toTest = toTest.trim().toLowerCase();
                    let against = v.userNames[i].USERNAME;
                    against = against.trim().toLowerCase();

                    if ((toTest === against) && (v.userNames[i].ID !== v.mainTableId)) {
                        ok = false;
                        $('#userNameWarning').text(v.lang.emailAlreadyInUse);
                    }

                }

            }
        }

        if ((v.modalEditUser.modalMode === "add") || (v.modalEditUser.modalMode === "pwd-reset")) {
            // we check pwd consistency

            if (v.modalEditUser.ui.pwd.val() !== v.modalEditUser.ui.pwdCopy.val()){
                ok = false;
                $('.pwdWarning').text(v.lang.pwdproblem);
            }

        }


        if (ok) {
            // All validations (as applicable) are OK.
            // We save

            let formData = new FormData();

            formData.append('mode', v.modalEditUser.modalMode);
            formData.append('logged_in_user', v.loggedInUser);

            let pwd = ''
            if ((v.modalEditUser.modalMode === 'add') || (v.modalEditUser.modalMode === 'pwd-reset')) {
               pwd = v.modalEditUser.ui.pwd.val();
            }
            formData.append('pwd', pwd);

            let userid = v.mainTableId;
            if (v.modalEditUser.modalMode === 'add') {
                userid = '0'
            }
            formData.append('table_id', userid);

            let activated = '0';
            if (v.modalEditUser.ui.userActivated.prop("checked")) {
                activated = '1';
            }
            formData.append('activated', activated);

            formData.append('user_name', v.modalEditUser.ui.inpUserName.val());
            formData.append('person_id', v.modalEditUser.ui.personSelect.val());
            formData.append('language',  v.modalEditUser.ui.languageSelect.val());


            $.ajax({
                url: window.location.origin + "/bodmin/users/handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (data) {

                    if (v.modalEditUser.modalMode === 'edit'){
                        // Re-populate the row with updated data

                        $(v.selectedRow).find("td").eq(0).text(v.modalEditUser.ui.inpUserName.val());

                        let personText = '';
                        let signatureText = '';
                        if (v.modalEditUser.ui.personSelect.val() !== '0'){
                            personText = $( "#personSelect option:selected" ).text();
                            signatureText = getPersonsSignature(v.modalEditUser.ui.personSelect.val());
                        }
                        $(v.selectedRow).find("td").eq(1).text( personText );
                        $(v.selectedRow).find("td").eq(2).text( signatureText );

                        let activatedText = "";
                        if (v.modalEditUser.ui.userActivated.prop("checked")) {
                            activatedText = v.lang.ja;
                        }
                        $(v.selectedRow).find("td").eq(3).text(activatedText);
                        $(v.selectedRow).find("td").eq(4).text( $( "#languageSelect option:selected" ).text());
                    }

                    if (v.modalEditUser.modalMode === 'add'){
                        // Create the row in the table ...and
                        // populate a new row in the table on screen with updated data

                        let writtenData = JSON.parse(data);
                        let writtenId = (writtenData.ID);


                        let row = '<tr id="' + writtenId + '">';
                        row += '<td>' + v.modalEditUser.ui.inpUserName.val() + '</td>';

                        let personText = '';
                        let signatureText = '';
                        if (v.modalEditUser.ui.personSelect.val() !== '0'){
                            personText = $( "#personSelect option:selected" ).text();
                            signatureText = getPersonsSignature(v.modalEditUser.ui.personSelect.val());
                        }

                        row += '<td>' + personText + '</td>';
                        row += '<td>' + signatureText + '</td>';


                        let activatedText = "";
                        if (v.modalEditUser.ui.userActivated.prop("checked")) {
                            activatedText = v.lang.ja;
                        }
                        row += '<td>' + activatedText + '</td>';
                        row += '<td>' +  $( "#languageSelect option:selected" ).text() + '</td>';

                        let dateAsYmd = getDateAsYMDString(new Date())
                        row += '<td>' + dateAsYmd.substring(0, 3) + '</td>';
                        row += '</tr>';

                        row += '<tr id="dataFor-' + writtenId +'" class="mg-table-row-data mg-hide-element">';
                        row += '<td colspan="6">' + mgGetDivWithSpinnerImg() + '</td>';
                        row += '</tr>';
                        v.table.dataRows.append(row);

                        v.selectedRow = $( 'tr#' + writtenData.ID );
                        handleSelectedRow();

                    }

                    if (v.modalEditUser.modalMode === 'delete'){

                        // data row
                        let row = $( '#dataFor-' + v.mainTableId );
                        row.remove();

                        // main row
                        row = $( 'tr#' + v.mainTableId );
                        row.remove();

                        // reset ui - no record selected
                        v.mainTableId = '';
                        v.cntrlPanel.ui.infoLabel.html(v.cntrlPanel.lang.infoLabelDefault);
                        $('.editButton').prop('disabled', true);

                    }

                }

            });

            v.modalEditUser.ui.window.modal('hide');

        }

    });

    function getPersonsSignature(id){

        let result = ''
        const l = v.persons.length;
        for (let i = 0; i <l; i++) {

            if (v.persons[i].ID === id){
                result = v.persons[i].SIGNATURE;
                break;
            }

        }

        return result;

    }

    function setLangTexts(){

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';

            v.cntrlPanel.lang = {
                infoLabelVald : 'Selected',
                infoLabelDefault : 'Click a user to activate the buttons',
            }

            // modal header, depending on intent.
            v.lang.newUser = "New user";
            v.lang.editUser = "Edit user";
            v.lang.deleteUser = "Remove user?";

            v.lang.totalt = "Total";
            v.lang.nopermission = "You do not have sufficient permissions to edit data.";
            v.lang.permissions ='Permissions';

            v.lang.cancel = "Cancel";
            v.lang.save = "Save";
            v.lang.deletebutton = "Remove";

            v.lang.ja = "Yes";
            v.lang.nej = "No";
            v.lang.vald = "Selected: ";
            v.lang.ater = "Cancel";

            // warning messages
            v.lang.resetpwd = "Re-set password";
            v.lang.chguser = "Edit data for user";
            v.lang.invalidemail = "Invalid email address";
            v.lang.emailAlreadyInUse = "This email address is already used";
            v.lang.pwdproblem = "The passwords given are not the same the same";
            v.lang.deleteuser = "Remove user?";

            v.lang.title = 'Users';
            // header info
            v.lang.notLoggedinText = 'You are not logged in';
            v.lang.pageTitle = 'User';
            v.lang.loggedinText = 'Logged-in as ';
            v.lang.logOutHere = "Log out here";
            v.lang.hdrMain = 'Users';


            // Buttons
            // main screen
            v.lang.btnNew = "New user";
            v.lang.btnEdit = "Edit";
            v.lang.btnDelete = "Remove";
            v.lang.btnPasswordReset = "Reset password";
            v.lang.btnPermissions = 'User permissions';
            // edit user
            v.lang.btnCancel = 'Cancel';
            v.lang.btnSaveEditForm = 'Save changes';

            // edit permissions
            v.lang.btnPermSave = 'Save';
            v.lang.btnPermCancel = 'Cancel';

            // table
            v.lang.tblFilterBox = "Filter user here";
            v.lang.tblHdrUserNamn = "User name";
            v.lang.tblHdrPersonNamn = "Person";
            v.lang.tblHdrAktiverad = "Activated";
            v.lang.tblHdrSignature = "Signature";
            v.lang.tblHdrDefaultLanguage = "Language";
            v.lang.tblHdrSkapadNar = "Record created";
            v.lang.tblActivatedYes = 'Yes';
            // table in table
            v.lang.tblInTblHeader = "E-mail";

            // user communication
            v.lang.infPermIntro = 'Permissions for ';
            v.lang.infPermPrompt = 'Remember to update user permissions!';


            // modal edit table data
            v.lang.modalHeaderEdit = "New user";
            v.lang.lblUserName = "User name";
            v.lang.lblPersonName = 'Person (if possible)';
            v.lang.lblLanguage = "Language";
            v.lang.lblPwdOne = "Password";
            v.lang.lblPwdTwo = "Repeat password";
            v.lang.lblAktiverad = "Activated";
            v.lang.ddNoPersonSelected = '--No person selected--';

            // modal edit emails
            v.lang.modalPermissionsTitle = 'Manage permissions for '

        }

        // S V E N S K A
        if (v.lang.current === '2'){

            v.lang.langAsString = 'se';

            v.cntrlPanel.lang = {
                infoLabelVald : 'Vald användare',
                infoLabelDefault : 'Välj en användare för att aktivera knapparna',
            }


            // modal header, depending on intent.
            v.lang.newUser = "Ny användare";
            v.lang.editUser = "Ändra användare";
            v.lang.deleteUser = "Ta bort användare?";

            v.lang.totalt = "Totalt";
            v.lang.nopermission = "Du har inte behörighet att ändra data.";
            v.lang.permissions = 'Behörigheter';

            v.lang.cancel = "Avbryt";
            v.lang.save = "Spara";
            v.lang.deletebutton = "Tag bort";

            v.lang.ja = "Ja";
            v.lang.nej = "Nej";
            v.lang.vald = "Vald: ";
            v.lang.ater = "Avbryt";

            // warning messages
            v.lang.resetpwd = "Återställ passord";
            v.lang.chguser = "Ändra data om användare";
            v.lang.invalidemail = "Ogiltig e-post adress";
            v.lang.emailAlreadyInUse = "Denna epost-adress är redan registrerad";
            v.lang.pwdproblem = "Passorden är inte de samma";
            v.lang.deleteuser = "Ta bort användare?";


            v.lang.title= 'Användare';
        
            // header info
            v.lang.notLoggedinText = 'Du är ej inloggad';
            v.lang.pageTitle = 'Användare';
            v.lang.loggedinText = 'Inloggad som ';
            v.lang.logOutHere = "Logga ut här";
            v.lang.hdrMain = 'Användare';


            // Buttons
            // main screen
            v.lang.btnNew = "Ny användare";
            v.lang.btnEdit = "Ändra";
            v.lang.btnDelete = "Tag bort";
            v.lang.btnPasswordReset = "Återställ passord";
            v.lang.btnPermissions = 'Användarens behörigheter';
            // edit user
            v.lang.btnCancel = 'Avbryt';
            v.lang.btnSaveEditForm = 'Spara ändringar';

            // edit permissions
            v.lang.btnPermSave = 'Spara';
            v.lang.btnPermCancel = 'Avbryt';

            // table
            v.lang.tblFilterBox = "Sök användare här";
            v.lang.tblHdrUserNamn = "Användarnamn";
            v.lang.tblHdrPersonNamn = "Person";
            v.lang.tblHdrAktiverad = "Aktiverad";
            v.lang.tblHdrSignature = "Signatur";
            v.lang.tblHdrDefaultLanguage = "Språk";
            v.lang.tblHdrSkapadNar = "Post skapad";
            // table in table
            v.lang.tblActivatedYes = 'Ja';

            // user communication
            v.lang.infPermIntro = 'Behörigheter för ';
            v.lang.infPermPrompt = 'Kom ihåg att uppdatera behörigheterna';

            // modal edit table data
            v.lang.modalHeaderEdit = "Ny användare";
            v.lang.lblUserName = "Användarnamn";
            v.lang.lblPersonName = 'Person (om möjligt)';
            v.lang.lblLanguage = "Språk";
            v.lang.lblPwdOne = "Passord";
            v.lang.lblPwdTwo = "Passord igen";
            v.lang.lblAktiverad = "Aktiverad";
            v.lang.ddNoPersonSelected = '--Ingen person vald--';

            // modal edit emails
            v.lang.modalPermissionsTitle = 'Hantera behörigheter för '


        }


        $(document).attr('title', v.lang.pageTitle);
        $("html").attr("lang", v.lang.langAsString);
        v.cntrlPanel.ui.hdrMain.text(v.lang.hdrMain);
        $('#loggedinText').text(v.lang.loggedinText);


        let loggedInInfo = v.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/bodmin/loggedout/index.php" class="mg-hdrLink">' +  ' ' + v.lang.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);


        // cntrl panel
        // buttons
        v.cntrlPanel.ui.btnNew.text(v.lang.btnNew);
        v.cntrlPanel.ui.btnPasswordReset.text(v.lang.btnPasswordReset);
        v.cntrlPanel.ui.btnEdit.text(v.lang.btnEdit);
        v.cntrlPanel.ui.btnDelete.text(v.lang.btnDelete);
        v.cntrlPanel.ui.btnPermissions.text(v.lang.btnPermissions);
        v.cntrlPanel.ui.selectInfo.text(v.lang.selectInfo);
        v.cntrlPanel.ui.infoLabel.text(v.cntrlPanel.lang.infoLabelDefault);


        // edit user
        v.modalEditUser.ui.btnCancel.text(v.lang.btnCancel);
        v.modalEditUser.ui.btnSave.text(v.lang.btnSaveEditForm);


        // user communication
        $('#infPermIntro').text( v.lang.infPermIntro);
        $('#infPermPrompt').text( v.lang.infPermPrompt);
        $('#infPwd').text( 'v.lang.infPwd');
        $('#infPwdIntro').text( v.lang.infPwdIntro);


        // main table
        v.table.ui.tblFilterBox.attr('placeholder', v.lang.tblFilterBox);
        $('#tblHdrUserNamn').text( v.lang.tblHdrUserNamn);
        $('#tblHdrPersonNamn').text(v.lang.tblHdrPersonNamn);
        $('#tblHdrSignature').text(v.lang.tblHdrSignature);
        $('#tblHdrAktiverad').text(v.lang.tblHdrAktiverad);
        $('#tblHdrDefaultLanguage').text(v.lang.tblHdrDefaultLanguage);
        $('#tblHdrSkapadNar').text(v.lang.tblHdrSkapadNar);
        $('td.published').text(v.lang.ja);
        $('td.notPublished').text(v.lang.nej);

        // modal main
        v.modalEditUser.ui.header.text(v.lang.modalHeaderEdit);
        $('#lblUserName').text(v.lang.lblUserName);
        $('#lblPersonName').text(v.lang.lblPersonName);
        $('#lblLanguage').text(v.lang.lblLanguage);
        $('#lblPwdOne').text(v.lang.lblPwdOne);
        $('#lblPwdTwo').text(v.lang.lblPwdTwo);
        $('#lblAktiverad').text(v.lang.lblAktiverad);
        $("#personSelect option[value='0']").text(v.lang.ddNoPersonSelected);

        // modal edit permissions
        $('#modalPermissionsTitle').text(v.lang.modalPermissionsTitle);
        v.modalEditPermissions.ui.btnPermCancel.text(v.lang.btnPermCancel);
        v.modalEditPermissions.ui.btnPermSave.text(v.lang.btnPermSave);

    }

    v.lang.alpha = $('#metaLang').attr('content');
    v.lang.current = getLanguageAsNo();

    setLangTexts();
    setEditButtonsOff();
    loadTable(v);
    PopulateDropDowns();

});
