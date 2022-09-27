<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$metaData = array();
//$metaData['authors'] = getPublicationsAuthors ($pdo);
//$metaData['taxa'] = getPublicationsTaxaMetaData ($pdo);
$metaData['keywords'] = getPublicationsKeyWordsMetaData ($pdo);


echo json_encode($metaData);
