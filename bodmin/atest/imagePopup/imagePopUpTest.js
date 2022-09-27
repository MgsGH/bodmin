$(document).ready(function(){

    const btnNewPhoto =  $('#newPhoto');
    const btnEditPhoto =  $('#editPhoto');
    const btnDeletePhoto =  $('#deletePhoto');

    const currentImageId = $('#currentImageId');
    const currentMode = $('#currentMode');

    btnNewPhoto.click(function(){

        const imgId = '0';
        const params = {
            mode : 'add',
            imageId : imgId,
            languageId : '2',
            loggedInUserId : 1
        }

        const photoEditModal = new PhotoPopUp(params);
        photoEditModal.openModal();

    });

    btnEditPhoto.click(function(){

        const imgId = $('#testId').val();
        const params = {
            mode : 'edit',
            imageId : imgId,
            languageId : '2',
            loggedInUserId : 1
        }

        const photoEditModal = new PhotoPopUp(params);
        photoEditModal.openModal();

    });

    btnDeletePhoto.click(function(){

        const imgId = $('#testId').val();
        const params = {
            mode : 'delete',
            imageId : imgId,
            languageId : '2',
            loggedInUserId : 1
        }

        const photoEditModal = new PhotoPopUp(params);
        photoEditModal.openModal();

    });

    currentImageId.change(function() {
        alert('Image written - ' + currentMode.val() );
    });


    // add profile popup to DOM ???


});