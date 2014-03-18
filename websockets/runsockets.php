<?php
require_once 'clientsupport.php';

       // $host = 'localhost';
       // $port = 12345;         
        //$server = new clientSupport($host , $port );
require '../adei.php';
$req = new REQUEST("http://localhost/adei-branch/adei/services/getdata.php?db_server=autogen&db…default&db_mask=0&experiment=1360081704-1365179304&window=86400&format=csv");
$asd = new CACHEDB($req);

$asddd = $asd->GetCachePostfix();
echo($asddd);
           
?>