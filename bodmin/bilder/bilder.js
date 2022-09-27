$(document).ready(function(){

    /*

    Here we have a lot of data. We must combine free search with quick display and pagination.
    All data is retrieved first and stored in an array in the browser. This takes a little while as it is a complex data structure
    with two one-to-many relationships: image->keywords, image->taxa.

    This allPhotos array is filtered to displayTable.displayTableArray which is used for building pages and pagination.

    All photo data manipulation is handled in aahelpers/PhotoPopUp.js with the HTML part coming from aahelpers/popUpImage.php.

    currentImageIdInput.change() important @ approx 510 handles post add/change/edit work, such as updating the page.

    */

    let v = {

        loggedinUserId : $('#loggedInUserId').text(),

        displayTable : {

            displayTableArray  : [],
            numberOfItems : 0,
            numberPerPage : 10,
            currentPage : 1,
            numberOfPages : 1,  // Math.ceil(numberOfItems/numberPerPage)

            tableBody : $('#imageTableBody'),

        },

        photoEditModal : null,

        lang : {
            current : $('#systemLanguageId').text(),
            editing : '0'
        },

        ui : {

            tblFilterBox : $('#tblFilterBox'),
            dataTableBody : $('#data tbody'),

            // buttons & info section
            // left-hand side
            btnEdit : $('#btnEdit'),
            btnNew : $('#btnNew'),
            btnDelete : $('#btnDelete'),
            btnShow : $('#btnShow'),
            selectedImagePanel : $('#info'),
            editActionInfo : $('#actionI'),
            btnReset : $('#btnPhotoModalReset'),

            displaytable : {

                nextButtons : $('.next-button'),
                backButtons : $('.back-button'),

            }

        },

        modalShowPhoto : {

            window : $('#modalShowPhotoWindow'),
            header : $('#modalShowPhotoHeader'),
            close : $('#btnModalShowPhotoCancel'),
            closeButtons : $('.closeModalShowPhoto'),
            showSection : $('#showSection'),

        }

    };



    function setLangTexts() {

        // E N G E L S K A
        if (v.lang.current === '1') {


            v.modalShowPhoto.lang = {
                header : "Visa bild",
                close  : "Stäng",
            }


            v.lang = {

                langAsString : 'en',

                // Button texts
                yes : "Yes",
                no : "No",
                newPicture : 'New image',
                editPicture : 'Edit image and its data',

                current : $('#lang').text(),
                title: 'Photos',
                // header info
                pageTitle : 'Photos',
                loggedInText : 'Logged in as ',
                logOutHere : "Log out here",
                hdrMain : 'Photos',
                infoLabel : 'Click a photo to activate the buttons',

                // Buttons
                btnNew : "New photo",
                btnEdit : "Edit",
                btnDelete : "Remove",
                btnShow : 'Show',

                // table
                tblFilterBox : "Filter image data here",
                tblHdrData : "Image data",
                tblHdrPhoto : 'Photo',

                tblMetaDataPhotographer : 'Photographer',
                tblMetaDataTaxa         : 'Species',
                tblMetaDataKeywords     : 'Keywords',
                tblMetaDataPlace        : 'Place',
                tblMetaDataDateTaken    : 'Date taken',
                tblMetaDataUploaded     : 'Date uploaded',
                tblMetaDataPublished    : 'Published in gallery',
                tblMetaDataURL          : 'URL',

            }
        }

        // S V E N S K A
        if (v.lang.current === '2') {

            v.lang = {

                langAsString : 'se',

                // Button texts
                deletebutton : "Tag bort",
                yes : "Ja",
                no : "Nej",

                newPicture : 'Ny bild',
                editPicture : 'Editera bilden och dess data',
                
                current : $('#lang').text(),
                title: 'Bilder',
                // header info
                notLoggedInText : 'Du är ej inloggad',
                pageTitle : 'Bilder',
                loggedInText : 'Inloggad som ',
                logOutHere : "Logga ut här",
                hdrMain : 'Bilder',
                infoLabel : 'Välj en bild för att aktivera knapparna',

                // Buttons
                btnNew : "Ladda upp ny bild",
                btnEdit : "Ändra",
                btnDelete : "Tag bort",
                btnShow : 'Visa',

                // table
                tblFilterBox : "Filtrera bilddata här",
                tblHdrData : "Bilddata",
                tblHdrPhoto : 'Bild',

                tblMetaDataPhotographer : 'Fotograf',
                tblMetaDataTaxa         : 'Art(er)',
                tblMetaDataKeywords     : 'Nyckelord',
                tblMetaDataPlace        : 'Plats',
                tblMetaDataDateTaken    : 'Tagen (datum)',
                tblMetaDataUploaded     : 'Uppladdad (datum)',
                tblMetaDataPublished    : 'Publicerad i galleriet',
                tblMetaDataURL          : 'URL',

            }


            v.modalShowPhoto.lang = {
                header : "Visa bild",
                close  : "Stäng",
            }


        }

        $(document).attr('title', v.lang.pageTitle);
        $("html").attr("lang", v.lang.langAsString);
        $('#hdrMain').text(v.lang.hdrMain);
        $('#loggedInText').text(v.lang.loggedInText);
        $('#selectInfo').text(v.lang.selectInfo);
        $('#infoLabel').text(v.lang.infoLabel);

        let loggedInInfo = v.lang.notLoggedInText;
        if (v.loggedinUserId !== '0'){
            loggedInInfo = '<a href="/bodmin/loggedout/index.php" class="mg-hdrLink">' +  ' ' + v.lang.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        // all buttons
        v.ui.btnNew.text(v.lang.btnNew);
        v.ui.btnEdit.text(v.lang.btnEdit);
        v.ui.btnDelete.text(v.lang.btnDelete);
        v.ui.btnShow.text(v.lang.btnShow);

        // main table
        v.ui.tblFilterBox.attr('placeholder', v.lang.tblFilterBox);
        $('#tblHdrData').text( v.lang.tblHdrData);
        $('#tblHdrPhoto').text( v.lang.tblHdrPhoto);

        // Meta data labels in main table
        $('.yes').text( v.lang.yes);
        $('.no').text( v.lang.no);
        $('.tblMetaDataPhotographer').text( v.lang.tblMetaDataPhotographer);
        $('.tblMetaDataTaxa').text( v.lang.tblMetaDataTaxa);
        $('.tblMetaDataKeywords').text( v.lang.tblMetaDataKeywords);
        $('.tblMetaDataPlace').text( v.lang.tblMetaDataPlace);
        $('.tblMetaDataDateTaken').text( v.lang.tblMetaDataDateTaken);
        $('.tblMetaDataUploaded').text( v.lang.tblMetaDataUploaded);
        $('.tblMetaDataPublished').text( v.lang.tblMetaDataPublished);
        $('.tblMetaDataURL').text( v.lang.tblMetaDataURL);

        // Modal show image
        v.modalShowPhoto.header.text(v.modalShowPhoto.lang.header);
        v.modalShowPhoto.close.text(v.modalShowPhoto.lang.close);

    }

    // -----------------------------------------------------------table handling -------------------------------
    // Select row in the table
    $(document).on("click", "tr", function(){
        selectRow($(this));
    });


    v.ui.tblFilterBox.on('input', function() {

        // filter the table
        v.needle = $(this).val().toLowerCase();
        v.displayTable.displayTableArray = v.allPhotos; // before any filtering
        v.displayTable.displayTableArray = v.allPhotos.filter(filterImage);
        $('#antal-bilder').text( v.displayTable.displayTableArray.length);
        buildTablePage('1');

    });


    function filterImage(element){

        // build string to search in
        const hayStack = element.photographer + ' ' + element.place + ' ' + element.keywords + ' ' + element.arter + ' ' + element.captured + ' ' + element.uploaded + + ' ' + element.id;
        return mgCheckFilterString( hayStack, v.needle)
        //return hayStack.toLowerCase().includes(v.needle);

    }


    v.ui.btnEdit.on('click', function(){

        const params = {
            mode : 'edit',
            imageId : v.currentId,
            languageId : v.lang.current,
            loggedInUserId : v.loggedinUserId
        }

        v.photoEditModal.openModal(params);

    });


    v.modalShowPhoto.closeButtons.on('click', function(){
        v.modalShowPhoto.window.modal('hide');
    });


    v.ui.btnNew.on('click', function(){

        const imgId = '0';
        const params = {
            mode : 'add',
            imageId : imgId,
            languageId : v.lang.current,
            loggedInUserId : v.loggedinUserId,
        }

        v.photoEditModal.openModal(params);

    });


    v.ui.btnDelete.on('click', function(){

        const params = {
            mode : 'delete',
            imageId : v.currentId,
            languageId : v.lang.current,
            loggedInUserId : v.loggedinUserId,
        }

        v.photoEditModal.openModal(params);

    });


    v.ui.btnShow.on('click', function(){

        // Populate modal and make it visible
        v.modalShowPhoto.showSection.html('<img class="shadow" alt="artbild" src="../../v2images/maxipics/maxipic-' + v.currentId + '.jpg?nocache=' + Date.now() + '">' );
        v.modalShowPhoto.window.modal('show');

    });


    function setEditButtonsOff(){

        $('.edit-button').prop('disabled', true);

        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type:"get",
            async: false,
            url: "../users/getUserModulePermission.php?userId=" + v.loggedinUserId + "&moduleId=9",
            success: function(data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {
                    v.ui.btnEdit.hide();
                    v.ui.btnDelete.hide();
                    v.ui.btnNew.hide();

                    $('#editButtons').html('<br/><small>' + v.lang.intebehorig + '<small>');
                    v.ui.selectedImagePanel.text('');

                }

            }
        });

    }


    function selectRow(selectedRow) {

        selectedRow.siblings().removeClass('table-active');
        selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        selectedRow.next().removeClass('mg-hide-element');

        $('.edit-button').prop('disabled', false);

        v.currentId = selectedRow.attr('id');
        v.currentPicURL = $(selectedRow).find("td").eq(0).html();
        v.ui.selectedImagePanel.html(v.currentPicURL);
        $('#infoLabel').html("");

    }


    function buildTablePage(currPage){

        v.displayTable.currentPage = currPage;

        const trimStart = (currPage-1) * v.displayTable.numberPerPage;
        const trimEnd = trimStart + v.displayTable.numberPerPage;
        const thisPageArray = v.displayTable.displayTableArray.slice(trimStart, trimEnd);

        v.ui.dataTableBody.empty();

        $.each(thisPageArray, function(index, value){

            let dateTaken = value["captured"].toLocaleString().substring(0,10);
            let dateUploaded = value["uploaded"].toLocaleString().substring(0,10);
            let url = '/v2images/minipics/minipic-' + value["id"] + '.jpg?nocache=' + Date.now();

            let html = '<tr id="' + value['id'] + '">';
            html += '<td><img src="' + url + '" class="d-block m-auto" alt="species"></td>';
            html += '<td>';
            html += '<span class="tblMetaDataPhotographer"></span>' + ': ' + value["photographer"] + '<br/>';
            let temp = "";
            if (value["arter"] !== false){
                temp = value["arter"];
            }
            html += '<span class="tblMetaDataTaxa"></span>' + ': ' + temp + '<br/>';

            temp = "";
            if (value["keywords"] !== false){
                temp = value["keywords"];
            }
            html += '<span class="tblMetaDataKeywords"></span>' + ': ' + temp + '<br/>';
            html += '<span class="tblMetaDataPlace"></span>' + ': ' + value["place"] + '<br/>';
            html += '<span class="tblMetaDataDateTaken"></span>' + ': ' + dateTaken + '<br/>';
            html += '<span class="tblMetaDataUploaded"></span>' + ': ' + dateUploaded + '<br/>';
            html += '<span class="tblMetaDataPublished"></span>' + ': ';
            let tmp = '<span class="no"></span>';
            if (value['published'] === '1') {
                tmp = '<span class="yes">JA</span>';
            }
            html += tmp;
            html += '<br/><span class="tblMetaDataURL">URL: </span>' + ': ' + url;
            html += '<br/></td>';
            html += '</tr>';

            v.displayTable.tableBody.append(html);
            //setLangTexts();
            
        });

        setLangTexts();
        if (v.currentId !== undefined){
            $('#infoLabel').html("");
        }

        setPaginationButtons()

    }


    function loadAllPhotoData(){

        v.displayTable.tableBody.empty();
        v.displayTable.tableBody.append('<tr><td colspan="2" class="text-center"><div><br/><br/><img src="../../aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"><br/><br/></div></td></tr>');

        $.ajax({
            type:"GET",
            url: "getAllMiniPics.php?lang=" + v.lang.current,
            success: function(data) {

                let photos = JSON.parse(data);

                v.allPhotos = Object.values(photos);                 // so we can filter to the below, later
                v.displayTable.displayTableArray = v.allPhotos; // before any filtering

                // build first page of table
                v.displayTable.tableBody.empty();
                v.displayTable.currentPage = 1;
                buildTablePage(v.displayTable.currentPage);
                $('#antal-bilder').text( v.displayTable.displayTableArray.length);

            }
        });

    }


    function setPaginationButtons(){

        // Next buttons
        // Default - disable next buttons
        v.ui.displaytable.nextButtons.prop('disabled', true);
        if (((parseInt(v.displayTable.currentPage)+1) * parseInt(v.displayTable.numberPerPage)) < v.displayTable.displayTableArray.length){
            v.ui.displaytable.nextButtons.prop('disabled', false);
            v.displayTable.nextPage = parseInt(v.displayTable.currentPage)+1;
        }

        // Back buttons
        // Default - disable back buttons
        v.ui.displaytable.backButtons.prop('disabled', true);
        if ((parseInt(v.displayTable.currentPage)) >= 2){
            v.ui.displaytable.backButtons.prop('disabled', false);
            v.displayTable.previousPage = v.displayTable.currentPage-1;
        }

    }


    v.ui.displaytable.nextButtons.on('click', function(){
        buildTablePage(v.displayTable.nextPage);
    });


    v.ui.displaytable.backButtons.on('click' ,function(){
        buildTablePage(v.displayTable.previousPage);
    });


    const currentImageIdInput = $('#currentImageId');
    const currentModeInput = $('#currentMode');

    currentImageIdInput.change(function() {
        // Listen to changes in the PhotoPopUp modal.
        // One modal is used for all photo work: add, edit, and delete
        // The current "mode" is stored in hidden variable in form, here currentModeInput.val()

        if (currentModeInput.val() === 'edit') {

            // After editing, the page needs to be rebuilt. Meta-data may have changed.
            // Pick up allPhotos record
            const l = v.allPhotos.length;
            for (let i = 0; i < l; i++) {

                if (v.allPhotos[i].id === currentImageIdInput.val()) {


                    // Prepare fields which cannot be picked up by a "one-liner" from the form.
                    let published = '0';
                    if ($('#cbPhotoModalPublished').prop('checked')) {
                        published = '1';
                    }

                    // This basically "CREATED_WHEN" but here we simply approximate it.
                    // Only used for sorting photos and is loaded properly next time the set of photos is
                    // loaded.
                    const d = new Date();
                    const stringDate = getDateAsYMDString(d);

                    v.allPhotos[i].arter = $('#selectedTaxa').val();
                    v.allPhotos[i].captured = $('#inpPhotoModalDateTaken').val();
                    v.allPhotos[i].id = currentImageIdInput.val();
                    v.allPhotos[i].keywords = $('#selectedKeywords').val();
                    v.allPhotos[i].photographer = $('#slctPhotoModalPerson option:selected').text();
                    v.allPhotos[i].place = $('#inpPhotoModalPlats').val();
                    v.allPhotos[i].published = published;
                    v.allPhotos[i].uploaded = stringDate;
                    break;
                }
            }

            buildTablePage(v.displayTable.currentPage);



        }

        if (currentModeInput.val() === 'add') {

            // Prepare fields which cannot be picked up by a "one-liner" from the form.
            let p = '0';
            if ($('#cbPhotoModalPublished').prop('checked')) {
                p = '1';
            }

            // This basically "CREATED_WHEN" but here we simply approximate it.
            // Only used for sorting photos and is loaded properly next time the set of photos is
            // loaded.
            const d = new Date();
            const stringDate = getDateAsYMDString(d);


            const newRecord = {
                arter: $('#selectedTaxa').val(),
                captured: $('#inpPhotoModalDateTaken').val(),
                id: currentImageIdInput.val(),
                keywords: $('#selectedKeywords').val(),
                photographer: $('#slctPhotoModalPerson option:selected').text(),
                place: $('#inpPhotoModalPlats').val(),
                published: p,
                uploaded: stringDate,
            }

            // add the record written to the DB to the image array used here
            v.allPhotos.unshift(newRecord);
            v.displayTable.displayTableArray = v.allPhotos; // before any filtering

            // Re-build first page of table, as newest photos are shown first.
            v.displayTable.tableBody.empty();
            v.displayTable.currentPage = 1;
            buildTablePage(v.displayTable.currentPage);

            // empty also filter field for consistent user experience
            v.ui.tblFilterBox.val('');

        }

        if (currentModeInput.val() === 'delete') {

            // remove "current record" from array
            const length = v.allPhotos.length;
            for (let i = 0; i < length; i++) {
                let currentRecord = v.allPhotos[i];
                if (currentRecord.id === v.currentId) {
                    v.allPhotos.splice(i, 1);
                    break;
                }
            }

            v.displayTable.displayTableArray = v.allPhotos; // re-load display table

            // Re-do the page
            v.displayTable.tableBody.empty();
            buildTablePage(v.displayTable.currentPage);

            // Un-select the now deleted image
            v.currentId = undefined;
            v.ui.selectedImagePanel.html('');
            // inform the user
            $('#infoLabel').text(v.lang.infoLabel);
            // ..and disable buttons until another photo is selected
            $('.edit-button').prop('disabled', true);

        }

    });


    setEditButtonsOff();
    setLangTexts();
    loadAllPhotoData();
    v.photoEditModal = new PhotoPopUp();

});



