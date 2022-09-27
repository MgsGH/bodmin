
function mgCheckFilterString( hay, needles){

    let words = needles.toLowerCase().split(" ");
    let answer = true;

    for (let i = 0; i < words.length; i++) {

        answer = (hay.toLowerCase().indexOf(words[i]) > -1);
        if (answer === false){
            break;
        }

    }

    return answer;

}


function mgGetImgSpinner(){
    return '<div class="pt-5 pb-5"><img src="/aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"></div>';
}


function mgGetDivWithSpinnerImg(){
    return '<div class="pt-5 pb-5"><img src="/aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"></div>';
}


function mgGetDataRow(id, cols){

    let rows = "";
    rows = rows + '<tr id="dataFor-' + id + '" class="mg-table-row-data mg-hide-element"><td colspan="' + cols + '">';
    rows = rows + mgGetImgSpinner();
    rows = rows + '</td></tr>'

    return rows;

}


function getDateFrom(ymdString){

    let pieces = ymdString.split("-");
    let y = pieces[0];
    let m = parseInt(pieces[1]) - 1;
    let d = pieces[2];

    return new Date(y,m,d);

}


function mgGetMonthAsIntegerString(ymd){

    let month = ymd.substr(5,2);
    if (month.substr(0,1) === '0'){
        month = month.substr(1,1)
    }

    return month

}


function getLoggedInUserId(){

    return  $('#loggedInUserId').text();

}


function mgFilterInt(value) {
    if (/^[-+]?(\d+|Infinity)$/.test(value)) {
        return Number(value)
    } else {
        return NaN
    }
}


function setCheckBoxStatus(theBox, intStatus){

    if (intStatus === '1') {
        theBox.prop('checked', true);
    } else {
        theBox.prop('checked', false);
    }

}


function getCheckBoxStatus(theBox){

    let answer = '0';
    if (theBox.prop('checked')){
        answer = '1';
    }

    return answer
}


function formatBoolean(b){

    let r = b;

    if ((b === '') || (b === '0') || (b === 0)){
        r = '-';
    }

    if ((b === '1') || (b === 1)){
        r = 'X';
    }

    return r;

}


function getNumberArray(){
    return ["1","2","3","4","5","6","7","8","9","0"];
}


function checkIfStringIsInteger(s){

    let ok = true;
    const aDigits = getNumberArray();

    if (s.trim().length > 0){
        for(let i = 0; i < s.length; i++) {
            let charToTest = s.substring(i, i+1);
            if (!aDigits.includes(charToTest)) {
                ok = false;
                break;
            }
        }
    }

    return ok;
}


function checkIfStringIsDecimalNumber(s, decSign){

    let ok = true;
    const aDigits = getNumberArray();
    aDigits.push(decSign);
    aDigits.push('-');

    if (s.trim().length > 0){
        for(let i = 0; i < s.length; i++) {
            let charToTest = s.substring(i, i+1);
            if (!aDigits.includes(charToTest)) {
                ok = false;
                break;
            }
        }
    }

    return ok;
}


function checkIfStringIsZero(s){

    let ok = true;
    const aDigits = ["0"];

    if (s.trim().length > 0){
        for(let i = 0; i < s.length; i++) {
            let charToTest = s.substring(i, i+1);
            if (!aDigits.includes(charToTest)) {
                ok = false;
                break;
            }
        }
    }

    return ok;
}


function mgGetDecimalPortionFromNumberString(s){

    /* assuming a checked proper number here, with a decimal sign, either , or . */
    let lookFor = ',';
    if (s.includes('.')){
        lookFor = '.';
    }
    let from = s.indexOf(lookFor);
    return s.substring(from+1);
}


function mgFormatNumberString(s, v){

    /* assuming a checked proper number here, with a decimal sign, either , or . */
    let lookFor = ',';
    if (s.includes('.')){
        lookFor = '.';
    }
    return s.replace(lookFor, v.language.decSign);

}


function mgGetIntegerPart(s){

    /* assuming a checked proper number here, with a decimal sign, either , or . */
    let lookFor = ',';
    if (s.includes('.')){
        lookFor = '.';
    }

    return s.substring(0, s.indexOf(lookFor));

}


function mgPolishNumberString(s, bodmin){

    let decPart = mgGetDecimalPortionFromNumberString(s);
    if (checkIfStringIsZero(decPart)){
        s = mgGetIntegerPart(s);
    } else {
        s = mgFormatNumberString(s, bodmin);
    }

    return s;

}


function getNbSp(n){

    let s = '';
    for (let i = 0; i < n; i++) {
        s += String.fromCharCode(160);
    }

    return s;
}


function mgNbSp(){
    return String.fromCharCode(160);
}


function getNumberWithDelimiters(v, intAsString){

    const i = parseInt(intAsString);
    return i.toLocaleString(v.language.locale);

}


function mgValidateMin(value, placeHolderWithMinAndMax){

    let ok = true;

    let min = mgGetMin(placeHolderWithMinAndMax);
    if (min !== 'X'){
      min = parseFloat(min);
      value = parseFloat(value);
      ok = (value >= min);
    }

    return ok;

}


function mgValidateMax(value, placeHolderWithMinAndMax){

    let ok = true;

    let max = mgGetMax(placeHolderWithMinAndMax);
    if (max !== 'X'){
      max = parseFloat(max);
      value = parseFloat(value);
      ok = (value <= max);
    }

    return ok;

}


function mgGetMin(placeHolderWithMinAndMax){

    let min = 'X';
    let space = placeHolderWithMinAndMax.indexOf(' ');
    if (space !== '-1') {
        min = placeHolderWithMinAndMax.substring(0, space);
    }

    return min;

}


function mgGetMax(placeHolderWithMinAndMax){

    let value = 'X';
    let space = placeHolderWithMinAndMax.lastIndexOf(' ');
    if (space !== '-1') {
        value = placeHolderWithMinAndMax.substring(space);
    }

    return value;

}


function mgGetProperDecimalSignString(s){

    if (s.indexOf(',') !== '-1'){
        s = s.replace(',', '.');
    }

    return s;

}


function mgToTitleCase(str) {
    return str.replace(
        /\w\S*/g,
        function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        }
    );
}


function mgToLocaleString(s, v){

    let answer = Number(s).toLocaleString();
    if (v.language.current === '2') {
        answer = answer.replace('.', v.language.thousandSeparator);
    }

    return answer;
}


function resolveLanguage(v){
    v.language.current = '1';
    if (v.language.metaLang.attr('content') === 'sv'){
        v.language.current = '2';
    }
}


function getDateFromYMDString(ymdString){

    const a = ymdString.split('-')
    let year = parseInt(a[0]);
    let month = parseInt(a[1])-1;
    let day = parseInt(a[2]);
    return new Date(year, month, day);

}


function getDateTexts(sLanguage){
    /*
    return four arrays with months, weekdays names (long/short) and day suffix texts grouped below dateTexts.
     */

    let dateTexts = {}

    // E N G E L S K A
    if (sLanguage === '1') {

        dateTexts = {

            daySuffixes : [
                ' of',
                'st',
                'nd',
                'rd',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'st',
                'nd',
                'rd',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'th',
                'st',
            ],
            weekdays : [
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday'
            ],
            weekDaysShort : [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],

            months : ['january', 'february', 'march', 'april',  'may', 'june', 'july',
                      'august', 'september', 'october', 'november', 'december' ]

        }

    }

    // S V E N S K A
    if (sLanguage === '2') {

        dateTexts = {

            daySuffixes : [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            weekdays : [
                'söndag',
                'måndag',
                'tisdag',
                'onsdag',
                'torsdag',
                'fredag',
                'lördag'
            ],
            weekDaysShort : [ "sö", "må", "ti", "on", "to", "fr", "lö" ],

            months : ['januari', 'februari', 'mars', 'april',  'maj', 'juni', 'juli',
                'augusti', 'september', 'oktober', 'november', 'december' ]

        }

    }

    return dateTexts;

}


function getFormattedDate(ymdString, v){

    const ydmTo = ymdString.split("-");
    const year = ydmTo[0];
    const month = parseInt(ydmTo[1]);
    const day = parseInt(ydmTo[2]);

    // we need the week-day as well, thus..
    const d = new Date(ymdString);
    const weekdayNo = d.getDay();  // 0-6



    const monthName = v.language.dateTexts.months[month-1];
    let dayName = v.language.dateTexts.weekdays[weekdayNo];

    if(v.language.current === '1'){
       dayName = v.language.dateTexts.weekDaysShort[weekdayNo];
    }
    //const daySuffixTwo = v.language.dateTexts.daySuffixes[0];
    //const daySuffixOne = v.language.dateTexts.daySuffixes[day];

    // Wednesday, 5th of November, 2020
    // Onsdag 12 maj 2012
    //return dayName + ' ' + day + daySuffixOne + daySuffixTwo + ' ' + monthName + ' ' + year;
    return dayName + ' ' + day + ' ' + monthName + ' ' + year;
}


function getDateAsYMDString(d){

    let year = d.getFullYear();
    let month = ("0" + (d.getMonth() + 1)).slice(-2);
    let day = ("0" + (d.getDate())).slice(-2);
    return  year + '-' + month + '-' + day;

}


function getNowAsDateTimeString(){

    const d = new Date();
    const year = d.getFullYear();
    const month = ("0" + (d.getMonth() + 1)).slice(-2);
    const day = ("0" + (d.getDate())).slice(-2);
    const hour = ("0" + (d.getHours())).slice(-2);
    const minute = ("0" + (d.getMinutes())).slice(-2);
    const second = ("0" + (d.getSeconds())).slice(-2);
    let answer = year + '-' + month + '-' + day;
    answer += ' ' + hour + ':' + minute + ':' + second;
    return answer;

}


function getNowAsYMD(){

    let d = new Date();
    return getDateAsYMDString(d);

}


function isDayMigrationCountDay(date){

    let dayAndMonth = date.substring(5);

    let startDay = '08-01';
    let endDay =  '11-20';

    return ((dayAndMonth >= startDay) && (dayAndMonth <= endDay))

}


function getOnGoingSeasons(pageData){

    const testDate = '1000-' + pageData.newsData.DATE.substring(5);

    const seasonsInfo = pageData.seasonData;
    let ongoingSeasons = [];

    const l = seasonsInfo.length;
    for (let i = 0; i < l; i++) {

        let thisSeason = [];
        thisSeason.push(seasonsInfo[i]['workSchemeData']);
        thisSeason.push(seasonsInfo[i]['ringingData']);


        if ((testDate >= thisSeason[0].STARTDUMMYDATE) && (testDate <= thisSeason[0].ENDDUMMYDATE)){
            ongoingSeasons.push(thisSeason);
        }

    }

    return ongoingSeasons;
}


function isDayStandardRingingDay(ymdDate){

    const dayAndMonth = ymdDate.substring(5);

    const startDaySpring = '03-21';
    const endDaySpring =  '06-10';

    const startDayFall = '07-21';
    const endDayFall =  '11-10';

    return (((dayAndMonth >= startDaySpring) && (dayAndMonth <= endDaySpring)) || ((dayAndMonth >= startDayFall) && (dayAndMonth <= endDayFall)));

}


function getDaysToSeasonStartText(lang, dateAsYMD){

    // This function expects dateAsYMD to be a non-season day, either in the summer or autumn/winter
    // It calculates the number of days until the next season starts and returns a nicely formatted text.
    let thisYear = parseInt(dateAsYMD.substr(0,4));
    let thisMonth = dateAsYMD.substr(5,2);
    if (thisMonth === '11' || thisMonth === '12'){
        // the next season starts next year
        thisYear = thisYear + 1;
    }

    let nextStartMonthDay = '-03-21';
    if (thisMonth === '06' || thisMonth === '07'){
        nextStartMonthDay = '-07-21';
    }

    const nextStartingDate = getDateFromYMDString(thisYear.toString() + nextStartMonthDay);
    const dateCurrent = getDateFromYMDString(dateAsYMD);
    const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds

    const days = Math.round(Math.abs((nextStartingDate - dateCurrent) / oneDay));

    let textDays = lang.rDays;
    if (days === 1){
        textDays = lang.rDay;
    }

    return lang.rNextSeason + days.toString() + ' ' + textDays + '.';

}


function getRightTime(timeText, ymdDate){

    const timeOffSet = getDateFromYMDString(ymdDate).getTimezoneOffset();
    let timme = timeText.substring(0,2);
    if (timeOffSet === -120){  // it is "summer" time
        timme = timeText.substring(3,5);
    }

    return timme;

}


function getLanguageAsNo(){

    let codeAsNo = '1';
    let alphaCode = $('#metaLang').attr('content');
    if (alphaCode === 'sv'){
        codeAsNo = '2';
    }

    return codeAsNo;

}



function getFirstCharCapitalized(s){
    return s.substring(0,1).toUpperCase() + s.substring(1);
}


function checkEmailAddress(address){

    let rule = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return rule.test(address);

}


const l = (arg) => console.log(arg);


function clearWarnings(){

    $('.formWarning').text('');
    $('.inputWarning').removeClass('inputWarning');

}


function showHelp(){
    $('#helpInfo').toggleClass('mg-hide-element', false);
}


function showHelpIfItExists(v){

    $.ajax({
        type:"GET",
        async: true,

        url: "/aahelpers/getHelp.php?language=" + v.language.current + '&module=' + v.currentModule,
        success: function(data) {

            let help = JSON.parse(data);
            let l = help.length;
            let html = '';
            if (l > 0){

                html += '<div>';
                html += '<a href="#" onclick="showHelp();return false;" title="Click to see available help"><img src="/bodmin/img/help/boj2.png" alt="livboj" id="helpImg"/></a>'
                html += '</div>';
                html += '<div id="helpInfo" class="mg-hide-element">';

                for (let i = 0; i < l; i++) {
                    html += '<a href="' + help[i].URL + '" target="_blank">' + help[i].TEXT + '</a><br/>';
                }

                html += '</div>';


                v.controlPanel.ui.help.toggleClass('mg-hide-element', false);
                v.controlPanel.ui.help.empty();
                v.controlPanel.ui.help.append(html);

            }

        }
    });



}


function formatTemperature(s, v){

    let prefix = '';
    if (parseFloat(s) > 0){
        prefix = '+';
    }
    s = formatNo(s, v, 1);
    return prefix + s;

}


function getWindChillValue(t, w){

    let answer = "-----";
    if (t <= 10.0) {
        let windC = Math.pow(w, 0.16);
        let c = (13.12 + (0.6215 * t) - 13.956 * windC + 0.48669 * t * windC) * 10;
        answer = Math.round(c) / 10;
    }

    return answer;
}


function formatTemperatureValueAsString(v, t){

    let tAsFloat = parseFloat(t);
    let tAsString = tAsFloat.toLocaleString(v.language.locale);
    let prefix = '';
    if ((tAsFloat) > 0){
        prefix = '+';
    }
    if ((tAsFloat) === 0){
        prefix = '±';
    }

    return prefix + tAsString;

}


function formatNo(string, v, dec){

    let sAsFloat = parseFloat(string);
    return sAsFloat.toLocaleString(v.language.locale, {
        minimumFractionDigits: dec,
        maximumFractionDigits: dec
    })

}


function formatSikt(s, v){

    let sAsFloat = parseFloat(s);

    if (sAsFloat < 5){
        return sAsFloat.toLocaleString(v.language.locale, {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        })

    } else {
        return sAsFloat.toLocaleString(v.language.locale, {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        })
    }

}


function getCurrentRecordId(v){
    return v.mainTableId;
}


function handleRowSelection(v){

    if (v.selectedRow.hasClass('mg-table-row-data')){
        v.selectedRow = v.selectedRow.prev();
    }

    v.selectedRow.siblings().removeClass('table-active');
    v.selectedRow.addClass('table-active');
    $('#data tr.mg-table-row-data').addClass('mg-hide-element');
    v.selectedRow.next().removeClass('mg-hide-element');

    $('.editButton').prop('disabled', false);

    v.mainTableId = v.selectedRow.attr('id');
    v.name = $(v.selectedRow).find("td").eq(0).text();

    v.controlPanel.ui.infoLabel.text(v.controlPanel.language.infoLabelVald) ;
    v.controlPanel.ui.infoSelectedRecord.text( v.name ) ;

}


function filterTable(filterWith){

    let needle = filterWith

    $("#data tbody tr").filter(function() {
        let hay = $(this).text();
        let currentRow = $(this);

        if (currentRow.hasClass('mg-table-row-data')){
            // The parent row this data belongs to may be filtered out. Hide it.
            currentRow.toggleClass('mg-hide-element', true);
        } else {
            currentRow.toggle(mgCheckFilterString(hay, needle));
        }

    });

}


function setEditButtonsOnOff(v){

    $('.editButton').prop('disabled', true);
    v.controlPanel.ui.infoPermissions.toggleClass('mg-hide-element', true);

    // if not sufficient permissions hide the buttons altogether - at least for now!
    $.ajax({
        type:"get",
        async: false,
        url: "../users/getUserModulePermission.php?userId=" + $('#loggedInUserId').text() + "&moduleId=9",
        success: function(data) {

            let obj = JSON.parse(data);
            let permission = obj[0].PERMISSION_ID;

            if (permission < 5) {
                v.controlPanel.ui.infoLabel.toggleClass('mg-hide-element', true);
                v.controlPanel.ui.infoSelectedRecord.toggleClass('mg-hide-element', true);

                $('.editButton').hide();
                v.controlPanel.ui.btnNew.hide();
                v.controlPanel.ui.infoPermissions.toggleClass('mg-hide-element', false);
                v.controlPanel.ui.infoPermissions.text(v.language.noPermission);
            }

        }
    });

}


function getWebShopHeader(){

    return '<div class="row horizontal align-items-center gron">\n' +
        '    <div class="col-2 vertical">\n' +
        '        <div class="mb-4 d-flex justify-content-center">\n' +
        '            <a href="fyrshopen.php?sprak=sve"><img src="/bilder/fyrshopen_5x3.jpg" alt="Fyrshoppen logga" width="106" height="80" title="Fyrshopen - utställning och butik i Falsterbo Fyr."></a>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div class="col-8 vertical">\n' +
        '        <div class="mb-1 d-flex justify-content-center">\n' +
        '            <div>\n' +
        '                <h1 class="fboh1 white">Välkommen till SkOFs och Falsterbo Fågelstations webshop</h1>\n' +
        '                <p class="fbop white">SkOFs och Falsterbo Fågelstations verksamheter bygger i hög grad på ideellt arbete med ringa ekonomisk ersättning. <br> Genom att köpa våra böcker, dekaler, vykort m.m. stöder du arbetet för ett\n' +
        '                    starkare fågelskydd i Skåne och den fortsatta verksamheten vid Falsterbo Fågelstation.\n' +
        '                    Du beställer varorna här och betalar mot faktura som medföljer leveransen.\n' +
        '                    Postens avgifter tillkommer.\n' +
        '                </p>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div class="col-2 vertical">\n' +
        '        <div class="mb-2 d-flex justify-content-center mt-3">\n' +
        '            <div class="row horizontal align-items-center">\n' +
        '\n' +
        '                <div class="col-6 vertical">\n' +
        '                    <div class="mb-4 d-flex justify-content-center">\n' +
        '                        <a href="https://www.skof.se" target="_top"><img src="/bilder/skofdekal.png" alt="SkOF dekal"></a>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="col-6 vertical">\n' +
        '                    <div class="mb-4 d-flex justify-content-center">\n' +
        '                        <a href="https://www.falsterbofagelstation.se" target="_top"><img src="/bilder/fbodekal_3d.jpg" width="56" height="81" alt="Fbo dekal"></a>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>'


}


function loadCategoryInformation(v, category){

    v.page.introText.empty();
    v.page.introText.append(mgGetDivWithSpinnerImg());

    $.ajax({
        type:"get",
        async: false,
        url: "/sales/getCategoryIntroduction.php?category=" + category,
        success: function(data) {

            let obj = JSON.parse(data);
            let imgHtml = '<img src="/sales/bilder/' + obj[0].bildmapp + '/' + obj[0].kat_bild + '" class="float-end" alt="Bok illustration">';

            let html =  '   <div class="row horizontal align-items-center">\n' +
                '                <div class="col-8 vertical">\n' +
                '                    <div class="mb-4 d-flex justify-content-center">\n' +
                '                         <div>\n' +
                '                    ' + obj[0].ingr_s +
                '                         </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '                <div class="col-4 vertical">\n' +
                '                    <div class="mb-4 d-flex justify-content-center">\n' +
                '                    ' + imgHtml + '\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>\n'


            v.page.introText.empty();
            v.page.introText.html(html);
        }
    });

}


function capitalizeFirstLetter(string){

    return string.charAt(0).toUpperCase() + string.slice(1);

}



function handleAndFormatNumber(v, n){

    let answer = '-';
    // if it is a number
    if ((!isNaN(n)) && (n != null) ){
        answer = parseInt(n).toLocaleString(v.language.locale)
    }

    return answer;
}


function loadStandardStrackTable(v, node){

    v.ui.page.strackDataHeader.text(v.date.current);

    $.ajax({
        type: "GET",
        url: "getStrackDataForDate.php?date=" + v.date.current + '&language=' + v.language.current,
        success: function (data) {

            let migrationData = JSON.parse(data);

            v.blogDay = {
                dateYMD : v.date.current,
            }

            composeTable(migrationData, v, node)

        }

    });

}


function composeTable(migrationData, v, node){

    let html = '';
    let y = v.blogDay.dateYMD.substring(0,4);
    let md = v.blogDay.dateYMD.substring(5);



    getStrackTableTexts(v);

    let numberOfMigrationData = migrationData.length;

    html = getTableStart();
    html += getStandardStrackDaySumTableHead(v);
    html += '<tbody>';

    let summaDag = 0;
    let summaTot = 0;
    let summaTotMedel = 0;
    let summaTotMin = 0;
    let summaTotMax = 0;

    for ( let i = 0; i < numberOfMigrationData; i++ ) {

        let title = "";
        let intro = v.standardDaySumTable.language.until.substring(0,1).toUpperCase() + v.standardDaySumTable.language.until.substring(1) + ' ' + md + ' ' + v.standardDaySumTable.language.taxa;
        html  += '<tr ' + 'id="' + migrationData[i]['ART'] +'">';
        let link = '<a href="/strack/art-alla-ar?art=' + migrationData[i]['ART'] + '&lang=' + v.language.langAsString + '">';
        html  += '<td class="art">' + link + migrationData[i]['TAXON'] + '</a></td>';
        title = v.standardDaySumTable.language.today + ' ' + md;
        html  += '<td class="no-f" title="' + title + '">' + parseInt(migrationData[i]['TODAY']).toLocaleString(v.language.locale)  + '</td>';
        link = '<a href="/strack/art-ar?art=' + migrationData[i]['ART'] + '&year=' + y + '&lang=' + v.language.langAsString + '">';
        title = intro + " - " + v.standardDaySumTable.language.thisYear.toLowerCase();
        html  += '<td class="no-f" title="' + title + '">' + link + parseInt(migrationData[i]['TOTODAY']).toLocaleString(v.language.locale)  + '</a></td>';
        title = intro + " - " + v.standardDaySumTable.language.min.toLowerCase();
        html  += '<td class="no-f" title="' + title + '">' +  handleAndFormatNumber(v, migrationData[i]['MINI'])  + '</td>';
        title = intro + " - " + v.standardDaySumTable.language.allTimeAverage.toLowerCase();
        html  += '<td class="no-f" title="' + title + '">' +  handleAndFormatNumber(v, migrationData[i]['MEDEL'])  + '</td>';
        title = intro + " - " + v.standardDaySumTable.language.max.toLowerCase();
        html  += '<td class="no-f" title="' + title + '">' +  handleAndFormatNumber(v, migrationData[i]['MAXI'])  + '</td>';
        html  += '</tr>';

        summaDag = addIfPossible( summaDag, migrationData[i]['TODAY'] );
        summaTot = addIfPossible( summaTot, migrationData[i]['TOTODAY'] );
        summaTotMin = addIfPossible( summaTotMin, migrationData[i]['MINI'] );
        summaTotMedel = addIfPossible( summaTotMedel, migrationData[i]['MEDEL'] );
        summaTotMax = addIfPossible( summaTotMedel, migrationData[i]['MAXI'] );


    }

    html  += '<tr>';
    html  += '<td class="summa">' + 'Tot'  + '</td>';
    html  += '<td class="no-f summa">' + summaDag.toLocaleString(v.language.locale)  + '</td>';
    html  += '<td class="no-f summa">' + summaTot.toLocaleString(v.language.locale)  + '</td>';
    html  += '<td class="no-f summa">' + summaTotMin.toLocaleString(v.language.locale)  + '</td>';
    html  += '<td class="no-f summa">' + summaTotMedel.toLocaleString(v.language.locale)  + '</td>';
    html  += '<td class="no-f summa">' + summaTotMax.toLocaleString(v.language.locale)  + '</td>';
    html  += '</tr>';

    html  += '</tbody>';
    html  += '</table>';
    html += '<p class="mt-2 mb-3">' + numberOfMigrationData + ' ' + v.standardDaySumTable.language.antalArter + '</p>';

    node.empty();
    node.append(html);


}


function addIfPossible(number, addition){

    if (typeof(addition) != 'undefined' && addition != null)
    {
        if (!isNaN(parseInt( addition )) ) {
            number += parseInt( addition );
        }

    }

    return number;

}


function getTableStart(){
    return '<table class="table table-striped table-sm table-hover">';
}


function getStandardStrackDaySumTableHead(v){

    const md = v.blogDay.dateYMD.substring(5);
    const year = v.blogDay.dateYMD.substring(0,4);
    const previousYear = new Date().getFullYear() - 1;

    return '     <thead class="thead-light">\n' +
        '        <tr>\n' +
        '            <th rowspan="2" class="align-middle text-center">\n' +
        '                 ' + v.standardDaySumTable.language.migrationData + '\n' +
        '            </th>\n' +
        '            <th rowspan="2" class="align-middle text-center">' +
        '                 ' + v.standardDaySumTable.language.today + '\n' +
        '            </th>\n' +
        '            <th rowspan="2" class="align-middle text-center">\n' +
        '                 ' + year + '<br/>' +  v.standardDaySumTable.language.until + '<br/> ' + md + '\n' +
        '            </th>\n' +
        '            <th colspan="3" class="text-center">\n' +
        '                 ' + v.standardDaySumTable.language.seasons + ' 1973 - '  + previousYear + ' ' + v.standardDaySumTable.language.until + ' ' + md + '<br/> ' + v.standardDaySumTable.language.taxa + '\n' +
        '            </th>\n' +
        '        </tr>\n' +
        '        <tr>\n' +

        '            <th class="text-center">\n' +
        '                 ' + v.standardDaySumTable.language.min + '\n' +
        '            </th>\n' +

        '            <th class="text-center">\n' +
        '                 ' + v.standardDaySumTable.language.allTimeAverage + '\n' +
        '            </th>\n' +
        '            <th class="text-center">\n' +
        '                 ' + v.standardDaySumTable.language.max + '\n' +
        '            </th>\n' +

        '        </tr>\n' +
        '        </thead>'

}


function getStrackTableTexts(v) {

    // E N G E L S K A
    if (v.language.current === '1'){

        v.language.langAsString = 'en';
        v.language.decDelimiter = '.';
        v.language.locale = 'en-US';

        v.standardDaySumTable = {
            language : {
                migrationData : 'Species',
                today : 'Today',
                seasons : 'The seasons',
                until : 'until',
                taxa : '(for these taxa)',
                thisYear : 'This year',
                allTimeAverage : 'Average',
                antalArter : 'species',
                max : 'Max',
                min : 'Min',
            }
        };

    }


    // S V E N S K A
    if (v.language.current === '2') {

        v.language.langAsString = 'sv';
        v.language.decDelimiter = ',';
        v.language.locale = 'sv-SE';

        v.standardDaySumTable = {
            language : {
                migrationData : 'Art',
                today : 'Idag',

                seasons : 'Säsongerna',
                until : 't.o.m.',
                taxa : '(för dessa taxa)',
                thisYear : 'I år',
                allTimeAverage : 'Medel',
                antalArter : 'arter',
                max : 'Som mest',
                min : 'Som minst',
            }
        };

    }


}