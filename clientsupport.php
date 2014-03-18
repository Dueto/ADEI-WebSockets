<?php
require_once("requestobj.php");
require_once("sqlquerys.php");
require_once('websockets.php');
 
class clientSupport extends WebSocketServer 
{
    protected function process ($user, $message) 
    {
        $stringToSend = 'Date/Time';
        $req = explode(';', $message);
        $reqObj = new reqObject($req[0], $req[1], $req[2], $req[3], $req[4], $req[5], $req[6]);
        $link = new sqlQuerys();
        $results = $link->selectData($reqObj);
        if(count($results) != 0)
        {
            $channels = explode(',', $req[3]);
            foreach ($channels as $channel)
            {
                $stringToSend = $stringToSend . "," . $reqObj->getChannelLabel($channel);
            }
            foreach ($results as $elem)
            {
                $time = $this->formatTime($elem);
                $stringToSend = $stringToSend . "\n" . $time . "," . $elem->{$reqObj->getAggregator() . $reqObj->getDb_mask()};
            }
                //send csv string
            $this->send($user, $stringToSend);   
        }
        else
        {
            $this->send($user, 'No data.');
        }
    }
    
    protected function connected ($user) 
    {   
    }
    
    protected function closed ($user) 
    {       
    }
    
    protected function formatTime($elem)
    {
        $time = str_replace(' ', 'T', $elem->{'time'});
        if(property_exists($elem, 'ns'))
        {
            $time = $time . '.' . $elem->ns;
        }
        else
        {
            $time = $time . '.000000';
        }
        return $time;
    }
    
}
 



