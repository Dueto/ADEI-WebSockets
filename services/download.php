<?php

  header("Content-type: text/xml");
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  global $ADEI;
  $ADEI->RequireClass("download");


try {  
  $target = $_GET["target"];    
  $dm = new DOWNLOADMANAGER();    
 
  switch ($target) {
    case "dlmanager_add":	  
      $dm->AddDownload();	    
    break;
    case "dlmanager_remove":
      $dm->RemoveDownload();      
    break;
    case "dlmanager_list":      
      CreateDownloadXml($dm->GetDownloads(), $target);
    break;          
    case "dlmanager_run":
      $dm->DlManagerRun();
    break;  
    case "dlmanager_sort":
      $dm->SortBy();
    break;
    case "dlmanager_details":
      CreateDownloadXml($dm->GetDownloadDetails(), $target);
    break;
    case "dlmanager_download":
      $dm->GetFile();
    break;
    case "dlmanager_toggleautodelete";
      $download = $_GET["dl_id"];		 
      $dm->ToggleAutodelete($download);
    break;
    default:
      throw new ADEIException(translate("Error with download service: Target ( $target ) not valid"));
    break;
  }
} catch(ADEIException $ex) {  
    throw new ADEIException(translate("Error with download service. Target: $target \n Error: $ex"));   
}

  function CreateDownloadXml($props, $mode) {
    $XMLoutput = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    switch ($mode) {
      case 'dlmanager_list':	
	$XMLoutput .= "<result>\n";
	foreach($props as $download) {   
	$XMLoutput .= "<download";
	  foreach($download as $key => $value) {
	    $XMLoutput .= " $key=\"" . htmlentities($value) . "\"";
	  }	
	$XMLoutput .= "></download>\n";
	}	
	$XMLoutput .= "</result>";
      break;
      case 'dlmanager_details':
	$XMLoutput .= "<groups>";
	if(!empty($props['props']['error'])) $XMLoutput .= "<error>" . htmlentities($props['props']['error']) . "</error>";
	$XMLoutput .= "<window><from>{$props['props']['window']['from']}</from><to>{$props['props']['window']['to']}</to></window>"; 	//
	$XMLoutput .= "<data><format>{$props['props']['format']}</format><size>{$props['props']['size']}</size></data>";
	
	foreach($props['groups'] as $gid => $itemlist) {
	  $XMLoutput .= "<group>\n<gname>$gid</gname>";
	  foreach($itemlist as $item => $info){
	    $XMLoutput .= "<item>\n<itemid>{$info['id']}</itemid>\n<itemname>{$info['name']}</itemname>\n</item>\n";	    
	  }
	  $XMLoutput .= "</group>";
	}
	$XMLoutput .= "</groups>";   
      break;
    }
    echo $XMLoutput;        
  }

?>
