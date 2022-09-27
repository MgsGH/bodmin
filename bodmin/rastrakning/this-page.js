$(document).ready(function(){

    let bodmin = {};
    bodmin.lang = {};
    bodmin.functions = {};
    bodmin.buttons = {};
    bodmin.ui = {};
    bodmin.lang.current = $('#systemLanguageId').text();

    bodmin.ui.ddTaxaBox = $('#select-taxa-drop-down');


    setLangTexts();

    bodmin.functions.swapLanguage = function (){

        if (bodmin.lang.current === '1'){
            bodmin.lang.current = '2';
            bodmin.lang.langAsString = 'se';

        } else {
            bodmin.lang.current = '1';
            bodmin.lang.langAsString = 'en';
        }

        setLangTexts();

    }

    $('#rrTable').removeClass('mg-hide-element');
    $('#loaderDiv').addClass('mg-hide-element');
    setEditControlsOff();
    zeroSessionVariables();


    /// ---------------------------------------------------------------table handling -----------------
    //  select row in the table
    $('#data tbody tr').click( function(){
        selectRow($(this));
    });

    //  filter the table
    $('#tableSearchBox1').on('input', function() {
        filterTable();
    });

    //  filter the table
    $('#tableSearchBox2').on('input', function() {
        filterTable();
    });

    // -----------------------------------------------------------------main table maintenance---------
    $('#btnEdit').click( function(){
        openEditBoxEdit();
    });

    $('#btnNew').click( function(){
        openEditBoxNew()
    });

    $('#btnDelete').click( function(){
        openEditBoxDelete()
    });

    $('#btnSaveMainModal').click(function(){
        $("#form-edit-main-table").submit();
    });

    $('#form-edit-main-table').submit(function(event){

        let ok = true;

        bodmin.veckaWarning = $('#main-item-vecka-WarningText');
        bodmin.yearWarning = $('#main-item-year-WarningText');
        bodmin.yearWarning.text('');
        bodmin.veckaWarning.text('');
        $('#main-item-done-WarningText').text('');

        bodmin.year = $('#main-item-year').val();
        bodmin.vecka = $('#main-item-vecka').val();

        let modalMode = $('#action').attr('value');


        if ((modalMode === "add") || (modalMode === "edit") ) { // excluding delete

            ok = (bodmin.year.length > 0);
            if (!ok) {
                bodmin.yearWarning.text(bodmin.lang.yearwarning);
            }

            if (ok) {
                ok = (bodmin.year > '1900');
                if (!ok) {
                    bodmin.yearWarning.text(bodmin.lang.yearwarninglater);
                }
            }

            if (ok) {
                ok = ($.isNumeric(bodmin.year));
                if (!ok) {
                    bodmin.yearWarning.text(bodmin.lang.yearwarninglater);
                }
            }

            if (ok) {
                ok = (bodmin.vecka.length > 0);
                if (!ok) {
                    bodmin.veckaWarning.text(bodmin.lang.weekwarning);
                }
            }

            if (ok) {
                ok = (bodmin.vecka < '52');
                if (!ok) {
                    bodmin.veckaWarning.text(bodmin.lang.weekformatmax);
                }
            }

            if (ok) {
                ok = (bodmin.vecka.length = 1);
                if (!ok) {
                    bodmin.veckaWarning.text(bodmin.lang.weekformat);
                }
            }

            if (ok) {
                ok = ($.isNumeric(bodmin.vecka));
                if (!ok) {
                    bodmin.yearWarning.text(bodmin.lang.weekformat);
                }
            }


        }

        if (modalMode === "add")  { //
            if (ok) {
                // Check if the year/week is already entered
                $.ajax({
                    type: "get",
                    async: false,
                    url: "yearWeekExist.php?year=" + bodmin.year + '&vecka=' + bodmin.vecka,
                    success: function (data) {

                        let exist = JSON.parse(data);
                        let svar = exist[0];

                        ok = (svar === 'No');
                        if (!ok) {
                            $('#main-item-done-WarningText').text(bodmin.lang.yearweekwarning);
                        }

                    }
                })
            }
        }


        if (modalMode === "edit")  { //
            if (ok) {
                // Check if the year/week is already entered for another id (what we had may gave changed).

                let recordid = sessionStorage.getItem('mainTableId');

                $.ajax({
                    type: "get",
                    async: false,
                    url: 'yearWeekExistExceptId.php?id=' + recordid  + '&year=' + bodmin.year + '&vecka=' + bodmin.vecka,
                    success: function (data) {

                        let exist = JSON.parse(data);
                        let svar = exist[0];

                        ok = (svar === 'No');
                        if (!ok) {
                            $('#main-item-done-WarningText').text(bodmin.lang.yearweekwarning);
                        }

                    }
                })
            }
        }

        if (!ok) {
            event.preventDefault();
        }

    });

    //-----------------------------------------------------------------------art data--------------
    $('#btnEditSubItems').click( function(){
        openEditSubItems();
    });

    $('#btnAddTaxa').click( function(){

        addItemSection();

        // Tag bort det nu valda taxat ur listan, så vi inte kan välja det igen.
        let recentlySelected = bodmin.ui.ddTaxaBox.children("option:selected");
        recentlySelected.remove();

        // set select box tillbaka till "Välj art".
        bodmin.ui.ddTaxaBox.val(0);

        // och disable select knappen
        $(this).prop('disabled', true);
    });


    $('#btnTaxaDataSave').click(function(){
        handleTaxaData();
    });


    $('#select-taxa-drop-down').on('change',function() {

        console.log($(this).val());

        let taxaId = $(this).val();
        let disable = (taxaId === '0');
        $('#btnAddTaxa').prop('disabled', disable);

    });


    $('#select-locality-drop-down').on('change',function() {
        sessionStorage.setItem("lokalId", $(this).val() );
        $('#main-item-lokal-namn').text($("#select-locality-drop-down option:selected" ).text());
        setEditDataButtonOnOff();
    });

    // ---------------------------------------------------------------------- miscellaneous
    $('#action-info').fadeOut(6000);

    function setEditControlsOff(){

        $('#btnEdit').prop('disabled', true);
        $('#btnDelete').prop('disabled', true);

        $('#btnEditSubItems').prop('disabled',true);
        $('#select-locality-drop-down').prop('disabled',true);

        // if not sufficient permissions hide the buttons altogether - at least for now!
        $.ajax({
            type:"get",
            async: false,
            url: "../users/getUserModulePermission.php?userId=" + $('#loggedInUserId').text() + "&moduleId=9",
            success: function(data) {

                let obj = JSON.parse(data);
                let permission = obj[0].PERMISSION_ID;

                if (permission < 5) {
                    $('#btnEdit').hide();
                    $('#btnDelete').hide();
                    $('#btnNew').hide();

                    $('#editButtons').html('<br/><small>' + bodmin.lang.nopermission + '<small>');
                    $('#info').text('');

                }

            }
        });

    }


    function zeroSessionVariables(){

        sessionStorage.setItem("weekPublished", '0');
        sessionStorage.setItem("lokalId", '0');
        sessionStorage.setItem("rrVecka", '0');
        sessionStorage.setItem("rrYear", '0');
        sessionStorage.setItem("mainTableId", '0' );

        // default info text
        $('#info').html(bodmin.lang.selectweek + '</span>');

        let theRowsNotToFilter = $('[id^="detailed-data-"]');
        theRowsNotToFilter.toggleClass("mg-hide-element",true);

        $('#select-locality-drop-down').val('0');

    }


    function filterTable(){

        zeroSessionVariables();

        // Check only rows which first level data - not extra data normally hidden
        let theRowsToFilter = $('[id^="occasion-"]');
        theRowsToFilter.filter(function () {

            let currentRow = $(this);

            let filterOnYear = currentRow.find("td").eq(0).text().toLowerCase();
            let filterOnWeek = currentRow.find("td").eq(1).text().toLowerCase();

            let yearFilterString = $('#tableSearchBox1').val().toLowerCase();
            let weekFilterString = $('#tableSearchBox2').val().toLowerCase();

            // None of the boxes filled out.. do not filter
            if ((yearFilterString.trim().length === 0) && (weekFilterString.trim().length === 0)){
                currentRow.toggle(true);
            }

            // Both boxes filled out
            if ((yearFilterString.trim().length > 0) && (weekFilterString.trim().length > 0)){
                currentRow.toggle((filterOnYear.indexOf(yearFilterString) > -1) && (filterOnWeek.indexOf(weekFilterString) > -1));
            }

            // Week box filled out
            if ((yearFilterString.trim().length === 0) && (weekFilterString.trim().length > 0)){
                currentRow.toggle(filterOnWeek.indexOf(weekFilterString) > -1);
            }

            // Year box filled out
            if ((yearFilterString.trim().length > 0) && (weekFilterString.trim().length === 0)){
                currentRow.toggle(filterOnYear.indexOf(yearFilterString) > -1);
            }

        });
    }


    function openEditBoxEdit(){

        let id = sessionStorage.getItem("mainTableId");

        $.ajax({
            type:"get",
            url: "getMonOccViaId.php?id=" +  id,
            success: function(data) {

                $('#editTitle').text(bodmin.lang.changedataheader + id );

                $('#modal-mode').text("edit");
                $('#action').attr('value', "edit");

                $('#btnCancelMainModal').text(bodmin.lang.cancel);
                $('#btnSaveMainModal').text(bodmin.lang.save).show();

                // clear error messages
                let veckaWarning = $('#main-item-vecka-WarningText');
                let yearWarning = $('#main-item-year-WarningText');
                yearWarning.text('');
                veckaWarning.text('');
                $('#main-item-done-WarningText').text('');

                // hide delete section
                $('#delete-section').addClass('mg-hide-element');
                // show other data
                $('#main-edit-section').removeClass('mg-hide-element');
                $('#done-section').removeClass('mg-hide-element');

                let obj = JSON.parse(data);
                let occasion = obj[0];

                //populate edit form with gotten data
                $('#main-item-year').val(occasion.YEAR);
                $('#main-item-vecka').val(occasion.WEEK);

                let checkBoxPublished = $('#main-item-done');
                checkBoxPublished.prop('disabled', false);
                checkBoxPublished.prop('checked', false);
                if (occasion.PUBLISH === '1'){
                    checkBoxPublished.prop('checked', true);
                }

                $('#modal-edit-main-table').modal('show');

            }
        });

    }


    function openEditBoxNew(){

        $.ajax({
            type:"get",
            url: "getLastCurrentWeek.php",
            success: function(data) {

                let time = JSON.parse(data);

                let year = time[0].MAX_YEAR;
                let vecka = time[0].MAX_VECKA;

                vecka ++;
                if (vecka === '53'){
                    vecka = '01';
                    year ++;
                }

                $('#editTitle').text(bodmin.lang.newweek);
                $('#action').attr('value', "add");

                $('#cancel').text(bodmin.lang.cancel);
                $('#btnSaveMainModal').text(bodmin.lang.save).show();

                // clear possible error messages
                let veckaWarning = $('#main-item-vecka-WarningText');
                let yearWarning = $('#main-item-year-WarningText');
                yearWarning.text('');
                veckaWarning.text('');
                $('#main-item-done-WarningText').text('');

                // hide delete & publish section, publish not relevant until data (sub items) has been entered
                $('#delete-section').addClass('mg-hide-element');
                $('#done-section').addClass('mg-hide-element');

                // show other data
                $('#main-edit-section').removeClass('mg-hide-element');


                // default fields
                $('#main-item-year').val(year);
                $('#main-item-vecka').val(vecka);

                $('#modal-edit-main-table').modal('show');

            }
        });

    }


    function openEditBoxDelete(){

        let id =  sessionStorage.getItem("mainTableId");

        $.ajax({
            type: "get",
            url: "getMonOccViaId.php?id=" + id,
            success: function (data) {

                $('#editTitle').text(bodmin.lang.deleteweek);
                $('#action').attr('value', bodmin.lang.deletebutton);

                let obj = JSON.parse(data);
                let occasion = obj[0];

                // hide largest section
                $('#main-edit-section').addClass('mg-hide-element');

                // get some reasonable identifier for the delete warning
                let personName = $('#fullName').text();
                $('#recInfo').attr('value', personName);

                // get delete section, we are fiddling with it a little
                let deleteSection = $('#delete-section');

                // populate delete section
                deleteSection.html('<h6>' + personName + '</h6>');
                // and make it visible
                deleteSection.removeClass('mg-hide-element');

                btnSave = $('#btnSaveMainModal');
                btnCancel = $('#cancel');
                btnSave.show();

                btnSave.text(bodmin.lang.ja);
                btnCancel.text(bodmin.lang.nej);
                if (occasion.PUBLISH === '1') {
                    btnSave.hide();
                    btnCancel.text(bodmin.lang.cancel);
                    deleteSection.text(bodmin.lang.deleteno);
                }


                $('#modal-edit-main-table').modal('show');

            }
        })

    }


    function openEditSubItems(){

        $('#main-item-name').text($('#fullName').text() );
        $('#btnAddTaxa').prop('disabled', true);

        // clean up, we may have had a "cancel" previously. Restore to one (template) species section
        $('#item-list-item [id^="item-"]').remove();

        // get species list, and, eventually earlier entered data
        $.ajax({
            type:"get",
            async: false,
            url: "getWeekPlaceTaxaList.php?vecka=" + sessionStorage.getItem("rrVecka") + '&lokal=' + sessionStorage.getItem('lokalId') + '&lang=' + bodmin.lang.current,
            success: function(data) {

                let taxaList = JSON.parse(data);

                //populate edit form, add new boxes as needed
                for (let i = 0; i < taxaList.length; i++) {
                    addNewItemSection(taxaList[i].TAXA_ID, taxaList[i].NAME, taxaList[i].AVG_ALLA_AR );
                }

                // get and plug-in earlier entered data (if any)
                $.ajax({
                    type: "get",
                    async: false,
                    url: "getLokalArVeckaData.php?occasion=" + sessionStorage.getItem("mainTableId") + '&place=' + sessionStorage.getItem('lokalId'),
                    success: function (nodata) {
                        let taxaAndAntal = JSON.parse(nodata);
                        for (let i = 0; i < taxaAndAntal.length; i++) {

                            // antal
                            let inputBox = $('#id-input-item-' + taxaAndAntal[i].TAXA_ID);
                            inputBox.val(taxaAndAntal[i].ANTAL);

                            // record id
                            let recordIdDiv = $('#record-id-' + taxaAndAntal[i].TAXA_ID);
                            recordIdDiv.text(taxaAndAntal[i].ID);

                        }
                    }
                });


                // Remove very seldom recorded species which - unless recorded this week (since before).
                let taxaSections = $('#item-list-item [id^="item-"]');
                taxaSections.each( function( index, element ){

                    let thisTaxaSection = $(this);
                    let inputBox = thisTaxaSection.find('input');
                    let avgSpan = thisTaxaSection.find('span');
                    if ((avgSpan.text() === '0') && (inputBox.val().length === 0)) {
                        thisTaxaSection.remove();
                    }

                });


                // Before (eventually) adding taxa, we need to get the list to chose from.
                // This list is dynamic. Already present taxa, above, should not be selectable (again).
                // We load this list while the user is fiddling with the existing list
                let existingIds = getListOfTaxaInModal();
                $.ajax({
                    type: "get",
                    url: "getTaxaData.php?lang=" + bodmin.lang.current,
                    success: function (data) {

                        let theDropDown = $('#select-taxa-drop-down');
                        let thisOption = '<option value="0" selected>' + bodmin.lang.statictexts.ddTaxaNoValue  + '</option>';
                        theDropDown.append(thisOption);

                        let taxa = JSON.parse(data);
                        for (let i = 0; i < taxa.length; i++) {
                            if (!existingIds.includes(taxa[i].ID)){
                                theDropDown.append($("<option></option>").attr("value",taxa[i].ID).text(taxa[i].TEXT));
                            }
                        }

                    }
                });
            }

        });

        $('#modal-edit-sub-items').modal('show');

    }


    function addNewItemSection(taxaId, taxaName, weekAverage){

        // clone the template species section
        let newItemSection = $("#taxa-template-item").clone();

        newItemSection.attr('id', 'item-' + taxaId);

        let taxaNameDiv = newItemSection.find("#taxa-name-0");
        taxaNameDiv.text(taxaName);
        taxaNameDiv.attr('id', 'taxa-name-' + taxaId);

        let antalsBox = newItemSection.find("input[name='antal-input-box-0']");
        antalsBox.attr('id', 'id-input-item-' + taxaId);
        antalsBox.attr('name', 'antal-input-box-' + taxaId);

        let averageSpan = newItemSection.find("#average-0");
        averageSpan.attr('id', 'average-' + taxaId );
        averageSpan.text(weekAverage);

        let taxaIdDiv = newItemSection.find("#record-id-0");
        taxaIdDiv.attr('id', 'record-id-' + taxaId );

        newItemSection.removeClass('mg-hide-element');
        newItemSection.appendTo("#item-list-item");

    }


    function addItemSection(){

        let taxaName = $( "#select-taxa-drop-down option:selected" ).text();
        let taxaId = $( "#select-taxa-drop-down").val();
        let average = "-";

        addNewItemSection(taxaId, taxaName, average);

    }


    function selectRow(clickedRow) {

        //occasion-68986
        //01234567
        //only "head rows" react on clicks.
        if (clickedRow.attr('id').substr(0,8) === 'occasion'){

            // Set the stage harvest all codes
            sessionStorage.setItem("rrYear", $(clickedRow).find("td").eq(0).text() );
            sessionStorage.setItem("rrVecka", $(clickedRow).find("td").eq(1).text() );

            let publishedCell = clickedRow.find("td").eq(4);
            let published = publishedCell.hasClass('published');

            sessionStorage.setItem("weekPublished", published);

            //occasion-
            //012345678
            let id = clickedRow.attr('id').substr(9);
            sessionStorage.setItem("mainTableId", id );

            //----------- end code harvesting ----------------

            // Work on the display
            // hide ALL table details rows

            let t = $('[id^="detailed-data-"]');
            t.toggleClass('mg-hide-element', true);

            // unselect visually all rows - as previous selected row is not known (or could be none).
            clickedRow.siblings().removeClass('table-active');
            clickedRow.addClass('table-active');
            clickedRow.next().removeClass('mg-hide-element');

            // Show spinner on detail row
            let spinnerid = "#loaderdiv-" + sessionStorage.getItem("rrYear") + "-" + sessionStorage.getItem("rrVecka");
            $(spinnerid).removeClass('mg-hide-element');
            // hide table section until table is loaded
            let tabellwrapper = "#vecko-detalj-tabell-" + sessionStorage.getItem("rrYear") + "-" + sessionStorage.getItem("rrVecka");
            $(tabellwrapper).toggleClass('mg-hide-element', true);

            // enable all buttons
            $('button').prop('disabled', false);

            $('#main-item-id').val(id);

            let name = sessionStorage.getItem("rrYear") + '-' + sessionStorage.getItem("rrVecka");
            $('#main-item-recInfo').attr('value', name);

            $('#infoLabel').html(bodmin.lang.infoselectedweek + '<span id="fullName"><strong>' + name + '</strong></span>');

            setEditDataButtonOnOff();

            createRastRakningTable();
        }

    }


    function setEditDataButtonOnOff(){

        let btnEditSpeciesData = $('#btnEditSubItems');
        btnEditSpeciesData.prop('disabled',true);
        btnEditSpeciesData.attr('title', bodmin.lang.btnEditSpeciesData);
        bodmin.buttons.speciesDropDown = $('#select-locality-drop-down');
        bodmin.buttons.speciesDropDown.prop('disabled',true);

        // if handle the week itself is OK (from permissions)
        if (!$('#btnEdit').prop('disabled')){

            if (sessionStorage.getItem("weekPublished") === "true"){
                btnEditSpeciesData.attr('title', bodmin.lang.btnEditSpeciesDataTitle); /* add a flyover saying "published.." */
            } else {
                btnEditSpeciesData.prop('disabled', (sessionStorage.getItem("lokalId") === '0'));
                bodmin.buttons.speciesDropDown.prop('disabled', false);
            }

        }
    }


    //
    //  Build a list of taxa ids already listed in the modal window.
    //  we need to exclude those from being selectable in the modal taxa drop down.
    //
    function getListOfTaxaInModal(){

        let taxaNames = $('[id^="taxa-name-"]');
        let ids = [];

        taxaNames.each(function(index, value) {

            let thisId = $(this).attr('id');

            // taxa-name-xxxx : 10
            // 0123456789
            let taxaId = thisId.substr(10);
            if (taxaId !== '0'){
                ids.push(taxaId);
            }

        });

        return ids;

    }


    function getInteger(numberAsString){

        let value = parseInt(numberAsString, 10);
        if (isNaN(value)) {
            value = 0;
        }

        return value;
    }


    function getFormattedInteger(integerAsString){

        let returnValue = '-';
        let value = getInteger(integerAsString);
        if (value !== 0) {
            returnValue = new Intl.NumberFormat('sv-SE').format(value);
        }

        return returnValue;

    }


    function createRastRakningTable() {

        $.ajax({
            type: "get",
            url: "getWeekTableData.php?year=" + sessionStorage.getItem("rrYear") + '&vecka=' + sessionStorage.getItem("rrVecka") + '&lang=' + bodmin.lang.current,
            beforeSend: function() {
                $('[id^="art-"]').remove();
                $('#week-summary-row').remove();
            },
            success: function (data) {

    console.log("getWeekTableData.php?year=" + sessionStorage.getItem("rrYear") + '&vecka=' + sessionStorage.getItem("rrVecka") + '&lang=' + bodmin.lang.current);

                let art = JSON.parse(data);

                let sumBLACK = 0;
                let sumKANALEN = 0;
                let sumANGSNASET = 0;
                let sumNABBEN = 0;
                let sumSLUSAN = 0;
                let sumREVLARNA = 0;
                let sumKNOSEN = 0;
                let sumTOT = 0;
                theTable = $('#' + sessionStorage.getItem("rrYear") + '-' + sessionStorage.getItem("rrVecka"));

                //populate the week's count table
                for (let i = 0; i < art.length; i++) {
                    sumBLACK = sumBLACK + getInteger(art[i].BLACK);
                    sumKANALEN = sumKANALEN + getInteger(art[i].KANALEN);
                    sumANGSNASET = sumANGSNASET + getInteger(art[i].ANGSNASET);
                    sumNABBEN = sumNABBEN + getInteger(art[i].NABBEN);
                    sumSLUSAN = sumSLUSAN + getInteger(art[i].SLUSAN);
                    sumREVLARNA = sumREVLARNA + getInteger(art[i].REVLARNA);
                    sumKNOSEN = sumKNOSEN + getInteger(art[i].KNOSEN);
                    let newRow = $('#noll').clone();
                    newRow.attr('id', 'art-' + i+1);
                    $(newRow).find("td").eq(0).text(art[i].NAME);
                    $(newRow).find("td").eq(1).text(getFormattedInteger(art[i].KANALEN));
                    $(newRow).find("td").eq(2).text(getFormattedInteger(art[i].BLACK));
                    $(newRow).find("td").eq(3).text(getFormattedInteger(art[i].ANGSNASET));
                    $(newRow).find("td").eq(4).text(getFormattedInteger(art[i].NABBEN));
                    $(newRow).find("td").eq(5).text(getFormattedInteger(art[i].SLUSAN));
                    $(newRow).find("td").eq(6).text(getFormattedInteger(art[i].REVLARNA));
                    $(newRow).find("td").eq(7).text(getFormattedInteger(art[i].KNOSEN));
                    let totalt = getInteger(art[i].BLACK) + getInteger(art[i].KANALEN) + getInteger(art[i].ANGSNASET) + getInteger(art[i].NABBEN) + getInteger(art[i].SLUSAN) + getInteger(art[i].REVLARNA) + getInteger(art[i].KNOSEN);
                    sumTOT = sumTOT + totalt;

                    $(newRow).find("td").eq(8).text(getFormattedInteger(totalt));
                    newRow.removeClass('mg-hide-element');
                    newRow.appendTo(theTable);

                }

                let summaryRow = $('#noll').clone();
                summaryRow.attr('id', 'week-summary-row');
                $(summaryRow).find("td").eq(0).html('<strong>' + bodmin.lang.totalt + '</strong>');
                $(summaryRow).find("td").eq(1).html('<strong>' + getFormattedInteger(sumKANALEN) + '</strong>');
                $(summaryRow).find("td").eq(2).html('<strong>' + getFormattedInteger(sumBLACK) + '</strong>');
                $(summaryRow).find("td").eq(3).html('<strong>' + getFormattedInteger(sumANGSNASET) + '</strong>');
                $(summaryRow).find("td").eq(4).html('<strong>' + getFormattedInteger(sumNABBEN) + '</strong>');
                $(summaryRow).find("td").eq(5).html('<strong>' + getFormattedInteger(sumSLUSAN) + '</strong>');
                $(summaryRow).find("td").eq(6).html('<strong>' + getFormattedInteger(sumREVLARNA) + '</strong>');
                $(summaryRow).find("td").eq(7).html('<strong>' + getFormattedInteger(sumKNOSEN) + '</strong>');
                $(summaryRow).find("td").eq(8).html('<strong>' + getFormattedInteger(sumTOT) + '</strong>');
                $(summaryRow).find("td").eq(8).attr('id', "gross-summary");
                summaryRow.appendTo(theTable);
                summaryRow.removeClass('mg-hide-element');
                theTable.removeClass('mg-hide-element');

                // hide spinner
                $("#loaderdiv-" + sessionStorage.getItem('rrYear') + '-' + sessionStorage.getItem('rrVecka')).addClass('mg-hide-element');
                // show the new table again.
                $("#vecko-detalj-tabell-" + sessionStorage.getItem('rrYear') + '-' + sessionStorage.getItem('rrVecka')).removeClass('mg-hide-element');

            }


        });
    }

    function handleTaxaData(){


        // hide the table until populated..
        let veckoid = "#vecko-detalj-tabell-" + sessionStorage.getItem('rrYear') + '-' + sessionStorage.getItem('rrVecka');
        console.log('Vecko-id: ' + veckoid);
        $(veckoid).addClass('mg-hide-element');

        // turn the spinner ON
        let spinnerid = "#loaderdiv-" + sessionStorage.getItem("rrYear") + "-" + sessionStorage.getItem("rrVecka");
        $(spinnerid).removeClass('mg-hide-element');

        // we need the following for writing - first part below common for all taxa
        // $mo, $ml, $taxa, $antal, $observator, $datum

        let data = {
            records: [],
            mo: "mo",
            ml: "ml",
            observator: "obs",
            datum: "xxx",
            updater: 'xx'
        };

        data.mo = sessionStorage.getItem("mainTableId");
        data.ml = sessionStorage.getItem('lokalId');
        data.observator = $('#select-box-observator').val();
        data.datum = $('#input-date').val();
        data.updater = $('#loggedInUserId').text();

        // build data set to post
        let taxaSections = $('#item-list-item [id^="item-"]');
        taxaSections.each(function() {

            // specific for each taxa: (record id - if entered earlier), taxa id and of course antal.
            // item-xx
            let taxaId = $(this).attr('id').substr(5);
            let antal = $('#id-input-item-' + taxaId).val();
            let recId = $('#record-id-' + taxaId).text();

            // if we have data, or an old record now with nothing or zero.
            if ((antal.length > 0) || (recId !== '0' )) {

                const aRecord = new Object();
                aRecord.recid = recId;
                aRecord.taxa = taxaId;
                aRecord.recantal = antal;
                data.records.push(aRecord);

            }

        });

        $.ajax({
            type: "POST",
            url: "handleRastRakningObservation.php",
            data: data,
            //success: function(data, textStatus, jqXHR)
            success: function()
            {
                // re-create the table, now updated
                createRastRakningTable();

                // update the row with fresh data
                let selectedRow = $('.table-active');
                let no = $('[id^="art-"]').length;

                let antal_faglar = $('#gross-summary').text();

                selectedRow.find("td").eq(2).text(no);
                selectedRow.find("td").eq(3).text(antal_faglar);

            },
            error: function ()
            {

            }
        });


        $('#modal-edit-sub-items').modal('hide');

    }

    function setLangTexts(){


        // E N G E L S K A
        if (bodmin.lang.current === '1'){
            bodmin.lang.langAsString = 'en';
            bodmin.lang.totalt = "Total";

            bodmin.lang.yearwarning = "A year must given.";
            bodmin.lang.yearwarninglater = "A year later than 1900 must be given";
            bodmin.lang.yearwarningnumber = "Enter a correct year later than 1900.";
            bodmin.lang.weekwarning = "A week must be given.";
            bodmin.lang.weekformat = "Kindly enter week 1-9 as 01-09.";
            bodmin.lang.weekformatmax = "Max week is 52.";
            bodmin.lang.yearweekwarning = "This year and week already exist.";

            bodmin.lang.nopermission = "You do not have sufficient permissions to edit data.";
            bodmin.lang.selectweek = "Select a week to activate the buttons";
            bodmin.lang.changedataheader = "Edit data concerning year/week, id: ";
            bodmin.lang.cancel = "Cancel";
            bodmin.lang.save = "Save";
            bodmin.lang.newweek = "New staging monitoring week";
            bodmin.lang.deleteweek = "Remove staging monitoring week?";
            bodmin.lang.deletebutton = "Remove";
            bodmin.lang.ja = "Yes";
            bodmin.lang.nej = "No";

            bodmin.lang.deleteno = "As the week is published, it cannot be removed.";
            bodmin.lang.btnEditSpeciesDataTitle = "Published weeks cannot be changed. Unpublish it first, then you are free to edit it.";
            bodmin.lang.btnEditSpeciesData = "Select a locality for editing its data";
            bodmin.lang.infoselectedweek = "Selected week: ";

            bodmin.lang.statictexts = {
                title: 'Staging monitoring',
                // header info
                loggedinText : 'Logged in as ',
                notLoggedinText : 'You are not logged in',
                logOutHere : "Log out here",
                pageTitle : "Staging monitoring",

                // vänstersidan
                hdrMain : 'News',
                infoLabel : 'Select a week to activate the buttons',

                btnNew : 'New week',
                btnChange : 'Edit',
                btnDelete : 'Remove',
                ddNoValue : " -- Select a location -- ",
                btnEditSubItems : 'Manage data',

                // main table
                // filter place holders
                tableSearchBox1 : 'Filter years here',
                tableSearchBox2 : 'Filter weeks here',

                tblYear : "Year",
                tblWeek : "Week",
                tblAntAarter : "Number of species",
                tblAntRast : "Number of birds",
                tblPubl : "Published",

                // ------------------- Detalj bild default
                editTitle : "Update week",
                lblAr : "Year",
                lblVecka : "Week",
                lblPublished : "Published",

                // ------------------- Art data modalen
                hdrIntro : "Manage data for ",
                btnAddTaxa : "Ammend the species to the list above",
                btnTaxaDataCancel : "Cancel",
                btnTaxaDataSave : "Save",
                lblDate : "Date",
                lblObserver : "Observer",
                hdrArt : "Species",
                hdrAntal : "Number of birds",
                hdrAverage : "Long term average",
                ddTaxaNoValue : " -- Select a species -- ",

                avbryt : " Cancel",
                spara : "Save",
                detaljTblHdr :  "This week's count",
                art : "Species",
                black :  "Black",
                kanalen : "Canal",
                angsnaset : "Ängsnäset",
                nabben : "The point",
                slusan : "Harbour road",
                revlarna : "Revlarna",
                knosen : "Knosen",
                summa : "Sum",

                //
                hanteraData : "Manage data",
                average : "Average all years",
                datum : "Date",
                observer : "Observer",
                valjArt : "Select a species here",
                addSpeciesBtn : "Append selected species to the list above",

                // user interaction
                skapad : "created",
                borttagen : " deleted",
                uppdaterad : " updated",
                dataOk : "Now you can start enter data!",
                webOk : "If you now have published the week, it will shown on the Web site."

            }


        }

        // S V E N S K A
        if (bodmin.lang.current === '2'){
            bodmin.lang.langAsString = 'se';
            bodmin.lang.totalt = "Totalt";
            bodmin.lang.yearwarning = "År måste anges.";
            bodmin.lang.yearwarninglater = "År senare än 1900 måste anges.";
            bodmin.lang.yearwarningnumber = "Vänligen ange ett korrekt år, senare än 1900.";
            bodmin.lang.weekwarning = "Vecka måste anges.";
            bodmin.lang.weekformat = "Vänligen ange vecka 1-9 som 01-09.";
            bodmin.lang.weekformatmax = "Veckor kan inte vara större än 52.";
            bodmin.lang.yearweekwarning = "Detta år och denna vecka finns redan.";
            bodmin.lang.nopermission = "Du har inte behörighet att ändra data här.";
            bodmin.lang.selectweek = "Välj en vecka för att aktivera knapparna";
            bodmin.lang.changedataheader = "Ändra data om rasträkningsvecka, id:";
            bodmin.lang.cancel = "Avbryt";
            bodmin.lang.save = "Spara";
            bodmin.lang.newweek = "Ny rasträkningsvecka";
            bodmin.lang.deleteweek = "Ta bort rasträkningsvecka?";
            bodmin.lang.deletebutton = "Tag bort";
            bodmin.lang.ja = "Ja";
            bodmin.lang.nej = "Nej";

            bodmin.lang.deleteno = "Veckan kan ej tas bort då den är publicerad.";
            bodmin.lang.btnEditSpeciesDataTitle = "Publicerade veckors data kan ej ändras. Ändra status först, sedan kan du ändra data.";
            bodmin.lang.btnEditSpeciesData = "'Välj lokal för att ändra data.'";
            bodmin.lang.infoselectedweek = "Vald vecka: ";

            bodmin.lang.statictexts = {
                title : 'Rasträkning',
                // header info
                loggedinText : 'Inloggad som ',
                notLoggedinText : 'Du är ej inloggad',
                logOutHere : 'Logga ut här',
                pageTitle : "Rasträkning",

                // vänster sidan
                hdrMain : 'Rasträkning',
                infoLabel : 'Välj vecka för att aktivera knapparna',
                btnNew : 'Ny vecka',
                btnChange : 'Ändra',
                btnDelete : 'Tag bort',
                ddNoValue : " -- Välj en lokal -- ",
                btnEditSubItems : 'Hantera',

                // Main table
                // filter place holders
                tableSearchBox1 : 'Sök år',
                tableSearchBox2 : 'Sök vecka',
                header : "Staging monitoring",
                // main table headers
                tblYear : "År",
                tblWeek : "Vecka",
                tblAntAarter : "Antal arter",
                tblAntRast : "Antal fåglar",
                tblPubl : "Publicerad",

                // ------------------- Detalj bild default
                editTitle : "Ändra vecka",
                lblAr : "År",
                lblVecka : "Vecka",
                lblPublished : "Publicerad",

                // ------------------- Art data modalen
                hdrIntro : "Hantera data för ",
                btnAddTaxa : "Lägg tillarten i listan ovan",
                btnTaxaDataCancel : "Avbryt",
                btnTaxaDataSave : "Spara",
                lblDate : "Datum",
                lblObserver : "Observatör",
                hdrArt : "Art",
                hdrAntal : "Antal",
                hdrAverage : "Medeltal denna vecka",
                ddTaxaNoValue : " -- Välj en art -- ",

                avbryt : "Avbryt",
                spara : "Spara",
                detaljTblHdr :  "Denna veckas räkning",
                art : "Art",
                black :  "Black",
                kanalen : "Kanalen",
                angsnaset : "Ängsnäset",
                nabben : "Nabben",
                slusan : "Slusan",
                revlarna : "Revlarna",
                knosen : "Knösen",
                summa : "Summa",
                hanteraData : "Hantera data",
                average : "Medeltal alla år",
                datum : "Datum",
                observer : "Observatör",
                valjArt : "Välj art här",
                addSpeciesBtn : "Lägg till vald art i listan ovan",
                // user feedback
                skapad : "Skapad",
                borttagen : " borttagen",
                uppdaterad : " uppdaterad",
                dataOk : "Nu kan du börja med att lägga till data!",
                webOk : "Om du har publicerat vecka kommer den att visas på websajten."

            }

        }

        // get options for "lokal" drop down
        $.ajax({
            type: "get",
            url: "getLokaler.php?langId=" + bodmin.lang.current,
            success: function (data) {

                let comingOptions = JSON.parse(data);

                let dropDown = $('#select-locality-drop-down');
                let thisOption = '<option value="0">' + bodmin.lang.statictexts.ddNoValue  + '</option>';
                dropDown.append(thisOption);

                for (let i=0; i<comingOptions.length; i++){
                    thisOption = '<option value="' + comingOptions[i].ID + '">' +  comingOptions[i].TEXT + '</option>';
                    dropDown.append(thisOption);
                }

            }
        });


        $(document).attr('title', bodmin.lang.statictexts.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.statictexts.loggedinText);
        $('#hdrMain').text(bodmin.lang.statictexts.hdrMain);
        $('#selectInfo').text(bodmin.lang.statictexts.selectInfo);
        $('#infoLabel').text(bodmin.lang.statictexts.infoLabel);

        let loggedInInfo = bodmin.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.statictexts.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        // Buttons on the left hand side
        $('#btnEditSubItems').text(bodmin.lang.statictexts.btnEditSubItems);
        $('#btnEdit').text(bodmin.lang.statictexts.btnChange);
        $('#btnNew').text(bodmin.lang.statictexts.btnNew);
        $('#btnDelete').text(bodmin.lang.statictexts.btnDelete);

        $('#tableSearchBox1').attr('placeholder', bodmin.lang.statictexts.tableSearchBox1);
        $('#tableSearchBox2').attr('placeholder', bodmin.lang.statictexts.tableSearchBox2);

        // main select table
        $('#tblYear').text(bodmin.lang.statictexts.tblYear);
        $('#tblWeek').text(bodmin.lang.statictexts.tblWeek);
        $('#tblAntAarter').text(bodmin.lang.statictexts.tblAntAarter);
        $('#tblAntRast').text(bodmin.lang.statictexts.tblAntRast);
        $('#tblPubl').text(bodmin.lang.statictexts.tblPubl);
        $('td.published').text(bodmin.lang.ja);
        $('td.notPublished').text(bodmin.lang.nej);

        // detail tables
        $('[name="art"]').text(bodmin.lang.statictexts.art);
        $('[name="kanalen"]').text(bodmin.lang.statictexts.kanalen);
        $('[name="black"]').text(bodmin.lang.statictexts.black);
        $('[name="angsnaset"]').text(bodmin.lang.statictexts.angsnaset);
        $('[name="nabben"]').text(bodmin.lang.statictexts.nabben);
        $('[name="slusan"]').text(bodmin.lang.statictexts.slusan);
        $('[name="revlarna"]').text(bodmin.lang.statictexts.revlarna);
        $('[name="knosen"]').text(bodmin.lang.statictexts.knosen);
        $('[name="summa"]').text(bodmin.lang.statictexts.summa);

        // modal - main table
        $('#editTitle').text(bodmin.lang.statictexts.editTitle);
        $('#lblAr').text(bodmin.lang.statictexts.lblAr);
        $('#lblVecka').text(bodmin.lang.statictexts.lblVecka);
        $('#lblPublished').text(bodmin.lang.statictexts.lblPublished);
        $('#btnSaveMainModal').text(bodmin.lang.statictexts.spara);
        $('#btnCancelMainModal').text(bodmin.lang.statictexts.avbryt);

        // modal, manage data for a week and location
        $('#hdrIntro').text(bodmin.lang.statictexts.hanteraData);
        $('#modalDataTitle').text(bodmin.lang.statictexts.hanteraData);
        $('#btnAddTaxa').text(bodmin.lang.statictexts.btnAddTaxa);
        $('#btnTaxaDataCancel').text(bodmin.lang.statictexts.avbryt);
        $('#btnTaxaDataSave').text(bodmin.lang.statictexts.spara);
        $('#lblDate').text(bodmin.lang.statictexts.lblDate);
        $('#lblObserver').text(bodmin.lang.statictexts.lblObserver);
        $('#hdrArt').text(bodmin.lang.statictexts.hdrArt);
        $('#hdrAntal').text(bodmin.lang.statictexts.hdrAntal);
        $('#hdrAverage').text(bodmin.lang.statictexts.hdrAverage);


    }

});
