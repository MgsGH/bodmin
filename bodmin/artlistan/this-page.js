$(document).ready(function(){

    bodmin = {};
    bodmin.functions = {};
    bodmin.buttons = {};
    bodmin.lang = {};
    bodmin.lang.current = $('#systemLanguageId').text();
    setLangTexts();


    bodmin.functions.swapLanguage = function (){

        if (bodmin.lang.current === '1'){
            bodmin.lang.current = '2';
            bodmin.lang.langAsString = 'se';

        } else {
            bodmin.lang.current = '1';
            bodmin.lang.langAsString = 'en';
        }

        setLangTexts();

    }

    function setLangTexts(){

        // E N G E L S K A
        if (bodmin.lang.current === '1'){

            bodmin.lang.langAsString = 'en';

            // texts assigned as we go
            // none - yet

            // "static texts"
            bodmin.lang.statictexts = {
                title: 'Species list',
                // header info
                loggedinText : 'Logged in as ',
                notLoggedinText : 'You are not logged in',
                logOutHere : "Log out here",
                pageTitle : "Species list",
                hdrMain : "Species list",

                // vänstersidan
                selectInfo : 'Select a record',

                btnNew : 'New record',
                btnChange : 'Change',
                btnDelete : 'Remove'
            }

        }

        // S V E N S K A
        if (bodmin.lang.current === '2'){
            bodmin.lang.langAsString = 'se';


            bodmin.lang.statictexts = {
                title : 'Artlistan',

                // header info
                loggedinText : 'Inloggad som ',
                notLoggedinText : 'Du är ej inloggad',
                logOutHere : "Logga ut här",
                pageTitle : "Artlistan",
                hdrMain : "Artlistan",

                selectInfo : 'Välj en observation',

                btnNew : 'Ny',
                btnChange : 'Ändra',
                btnDelete : 'Tag bort'
            }

        }

        $(document).attr('title', bodmin.lang.statictexts.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.statictexts.loggedinText);
        $('#hdrMain').text(bodmin.lang.statictexts.hdrMain);
        $('#selectInfo').text(bodmin.lang.statictexts.selectInfo);
        $('#infoLabel').text(bodmin.lang.statictexts.infoLabel);

        let loggedInInfo = bodmin.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/loggedout/index-empty.php" class="mg-hdrLink">' +  ' ' + bodmin.lang.statictexts.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        //
        /*
        $('#btnNew').text(bodmin.lang.statictexts.btnNew);
        $('#btnChange').text(bodmin.lang.statictexts.btnChange);
        $('#btnDelete').text(bodmin.lang.statictexts.btnDelete);
        */

    }

});