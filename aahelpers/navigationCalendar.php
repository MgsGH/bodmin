<?php

       //getNavigationCalendarTableAsHTML($language, $eventDates, $year, $month, $day)
function getNavigationCalendarTableAsHTML($language, $eventDatesAsArray, $year, $month, $selectedDate){

    $str = '<div class="middle">' . getCalendarHeader($language, $year, $month );
    $str = $str . getCalendarCellsThisMonth($eventDatesAsArray, $year, $month, $selectedDate);
    return $str . '</div>';

}


function getCalendarHeader($language, $year, $month){

    if (substr($month, 0, 1) == '0'){
        $month = substr($month, 1,1);
    }
    $texts = getCalendarTexts($language);

    $table_caption = $texts[$month]; // current
    $mo = $texts['Mo'];
    $tu = $texts['Tu'];
    $we = $texts['We'];
    $th = $texts['Th'];
    $fr = $texts['Fr'];
    $sa = $texts['Sa'];
    $su = $texts['Su'];

    $thisURL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $priorYear = $year - 1;
    $nextYear = $year + 1;
    $nextYearURL = getRewrittenURL('year', $nextYear, $thisURL);
    $nextYearURL = getRewrittenURL('month', $month, $nextYearURL);
    $priorYearURL = getRewrittenURL('year', $priorYear, $thisURL);
    $priorYearURL = getRewrittenURL('month', $month, $priorYearURL);
    $nextMonthURL = getNextMonthURL($year, $month, $thisURL);
    $priorMonthURL = getPriorMonthURL($year, $month, $thisURL);
    $headerString = '
		<table class="cal_table">
			<tr>				
				<th class="cal_head_side"><a href="' . $priorYearURL . '"><<</a></th>
				<th class="cal_head text-center" colspan="5">' . $year . '</th> 
				<th class="cal_head_side"><a href="' . $nextYearURL . '">>></a></th>
			</tr>
            <tr>				
				<th class="cal_head_side"><a href="' . $priorMonthURL .  '"><<</a></th>
				<th class="cal_head text-center" colspan="5">' . $table_caption . '</th> 
				<th class="cal_head_side"><a href="' . $nextMonthURL . '">>></a></th>
			</tr>
			<tr>
				<th class="cal_sub_head cal_text">'.$mo.'</th>
				<th class="cal_sub_head cal_text">'.$tu.'</th>
				<th class="cal_sub_head cal_text">'.$we.'</th>
				<th class="cal_sub_head cal_text">'.$th.'</th>
				<th class="cal_sub_head cal_text">'.$fr.'</th>
				<th class="cal_sub_head cal_text">'.$sa.'</th>
				<th class="cal_sub_head cal_text">'.$su.'</th>
			</tr>';

    return $headerString;

}


/*
 *
 * Number of cells in the calender is opening empty cells + number of days in month.
 * If this is an even multiple of 7, no closing cells.
 *
 */

function getCalendarCellsThisMonth( $eventDatesAsArray, $year, $month, $selectedDate ){

    // local variables
    $numberOfDaysInMonth = getNoOfDaysInMonth($year, $month);
    $startWeekDayOfTheMonth = getFirstWeekDayOfTheMonth($year, $month); //
    $dayOfMonth = 1;
    $doneIntroDays = false;
    $thisURL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $ringingDays = $eventDatesAsArray;
    $htmlString = '';

    //----------------------------------------------------------------------------------------
    //Loop through the days of the month, each week in a row.
    while ( $dayOfMonth <= $numberOfDaysInMonth) {

        $htmlString = $htmlString . '<tr>';
        if (!$doneIntroDays) {
            $htmlString = $htmlString . getCalendarOpeningCells($startWeekDayOfTheMonth);
            $doneIntroDays = true;
            $thisWeekDay = $startWeekDayOfTheMonth;
        } else {
            $thisWeekDay = 1;
        }

        while (($thisWeekDay <= 7) && ($dayOfMonth <= $numberOfDaysInMonth)) {

            $currentCellDate = getDayAsYmdString($year, $month, $dayOfMonth);

            // check the styling to apply to this cell
            $class = "cal_content"; // default day-class
            $eventThisDay = false;
            // check if today
            if ( $currentCellDate == getCurrentDateAsYMD() ){
                $class = "cal_today";
            } elseif ($currentCellDate == $selectedDate) {
                    $class = "cal_vald_dag";
                } else {
                    $eventThisDay = calCheckIfDateExists($ringingDays, $currentCellDate);
                    if ( $eventThisDay ){
                        $class = 'cal_event';
                    }
                }

            // apply formatting
            $htmlString = $htmlString . '<td class="' . $class .'">';

            // Build content to put in this cell
            // Default with this days "number" i.e. 02
            $cellContent = $dayOfMonth;
            // is there any event this day (checked above already) if yes, build the link, with existing params set.
            if ( $eventThisDay ) {
                if ($currentCellDate !== $selectedDate) {
                    $cellContent = '<a href="' . getRewrittenURL('dag', $dayOfMonth, $thisURL) . '">' . $dayOfMonth . '</a>';
                }
            }

            $htmlString = $htmlString . $cellContent . '</td>';

            $dayOfMonth++;
            $thisWeekDay++;

        }

        if ($thisWeekDay <7){
            $htmlString = $htmlString . getCalendarWeekLastClosingCells($thisWeekDay);
        }

        $htmlString = $htmlString . '</tr>';

    }


    return  $htmlString . '</table>';
}


function getCalendarWeekLastClosingCells($fromWeekDay){

    $newRow = "\n\r";
    $htmlString = "";

    //Fill the last cells
    for($day = $fromWeekDay; $day <= 7; $day++ ) {
        $htmlString = $htmlString . '<td class="cal_content">&nbsp;</td>' . $newRow;
    }

    return $htmlString;

}


function getCalendarOpeningCells($startWeekWeekDayOfTheMonth){

    $newRow = "\n\r";
    $htmlString = "";

    //The empty cells before the 1st day of the month
    for($day = 1; $day < $startWeekWeekDayOfTheMonth; $day++ )
    {
        $htmlString =  $htmlString . '<td class="cal_content">&nbsp;</td>' .$newRow;
    }

    return $htmlString;
}


function getCalendarTexts($language){

    $texts['Mo'] = 'Må';
    $texts['Tu'] = 'Ti';
    $texts['We'] = 'On';
    $texts['Th'] = 'To';
    $texts['Fr'] = 'Fr';
    $texts['Sa'] = 'Lö';
    $texts['Su'] = 'Sö';
    $texts['1'] = 'januari';
    $texts['2'] = 'februari';
    $texts['3'] = 'mars';
    $texts['4'] = 'april';
    $texts['5'] = 'maj';
    $texts['6'] = 'juni';
    $texts['7'] = 'juli';
    $texts['8'] = 'augusti';
    $texts['9'] = 'september';
    $texts['10'] = 'oktober';
    $texts['11'] = 'november';
    $texts['12'] = 'december';

    if ($language == 'en'){
        $texts['Mo'] = 'Mo';
        $texts['Tu'] = 'Th';
        $texts['We'] = 'We';
        $texts['Th'] = 'Th';
        $texts['Fr'] = 'Fr';
        $texts['Sa'] = 'Sa';
        $texts['Su'] = 'Su';
        $texts['1'] = 'January';
        $texts['2'] = 'February';
        $texts['3'] = 'March';
        $texts['4'] = 'April';
        $texts['5'] = 'May';
        $texts['6'] = 'June';
        $texts['7'] = 'July';
        $texts['8'] = 'August';
        $texts['9'] = 'September';
        $texts['10'] = 'October';
        $texts['11'] = 'November';
        $texts['12'] = 'December';

    }

    return $texts;
}


function getPriorMonthURL($selectedYear, $selectedMonth, $url){


    // Determine the previous/next month/year for the calender header, based on currently selected month
    // -------------------------------------------------------------------------------------------------


    // December
    if( $selectedMonth == 12 ){
        $yearForPreviousLink = $selectedYear;   // The same
        $previous_month = 11;
    }

    // January..
    if( $selectedMonth == 1 ){
        $yearForPreviousLink = $selectedYear-1; //ex. 2009-1
        $previous_month = 12;
    }

    // All other months
    if (( $selectedMonth < 12 ) && ($selectedMonth > 1)) {
        $yearForPreviousLink = $selectedYear;               // the same  as now
        $previous_month = $selectedMonth - 1;
    }


    $newURL = getRewrittenURL('year', $yearForPreviousLink, $url);
    $newURL = getRewrittenURL('month', $previous_month, $newURL);

    return $newURL;



}


function getNextMonthURL($selectedYear, $selectedMonth, $url){



    // Determine the next month/year for the calender header, based on currently selected year and month
    // -------------------------------------------------------------------------------------------------
    // dummy below - not really needed
    $yearForNextLink = $selectedYear+1;     // New next ex. 2008+1
    $next_month = 1;                        // 1 (jan)

    // December
    if( $selectedMonth == 12 ){
        $yearForNextLink = $selectedYear+1;     // New next ex. 2008+1
        $next_month = 1;                        // 1 (jan)
    }

    // January..
    if( $selectedMonth == 1 ){
        $yearForNextLink = $selectedYear;
        $next_month = 2;
    }

    // All other months
    if (( $selectedMonth < 12 ) && ($selectedMonth > 1)) {
        $yearForNextLink = $selectedYear;                   // the same as now
        $next_month = $selectedMonth + 1;
    }

    $newURL = getRewrittenURL('year', $yearForNextLink, $url);
    $newURL = getRewrittenURL('month', $next_month, $newURL);

    return $newURL;
}


function getDayAsYmdString($year, $month, $day){

    if (strlen($day) == 1){
        $day = '0' . $day;
    }

    if (strlen($month) == 1){
        $month = '0' . $month;
    }

    return $year . '-' . $month . '-' . $day;

}


function getFirstWeekDayOfTheMonth($year, $month){

    //----------------------------------------------------------------------------------------
    setlocale(LC_TIME, 'swedish');
    $date_string = mktime(0,0,0, $month,1,$year);

    $weekDayWeekStart=date("w", $date_string);  //The number of the 1st day of the week OBS. "w" börjar veckan på söndag

    if (($weekDayWeekStart)== 0)
    {
        $weekDayWeekStart = 7;
    }
    else
    {
        $weekDayWeekStart = $weekDayWeekStart - 0;
    }

    return $weekDayWeekStart;
}


function getNoOfDaysInMonth($year, $month){

    $date_string = mktime(0,0,0,$month,1,$year); //The date string we need for some info... saves space
    $noOf = date("t",$date_string); //The total days in the month for the end of the loop
    return $noOf;

}


function calCheckIfDateExists($ringingDays, $currentCellDate): bool
{

    $answer = false;
    $n = count($ringingDays);
    for ($i=0; $i < $n; $i++){

        if ($ringingDays[$i]['THEDATE'] === $currentCellDate ){
            $answer = true;
            break;
        }

    }
// todo - check here!
    return $answer;

}








