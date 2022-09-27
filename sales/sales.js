$(document).ready(function(){

    let v = {

        language : {
            current : $('#lang').text(),
        },


        date : {
            current : '',   // selected even date
            getParameter : $('#date').text(),
        },

        ui : {
            page : {
                newStuff : $('#newStuff'),
                header : $('#pageHeader'),
            },
        }


    }

    function getTexts() {

        // E N G E L S K A
        if (v.language.current === '1'){

            v.language.langAsString = 'en';
            v.language.decDelimiter = '.';
            v.language.locale = 'en-US';

        }

        // S V E N S K A
        if (v.language.current === '2') {

            v.language.langAsString = 'se';
            v.language.decDelimiter = ',';
            v.language.locale = 'sv-SE';

        }

    }

    getTexts();


    function populateContent(){

        v.ui.page.newStuff.empty();
        v.ui.page.newStuff.append(mgGetDivWithSpinnerImg());

        $.ajax({
            type: "GET",
            url: "getNewStuff.php?lang=" + v.language.current,
            success: function (data) {

                let items = JSON.parse(data);
                let numberOfRows = Math.round(items.length/2);
                let z = -1;
                let html = '';

                for ( let i = 0; i < numberOfRows; i++ ) {

                    z++;
                    html += '<div class="row horizontal align-items-center">';

                    for (let j = 0; j < 2; j++) {
                        let thisItem = items[z+j];

                        html += '<div class="col vertical">';
                        html += '<div class="mb-4 d-flex justify-content-center">';
                        let varubild = thisItem['artnr'] + '_stor.jpg';
                        let info = thisItem['artikel'] + ' ' + thisItem['pris'] + ' kr. ' + thisItem['extra_s'];

                        let link = '<a href="/sales/';
                        if (thisItem['katnr'] === '2'){
                            link += 'books/index.php#' +  thisItem['artnr'] + '">';
                        }

                        if (thisItem['katnr'] === '9'){
                            link += 'dvd/index.php#' +  thisItem['artnr'] + '">';
                        }

                        html +=  link + '<img class="shadow" src="bilder/' + thisItem['bildmapp'] + '/' + varubild + '" alt="bild" title="' + info + '"></a>';
                        html += '</div>';
                        html += '</div>';

                    }

                    z++;

                    html += '</div>';

                }

                v.ui.page.newStuff.empty();
                v.ui.page.newStuff.append(html);
            }

        });

    }


    v.ui.page.header.html(getWebShopHeader());
    populateContent();


});