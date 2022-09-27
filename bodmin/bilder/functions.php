<?php


function getPhotosTableAsHTML($pdo, $data){

    $html = '<table id="data" class="table table-hover table-bordered w-auto mb-0">
            <thead>
                <tr>
                    <th id="tblHdrPhoto">Xxxx</th>
                    <th id="tblHdrData">xxxx</th>
                </tr>
            </thead>
            <tbody>';
    foreach($data as $photo){
        $html = $html . getPhotoTableRow($pdo, $photo);
    }

    $html = $html . '
           </tbody>
           </table>';

    return $html;

}


function getPhotoTableRow($pdo, $photo)
{

    $html = '<tr id="' . $photo['IMAGE_ID'] . '">';
    $html = $html . '<td><img src="/v2bilder/minipics/minipic-' . $photo["IMAGE_ID"] . '.jpg' . '" alt="species"></td>';
    $html = $html . '<td>';
    $html = $html . '<span class="tblMetaDataPhotographer"></span>' . $photo["FULLNAME"] . '<br/>';
    $html = $html . '<span class="tblMetaDataTaxa"></span>' . getTaxaNamesForPhoto($pdo, $photo["IMAGE_ID"], $_SESSION["preferredLanguageId"]) . '<br/>';
    $html = $html . '<span class="tblMetaDataKeywords"></span>' . getKeywordTextsForPhoto($pdo, $photo["IMAGE_ID"]) . '<br/>';
    $html = $html . '<span class="tblMetaDataPlace"></span>' . $photo["PLATS"] . '<br/>';
    $html = $html . '<span class="tblMetaDataDateTaken"></span>' . $photo["DATUM"] . '<br/>';
    $html = $html . '<span class="tblMetaDataUploaded"></span>' . $photo["CREATED_AT"] . '<br/>';
    $html = $html . '<span class="tblMetaDataPublished"></span>';
    if ($photo['PUBLISHED'] === '1') {
        $html = $html . '<span class="yes"></span>';
    } else {
        $html = $html . '<span class="no"></span>';
    }
    $html = $html . '<br/><span class="tblMetaDataURL">URL: </span>' . $_SERVER['HTTP_HOST'] .'/v2bilder/maxipics/maxipic-' . $photo["IMAGE_ID"] . '.jpg';
    $html = $html . '<br/></td>';
    $html = $html . '</tr>';
    return $html;
}


function getTaxaNamesForPhoto($pdo, $bild_id, $lang_id){


    $taxaData = getTaxaDataForPhoto($pdo, $bild_id, $lang_id);
    $resultString = "";

    foreach ($taxaData as $aTaxa){
        $resultString .= $aTaxa['NAME'] . ', ';
    }

    //$answer = substr($resultString, 0, strlen($resultString)-2);
    //$answer = $resultString;

    return substr($resultString, 0, strlen($resultString)-2);;

}


function getKeywordTextsForPhoto($pdo, $bild_id){

    $KeywordsData = getKeywordsForPhoto($pdo, $bild_id, $_SESSION["preferredLanguageId"]);
    $resultString = "";

    if (sizeof($KeywordsData) > 0) {

        foreach ($KeywordsData as $aKeywordData) {
            $resultString = $resultString . $aKeywordData['TEXT'] . ', ';
        }

        $resultString = substr($resultString, 0, strlen($resultString) - 2);
    }

    return $resultString;

}


function getKeywordTextsForImage($pdo, $bild_id, $lang){

    $KeywordsData = getKeywordsForPhoto($pdo, $bild_id, $lang);
    $resultString = "";

    if(sizeof($KeywordsData) > 0){

        foreach ($KeywordsData as $aKeywordData){
            $resultString = $resultString . $aKeywordData['TEXT'] .', ';
        }
        $resultString = substr($resultString, 0, strlen($resultString)-2);

    }


    return $resultString;

}


