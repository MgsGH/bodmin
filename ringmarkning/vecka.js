$(document).ready(function(){

    let v = {
        dataArea : $('#dataArea'),
        dataTabs : $("#dataTabs"),

        lang : {
            current : $('#lang').text(),
        },

        date : {
            current : '',
        },

        ui : {
            pageHeader : $('#pageHeader'),
        }
    }

    function getTexts() {

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';
            v.lang.decDelimiter = '.';
            v.lang.locale = 'en-US';

            v.lang.pageHeader = 'Most recent seven days';
            v.lang.noSeasonDisclaimer = 'No active season at the moment.';



        }


        // S V E N S K A
        if (v.lang.current === '2') {
            v.lang.langAsString = 'se';
            v.lang.decDelimiter = ',';
            v.lang.locale = 'sv-SE';

            v.lang.pageHeader = 'Senaste sju dagarna';
            v.lang.noSeasonDisclaimer = 'Ingen aktiv säsong för stunden.';

        }

    }

    function setTexts(){

        v.ui.pageHeader.text(v.lang.pageHeader);

    }

    function loadData(){

        v.date.current = getNowAsYMD();

        console.log(v.date.current);

        // get dates with ringing entries, for populating the calender
        $.ajax({
            type:"GET",
            async: true,
            url: "getSevenDaysData.php?language=" + v.lang.current + "&date=" + v.date.current,
            success: function(data) {

                let ringingData = JSON.parse(data);
                let html = '<h3>' + v.lang.noSeasonDisclaimer + '</h3>';

                if (ringingData.length === 0) {
                    v.dataArea.empty();
                    v.dataArea.append(html);
                } else {

                    // create tabs section
                    let tabHtml = '      <div id="dataTabs">\n' +
                        '          <ul>'
                    for (let i = 0; i < ringingData.length; i++){
                        let thisSeason = ringingData[i]["season"];
                        tabHtml = tabHtml + '<li><a href="#' + 'tab' + thisSeason["TEXT_CODE"] + '"><span id="' + thisSeason["TEXT_CODE"] + '">' + thisSeason["TEXT"] + '</span></a></li>';

                    }

                    tabHtml = tabHtml + '</ul>';

                    html = tabHtml;
                    for (let i = 0; i < ringingData.length; i++){
                        let fields = ringingData[i]["fields"];
                        let thisSeason = ringingData[i]["season"];
                        html = html + '<div id="tab' + thisSeason["TEXT_CODE"] + '">';
                        html = html + '<table class="table table-striped table-sm table-hover">\n' +
                                                      '   <tr>';
                        html = html + '<th>' + 'Art' + '</th>';
                        for (let f = 3; f < fields.length-4; f++) {
                            html = html + '<th>' + fields[f] + '</th>';

                        }
                        html = html + '<th class="text-center">' + '7-tot' + '</th>';
                        html = html + '<th class="text-center">' + 'S-tot' + '</th>';
                        html = html + '<th class="text-center">' + 'S-mv' + '</th>';
                        html = html + '<th class="text-center">' + 'i100' + '</th>';

                        html = html + '  </tr>\n';

                        let allSpecies = ringingData[i]["data"];

                        for (let s = 0; s < allSpecies.length; s++){
                            html = html + '<tr>';
                            html = html + '<td>' + allSpecies[s]['NAMN'] + '</td>';

                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[3]]) + '</td>';  // 1
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[4]]) + '</td>';  // 2
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[5]]) + '</td>';  // 3
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[6]]) + '</td>';  // 4
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[7]]) + '</td>';  // 5
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[8]]) + '</td>';  // 6
                            html = html + '<td class="no-s">' + formatNoIfZero(allSpecies[s][fields[9]]) + '</td>';  // 7

                            html = html + '<td class="no-s">' + allSpecies[s]['VTOT'] + '</td>';
                            html = html + '<td class="no-s">' + allSpecies[s]['STOT'] + '</td>';
                            html = html + '<td class="no-s">' + allSpecies[s]['SMV'] + '</td>';
                            html = html + '<td class="no-s">' + allSpecies[s]['I100'] + '</td>';

                            html = html + '</tr>';
                        }
                        html = html + '  </table>\n';
                        html = html + '  </div>';



                    }

                    html = html + '  </div><br/><br/>';
                    v.dataArea.empty();
                    v.dataArea.append(html);
                    $('#dataTabs').tabs();

                }


            },


        });

    }


    function plugInSpinner(){
        v.dataArea.append(mgGetDivWithSpinnerImg());
    }


    function formatNoIfZero(i){
        let answer = i;
        if (i === '0'){
            answer = '-'
        }

        return answer;
    }

    getTexts();
    setTexts();
    getHeaderTexts();
    setHeaderTexts();
    plugInSpinner();
    loadData();


});