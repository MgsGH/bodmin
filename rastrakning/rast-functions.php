<?php

function getRastTableHeader ($texts){

    $rasttop='<tr><th>' . $texts->getTxt("art") . '</th>

    <th class="text-center"><span title="Kanalen">KAN</span></th>
    <th class="text-center"><span title="Black">BLA</span></th>
    <th class="text-center"><span title="Ängsnäset">ÄNG</span></th>
    <th class="text-center"><span title="Nabben och Måkläppen">NAB</span></th>
    <th class="text-center"><span title="Slusan, Ålasjön, och Landgrens holme">SLÅ</span></th>
    <th class="text-center"><span title="Skanörs revlar">REV</span></th>
    <th class="text-center"><span title="Knösen">KNÖ</span></th>
    <th class="text-center">' . $texts->getTxt("summa") . '</th></tr>';

    return $rasttop;
}


function getNextWeekLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language){


    $baseLink1 = '<a class="btn btn-outline-primary btn-sm';
    $disabledClass = ' disabled';
    $disabled = false;
    $baseLink2 = '" role="button" aria-disabled="true" href="/rastrakning/index.php?';
    $linkText = $texts->getTxt('bladdra-vecka') . '&nbsp;&raquo;' ;
    $languagePart = getLanguageParameter($language);
    $yearPart = 'year=';
    $weekPart = '&vecka=';


    if (($selectedYear == $maxYear) && ($selectedVecka == $maxWeek )){
        // no link in this case, no future week
        $disabled = true;
    } else {
        // Next  week exists
        if ($selectedVecka == 52) {
            // next week is next year, week 1
            $nextWeek = 1;
            $weekPart = $weekPart . $nextWeek;
            $yearPart = $yearPart . ($selectedYear + 1);
        } else {
            $weekPart = $weekPart . ($selectedVecka+1);
            $yearPart = $yearPart . $selectedYear;
        }

    }

    $link = $baseLink1 . $baseLink2;
    if ($disabled){
        $link = $baseLink1 . $disabledClass . $baseLink2;
    }

    return $link . $yearPart . $weekPart . $languagePart .'">' . $linkText . '</a>';

}


function getNextYearLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language){

    $baseLink1 = '<a class="btn btn-outline-primary btn-sm';
    $disabledClass = ' disabled';
    $disabled = false;
    $baseLink2 = '" role="button" aria-disabled="true" href="/rastrakning/index.php?';
    $linkText = $texts->getTxt('bladdra-ar') . '&nbsp;&raquo;&raquo;' ;
    $yearPart = 'year=';
    $weekPart = '&vecka=';
    $languagePart = getLanguageParameter($language);
    $selectedYear = intval($selectedYear);


    if ($selectedYear == $maxYear){
        // no link in this case, no future year
        $disabled = true;
    }

    if (($selectedYear == $maxYear-1) && ($selectedVecka >= $maxWeek)){
        // Next year exist
        // The same week does *not* exist in the next (only last) year. So, set week to max week next year.
        $selectedYear = $selectedYear + 1;
        $yearPart = $yearPart . $selectedYear;
        $weekPart = $weekPart . $maxWeek;
    }

    if ($selectedYear < $maxYear-1) {
        // Next year exists - so far, so good..
        $selectedYear = $selectedYear + 1;
        $yearPart = $yearPart . $selectedYear;
        // but what about the week - yes - all previous years have all weeks.
        $weekPart = $weekPart . $selectedVecka;
    }

    $link = $baseLink1 . $baseLink2;
    if ($disabled){
       $link = $baseLink1 . $disabledClass . $baseLink2;
    }

    return $link . $yearPart . $weekPart . $languagePart .'">' . $linkText . '</a>';

}


function getPreviousYearLink($selectedVecka, $selectedYear, $texts, $language){

    // final
    // <a href="#" class="btn btn-outline-primary disabled" role="button" aria-disabled="true">&laquo;&laquo;&nbsp;<?= $texts->getTxt('Ar') </a>
    $baseLink1 = '<a class="btn btn-outline-primary btn-sm';
    $disabledClass = ' disabled';
    $disabled = false;
    $baseLink2 = '" role="button" aria-disabled="true" href="/rastrakning/index.php?';
    $minYear = "1993";
    $linkText = '&laquo;&laquo;&nbsp;' . $texts->getTxt('bladdra-ar') ;
    $yearPart = 'year=';
    $weekPart = '&vecka=';
    $languagePart = getLanguageParameter($language);
    $selectedYear = intval($selectedYear);

    if ($selectedYear == $minYear){
        // no link in this case, no previous year
        $disabled = true;
    } else {
        // Previous year exist
        // The same week does always exist, even in the first year as the counts starts week 1. (week 53 is ignored)
        $selectedYear = $selectedYear - 1;
        $yearPart = $yearPart . $selectedYear;
        $weekPart = $weekPart . $selectedVecka;
    }

    $link = $baseLink1 . $baseLink2;
    if ($disabled){
        $link = $baseLink1 . $disabledClass . $baseLink2;
    }

    return $link . $yearPart . $weekPart . $languagePart .'">' . $linkText . '</a>';

}


function getPreviousWeekLink($selectedVecka, $selectedYear, $texts, $language){

    $minYear = "1993";
    $baseLink1 = '<a class="btn btn-outline-primary btn-sm';
    $disabledClass = ' disabled';
    $disabled = false;
    $baseLink2 = '" role="button" aria-disabled="true" href="/rastrakning/index.php?';
    $linkText = '&laquo;&nbsp;' . $texts->getTxt('bladdra-vecka') ;

    $yearPart = 'year=';
    $weekPart = '&vecka=';
    $languagePart = getLanguageParameter($language);

    if (($selectedYear == $minYear) && ($selectedVecka == 1)){
        // no link in this case, no previous week - the first ever week already selected
        $disabled = true;
    } elseif (($selectedYear == $minYear) && ($selectedVecka > 1)) {  // first year week 2 or later
        // all cases - previous week exists
        // The same week does always exist, also in the first year as the counts started week 1.
        $yearPart = $yearPart . $selectedYear;
        $selectedVecka = $selectedVecka - 1;
        $weekPart = $weekPart . $selectedVecka;

    } elseif (($selectedYear > $minYear) && ($selectedVecka == 1)) { // special case 1 -> 52 AND previous year
        $selectedYear = $selectedYear - 1;
        $selectedVecka = 52;
        $yearPart = $yearPart . $selectedYear;
        $weekPart = $weekPart . $selectedVecka;

    } else {  // standard case, previous week same year
        $selectedVecka = $selectedVecka -1;
        $yearPart = $yearPart . $selectedYear;
        $weekPart = $weekPart . $selectedVecka;
    }

    $link = $baseLink1 . $baseLink2;
    if ($disabled){
        $link = $baseLink1 . $disabledClass . $baseLink2;
    }

    return $link . $yearPart . $weekPart . $languagePart .'">' . $linkText . '</a>';

}

function getLanguageParameter($language){

    $languageParameter = '';
    if ($language == 'en'){
        $languageParameter = '&language=en';
    }

    return $languageParameter;
}