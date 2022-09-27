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

            h.lang.titleText = 'Falsterbo Bird Observatory - Photo galleri'
            h.lang.bannerHeader = 'Photo gallery - Falsterbo Bird Observatory';
            h.lang.bannerIntroText = 'In our photo gallery images (mainly taken on the peninsula) depicting mainly birds, people, and landscapes are shown.  Click on the iomages to bring up a larger version. It is possible to filer by species and photographer at the moment. We welcome yet more contributions to this archive. Kindly, do not use the photos without prior consent from the photographer.';
        }


        // S V E N S K A
        if (h.lang.current === '2') {
            h.lang.langAsString = 'se';
            h.lang.decDelimiter = ',';
            h.lang.locale = 'sv-SE';

            h.lang.titleText = 'Falsterbo Fågelstation - Fotogalleri'
            h.lang.bannerHeader = 'Fotogalleri - Falsterbo Fågelstation';
            h.lang.bannerIntroText = 'I vårt fotogalleri visas bilder (huvudsakligen) tagna på Falsterbonäset. Fåglar, människor och landskap förekommer oftast. Klicka på bilderna som visas i datum ordning med de senaste först. Det går bra att filtrera på art och fotograf. Klicka på bilderna för att öppna en större bild. Vi välkomnar bidrag. Vänligt, använd inte dessa bilder utan fotografens medgivande.';

        }

    }

    function setHeaderTexts() {

        h.titleText.text(h.lang.titleText);
        h.bannerHeader.text(h.lang.bannerHeader);
        h.bannerIntroText.text(h.lang.bannerIntroText);

    }


    // https://pagination.js.org/docs/index.html
    // https://getbootstrap.com/docs/4.0/utilities/flex/

    // I vårt fotogalleri visas bilder (huvudsakligen) tagna på Falsterbonäset.
    // Klicka på bilderna (visas i systematisk ordning) för att öppna en större bild i ett nytt fönster.
    // Bilderna får inte kopieras eller användas utan fotografernas tillstånd. V.g. respektera detta.



    let v = {

        language: {
            metaLang: $("#metaLang"),
            current: ''  // here only for clarity, set below.
        },
        displaySettings : {
            // 0 -> All
            // keyword : '0',
            taxon : '0',
            photographer : '0',
        },
        selectedImageMetaData : {
            date : '',
            place : '',
            photographer : '',
        },
        filterData : {
            allImages : [],
            currentSelection : [],
        },
        metaData : {
            aKeywords : [],
            aPhotographers : [],
            aTaxa : [],
        },

        ui : {
            imagesPanel : $('#imagesPanel'),
            headerTextPartOne : $('#headerTextPartOne'),
            headerTextPartTwo : $('#headerTextPartTwo'),
            btnNext : $('#btnNext'),
            btnBack : $('#btnBack'),
            imagesPageLength : 20,
            imagesPageStartIndex : 0,
            texts : {
                noOfImages: $('#no-of-images'),
                noOfTaxa : $('#no-of-taxa'),
                noOfPhotographers : $('#no-of-photographers'),
                noOfKeywords : $('#no-of-keywords'),
            },
            data : {
                noOfImages: $('#no-of-images-data'),
                noOfTaxa : $('#no-of-taxa-data'),
                noOfPhotographers : $('#no-of-photographers-data'),
                noOfKeywords : $('#no-of-keywords-data'),
            },

            controlPanel : {
                ddNoOfImages : $('#ddNoOfImages'),
                imagesPerPage : $('#imagesPerPage'),
                filterDropDowns : {
                    taxon : $('#ddTaxon'),
                    group : $('#Not-used-yet'),
                    photographer : $('#ddPhotographer'),
                },

                headerText : $('#headerText'),
                filterText : $('#filterText'),
                photographerText : $('#filterPhotographerText'),
                taxonText : $('#taxonText'),
                imagesPerPageText : $('#imagesPerPageText'),

            },

            detailModal : {
                theWindow    : $('#imageModal'),
                imagePanel   : $('#modalImagePanel'),
                buttonBack   : $('#buttonBack'),
                imageToShow  : '',
                photographerText : $('#photographerText'),
                photographerName : $('#photographerName'),
                imageMetaDataPlace : $('#imageMetaDataPlace'),
                imageMetaDataDate : $('#imageMetaDataDate'),
                taxonName : $('#taxonName'),
            }

        }
    }

    function setLangTexts(){

        //let nbsp = String.fromCharCode(160);

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.localeString = 'en_GB';
            v.language.thousandSeparator = '.';


            v.ui.detailModal.lang = {
                photographerText : "Photo: ",
            };

            v.ui.controlPanel.lang = {
                headerText : "Show what and how",
                filterText : "Filter",
                photographerText : "Photographer",
                taxonText : "Species",
                imagesPerPageText : "No of photos per page",
            }

            v.language.headerTextPartOneAll = "All images, ";
            v.language.headerTextPartOneFiltered = "Filtered images, ";
            v.language.headerTextPartTwo  ="newest first";

        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.langAsString = 'se';
            v.language.localeString = 'sv_SE';
            v.language.thousandSeparator = ' ';

            v.ui.detailModal.lang = {
                photographerText : "Foto: ",
            };

            v.ui.controlPanel.lang = {
                headerText : "Visa vad och hur",
                filterText : "Filtrera",
                photographerText : "Fotograf",
                taxonText : "Art",
                imagesPerPageText : "Antal bilder per sida",
            }

            v.language.headerTextPartOneAll = "Alla bilder, ";
            v.language.headerTextPartOneFiltered = "Filtrerade bilder, ";
            v.language.headerTextPartTwo  = "nyast först";


        }

        v.ui.detailModal.photographerText.text(v.ui.detailModal.lang.photographerText);
        v.ui.controlPanel.headerText.text( v.ui.controlPanel.lang.headerText );
        v.ui.controlPanel.filterText.text( v.ui.controlPanel.lang.filterText );
        v.ui.controlPanel.photographerText.text( v.ui.controlPanel.lang.photographerText );
        v.ui.controlPanel.taxonText.text( v.ui.controlPanel.lang.taxonText );
        v.ui.controlPanel.imagesPerPageText.text( v.ui.controlPanel.lang.imagesPerPageText );
        v.ui.headerTextPartOne.text( v.language.headerTextPartOneAll );
        v.ui.headerTextPartTwo.text( v.language.headerTextPartTwo );

    }

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    v.ui.detailModal.buttonBack.click(function() {
        v.ui.detailModal.theWindow.modal('hide');
    });

    v.ui.controlPanel.filterDropDowns.taxon.change(function(){
        v.displaySettings.taxon = $(this).val();
        filterData();
        reSetPagination();
        reSetHeader();
    });

    v.ui.controlPanel.filterDropDowns.photographer.change(function(){
        v.displaySettings.photographer = $(this).val();
        filterData();
        reSetPagination();
        reSetHeader();
    });

    v.ui.controlPanel.ddNoOfImages.change(function(){

        v.ui.imagesPageLength = $(this).val();
        let pageDataSet = extractPageImages();  // from current selection
        reSetPagination();
        buildImagesPanel(pageDataSet);
    });

    v.ui.btnBack.click(function() {
        v.ui.imagesPageStartIndex = v.ui.imagesPageStartIndex - v.ui.imagesPageLength;
        let page = extractPageImages();
        buildImagesPanel(page);
    });

    v.ui.btnNext.click(function() {

        v.ui.imagesPageStartIndex = v.ui.imagesPageStartIndex + v.ui.imagesPageLength;

        // forward, check if there is another page
        if (v.ui.imagesPageStartIndex + v.ui.imagesPageLength >= v.filterData.currentSelection.length){
            v.ui.btnNext.attr('disabled','disabled');
        }

        // always done, as soon as we have moved forward, we can move back again.
        if (v.ui.imagesPageStartIndex >= v.ui.imagesPageLength){
            v.ui.btnBack.removeAttr('disabled');
        }

        let page = extractPageImages();
        buildImagesPanel(page);

    });

    function reSetHeader(){
        v.ui.headerTextPartOne.text( v.language.headerTextPartOneAll );
        if ((v.displaySettings.taxon !== '0') || (v.displaySettings.photographer !== '0')){
            v.ui.headerTextPartOne.text( v.language.headerTextPartOneFiltered );
        }
    }

    function reSetPagination(){

        // re-set pagination to first page
        v.ui.imagesPageStartIndex = 0;

        // default settings
        v.ui.btnNext.removeAttr('disabled');
        v.ui.btnBack.attr('disabled','disabled');

        // check if there's actually a "next" page, if not disable next button.
        if (v.filterData.currentSelection.length <= v.ui.imagesPageLength) {
            v.ui.btnNext.attr('disabled','disabled');
        }

    }

    function filterData(){

        // Filter each metadata set to create a set of images.
        // Use this set to filter the baseImages set.

        v.filterData.aFiltered = v.filterData.allImages;

        if (v.displaySettings.photographer !== '0'){
            v.filterData.aFiltered = v.metaData.aPhotographers.filter(filterPhotographer);
        }
/*
        if (v.filterData.keyword !== '0'){
            let tmp = v.metaData.aKeywords.filter(filterKeyword);
            // tmp now has a few recs, these should also be in authorsFiltered.
            // We have filter given the first filtering above. The keyword filtered must also be among the
            // authors.
            v.filterData.aFiltered = tmp.filter(reFilterFiltered)
        }
*/
        if (v.displaySettings.taxon !== '0'){
            let tmp = v.metaData.aTaxa.filter(filterTaxa);
            // We have filter given the first filtering above. The taxa filtered must also be among the earlier
            v.filterData.aFiltered = tmp.filter(reFilterFiltered)
        }

        v.filterData.currentSelection = v.filterData.allImages.filter(finalFilter);

        let pageDataSet = extractPageImages();  // from current selection, start with first page.

        buildImagesPanel(pageDataSet);

    }

    function filterPhotographer(element){
        return element.PERSON_ID === v.displaySettings.photographer;
    }

    function filterKeyword(element){
        return element.KEYWORD_ID === v.filterData.keyword;
    }

    function filterTaxa(element){
        return element.TAXA_ID === v.displaySettings.taxon;
    }

    function reFilterFiltered(element){

        let answer = false;
        for (let i = 0; i < v.filterData.aFiltered.length; i++){

            let filteredImage = v.filterData.aFiltered[i];
            if (filteredImage.IMAGE_ID === element.IMAGE_ID){
                answer = true;
                break;
            }
        }

        return answer;
    }

    function finalFilter(element){

        let answer = false;
        for (let i = 0; i < v.filterData.aFiltered.length; i++){

            let filteredImage = v.filterData.aFiltered[i];
            if (filteredImage.IMAGE_ID === element.IMAGE_ID){
                answer = true;
                break;
            }
        }

        return answer;
    }

    function extractPagePanelPhotos(element, index){
        return ((index >= v.ui.imagesPageStartIndex) && (index < parseInt(v.ui.imagesPageStartIndex) + parseInt(v.ui.imagesPageLength)))
    }

    function buildImagesPanel(dataSet){

        let url = 'https://www.falsterbofagelstation.se/v2images/minipics/';
        let s = '';
        s = s + '<ul class="minipic-ul">';
        for (let i = 0; i < dataSet.length; i++){
            let imgName = 'minipic-' + dataSet[i].IMAGE_ID + '.jpg';
            let maxiPicName = 'maxipic-' + dataSet[i].IMAGE_ID + '.jpg';
            s = s + '<li class="minipic-li" title="' + dataSet[i].FULLNAME + '"><a href="#' + maxiPicName + '" class="thumbnail">';
            s = s + '<img class="shadow rounded" alt="thumnail image" src="' + url + imgName + '"></a>';
            s = s + '</li>';
        }

        let images = dataSet.length;

        while ( images < v.ui.imagesPageLength ){
            // pad page with dummy list entries so images are aligned properly.
            s = s + '<li class="minipic-li"></li>';
            images++;
        }
        s = s + '</ul>';
        v.ui.imagesPanel.empty();
        v.ui.imagesPanel.append(s);

    }

    function extractPageImages(){
        return v.filterData.currentSelection.filter(extractPagePanelPhotos);
    }

    function loadBasePhotos(){
       $.ajax({
           type: "get",
           url: "getImages.php",
           success: function (data) {
               v.filterData.allImages = JSON.parse(data);

               v.filterData.currentSelection = v.filterData.allImages;
               let pageDataSet = extractPageImages();  // from current selection, here all, first page.
               buildImagesPanel(pageDataSet);
               checkAndShowIfWantedPopUp();
           }
       });
   }

    function checkAndShowIfWantedPopUp(){
        // check if we have book-marked this page with an active popUp open: #maxipic-XXXX.jpg (taxa code proper)
        let x = location.hash;
        x = decodeURI( x );

        if (x.length > 6){
            popUpDetails(x.substr(1));
        }
    }

    function popUpDetails(s) {

        let l = s.indexOf('.') - 8;
        // s = maxipic-XYZ.jpg
        //     01234567
        v.imgNo = s.substr(8, l);

        resolveImageMetaDataFromBaseData(v.imgNo);
        v.ui.detailModal.photographerName.text(v.selectedImageMetaData.photographer);
        v.ui.detailModal.imageMetaDataPlace.text(v.selectedImageMetaData.place);
        v.ui.detailModal.imageMetaDataDate.text(v.selectedImageMetaData.date);
        $.ajax({
            type: "get",
            url: "getImageTaxaNamesViaPhotoId.php?language=" + v.language.current + "&image=" + v.imgNo,
            success: function (data) {


                let names = JSON.parse(data);

                let namesString = '';
                for (let i = 0; i < names.length; i++){
                    namesString = namesString + names[i].NAME + ', ';
                }

                let l = namesString.length - 2; // comma+space
                namesString = namesString.substr(0, l);
                if (namesString.length > 0){
                    namesString = namesString + ', ';
                }

                v.ui.detailModal.taxonName.text(namesString);

            }
        });

        v.ui.detailModal.imageToShow = '<img alt="Species detail image" class="shadow rounded" src="https://www.falsterbofagelstation.se/v2images/maxipics/' + s + '">';
        v.ui.detailModal.imagePanel.empty();
        v.ui.detailModal.imagePanel.append(v.ui.detailModal.imageToShow);
        v.ui.detailModal.theWindow.modal('show');

    }


    function resolveImageMetaDataFromBaseData(imgNo){

        for (let i = 0; i < v.filterData.allImages.length; i++){

             if (v.filterData.allImages[i].IMAGE_ID === imgNo){
                v.selectedImageMetaData.date = v.filterData.allImages[i].DATUM.substr(0, 10);
                v.selectedImageMetaData.place = v.filterData.allImages[i].PLATS;
                v.selectedImageMetaData.photographer = v.filterData.allImages[i].FULLNAME;
                break;
            }

        }

    }


    function getAllMetaData(){

        $.ajax({
            type: "get",
            url: "getImagesTaxa.php",
            success: function (data) {
                v.metaData.aTaxa = JSON.parse(data);

                $.ajax({
                    type: "get",
                    url: "getImagesPhotographers.php",
                    success: function (data) {
                        v.metaData.aPhotographers = JSON.parse(data);
                    }
                });

            }
        });
    }


    $(document).on('click', '.thumbnail', function(){
        let s = $(this).attr("href").substr(1, 99);
        popUpDetails(s);
    });

    $('.js-example-basic-single').select2({
        width: 'resolve' // override potentially changed default(s)
    });

    getHeaderTexts();
    setHeaderTexts();
    resolveLanguage(v);
    setLangTexts();
    loadBasePhotos();
    getAllMetaData();

});