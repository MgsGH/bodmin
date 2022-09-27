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
                header : $('#pageHeader'),
                introText : $('#introText'),
                itemList : $('#itemList'),
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

        v.ui.page.itemList.empty();
        v.ui.page.itemList.append(mgGetDivWithSpinnerImg());

        $.ajax({
            type: "GET",
            url: "getBooks.php",
            success: function (data) {

                v.books = JSON.parse(data);
                let numberOfRows = v.books.length;

                console.log(v.books);

                let html = '<table id="data" class="table table-hover w-auto">' +
                    '<thead><tr>' +
                    '<th>'  +
                    'Titel' +
                    '</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                for ( let i = 0; i < numberOfRows; i++ ) {
                    let image = '<img style="float:left; margin-right:10px; border:none; display: block;" class="shadow " src="/sales/bilder/bocker/' + v.books[i].artnr + '_stor.jpg" alt="Omslag">'

                    html += '<tr id="'+ v.books[i].artnr +'"><td>' + v.books[i].artikel + '<br/></td></tr>';
                    html += '<tr class="mg-table-row-data mg-hide-element" id="data-'+ v.books[i].artnr +'">'
                    html += '<td>';
                    html += '<div style="height: 340px;" class="Xmg-peanut">';
                    html += image + v.books[i].spectext_s;
                    let pris = Math.round(v.books[i].pris);
                    html += '<br/><p class="mt-2">Pris: <span id="pris-' + v.books[i].artnr + '">' + pris + '</span> kr.</p>';
                    html += '</div>';
                    html += '   <div class="mb-2 mg-warning-input" id="ordered-' + v.books[i].artnr + '">';
                    html += '   </div>';
                    html += '    <div class="row">\n';
                    html += '        <div class="col-1 pt-2"><label class="control-label" for="inpName" id="lblInpName">Antal: </label></div>\n';
                    html += '        <div class="col-2"><input type="number" id="inpNumber-' + v.books[i].artnr + '" required class="form-control input-sm" value="1" width="2" autofocus="autofocus"></div>\n';
                    html += '        <div class="col-6"><button id="btnOrder-' +  v.books[i].artnr + '" class="btn btn-primary btn-order">Lägg till i beställningslistan</button></div>\n';
                    html += '    </div>';
                    html += '    <div class="col-6 mt-3" id="info-' + v.books[i].artnr + '"></div>\n';
                    html += '    <div class="mt-2"><span class="mg-warning-input" id="warningInpName-' + v.books[i].artnr +'"></span></div>\n';
                    html += '</td>';
                    html += '</tr>';

                }

                html += '</tbody></table>';

                v.ui.page.itemList.empty();
                v.ui.page.itemList.append(html);

            }

        });

    }


    $(document).on("click", "#data tbody tr", function(){
        v.selectedRow = $(this);
        handleSelectedRow(v);
    });


    $(document).on("click", "body .btn-order", function(e){

        e.stopPropagation();

        //btnOrder-
        //012345678
        let id = $(this).attr('id').substring(9);
        let inputField = $('#inpNumber-' + id)
        let antal = inputField.val();
        let n = parseInt(antal);
        let ok = true;
        if ((antal === '') || (n === 0)) {
            $('#warningInpName-' + id).text('Du måste beställa minst en vara.');
            inputField.toggleClass('mg-warning', true);
            ok = false;
        }

        if (ok){

            if ( typeof sessionStorage['mySessionShoppingCart'] === 'undefined' ){

                let customerInfo = {};
                customerInfo['firstname'] =  '';
                customerInfo['lastname'] =  '';
                customerInfo['email'] = '@gmail.com';

                let orders = [];
                let mySessionShoppingCart = {'customerInfo' : customerInfo, 'orders' : orders};

                sessionStorage['mySessionShoppingCart'] = JSON.stringify(mySessionShoppingCart);

            }

            let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);

            let order = {}
            order['articleId'] = id;
            order['noof'] = n;
            order['name'] = 'Bok - ' + v.name;
            order['size'] = '-';
            order['price'] = $('#pris-' + id).text();
            myShoppingCart.orders.push(order);

            $('#info-' + id).html('Denna vara ligger nu i <span class="fakeLink gotoOrders">beställningslistan</span>.');

            sessionStorage['mySessionShoppingCart'] = JSON.stringify(myShoppingCart);

        }

    });


    // Reset fields on entry
    $('body').on('focus click', 'input', function(e) {
        $(e.target).toggleClass('mg-warning', false);
        let id = $(e.target).attr('id').substring(10);
        $('#warningInpName-' + id).text('');
    });


    function handleSelectedRow(v){
        handleItemRowSelection(v);
    }


    function handleItemRowSelection(v){

        const id = v.selectedRow.attr('id');

        console.log(id);

        let inputField = $( "#inpNumber-" + id );
        let orderButton = $( "#btnOrder-" + id );

        orderButton.prop( 'disabled', false );
        inputField.prop( 'disabled', false );

        if (v.selectedRow.hasClass('mg-table-row-data')){
            v.selectedRow = v.selectedRow.prev();
        }

        v.selectedRow.siblings().removeClass('table-active');
        v.selectedRow.addClass('table-active');
        $('#data tr.mg-table-row-data').addClass('mg-hide-element');
        v.selectedRow.next().removeClass('mg-hide-element');

        v.mainTableId = v.selectedRow.attr('id');
        v.name = $(v.selectedRow).find("td").eq(0).text();

        if (alreadyOrdered(v.mainTableId)){

            orderButton.prop( 'disabled', true );
            inputField.prop( 'disabled', true );

            $('#ordered-' + id ).html('Denna vara är beställd. För att ändra antal eller ta bort artikeln, gå till <span class="fakeLink gotoOrders">beställningslistan</span>');

        }


    }

    $('body').on('focus click', '.gotoOrders', function(e) {

        e.stopPropagation();
        let u = window.location.origin;

        console.log(u);

        window.location.href = u + "/sales/orders/index.php";

    });

    function alreadyOrdered(id){

        let answer = false;
        if ( typeof sessionStorage['mySessionShoppingCart'] !== 'undefined' ){

            let myShoppingCart = JSON.parse(sessionStorage['mySessionShoppingCart']);


            let orderedItems = myShoppingCart.orders;

            const l = orderedItems.length;
            for (let i = 0; i < l; i++) {

                console.log(orderedItems[i]);

                if ( orderedItems[i].articleId === id ){
                    answer = true;
                    break;
                }


            }

        }

        return answer;

    }


    const category = 8;
    v.ui.page.header.html(getWebShopHeader());
    loadCategoryInformation(v, category);
  //  populateContent();


});

