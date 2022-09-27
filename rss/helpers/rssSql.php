<?php

function rss_getADBConnection(){

/*
    $server = 'localhost';
    $user = 'web';
    $password = 'MIkcHZkwCRu8VuRv';
    $database = 'hkghbhzh_fbodata';
*/

    // production
    // https://cpsrv04.misshosting.com:2083
//    $server = 'https://cpsrv04.misshosting.com';

    $server = 'localhost';
    $user = 'hkghbhzh_persona';
    $password = '03nanth3456';
    $database = 'hkghbhzh_fbodata';

    $connection = mysqli_connect($server, $user, $password, $database);

    $sql = "SET NAMES 'utf8' COLLATE 'utf8_general_ci'";
    mysqli_query($connection, $sql);

    $sql = "SET CHARACTER_SET utf8";
    mysqli_query($connection, $sql);

    return $connection;

}


function rss_getDaysWithNews($connection){

    $sql="SELECT CONCAT(DATE_FORMAT(dagbdatum,'%a, %d %b %Y %T'), ' +0000') RSSDATE, dagbdatum DAG from dagboksblad order by dagbdatum DESC";

    $query=mysqli_query($connection, $sql) or die (mysqli_error($connection));

    return $query;
}


function rss_getRingingLocations($connection, $day){

    $sql = "SELECT p FROM rmdagsum where rmdagsum.datum='$day' and rmdagsum.p<>'ÖV'
                UNION SELECT p FROM ovda2sum where ovda2sum.datum='$day'
                ORDER BY p";
    $query = mysqli_query($connection, $sql);

    return $query;

}


function rss_getRingingDataforLocationAndDay($connection, $location, $day){

    $sql = "select ALLDAGSUMWITHNAMES.svnamn, ALLDAGSUMWITHNAMES.ENGNAMN, ALLDAGSUMWITHNAMES.LATNAMN, ALLDAGSUMWITHNAMES.summa from ALLDAGSUMWITHNAMES 
                where ALLDAGSUMWITHNAMES.p='$location' and ALLDAGSUMWITHNAMES.datum='$day' order by ALLDAGSUMWITHNAMES.snr";
    $locationDayData = mysqli_query($connection, $sql) or die(mysqli_error($connection));

    return $locationDayData;
}