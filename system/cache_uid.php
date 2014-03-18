<?php

$res = exec('ps xa | grep "cache_uid.php" | grep -v grep | wc -l');
if ($res > 1) exit;

require("../adei.php");

function Update($control) {
    $locator = new UIDLocator($control);
    $locator->UpdateUIDs();
}


try {
    Update(false);
    Update(true);
} catch(ADEIException $e) {
    $e->logInfo(translate("Problem processing uids"));
    echo translate("Error: %s", $e->getInfo());
}
?>