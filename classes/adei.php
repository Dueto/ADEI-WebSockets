<?php

require($ADEI_ROOTDIR . "/classes/timezone.php");
require($ADEI_ROOTDIR . "/classes/readertime.php");

require($ADEI_ROOTDIR . "/classes/profiler.php");
require($ADEI_ROOTDIR . "/classes/logger.php");

require($ADEI_ROOTDIR . "/classes/request.php");
require($ADEI_ROOTDIR . "/classes/options.php");
require($ADEI_ROOTDIR . "/classes/database.php");
require($ADEI_ROOTDIR . "/classes/datahandler.php");

require($ADEI_ROOTDIR . "/classes/common.php");
require($ADEI_ROOTDIR . "/classes/exception.php");
require($ADEI_ROOTDIR . "/classes/lock.php");
require($ADEI_ROOTDIR . "/classes/loggroup.php");
require($ADEI_ROOTDIR . "/classes/interval.php");
require($ADEI_ROOTDIR . "/classes/mask.php");
require($ADEI_ROOTDIR . "/classes/resolution.php");
require($ADEI_ROOTDIR . "/classes/data.php");

require($ADEI_ROOTDIR . "/classes/axis.php");
require($ADEI_ROOTDIR . "/classes/axes.php");

require($ADEI_ROOTDIR . "/classes/cgroup/sourcetree.php");
require($ADEI_ROOTDIR . "/classes/cgroup/cachewrapper.php");
require($ADEI_ROOTDIR . "/classes/cgroup/cacheset.php");

require($ADEI_ROOTDIR . "/classes/adeidb.php");
require($ADEI_ROOTDIR . "/classes/uidlocator.php");

require($ADEI_ROOTDIR . "/classes/datafilter.php");
require($ADEI_ROOTDIR . "/classes/readerfilter.php");
require($ADEI_ROOTDIR . "/classes/filterdata.php");
require($ADEI_ROOTDIR . "/classes/reader.php");
require($ADEI_ROOTDIR . "/classes/cache.php");

class ADEI extends ADEICommon {
 var $RESPONSE_ENCODING;
 
 var $item_locator;
 var $control_locator;
 
 function __construct() {
    parent::__construct();
    $this->RESPONSE_ENCODING = REQUEST::GetResponseEncoding();

    $this->item_locator = NULL;
    $this->control_locator = NULL;
 }
 
 function __destruct() {
	// Fixing LabVIEW bug (existing at least at Internet Toolkit 6.0.1)
    if ($this->RESPONSE_ENCODING == REQUEST::ENCODING_LABVIEW) {
	echo str_repeat(" ", 1024);
    }
 }
 
 
 function ResolveUID($uid, $control = false) {
    if ($control) {
	if (!$this->control_locator) $this->control_locator = new UIDLocator(true);
	$locator = $this->control_locator;
    } else {
	if (!$this->item_locator) $this->item_locator = new UIDLocator(false);
	$locator = $this->item_locator;
    }    
    return $locator->GetItem($uid);
 }
}


$ADEI = new ADEI();
/*
$ADEI->RequireClass(
    "timezone", "readertime",
    "profiler", "logger",
    "request", "options", "database", "datahandler",
    "common", "exception", "lock", 
    "loggroup", "interval", "mask", "resolution", "data",
    "datafilter", "readerfilter", "filterdata", "reader",
    "adeidb", "cache", "draw", "drawtext", "welcome", "export"
);
*/
?>