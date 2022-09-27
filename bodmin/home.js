$(document).ready(function(){

    bodmin = {};
    bodmin.lang = {};


    bodmin.newsSection = {
        ui : {
            keywordsDropDown : $('#ddKeyWordsBlog'),
            newsItemsList : $('#newsList')
        }
    }

    bodmin.lang.current = $('#systemLanguageId').text();

    console.log(bodmin.lang.current);

    setLangTexts();
    populateDropDown();

    bodmin.newsSection.ui.keywordsDropDown.change(function() {

        bodmin.newsSection.ui.newsItemsList.empty();
        bodmin.newsSection.ui.newsItemsList.append(mgGetImgSpinner());

        if (bodmin.newsSection.ui.keywordsDropDown.val() !== '0') {

            // keywords
            $.ajax({
                type: "get",
                url: '../api/getNewsFullTexts.php?keyword=' + bodmin.newsSection.ui.keywordsDropDown.val() + '&lang=' + bodmin.lang.current,
                success: function (data) {

                    bodmin.newsSection.ui.newsItemsList.empty();
                    let html = "";

                    let newsItems = JSON.parse(data);

                    console.log('antal funna dagar: ' + newsItems.length);

                    for (let i = 0; i < newsItems.length; i++) {
                        html = html + newsItems[i].TEXT;
                    }

                    bodmin.newsSection.ui.newsItemsList.empty();
                    bodmin.newsSection.ui.newsItemsList.append(html);

                }
            });


        } else {

            // all
            $.ajax({
                type: "get",
                url: "../api/getAllNewsFullTexts.php?lang=" + bodmin.lang.current,
                success: function (data) {

                    bodmin.newsSection.ui.newsItemsList.empty();
                    let html = "";

                    let newsItems = JSON.parse(data);
                    for (let i = 0; i < newsItems.length; i++) {
                        html = html + newsItems[i].TEXT;
                    }

                    bodmin.newsSection.ui.newsItemsList.empty();
                    bodmin.newsSection.ui.newsItemsList.append(html);

                }
            });

        }
    });


    function setLangTexts(){

        // E N G E L S K A
        if (bodmin.lang.current === '1'){

            bodmin.lang.langAsString = 'en';
            bodmin.lang = {

                title: 'Home',
                loggedinText : 'logged in as ',
                notLoggedinText : 'You are not logged in',
                logOutHere : 'Log out here',
                hdrMain : "Welcome to Falsterbo Bird Observatory and its management system",
                hdrSubOne : "This is the back-end maintenance system. It is used to maintain information posted on the web site, and beyond.",
                hdrSubThreeOne : 'To run the system, kindly use the links at the top of this page. If you do not see any links, or not the link you expect, mail Magnus: <a href="mailto:magnus.grylle@gmail.com?subject=bodmin">magnus.grylle@gmail.com</a>',

            }

            bodmin.newsSection.lang = {
                ddKeywordsNoValue : "All"
            }


        }


        // S V E N S K A
        if (bodmin.lang.current === '2'){

            bodmin.lang.langAsString = 'se';
            bodmin.lang = {


                title: 'Hem',
                loggedinText : 'Inloggad som ',
                notLoggedinText : 'Du ej inloggad',
                logOutHere : 'Logga ut här',
                hdrMain : "Välkommen till Falsterbo Fågelstation",
                hdrTwo : "Detta är vår datahanterare",
                hdrSubOne : "Vad du ser nu är underhållsdelen av systemet. Här underhåller vi information som vi behöver, varav en del visas på vår web sajt.",
                hdrSubThreeOne : 'Vänligen, för att köra systemet, klicka länkarna som återfinns längst upp på denna sida. Har du inga länkar, saknar du behörigheter. Maila i så fall Magnus: <a href="mailto:magnus.grylle@gmail.com?subject=bodmin">magnus.grylle@gmail.com</a>',

            }

            bodmin.newsSection.lang = {
                ddKeywordsNoValue : "Alla"
            }

        }

        // standard for all pages
        $(document).attr('title', bodmin.lang.title);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.loggedinText);


        let loggedInInfo = bodmin.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/bodmin/loggedout/index.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.logOutHere + "</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        $('#hdrMain').text(bodmin.lang.hdrMain);
        $('#hdrTwo').text(bodmin.lang.hdrTwo);
        $('#hdrSubOne').text(bodmin.lang.hdrSubOne);
        $('#hdrSubThreeOne').html(bodmin.lang.hdrSubThreeOne);

    }

    function populateDropDown() {

        // keywords
        $.ajax({
            type: "get",
            url: "../api/getKeywordsForCategory.php?cat=15&lang=" + bodmin.lang.current,
            success: function (data) {

                let thisOption = '<option value="0" selected>' + bodmin.newsSection.lang.ddKeywordsNoValue  + '</option>';
                bodmin.newsSection.ui.keywordsDropDown.append(thisOption);

                let keyw = JSON.parse(data);
                for (let i = 0; i < keyw.length; i++) {
                    bodmin.newsSection.ui.keywordsDropDown.append($("<option></option>").attr("value", keyw[i].ID).text(keyw[i].TEXT));
                }

            }
        });
    }

    function populateNewsSection() {


        // keywords
        $.ajax({
            type: "get",
            url: "../api/getKeywordsForCategory.php?cat=15&lang=" + bodmin.lang.current,
            success: function (data) {

                let newsText = '';

                let keyw = JSON.parse(data);
                for (let i = 0; i < keyw.length; i++) {
                    bodmin.newsSection.ui.keywordsDropDown.append($("<option></option>").attr("value", keyw[i].ID).text(keyw[i].TEXT));
                }

            }
        });
    }

    function populateNewsItems(){

        bodmin.newsSection.ui.newItemsList.empty();
        bodmin.newsSection.ui.newItemsList.append(mgGetImgSpinner());


    }

    setLangTexts();

});