$(document).ready( function () {

    let h = {

        titleText: $('#titleText'),
        bannerHeader: $('#bannerHeader'),
        bannerIntroText: $('#bannerIntroText'),

        lang: {
            current: $('#lang').text(),
        },

    }

    function getHeaderTexts() {


        // E N G E L S K A
        if (h.lang.current === '1') {

            h.lang.titleText = 'Falsterbo Bird Observatory - Species list'
            h.lang.bannerHeader = 'Species list - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Listan omfattar arter som anträffats väster om Falsterbokanalen. Totalt har 362 arter noterats från slutet av 1800-talet t.o.m. 2018. Urvalet är gjort enligt AERCs (Association of European Rarities Committees) riktlinjer för spontan förekomst (AERC-kategori A-C). För varje art anges förekomsten per månad enligt en 5-gradig skala samt häckningsstatus. Arter som tillhör AERC-kategorierna D eller E kommer att presenteras med tiden.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Artlista'
            h.lang.bannerHeader = 'Artlista - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'Listan omfattar arter som anträffats väster om Falsterbokanalen. Totalt har 362 arter noterats från slutet av 1800-talet t.o.m. 2018. Urvalet är gjort enligt AERCs (Association of European Rarities Committees) riktlinjer för spontan förekomst (AERC-kategori A-C). För varje art anges förekomsten per månad enligt en 5-gradig skala samt häckningsstatus. Arter som tillhör AERC-kategorierna D eller E kommer att presenteras med tiden.';

        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.text(h.lang.bannerHeader);
        h.bannerIntroText.text(h.lang.bannerIntroText);

    }

    let v = {
        taxon : {
          dummy : 'something',
        },
        dataArea: $('#dataArea'),
        dataTabs: $("#dataTabs"),
        language: {
            metaLang: $("#metaLang"),
            current: ''  // here only for clarity, set below.
        },
        overview: {
            noOfFynd: $('#no-of-fynd'),
            noOfBirds: $('#no-of-birds'),
        },


        ui : {
            noOfBirdsText : $('#noOfBirdsText'),
            noOfFyndText  : $('#noOfFyndText'),
            buttonBack    : $('#buttonBack'),
            taxaTable : {
                tablePlaceHolder     : $('#tablePlaceHolder'),
                theTable             : $('#taxaTable'),
                taxaListHead         : $('#taxaListHead'),
                taxaListBody         : $('#taxaListBody'),

            },
            displaySettings : {
                scientificName : "yes",
                commonName : "yes",
                rare : true,
                breeders : true,
                rareBreeders : true,
                prevBreeders : true,
                ovrigaIckeHackare : true,
            },
            nameCheckBoxes : {
                scientificName : $('#sciName'),
                commonName : $('#commonName'),
            },
            taxaCheckBoxes : {
                rare : $('#rare'),
                rareBreeders : $('#rareHackare'),
                breeders : $('#hackare'),
                previousBreeders : $('#tidigareHackare'),
                others : $('#ovrigaIckeHackande'),
            },
            controlPanelTexts : {
                headerShowWhat : $('#headerShowWhat'),
                artgrupper : $('#artgrupper'),
                labelRare : $('#labelRare'),
                labelRareHackare : $('#labelRareHackare'),
                labelHackare : $('#labelHackare'),
                labelTidigareHackare : $('#labelTidigareHackare'),
                labelOvrigaIckeHackande : $('#labelOvrigaIckeHackande'),
                namn : $('#namn'),
                labelSciName : $('#labelSciName'),
                labelCommonName : $('#labelCommonName'),
            },

            detailModal : {
                theWindow    : $('#taxonModal'),
                taxonDetailHeader : $('#taxonDetailHeader'),
                tableBody : $('#taxonObservationsTableBody'),
                tableHeaderFynd : $('#tableHeaderFynd'),
                tableHeaderDate : $('#tableHeaderDate'),
                tableHeaderNoAgeSex : $('#tableHeaderNoAgeSex'),
                tableHeaderPlaceCircumstancesAndReferences :  $('#tableHeaderPlaceCircumstancesAndReferences'),
            }

        }
    }

    function setLangTexts(){

        let nbsp = String.fromCharCode(160);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.localeString = 'en_GB';
            v.language.thousandSeparator = '.';

            v.ui.lang = {
                // multi-select drop downs
                noOfBirdsText   : "birds",
                noOfFyndText    : "occasions",
                buttonBack      : "Back to taxa list",
            };

            v.ui.lang.legendOccurence = [
                {"code": "5", "text" : "Common and seen daily in the right habitat."},
                {"code": "4", "text" : "Rather common and there is a good chance seeing it."},
                {"code": "3", "text" : "Regular but scarce."},
                {"code": "2", "text" : "Rare but annual or almost annual."},
                {"code": "1", "text" : "Less than 10 observations in all during this month."},
                {"code": "H", "text" : "Regular breeder (annual)."},
                {"code": "h", "text" : "Occasional breeder (after 1980)."},
                {"code": "(h)", "text" : "Earlier breeder, prior to 1980."},
            ]

            v.ui.lang.taxaTable = {
                textsFile : "https://cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json",
                jan : 'Jan',
                feb : 'Feb',
                mar : 'Mar',
                apr : 'Apr',
                may : 'May',
                jun : 'Jun',
                jul : 'Jul',
                aug : 'Aug',
                sep : 'Sep',
                oct : 'Oct',
                nov : 'Nov',
                dec : 'Dec',
                tableHeaderTaxon : 'Species',
                tableHeaderMonths : 'Monthly presence',
                tableHeaderBreeding : 'Breeding',
            };

            v.ui.controlPanelTexts.lang = {
                headerShowWhat : 'Show what',
                artgrupper : 'Species groups',
                labelRare : 'Rare',
                labelHackare : 'Breeders',
                labelRareHackare : 'Occasional' + nbsp + 'breeders',
                labelTidigareHackare : 'Previous' + nbsp + 'breeders',
                labelOvrigaIckeHackande : 'Other' + nbsp + 'non' + nbsp + 'breeders',
                namn : 'Name',
                labelSciName : 'Scientific',
                labelCommonName : 'English',
            };

            v.ui.detailModal.lang = {
                tableHeaderFynd : 'Record No#',
                tableHeaderDate : 'Date(s)',
                tableHeaderNoAgeSex : 'No. of, age & sex',
                tableHeaderPlaceCircumstancesAndReferences :  'Place, circumstances and reference(s)',
                tableNoSex : 'Sex not reported',
                tableNoAge : 'Age not reported',
                tableNoActivity : 'Circumstances not recorded',
                tableNoAgeNoSex : 'Age and sex not reported',
                tableFromDate : 'From ',
                tableToDate : 'to ',
            }


        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.langAsString = 'se';
            v.language.localeString = 'sv_SE';
            v.language.thousandSeparator = ' ';

            v.ui.lang = {
                // multi-select drop downs
                noOfBirdsText   : "fåglar",
                noOfFyndText    : "fynd",
                buttonBack      : "Tillbaka till taxa",
            };

            v.ui.lang.legendOccurence = [
                {"code": "5", "text" : "Arten förekommer rikligt och ses ofta."},
                {"code": "4", "text" : "Arten förekommer tämligen rikligt och chansen är stor att påträffa den."},
                {"code": "3", "text" : "Arten förekommer regelbundet men sparsamt."},
                {"code": "2", "text" : "Arten förekommer sällsynt men årligen eller nästan årligen."},
                {"code": "1", "text" : "Färre än 10 fynd i aktuell månad."},
                {"code": "H", "text" : "Arten häckar regelbundet (årligen)."},
                {"code": "h", "text" : "Arten har häckat efter 1980, dock ej årligen."},
                {"code": "(h)", "text" : "Arten har häckat, dock inte efter 1980."},
            ]

            v.ui.lang.taxaTable = {
                textsFile : "https://cdn.datatables.net/plug-ins/1.11.3/i18n/sv_se.json",
                jan : 'Jan',
                feb : 'Feb',
                mar : 'Mar',
                apr : 'Apr',
                may : 'Maj',
                jun : 'Jun',
                jul : 'Jul',
                aug : 'Aug',
                sep : 'Sep',
                oct : 'Okt',
                nov : 'Nov',
                dec : 'Dec',
                tableHeaderTaxon : 'Art',
                tableHeaderMonths : 'Månadsvis förekomst',
                tableHeaderBreeding : 'Häckning',
            };

            v.ui.controlPanelTexts.lang = {
                headerShowWhat : 'Visa vad',
                artgrupper : 'Artgrupper',
                labelRare : 'Sällsynta',
                labelHackare : 'Häckare',
                labelRareHackare : 'Tillfälliga' + nbsp + 'häckare',
                labelTidigareHackare : 'Tidigare' + nbsp +  'häckare',
                labelOvrigaIckeHackande : 'Övriga' + nbsp + 'icke' + nbsp + 'häckande',
                namn : 'Namn',
                labelSciName : 'Vetenskapliga',
                labelCommonName : 'Svenska',
            };

            v.ui.detailModal.lang = {
                tableHeaderFynd : 'Fynd',
                tableHeaderDate : 'Datum',
                tableHeaderNoAgeSex : 'Antal, ålder, och kön',
                tableHeaderPlaceCircumstancesAndReferences :  'Lokal, omständigheter, och referenser',
                tableNoSex : 'kön ej rapporterat',
                tableNoAge : 'ålder ej rapporterad',
                tableNoAgeNoSex : 'ålder och kön ej rapporterade',
                tableNoActivity : 'omständigheter ej rapporterade',
                tableFromDate : 'Från och med',
                tableToDate : 'till',
            }
        }


        v.ui.noOfFyndText.text(v.ui.lang.noOfFyndText);
        v.ui.noOfBirdsText.text(v.ui.lang.noOfBirdsText);
        v.ui.buttonBack.text(v.ui.lang.buttonBack);

        // control panel texts
        v.ui.controlPanelTexts.headerShowWhat.text(v.ui.controlPanelTexts.lang.headerShowWhat);
        v.ui.controlPanelTexts.artgrupper.text(v.ui.controlPanelTexts.lang.artgrupper);
        v.ui.controlPanelTexts.labelRare.text(v.ui.controlPanelTexts.lang.labelRare);
        v.ui.controlPanelTexts.labelHackare.text(v.ui.controlPanelTexts.lang.labelHackare);
        v.ui.controlPanelTexts.labelRareHackare.text(v.ui.controlPanelTexts.lang.labelRareHackare);
        v.ui.controlPanelTexts.labelTidigareHackare.text(v.ui.controlPanelTexts.lang.labelTidigareHackare);
        v.ui.controlPanelTexts.labelOvrigaIckeHackande.text(v.ui.controlPanelTexts.lang.labelOvrigaIckeHackande);
        v.ui.controlPanelTexts.namn.text(v.ui.controlPanelTexts.lang.namn);
        v.ui.controlPanelTexts.labelSciName.text(v.ui.controlPanelTexts.lang.labelSciName);
        v.ui.controlPanelTexts.labelCommonName.text(v.ui.controlPanelTexts.lang.labelCommonName);

        v.ui.detailModal.tableHeaderFynd.text(v.ui.detailModal.lang.tableHeaderFynd);
        v.ui.detailModal.tableHeaderFynd.text(v.ui.detailModal.lang.tableHeaderFynd);
        v.ui.detailModal.tableHeaderDate.text(v.ui.detailModal.lang.tableHeaderDate);
        v.ui.detailModal.tableHeaderNoAgeSex.text(v.ui.detailModal.lang.tableHeaderNoAgeSex);
        v.ui.detailModal.tableHeaderPlaceCircumstancesAndReferences.text(v.ui.detailModal.lang.tableHeaderPlaceCircumstancesAndReferences);

    }

    function loadTable(){

        v.taxon.dataloaded = false;

        $.ajax({
            type: "get",
            url: "getTheTaxaList.php?language=" + v.language.current,
            success: function (data) {

                v.taxaData = JSON.parse(data);

                v.taxon.dataloaded = true;
                refreshTable(v.taxaData);
                checkAndShowIfWantedPopUp();
            }

        });

    }

    function initializeTableHeader(){

        let s =    '             <tr>\n' +
        '                            <th class="mg-hide-element"></th>\n' +
        '                            <th rowspan="2" id="tableHeaderTaxon"></th>\n' +
        '                            <th colspan="12" class="text-center" id="tableHeaderMonths"></th>\n' +
        '                            <th rowspan="2" class="text-center" id="tableHeaderBreeding"></th>\n' +
        '                        </tr>\n' +
        '                        <tr>\n' +
        '                            <th class="mg-hide-element">Snr</th>\n' +
        '                            <th class="text-center" id="jan"></th>\n' +
        '                            <th class="text-center" id="feb"></th>\n' +
        '                            <th class="text-center" id="mar"></th>\n' +
        '                            <th class="text-center" id="apr"></th>\n' +
        '                            <th class="text-center" id="may"></th>\n' +
        '                            <th class="text-center" id="jun"></th>\n' +
        '                            <th class="text-center" id="jul"></th>\n' +
        '                            <th class="text-center" id="aug"></th>\n' +
        '                            <th class="text-center" id="sep"></th>\n' +
        '                            <th class="text-center" id="oct"></th>\n' +
        '                            <th class="text-center" id="nov"></th>\n' +
        '                            <th class="text-center" id="dec"></th>\n' +
        '                        </tr>\n';

        v.ui.taxaTable.taxaListHead.append(s);

        $('#jan').text(v.ui.lang.taxaTable.jan);
        $('#feb').text(v.ui.lang.taxaTable.feb);
        $('#mar').text(v.ui.lang.taxaTable.mar);
        $('#apr').text(v.ui.lang.taxaTable.apr);
        $('#may').text(v.ui.lang.taxaTable.may);
        $('#jun').text(v.ui.lang.taxaTable.jun);
        $('#jul').text(v.ui.lang.taxaTable.jul);
        $('#aug').text(v.ui.lang.taxaTable.aug);
        $('#sep').text(v.ui.lang.taxaTable.sep);
        $('#oct').text(v.ui.lang.taxaTable.oct);
        $('#nov').text(v.ui.lang.taxaTable.nov);
        $('#dec').text(v.ui.lang.taxaTable.dec);
        $('#tableHeaderTaxon').text(v.ui.lang.taxaTable.tableHeaderTaxon);
        $('#tableHeaderMonths').text(v.ui.lang.taxaTable.tableHeaderMonths);
        $('#tableHeaderBreeding').text(v.ui.lang.taxaTable.tableHeaderBreeding);


    }

    function refreshTable(taxaData){

        // clear first DataTable object
        if (v.ui.taxaTable.dataTable != null){
            v.ui.taxaTable.dataTable.clear();
            v.ui.taxaTable.dataTable.destroy();
        }

        //2nd empty html
        let tableId = "#taxaTable";
        $(tableId + " tbody").empty();
        $(tableId + " thead").empty();

        let s = "";
        for (let i = 0; i < taxaData.length; i++){
            s = s + "<tr>";
            s = s + "<td class='mg-hide-element'>" + taxaData[i].SNR + "</td>";
            s = s + "<td>" + resolveTaxonNaming(taxaData[i]) + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].JAN ) + ">" + taxaData[i].JAN + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].FEB ) + ">" + taxaData[i].FEB + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].MAR ) + ">" + taxaData[i].MAR + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].APR ) + ">" + taxaData[i].APR + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].MAJ ) + ">" + taxaData[i].MAJ + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].JUN ) + ">" + taxaData[i].JUN + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].JUL ) + ">" + taxaData[i].JUL + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].AUG ) + ">" + taxaData[i].AUG + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].SEP ) + ">" + taxaData[i].SEP + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].OKT ) + ">" + taxaData[i].OKT + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].NOV ) + ">" + taxaData[i].NOV + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].DCE ) + ">" + taxaData[i].DCE + "</td>";
            s = s + "<td class='text-center'" + resolveTitle( taxaData[i].HAC ) + ">" + taxaData[i].HAC + "</td>";
            s = s + "</tr>";
        }

        initializeTableHeader();

        v.ui.taxaTable.taxaListBody.append(s);

        v.ui.taxaTable.dataTable = $('#taxaTable').DataTable({
            "order": [[ 0, "asc" ]],
            "pageLength": 25,
            "language" : {
                "url" : v.ui.lang.taxaTable.textsFile,
            },

        });



    }

    function resolveTitle(code){

        let s = '';
        if (code !== '-'){

            for (let i = 0; i < v.ui.lang.legendOccurence.length; i++){

                if( v.ui.lang.legendOccurence[i].code === code){
                    s = ' title="' + v.ui.lang.legendOccurence[i].text + '"';
                    break;
                }

            }

        }

        return s;

    }

    v.ui.taxaCheckBoxes.rare.change(function(){
        v.ui.displaySettings.rare = $(this).prop("checked");
        filterData();
    });

    v.ui.taxaCheckBoxes.breeders.change(function(){
        v.ui.displaySettings.breeders = $(this).prop("checked");
        filterData();
    });

    v.ui.taxaCheckBoxes.rareBreeders.change(function(){
        v.ui.displaySettings.rareBreeders = $(this).prop("checked");
        filterData();
    });

    v.ui.taxaCheckBoxes.previousBreeders.change(function(){
        v.ui.displaySettings.prevBreeders = $(this).prop("checked");
        filterData();

    });

    v.ui.taxaCheckBoxes.others.change(function(){
        v.ui.displaySettings.ovrigaIckeHackare = $(this).prop("checked");
        filterData();

    });

    v.ui.nameCheckBoxes.scientificName.change(function(){
        v.ui.displaySettings.scientificName = 'no';
        if (this.checked){
            v.ui.displaySettings.scientificName = 'yes';
        }

        refreshTable(v.taxaData);


    });

    v.ui.nameCheckBoxes.commonName.change(function(){
        v.ui.displaySettings.commonName = 'no';
        if (this.checked) {
            v.ui.displaySettings.commonName = 'yes';
        }

        refreshTable(v.taxaData);

    });

    function filterData(){

        if (v.taxon.dataloaded ) {

            let rareFiltered = v.taxaData;
            if (!v.ui.displaySettings.rare) {
                console.log('Now filtering for rare ' );
                rareFiltered = v.taxaData.filter(filterRare);
            }

            let hackareFiltered = rareFiltered;
            if (!v.ui.displaySettings.breeders) {
                console.log('Now filtering for breeders ' );
                hackareFiltered = rareFiltered.filter(filterHackare);
            }

            let rarePrevBreeders = hackareFiltered;
            if (!v.ui.displaySettings.rareBreeders) {
                console.log('Now filtering for occ. breeders ' );
                rarePrevBreeders = hackareFiltered.filter(filterRareHackare);
            }

            let tidigareHackareFiltered = rarePrevBreeders;
            if (!v.ui.displaySettings.prevBreeders) {
                console.log('Now filtering for tidigare häckare ' );
                tidigareHackareFiltered = rarePrevBreeders.filter(filterTidigareHackare);
            }

            let ovrigaFiltered = tidigareHackareFiltered;
            if (!v.ui.displaySettings.ovrigaIckeHackare) {
                console.log('Now filtering for tidigare häckare ' );
                ovrigaFiltered = tidigareHackareFiltered.filter(filterOvrigaIckeHackare);
            }

            refreshTable(ovrigaFiltered);

        }

    }

    function filterRare(element){
        return element.FYN === 'nej';
    }

    function filterHackare(element){
        return element.HAC !== 'H';
    }

    function filterRareHackare(element){
        return element.HAC !== 'h';
    }

    function filterTidigareHackare(element){
        return element.HAC !== '(h)';
    }

    function filterOvrigaIckeHackare(element){
        let answer = true;
        if (element.FYN === 'nej'){
            answer = (element.HAC !== '-');
        }
        return answer;
    }


    function resolveTaxonNaming(aRecord){

        let s = '';
        let sciName = "";
        if (aRecord.SCINAME !== null) {
            sciName = aRecord.SCINAME;
        }

        if ((v.ui.displaySettings.scientificName === 'yes') && (v.ui.displaySettings.commonName === 'yes')){

            s = aRecord.NAME + '</br>' + sciName;
        } else {

            if (v.ui.displaySettings.commonName === 'yes') {
                s = aRecord.NAME;
            }

            if (v.ui.displaySettings.scientificName === 'yes') {
                s = sciName;
            }

        }

        let link = s;


        if (aRecord['FYN'] === 'ja'){
            link = '<a href="#' + aRecord.TAXA_ID + '" class="fynd">' + s + '</a>';
        }

        return link;

    }

    function getTaxaFromTaxaList(s){

        let answer = "";
        for (let i=0; i < v.taxaData.length; i++){

            if (v.taxaData[i].TAXA_ID === s){
                answer = v.taxaData[i];
                break;
            }

        }

        return answer;
    }

    function checkAndShowIfWantedPopUp(){
        // check if we have book-marked this page with an active popUp open: #99 (taxa code proper)
        let x = location.hash;
        x = decodeURI( x );
        if (x.length === 6){
            popUpDetails(x.substr(1));
        }
    }


    function popUpDetails(s) {

        v.ui.detailModal.tableBody.empty();
        v.ui.detailModal.tableBody.append(mgGetDivWithSpinnerImg());
        v.ui.detailModal.theWindow.modal('show');
        $.ajax({
            type: "get",
            url: "getTaxonRecords.php?taxon=" + s + '&language=' + v.language.current,
            success: function (data) {

                v.observationsData = JSON.parse(data);

                let aTaxaBaseInfo = getTaxaFromTaxaList(s);
                v.ui.detailModal.taxonDetailHeader.text(aTaxaBaseInfo.NAME);

                $.ajax({
                    type: "get",
                    url: "getTaxonRecordsReferences.php?taxon=" + s + '&language=' + v.language.current,
                    success: function (data) {

                        v.ui.detailModal.tableBody.empty();
                        v.observationsReferencesData = JSON.parse(data);

                        let rows = '';
                        for ( let i=0; i < v.observationsData.length; i++ ){

                            rows = rows + '<tr>';
                            rows = rows + '<td>' + v.observationsData[i].FYND + '</td>';
                            rows = rows + '<td>' + resolveDate(v.observationsData[i]) + '</td>';
                            rows = rows + '<td>' + resolveAntalAgeSex(v.observationsData[i]) + '</td>';
                            rows = rows + '<td>' + resolvePlaceCircumstancesAndReferences(v.observationsData[i]) + '</td>';
                            rows = rows + '</tr>';

                        }

                        v.ui.detailModal.tableBody.append(rows);
                        v.overview.noOfFynd.text(v.observationsData[0].FYND);
                        v.overview.noOfBirds.text(sumAntal(v.observationsData));

                        v.ui.detailModal.theWindow.modal('show');

                    }
                });

            }
        });

    }


    function resolveAntalAgeSex(aRecord){

        let answer = aRecord.ANTAL;

        if ((aRecord.AGE_N === '17') && (aRecord.SEX_N === '7')){
            answer = answer + ', ' + v.ui.detailModal.lang.tableNoAgeNoSex;
        } else {

            let age = v.ui.detailModal.lang.tableNoAge;
            if (aRecord.AGE_N !== '17'){
                age = aRecord.AGE_TEXT;
            }
            answer = answer + ', ' + age;

            let sex = v.ui.detailModal.lang.tableNoSex;
            if (aRecord.SEX_N !== '7'){
                sex = aRecord.SEX_TEXT;
            }
            answer = answer + ', ' + sex;

        }

        return answer;

    }


    function resolvePlaceCircumstancesAndReferences(aRecord){

        let answer = aRecord.LOKAL + ', ' + aRecord.ACTIVITY_TEXT;
        let txt = aRecord.SVEEXTRA;
        if (aRecord.LANGUAGE_ID === '1'){
            txt = aRecord.ENGEXTRA;
        }
        if (txt !== null){
            answer = answer + ', ' + txt;
        }
        console.log(aRecord);

        answer = answer + '</br></br><p> ' + aRecord.REF + '</br>';
        answer = answer + resolveReferences(aRecord);


        return answer;

    }


    function resolveReferences(aRecord){

        let answer = '';
        for ( let i=0; i < v.observationsReferencesData.length; i++ ){
            if (v.observationsReferencesData[i].ID === aRecord.ID){
                answer = answer + v.observationsReferencesData[i].TEXT + '<br/>';
            }

        }

        answer = answer + '</p>';

        return answer;

    }


    function resolveDate(aRecord){

        let answer = aRecord.FDATUM;
        if (aRecord.FDATUM !== aRecord.SDATUM){
            answer = aRecord.FDATUM + ' ' + v.ui.detailModal.lang.tableToDate + '<br/>' + aRecord.SDATUM;
        }

        return answer;

    }


    function sumAntal(observationsData){

        let answer = 0;
        for ( let i=0; i < observationsData.length; i++ ){
            answer = answer + parseInt(observationsData[i].ANTAL);
        }

        return answer;

    }

    /*
    table.buttons().container()
        .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
*/

    $(document).on('click', '.fynd', function(){

        let s = $(this).attr("href").substr(1, 99);
        popUpDetails(s);

    });

    getHeaderTexts();
    setHeaderTexts();

    resolveLanguage(v);
    setLangTexts();
    loadTable();


});



