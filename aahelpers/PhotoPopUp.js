
    function PhotoPopUp()  {

        /*

        Php include, calling code and handling code example

        // in php file - brings in the HTML for the form
        <?php
            require $path . "/aahelpers/popUpImage.php";
        ?>

        ...

        // calling js file

        const photoEditModal = new PhotoPopUp();
        ...
        // edit button, on click
        const params = {
            mode : 'add',
            imageId : imgId,
            languageId : '2',
            loggedInUserId : 1
        }

        photoEditModal.openModal(params);

        -----

        // calling js-file managing post popUp actions
        const currentImageId = $('#currentImageId');
        const currentMode = $('#currentMode');

        currentImageId.change(function() {
            alert('Image written - ' + currentMode );
        });

        Main action here:

        */

        // https://stackoverflow.com/questions/5222209/getter-setter-in-constructor

        let languageId = '0'
        let loggedInUserId = '0';
        let imageId = '0';
        let modalMode = '-';
        let imageOK = true;
        let imageEdited = false; //

        let ui = {
            window : $('#editPhotoModal'),  // the modal box
            modalHeader : $('#photoModalModalHeader'),
            tabPhoto : $('#photoModalTabImage'),
            divPhotoModalReCrop : $('#divReCrop'),
            btnPhotoModalReCrop : $('#btnPhotoModalReCrop'),
            imagePreviewWrapper : $('#photoModalImgPreviewWrapper'),
            imagePreview : $('#photoModalImgPreviewUpload'),
            cropInfo : $('#photoModalCropInfo'),
            tabMetaData : $('#photoModalTabMetaData'),
            selectImage : $('#photoModalSelectImage'),
            modalTaxaDropDown : $('#slctPhotoModalTaxa'),
            modalPersonDropDown : $('#slctPhotoModalPerson'),
            modalKeywordsDropDown : $('#slctPhotoModalKeywords'),
            selectedTaxa : $('#selectedPhotoModalTaxa'),
            selectedKeywords : $('#selectedPhotoModalKeywords'),
            checkBoxPublished : $('#cbPhotoModalPublished'),
            inputBoxPlace : $('#inpPhotoModalPlats'),
            inputBoxDateTaken : $('#inpPhotoModalDateTaken'),

            currentImageId : $('#currentImageId'),
            currentMode : $('#currentMode'),
            inputFields : $('.form-field'),
            tabs : $("#tabs"),

            waitPanel  : $('#wait'),
            editPanel  : $('#editForm'),

            dateWarningText : $('#datePhotoModalWarningText'),
            selectedTaxaWarningText : $('#selectedTaxaPhotoModalWarningText'),
            selectedKeywordsWarningText : $('#selectedKeywordsPhotoModalWarningText'),
            selectedPlaceWarningText : $('#selectedPlacePhotoModalWarningText'),

            // buttons in modal
            btnEditPhotoX : $('#btnEditPhotoX'),
            grpEditButtons : $('#buttonsWrapper'),
            btnStartCrop : $('#btnPhotoModalStartCropper'),
            btnFlip : $('#btnPhotoModalFlip'),
            btnReset : $('#btnPhotoModalReset'),
            btnRotate : $('#btnPhotoModalRotate'),
            btn32 : $('#btnPhotoModal32'),
            btn11 : $('#btnPhotoModal11'),
            btnTest : $('#btnTest'),
            cropWarning : $('#photoModalCropWarning'),
            aspectRatio : '32',
            btnPhotoModalCancel : $('#btnPhotoModalCancel'),
            btnPhotoModalSave : $('#btnPhotoModalSave'),
        }

        let lang = {

            mainHeaderAdd : "Add image to the system",
            mainHeaderEdit : "Edit image and its data",
            mainHeaderDelete : "Remove image from the system?",

            tabPhoto : 'Image',
            tabMetaData : 'Image data',

            reCrop : 'Re-crop image',

            cropWarning : 'Alert - cropped images with less than 553/553 or 553/800 pixels may look grainy when shown.',
            cropWarningNotAnImage : 'Please select a proper (jpg) image.',

            // Buttons
            btnPhotoModalCancel : 'Cancel',
            btnPhotoModalSave : 'Save changes',

            // modal edit table data
            lblPerson : "Photographer",
            lblDateTaken : "Date taken",
            lblTaxa : 'Species',
            lblPlats : "Location (free text)",
            lblKeywords : "Keywords",
            lblPublished : "Published",
            ddTaxaNoValue : "--select a species--",
            ddPersonNoValue : "--select a person--",
            ddKeywordsNoValue : "--select a keyword--",
            deleteImage : 'Delete the image and its image data?',
            yes : "Yes",
            no : "No",

            // image manipulation buttons
            btnStartCropper : "Re-crop the image",
            btnFlip : "Flip the image horizontally",
            btnRotate : "Rotate the image 90 degrees",
            btn32 : "Set image size 3/2",
            btn11 : "Set image size 1/1",
            btnReset : "re-set cropping area",
            // Crop info
            height : "Height",
            width : "width",
            ratio : "ratio",

            // warning messages
            dateWarningText : 'Invalid date entered.',
            tooOldDate : 'Dates older than 1950 not allowed',
            selectedTaxaWarningText : 'You have to add either one species or one keyword, as a minimum.',
            selectedPlaceWarningText : 'Place field cannot be blank'

        }

        this.openModal = open;

        this.imgId = getImgId;

        function getImgId(){
            return imageId;
        }

        function open(params){

            imageOK = true;
            languageId = params.languageId;
            loggedInUserId = params.loggedInUserId;
            imageId = params.imageId;
            modalMode = params.mode;
            imageEdited = false; // always default to false

            setLangTexts(languageId)
            populateModalDropDowns(languageId, loggedInUserId);


            ui.waitPanel.toggleClass('mg-hide-element', false);
            ui.waitPanel.append('<div><br/><br/><img src="' + window.location.origin + '/aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"><br/><br/></div>');
            ui.editPanel.toggleClass('mg-hide-element', true);

            ui.selectImage.toggleClass('mg-hide-element', false);
            ui.divPhotoModalReCrop.toggleClass('mg-hide-element', true);

            ui.inputFields.prop( "disabled", false ); // fields disable if needed below

            clearWarningTextsInModal();
            ui.selectedKeywords.empty();
            ui.selectedTaxa.empty();

            ui.btnPhotoModalCancel.text( lang.btnPhotoModalCancel );
            ui.btnPhotoModalSave.text( lang.btnPhotoModalSave );

            if (modalMode === 'add'){

                ui.modalHeader.text(lang.mainHeaderAdd);
                imageEdited = true; // always edit an image when uploading

                // empty and default field(s), date to today
                ui.inputBoxDateTaken.val((new Date()).toISOString().split('T')[0]);

                ui.cropInfo.toggleClass('mg-hide-element', true)
                ui.cropWarning.toggleClass('mg-hide-element', true);
                ui.grpEditButtons.toggleClass('mg-hide-element', true);
                ui.imagePreviewWrapper.toggleClass('mg-hide-element', true);

                ui.selectImage.val(null);
                ui.inputBoxPlace.val('');
                ui.checkBoxPublished.prop( "checked", false);

                ui.window.modal('show');

            }

            if (modalMode === 'edit'){

                ui.modalHeader.text(lang.mainHeaderEdit);

                // hide file selector, images can only be re-cropped
                ui.selectImage.toggleClass('mg-hide-element', true);

                // Show re-crop button
                ui.divPhotoModalReCrop.toggleClass('mg-hide-element', false);

                ui.cropInfo.toggleClass('mg-hide-element', true)
                ui.cropWarning.toggleClass('mg-hide-element', true);
                ui.grpEditButtons.toggleClass('mg-hide-element', true);

                ui.selectImage.val(null);
                ui.inputBoxPlace.val('');
                ui.checkBoxPublished.prop("checked", false);

                ui.imagePreview.attr('src', '/aahelpers/img/loading/ajax-loader.gif');
                ui.imagePreviewWrapper.toggleClass('mg-hide-element', false);

                // populate with existing data
                loadImage().then(ui.window.modal('show'));


            }

            if (modalMode === 'delete'){

                ui.btnPhotoModalCancel.text( lang.no );
                ui.btnPhotoModalSave.text( lang.yes );
                ui.modalHeader.text(lang.mainHeaderDelete);
                ui.inputFields.prop( "disabled", true );
                ui.selectImage.toggleClass('mg-hide-element', true);

                // populate with existing data
                ui.imagePreviewWrapper.toggleClass('mg-hide-element', false);
                let url = '/v2images/maxipics/maxipic-' + imageId + '.jpg';
                ui.imagePreview.attr('src', url);

                ui.window.modal('show');
            }

        }


        async function loadImage(){

            const url = '/v2images/maxipics/maxipic-' + imageId + '.jpg?nocache=' + Date.now();

            let response = await fetch(url);
            let data = await response.blob();
            let metadata = {
                type: 'image/jpeg'
            };
            let file = new File([data], "edit.jpg", metadata);

            // ... do something with the file or return it
            const imgURL = URL.createObjectURL(file);
            ui.imagePreview.attr('src', imgURL);


        }


        ui.btnPhotoModalReCrop.click(function(){
            setupCropper();
            imageEdited = true; //
            ui.grpEditButtons.toggleClass('mg-hide-element', false);
            ui.divPhotoModalReCrop.toggleClass('mg-hide-element', true);
        });


        function populatePersonDropDown(){
            // populate photographer drop-down. Logged in user if "add" otherwise already entered person ID
            const l = ui.persons.length;
            for (let i = 0; i < l; i++) {

                if (ui.persons[i].ID === ui.defaultPerson){
                    ui.modalPersonDropDown.append($("<option selected='selected'></option>").attr("value",ui.persons[i].ID).text(ui.persons[i].TEXT));
                } else {
                    ui.modalPersonDropDown.append($("<option></option>").attr("value",ui.persons[i].ID).text(ui.persons[i].TEXT));
                }

            }
        }

        function clearWarningTextsInModal(){
            ui.cropWarning.text('');
            ui.cropInfo.text('');
            ui.dateWarningText.text("");
            ui.selectedTaxaWarningText.text("");
            ui.selectedKeywordsWarningText.text("");
            ui.selectedPlaceWarningText.text("");
        }


        function setLangTexts(languageId) {

            // S V E N S K A
            if (languageId === '2') {

                lang = {

                    mainHeaderAdd : "Lägg till bild",
                    mainHeaderEdit : "Ändra redan upplagd bild",
                    mainHeaderDelete : "Tag bort bild?",

                    tabPhoto : 'Bild',
                    tabMetaData : 'Bilddata',

                    reCrop : 'Ändra bildutsnitt',

                    btnPhotoModalCancel : 'Avbryt',
                    btnPhotoModalSave : 'Spara ändringar',
                    yes : "Ja",
                    no : "Nej",

                    cropWarning : 'Hårt utskurna bilder (mindre än 553/553 eller 553/800 bildpunkter) ser gryniga ut när de visas på sajten.',
                    cropWarningNotAnImage : 'Vänligen välj en korrekt (jpg) bild.',

                    // modal edit table data
                    lblPerson : "Fotograf",
                    lblDateTaken : "Datum när bilden är tagen",
                    lblTaxa : 'Art',
                    lblPlats : "Plats (fri text)",
                    lblKeywords : "Nyckelord",
                    lblPublished : "Publicerad i galleriet",
                    ddTaxaNoValue : "--välj en art--",
                    ddPersonNoValue : "--Välj en person--",
                    ddKeywordsNoValue : "--Välj ett nyckelord--",

                    // image manipulation buttons
                    btnStartCropper : "Klipp ut igen",
                    btnFlip : "Spegelvänd bilden",
                    btnRotate : "Rotera bilden 90 grader",
                    btn32 : "Sätt bildproportioner 3/2",
                    btn11 : "Sätt bildproportioner 1/1",
                    btnReset : "Återställ utklippsytan",

                    // Crop info
                    height : "Höjd",
                    width : "Vidd",
                    ratio : "Proportioner",

                    // warning messages
                    dateWarningText : 'Ogiltigt datum angivet.',
                    tooOldDate : 'Datum äldre än 1950 inte tillåtna.',
                    selectedTaxaWarningText : 'Du måste ange minst en art eller ett nyckelord.',
                    selectedPlaceWarningText : 'Plats måste anges.'

                }

            }


            ui.tabPhoto.text( lang.tabPhoto);
            ui.tabMetaData.text( lang.tabMetaData);

            ui.btnPhotoModalReCrop.attr('title', lang.reCrop );
            ui.btnPhotoModalReCrop.text( lang.reCrop );

            // Buttons
            ui.btnPhotoModalCancel.text( lang.btnPhotoModalCancel );
            ui.btnPhotoModalSave.text( lang.btnPhotoModalSave );

            $('#lblPhotoModalPerson').text(lang.lblPerson);  // Photographer
            $('#lblPhotoModalDateTaken').text(lang.lblDateTaken);
            $('#lblPhotoModalTaxa').text(lang.lblTaxa);
            $('#lblPhotoModalKeywords').text(lang.lblKeywords);

            $('#lblPhotoModalPlats').text(lang.lblPlats);
            $('#lblPhotoModalPublished').text(lang.lblPublished);

            ui.btnStartCrop.attr('title', lang.btnStartCropper);
            ui.btnFlip.attr('title', lang.btnFlip );
            ui.btnRotate.attr('title', lang.btnRotate );
            ui.btn32.attr('title', lang.btn32 );
            ui.btn11.attr('title', lang.btn11 );
            ui.btnReset.attr('title', lang.btnReset );

        }


        $('.closeModalEditPhoto').click(function(){
            ui.imagePreview.cropper('destroy');
            ui.window.modal('hide');
        });


        ui.selectImage.change(function() {

            imageOK = true;
            ui.cropWarning.text('');
            ui.cropWarning.toggleClass('mg-hide-element', true);

            const imgURL = URL.createObjectURL(ui.selectImage[0].files[0]);
            ui.imagePreview.attr('src', imgURL);

            setupCropper();


        });

        ui.imagePreview.on('error', function() {
            ui.cropWarning.toggleClass('mg-hide-element', false);
            ui.cropWarning.text(lang.cropWarningNotAnImage);
            imageOK = false;
        });


        function setupCropper() {

            ui.imagePreviewWrapper.toggleClass('mg-hide-element', false);
            ui.imagePreview.cropper('destroy');
            ui.grpEditButtons.toggleClass('mg-hide-element', false);
            ui.cropInfo.toggleClass('mg-hide-element', false)

            ui.imagePreview.cropper({

                initialAspectRatio: 1.5,
                aspectRatio: 1.5,
                viewMode: 1,
                zoomable: false,
                ready: function (/*e*/) {
                    $(this).cropper('setData', {
                        height: 553,
                        width: 800,
                        rotate: 0,
                        scaleX: 1,
                        scaleY: 1,
                        x: 0,
                        y: 0
                    });
                },

                // yet more options here
            });

            document.getElementById('photoModalImgPreviewUpload').addEventListener('crop', function (/*event*/) {
                showCroppingInfo();
            });

        }


        function showCroppingInfo(){

            let data = ui.imagePreview.cropper('getData');

            const height = Math.round(data.height);
            const width = Math.round(data.width);
            const info = lang.height + ': ' + height + ', ' + lang.width + ': ' + width;
            ui.cropInfo.html(info);

            ui.cropWarning.text('');
            ui.cropWarning.toggleClass('mg-hide-element', true);
            if (height < 533) {
                ui.cropWarning.text(lang.cropWarning);
                ui.cropWarning.toggleClass('mg-hide-element', false);
            }

        }


        ui.btnReset.click( function(){
            setupCropper();
        });


        ui.btnRotate.click( function(event){
            event.preventDefault();
            ui.imagePreview.cropper('rotate', 90);
        });


        ui.btn32.click( function(){

            let c = ui.imagePreview.data('cropper');
            c.setAspectRatio(1.5);
            c.setData({
                height: 553,
                width: 800
            })
        });


        ui.btn11.click( function(){

            let c = ui.imagePreview.data('cropper');
            c.setAspectRatio(1);
            c.setData({
                height: 553,
                width: 553
            })


        });


        ui.btnFlip.click(function(event){
            event.preventDefault();
            let data = ui.imagePreview.cropper('getData');
            ui.imagePreview.cropper('scale', -data.scaleX, data.scaleY);
        });


        ui.btnStartCrop.click(function(event){
            event.preventDefault();
            setupCropper();
        });


        function populateModalDropDowns(languageId, loggedInUserId){

            // taxa - photos
            $.ajax({
                type: "GET",
                url: window.location.origin + "/api/getTaxaData.php?lang=" + languageId,
                success: function (data) {

                    let thisOption = '<option value="0" selected>' + lang.ddTaxaNoValue  + '</option>';
                    ui.modalTaxaDropDown.append(thisOption);
                    let taxa = JSON.parse(data);
                    const l = taxa.length;
                    for (let i = 0; i < l; i++) {
                        ui.modalTaxaDropDown.append($("<option></option>").attr("value", taxa[i].TAXA_ID).text(taxa[i].TEXT));
                    }

                }
            });

            // persons (photographers) - photos
            // get first logged-in users person id, so we can set this option as selected when
            // loading the option list in person drop down.
            $.ajax({
                type: "GET",
                url: window.location.origin + "/api/getPersonIdViaUserId.php?id=" + loggedInUserId,
                success: function (data) {

                    const person = JSON.parse(data);
                    ui.loggedInUserAsPerson = person[0].person_id;
                    ui.defaultPerson = ui.loggedInUserAsPerson;

                    $.ajax({
                        type: "GET",
                        url: window.location.origin + "/bodmin/api/getAllActivePersons.php",
                        success: function (data) {

                            ui.persons = JSON.parse(data);

                            if ((modalMode === 'edit') || (modalMode === 'delete')){

                                $.ajax({
                                    type: "GET",
                                    url: window.location.origin + "/bodmin/bilder/getAllPicData.php?id=" + imageId + "&language=" + languageId,
                                    success: function (data) {

                                        const allData = JSON.parse(data);

                                        // Populate fields
                                        const plainMetaData = allData[0][0];
                                        ui.defaultPerson = plainMetaData.PERSON_ID;
                                        ui.inputBoxPlace.val(plainMetaData.PLATS);
                                        ui.inputBoxDateTaken.val(plainMetaData.DATUM.substr(0, 10));
                                        const publishingStatus = (plainMetaData.PUBLISHED === '1');
                                        ui.checkBoxPublished.prop('checked', publishingStatus);

                                        const taxaMetaData = allData[1];
                                        // load previously added taxa (if any)
                                        $.each(taxaMetaData, function(index, value) {
                                            ui.selectedTaxa.append('<li class="mgLiInline" id="' + value.TAXA_ID + '">' + value.NAME + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
                                        });

                                        const keywordMetaData = allData[2];
                                        // load previously added keywords (if any)
                                        $.each(keywordMetaData, function(index, value) {
                                            ui.selectedKeywords.append('<li class="mgLiInline" id="' + value.KEYWORD_ID + '">' + value.TEXT + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
                                        });


                                        populatePersonDropDown();

                                        ui.waitPanel.toggleClass('mg-hide-element', true);
                                        ui.editPanel.toggleClass('mg-hide-element', false);

                                    }
                                });

                            }


                            if (modalMode === 'delete') {

                                populatePersonDropDown();
                                ui.waitPanel.toggleClass('mg-hide-element', true);
                                ui.editPanel.toggleClass('mg-hide-element', false);

                            }

                            if (modalMode === 'add') {

                                populatePersonDropDown();
                                ui.waitPanel.toggleClass('mg-hide-element', true);
                                ui.editPanel.toggleClass('mg-hide-element', false);

                            }

                        }
                    });

                }
            });


            // keywords photos
            $.ajax({
                type: "GET",
                url: window.location.origin + "/api/getKeywordsForCategory.php?cat=13&lang=" + languageId,
                success: function (data) {

                    let thisOption = '<option value="0" selected>' + lang.ddKeywordsNoValue  + '</option>';
                    ui.modalKeywordsDropDown.append(thisOption);

                    let keyWords = JSON.parse(data);
                    const l = keyWords.length
                    for (let i = 0; i < l; i++) {
                        ui.modalKeywordsDropDown.append($("<option></option>").attr("value", keyWords[i].ID).text(keyWords[i].TEXT));
                    }

                }
            });

        }


        ui.modalTaxaDropDown.change(function() {

            let selected = $("#slctPhotoModalTaxa option:selected" );

            if (!getListOfSelectedTaxaIds().includes(ui.modalTaxaDropDown.val()) && (ui.modalTaxaDropDown.val() !== '0')){
                ui.selectedTaxa.append('<li class="mgLiInline" id="' + ui.modalTaxaDropDown.val() + '">'  + selected.text() + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
            }

        });


        function getListOfSelectedTaxaIds(){

            let taxaIds = [];
            $('#selectedPhotoModalTaxa li').each(function( /*index*/ ) {
                taxaIds.push($( this ).attr('id'));
            });

            return taxaIds.toString();

        }


        function getListOfSelectedTaxaTexts(){

            let taxaTexts = [];

            $('#selectedPhotoModalTaxa li').each(function( /* index*/ ) {
                taxaTexts.push($( this ).text().trim());
            });

            return taxaTexts.toString().replaceAll(',', ', ');

        }        


        ui.selectedTaxa.on('click', '.itemSelected', function(){
            $( this ).parent().remove();
        });


        ui.modalKeywordsDropDown.change(function() {
            let selected = $("#slctPhotoModalKeywords option:selected" );
            if (!getListOfSelectedKeywordsIds().includes(selected.val()) && (selected.val() !== '0')){
                $('#selectedPhotoModalKeywords').append('<li class="mgLiInline" id="' + selected.val() + '">'  + selected.text() + '  <button type="button" class="btn btn-link itemSelected"><i class="fa fa-close"></i></button></li>');
            }
        });


        ui.selectedKeywords.on('click', '.itemSelected', function(){
            $( this ).parent().remove();
        });


        function getListOfSelectedKeywordsIds(){

            let keywordIds = [];

            $('#selectedPhotoModalKeywords li').each(function( /* index*/ ) {
                keywordIds.push($( this ).attr('id'));
            });

            return keywordIds.toString();

        }


        function getListOfSelectedKeywordsTexts(){

            let keywordTexts = [];

            $('#selectedPhotoModalKeywords li').each(function( /* index*/ ) {
                keywordTexts.push($( this ).text().trim());
            });
             
            return keywordTexts.toString().replaceAll(',', ', ');

        }


        ui.btnPhotoModalSave.click(function(){

            let ok = true;
            if (modalMode === "delete"){
                // No tests what-so-ever - we delete whatever we have in the system.
            }

            if ((modalMode === "add") || (modalMode === "edit")) {
                ok = imageOK;
                if (!ok){
                    $("#tabs").tabs("option", "active", 0);
                } else {
                    // Clear possible old error texts
                    clearWarningTextsInModal();
                }


                // image is OK, let's check the metadata.
                // Date, species location, keywords, and image (above)
                if (ok) {
                    ok = validateDate();
                }

                if (ok) {
                    ok = validateTaxaAndKeywords();
                }

                if (ok) {
                    ok = validatePlace();
                }

                if (!ok) {
                    // Show meta data tab - we have issues here
                    $("#tabs").tabs("option", "active", 1);
                }

            }

            if (ok) {

                // All validations (if applicable) are OK.
                let formData = new FormData();

                if ( imageEdited ) {
                    // Only when we have edited an image (edit/add), cropper is active.
                    let imgSmall = ui.imagePreview.cropper('getCroppedCanvas', {
                        width: 170,
                        height: 113.33
                    });
                    let imgSmallData = imgSmall.toDataURL("image/jpeg");
                    formData.append('imgSmallData', imgSmallData);

                    let img = ui.imagePreview.cropper('getCroppedCanvas');
                    let imgData = img.toDataURL("image/jpeg");
                    formData.append('imgData', imgData);
                }

                // Save selected keywords and taxa in hidden field for easy retrieval in calling code
                $('#selectedKeywords').val(getListOfSelectedKeywordsTexts());
                $('#selectedTaxa').val(getListOfSelectedTaxaTexts());

                formData.append('mode', modalMode);

                // https://github.com/fengyuanchen/jquery-cropper
                // https://www.youtube.com/watch?v=1lrwLc-5UXs
                // https://github.com/fengyuanchen/cropper/issues/489

                formData.append('currentId', imageId);
                formData.append('taxaIds', getListOfSelectedTaxaIds());
                formData.append('keywordIds', getListOfSelectedKeywordsIds());

                let published = '0';
                if (ui.checkBoxPublished.is(':checked')) {
                    published = '1';
                }
                formData.append('published', published);
                formData.append('photographer', ui.modalPersonDropDown.val());
                formData.append('place', ui.inputBoxPlace.val());
                formData.append('dateTaken', ui.inputBoxDateTaken.val());

                $.ajax({
                    url: window.location.origin + "/aahelpers/handleImageData.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'POST',
                    success: function (data) {

                        // store id in hidden input-field and trigger change
                        // so calling code can act upon the change.
                        // modalMode is also stored in the DOM, so reacting code knows what has happened
                        const tmpId = JSON.parse(data);
                        imageId = tmpId[0].maxid;
                        ui.currentMode.val(modalMode);
                        ui.currentImageId.val(imageId).trigger('change');
                        ui.window.modal('hide');

                    }
                });

            }


        });

        function validateTaxaAndKeywords(){

            let ok = true;
            if (($('#selectedPhotoModalTaxa li').length === 0 ) && ($('#selectedPhotoModalKeywords li').length === 0 )){
                ui.selectedTaxaWarningText.text(lang.selectedTaxaWarningText);
                ui.selectedKeywordsWarningText.text(lang.selectedTaxaWarningText);
                ok = false;
            }

            return ok;
        }


        function validatePlace(){

            let ok = true;

            if ( ui.inputBoxPlace.val().trim().length === 0 ){
                ui.selectedPlaceWarningText.text(lang.selectedPlaceWarningText);
                ok = false;
            }

            return ok;
        }


        function validateDate(){

            let data = ui.inputBoxDateTaken.val();
            let ok = true;

            if (data.length === 0){
                ok = false;
                ui.dateWarningText.text(lang.dateWarningText);
            } else {
                let year = data.substr(0,4);
                if (year < '1951'){
                    ok = false;
                    ui.dateWarningText.text(lang.tooOldDate);
                }
            }

            return ok;
        }


        ui.inputBoxDateTaken.datepicker({
            dateFormat: 'yy-mm-dd',
            firstDay: 1,                    // Start with Monday
            maxDate : 0,                    // No future dates selectable
        })

        ui.tabs.tabs();
        ui.tabs.tabs({ active: 0 });  // default image tab

        $('.js-example-basic-single').select2();

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        ui.modalPersonDropDown.select2({
            dropdownParent: ui.window
        });

        ui.modalTaxaDropDown.select2({
            dropdownParent: ui.window
        });

        ui.modalKeywordsDropDown.select2({
            dropdownParent: ui.window
        });


    }


