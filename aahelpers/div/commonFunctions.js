
function checkFilterString(hay, needles){

    let i;
    let words = needles.toLowerCase().split(" ");
    let answer = true;

    for (i = 0; i < words.length; i++) {

        answer = (hay.toLowerCase().indexOf(words[i]) > -1);
        if (answer === false){
            break;
        }

    }

    return answer;

}

/*

bodmin.functions.swapLanguage = function (bodmin){

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