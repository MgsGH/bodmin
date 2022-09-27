/*
This file contains routines shared by the home page and the blog-front end.

 */

/*
"Blog days", a grouped collection of data for a given date, appear in several contexts:
* Most recent day at the "home" page
* As an entry in the list "featured news" on the home page;
* A chosen day in the blog section.

Technically, the term BlogDay refers to a "<div>" containing all the HTML for a given day, regardless of the context
this <div> appear (alone on a page or in a list).

Creating a blogDay is a two-step process. First the structure of the blogDay is constructed, starting with an empty <div>.
For this only the date needs to be known. All functions used for this has "getBlogDayXxxxSection" in their names.
Second step is to load content into the constructed structures. This is done by a corresponding loadBlogDayXxxxContent function.


Blog Day data come from many sources:
* Blog text
* Visible migration (during season)
* Ringing (during season)
* Weather
* Staging data (week)

*/


function compileBlogDayAllPageSections(pageData, v, headersScaling){

    // This is the function deciding on the overall layout of a "blogDay".
    // Expects v.blogDay.node and v.blogDay.dateYMD // as well as v.xxxx.language.texts.
    // HeadersScalingLevel decides how much default headers <hx> are scaled when put onto the page.

    const news = pageData['newsData'];

    v.blogDay.blogText = news["TEXT"];
    v.blogDay.blogDate = news["DATE"];
    const thisPageNode = v.blogDay.node;
    const langSection = v.ringingSection.language;


    // Intro, title (date) and weather box
    thisPageNode.append(getBlogDayIntroSection(v, headersScaling));
    let tableBodyNode = $( '#weatherTableBody-' + v.blogDay.blogDate );
    loadBlogDayWeather(pageData['weatherData'], tableBodyNode, v );


    // Blog text, not always present, if present, it comes first in terms of content sections
    thisPageNode.append(getBlogDayTextSection(v));
    let node = thisPageNode.find('#blogTextSection-' + v.blogDay.blogDate);
    loadBlogDayTextContent(node, v, headersScaling);

    // Ringing, always done both spring and autumn during season, odd days without due to weather
    thisPageNode.append(getBlogDayRingingSection(v));
    loadBlogDateRingingContent(pageData, v, langSection);

    // Visible migration section
    thisPageNode.append(getBlogDayVisibleMigrationSection(v));
    node = thisPageNode.find('#visibleMigrationSection-' + v.blogDay.blogDate);
    loadBlogDayVisibleMigrationContent(pageData, node, v);

    // staging section
    thisPageNode.append(getBlogDayStagingSection(v));
    node = thisPageNode.find('#stagingSection-' + v.blogDay.blogDate);
    loadBlogDayStagingContent(node, v);

}


function getBlogDayIntroSection(v, topHeaderScaling){

    let defaultHeaderLevel = 1;
    let ScaledHeaderLevel = parseInt(defaultHeaderLevel) + parseInt(topHeaderScaling);
    let dateAsHeader = getFormattedDate(v.blogDay.blogDate, v);
    dateAsHeader = capitalizeFirstLetter(dateAsHeader);

    let tableClass = 'smhi-dagbok';
    if(v.language.current === '1'){
        tableClass = 'smhi-dagbok-wide';
    }

    return '<div class="d-flex space-below justify-content-between mb-2">\n' +
        '\n' +
        '                    <div>\n' +
        '                        <h' + ScaledHeaderLevel + ' id="dateHeader">' + dateAsHeader  + '</h' + ScaledHeaderLevel +'>\n' +
        '                    </div>\n' +
        '                    <div class="vaderTabell mt-1" id=weatherTable-' + v.blogDay.blogDate + '">\n' +
        '                        <table class="table_none ' + tableClass + '" id="weatherTable">\n' +
        '                            <thead>\n' +
        '                                <tr>\n' +
        '                                    <th class="smhi-tid" id="weatherTime" title="' + v.smhi.language.smhiHeaderTimeTitle + '">' + v.smhi.language.smhiHeaderTime + '</th>\n' +
        '                                    <th class="smhi-moln" id="weatherClouds" title="' + v.smhi.language.smhiHeaderCloudsTitle + '">' + v.smhi.language.smhiHeaderClouds + '</th>\n' +
        '                                    <th class="smhi-vind" id="weatherWind" title="' + v.smhi.language.smhiHeaderWindTitle + '">' + v.smhi.language.smhiHeaderWind + '</th>\n' +
        '                                    <th class="smhi-ms" id="weatherWindForce" title="' + v.smhi.language.smhiHeaderWindForceTitle + '">' + v.smhi.language.smhiHeaderWindForce + '</th>\n' +
        '                                    <th class="smhi-temp" id="weatherTemperature" title="' + v.smhi.language.smhiHeaderTempTitle + '">' + v.smhi.language.smhiHeaderTemp + '</th>\n' +
        '                                    <th class="smhi-sikt" id="weatherVisibility" title="' + v.smhi.language.smhiHeaderVisibilityTitle + '">' + v.smhi.language.smhiHeaderVisibility + '</th>\n' +
        '                                    <th class="smhi-tryck" id="weatherPressure" title="' + v.smhi.language.smhiHeaderPressureTitle + '">' + v.smhi.language.smhiHeaderPressure + '</th>\n' +
        '                                    <th class="smhi-vader-header" id="weatherHeader">' + v.smhi.language.smhiHeaderComment +'</th>\n' +
        '                                </tr>\n' +
        '                            </thead>\n' +
        '                            <tbody id="weatherTableBody-' + v.blogDay.blogDate + '">\n' +
        '                               <tr><td colspan="8">' + mgGetDivWithSpinnerImg() + '</td></tr>                               \n' +
        '                            </tbody>\n' +
        '                        </table>\n' +
        '                    </div>\n' +
        '\n' +
        '                </div>';

}


function loadBlogDayWeather(wData, tableBodyNode, v){

    let w_info = wData;

    const comments = w_info[1];
    const readings = w_info[0];
    const l = readings.length;
    let html = '';
    for (let i =0; i < l; i++){

        let timme = getRightTime(readings[i].TIME, v.blogDay.blogDate );
        html += '<tr>';
        html += '<td class="text-center">' + timme + '</td>';
        html += '<td class="text-center">' + readings[i].CLOUDS + '</td>';
        html += '<td class="text-center">' + readings[i].WIND + '</td>';
        html += '<td class="text-end">' + readings[i].vsty + getNbSp(2) + '</td>';
        html += '<td class="text-end">' + formatTemperature(readings[i].TEMP, v) + getNbSp(2) + '</td>';
        html += '<td class="text-end">' + formatSikt(readings[i].SIKT, v) + getNbSp(2) + '</td>';
        html += '<td class="text-end">' + formatNo(readings[i].TRYCK, v, 1) + getNbSp(8) + '</td>';
        html += '<td>' + getWeatherCommentsForId(readings[i].id, comments).substring(2) + '</td>';
        html += '</tr>';

    }

    tableBodyNode.empty();
    tableBodyNode.append(html);

}


function getWeatherCommentsForId(id, commentsArray){

    const l = commentsArray.length;
    let commentText = '';
    // for each weather comment for this day check if relevant given current
    // recording
    for (let i = 0; i < l; i++) {

        let currentObservation = commentsArray[i];
        if (id === currentObservation.DAGB_VADER_ID){
            commentText += ', ' + currentObservation.TEXT;
        }

    }

    return commentText;

}


function getBlogDaySection(){

    return {
        dateYMD : '',
            node : $('#theMostRecentBlogEntry'),
            datePicker : $.datepicker, /* used for isoweek */
            blogText : '',
            defaultSectionVisibility : {
            visibleMigration : false,
        },

    }

}


function getBlogDayTextSection(v){

    let html = '<div id="blogTextSection-' + v.blogDay.blogDate + '" class="mt-2 mb-3 tst">';
    html += mgGetDivWithSpinnerImg();
    return html + '</div>';

}


function loadBlogDayTextContent(node, v, scaling){
    // Text content comes with header tags. However, the levels needs to be adjusted
    // as the whole "blogPage" may be in a different context on the web page.
    // this function re-code headers - if given a scaling larger than 0.

    let txt = v.blogDay.blogText;

    for (let i = 5; i > 0; i--){

        let newLevel = parseInt(scaling) + 1 + i;

        let lookFor = '<h' + i + '>';
        let replaceWith = '<h' +  newLevel  + '>';
        txt = txt.replaceAll(lookFor, replaceWith);

        lookFor = '</h' + i + '>';
        replaceWith = '</h' + newLevel + '>';
        txt = txt.replace(lookFor, replaceWith);

    }

    node.empty();
    node.html(txt);

}


// Ringing/banding
function getBlogDayRingingSection(v){

    let html = '<div id="ringingSection" class="mb-2">';
    html +=   '     <h3 id="ringingSectionHeader">' + v.ringingSection.language.header + '</h3>';
    html +=   '     <div id="ringingSectionBody-' + v.blogDay.blogDate + '" class="ringingSectionBody">';
    html += mgGetDivWithSpinnerImg();
    html += '     </div>';
    return html + '</div>';

}

function getRingingSectionIds(){

    return {
        ui: {
            theSectionItSelf: $('#ringingSection'),
            ringingSectionHeader: $('#ringingSectionHeader'),
            ringingSectionBody: $('#ringingSectionBody'),
        },
        language : {},
    };

}

function loadBlogDateRingingContent(pageData, v, lang){

    /*
        The structure "pageData" contains "seasonData" which keeps all standardised work schemes given this work area - here ringing.
        All standard seasons are always retrieved, along with their data.
        Then ongoing seasons are filtered out from all seasons (this could have been done on the server side - but messier)
        If a work scheme is "ongoing" if date is within season start/stop. If so, there ought to be data. If there is, it is shown.
        If no data, two cases
        - date was cancelled, or
        - data not yet entered
     */

    // this is the node to work with.
    let node = $('#ringingSectionBody-' + pageData.newsData.DATE);
    let html = '';

    let onGoingSeasons = getOnGoingSeasons(pageData);
    let onGoing = onGoingSeasons.length > 0;

    if (!onGoing){
        // populate non-season disclaimer and inform when the season start
        html = '<p>' + lang.disclaimer + ' ' + getDaysToSeasonStartText(lang, pageData.newsData.DATE) + '</p>';
    }

    // We have ongoing seasons
    if (onGoing){

        let l = onGoingSeasons.length
        for (let i = 0; i < l; i++) {

            let season = onGoingSeasons[i];

            html += '<div class="mb-4">';
            html += '<h5 class="grey">' + getFirstCharCapitalized(season[0].TEXT) + '</h5>';

            if (season[1].length !== 0) {
                html += getNicelyFormattedRingingSectionAsString(season[1], lang);
            }

            let cancelledText = '';
            if (season[1].length === 0) {  // No data
                cancelledText = lang.dataNotYetEntered;

                let cancelledInformation = isWorkSchemeCancelled(pageData, season[0].WORKSCHEME_ID);
                if (cancelledInformation !== '') {
                    cancelledText = cancelledInformation ;
                }
            }

            html += '<p>' + cancelledText + '</p>';
            html += '</div>';

        }
    }


    // we may have some "other" data.
    let nonSystematicRingingData = pageData['nonSystematicRingingData'];

    let l = nonSystematicRingingData.length;
    if ( l > 0) {

        for (let i = 0; i < l; i++) {

            const placeInfo = nonSystematicRingingData[i]['placeInfo'];
            const ringingData = nonSystematicRingingData[i]['ringingData'];

            html += '<div class="mb-4 otherData">';
            html += '<h5 class="grey">' + getFirstCharCapitalized(placeInfo.TEXT) + '</h5>';

            html += getNicelyFormattedRingingSectionAsString(ringingData, lang);
            html += '</div>';

        }

    }

    node.empty();
    node.append(html);

}


function isWorkSchemeCancelled(pageData, workSchemeId){

    let cancelledData = pageData['allZeroDayData'];
    let l = cancelledData.length;
    let s = '';

    if (l > 0) {
        for (let i = 0; i < l; i++) {

            if (cancelledData[i]['WORKSCHEME_ID'] === workSchemeId){
                s = '<p>' + cancelledData[i]['TEXT'] + '. ' + cancelledData[i]['RESON'] + '</p>';
                break;
            }

        }

    }

    return s;

}


function getNicelyFormattedRingingSectionAsString(ringingData, lang){

    let summa = 0;
    let taxaList = '';
    let html = '';
    const l = ringingData.length;

    for (let t = 0; t < l; t++) {

        let season = ringingData[t]['P'];
        let taxaName = ringingData[t]['NAME'];
        let art = ringingData[t]['ART'];

        if (t > 0){
            taxaName = ringingData[t]['NAME'].toLowerCase();
        }

        let year = ringingData[t]['DATUM'].substring(0,4);
        taxaList += '<a href="/ringmarkning/art-ar-sasong.php?lang=' + lang.languageAsString + '&year=' + year +'&sasong=' + season + '&art=' + art + '">' + taxaName + '</a>' + mgNbSp() + ringingData[t]['SUMMA'] + ', ';
        summa = summa + parseInt(ringingData[t]['SUMMA']);

    }

    taxaList = taxaList.substring(0, taxaList.length - 2);

    html += taxaList;
    html += '<div class="mt-2">' + getProperlyFormattedSummaryText(lang, summa, ringingData.length) + '</div>';

    return html;

}


function getTextsBlogRinging(languageId){

    let language = {};
    if (languageId === '1') {
        language = {
            languageAsString : 'en',
            header : "Banding/ringing",
            dataNotYetEntered : "Data not yet entered.",
            cancelledToday : "Cancelled today. ",
            zeroBirdsToday : "0 (zero) bird ringed today in ",
            disclaimer : "No standardized banding/ringing today.",
            rNextSeason : "Next season starts in ",
            rDays : "days",
            rDay  : "day",
            rSum  : "Day total:",
            rBird  : "bird of",
            rBirds  : "birds of",
            rTaxon  : "species",
            rTaxa  : "species",
        };

    }

    if (languageId === '2') {
        language = {
            languageAsString : 'sv',
            header : "Ringmärkning",
            dataNotYetEntered : "Dagens ringmärkning inte inmatad än.",
            cancelledToday : "Inställt idag. ",
            zeroBirdsToday : "0 (noll) fåglar fångade i ",
            disclaimer : "Ingen standardiserad ringmärkning idag.",
            rNextSeason : "Nästa säsong börjar om ",
            rDays   : "dagar",
            rDay    : "dag",
            rSum    : "Summa:",
            rBird   : "fågel av",
            rBirds  : "fåglar av",
            rTaxon  : "art",
            rTaxa   : "arter",
        }

    }

    return language

}


// Visible migration monitoring
function getBlogDayVisibleMigrationSection(v){

    return '                         <div class="mb-4" id="visibleMigrationSection-' + v.blogDay.blogDate + '">' +
        '                                <h3 id="visibleMigrationSectionHeader"> ' + v.visibleMigrationSection.language.visibleMigrationSectionHeader + '</h3>\n' +
        '                                <div id="visibleMigrationSectionInfo-' + v.blogDay.blogDate + '" class="mg-hide-element"> ' + v.visibleMigrationSection.language.visibleMigrationDataNotYetEntered + '</div>\n' +

        '                                <div id="visibleMigrationSectionData-' + v.blogDay.blogDate + '">\n' +
        '                                   <div class="d-flex justify-content-start">\n' +
        '                                       <div class="pt-2 pr-2"><span id="summary"></span>  ' + mgNbSp() + mgNbSp() + '</div>\n' +
        '                                       <div class="pt-2">' + mgNbSp() + mgNbSp() + '</div>\n' +
        '                                        <div class="pl-2"><button type="button" class="btn btn-link btnVisibleMigration" id="btnVisibleMigration-' + v.blogDay.blogDate + '">' + v.visibleMigrationSection.language.showData + '</button></div>\n' +
        '                                    </div> \n' +
        '                                    \n' +
        '                                   <div id="visibleMigrationSectionBody-' + v.blogDay.blogDate + '">\n' +
        '                                       ANKA' +
       '                                    </div>' +
        '                                </div>' +
        '                            </div>';

}

function getVisibleMigrationSectionIds(){

    return  {
        ui : {
            theSectionItSelf : $('#visibleMigrationSection'),
            visibleMigrationSectionHeader : $('#visibleMigrationSectionHeader'),
            //visibleMigrationSectionBody : $('#visibleMigrationSectionBody'),
            visibleMigrationHeaderTaxa : $('#visibleMigrationHeaderTaxa'),
            visibleMigrationHeaderDayTotal : $('#visibleMigrationHeaderDayTotal'),
            visibleMigrationSeasonTot : $('#visibleMigrationSeasonTot'),
            visibleMigrationHeaderAverageThisSeason : $('#visibleMigrationHeaderAverageThisSeason'),
            visibleMigrationHeaderAverageAllSeasons : $('#visibleMigrationHeaderAverageAllSeasons'),
            visibleMigrationTableBody : $('#visibleMigrationTableBody'),
        },
        language : {},
    };

}


function loadBlogDayVisibleMigrationContent(pageData, node, v){

    let migrationData = pageData.strackData;

    v.blogDay.dateYMD = pageData.newsData.DATE;

    // Show only visible migration section during season - default hidden.
    node.toggleClass("mg-hide-element", true);

    if (isDayMigrationCountDay( v.blogDay.dateYMD )){

        node.toggleClass("mg-hide-element", false);
        let html = '';

        if (migrationData.length === 0) {  // no data

            // then two cases
            // - either not yet entered, or
            // - day has been cancelled

            let infoSection = $('#visibleMigrationSectionInfo-' + v.blogDay.dateYMD);
            infoSection.toggleClass('mg-hide-element', false);
            $('#visibleMigrationSectionData-' + v.blogDay.dateYMD).toggleClass('mg-hide-element', true);

            // default not entered
            let info = '<p>' + v.visibleMigrationSection.language.visibleMigrationDataNotYetEntered + '</p>';
            let cancelled = isWorkSchemeCancelled(pageData, '6');
            if (cancelled !== '') {
                info = cancelled;
            }

            html = info;
            infoSection.empty();
            infoSection.append(html);

        }

        if (migrationData.length !== 0) {

            let tableBodyNode = $('#visibleMigrationSectionBody-' + v.blogDay.blogDate );

            tableBodyNode.append(mgGetDivWithSpinnerImg());
            composeTable(migrationData, v, tableBodyNode)

            let summaryHTML = compileSummaryHtml(v, migrationData) ;
            let summaryNode = node.find('#summary');
            summaryNode.append(summaryHTML);

            if (v.blogDay.defaultSectionVisibility.visibleMigration === false){

                let visibleMigrationSection = $('#visibleMigrationSectionBody-' +  v.blogDay.dateYMD);

                visibleMigrationSection.toggleClass('mg-hide-element', true);
                $(this).text(v.visibleMigrationSection.language.showData);

            }

        }

    }

}


function myParseInt(s){

    let answer = parseInt(s)
    if ((isNaN(answer)) || (answer === 0)){
        console.log(s);
    }

    return answer;

}


function getTextsBlogVisibleMigration(languageId){

    let language = {};

    if (languageId === '1'){
        language = {

            visibleMigrationDataCancelledToday : 'Migration counts cancelled today.',
            visibleMigrationDataNotYetEntered : 'Visible migration data not yet entered for this day.',
            visibleMigrationSectionHeader : 'Visible migration',
            visibleMigrationHeaderTaxa : 'Species',
            visibleMigrationHeaderDayTotal : 'Day total',
            visibleMigrationSeasonTot : 'Until today',
            visibleMigrationHeaderAverageThisSeason : 'This season',
            visibleMigrationHeaderAverageAllSeasons : 'Average all years',
            showData : "Show detail table",
            hideData : "Hide detail table",
            today : "Today",
            bird : "bird",
            birds : "birds",
            of : "of",
            taxa : "species",
            taxon : "species",
            migrated : "left Sweden, seen/heard from Nabben.",

            table : {

            }
        };
    }

    if (languageId === '2'){
        language = {
            visibleMigrationSectionHeader : 'Sträckräkning',
            visibleMigrationDataNotYetEntered : 'Sträckräkningsdata inte uppladdat för denna dag (än)..',
            visibleMigrationDataCancelledToday : 'Sträckräkningen inställd idag.',
            visibleMigrationHeaderTaxa : 'Art',
            visibleMigrationHeaderDayTotal : 'Idag',
            visibleMigrationSeasonTot : 'Till och med idag',
            visibleMigrationHeaderAverageThisSeason : 'Denna säsong',
            visibleMigrationHeaderAverageAllSeasons : 'Medel alla säsonger',
            showData : "Visa detaljer",
            hideData : "Göm detaljer",
            today : "Idag sträckte",
            bird : "fågel",
            birds : "fåglar",
            of : "av",
            taxa : "arter",
            taxon : "art",
            migrated : "ut, observerade från Nabben.",
        };
    }

    return language;

}

function getProperlyFormattedSummaryText(lang, numberOfBirds, numberOfTaxa){

    let birdx = lang.rBirds;
    if (numberOfBirds < 2){
        birdx = lang.rBirds;
    }

    let taxx = lang.rTaxa;
    if (numberOfTaxa < 2){
        taxx = lang.rTaxon;
    }

    return lang.rSum + ' ' + numberOfBirds + ' ' + birdx + ' ' + numberOfTaxa + ' ' + taxx + '.';

}


function compileSummaryHtml(v, migrationData){

    let l = migrationData.length;
    let daySum = 0;
    for (let i = 0; i < l; i++) {
        daySum = addIfPossible(daySum, migrationData[i]['TODAY']);
    }
    let birds = v.visibleMigrationSection.language.birds;
    let taxa = v.visibleMigrationSection.language.taxa;
    if (l === 1){
        birds = v.visibleMigrationSection.language.bird;
        taxa = v.visibleMigrationSection.language.taxon;
    }

    return v.visibleMigrationSection.language.today + mgNbSp() + getNumberWithDelimiters(v,daySum) + mgNbSp() + birds + mgNbSp() +
        v.visibleMigrationSection.language.of + mgNbSp() + l + mgNbSp() + taxa + mgNbSp() +
        v.visibleMigrationSection.language.migrated;

}


function getTextsBlogSmhi(languageId){

    let language = {};
    if (languageId === '1') {
        language = {

            smhiHeader : "Weather drawn from the weather station at Falsterbo light house.",

            smhiHeaderTime : 'Time',
            smhiHeaderTimeTitle : 'Summertime/normal (winter) time',

            smhiHeaderClouds : 'Clouds',
            smhiHeaderCloudsTitle : 'Given in fractions (1/8) of the sky',

            smhiHeaderWindForce : 'm/s',
            smhiHeaderWindForceTitle : 'Average wind during 10 minutes, measured 10 meters above ground. Data given in meters/second',

            smhiHeaderWind : 'Wind',
            smhiHeaderWindTitle : 'Average wind during 10 minutes, measured 10 meters above ground. Wind direction indicates *from* where the wind is blowing.',

            smhiHeaderTemp : 'Temp',
            smhiHeaderTempTitle : 'Measured 1.5 to 2 meters above ground.',

            smhiHeaderChillFactor : 'Wind-chill',
            smhiHeaderChillFactorTitle : 'Indicates the practical temperature given the wind. Dress according to this!',
            smhiChillFactorNotApplicable : 'Not in range (less than 12 °C and wind more than 2 m/s).',

            smhiHeaderVisibility : 'Visibility',
            smhiHeaderVisibilityTitle : 'Measured from eye level',

            smhiHeaderPressure : 'Air press.',
            smhiHeaderPressureTitle : 'At sea level (converted) hPa',

            smhiHeaderComment : 'Comment',


            smhiInfo : 'Refreshed every third hour from 08 to 20.',
            smhiInfoII : 'Click the SMHI logotype for a 10 day forecast or ',
            smhiShortPrognosisText : "here for a short prognosis",

            smhiHeaderUpdated     : 'Updated ',
            smhiHeaderHour        : 'hour, ',
            smhiHeaderHours       : 'hours, ',
            smhiHeaderMinute      : 'minute, and ',
            smhiHeaderMinutes     : 'minutes, and ',
            smhiHeaderSeconds     : 'seconds ',
            smhiHeaderSedan       : 'ago ',
            smhiKlockanPrefix     : 'at ',
            smhiKlockanSuffix     : ''

        };

    }

    if (languageId === '2') {
        language = {
            smhiHeader : "Väder från väderstationen vid Falsterbo fyr.",

            smhiHeaderTime : 'Tid',
            smhiHeaderTimeTitle : 'Sommartid/normal (vinter) tid',

            smhiHeaderClouds : 'Moln',
            smhiHeaderCloudsTitle : 'Anges i (molntäckta) åttondelar av himlen.',

            smhiHeaderWind : 'Vind',
            smhiHeaderWindTitle : 'Medelvind under 10 minuter. Uppmätes 10 meter ovan markytan. Vindriktning anger *från* vilket håll vinden blåser.',


            smhiHeaderWindForce : 'm/s',
            smhiHeaderWindForceTitle : 'Medelvind under 10 minuter. Uppmätes 10 meter ovan markytan. Data i meter/sekund',

            smhiHeaderTemp : 'Temp.',
            smhiHeaderTempTitle : 'Uppmätes 1,5 till 2 meter över marken.',

            smhiHeaderChillFactor : 'Kyleffekt',
            smhiHeaderChillFactorTitle : 'Vindens avkylning vid rådande temperatur. Ger den reella kylan att klä sig efter!',
            smhiChillFactorNotApplicable : 'Ej tillämpbar vid rådande temp och vind.',

            smhiHeaderVisibility : 'Sikt',
            smhiHeaderVisibilityTitle : 'I ögonhöjd. Kilometer med en decimal om sikten understiger 5 km.',

            smhiHeaderPressure : 'Lufttryck',
            smhiHeaderPressureTitle : 'Vid havsytan (omräknat) hPa',

            smhiHeaderComment : 'Kommentar',

            smhiInfo : 'Uppdateras var 3:e timme från morgon till kväll.',
            smhiInfoII : 'Klicka på SMHI-loggan för en tiodagarsprognos, eller',
            smhiShortPrognosisText : "här för en kortprognos",

            smhiHeaderUpdated     : 'Uppdaterat ',
            smhiHeaderHour        : 'timme, ',
            smhiHeaderHours       : 'timmar, ',
            smhiHeaderMinute      : 'minut, och ',
            smhiHeaderMinutes     : 'minuter, och ',
            smhiHeaderSecond      : 'sekund, ',
            smhiHeaderSeconds     : 'sekunder ',
            smhiHeaderSedan       : 'sedan ',
            smhiKlockanPrefix     : 'kl. ',
            smhiKlockanSuffix     : '',

        }

    }

    return language

}

function getSmhiIds(){

    return {
        ui : {
            smhiHeader           : $('#smhiHeader'),

            smhiHeaderTime       : $('#smhiHeaderTime'),
            smhiHeaderClouds     : $('#smhiHeaderClouds'),
            smhiHeaderWind       : $('#smhiHeaderWind'),
            smhiHeaderTemp       : $('#smhiHeaderTemp'),
            smhiHeaderWindChill  : $('#smhiHeaderWindChill'),
            smhiHeaderVisibility : $('#smhiHeaderVisibility'),
            smhiHeaderPressure   : $('#smhiHeaderPressure'),
            smhiHeaderComment    : $('#smhiHeaderComment'),

            smhiDataChillFactor  : $('#smhiDataChillFactor'),

            smhiHeaderUpdated    : $('#smhiHeaderUpdated'),
            smhiDataHour         : $('#smhiDataHour'),
            smhiHeaderHour       : $('#smhiHeaderHour'),
            smhiDataMinute       : $('#smhiDataMinute'),
            smhiHeaderMinute     : $('#smhiHeaderMinute'),
            smhiDataSecond       : $('#smhiDataSecond'),
            smhiHeaderSecond     : $('#smhiHeaderSecond'),
            smhiHeaderSedan      : $('#smhiHeaderSedan'),
            smhiHeaderWeatherType: $('#smhiHeaderWeatherType'),
            smhiKlockanPrefix    : $('#smhiKlockanPrefix'),
            smhiKlockanData      : $('#smhiKlockanData'),
            smhiKlockanSuffix    : $('#smhiKlockanSuffix'),

            smhiDataTime : $('#smhiDataTime'),
            smhiDataClouds : $('#smhiDataClouds'),
            smhiDataWindDirection : $('#smhiDataWindDirection'),
            smhiDataWindForce : $('#smhiDataWindForce'),
            smhiDataTemp : $('#smhiDataTemp'),
            smhiDataVisibility : $('#smhiDataVisibility'),
            smhiDataPressure : $('#smhiDataPressure'),
            smhiDataComment : $('#smhiDataComment'),

        },
        language : {},

    };

}

// Staging section
function getTextsBlogStagingSection(languageId){

    let language = {}

    if (languageId === '1'){
        language = {
            header : "This week's staging count",
            rrInfo : "Data concerning this week's count you find ",
            rrHere : "here",
        };
    }

    if (languageId === '2'){
        language = {
            header : "Veckans rastfågelräkning",
            rrInfo : "Data finner du ",
            rrHere : "här",
        };
    }

    return language;

}

function getStagingSectionIds(){

    return {
        ui : {
            header : $('#stagingHeader'),
                rrInfo : $('#rrInfo'),
                rrHere : $('#rrHere'),
                rrLink : $('#rrLink'),
        },
        language : {},
    };



}

function getBlogDayStagingSection(v){

    let html = '<div id="stagingSection-' + v.blogDay.blogDate + '" class="mb-1 pb-2">';
    html += '<h3 id="stagingHeader">' + v.stagingSection.language.header + '</h3>';
    html += '<div id="stagingBody">';
    html += '<p>';
    html += '    <span id="rrInfo">' + v.stagingSection.language.rrInfo + '</span> <a href="" id="rrLink"><span id="rrHere">' + v.stagingSection.language.rrHere + '</span></a>.';
    html += '</p>';
    html += '</div>';
    return html + '</div>';

}

function loadBlogDayStagingContent(node, v){

    const d = new Date(v.blogDay.dateYMD);
    v.blogDay.week = v.blogDay.datePicker.iso8601Week( d );
    let stagingLink = node.find('#rrLink');

    let link = '/rastrakning/?year=' + v.blogDay.dateYMD.substring(0,4) + '&vecka=' + v.blogDay.week;
    if (v.language.current === '1'){
        link = link + '&lang=en';
    }

    stagingLink.attr('href', link)

}
