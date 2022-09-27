$(document).ready(function(){

    let bodmin = {};
    bodmin.functions = {};

    bodmin.ui = {
        btnLogin : $('#btnLogin'),
        inpUserName : $('#username'),
        errorUserName : $('#error-user-name'),
        inpPassWord : $('#password'),
        errorPassword : $('#error-pass-word'),
        loggingIn : $('#logging-in')
    }

    bodmin.lang = {
        current : $('#systemLanguageId').text()
    };

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

    };

    function setLangTexts(){

        // E N G E L S K A
        if (bodmin.lang.current === '1'){

            bodmin.lang = {
                pageTitle : 'Log in',
                hdrMain : 'Please log in',
                headerSubText: 'Enter your credentials below',
                loggedinText : 'You are not logged in - yet ',
                logInAgain : 'Log in again',
                userName : 'User name (email address)',
                pwd : 'Password',
                userNameNotGiven : 'You must give a user name',
                passwordNotGiven : 'You must give a password',
                wrongUserName : 'This user name does not exist',
                wrongPassword : 'This password is not correct'

            }
        }

        // S V E N S K A
        if (bodmin.lang.current === '2'){

            bodmin.lang = {
                pageTitle : 'Logga in',
                hdrMain : 'Vänligen logga in',
                headerSubText: 'Fyll i dina uppgifter nedan',
                loggedinText : 'Du är inte inloggad - än ',
                userName : 'Användarnamn (epost adress)',
                pwd : 'Passord',
                userNameNotGiven : 'Du måste ange användarnamn',
                passwordNotGiven : 'Du måste ange ett lösenord',
                wrongUserName : 'Detta användarnamn finns ej',
                wrongPassword : 'Fel lösenord'

            }
        }

        $(document).attr('title', bodmin.lang.pageTitle);
        $("html").attr("lang", bodmin.lang.langAsString);
        $('#loggedinText').text(bodmin.lang.loggedinText);
        $('#hdrMain').text(bodmin.lang.hdrMain);
        $('#headerSubText').text(bodmin.lang.headerSubText);
        $('#lblUserName').text(bodmin.lang.userName);
        $('#pwd').text(bodmin.lang.pwd);
        $('#userName').html('');

    }

    bodmin.ui.btnLogin.on('click', function(){

        bodmin.ui.errorUserName.text('');
        bodmin.ui.errorPassword.text('');
        let ok = true;

        if (bodmin.ui.inpUserName.val().length === 0){
            bodmin.ui.errorUserName.text(bodmin.lang.userNameNotGiven);
            bodmin.ui.inpUserName.focus();
            ok = false;
        }

        if (ok){

            if (bodmin.ui.inpPassWord.val().length === 0){
                bodmin.ui.errorPassword.text(bodmin.lang.passwordNotGiven);
                bodmin.ui.inpPassWord.focus();
                ok = false;
            }
        }

        // basic formalities are OK, load the formData and check if allowed in
        if (ok) {
            bodmin.ui.loggingIn.toggleClass("mg-hide-element", false);
            bodmin.ui.btnLogin.prop('disabled', true);

            let formData = new FormData;
            formData.append('username', bodmin.ui.inpUserName.val() );
            formData.append('pwd', bodmin.ui.inpPassWord.val() );

            $.ajax({
                url: "checkLogin.php",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function ( data /*, textStatus, jqXHR */) {

                    let result = JSON.parse(data);

                    if (result.status === 'ok'){
                        window.location.replace("/bodmin/index.php");
                    } else if (result.status === 'username') {
                        bodmin.ui.errorUserName.text(bodmin.lang.wrongUserName);
                        bodmin.ui.inpUserName.focus();
                        bodmin.ui.loggingIn.toggleClass("mg-hide-element", true);
                        bodmin.ui.btnLogin.prop('disabled', false);
                    } else if (result.status === 'password') {
                        bodmin.ui.errorPassword.text(bodmin.lang.wrongPassword);
                        bodmin.ui.inpPassWord.focus();
                        bodmin.ui.loggingIn.toggleClass("mg-hide-element", true);
                        bodmin.ui.btnLogin.prop('disabled', false);
                    }

                }
            });

        }

    });

    bodmin.ui.inpUserName.focus();

});

