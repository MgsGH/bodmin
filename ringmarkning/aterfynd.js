$(document).ready(function(){


    // https://ourcodeworld.com/articles/read/269/top-7-best-range-input-replacement-javascript-and-jquery-plugins
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html
    // https://www.jqueryscript.net/demo/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/
    // https://www.jqueryscript.net/form/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect.html
    // https://select2.org/

    // v.ui.taxaDropDown.change main starting point below.
    // approx 342


    let v = {
        dataArea : $('#dataArea'),
        dataTabs : $("#dataTabs"),
        language : {
            metaLang : $("#metaLang"),
            current : $('#lang').text(),
        },
        taxon : {
            current : '',
            sexable : '',
            aFilterYears : [],
            maxTime : 0,
            maxDistance : 42,
        },

        ui : {
            // text ids - for setting texts depending on language
            mainHeader : $('#mainHeader'),
            labelSelectTaxa : $('#labelSelectTaxa'),
            labelFilter : $('#labelFilter'),

            cardHeaderRinged : $('#cardHeaderRinged'),
            labelRingedYears : $('#labelRingedYears'),
            labelRingedMonths : $('#labelRingedMonths'),
            labelRingedAge : $('#labelRingedAge'),
            labelRingedSex : $('#labelRingedSex'),

            cardHeaderRecoveries : $('#cardHeaderRecoveries'),
            labelRecoveriesYears : $('#labelRecoveriesYears'),
            labelRecoveriesMonths : $('#labelRecoveriesMonths'),
            labelRangeDistance : $('#labelRangeDistance'),
            labelRangeTime : $('#labelRangeTime'),

            tabHeaderList  : $('#tabHeaderList'),
            tabHeaderSummary : $('#tabHeaderSummary'),
            tabHeaderMap : $('#tabHeaderMap'),
            tabHeaderGoodToKnow : $('#tabHeaderGoodToKnow'),

            tabListRingingData : $('#tabListRingingData'),
            tabListRecoveryData : $('#tabListRecoveryData'),

            // controls
            taxaDropDown : $('#slcttaxa'),

            // ringing data tuning section
            slctRingingYears : $('#slctRingingYears'),
            slctRingingMonths : $('#slctRingingMonths'),
            slctage : $('#slctage'),
            slctsex : $('#slctsex'),
            labelInputTime : $('#labelInputTime'),
            labelInputDistance : $('#labelInputDistance'),

            // recoveries tuning section
            slctRecoveryYears        : $('#slctRecoveryYears'),
            slctRecoveryMonths       : $('#slctRecoveryMonths'),

            inputDistance            : $('#inputDistance'),
            sliderDistance           : $('#sliderDistance'),
            sliderDistanceMaxValue   : $('#sliderDistanceMaxValue'),
            sliderDistanceMinValue   : $('#sliderDistanceMinValue'),

            inputTime                : $('#inputTime'),
            sliderTime               : $('#sliderTime'),
            sliderTimeMaxValue       : $('#sliderTimeMaxValue'),
            sliderTimeMinValue       : $('#sliderTimeMinValue'),

            // data sections below
            // tabs
            tabMap                   : $('#tabMap'),

            // summary tab
            rmTot                   : $('#rmTot'),
            rmProcent               : $('#rmProcent'),

            // list tab
            tableRecoveries : $('#tableRecoveries'),
            avstandsLista : $('#avstandsLista'),

            tidsLista : $('#tidsLista'),
            sexDropDownSection : $('#sexDropDownSection'),

            // meta data section
            dataMetaHeader : $('#dataMetaHeader'),
            totRecoveries  : $('#totRecoveries'),

            taxonGrandTotal         : $('#taxonGrandTotal'),
            taxonGrandTotalOne      : $('#taxonGrandTotalOne'),
            taxonGrandTotalTwo      : $('#taxonGrandTotalTwo'),

            filteringHeader         : $('#filteringHeader'),
            filteringSuffix         : $('#filteringSuffix'),
            rmFilterTot             : $('#rmFilterTot'),
            rmFilterPercent         : $('#rmFilterProcent'),

            distanceListHeader      : $('#distanceListHeader'),
            timeListHeader          : $('#timeListHeader'),

        },
    }


    function setLangTexts(){

        // E N G E L S K A
        if (v.language.current === '1'){
            v.language.langAsString = 'en';
            v.language.localeString = 'en_GB';
            v.language.thousandSeparator = '.';

            v.ui.lang = {
                // multi-select drop downs
                ddAll                       : 'All',
                ddBoth                      : "Both",
                ddMonthsAll                 : "Whole year",
                ddMonthsNoMonthsSelected    : " selected",
                ddMonthsNonSelectedText     : "Select",
                textAlla                    : "All",
                textInget                   : "None",
                textInga                    : "None",
                textSelectAll               : " Select all",

                mainHeader                  : "Recoveries",
                labelSelectTaxa             : "Select a ringed and recovered species or sub-species",
                labelFilter                 : "Filter data",

                cardHeaderRinged            : "Ringing circumstances",
                labelRingedYears            : "Years",
                labelRingedMonths           : "Months",
                labelRingedAge              : "Ages",
                labelRingedSex              : "Sexes",

                cardHeaderRecoveries        : "Recovery circumstances",
                labelRecoveriesYears        : "Years",
                labelRecoveriesMonths       : "Months",
                labelRangeDistance          : "Distance",
                labelRangeTime              : "Time",
                labelInputTime              : "Time interval",
                labelInputDistance          : "Distance interval",

                tabHeaderList               : "List",
                tabHeaderSummary            : "Summary",
                tabHeaderMap                : "Map",
                tabHeaderGoodToKnow         : "Good to know",

                tabListRingingData          : 'Ringed',
                tabListRecoveryData         : 'Found',
                days                        : ' days',

                // data tabs
                // summary
                taxonGrandTotal             : 'Overall',
                taxonGrandTotalTextOne      : ' banded/ringed, generating ',
                taxonGrandTotalTextTwo      : ' recoveries (including local recoveries).',
                filteringHeader             : 'Recoveries subject to filtering as above',
                filteringSuffix             : ' recoveries.',

                distanceListHeader          : 'Most faraway finds',
                timeListHeader              : 'Longest elapsed time ',

            };

            v.language.mapPopUp = {
                caught                       : 'Caught ',
                as                           : ' as ',
                recovered                    : 'Recovered ',
                in                           : ' in ',
                elapsedTime                  : 'Elapsed time: ',
                elapsedTimeUnknown           : 'Recovery date uncertain, thus, elapsed time not given.',
                days                         : ' days.',
                distance                     : 'Distance: ',
                distanceUnit                 : ' kilometers.',
            }

        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.langAsString = 'se';
            v.language.localeString = 'sv_SE';
            v.language.thousandSeparator = ' ';

            v.ui.lang = {
                // multi-select drop downs
                ddAll                       : 'Alla',
                ddBoth                      : "Båda",
                ddMonthsAll                 : "Hela året",
                ddMonthsNoMonthsSelected    : " valda",
                ddMonthsNonSelectedText     : "Välj",
                textAlla                    : "Alla",
                textInget                   : "Inget",
                textInga                    : "Inget",
                textSelectAll               : " Välj alla",

                mainHeader                  : "Återfynd",
                labelSelectTaxa             : "Välj ringmärkt och återfunnen art eller underart",
                labelFilter                 : "Filtrera data",

                cardHeaderRinged            : "Märkdata",
                labelRingedYears            : "År",
                labelRingedMonths           : "Månader",
                labelRingedAge              : "Ålder",
                labelRingedSex              : "Kön",

                cardHeaderRecoveries        : "Återfyndsdata",
                labelRecoveriesYears        : "År",
                labelRecoveriesMonths       : "Månader",
                labelInputTime              : "Tidsintervall",
                labelInputDistance          : "Avståndsintervall",

                tabHeaderList               : "Lista",
                tabHeaderSummary            : "Sammanställning",
                tabHeaderMap                : "Karta",
                tabHeaderGoodToKnow         : "Bra att veta",

                tabListRingingData          : 'Märkt',
                tabListRecoveryData         : 'Återfynd',

                days                        : ' dagar',

                // data tabs
                // summary
                taxonGrandTotal             : 'Totalt',
                taxonGrandTotalTextOne      : ' ringmärkta, dessa har gett ',
                taxonGrandTotalTextTwo      : ' återfynd (inklusive lokala fynd).',

                filteringHeader             : 'Återfynd efter filtrering enligt ovan',
                filteringSuffix             : ' av alla återfynd.',


                distanceListHeader          : 'Mest långväga fynd',
                timeListHeader              : 'Största tidsintervall',

            };

            v.language.mapPopUp = {
                caught                       : 'Fångad ',
                as                           : ' som ',
                recovered                    : 'Funnen ',
                in                           : ' i ',
                elapsedTime                  : 'Förfluten tid: ',
                elapsedTimeUnknown           : 'Fynddatum osäkert, förfluten tid anges ej.',
                days                         : ' dagar.',
                distance                     : 'Avstånd: ',
                distanceUnit                 : ' kilometer.',
            }
        }

        v.ui.mainHeader.text(v.ui.lang.mainHeader);
        v.ui.labelSelectTaxa.text(v.ui.lang.labelSelectTaxa);
        v.ui.labelFilter.text(v.ui.lang.labelFilter);

        v.ui.cardHeaderRinged.text(v.ui.lang.cardHeaderRinged);
        v.ui.labelRingedYears.text(v.ui.lang.labelRingedYears);
        v.ui.labelRingedMonths.text(v.ui.lang.labelRingedMonths);
        v.ui.labelRingedAge.text(v.ui.lang.labelRingedAge);
        v.ui.labelRingedSex.text(v.ui.lang.labelRingedSex);

        v.ui.cardHeaderRecoveries.text(v.ui.lang.cardHeaderRecoveries);
        v.ui.labelRecoveriesYears.text(v.ui.lang.labelRecoveriesYears);
        v.ui.labelRecoveriesMonths.text(v.ui.lang.labelRecoveriesMonths);

        v.ui.labelInputTime.text(v.ui.lang.labelInputTime);
        v.ui.labelInputDistance.text(v.ui.lang.labelInputDistance);

        v.ui.tabHeaderList.text(v.ui.lang.tabHeaderList);
        v.ui.tabHeaderSummary.text(v.ui.lang.tabHeaderSummary);
        v.ui.tabHeaderMap.text(v.ui.lang.tabHeaderMap);
        v.ui.tabHeaderGoodToKnow.text(v.ui.lang.tabHeaderGoodToKnow);

        v.ui.tabListRingingData.text(v.ui.lang.tabListRingingData);
        v.ui.tabListRecoveryData.text(v.ui.lang.tabListRecoveryData);

        // data tabs
        // summary tab
        v.ui.taxonGrandTotal.text(v.ui.lang.taxonGrandTotal);
        v.ui.taxonGrandTotalOne.text(v.ui.lang.taxonGrandTotalTextOne);
        v.ui.taxonGrandTotalTwo.text(v.ui.lang.taxonGrandTotalTextTwo);
        v.ui.timeListHeader.text(v.ui.lang.timeListHeader);
        v.ui.distanceListHeader.text(v.ui.lang.distanceListHeader);
        v.ui.filteringHeader.text(v.ui.lang.filteringHeader);
        v.ui.filteringSuffix.text(v.ui.lang.filteringSuffix);

    }


    function populateDropDowns(){

        // m o n t h s
        $.ajax({
            type: "get",
            url: "../api/getMonths.php?lang=" + v.language.current,
            success: function (data) {

                let months = JSON.parse(data);
                v.ui.months = [];

                for (let i = 0; i < months.length; i++) {
                    let option = {};

                    let label = 'label';
                    option[label] = months[i].TEXT;

                    let title = 'title'
                    option[title] = months[i].TEXT;

                    let value = 'value'
                    option[value] = months[i].MONTHNO;

                    let selected = 'selected'
                    option[selected] = true;
                    v.ui.months.push(option);

                }

                v.ui.slctRingingMonths.multiselect({
                    includeSelectAllOption: true,
                    buttonWidth: '100px',
                    nonSelectedText: 'Välj månader'
                });
                v.ui.slctRingingMonths.multiselect('dataprovider', v.ui.months);

            }
        });
    }


    v.ui.taxaDropDown.change(function() {
        v.taxon.current = v.ui.taxaDropDown.val();
        let t = $("#slcttaxa option:selected").text();
        v.ui.dataMetaHeader.text(t);
        loadDataForTaxa();
    });


    function loadDataForTaxa(){

        v.ui.tableRecoveries.empty();

        const s = '<tr><td colspan="2">' +
            mgGetImgSpinner() +
            '</td></tr>'
        v.ui.tableRecoveries.append(s);

        // Recovery data for taxa
        $.ajax({
            type: "get",
            url: "../api/getRecoveries.php?taxon=" + v.taxon.current,
            success: function (data) {

                v.taxon.allRecoveries = JSON.parse(data);

                // recode unset sex, age -> 'x'
                reCodeAgeAndSex();

                // reset all selects controls to data *in* the current data set
                checkRingingYearsForCurrentTaxa();
                checkRingingMonthsForCurrentTaxa();
                checkRingingAgesForCurrentTaxa()
                checkRingingSexesForCurrentTaxa();

                checkRecoveryYearsForCurrentTaxa();
                checkRecoveryMonthsForCurrentTaxa();

                v.ui.totRecoveries.text( v.taxon.allRecoveries.length );
                reLoadMainTable(v.taxon.allRecoveries);

                getDistanceAsHTML(v.taxon.allRecoveries, v);
                getTimeAsHTML(v.taxon.allRecoveries, v);

                setSliderValues();
                getTotalNumberOfRingedBirds();
                filterData();

                v.taxon.dataloaded = true;

            },

        });

    }

    function reCodeAgeAndSex(){

        for (let i = 0; i < v.taxon.allRecoveries.length; i++){

            if (v.taxon.allRecoveries[i].MAGE === "") {
                v.taxon.allRecoveries[i].MAGE = "X";
            }

            if (v.taxon.allRecoveries[i].MSEX === "") {
                v.taxon.allRecoveries[i].MSEX = "X";
            }

        }
    }


    function getTotalNumberOfRingedBirds(){

        $.ajax({
            type: "get",
            url: "../api/getNumberOfRingedBirds.php?taxon=" + v.taxon.current,
            success: function (data) {

                v.taxon.noOfRinged = JSON.parse(data);

                v.ui.rmTot.text(mgToLocaleString(v.taxon.noOfRinged, v));
                let recoveryPercent = Math.round(v.taxon.allRecoveries.length/v.taxon.noOfRinged * 1000) / 10;  // One decimal
                v.ui.rmProcent.text( recoveryPercent );

                v.ui.rmFilterTot.text(mgToLocaleString( v.taxon.allRecoveries.length, v));
                v.ui.rmFilterPercent.text( '100' );

            },

        });
    }

    function resolveAge(age){

        let a = '';
        if (age.length > 0){
            a = age;
        }

       return a;
    }
    
    function resolveSex(sex){

        let a = '';
        if (sex.length > 0){

            switch (sex){
                case "F":
                    a = v.language.sex.F;
                    break;
                case "M":
                    a = v.language.sex.M;
                    break;
                case "G":
                    a = v.language.sex.G;
                    break;
                case "N":
                    a = v.language.sex.N;
                    break;
                case "X":
                    a = v.language.sex.X;
                    break;
                default:
                    a = sex;
            }

        }

        return a;
    }

    function resolveTime(dagar){

        let a = v.language.mapPopUp.elapsedTime + dagar + v.language.mapPopUp.days;
        if (dagar === '0'){
            a = v.language.mapPopUp.elapsedTimeUnknown;
        }

        return a;
    }

    function getSmallerPlace(arrToUse){

        let answer = ''
        if (arrToUse.length > 1){
            answer = mgToTitleCase(arrToUse[1]) + ', ';
        }

        return answer;
    }

    function resolveOmstandigheter(svText, engText, langId){

        let answer = svText;
        if (langId === "2"){
            answer = engText;
        }

        return answer;
    }

    function sortDistansDesc( a, b ) {
        let aa = parseInt(a.DISTANS);
        let bb = parseInt(b.DISTANS);
        if ((!isNaN(aa)) && (!isNaN(bb))){
            if ( aa > bb ){
                return -1;
            }
            if ( aa < bb ){
                return 1;
            }
            return 0;
        } else {
            return 0;
        }

    }

    function sortDaysDesc( a, b ) {
        let aa = parseInt(a.DAGAR);
        let bb = parseInt(b.DAGAR);
        if ((!isNaN(aa)) && (!isNaN(bb))){
            if ( aa > bb ){
                return -1;
            }
            if ( aa < bb ){
                return 1;
            }
            return 0;
        } else {
            return 0;
        }

    }

    function checkRingingYearsForCurrentTaxa(){

        let aYears = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            aYears.push(v.taxon.allRecoveries[i].MDATUM.substring(0,4));
        }

        let aUnique = [...new Set(aYears)];

        let aRingYears = [];
        for (let i = 0; i < aUnique.length; i++){
            let aYear = {label: aUnique[i], title: aUnique[i], value: aUnique[i]} ;
            aRingYears.push(aYear);
        }

        v.ui.slctRingingYears.multiselect('dataprovider', aRingYears);
        v.ui.slctRingingYears.multiselect('selectAll', false);

    }

    function checkRingingMonthsForCurrentTaxa(){

        let aMonths = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            // 2012-10-07
            // 0123456
            aMonths.push(v.taxon.allRecoveries[i].MDATUM.substring(5,7));
        }

        let aUnique = [...new Set(aMonths)];

        aUnique.sort();

        let aRingMonths = [];
        for (let i = 0; i < aUnique.length; i++){

            let aRingMonth = {label: v.language.months[aUnique[i]], title: v.language.months[aUnique[i]], value: aUnique[i]} ;
            aRingMonths.push(aRingMonth);
        }

        v.ui.slctRingingMonths.multiselect('dataprovider', aRingMonths);
        v.ui.slctRingingMonths.multiselect('selectAll', false);

    }

    function checkRingingAgesForCurrentTaxa(){


        // build array of all ages
        let aAges = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            aAges.push(v.taxon.allRecoveries[i].MAGE);
        }

        // create a unique set of ages
        let aUnique = [...new Set(aAges)];

        // make a list of ages for the query ( we need to get SORTORDER from DB )
        let agesString = ''
        for (let i = 0; i < aUnique.length; i++){
            agesString = agesString + ',"' + aUnique[i] + '"';
        }
        agesString = agesString.substring(1, 999);
        agesString = '(' + agesString + ')';


        const encodedAgesString = encodeURIComponent(agesString);

        // ages
        $.ajax({
            type: "get",
            url: "getAges.php?lang=" + v.language.current + '&ages=' + encodedAgesString,
            success: function (data) {

                let ages = JSON.parse(data);
                v.ui.dropdownAges = [];

                for (let i = 0; i < ages.length; i++) {
                    const anAgeOption = {label: ages[i].TEXT, title: ages[i].TEXT, value: ages[i].ATERFYND_AGE} ;
                    v.ui.dropdownAges.push(anAgeOption);
                }

                v.ui.slctage.multiselect({
                    includeSelectAllOption: true,
                    buttonWidth: '100px',
                });
                v.ui.slctage.multiselect('dataprovider', v.ui.dropdownAges);
                v.ui.slctage.multiselect('selectAll', false);

            }
        });

    }

    function checkRingingSexesForCurrentTaxa(){

        aSexes = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            aSexes.push(v.taxon.allRecoveries[i].MSEX);
        }

        let aUnique = [...new Set(aSexes)];
        v.taxon.checkAges = true;
        if (aUnique.length === 1){
            v.taxon.checkAges = false;
            v.ui.sexDropDownSection.addClass('mg-hide-element');
        } else {

            v.ui.sexDropDownSection.removeClass('mg-hide-element');

            let aRingSexes = [];
            for (let i = 0; i < aUnique.length; i++){
                if (aUnique[i].length > 0){
                    let key = aUnique[i];
                    let s = v.language.sexes[key];
                    let aRingSex = {label: s, title: s, value: key} ;

                    aRingSexes.push(aRingSex);
                }
            }

            v.ui.slctsex.multiselect('dataprovider', aRingSexes);
            v.ui.slctsex.multiselect('selectAll', false);

        }

    }

    function checkRecoveryMonthsForCurrentTaxa(){

        let aMonths = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            // 2012-10-07
            // 0123456
            aMonths.push(v.taxon.allRecoveries[i].FDATUM.substring(5,7));
        }

        let aUnique = [...new Set(aMonths)];

        aUnique.sort();

        let aRecoveryMonths = [];
        for (let i = 0; i < aUnique.length; i++){

            let aRingMonth = {label: v.language.months[aUnique[i]], title: v.language.months[aUnique[i]], value: aUnique[i]} ;
            aRecoveryMonths.push(aRingMonth);
        }

        v.ui.slctRecoveryMonths.multiselect('dataprovider', aRecoveryMonths);
        v.ui.slctRecoveryMonths.multiselect('selectAll', false);

    }

    function checkRecoveryYearsForCurrentTaxa(){

        let aYears = [];
        for (let i = 0; i < v.taxon.allRecoveries.length; i++){
            // 2012-10-07
            // 0123456
            aYears.push(v.taxon.allRecoveries[i].FDATUM.substring(0,4));
        }

        let aUnique = [...new Set(aYears)];

        aUnique.sort();

        let aRecoveryYears = [];
        for (let i = 0; i < aUnique.length; i++){

            let aRecoveryYear = {label: v.language.months[aUnique[i]], title: aUnique[i], value: aUnique[i]} ;
            aRecoveryYears.push(aRecoveryYear);
        }

        v.ui.slctRecoveryYears.multiselect('dataprovider', aRecoveryYears);
        v.ui.slctRecoveryYears.multiselect('selectAll', false);

    }

    function reLoadMainTable(arrayToUse){

        v.ui.tableRecoveries.empty();

        // build recovery table
        for (let i = 0; i <  arrayToUse.length; i++) {

            let comma = ', ';
            let s = '<tr>' + '\n';

            // ringing data
            s = s + '<td>' + '\n';
            let datumOchPlats = arrayToUse[i].MDATUM + comma + mgToTitleCase(arrayToUse[i].MSTORORT);
            let ageText = resolveAge(arrayToUse[i].MAGE);
            let sexText = resolveSex(arrayToUse[i].MSEX);

            s = s + datumOchPlats + '<br/>' + ageText + ' ' + sexText;

            s = s + '</td>' + '\n';

            // recovery information
            s = s + '<td>' + '\n';

            // potentially dirty (and inconsistent) data, cleaned in getLocation
            s = s + arrayToUse[i].FDATUM + comma + getLocation(arrayToUse[i].FPROVINS, arrayToUse[i].FSTORORT);

            s = s + ' (' + arrayToUse[i].FLAT + comma + arrayToUse[i].FLON + ') ';
            s = s + resolveAge(arrayToUse[i].FAGE);
            s = s + '<br/>';
            s = s + resolveOmstandigheter(arrayToUse[i].fkdtxt_sve, arrayToUse[i].fkdtxt_eng, '1') + '<br/>';
            s = s + resolveTime(arrayToUse[i].DAGAR) + '<br/>';
            s = s + 'Distans: ' + arrayToUse[i].DISTANS + ' km.' + '<br/>';  // KURS,

            s = s + '</td>' + '\n';

            // close the row
            s = s + '</tr>' + '\n';

            v.ui.tableRecoveries.append(s);
        }

    }

    function filterData(){

        if (v.taxon.dataloaded ) {

            //console.log(' ');
            //console.log('All ringed and recovered birds ' + v.taxon.allRecoveries.length);

            // ringing side
            v.taxon.selectedRingingYears = v.ui.slctRingingYears.val();
            let yearFiltered = v.taxon.allRecoveries.filter(filterRingingYears);
            //console.log('After year filter ' + yearFiltered.length );

            v.taxon.selectedMonths = v.ui.slctRingingMonths.val();
            const monthsFiltered = yearFiltered.filter(filterRingingMonths);
            //console.log('After ringing month filter ' + monthsFiltered.length);

            let sexFiltered = monthsFiltered;
            if (v.taxon.checkAges){
                v.taxon.selectedSexes = v.ui.slctsex.val();
                sexFiltered = monthsFiltered.filter(filterSex);
            }
            //console.log('After sex filter ' + sexFiltered.length);

            // recovery side
            const timeFiltered = sexFiltered.filter(filterTime);
            //console.log('After time filter ' + timeFiltered.length);

            const distanceFiltered = timeFiltered.filter(filterDistance);
            //console.log('After distance filter ' + distanceFiltered.length);

            v.taxon.selectedRecoveryYears = v.ui.slctRecoveryYears.val();
            const recoveryYearsFiltered = distanceFiltered.filter(filterRecoveryYears);
            //console.log('After recovery years filter ' + recoveryYearsFiltered.length);

            v.taxon.selectedRecoveryMonths = v.ui.slctRecoveryMonths.val();
            v.recoveryMonthsFiltered = recoveryYearsFiltered.filter(filterRecoveryMonths);
            //console.log('After recovery months filter ' + v.recoveryMonthsFiltered.length);

            v.ui.rmFilterTot.text(mgToLocaleString(v.recoveryMonthsFiltered.length, v));
            let tot = parseInt(v.ui.totRecoveries.text());
            let recoveryPercent = Math.round(v.recoveryMonthsFiltered.length/tot * 1000) / 10;  // One decimal
            v.ui.rmFilterPercent.text( recoveryPercent );

            reLoadMainTable(v.recoveryMonthsFiltered);
            setUpTheMap(v.recoveryMonthsFiltered, v);

        }

    }

    function filterRingingYears(element){
        return v.taxon.selectedRingingYears.includes(element.MDATUM.substring(0,4))
    }

    function filterRecoveryYears(element){
        return v.taxon.selectedRecoveryYears.includes(element.FDATUM.substring(0,4))
    }

    function filterRecoveryMonths(element){
        return v.taxon.selectedRecoveryMonths.includes(element.FDATUM.substr(5,2))
    }

    function filterRingingMonths(element){
        return v.taxon.selectedMonths.includes(element.MDATUM.substr(5,2));
    }

    function filterSex(element){
        /*
        MultiSelect (v.taxon.selectedSexes) does not yield an array in this case.
        Unclear why. Thus testing this way.
         */
        let found = false;
        for (const [key, value] of Object.entries(v.taxon.selectedSexes)) {
            if (value === element.MSEX){
                found = true;
                break;
            }
        }
        return found;
    }

    function filterTime(element) {
        // 0 days does not exist. It indicates "not known" and these records are ignored when filtering time.
        let answer = true;
        if (element.DAGAR > 0)  {
            answer = (element.DAGAR >= v.ui.sliderTime.slider("values", 0)) && (element.DAGAR <= v.ui.sliderTime.slider("values", 1));
        }
        return answer;
    }

    function filterDistance(element) {
        return (element.DISTANS >= v.ui.sliderDistance.slider("values", 0)) && (element.DISTANS <= v.ui.sliderDistance.slider("values", 1));
    }

    function getLocation(province, place){

        let comma = ', ';
        // potentially dirty (and inconsistent) data
        let fprovins = province.replace(';', ',');
        const myArr = fprovins.split(",");
        const arrStorOrt = myArr.filter(word => word.length > 2);
        return mgToTitleCase(place) + comma + getSmallerPlace(arrStorOrt) + mgToTitleCase(arrStorOrt[0]);

    }

    function getDistanceAsHTML(arrayToSort, v){

        arrayToSort.sort( sortDistansDesc );

        v.taxon.maxDistance = arrayToSort[0].DISTANS;
        v.taxon.minDistance = arrayToSort[arrayToSort.length-1].DISTANS;

        v.ui.sliderDistanceMaxValue.text(mgToLocaleString(arrayToSort[0].DISTANS, v));
        v.ui.sliderDistanceMinValue.text(mgToLocaleString(v.taxon.minDistance, v));

        let max = 3;
        if (arrayToSort.length < 3){
            max = arrayToSort.length;
        }

        let s = '';
        for (let i = 0; i < max; i++){
            s = s + mgToLocaleString(arrayToSort[i].DISTANS, v) + ' km. ' + getLocation(arrayToSort[i].FPROVINS, arrayToSort[i].FSTORORT) + '<br/>';
        }

        v.ui.avstandsLista.empty();
        v.ui.avstandsLista.append(s);

    }

    function getTimeAsHTML(arrayToSort, v){

        arrayToSort.sort( sortDaysDesc );

        v.taxon.maxTime = arrayToSort[0].DAGAR;
        v.ui.sliderTimeMaxValue.text(mgToLocaleString(arrayToSort[0].DAGAR, v));

        v.taxon.minTime = arrayToSort[arrayToSort.length-1].DAGAR;
        for (let i = arrayToSort.length-1; i > -1; i = i-1){
            v.taxon.minTime = arrayToSort[i].DAGAR;
            if (v.taxon.minTime !== "0"){
                break;
            }
        }
        v.ui.sliderTimeMinValue.text(mgToLocaleString(v.taxon.minTime, v));

        // sometimes we have very few recoveries, so we cannot show the three longest times
        let max = 3;
        if (arrayToSort.length < 3){
            max = arrayToSort.length;
        }

        let s = '';
        for (let i = 0; i < max; i++){
            s = s + mgToLocaleString(arrayToSort[i].DAGAR, v) + ' dagar, ' + getLocation(arrayToSort[i].FPROVINS, arrayToSort[i].FSTORORT) + '<br/>';
        }

        v.ui.tidsLista.empty();
        v.ui.tidsLista.append(s);

        return s;
    }

    function setMonthsTexts() {

        // E N G E L S K A
        if (v.language.current === '1'){
            v.language.months = {
                "01" : 'January',
                "02" : 'February',
                "03" : 'March',
                "04" : 'April',
                "05" : 'May',
                "06" : 'June',
                "07" : 'July',
                "08" : 'August',
                "09" : 'September',
                "10" : 'October',
                "11" : 'November',
                "12" : 'December',
            }
        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.months = {
                "01" : 'januari',
                "02" : 'februari',
                "03" : 'mars',
                "04" : 'april',
                "05" : 'maj',
                "06" : 'juni',
                "07" : 'juli',
                "08" : 'augusti',
                "09" : 'september',
                "10" : 'oktober',
                "11" : 'november',
                "12" : 'december',
            }
        }
    }

    function setSexTexts() {

        // E N G E L S K A
        if (v.language.current === '1'){
            v.language.sexes = {
                "F" : 'Females',
                "M" : 'Males',
                "X" : 'Sex not given',
                "N" : 'Probable males',
                "G" : 'Probable females',
            };
            v.language.sex = {
                "F" : 'Female',
                "M" : 'Male',
                "X" : 'Sex not given',
                "N" : 'Probable male',
                "G" : 'Probable female',
            }

        }

        // S V E N S K A
        if (v.language.current === '2'){
            v.language.sexes = {
                "F" : 'Honor',
                "M" : 'Hanar',
                "X" : 'Kön okänt',
                "N" : 'Troliga hanar',
                "G" : 'Troliga honor',
            };
            v.language.sex = {
                "F" : 'Hona',
                "M" : 'Hane',
                "X" : 'Kön okänt',
                "N" : 'Trolig hane',
                "G" : 'Trolig hona',
            }
        }
    }

    getHeaderTexts();
    setHeaderTexts();

    v.taxon.dataloaded = false;


    setSexTexts();
    setLangTexts();
    setMonthsTexts();

    populateDropDowns();
    $('.js-example-basic-single').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $( '#datatabs' ).tabs();

    // ringing section
    v.ui.slctRingingYears.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
    });
    v.ui.slctRingingYears.multiselect('selectAll', false);

    v.ui.slctRingingMonths.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
        selectAllText: v.ui.lang.textSelectAll,
    });
    v.ui.slctRingingMonths.multiselect('selectAll', false);

    v.ui.slctage.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
        selectAllText: v.ui.lang.textSelectAll,
    });
    v.ui.slctage.multiselect('selectAll', false);

    v.ui.slctsex.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
        selectAllText: v.ui.lang.textSelectAll,
    });
    v.ui.slctsex.multiselect('selectAll', false);

    // recoveries section
    v.ui.slctRecoveryYears.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
        selectAllText: v.ui.lang.textSelectAll,
    });
    v.ui.slctRecoveryYears.multiselect('selectAll', false);

    v.ui.slctRecoveryMonths.multiselect({
        includeSelectAllOption: true,
        allSelectedText: v.ui.lang.textAlla,
        nonSelectedText: v.ui.lang.textInga,
        selectAllText: v.ui.lang.textSelectAll,
    });
    v.ui.slctRecoveryMonths.multiselect('selectAll', false);

    // enable filtering on changes in selects (drop downs and sliders)
    // ringing side
    v.ui.slctRingingYears.change( filterData );
    v.ui.slctRingingMonths.change( filterData );
    v.ui.slctsex.change( filterData );
    v.ui.slctage.change( filterData );

    // recovery side
    v.ui.slctRecoveryYears.change( filterData );
    v.ui.slctRecoveryMonths.change( filterData );

    v.ui.sliderDistance.slider({
        range: true,
        slide: function( event, ui ) {
            v.ui.inputDistance.val( mgToLocaleString(ui.values[ 0 ], v) + " - " + mgToLocaleString(ui.values[ 1 ], v) + " km" );
            filterData();
        }
    });

    v.ui.tabMap.on('click', function(){
        filterData();
    });

    v.ui.sliderTime.slider({
        range: true,
        slide: function( event, ui ) {
            v.ui.inputTime.val( mgToLocaleString(ui.values[ 0 ], v) + " - " + mgToLocaleString(ui.values[ 1 ], v) + v.ui.lang.days );
            filterData();
        }
    });

    v.ui.taxaDropDown.trigger('change');


    function setSliderValues(){

        let aLowAndHigh = [];
        aLowAndHigh.push("0");
        aLowAndHigh.push(v.taxon.maxDistance);

        //v.ui.sliderDistance.slider( 'option', 'min', v.taxon.minDistance );
        v.ui.sliderDistance.slider( 'option', 'max', v.taxon.maxDistance );
        v.ui.sliderDistance.slider('values', aLowAndHigh);
        v.ui.inputDistance.val(  mgToLocaleString(v.ui.sliderDistance.slider( 'values', 0 ), v) + " - " +  mgToLocaleString(v.ui.sliderDistance.slider( 'values', 1 ), v) + " km" );

        aLowAndHigh = [];
        aLowAndHigh.push(0);
        aLowAndHigh.push(v.taxon.maxTime);

        v.ui.sliderTime.slider( 'option', 'max', v.taxon.maxTime );
        v.ui.sliderTime.slider('values', aLowAndHigh);
        v.ui.inputTime.val(  mgToLocaleString(v.ui.sliderTime.slider( 'values', 0 ), v) + " - " +  mgToLocaleString(v.ui.sliderTime.slider( 'values', 1 ), v) + v.ui.lang.days );

    }

    function buildPopUpText(recovery){

        let comma = ', ';
        let datumOchPlats = recovery.MDATUM + v.language.mapPopUp.in + mgToTitleCase(recovery.MSTORORT);
        let ageText = resolveAge(recovery.MAGE);
        let sexText = resolveSex(recovery.MSEX);

        let s = v.language.mapPopUp.caught + datumOchPlats + v.language.mapPopUp.as + ageText + ' ' + sexText + '<br/>';

        // potentially dirty (and inconsistent) data, cleaned in getLocation
        s = s + v.language.mapPopUp.recovered + recovery.FDATUM + v.language.mapPopUp.in + getLocation(recovery.FPROVINS, recovery.FSTORORT);

        s = s + ' (' + recovery.FLAT + comma + recovery.FLON + ') ';
        //s = s + resolveAge(recovery.FAGE);
        s = s + '<br/>';
        s = s + resolveOmstandigheter(recovery.fkdtxt_sve, recovery.fkdtxt_eng, '1') + '<br/>';
        s = s + resolveTime(recovery.DAGAR) + '<br/>';
        s = s + v.language.mapPopUp.distance + recovery.DISTANS + v.language.mapPopUp.distanceUnit + '<br/>';  // KURS,

        return s;

    }

    function setUpTheMap(data, v){


        if (v.mymap != null) {
            v.mymap.remove();
            v.mymap = null;
        }

        let zoom = 5;
        v.mymap = L.map('rmap').setView([55.405, 12.80], zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(v.mymap);

        let homeTab = document.getElementById('tabMap');
        let observer1 = new MutationObserver(function(){
            if (homeTab.style.display !== 'none'){
                v.mymap.invalidateSize();
            }
        });
        observer1.observe(homeTab, {attributes: true});


        L.circle([55.39, 12.818], {
            color: 'red',
            radius: 1000
        }).addTo(v.mymap);

        let markerArray = [];
        for (let i=0; i < data.length; i++){
            let flat = data[i].FLAT;
            let flon = data[i].FLON;
            let popupText = buildPopUpText(data[i]);
            markerArray.push( L.marker([flat, flon]).bindPopup( popupText ) );
        }

        let group = L.featureGroup(markerArray).addTo(v.mymap);
        v.mymap.fitBounds(group.getBounds());

        if (markerArray.length === 1){
            // when only one marker, the fitBounds area is too small. We zoom out.
            v.mymap.setZoom(10);
        }

    }


});