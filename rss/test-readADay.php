<?php

include_once "helpers/rss_functions.php";

$datum = '2019-04-08';

$text = rss_getTextForDay($datum);

echo $text;







