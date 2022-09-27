$(document).ready(function(){

    let v = {

        language : {
            current : $('#lang').text(),
        },

        dates : [],         // event dates
        date : {
            current : '',   // selected even date
            getParameter : $('#date').text(),
        },

        ui : {
            page : {
                ringingDateHeader : $('#ringingDateHeader'),
                ringDataSection : $('#ringDataSection'),
            },


        }


    }

    function getTexts() {

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.decDelimiter = '.';
            v.language.locale = 'en-US';

            v.language.ringingTable = {
                taxa : 'Species',
                today : 'Today',
                untilToday : 'Until today',
                thisYear : 'This year',
                allTimeAverage : 'Average',

            };

            v.language.summaryTable = {
                toToday : 'The season until',
                thisYear : 'This year',
                average : 'Average',
                max : 'Max',
                maxTotal : 'Highest total ever',
                taxa : 'Species',
                individuals : 'Today',
                i : 'i',
            };

        }

        // S V E N S K A
        if (v.language.current === '2') {
            v.language.langAsString = 'se';
            v.language.decDelimiter = ',';
            v.language.locale = 'sv-SE';

            v.language.ringingTable = {
                taxa : 'Art',
                today : 'Idag',
                untilToday : 'T.o.m. dagens datum',
                thisYear : 'I år',
                allTimeAverage : 'Medelvärde',
            };


            v.language.summaryTable = {
                toToday : 'Säsongen till och med',
                thisYear : 'I år',
                average : 'Medel',
                max : 'Max',
                maxTotal : 'Högsta<br/>säsong<br/>summan',
                taxa : 'Arter',
                individuals : 'Individer',
                i : 'i',
            };

        }

    }

    getTexts();
    getHeaderTexts();
    setHeaderTexts();


    function loadDays(){

        $.ajax({
            type: "GET",
            url: "getRingingDates.php",
            success: function (data) {
                v.dates = JSON.parse(data);
                v.date.current = getDefaultDate();
                setUpDatePicker();
            }
        });

    }

    function setUpDatePicker(){

        // tie datepicker to navigation panel
        // https://stackoverflow.com/questions/6857025/highlight-dates-in-jquery-ui-datepicker
        // https://stackoverflow.com/questions/389743/in-jquery-ui-date-picker-how-to-allow-selection-of-specific-weekdays-and-disable
        $( '#datepicker' ).datepicker('destroy');
        $( '#datepicker' ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1959:+1", //
            firstDay: 1, // Start with Monday
            defaultDate: getDefaultDate(),
            onSelect: function (date) {
                v.date.current = date;
                window.history.pushState('object or string', 'Title', '/ringmarkning/dagssummor/?date=' + v.date.current);
                composePage();
            },
            beforeShowDay: function(d) {
                let ymd = getDateAsYMDString(d)
                if ( v.dates.find(element => element === ymd) ){
                    return [true, "", ""];
                } else {
                    return [false, "", ""];
                }
            }

        });
        $("div.ui-datepicker").css("font-size", "70%");
        composePage();

    }


    function getDefaultDate(){

        let answer = getDateFromYMDString(v.dates[v.dates.length-1]);
        v.date.current = v.dates[v.dates.length-1];

        if (v.date.getParameter !== ''){
            answer = getDateFromYMDString(v.date.getParameter);
            v.date.current = v.date.getParameter;
        }
        return answer;
    }

    function composePage(){

        v.ui.page.ringDataSection.empty();
        v.ui.page.ringDataSection.append(mgGetDivWithSpinnerImg());

        v.ui.page.ringingDateHeader.text(v.date.current);

        $.ajax({
            type: "GET",
            url: "getAllRingingDataForDate.php?date=" + v.date.current + '&lang=' + v.language.current,
            success: function (data) {
                let ringingPlacesData = JSON.parse(data);

                let numberOfPlaces = ringingPlacesData.length;
                let html = '';

                let z = 0;
                let standardSchemes = ['FA', 'FB', 'FC'];

                for ( let i = 0; i < numberOfPlaces; i++ ) {

                    let place = ringingPlacesData[i];
                    let placeInfo = place['placeInfo'];

                    z = (i+1) % 2;   // add column? Even number of locations not needed
                    if (z !== 0){
                        html += '<div class="container">';
                        html += '<div class="row">';
                    }

                    html += '<div class="col">';

                    html += '<h5>' + placeInfo['PLACE'] + '<br/>' + placeInfo['TYPE'] + '</h5>';

                    html += getTableStart();
                    html += getTableStandardRingingTableHead();
                    html  += '<tbody>';

                    let taxaData = place['ringingData'];
                    let antalTaxa = taxaData.length;
                    let summaDag = 0;

                    for (let j = 0; j < antalTaxa; j++) {

                        html  += '<tr>';
                        html  += '<td class="art">' + taxaData[j]['ART']  + '</td>';
                        html  += '<td class="no-f">' + formatNo(taxaData[j]['SUMMA'], v, 0)   + '</td>';
                        html  += '<td class="no-f">' + formatNo(taxaData[j]['SUBTOT'], v, 0)  + '</td>';
                        html  += '<td class="no-f">' + formatNo(taxaData[j]['medelv'], v, 0)  + '</td>';
                        html  += '</tr>';

                        summaDag += parseInt( taxaData[j]['SUMMA'] );

                    }

                    html  += '<tr>';
                    html  += '<td>' + 'Tot'  + '</td>';
                    html  += '<td class="no-f summa">' + formatNo(summaDag, v, 0)  + '</td>';
                    html  += '<td>' + ' '  + '</td>';
                    html  += '<td>' + ' '  + '</td>';
                    html  += '</tr>';

                    html  += '</tbody>';
                    html  += '</table>';


                    if (standardSchemes.includes(placeInfo.TEXT_CODE)) {
                        html += '<div class="" id="' + placeInfo.TEXT_CODE + '">' + mgGetDivWithSpinnerImg() + '</div>';
                        html  += '</div>';
                    }

                    if ((z !== 0) && (i === (numberOfPlaces-1))) {
                        // The last table just added to the page,
                        // but we have to add an empty column, as only one col present in this row
                        html += '<div class="col">&nbsp;</div>';
                    }




                }

                v.ui.page.ringDataSection.empty();
                v.ui.page.ringDataSection.append(html);

                for ( let i = 0; i < numberOfPlaces; i++ ) {

                    let place = ringingPlacesData[i];
                    placeInfo = place['placeInfo'];

                    if (standardSchemes.includes(placeInfo.TEXT_CODE)) {
                        createSeasonSummaryTable(placeInfo.TEXT_CODE);
                    }

                }


            }

        });

    }

    function getTableStart(){

        return '<table class="table table-striped table-sm table-hover">';

    }


    function getSeasonSummaryTableHead(){

        return '     <thead class="thead-light">\n' +
            '        <tr>\n' +
            '            <th rowspan="2" class="align-middle text-center">\n' +
            ' ' +
            '            </th>\n' +
            '            <th colspan="3" class="align-middle text-center">\n' +
            v.language.summaryTable.toToday + ' ' + v.date.current.substring(5) + '\n' +
            '            </th>\n' +
            '            <th rowspan="2" class="text-center align-middle">\n' +
            v.language.summaryTable.maxTotal + '\n' +
            '            </th>\n' +
            '        </tr>\n' +

            '        <tr>\n' +
            '            <th>\n' +
            v.language.summaryTable.thisYear + '\n' +
            '            </th>\n' +
            '            <th>\n' +
            v.language.summaryTable.average + '\n' +
            '            </th>\n' +
            '            <th>\n' +
            v.language.summaryTable.max + '\n' +
            '            </th>\n' +
            '        </tr>\n' +
            '        </thead>';

    }


    function createSeasonSummaryTable(place){

        let html = '';
        let url = "getSeasonSummary.php?D=" + v.date.current + '&P=' + place;

        console.log(url);

        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {

                let summaryData = JSON.parse(data);

                html = getTableStart();
                html += getSeasonSummaryTableHead();


                html += '<tr>\n' +
                    '            <td>\n' +
                    v.language.summaryTable.taxa +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['taxa']['totalToToday'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['taxa']['averageToToday'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['taxa']['maxToToday'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['taxa']['allTimeMax'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '        </tr>\n' +

                    '<tr>\n' +
                    '            <td>\n' +
                    v.language.summaryTable.individuals +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['individuals']['totalToToday'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['individuals']['averageToToday'], v, 0 ) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['individuals']['maxToToday'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '            <td class="text-right">\n' +
                    formatNo(summaryData['individuals']['allTimeMax'], v, 0) + getNbSp(2) + '\n' +
                    '            </td>\n' +
                    '        </tr>\n';

                html += '</table>';

                let summarySection = $('#' + place);
                summarySection.empty();
                summarySection.append(html);

            }
        });


    }


    function getTableStandardRingingTableHead(){

        return '     <thead class="thead-light">\n' +
            '        <tr>\n' +
            '            <th rowspan="2" class="align-middle text-center">\n' +
                            v.language.ringingTable.taxa + '\n' +
            '            </th>\n' +
            '            <th rowspan="2" class="align-middle text-center">\n' +
                            v.language.ringingTable.today + '\n' +
            '            </th>\n' +
            '            <th colspan="2" class="text-center">\n' +
                            v.language.ringingTable.untilToday + '\n' +
            '            </th>\n' +
            '        </tr>\n' +
            '        <tr>\n' +
            '            <th class="text-center">\n' +
                            v.language.ringingTable.thisYear + '\n' +
            '            </th>\n' +
            '            <th class="text-center">\n' +
                            v.language.ringingTable.allTimeAverage + '\n' +
            '            </th>\n' +
            '        </tr>\n' +
            '        </thead>'


    }

    loadDays();


});