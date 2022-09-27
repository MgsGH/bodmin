$(document).ready( function () {

    let h = {

        titleText: $('#titleText'),
        bannerHeader: $('#bannerHeader'),
        bannerIntroText: $('#bannerIntroText'),

        lang: {
            current: $('#lang').text(),
        },

    }


    // https://select2.org/

    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });


    let v = {

        baseTaxaList : '',

        metaData : {
          aAuthors : [],
          aKeywords : [],
          aTaxa : [],
        },

        filterData : {
            author : '0',
            taxon : '0',
            keyword : '0',
        },

        language: {
            metaLang: $("#metaLang"),
            current: ''  // here only for clarity, set below.
        },

        ui : {

            publicationsTable : {
                table : $('#publicationsTable'),
                tableHead : $('#publicationsTableHead'),
                tableBody : $('#publicationsTableBody'),
            },

            controlPanel : {
                radioBoxYearDescending : $('#radioBoxYearsDescending'),
                radioBoxYearAscending : $('#radioBoxYearsAscending'),
                ddAuthor : $('#ddAuthor'),
                ddKeyword : $('#ddKeyword'),
                ddTaxon : $('#ddTaxon'),
            },


        },

    }

    function getHeaderTexts() {


        // E N G E L S K A
        if (h.lang.current === '1') {
            h.lang.titleText = 'Falsterbo Bird Observatory - Publications'
            h.lang.bannerHeader = 'Publications - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'Most publications related to Falsterbo bird observatory are, since the start back in 1955, published in the series named (translated) “Messages from Falsterbo Bird Observatory”. Most of these are articles published in various ornithological periodicals. A few standalone books are also included, and for the first time but expected to regular in the future, an internet publication. It is possible to filter the publications by author, species and taxon. Almost all publications are downloadable as pdf-files.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.titleText = 'Falsterbo Fågelstation - Publikationer'
            h.lang.bannerHeader = 'Publikationer - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'De flesta publikationer med anknytning till fågelstationens verksamhet ingår, alltsedan starten 1955, i serien "Meddelanden från Falsterbo Fågelstation". En majoritet är uppsatser som publicerats i diverse fågeltidskrifter. Flera böcker ingår också och, för första gången 2007 men säkert återkommande, en Internetpublicering. På denna sida kan man söka bland publikationerna via art, författare och nyckelord.  För nästan alla publikationer, utom böckerna som vi säljer, finns nedladdningsbara pdf-filer.';
        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.text(h.lang.bannerHeader);
        h.bannerIntroText.text(h.lang.bannerIntroText);

    }

    function setLangTexts(){

        //let nbsp = String.fromCharCode(160);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.localeString = 'en_GB';
            v.language.thousandSeparator = '.';


            v.language.publicationsTable = {
                textsFile: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json",
            }


        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.langAsString = 'se';
            v.language.localeString = 'sv_SE';
            v.language.thousandSeparator = ' ';

            v.language.publicationsTable = {
                textsFile : "https://cdn.datatables.net/plug-ins/1.11.3/i18n/sv_se.json",
            }

        }

    }

    function getPublicationsList( ){

        $.ajax({
            type: "get",
            url: "getPublications.php",
            success: function (data) {
                v.basePublicationsList = JSON.parse(data);
                v.filterData.currentPubList = v.basePublicationsList;
                buildTaxaTable();
            }

        });

    }

    function buildTaxaTable(){

        let s = '';
        const l = v.basePublicationsList.length;
        for (let i = 0; i < l; i++){

            s = s + '            <tr>\n' +
                '                <td class="publications-pdf-cell">\n' +
                                    resolvePDF(v.basePublicationsList[i]) +
                '                </td>\n' +
                '                <td>';
            s = s + '                <p class="publication">\n' +
                '                    <strong>' + v.basePublicationsList[i].AUTHOR + '</strong>\n' +
                                     v.basePublicationsList[i].YEAR + ' ' + '\n' +
                                     ' ' +
                                     v.basePublicationsList[i].JOURNAL + ' ' + '\n' +
                '                    <br/>\n' +
                                     v.basePublicationsList[i].TITLE + ' ' + '\n' +
                '                    <br/>\n' +
                                     v.basePublicationsList[i].summary + ' ' + '\n' +
                '                    </p>\n' +
                '                </td>\n' +
                '            </tr';
        }

        v.ui.publicationsTable.tableBody.append(s);

        v.ui.publicationsTable.dataTable = v.ui.publicationsTable.table.DataTable({
            order: [],
            "pageLength": 10,
            "language" : {
                "url" : v.language.publicationsTable.textsFile,
            },

        });

    }

    v.ui.controlPanel.ddAuthor.change(function(){

        v.filterData.author = $(this).val();
        if (v.filterData.author === 'alla' ){
            v.filterData.author = '0';
        }
        filterData();
    });

    v.ui.controlPanel.ddKeyword.change(function(){
        v.filterData.keyword = $(this).val();
        if (v.filterData.keyword === 'alla' ){
            v.filterData.keyword = '0';
        }
        filterData();
    });

    v.ui.controlPanel.ddTaxon.change(function(){
        v.filterData.taxon = $(this).val();
        if (v.filterData.taxon === 'alla' ){
            v.filterData.taxon = '0';
        }
        filterData();
    });

    v.ui.controlPanel.radioBoxYearDescending.change(function(){

        v.filterData.currentPubList.sort(function(a, b){
            let keyA = a.YEAR;
            let keyB = b.YEAR;
            // Compare the 2 years -
            if(keyA > keyB) return -1;
            if(keyA < keyB) return 1;
            return 0;
        });

        refreshTable( v.filterData.currentPubList );

    });

    v.ui.controlPanel.radioBoxYearAscending.change(function(){

        v.filterData.currentPubList.sort(function(a, b){
            let keyA = a.YEAR;
            let keyB = b.YEAR;

            // Compare the 2 years -
            if(keyA < keyB) return -1;
            if(keyA > keyB) return 1;
            return 0;
        });
        refreshTable( v.filterData.currentPubList );

    });

    function filterData(){

        // Filter each metadata set to create a set of publications.
        // Use this set to filter the basePublicationsList.

        v.filterData.aFiltered = v.basePublicationsList;

        if (v.filterData.author !== '0'){
            v.filterData.aFiltered = v.metaData.aAuthors.filter(filterAuthor);
        }

        if (v.filterData.keyword !== '0'){
            let tmp = v.metaData.aKeywords.filter(filterKeyword);
            // tmp now has a few recs, these should also be in authorsFiltered.
            // We have filter given the first filtering above. The keyword filtered must also be among the
            // authors.
            v.filterData.aFiltered = tmp.filter(reFilterFiltered)
        }

        if (v.filterData.taxon !== '0'){
            let tmp = v.metaData.aTaxa.filter(filterTaxa);
            // We have filter given the first filtering above. The taxa filtered must also be among the earlier
            v.filterData.aFiltered = tmp.filter(reFilterFiltered)
        }

        v.filterData.currentPubList = v.basePublicationsList.filter(finalFilter);
        refreshTable( v.filterData.currentPubList );

    }

    function filterAuthor(element){
        return element.AUTHOR_ID === v.filterData.author;
    }

    function filterKeyword(element){
        return element.KEYWORD_ID === v.filterData.keyword;
    }

    function filterTaxa(element){
        return element.TAXA_ID === v.filterData.taxon;
    }

    function reFilterFiltered(element){

        let answer = false;
        for (let i = 0; i < v.filterData.aFiltered.length; i++){

            let filteredPublication = v.filterData.aFiltered[i];
            if (filteredPublication.PUBLICATION_ID === element.PUBLICATION_ID){
                answer = true;
                break;
            }
        }

        return answer;
    }

    function finalFilter(element){

        let answer = false;
        for (let i = 0; i < v.filterData.aFiltered.length; i++){

            let filteredPublication = v.filterData.aFiltered[i];
            if (filteredPublication.PUBLICATION_ID === element.PUBLICATION_ID){
                answer = true;
                break;
            }
        }

        return answer;
    }

    function getAllMetaData(){

        $.ajax({
            type: "get",
            url: "getPublicationsAuthors.php",
            success: function (data) {
                v.metaData.aAuthors = JSON.parse(data);
                $.ajax({
                    type: "get",
                    url: "getPublicationsKeywords.php",
                    success: function (data) {
                        v.metaData.aKeywords = JSON.parse(data);
                        $.ajax({
                            type: "get",
                            url: "getPublicationsTaxa.php",
                            success: function (data) {
                                v.metaData.aTaxa = JSON.parse(data);
                            }
                        })
                    }
                });
            }
        });
    }



    function refreshTable(data){

        // clear first DataTable object
        if (v.ui.publicationsTable.dataTable != null){
            v.ui.publicationsTable.dataTable.clear();
            v.ui.publicationsTable.dataTable.destroy();
        }

        //2nd empty html
        let tableId = "#publicationsTable";
        $(tableId + " tbody").empty();
        $(tableId + " thead").empty();

        let s = "";
        for (let i = 0; i < data.length; i++){
            s = s + '            <tr>\n' +
                '                <td class="publications-pdf-cell">' +
                                 resolvePDF(data[i]) +
                '                </td>\n' +
                '                <td>';
            s = s + '                <p class="publication">\n' +
                '                    <strong>' + data[i].AUTHOR + '</strong>\n' +
                                    data[i].YEAR + ' ' + '\n' +
                                    ' ' +
                                    data[i].JOURNAL + ' ' + '\n' +
                '                    <br/>\n' +
                                    data[i].TITLE + ' ' + '\n' +
                '                    <br/>\n' +
                                    data[i].summary + ' ' + '\n' +
                '                    </p>\n' +
                '                </td>\n' +
                '            </tr';

        }


        let header =    '<tr class="mg-hide-element"><th>A</th><th>B</th></tr>';

        v.ui.publicationsTable.tableHead.append(header);

        v.ui.publicationsTable.tableBody.append(s);

        v.ui.publicationsTable.dataTable = $('#publicationsTable').DataTable({
            "order": [],
            "pageLength": 10,
            "language" : {
                "url" : v.language.publicationsTable.textsFile,
            },
        });


    }

    function resolvePDF(publication){

        let a = '';
        if (publication.PDF === 'J'){
            let tmp = '000' + publication.ID;
            tmp = tmp.substring( tmp.length-3);
            a = '<a href="/publikationer/pdf/' + tmp + '.pdf"><img src="https://www.falsterbofagelstation.se/bilder/icons/pdf-icon.png" alt="pdf-icon"></a>';
        }

        return a;
    }

    resolveLanguage(v);
    getHeaderTexts()
    setHeaderTexts();
    setLangTexts();
    getPublicationsList(setLangTexts);
    getAllMetaData();

});
