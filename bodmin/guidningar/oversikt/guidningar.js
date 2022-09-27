$(document).ready(function(){

    let v = {

        controlPanel : {
          btnNewBooking : $('#btnNewBooking')
        },

        lang : {
          current : getLanguageAsNo()
        },

    };

    // tie datepicker to navigation panel
    // https://stackoverflow.com/questions/6857025/highlight-dates-in-jquery-ui-datepicker
    $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true
    });

    function setLangTexts(){

        // E N G E L S K A
        if (v.lang.current === '1'){

            v.lang.langAsString = 'en';

            v.lang.common = {

                // header info
                loggedinText : 'Logged in as ',
                notLoggedinText : 'You are not logged in',
                logOutHere : "Log out here",
                pageTitle : "Guidings",
                hdrMain : "Guidings",

            }

            v.lang.controlPanel = {
                header: 'Guidningar',


                // vänster sidan
                selectInfo : 'Select a guiding',

                btnNewBooking : 'New guiding',
                btnChange : 'Change',
                btnDelete : 'Remove'
            }

        }

        // S V E N S K A
        if (v.lang.current === '2'){
            v.lang.langAsString = 'se';


            v.lang.common = {

                // header info
                loggedinText : 'Inloggad som ',
                notLoggedinText : 'Du är ej inloggad',
                logOutHere : "Logga ut här",
                pageTitle : "Guidningar",
                hdrMain : "Guidningar",

            }

            v.lang.controlPanel = {
                header : 'Guidningar',
                selectInfo : 'Välj guidingstillfälle',
                btnNewBooking : 'Ny bokning',
                btnChange : 'Ändra',
                btnDelete : 'Tag bort'
            }

        }

        $(document).attr('title', v.lang.common.pageTitle);
        $("html").attr("lang", v.lang.langAsString);
        $('#hdrMain').text(v.lang.common.hdrMain);
        $('#loggedinText').text(v.lang.common.loggedinText);
        $('#selectInfo').text(v.lang.common.selectInfo);
        $('#infoLabel').text(v.lang.common.infoLabel);

        let loggedInInfo = v.lang.notLoggedinText;
        if ($('#loggedInUserId').text() !== '0'){
            loggedInInfo = '<a href="/loggedout/index.php" class="mg-hdrLink">' +  ' ' + v.lang.common.logOutHere +"</a>";
        }
        $('#loggedStatus').html(loggedInInfo);

        //



    }

    console.log( v.lang.current );

    setLangTexts();

});


