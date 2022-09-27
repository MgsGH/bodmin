$(document).ready(function(){

    bodmin = {};

    bodmin.lang = {
        current : $('#lang').text(),
    };

    /*
    bodmin.functions.swapLanguage = function (){

        if (bodmin.lang.current === '1'){
            bodmin.lang.current = '2';
            bodmin.lang.langAsString = 'se';

        } else {
            bodmin.lang.current = '1';
            bodmin.lang.langAsString = 'en';
        }

        setLangTexts();

    };

     */

    function setLangTexts(){

        console.log(bodmin.lang.current);

        // E N G E L S K A
        if (bodmin.lang.current === '1'){

            bodmin.lang.langAsString = 'en';
            bodmin.lang.notLoggedinText = 'You are now logged out';

            bodmin.lang.statictexts = {
                pageTitle : 'Logged out',
                loggedinText : '',
                hdrMain : 'You are now logged out',
                logInAgain : 'Log in again here',
                tack : 'Many thanks for your efforts!'
            }
        }

        // S V E N S K A
        if (bodmin.lang.current === '2'){

            bodmin.lang.langAsString = 'se';
            bodmin.lang.notLoggedinText = 'Du är nu utloggad';

            bodmin.lang.statictexts = {
                pageTitle : 'Utloggad',
                loggedinText : '',
                hdrMain : 'Du är nu utloggad',
                logInAgain : 'Logga in igen här',
                tack : 'Mycket tack för din insats!'
            }
        }

        $(document).attr('title', bodmin.lang.statictexts.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.statictexts.loggedinText);
        $('#hdrMain').text(bodmin.lang.statictexts.hdrMain);
        $('#logInAgain').text(bodmin.lang.statictexts.logInAgain);
        $('#tack').text(bodmin.lang.statictexts.tack);

        let loggedInInfo = bodmin.lang.notLoggedinText;
        $('#loggedStatus').html(loggedInInfo);
        $('#userName').html('');

    }

    setLangTexts();

});