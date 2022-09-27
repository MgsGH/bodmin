$(document).ready(function() {

    let v = {

        orderButton : $('#orderButton'),
        gVar : $('#g-var'),
        logi : $('#logi'),
        lVar : $('#l-var'),
        sumSlider : $('#sum'),
        sumValue : $('#sumValue'),

        lang: {
            current: $('#lang').text(),
        },

        formwarnings : {

            generalWarning          : $('#generalWarning'),
            motifWarning            : $('#motifWarning'),
            dateWarning             : $('#dateWarning'),
            toWhomWarning           : $('#toWhomWarning'),
            greetingWarning         : $('#greetingWarning'),
            wishesWarning           : $('#wishesWarning'),
            deliveryNameWarning     : $('#deliveryNameWarning'),
            deliveryAddressWarning  : $('#deliveryAddressWarning'),
            payeeNameWarning        : $('#payeeNameWarning'),
            payeeContactWarning     : $('#payeeContactWarning'),

        },

        // fields
        deliveryDate : $( "#deliveryDate" ),
        formFields : {
            jubilee : $('#jubilee'),
            greeting : $('#greeting'),
            wishes : $('#wishes'),
            deliveryLastName : $('#deliveryLastName'),
            deliveryFirstName : $('#deliveryFirstName'),
            deliveryAddressStreet : $('#deliveryAddressStreet'),
            deliveryAddressZipCode : $('#deliveryAddressZipCode'),
            deliveryAddressCity : $('#deliveryAddressCity'),
            payeeFirstName : $('#payeeFirstName'),
            payeeLastName : $('#payeeLastName'),
            payeeEmail : $('#payeeEmail'),
            payeeTelephone : $('#payeeTelephone'),

        },

        intro : {
            bodyHeader : $('#bodyHeader'),
            p1 : $('#p1'),
            p2 : $('#p2'),
            p3 : $('#p3'),
        },

        formTexts : {
            orderHereHeader : $('#orderHereHeader'),
            motifHeader : $('#motifHeader'),
            motifPrompt : $('#motifPrompt'),

            giftHeader : $('#giftHeader'),

            jubileeLabel : $('#jubileeLabel'),
            greetingLabel : $('#greetingLabel'),
            wishesLabel : $('#wishesLabel'),

            deliveryAddressHeader    : $('#deliveryAddressHeader'),

            payeeHeader : $('#payeeHeader'),

            sumHeader : $('#sumHeader'),

        },



    }



    function setLangTexts(){

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';

            v.lang.intro = {
                bodyHeader : 'Christmas gift',
                p1 : 'A Christmas gift to a charity is an alternative to just another "gadget". You give someone a gift to Falsterbo Bird Observatory by filling out the form below, and transfer a sum to our 90-account (bg 900-3013, pg 900301-3, Skånes Ornitologiska Förening). Kinldy provide the required information below.',
                p2 : 'As soon as our bank has received the transfer the Christmas gift is sent to the address you have provided.',
                p3 : 'Should you be in a real emergency, get in contact with us over phone (0736-254 256), sand we can probably work something out.',
            }

            v.lang.giftTitles = {

                siskin: 'Redpoll',

            }

            v.lang.formWarnings = {
                generalWarning          : 'There is a problem with the form. You may have to scroll up to locate it.',
                motifWarning            : 'You have to select a letter.',
                dateWarning             : 'A date must be given.',
                toWhomWarning           : 'A name must be given.',
                greetingWarning         : 'A greeting must be given',
                wishesWarning           : 'From who must be given.',
                deliveryNameWarning     : 'Delivery name must be given',
                deliveryAddressWarning  : 'A full delivery address must be given',
                payeeNameWarning        : 'Payee information must be given',
                payeeWrongEmailWarning  : 'Invalid email address given.',
            }

            v.lang.formTexts = {
                orderHereHeader      : 'Order here',
                motifHeader          : 'Motif',
                giftHeader           : 'The gift',
                motifPrompt          : 'Click on the image for a larger version.',
                dateHeader           : 'Christmas greetings',
                jubileeLabel         : 'To',
                greetingLabel        : 'Greeting',
                greetingText         : 'God Jul till',
                wishesLabel          : 'Wishes',
                deliveryAddressHeader   : 'Delivery address',
                deliveryAddressFirstName: 'First name',
                deliveryAddressLastName : 'Last name',
                deliveryAddressStreet   : 'Street and number',
                deliveryAddressZipCode  : 'Zip code',
                deliveryAddressCity     : 'Place',
                payeeHeader             : 'Payee',
                payeeFirstName          : 'First name',
                payeeLastName           : 'Last name',
                payeeEmail              : 'E-mail address',
                payeeTelephone          : 'Telephone number',
                sumHeader               : 'Sum',
                orderButton             : 'Order your gift',
                ConfirmationHeader      : 'Kindly confirm your order as per below',
                buttonCancel            : 'Cancel',
                buttonOK                : 'Confirm',
            };

            v.lang.closeButtonText = 'Close';

        }


        // S V E N S K A
        if (v.lang.current === '2'){

            v.lang.langAsString = 'se';


            v.lang.intro = {
                bodyHeader : 'Julgåva',
                p1 : 'En julgåva till välgörande ändamål är ett bra alternativ till ytterligare en pryl. Du kan skänka en sådan gåva till Falsterbo Fågelstation, genom att sätta in valfritt belopp på vårt 90-konto (bg 900-3013, pg 900301-3, Skånes Ornitologiska Förening). Beställ via formuläret nedan.',
                p2 : 'Så snart Ditt bidrag registrerats av vår bank skickar vi den önskade julgåvan till den adress Du angivit.',
                p3 : 'I särskilt brådskande fall ber vi Dig ta telefonkontakt (0736-254 256), så att vi säkert hinner fixa allt i tid.',
            }

            v.lang.giftTitles = {

                siskin: 'Gråsiska',

            };

            v.lang.formWarnings = {
                generalWarning          : 'Det är problem med något fält ovan. Du kanske måste scrolla upp för att se det.',
                motifWarning            : 'Ett motiv måste väljas.',
                toWhomWarning           : 'En mottage måste anges.',
                greetingWarning         : 'En julhälsning måste anges.',
                wishesWarning           : 'Givare måste anges.',
                deliveryNameWarning     : 'Ett komplett namn måste anges.',
                deliveryAddressWarning  : 'En komplett leveransadress måste anges.',
                payeeNameWarning        : 'Inbetalarens namn måste anges.',
                payeeContactWarning     : 'Inbetalarens korrekta kontaktuppgifter måste anges.',
                payeeWrongEmailWarning  : 'Ogiltig email adress angiven.',

            };

            v.lang.formTexts = {
                orderHereHeader      : 'Beställ här',
                motifHeader          : 'Motiv',
                motifPrompt          : 'Klicka på bilden nedan för en större version.',
                giftHeader           : 'Julgåvan',
                jubileeLabel         : 'Till',
                greetingLabel        : 'Julhälsning',
                greetingText         : 'God Jul till',
                wishesLabel          : 'Önskar',
                deliveryAddressHeader   : 'Leveransadress',
                deliveryAddressFirstName: 'Förnamn',
                deliveryAddressLastName : 'Efternamn',
                deliveryAddressStreet   : 'Gata och nummer',
                deliveryAddressZipCode  : 'Postnummer',
                deliveryAddressCity     : 'Postort',
                payeeHeader             : 'Inbetalare',
                payeeFirstName          : 'Förnamn',
                payeeLastName           : 'Efternamn',
                payeeEmail              : 'E-post adress',
                payeeTelephone          : 'Telefonnummer',
                sumHeader               : 'Summa',
                orderButton             : 'Beställ din gåva',
                ConfirmationHeader      : 'Vänligen konfirmera din beställning',
                buttonCancel            : 'Avbryt',
                buttonOK                : 'Bekräfta',
            };

            v.lang.closeButtonText = 'Stäng';

        }

        v.intro.bodyHeader.text(v.lang.intro.bodyHeader);
        v.intro.p1.text(v.lang.intro.p1);
        v.intro.p2.text(v.lang.intro.p2);
        v.intro.p3.text(v.lang.intro.p3);

        v.formTexts.orderHereHeader.text(v.lang.formTexts.orderHereHeader);
        v.formTexts.motifHeader.text(v.lang.formTexts.motifHeader);
        v.formTexts.motifPrompt.text(v.lang.formTexts.motifPrompt);

        v.formTexts.giftHeader.text(v.lang.formTexts.giftHeader);
        v.formTexts.jubileeLabel.text(v.lang.formTexts.jubileeLabel);
        v.formTexts.greetingLabel.text(v.lang.formTexts.greetingLabel);
        v.formFields.greeting.text(v.lang.formTexts.greetingText);
        v.formTexts.wishesLabel.text(v.lang.formTexts.wishesLabel);

        v.formTexts.deliveryAddressHeader.text(v.lang.formTexts.deliveryAddressHeader);
        v.formFields.deliveryFirstName.attr('placeholder', v.lang.formTexts.deliveryAddressFirstName);
        v.formFields.deliveryLastName.attr('placeholder', v.lang.formTexts.deliveryAddressLastName);
        v.formFields.deliveryAddressZipCode.attr('placeholder', v.lang.formTexts.deliveryAddressZipCode);
        v.formFields.deliveryAddressStreet.attr('placeholder', v.lang.formTexts.deliveryAddressStreet);
        v.formFields.deliveryAddressCity.attr('placeholder', v.lang.formTexts.deliveryAddressCity);

        v.formTexts.payeeHeader.text(v.lang.formTexts.payeeHeader);
        v.formFields.payeeFirstName.attr('placeholder', v.lang.formTexts.payeeFirstName);
        v.formFields.payeeLastName.attr('placeholder', v.lang.formTexts.payeeLastName);
        v.formFields.payeeEmail.attr('placeholder', v.lang.formTexts.payeeEmail);
        v.formFields.payeeTelephone.attr('placeholder', v.lang.formTexts.payeeTelephone);
        v.formTexts.sumHeader.text(v.lang.formTexts.sumHeader);
        v.orderButton.text(v.lang.formTexts.orderButton);

    }


    function validateForm(){

        let ok = true;
        clearFormWarnings();

        if ($('input[name = "gift"]:checked').val() === undefined){
            ok = false;
            v.formwarnings.motifWarning.text(v.lang.formWarnings.motifWarning);
        }

        if (ok){
            if (v.formFields.jubilee.val().trim() === ''){
                ok = false;
                v.formwarnings.toWhomWarning.text(v.lang.formWarnings.toWhomWarning);
            }
        }

        if (ok){
            if (v.formFields.greeting.val().trim() === ''){
                ok = false;
                v.formwarnings.greetingWarning.text(v.lang.formWarnings.greetingWarning);
            }
        }

        if (ok){
            if (v.formFields.wishes.val().trim() === ''){
                ok = false;
                v.formwarnings.wishesWarning.text(v.lang.formWarnings.wishesWarning);
            }
        }

        if (ok){
            if ((v.formFields.deliveryLastName.val().trim() === '') || (v.formFields.deliveryFirstName.val().trim() === '')) {
                ok = false;
                v.formwarnings.deliveryNameWarning.text(v.lang.formWarnings.deliveryNameWarning);
            }
        }

        if (ok){

            if ((v.formFields.deliveryAddressStreet.val().trim() === '') || (v.formFields.deliveryAddressCity.val().trim() === '') || (v.formFields.deliveryAddressZipCode.val().trim() === '')) {
                ok = false;
                v.formwarnings.deliveryAddressWarning.text(v.lang.formWarnings.deliveryAddressWarning);
            }
        }


        if (ok){

            if ((v.formFields.payeeLastName.val().trim() === '') || (v.formFields.payeeFirstName.val().trim() === '')) {
                ok = false;
                v.formwarnings.payeeNameWarning.text(v.lang.formWarnings.payeeNameWarning);
            }
        }

        if (ok){

            if ((v.formFields.payeeEmail.val().trim() === '') || (v.formFields.payeeTelephone.val().trim() === '')) {
                ok = false;
                v.formwarnings.payeeContactWarning.text(v.lang.formWarnings.payeeContactWarning);
            }
        }

        if (ok){
            if (!checkEmailAddress(v.formFields.payeeEmail.val())){
                ok = false;
                v.formwarnings.payeeContactWarning.text(v.lang.formWarnings.payeeWrongEmailWarning);
            }
        }


        if(!ok){
            v.formwarnings.generalWarning.text(v.lang.formWarnings.generalWarning);
        }

        return ok;

    }


    function clearFormWarnings(){

        v.formwarnings.motifWarning.text('');
        v.formwarnings.toWhomWarning.text('');
        v.formwarnings.greetingWarning.text('');
        v.formwarnings.wishesWarning.text('');
        v.formwarnings.deliveryNameWarning.text('');
        v.formwarnings.deliveryAddressWarning.text('');
        v.formwarnings.payeeNameWarning.text('');
        v.formwarnings.payeeContactWarning.text('');
        v.formwarnings.generalWarning.text('');

    }


    v.modalShowPhoto = {

        window : $('#modalShowPhotoWindow'),
        header : $('#modalShowPhotoHeader'),
        close : $('#btnModalShowPhotoCancel'),
        closeButtons : $('.closeModalShowPhoto'),
        showSection : $('#showSection'),

    }


    v.modalShowOrder = {

        window      : $('#modalShowOrderWindow'),
        header      : $('#modalShowOrderHeader'),
        buttonClose : $('#btnModalShowOrderCancel'),
        buttonOK    : $('#btnModalShowOrderConfirm'),
        closeButtons: $('.closeModalShowOrder'),
        showSection : $('#showOrderSection'),

    }


    v.modalShowPhoto.closeButtons.on('click', function(){
        v.modalShowPhoto.window.modal('hide');
    });

    v.modalShowOrder.closeButtons.on('click', function(){
        v.modalShowOrder.window.modal('hide');
    });


    $('.gift-button').on('click', function(){

        v.formwarnings.motifWarning.text('');
        let gift = $('input[name = "gift"]:checked').val();
        let imageName = "";
        let title = "";

        switch(gift){

            case "siskin":
                imageName = 'xmas-1-maxi.jpg';
                title = v.lang.giftTitles.siskin;
                break;


        }


        v.selectedTemplateLetter = title;
        v.modalShowPhoto.header.text(title);
        v.modalShowPhoto.close.text(v.lang.closeButtonText);
        // Populate modal and make it visible
        v.modalShowPhoto.showSection.html('<img class="shadow" alt="artbild" src=images/' + imageName +'?nocache=' + Date.now() + '">' );
        v.modalShowPhoto.window.modal('show');
        
    });


    $("#orderGift").submit(function(e){
        e.preventDefault();
    });


    v.deliveryDate.on('change', function(){
        v.formwarnings.dateWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.jubilee.on('change', function(){
        v.formwarnings.toWhomWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.greeting.on('change', function(){
        v.formwarnings.greetingWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.wishes.on('change', function(){
        v.formwarnings.wishesWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.deliveryLastName.on('change', function(){
        v.formwarnings.deliveryNameWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.deliveryFirstName.on('change', function(){
        v.formwarnings.deliveryNameWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.deliveryAddressStreet.on('change', function(){
        v.formwarnings.deliveryAddressWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.deliveryAddressCity.on('change', function(){
        v.formwarnings.deliveryAddressWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.deliveryAddressZipCode.on('change', function(){
        v.formwarnings.deliveryAddressWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.payeeFirstName.on('change', function(){
        v.formwarnings.payeeNameWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.payeeLastName.on('change', function(){
        v.formwarnings.payeeNameWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.payeeTelephone.on('change', function(){
        v.formwarnings.payeeContactWarning.text('');
        v.formwarnings.generalWarning.text('');
    });

    v.formFields.payeeEmail.on('change', function(){
        v.formwarnings.payeeContactWarning.text('');
        v.formwarnings.generalWarning.text('');
    });


    v.orderButton.on('click', function(){

        // as long as we have only one alternative
        v.selectedTemplateLetter = v.lang.giftTitles.siskin;

        if (validateForm()){

            $('#modalShowOrderHeader').text(v.lang.formTexts.ConfirmationHeader);

            let orderText = '';
            orderText += '<div class="container-fluid">';
            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.motifHeader + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + v.selectedTemplateLetter + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.greetingLabel + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#greeting').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.jubileeLabel + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#jubilee').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row mb-3">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.wishesLabel + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#wishes').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.deliveryAddressHeader + mgNbSp() + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#deliveryFirstName').val() + ' ' + $('#deliveryLastName').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + ' ' + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#deliveryAddressStreet').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row mb-3">';
            orderText += '<div class="col-md-5">' + ' ' + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#deliveryAddressZipCode').val() + ' ' + $('#deliveryAddressCity').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.payeeHeader + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#payeeFirstName').val() + ' ' + $('#payeeLastName').val() + '</div>';
            orderText += '</div>';

            orderText += '<div class="row">';
            orderText += '<div class="col-md-5">' + '   ' + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#payeeEmail').val()  + '</div>';
            orderText += '</div>';

            orderText += '<div class="row mb-3">';
            orderText += '<div class="col-md-5">' + '   ' + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#payeeTelephone').val()  + '</div>';
            orderText += '</div>';

            orderText += '<div class="row mb-3">';
            orderText += '<div class="col-md-5">' + v.lang.formTexts.sumHeader + '</div>';
            orderText += '<div class="col-md-7 col-md-offset-2">' + $('#sum').val()  + '</div>';
            orderText += '</div>';

            orderText += '</div>';
            $('#showOrderSection').html(orderText);

            v.modalShowOrder.buttonOK.text(v.lang.formTexts.buttonOK);
            v.modalShowOrder.buttonClose.text(v.lang.formTexts.buttonCancel);
            v.modalShowOrder.window.modal('show');

        }

    });


    v.modalShowOrder.buttonOK.on('click', function(){

        let formData = new FormData;
        formData.append('gift' , v.selectedTemplateLetter);
        formData.append('towhom',$('#jubilee').val());
        formData.append('greeting', $('#greeting').val());
        formData.append('wishes', $('#wishes').val());
        // delivery details
        formData.append('deliveryFirstName', $('#deliveryFirstName').val());
        formData.append('deliveryLastName', $('#deliveryLastName').val());
        formData.append('deliveryAddressStreet', $('#deliveryAddressStreet').val());
        formData.append('deliveryAddressZipCode', $('#deliveryAddressZipCode').val());
        formData.append('deliveryAddressCity', $('#deliveryAddressCity').val());
        // payee
        formData.append('payeeFirstName', $('#payeeFirstName').val());
        formData.append('payeeLastName', $('#payeeLastName').val());
        formData.append('payeeEmail', $('#payeeEmail').val());
        formData.append('payeeTelephone', $('#payeeTelephone').val());
        formData.append('sum', $('#sum').val());

        $.ajax({
            type: "POST",
            url: "handleXmasOrder.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function()
            {
                // do nothing
            },
            error: function ()
            {

            }

        });

        v.modalShowOrder.window.modal('hide');

    });


    v.deliveryDate.datepicker({ dateFormat: "yy-mm-dd" }).val();

    v.sumSlider.on('change', function(){
        v.sumValue.text(v.sumSlider.val());
    });

    v.sumSlider.trigger('change');

    setLangTexts();


});
