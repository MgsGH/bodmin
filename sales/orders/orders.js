$(document).ready(function(){

    let v = {

        btnIssueOrder : $('#btnOpenOrderForm'),

        language : {
            current : $('#lang').text(),
        },


        date : {
            current : '',   // selected even date
            getParameter : $('#date').text(),
        },

        ui : {
            page : {
                header : $('#pageHeader'),
                introText : $('#introText'),
                itemList : $('#itemList'),
                tack : $('#tack'),
            },
        },

        modalEditOrder : {
            ui : {

                window : $('#modalEditPerson'),
                header : $('#modalEditPersonHeader'),
                sectionEdit : $('#modalMainEditSection'),


                // labels, fields and warnings
                warningTextsAll : $("small[id^='warning']"),

                lblFirstName : $('#lblFirstName'),
                inpFirstName : $('#inpFirstName'),
                warningFirstName : $('#warningFirstName'),

                lblLastName : $('#lblLastName'),
                inpLastName : $('#inpLastName'),
                warningLastName : $('#warningLastName'),

                lblInpPostalAddress : $('#lblInpPostalAddress'),
                inpPostalAddress : $('#inpPostalAddress'),
                warningPostalAddress : $('#warningPostalAddress'),

                lblZipCode : $('#lblZipCode'),
                inpZipCode : $('#inpZipCode'),
                warningZipCode : $('#warningZipCode'),

                lblCity : $('#lblCity'),
                inpCity : $('#inpCity'),
                warningCity : $('#warningCity'),

                lblCountry : $('#lblCountry'),
                inpCountry : $('#inpCountry'),
                warningCountry : $('#warningCountry'),

                lblEmail : $('#lblEMail'),
                inpEMail : $('#inpEMail'),
                warningEMail : $('#warningEMail'),

                btnSave : $('#btnModalEditPersonSave'),
                btnCancel : $('#btnModalEditPersonCancel'),

            }
        }

    }

    function getTexts() {

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.decDelimiter = '.';
            v.language.locale = 'en-US';

            v.modalEditOrder.language = {
                headerEdit : 'Change data concerning ',
                headerNew : 'New person',
                headerDelete : 'Remove person',

                // field labels
                lblFirstName : 'First name',
                lblLastName : 'Last name',

                warningFirstName : 'First name must be given',
                warningLastName : 'Last name must be given',
                warningPostalAddress : 'Box or street must be given',
                warningZipCode : 'Zip code must be given',
                warningCity : 'City must be given',
                warningCountry : 'Country must be given',
                warningEMail : 'E-mail address must be given',
                warningEMailInvalid : 'Invalid email address given',

                // button texts
                btnSave : 'Submit order',
                btnCancel : 'Cancel',

                ja : "Yes",
                nej : "No"


            }

        }

        // S V E N S K A
        if (v.language.current === '2') {

            v.language.langAsString = 'se';
            v.language.decDelimiter = ',';
            v.language.locale = 'sv-SE';

            v.modalEditOrder.language = {

                headerNew : 'Slutför beställing - ange nedanstående ',

                // field labels
                lblFirstName : 'För- och efternamn',

                warningFirstName : 'Förnamn måste anges',
                warningLastName : 'Efternamn måste anges',
                warningPostalAddress : 'Postbox eller gata måste anges.',
                warningZipCode : 'Postnummer måste anges',
                warningCity : 'Postort måste anges',
                warningCountry : 'Land måste anges',
                warningEMail : 'Epost adress måste anges',
                warningEMailInvalid : 'Ogiltig e-post adress',

                // button texts
                btnSave : 'Skicka beställning',
                btnCancel : 'Avbryt',

                ja : "Ja",
                nej : "Nej"


            }

        }

        // modal Edit Person
        //v.modalEditOrder.ui.header.text(v.modalEditOrder.language.header);

        v.modalEditOrder.ui.lblFirstName.text(v.modalEditOrder.language.lblFirstName);


        v.modalEditOrder.ui.btnCancel.text(v.modalEditOrder.language.btnCancel);
        v.modalEditOrder.ui.btnSave.text(v.modalEditOrder.language.btnSave);

    }


    function populateContent(){

        v.ui.page.tack.toggleClass('mg-hide-element', true);
        v.ui.page.itemList.empty();
        v.ui.page.introText.text('Din beställningslista är tom.');
        v.ui.page.introText.toggleClass('mg-hide-element', false);

        let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);

        if ( (typeof myShoppingCart !== 'undefined' ) && ( myShoppingCart.orders.length > 0)){

            let html = '<div class="Xmg-yellow">';
            html += '<table id="data" class="table table-hover w-auto">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>' + 'Beskrivning' + '</th>' ;
            html += '<th>' + 'Storlek' + '</th>' ;
            html += '<th>' + 'Pris' + '</th>' ;
            html += '<th>' + 'Antal' + '</th>' ;
            html += '<th>' + 'Total' + '</th>' ;
            html += '</tr>' ;
            html +=     '</thead>' ;
            html +=     '<tbody>';
            v.ui.page.introText.html('<p>Klicka på en artikel nedan för att ändra antal eller för att ta bort den.</p>');
            let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);
            let l = myShoppingCart.orders.length;
            for (let i = 0; i < l; i++) {
                let order = myShoppingCart.orders[i];
                html += '<tr id="order-' + order.articleId + '">';
                html += '<td>' + order.name + '</td>';
                html += '<td>' + order.size + '</td>';
                html += '<td id="price-' + order.articleId + '" class="text-end">' + order.price + '</td>';
                let tot = parseInt(order.noof) * parseInt(order.price);
                html += '<td id="noof-' + order.articleId + '" class="text-end">' + order.noof + '</td>';
                html += '<td id="tot-' + order.articleId + '" class="text-end">' + tot + '</td>';
                html += '</tr>';
                html += '<tr class="mg-table-row-data mg-hide-element" id="data-'+ order.articleId +'">'
                html += '<td colspan="5">';

                html += '<div class="row">';

                html += '        <div class="col-1 pt-2"><label class="control-label" for="inpName" id="lblInpName">Antal: </label></div>\n';
                html += '        <div class="col-2"><input type="number" id="inpNumber-' + order.articleId + '" required class="form-control form-control-sm" value="1" width="2" autofocus="autofocus"></div>\n';
                html += '        <div class="col-8"><button id="btnOrderUpdate-' +  order.articleId + '" class="btn-sm btn-primary btn-update-order">Uppdatera antal</button>' + getNbSp(2) + '<button id="btnOrderDelete-' +  order.articleId + '" class="btn-sm btn-warning btn-delete-order">Tag bort denna vara</button></div>\n';
                html += '        <div class="col-1"></div>\n';
                html += '</div>';
                html += '    <div class="col-6 mt-2" id="info-' + order.articleId + '"></div>\n';
                html += '    <div class="mt-2"><span class="mg-warning-input" id="warningInpName-' + order.articleId +'"></span></div>\n';
                html += '</td>';
                html += '</tr>';

            }
            html += '</tbody></table>';
            html += '';
            html += '</div>';
            html += '<div class="mb-2">' ;
            html += 'Totalt ordervärde: ' + sumOrderValue() + ' kr';
            html += '</div>';
            v.ui.page.itemList.html(html);
            $('#submitOrder').toggleClass('mg-hide-element', false);

        }

    }

    
    function sumOrderValue(){

        let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);
        let l = myShoppingCart.orders.length;
        let tot = 0;
        for (let i = 0; i < l; i++) {
            let order = myShoppingCart.orders[i];
            tot += parseInt(order.noof) * parseInt(order.price);
        }

        return tot;
    }


    $(document).on("click", "#data tbody tr", function(){
        v.selectedRow = $(this);
        handleSelectedRow(v);
    });



    $(document).on("click", "body .btn-delete-order", function(e){

        e.stopImmediatePropagation();
        let rawId = $(e.target).attr('id');

        //btnOrderDelete-
        //012345678901234
        let id = rawId.substring(15);

        let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);
        let l = myShoppingCart.orders.length;

        for (let i = 0; i < l; i++) {

            if (myShoppingCart.orders[i].articleId === id  ){
                myShoppingCart.orders.splice(i, 1);
                break;
            }

        }
        sessionStorage['mySessionShoppingCart'] = JSON.stringify(myShoppingCart);

        populateContent();

    });

    
    v.btnIssueOrder.on('click', function(){

        v.modalEditOrder.ui.header.text(v.modalEditOrder.language.headerNew);

        v.modalEditOrder.mode = "add";

        v.modalEditOrder.ui.btnCancel.text(v.modalEditOrder.language.btnCancel);
        v.modalEditOrder.ui.btnSave.text(v.modalEditOrder.language.btnSave);


        // clear possible error messages
        v.modalEditOrder.ui.warningTextsAll.text('');

        // empty and default fields
        v.modalEditOrder.ui.inpFirstName.val('');
        v.modalEditOrder.ui.inpLastName.val('');


        v.modalEditOrder.ui.window.modal('show');

    });


    $('.closeModal').on('click', function(){
        v.modalEditOrder.ui.window.modal('hide');
    })


    $(document).on("click", "body .btn-update-order", function(e){

        e.stopImmediatePropagation();
        let rawId = $(e.target).attr('id');

        //btnOrderUpdate-
        //012345678901234
        let id = rawId.substring(15);

        let inputField = $('#inpNumber-' + id)
        let antal = inputField.val();
        let n = parseInt(antal);
        let ok = true;
        if ((antal === '') || (n === 0)) {
            $('#warningInpName-' + id).text('Du måste ange ett antal, som minst, ett.');
            inputField.toggleClass('mg-warning', true);
            ok = false;
        }

        if (ok){

            let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);

            let l = myShoppingCart.orders.length;
            for (let i = 0; i < l; i++) {

                if (myShoppingCart.orders[i].articleId === id  ){
                    myShoppingCart.orders[i].noof = n;
                    $('#noof-' + id).text(n);
                    $('#tot-' + id).text( n * parseInt($('#price-' + id).text()) );
                    break;
                }

            }

            sessionStorage['mySessionShoppingCart'] = JSON.stringify(myShoppingCart);

        }

    });


    v.modalEditOrder.ui.btnSave.on('click', function(){

        // clear all potential error messages
        v.modalEditOrder.ui.warningTextsAll.text('');

        // first name cannot be blank
        let ok = (v.modalEditOrder.ui.inpFirstName.val().trim().length > 0);
        if (!ok) {
            v.modalEditOrder.ui.inpFirstName.toggleClass('inputWarning', true);
            v.modalEditOrder.ui.warningFirstName.text(v.modalEditOrder.language.warningFirstName);
        }

        // last name cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpLastName.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpLastName.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningFirstName.text(v.modalEditOrder.language.warningLastName);
            }
        }


        // street or box cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpPostalAddress.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpPostalAddress.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningPostalAddress.text(v.modalEditOrder.language.warningPostalAddress);
            }
        }


        // ZipCode cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpZipCode.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpZipCode.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningZipCode.text(v.modalEditOrder.language.warningZipCode);
            }
        }

        // City cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpCity.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpCity.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningCity.text(v.modalEditOrder.language.warningCity);
            }
        }

        // Country cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpCountry.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpCountry.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningCountry.text(v.modalEditOrder.language.warningCountry);
            }
        }

        // E-mail cannot be blank
        if (ok) {
            ok = (v.modalEditOrder.ui.inpEMail.val().trim().length > 0);
            if (!ok) {
                v.modalEditOrder.ui.inpEMail.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningEMail.text(v.modalEditOrder.language.warningEMail);
            }
        }

        // E-mail cannot be blank
        if (ok) {
            ok = (checkEmailAddress(v.modalEditOrder.ui.inpEMail.val().trim()));
            if (!ok) {
                v.modalEditOrder.ui.inpEMail.toggleClass('inputWarning', true);
                v.modalEditOrder.ui.warningEMail.text(v.modalEditOrder.language.warningEMailInvalid);
            }
        }

        if (ok){

            let formData = new FormData();

            formData.append('firstName', v.modalEditOrder.ui.inpFirstName.val());
            formData.append('lastName', v.modalEditOrder.ui.inpLastName.val());
            formData.append('postalAddress', v.modalEditOrder.ui.inpPostalAddress.val());
            formData.append('zipCode', v.modalEditOrder.ui.inpZipCode.val());
            formData.append('city', v.modalEditOrder.ui.inpCity.val());
            formData.append('country', v.modalEditOrder.ui.inpCountry.val());
            formData.append('email', v.modalEditOrder.ui.inpEMail.val());

            let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);

            let items = JSON.stringify(myShoppingCart.orders);
            formData.append('items', items);

            $.ajax({
                url: "handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function ( ) {

                    // Empty the order list
                    let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);
                    myShoppingCart.orders.splice(0, myShoppingCart.orders.length);
                    sessionStorage['mySessionShoppingCart'] = JSON.stringify(myShoppingCart);

                    // Hide finalize button
                    v.ui.page.itemList.toggleClass('mg-hide-element', true);
                    $('#submitOrder').toggleClass('mg-hide-element', true);
                    v.ui.page.introText.toggleClass('mg-hide-element', true);

                    // Output nice message to the customer
                    v.ui.page.tack.toggleClass('mg-hide-element', false);



                }

            });

            v.modalEditOrder.ui.window.modal('hide');

        }

    });


    // Reset fields on entry
    // input field and warning text: inpXxxxXXxx warningXxxxXXxx
    $('body').on('focus click', 'input', function(e) {
        $(e.target).toggleClass('inputWarning', false);

        //012
        //inpSomeThing

        let id = $(e.target).attr('id').substring(3);
        $('#warning' + id ).text('');
    });


    function handleSelectedRow(v){
        handleItemRowSelection(v);
    }


    function handleItemRowSelection(v){

        if (v.selectedRow.hasClass('mg-table-row-data')){
            v.selectedRow = v.selectedRow.prev();
        }

        v.selectedRow.siblings().removeClass('table-active');
        v.selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        v.selectedRow.next().removeClass('mg-hide-element');

        v.mainTableId = v.selectedRow.attr('id');
        v.name = $(v.selectedRow).find("td").eq(0).text();

    }


    v.language.current = '2';
    getTexts();
    v.ui.page.header.html(getWebShopHeader());
    populateContent();


});

