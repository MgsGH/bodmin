$(document).ready(function(){

    let v = {

        date : {},

        controlPanel : {
            ui : {
                hdrMain : $('#hdrMain'),
                hdrSub : $('#hdrSub'),
                infoLabel : $('#infoLabel'),
                selectInfo : $('#selectInfo'),
                btnNew : $('#btnNew'),
                btnEdit : $('#btnEdit'),
                btnDelete : $('#btnDelete'),
                btnNewBooking : $('#btnNewBooking'),

                bookingPanel : {
                   thePanelItself : $('#bookingInfoPanel'),
                   bookedRecordLabel : $('#bookedRecordLabel'),
                   bookedRecordText : $('#bookedRecordText'),
                   btnEditBooking : $('#btnEditBooking'),
                   btnDeleteBooking : $('#btnDeleteBooking'),
                   btnShowBooking : $('#btnShowBooking'),
                },

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

        modalEditCustomer : {
            ui : {
                window : $('#editUser'),
                header : $('#modalHeaderEdit'),
                sectionDelete : $('#modalMainSectionDelete'),
                headerDelete : $('#headerDelete'),
                blurbDelete : $('#blurbDelete'),

                sectionEdit : $('#modalMainSectionEdit'),
                tabs : $('#tabs'),

                // Base data tab
                customerModalTabBaseData : $('#customerModalTabBaseData'),

                inputCustomerName : $('#inputCustomerName'),
                lblCustomerName : $('#lblCustomerName'),
                customerNameWarning : $('#customerNameWarning'),

                inputCustomerAddress : $('#inputCustomerAddress'),
                lblAddress : $('#lblAddress'),
                customerAddressWarning : $('#customerAddressWarning'),

                inputCustomerCity : $('#inputCustomerCity'),
                lblCity : $('#lblCity'),
                customerCityWarning : $('#customerCityWarning'),

                inputCustomerZipCode : $('#inputCustomerZipCode'),
                lblZipCode : $('#lblZipCode'),
                customerZipCodeWarning : $('#customerZipCodeWarning'),

                inputCustomerContactPerson : $('#inputCustomerContactPerson'),
                lblContactPerson : $('#lblContactPerson'),
                customerContactPersonWarning : $('#customerContactPersonWarning'),

                inputCustomerEmail : $('#inputCustomerEmail'),
                lblEmail : $('#lblEmail'),
                customerEmailWarning : $('#customerEmailWarning'),

                inputCustomerTelephoneOne : $('#inputCustomerTelephoneOne'),
                lblTelephoneOne : $('#lblTelephoneOne'),
                customerTelephoneOneWarning : $('#customerTelephoneOneWarning'),

                inputCustomerTelephoneTwo : $('#inputCustomerTelephoneTwo'),
                lblTelephoneTwo : $('#lblTelephoneTwo'),
                customerTelephoneTwoWarning : $('#customerTelephoneTwoWarning'),

                // Invoice data tab
                customerModalTabInvoiceData : $('#customerModalTabInvoiceData'),

                inputInvoiceName : $('#inputInvoiceName'),
                lblInvoiceName : $('#lblInvoiceName'),
                InvoiceNameWarning : $('#InvoiceNameWarning'),

                inputInvoiceId : $('#inputInvoiceId'),
                lblInvoiceId : $('#lblInvoiceId'),
                InvoiceIdWarning : $('#InvoiceIdWarning'),

                inputInvoiceAddress : $('#inputInvoiceAddress'),
                lblInvoiceAddress : $('#lblInvoiceAddress'),
                InvoiceAddressWarning : $('#InvoiceAddressWarning'),

                lblInvoiceCity : $('#lblInvoiceCity'),
                lblInvoiceZipCode : $('#lblInvoiceZipCode'),
                inputInvoiceCity : $('#inputInvoiceCity'),
                inputInvoiceZipCode : $('#inputInvoiceZipCode'),
                invoiceCityWarning : $('#InvoiceCityWarning'),

                btnSave : $('#btnModalMainSave'),
                btnCancel : $('#btnModalMainCancel'),

            },
            modalMode : '',
        },

        modalEditBooking : {
            ui : {
                window : $('#editBookings'),
                sectionDelete : $('#sectionDelete'),
                deleteWhat : $('#deleteWhat'),


                sectionEdit : $('#sectionEdit'),

                btnBookingCancel : $('#btnBookingCancel'),
                btnBookingSave : $('#btnBookingSave'),
                bookingList : $('#bookingList'),
                modalBookingsTitle : $('#modalBookingsTitle'),

                // tid antal ålder kommentarer
                // fields
                lblBookingTime : $('#lblBookingTime'),
                inputBookingTime : $('#inputBookingTime'),
                bookingTimeWarning : $('#bookingTimeWarning'),

                lblBookingNoOf : $('#lblBookingNoOf'),
                inputBookingNoOf : $('#inputBookingNoOf'),

                lblBookingAge : $('#lblBookingAge'),
                inputBookingAge : $('#inputBookingAge'),

                lblKommentar : $('#lblKommentar'),
                textAreaKommentar : $('#textAreaKommentar'),
            },
        },


        lang : {
            current : getLanguageAsNo(),
        },

        loggedInUser : $('#coolLevel').text(),

    };


    function populateBookingStatus(){

        v.modalEditBooking.ui.bookingList.empty();
        $('#selectedDate').text(v.date.current);


        $.ajax({
            type: "GET",
            url: "getBookingsForDate.php?datum=" + v.date.current,
            success: function (data) {

                let bookings = JSON.parse(data);

                let l = bookings.length;
                let html = '';
                for (let i = 0; i < l; i++) {

                    html += '<li class="list-group-item">';
                    html += bookings[i].TIME + ' ' + bookings[i].PARTY + ', ' + bookings[i].PARTICIPANTS + ' ' + v.modalEditBooking.lang.persons;
                    html += '</li>';

                }

                if (l === 0){
                    html += '<li class="list-group-item">';
                    html += v.modalEditBooking.lang.noBookings;
                    html += '</li>';
                }

                v.modalEditBooking.ui.bookingList.append(html);

            }
        });

    }

    $(document).on("click", "#data .customerRecord", function(){
        v.selectedRow = $(this);
        handleSelectedRow();
    });

    $(document).on("click", ".bookingRecord", function(){
        v.selectedBooking = $(this);
        v.selectedBookingId = $(this).attr('id');
        handleBookingRecordSelection();
    });

    $(document).on("mouseenter", ".bookingRecord", function(){
        $(this).toggleClass( 'selectedBooking', true);
    });

    $(document).on("mouseleave", ".bookingRecord", function(){
        $(this).toggleClass( 'selectedBooking', false);
    });


    function handleSelectedRow(){

        // hide booking  controls - no booking record (yet) selected
        v.controlPanel.ui.bookingPanel.thePanelItself.toggleClass('mg-hide-element', true);

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
        v.name = $(v.selectedRow).find("td").eq(0).text() + ', ' + $(v.selectedRow).find("td").eq(1).text() + ' ' + $(v.selectedRow).find("td").eq(2).text()

        v.controlPanel.ui.infoLabel.html(v.controlPanel.lang.infoLabelVald + ' ' + '<strong>' + v.name + '</strong>') ;

        populateRowDetails();

    }


    function handleBookingRecordSelection(){
        let bookingInfo = v.selectedBooking.find("span").eq(0).text() + ' ' + v.selectedBooking.find("span").eq(1).text();
        v.controlPanel.ui.bookingPanel.bookedRecordText.text(bookingInfo);
        v.controlPanel.ui.bookingPanel.thePanelItself.toggleClass('mg-hide-element', false);
    }


    function populateRowDetails(){


        $.ajax({
            type:"GET",
            url: "getFullOrder.php?order=" +  v.mainTableId + '&language=' + v.lang.current,
            success: function(data) {

                let orderData = JSON.parse(data);
                let customer = orderData["customer"][0];

                let customerInfo = customer.FIRSTNAME + ' ' + customer.LASTNAME + ', ' + customer.ADDRESS + ', ' + customer.ZIPCODE + ' ' + customer.CITY + ', ' + customer.COUNTRY;

                let infoHTML = "<div class='card pb-3'>";
                infoHTML += '<div class="card-body">';
                infoHTML += "<h5 class='card-title text-muted pt-1 pb-2'>" + v.lang.order + ' ' + customerInfo + "</h5>";
                infoHTML += '<ul class="list-group list-group-flush">';
                infoHTML +=  '<li class="list-group-item">';
                infoHTML += '<h6 class="card-subtitle mb-2 text-muted">';
                infoHTML +=  '<span class="mg-320-span"> ' + 'Vara' + '</span>';
                infoHTML +=  '<span class="mg-160-span"> ' + 'Typ' + '</span>';
                infoHTML +=  '<span class="mg-80-span"> ' + 'Storlek' + '</span>';
                infoHTML +=  '<span class="mg-60-span"> ' + 'Antal' + '</span>';
                infoHTML +=  '<span class="mg-80-span"> ' + 'Pris' + '</span>';
                infoHTML +=  '</h6>';
                infoHTML +=  '</li>';


                let orderRows = orderData["orderRows"];

                let price = 0;
                const l = orderRows.length;
                for (let i = 0; i < l; i++) {

                    infoHTML +=  '<li class="list-group-item orderRows" id="' + orderRows[i].ID + '">';
                    infoHTML +=  '<span class="mg-320-span"> ' + orderRows[i].ARTIKEL  + '</span>';
                    infoHTML +=  '<span class="mg-160-span"> ' + orderRows[i].CATEGORY_TEXT + '</span>';
                      let size = orderRows[i].SIZE;
                    if (orderRows[i].CATEGORY_ID !== ''){
                        size = '-'
                    }
                    infoHTML +=  '<span class="mg-80-span"> ' + size + '</span>';
                    infoHTML +=  '<span class="mg-60-span"> ' + orderRows[i].NOOF + '</span>';
                    infoHTML +=  '<span class="mg-80-span"> ' + orderRows[i].PRIS + '</span>';
                    price += (Number(orderRows[i].PRIS) * Number( orderRows[i].NOOF));

                    infoHTML +=  '</li>';

                }
                infoHTML += '</ul>';

                infoHTML += '</div>';
                infoHTML += '<div><span class="mg-655-span">Total:' + getNbSp(1) + '</span>' + price + '</div>';
                infoHTML += '</div>';

                const dataCell = v.selectedRowsDataRow.find("td").eq(0);
                dataCell.html(infoHTML);

            }
        });


    }

    // --------------------------------------------------------- Customer ---------------------------------
    v.controlPanel.ui.btnEdit.on('click', function(){
        // Edit customer

        clearWarnings();

        v.modalEditCustomer.modalMode = 'edit';

        alert('Inte gjord ännu');

        /*

        v.modalEditCustomer.ui.sectionEdit.toggleClass('mg-hide-element', false);
        v.modalEditCustomer.ui.sectionDelete.toggleClass('mg-hide-element', true);

        v.modalEditCustomer.ui.tabs.tabs({ active: 0 });  // default base data tab

        v.modalEditCustomer.ui.btnCancel.text(v.lang.cancel);
        v.modalEditCustomer.ui.btnSave.text(v.lang.save);

        $.ajax({
            type:"GET",
            url: "getCustomerViaId.php?id=" +  v.mainTableId,
            success: function(data) {

                v.modalEditCustomer.ui.header.text(v.lang.editUser);

                $('#modal-mode').text("edit");
                $('#action').attr('value', "edit");

                v.modalEditCustomer.ui.btnCancel.text(v.lang.cancel);
                v.modalEditCustomer.ui.btnSave.text(v.lang.save);

                // clear error messages
                $('#userNameWarning').text('');

                // hide delete section
                $('#delete-section').addClass('mg-hide-element');
                // show other data
                $('#user-section').removeClass('mg-hide-element');
                $('#activated-section').removeClass('mg-hide-element');


                let obj = JSON.parse(data);
                let customerFromDb = obj[0];
                // Populate edit form with gotten data
                // Base-data tab
                v.modalEditCustomer.ui.inputCustomerName.val(customerFromDb.GROUP_NAME);
                v.modalEditCustomer.ui.inputCustomerAddress.val(customerFromDb.ADDRESS);
                v.modalEditCustomer.ui.inputCustomerCity.val(customerFromDb.CITY);
                v.modalEditCustomer.ui.inputCustomerZipCode.val(customerFromDb.ZIPCODE);
                v.modalEditCustomer.ui.inputCustomerContactPerson.val(customerFromDb.CONTACT_NAME);
                v.modalEditCustomer.ui.inputCustomerEmail.val(customerFromDb.EMAIL);
                v.modalEditCustomer.ui.inputCustomerTelephoneOne.val(customerFromDb.TEL_NO_1);
                v.modalEditCustomer.ui.inputCustomerTelephoneTwo.val(customerFromDb.TEL_NO_2);
                // Invoice data tab
                v.modalEditCustomer.ui.inputInvoiceName.val(customerFromDb.INVOICE_NAME);
                v.modalEditCustomer.ui.inputInvoiceId.val(customerFromDb.INVOICE_ID);
                v.modalEditCustomer.ui.inputInvoiceAddress.val(customerFromDb.INVOICE_ADDRESS);
                v.modalEditCustomer.ui.inputInvoiceCity.val(customerFromDb.INVOICE_CITY);
                v.modalEditCustomer.ui.inputInvoiceZipCode.val(customerFromDb.INVOICE_ZIPCODE);

                v.modalEditCustomer.ui.window.modal('show');

            }
        });

         */

    });

    v.controlPanel.ui.btnNew.on('click', function(){
        // New customer

        clearWarnings();

        v.modalEditCustomer.modalMode = 'add';

        v.modalEditCustomer.ui.tabs.tabs({ active: 0 });  // default base data tab

        v.modalEditCustomer.ui.header.text(v.lang.newUser);

        v.modalEditCustomer.ui.btnCancel.text(v.lang.cancel);
        v.modalEditCustomer.ui.btnSave.text(v.lang.save);

        v.modalEditCustomer.ui.sectionEdit.toggleClass('mg-hide-element', false);
        v.modalEditCustomer.ui.sectionDelete.toggleClass('mg-hide-element', true);

        // clear possible error messages
        $('#userNameWarning').text('');

        // empty (and default - not applicable here) fields
        v.modalEditCustomer.ui.inputCustomerName.val('');
        v.modalEditCustomer.ui.inputCustomerAddress.val('');
        v.modalEditCustomer.ui.inputCustomerZipCode.val('');
        v.modalEditCustomer.ui.inputCustomerCity.val('');
        v.modalEditCustomer.ui.inputCustomerContactPerson.val('');
        v.modalEditCustomer.ui.inputCustomerEmail.val('');
        v.modalEditCustomer.ui.inputCustomerTelephoneOne.val('');
        v.modalEditCustomer.ui.inputCustomerTelephoneTwo.val('');
        v.modalEditCustomer.ui.inputInvoiceName.val('');
        v.modalEditCustomer.ui.inputInvoiceId.val('');
        v.modalEditCustomer.ui.inputInvoiceAddress.val('');
        v.modalEditCustomer.ui.inputInvoiceZipCode.val('');
        v.modalEditCustomer.ui.inputInvoiceCity.val('');

        v.modalEditCustomer.ui.window.modal('show');

    });
    
    v.controlPanel.ui.btnDelete.on('click', function(){
        // Delete order

        v.modalEditCustomer.modalMode = 'delete';
        v.modalEditCustomer.ui.header.text(v.lang.deleteuser);

        v.modalEditCustomer.ui.btnCancel.text(v.lang.nej);
        v.modalEditCustomer.ui.btnSave.text(v.lang.ja);

        v.modalEditCustomer.ui.sectionEdit.toggleClass('mg-hide-element', true);
        v.modalEditCustomer.ui.sectionDelete.toggleClass('mg-hide-element', false);

        //v.modalEditCustomer.ui.blurbDelete.text(v.modalEditCustomer.lang.blurbDelete);
        v.modalEditCustomer.ui.headerDelete.text(v.name);

        v.modalEditCustomer.ui.window.modal('show');

    });

    v.modalEditCustomer.ui.btnSave.on('click', function(){
        // Save customer

        clearWarnings();

        let ok = true;

        if (v.modalEditCustomer.modalMode === "delete"){
            // No tests what-so-ever - we delete whatever we have.
        }

        if ((v.modalEditCustomer.modalMode === "add") || (v.modalEditCustomer.modalMode === "edit")) {

            // Normal fields
            // validate lightly group name, contact name, and email.
            if (v.modalEditCustomer.ui.inputCustomerName.val().trim() === ''){
                v.modalEditCustomer.ui.customerNameWarning.text(v.modalEditCustomer.lang.customerNameWarning);
                v.modalEditCustomer.ui.inputCustomerName.toggleClass('inputWarning', true);
                ok = false;
            }

            if (ok){

                if (v.modalEditCustomer.ui.inputCustomerContactPerson.val().trim() === ''){
                    v.modalEditCustomer.ui.customerContactPersonWarning.text(v.modalEditCustomer.lang.customerContactPersonWarning);
                    v.modalEditCustomer.ui.inputCustomerContactPerson.toggleClass('inputWarning', true);
                    ok = false;
                }

            }

            if (ok){
                // is email formally OK?
                if (!checkEmailAddress(v.modalEditCustomer.ui.inputCustomerEmail.val())){
                    ok = false;
                    v.modalEditCustomer.ui.customerEmailWarning.text(v.modalEditCustomer.lang.customerEmailWarning);
                }

            }


        }

        if (ok) {
            // All validations (as applicable) are OK.
            // We save

            let formData = new FormData();

            formData.append('mode', v.modalEditCustomer.modalMode);
            formData.append('logged_in_user', v.loggedInUser);


            let id = v.mainTableId;
            if (v.modalEditCustomer.modalMode === 'add') {
                id = '0'
            }
            formData.append('order_id', id);
            formData.append('customer_name', v.modalEditCustomer.ui.inputCustomerName.val());
            formData.append('customer_address', v.modalEditCustomer.ui.inputCustomerAddress.val());
            formData.append('customer_zipcode', v.modalEditCustomer.ui.inputCustomerZipCode.val());
            formData.append('customer_city', v.modalEditCustomer.ui.inputCustomerCity.val());
            formData.append('customer_email', v.modalEditCustomer.ui.inputCustomerEmail.val());



            $.ajax({
                url: window.location.origin + "/bodmin/fyrshopen/orders/handleData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function (data) {

                    if (v.modalEditCustomer.modalMode === 'edit'){
                        // Re-populate the row with updated data
                        $(v.selectedRow).find("td").eq(0).text(v.modalEditCustomer.ui.inputCustomerName.val());
                        $(v.selectedRow).find("td").eq(1).text(v.modalEditCustomer.ui.inputCustomerContactPerson.val());
                        $(v.selectedRow).find("td").eq(2).text(v.modalEditCustomer.ui.inputCustomerCity.val());
                    }

                    if (v.modalEditCustomer.modalMode === 'add'){

                        // Create the row in the table on screen ...and
                        // populate it with new data

                        let writtenData = JSON.parse(data);
                        let writtenId = (writtenData.ID);

                        let row = '<tr id="' + writtenId + '">';
                        row += '<td>' + v.modalEditCustomer.ui.inputCustomerName.val() + '</td>';
                        row += '<td>' + v.modalEditCustomer.ui.inputCustomerContactPerson.val() + '</td>';
                        row += '<td>' + v.modalEditCustomer.ui.inputCustomerCity.val() + '</td>';
                        row += '<td>' + $('#userName').text() + '</td>';
                        let dateAsYmd = getDateAsYMDString(new Date())
                        row += '<td>' + dateAsYmd.substring(0, 3) + '</td>';
                        row += '</tr>';

                        row += '<tr id="dataFor-' + writtenId +'" class="mg-table-row-data mg-hide-element">';
                        row += '<td colspan="7">' + mgGetDivWithSpinnerImg() + '</td>';
                        row += '</tr>';
                        v.table.dataRows.append(row);

                        v.table.ui.tblFilterBox.val( v.modalEditCustomer.ui.inputCustomerName.val() + ' ' + v.modalEditCustomer.ui.inputCustomerContactPerson.val() );
                        v.table.ui.tblFilterBox.trigger('input');
                        v.selectedRow = $( 'tr#' + writtenData.ID );
                        handleSelectedRow();

                    }

                    if (v.modalEditCustomer.modalMode === 'delete'){



                        // data row
                        let row = $( '#dataFor-' + v.mainTableId );
                        row.remove();

                        // main row
                        row = $( 'tr#' + v.mainTableId );
                        row.remove();

                        // reset ui - no record selected
                        v.mainTableId = '';
                        v.controlPanel.ui.infoLabel.html(v.controlPanel.lang.infoLabelDefault);
                        $('.editButton').prop('disabled', true);

                    }

                }

            });

            v.modalEditCustomer.ui.window.modal('hide');

        }

    });

    $('.closeModal').on('click', function(){
        v.modalEditCustomer.ui.window.modal('hide');
    });

    v.controlPanel.ui.bookingPanel.btnEditBooking.on('click',function(){
        // Edit booking

        clearWarnings();

        v.modalEditBooking.ui.sectionEdit.toggleClass('mg-hide-element', false);
        v.modalEditBooking.ui.sectionDelete.toggleClass('mg-hide-element', true);

        v.modalEditBooking.ui.btnBookingCancel.text(v.lang.cancel);
        v.modalEditBooking.ui.btnBookingSave.text(v.lang.save);

        v.modalEditBooking.modalMode = 'edit';

        $('#bookingsFor').text(v.name);
        v.modalEditBooking.ui.modalBookingsTitle.text(v.modalEditBooking.lang.modalBookingsTitleEdit);

        // Populate fields

        let ymdString = v.selectedBooking.find("span").eq(0).text();
        v.date.current = ymdString;
        let d = getDateFrom(ymdString);

        $( '#datepicker' ).datepicker('destroy');
        $( '#datepicker' ).datepicker({
            //showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1959:+1", //
            firstDay: 1, // Start with Monday
            defaultDate: d,
            onSelect: function (date) {
                v.date.current = date;
                populateBookingStatus();
            },

        });
        $("div.ui-datepicker").css("font-size", "80%");

        populateBookingStatus();

        let time = v.selectedBooking.find("span").eq(1).text();
        let number_of = v.selectedBooking.find("span").eq(2).text();
        let ages = v.selectedBooking.find("span").eq(3).text();
        let comment = v.selectedBooking.find("span").eq(4).text();

        v.modalEditBooking.ui.inputBookingTime.val(time);
        v.modalEditBooking.ui.inputBookingNoOf.val(number_of);
        v.modalEditBooking.ui.inputBookingAge.val(ages);
        v.modalEditBooking.ui.textAreaKommentar.val(comment);

        v.modalEditBooking.ui.window.modal('show');

    });

    v.controlPanel.ui.bookingPanel.btnDeleteBooking.on('click',function(){
        // Delete booking

        v.modalEditBooking.ui.sectionEdit.toggleClass('mg-hide-element', true);
        v.modalEditBooking.ui.sectionDelete.toggleClass('mg-hide-element', false);

        v.modalEditBooking.ui.btnBookingCancel.text(v.lang.nej);
        v.modalEditBooking.ui.btnBookingSave.text(v.lang.ja);

        v.modalEditBooking.modalMode = 'delete';

        $('#deleteHeader').text(v.modalEditBooking.lang.deleteHeader);
        $('#bookingsFor').text(v.name);
        v.modalEditBooking.ui.modalBookingsTitle.text('');

        v.modalEditBooking.ui.deleteWhat.text(v.controlPanel.ui.bookingPanel.bookedRecordText.text());

        v.modalEditBooking.ui.window.modal('show');

    });

    v.controlPanel.ui.bookingPanel.btnShowBooking.on('click',function(){
        alert('Coming very soon!')
    });

    v.modalEditBooking.ui.btnBookingSave.on('click', function(){
        // Save booking

        // Clear warning texts in modal (again - perhaps)
        clearWarnings();

        let ok = true;

        // validate lightly
        if (v.modalEditBooking.ui.inputBookingTime.val().trim() === ''){
            v.modalEditBooking.ui.bookingTimeWarning.text(v.modalEditBooking.lang.bookingTimeWarning);
            v.modalEditBooking.ui.inputBookingTime.toggleClass('inputWarning', true);
            ok = false;
        }

        if (ok) {
            // All validations (as applicable) are OK.

            // We "save" -> shoot off the form fpr processing

            let formData = new FormData();

            let idToEdit = '0';
            if (( v.modalEditBooking.modalMode === 'edit' ) || ( v.modalEditBooking.modalMode === 'delete' )){
                idToEdit = v.selectedBookingId;
            }

            formData.append('mode', v.modalEditBooking.modalMode);
            formData.append('logged_in_user', v.loggedInUser);
            formData.append('main_table_id', v.mainTableId);
            formData.append('record_id', idToEdit);
            formData.append('booking_date', $( '#datepicker' ).datepicker().val());
            formData.append('booking_time', v.modalEditBooking.ui.inputBookingTime.val());
            formData.append('booking_noof', v.modalEditBooking.ui.inputBookingNoOf.val());
            formData.append('booking_age', v.modalEditBooking.ui.inputBookingAge.val());
            formData.append('booking_comment', v.modalEditBooking.ui.textAreaKommentar.val());

            $.ajax({
                url: window.location.origin + "/bodmin/guidningar/orders/handleBookingData.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function () {
                    populateRowDetails();
                }

            });

            v.modalEditBooking.ui.window.modal('hide');

        }

    });

    $('.closeModalBookings').on('click', function(){
        v.modalEditBooking.ui.window.modal('hide');
    });

    function setEditButtonsOff(){

        v.controlPanel.ui.btnEdit.prop('disabled', true);
        v.controlPanel.ui.btnNewBooking.prop('disabled', true);
        v.controlPanel.ui.btnDelete.prop('disabled', true);

        // if not sufficient permissions let the buttons be hidden altogether - at least for now!
        /*
        $.ajax({
            type:"GET",
            async: false,
            url: "getUserModulePermission.php?userId=" + v.loggedInUser + "&moduleId=10",
            success: function(data) {

                let obj = JSON.parse(data);

                // default no permissions
                let permission = 1;
                if (obj.length > 0){

                    permission = obj[0].PERMISSION_ID;

                    if (permission < 5) {
                        v.controlPanel.ui.btnEdit.hide();
                        v.controlPanel.ui.btnNewBooking.hide();
                        v.controlPanel.ui.btnDelete.hide();
                        v.controlPanel.ui.btnNew.hide();

                        $('#editButtons').html('<br/><small>Du har inte behörighet att ändra data här.<small>');
                        $('#info').text('');

                    }

                }

            }
        });

         */

    }

    function loadTable(v) {

        let tmpHTML = '<tr><td colspan="7">' + mgGetDivWithSpinnerImg() + '</td></tr>';
        v.table.ui.bodySection.empty().append(tmpHTML);

        $.ajax({
            type:"GET",
            url: "getAllOrders.php?language=" + v.lang.current,
            success: function(data) {

                let rows = "";
                let orders = JSON.parse(data);

                //create and populate the table rows
                const l = orders.length;
                for (let i = 0; i < l; i++) {
                    rows += '<tr class="customerRecord" id="' + orders[i]["ID"] + '">';

                    rows += '<td>' + orders[i]["ID"] + '</td>';
                    rows += '<td>' + orders[i]["FIRSTNAME"] + '</td>';
                    rows += '<td>' + orders[i]["LASTNAME"] + '</td>';
                    rows += '<td>' + orders[i]["CITY"] + '</td>';
                    rows += '<td>' + orders[i]["EMAIL"] + '</td>';

                    let text = '';

                    if ( orders[i]["CREATED_AT"] !== null ){
                        text = orders[i]["CREATED_AT"];
                    }
                    rows += '<td>' + text + '</td>';
                    // status here
                    rows += '<td>' + orders[i]["STATUS_TEXT"] + '</td>';
                    rows += '</tr>';
                    rows += mgGetDataRow(orders[i]["ID"], 7);

                }

                v.table.ui.bodySection.empty().append(rows);
                v.orders = orders;

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


    function setLangTexts(){

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';

            v.controlPanel.lang = {
                infoLabelVald : 'Selected',
                infoLabelDefault : 'Click an order to activate the buttons',
            }

            v.lang.nopermission = "You do not have sufficient permissions to edit data.";

            v.modalEditCustomer.lang = {

                blurbDelete: 'As well as all bookings?',

                lblCustomerName : 'Kund (grupp) namn',
                customerNameWarning : 'Name must be given',

                customerModalTabBaseData : 'Base data',

                lblContactPerson : 'Kontaktperson (namn)',
                customerContactPersonWarning : 'Kontaktperson måste anges',

                lblEmail : 'Email',
                customerEmailWarning : 'Email must be given',
                invalidEmail : "Invalid email address",

                lblTelephoneOne : 'Telephone (1)',
                customerTelephoneOneWarning : 'At least one phone number must be given',

                lblTelephoneTwo : 'Telephone (2)',
                customerTelephoneTwoWarning : 'At least one phone number must be given',

                //------------------------------------------ Invoice tab --------------------
                customerModalTabInvoiceData : 'Invoice data',

                lblInvoiceName : 'Payee name',
                invoiceNameWarning : 'Payee name must be given',

                lblInvoiceId : 'Invoice id',
                invoiceIdWarning : 'Invoice id must be given',

                lblInvoiceAddress : 'Address',
                invoiceAddressWarning : 'Address must be given',

                lblInvoiceZipCode : 'Zip code',
                lblInvoiceCity : 'City',
                customerZipCodeWarning : 'Zip code and city must be given',

            }

            // Buttons
            // main screen
            v.lang.btnNew = "New order";
            v.lang.btnEdit = "Edit";
            v.lang.btnDelete = "Remove";
            v.lang.btnShow = "Show (print-out)";
            v.lang.btnNewBooking = 'New booking';

            // edit user
            v.lang.cancel = "Cancel";
            v.lang.save = "Save";
            v.lang.deletebutton = "Remove";

            v.lang.ja = "Yes";
            v.lang.nej = "No";

            // Header info
            v.lang.notLoggedinText = 'You are not logged in';
            v.lang.loggedinText = 'Logged-in as ';
            v.lang.logOutHere = "Log out here";
            v.lang.hdrMain = 'Fyrshopen';
            v.lang.hdrSub = 'Customers & orders';


            // table
            v.lang.tblFilterBox = "Filter orders here";
            v.lang.tblHdrOrderNumber = "Order No#";
            v.lang.tblHdrFirstName = "First name";
            v.lang.tblHdrLastName = "Last name";
            v.lang.tblHdrCity = "City";
            v.lang.tblHdrEmail = "Email";
            v.lang.tblHdrSkapadNar = "Order created";
            v.lang.tblHdrOrderStatus = "Order status";

            v.lang.tblActivatedYes = 'Yes';
            // table in table
            v.lang.order = 'Order: ';

            // modal edit
            v.modalEditBooking.lang  = {

                modalBookingsTitleEdit : 'Change order: ',
                modalBookingsTitleNew : 'New order: ',

                deleteHeader             : 'Remove the booking below?',

                lblBookingTime : 'Time',
                bookingTimeWarning : 'Ange tid',

                lblBookingNoOf : 'No. of visitors',
                lblBookingAge : 'Age(s)',
                lblKommentar : 'Comment',
                noBookings : 'No bookings.',

                persons : 'persons',

        }

        }

        // S V E N S K A
        if (v.lang.current === '2'){

            v.lang.langAsString = 'se';

            v.controlPanel.lang = {
                infoLabelVald : 'Vald beställning',
                infoLabelDefault : 'Välj en beställning för att aktivera knapparna',
            }

            // modal header, depending on intent.
            v.lang.newUser = "Ny beställning";
            v.lang.editUser = "Ändra beställning";
            v.lang.deleteUser = "Ta bort beställning?";

            v.lang.nopermission = "Du har inte behörighet att ändra data.";

            v.lang.cancel = "Avbryt";
            v.lang.save = "Spara";
            v.lang.deletebutton = "Tag bort";

            v.lang.order = 'Beställning:';

            v.lang.ja = "Ja";
            v.lang.nej = "Nej";


            // warning messages
            v.lang.chguser = "Ändra data om kund";
            v.lang.invalidemail = "Ogiltig e-post adress";
            v.lang.deleteuser = "Ta bort beställning?";

            v.modalEditCustomer.lang = {

                blurbDelete: 'Samt alla bokningar?',

                customerModalTabBaseData : 'Basdata',

                lblCustomerName : 'Kund (grupp) namn',
                customerNameWarning : 'Namn måste anges',

                lblAddress : 'Address',
                customerAddressWarning : 'Adress måste anges',

                lblZipCode : 'Postnummmer',
                customerZipCodeWarning : 'Post nummer måste anges',

                lblCity : 'Post ort',
                customerCityWarning : 'Postort måste anges',

                lblContactPerson : 'Kontaktperson (namn)',
                customerContactPersonWarning : 'Kontaktperson måste anges',

                lblEmail : 'Epost adress',
                customerEmailWarning : 'Epost adress måste anges',

                lblTelephoneOne : 'Telefonnummer (1)',
                customerTelephoneOneWarning : 'Åtmistone ett telefonnummer måste anges',

                lblTelephoneTwo : 'Telefonnummer (2)',
                customerTelephoneTwoWarning : 'Åtmistone ett telefonnummer måste anges',

                //------------------------------------------ Invoice tab --------------------
                customerModalTabInvoiceData : 'Faktureringsinformation',

                lblInvoiceName : 'Fakturamottagare',
                invoiceNameWarning : 'Fakturamottagare måste anges',

                lblInvoiceId : 'Fakturanummer/kod',
                invoiceIdWarning : 'Måste anges',

                lblInvoiceAddress : 'Fakturaadress',
                invoiceAddressWarning : 'Adress måste anges',

                lblInvoiceZipCode : 'Postnummer',
                lblInvoiceCity : 'Postort',
                customerInvoiceZipCodeWarning : 'Postort och postnummer måste anges',


            }

            v.lang.title= 'Beställningar & kunder';

            // header info
            v.lang.notLoggedinText = 'Du är ej inloggad';
            v.lang.pageTitle = 'Fyrshopen - beställningar';
            v.lang.loggedinText = 'Inloggad som ';
            v.lang.logOutHere = "Logga ut här";
            v.lang.hdrMain = 'Fyrshopen';
            v.lang.hdrSub = 'Kunder, beställningar';

            // Buttons
            // main screen
            v.lang.btnNew = "Ny beställning";
            v.lang.btnEdit = "Ändra status";
            v.lang.btnDelete = "Tag bort";
            v.lang.btnNewBooking = 'Ny bokning';
            v.lang.btnShow = "Visa (utskrift)";
            // edit user

            // table
            v.lang.tblFilterBox = "Sök beställning här";
            v.lang.tblHdrOrderNumber = "Ordernummer";
            v.lang.tblHdrFirstName = "Namn";
            v.lang.tblHdrLastName = "Efternamn";
            v.lang.tblHdrCity = "Ort";
            v.lang.tblHdrEmail = "Email";
            v.lang.tblHdrSkapadNar = "Beställning gjord";
            v.lang.tblHdrOrderStatus = "Order status";

            // modal edit
            v.modalEditBooking.lang  = {

                modalBookingsTitleEdit : 'Ändra bokning: ',
                modalBookingsTitleNew : 'Ny bokning: ',

                deleteHeader             : 'Tag bort beställning?',

                lblBookingTime : 'Tid',
                bookingTimeWarning : 'Ange tid',

                lblBookingNoOf : 'Antal besökare',
                lblBookingAge : 'Ålder',
                lblKommentar : 'Kommentar',

                noBookings : 'Inga bokningar.',

                persons : 'personer',

            }


        }


        $(document).attr('title', v.lang.pageTitle);
        $("html").attr("lang", v.lang.langAsString);
        v.controlPanel.ui.hdrMain.text(v.lang.hdrMain);
        v.controlPanel.ui.hdrSub.text(v.lang.hdrSub);
        $('#loggedinText').text(v.lang.loggedinText);


        let loggedInInfo = v.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/bodmin/loggedout/index.php" class="mg-hdrLink">' +  ' ' + v.lang.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);


        // Control panel panel
        // Buttons
        v.controlPanel.ui.btnNew.text(v.lang.btnNew);
        v.controlPanel.ui.btnEdit.text(v.lang.btnEdit);
        v.controlPanel.ui.btnDelete.text(v.lang.btnDelete);
        v.controlPanel.ui.btnNewBooking.text(v.lang.btnNewBooking);
        v.controlPanel.ui.selectInfo.text(v.lang.selectInfo);
        v.controlPanel.ui.infoLabel.text(v.controlPanel.lang.infoLabelDefault);

        v.controlPanel.ui.bookingPanel.btnEditBooking.text(v.lang.btnEdit);
        v.controlPanel.ui.bookingPanel.btnDeleteBooking.text(v.lang.btnDelete);
        v.controlPanel.ui.bookingPanel.btnShowBooking.text(v.lang.btnShow);

        // main table
        v.table.ui.tblFilterBox.attr('placeholder', v.lang.tblFilterBox);

        $('#tblHdrOrderNumber').text( v.lang.tblHdrOrderNumber);
        $('#tblHdrFirstName').text( v.lang.tblHdrFirstName);
        $('#tblHdrLastName').text(v.lang.tblHdrLastName);
        $('#tblHdrCity').text(v.lang.tblHdrCity);
        $('#tblHdrEmail').text(v.lang.tblHdrEmail);
        $('#tblHdrCreatedWhen').text(v.lang.tblHdrSkapadNar);
        $('#tblHdrOrderStatus').text(v.lang.tblHdrOrderStatus);

        // modal main - customer
        v.modalEditCustomer.ui.header.text(v.lang.modalHeaderEdit);

        v.modalEditCustomer.ui.customerModalTabBaseData.text(v.modalEditCustomer.lang.customerModalTabBaseData);
        v.modalEditCustomer.ui.customerModalTabInvoiceData.text(v.modalEditCustomer.lang.customerModalTabInvoiceData);

        v.modalEditCustomer.ui.btnCancel.text(v.lang.cancel);
        v.modalEditCustomer.ui.btnSave.text(v.lang.save);
        // Tab basdata
        v.modalEditCustomer.ui.lblCustomerName.text(v.modalEditCustomer.lang.lblCustomerName);
        v.modalEditCustomer.ui.lblAddress.text(v.modalEditCustomer.lang.lblAddress);
        v.modalEditCustomer.ui.lblZipCode.text(v.modalEditCustomer.lang.lblZipCode);
        v.modalEditCustomer.ui.lblCity.text(v.modalEditCustomer.lang.lblCity);
        v.modalEditCustomer.ui.lblContactPerson.text(v.modalEditCustomer.lang.lblContactPerson);
        v.modalEditCustomer.ui.lblEmail.text(v.modalEditCustomer.lang.lblEmail);
        v.modalEditCustomer.ui.lblTelephoneOne.text(v.modalEditCustomer.lang.lblTelephoneOne);
        v.modalEditCustomer.ui.lblTelephoneTwo.text(v.modalEditCustomer.lang.lblTelephoneTwo);
        // Tab faktura information
        v.modalEditCustomer.ui.lblInvoiceName.text(v.modalEditCustomer.lang.lblInvoiceName);
        v.modalEditCustomer.ui.lblInvoiceAddress.text(v.modalEditCustomer.lang.lblInvoiceAddress);
        v.modalEditCustomer.ui.lblInvoiceCity.text(v.modalEditCustomer.lang.lblInvoiceCity);
        v.modalEditCustomer.ui.lblInvoiceId.text(v.modalEditCustomer.lang.lblInvoiceId);
        v.modalEditCustomer.ui.lblInvoiceZipCode.text(v.modalEditCustomer.lang.lblInvoiceZipCode);

        // modal edit bokningar
        v.modalEditBooking.ui.lblBookingTime.text(v.modalEditBooking.lang.lblBookingTime);
        v.modalEditBooking.ui.lblBookingNoOf.text(v.modalEditBooking.lang.lblBookingNoOf);
        v.modalEditBooking.ui.lblBookingAge.text(v.modalEditBooking.lang.lblBookingAge);
        v.modalEditBooking.ui.lblKommentar.text(v.modalEditBooking.lang.lblKommentar);


    }

    v.lang.alpha = $('#metaLang').attr('content');
    v.lang.current = getLanguageAsNo();
    setLangTexts();

    //$('.ui-datepicker-current-day').trigger("click");

    v.modalEditCustomer.ui.tabs.tabs();


    setEditButtonsOff();
    loadTable(v);

});
