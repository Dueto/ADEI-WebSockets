<?php
require '../adei.php';
require_once("requestobj.php");
require_once("sqlquerys.php");
require_once('websockets.php');
 
class clientSupport extends WebSocketServer 
{
    var $req;
    
    protected function process ($user, $message) 
    {
        
        $this->$req = new REQUEST($message);        
        try
        {
            $link = new sqlQuerys();
            $results = $link->selectData($this->$req); 
            if(count($results) != 0)
            {
                $stringToSend = $this->formCsvString($results);                
                $this->send($user, $stringToSend);   
            }
            else
            {
                $this->send($user, 'No data.');
            }
        } 
        catch (Exception $ex) 
        {
            $this->send($user, $ex->getMessage());
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
    
    protected function formCsvString($results)
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
    }
    
}
 



