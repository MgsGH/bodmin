<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/common-functions.php';
include_once $path . "/aahelpers/PageMetaData.php";

$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('index.js?dummy=' . $t);

$language = getRequestLanguage();;
echo getHtmlHead('', $pageMetaData, $language);

// Unset all the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
    <div class="container">
        <br/>
        <h1 id="hdrMain">t</h1>
        <p id="tack"></p>
        <div class="mg-white-smoke container">
            <br>
            <p><a href="/bodmin/index.php"><span id="logInAgain"></span></a></p>
            <br>
        </div>

    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());


