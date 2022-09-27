<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/common-functions.php';
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/db.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setAdditionalJavaScriptFiles('login.js');

dbLog($path);

$pdo = getDataPDO();



$_SESSION["preferredLanguageId"] = 1;   // this is a work around as we do not know the preferred language - yet.
echo getHtmlHead('None', $pageMetaData, 1);

?>
    <div class="login-box">

        <div>
            <br/>
            <div <div class="d-flex justify-content-center">
                <img src="/aahelpers/img/login/logga-small.png" alt="falsterbo logga" class="rounded mx-auto d-block">
            </div>
            <div class="d-flex justify-content-center">
                <h1 id="hdrMain"></h1>
            </div>
            <div class="d-flex justify-content-center">
                <p id="headerSubText"></p>
            </div>

        </div>

        <div>

            <div class="form-group">
                <label for="username">E-post address</label>
                <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="fornamn.efternamn@somewhere.com">
                <small id="emailHelp" class="form-text text-muted">Vi delar aldrig denna med någon annan.</small>
            </div>
            <div class="form-group">
                <label for="password">Passord</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div id="logging-in" class="mg-hide-element mt-3">
                <div><img src="/aahelpers/img/loading/bullets.gif" alt="loading" class="mx-auto d-block"><br/></div>
            </div>
            <div class="form-group text-center mt-2">
                <button id="btnLogin" class="btn btn-primary">Login</button>
            </div>

        </div>

    </div>


<?php
echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());