<?php

include_once '../aahelpers/db.php';

deleteBlogEntry(getPDO(), $_POST['id'], $_POST['blogId']);

