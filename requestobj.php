<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of requestObj
 *
 * @author amatveev
 */
class reqObject 
{  
    private $db_server = null;
    private $db_name = null;
    private $db_group = null;
    private $db_mask = null;
    private $window = null;
    private $aggregator = null;
    private $needenLevel = null;
    
    private $leftTime = null;
    private $leftMilisec = null;
    private $rightTime = null;
    private $rightMilisec = null;
    
    private $levels = array(0, 10, 60, 600, 3600, 43200, 432000);    
    private $dataLevel = array(31536000 => '-01-01 00:00:00',
                           2592000 => '-01 00:00:00',
                           86400 =>  ' 00:00:00',                                                 
                           3600 =>  ':00:00',                         
                           60 => ':00' ,      
                           1 => '' ,
                           0 => '');    
    
   private $test_items = array(0 => "Noisy Line",
                                1 => "Cosinus",
                                2 => "Noisy Cosinus",
                                3 => "Sinus",
                                4 => "Wide Sinus",	
                                5 => "Combined Sinuses",	
                                6 => "Fading Sinus"	
                                );    
    private $extra_items = array(0 => "Extra Sinus",
                                 1 => "Extra Cosinus"
                                );
    private $fast_items = array(0 => "Noisy Cosinus",
                                1 => "Combined Cosinus",
                                2 => "Combined Sinus"  
                                );
    
    public function reqObject($_db_server,
                        $_db_name,
                        $_db_group,
                        $_db_mask,
                        $_window,
                        $_aggregator,
                        $_needenLevel)
    {
        $this->setDb_server($_db_server);
        $this->setDb_name($_db_name);
        $this->setDb_group($_db_group);
        $this->setDb_mask($_db_mask);
        $this->setWindow($_window);
        $this->setAggregator($_aggregator);
        $this->setNeedenLevel($_needenLevel);
       
        $this->setLeftTime();
        $this->setLeftMilisec();
        $this->setRightTime();
        $this->setRightMilisec();
        
    }
    
    public function setDb_server($_db_server)
    {
        $this->db_server = $_db_server;
    }
    
    public function setDb_name($_db_name)
    {
        $this->db_name = $_db_name;
    }
    
    public function setDb_group($_db_group)
    {
        $this->db_group = $_db_group;
    }
    
    public function setDb_mask($_db_mask)
    {
        $this->db_mask = $_db_mask;
    }
    
    public function setWindow($_window)
    {
        $this->window = $_window;                
    }
    
    public function setAggregator($_aggregator) 
    {
        $this->aggregator = $_aggregator;        
    }
    
    public function setNeedenLevel($_needenLevel)
    {
        $this->needenLevel = $_needenLevel;
    }
    
    public function setRightTime()
    {
        $this->rightTime = date("Y-m-d H:i:s", $this->splitRightTime());
    }
    
    public function setRightMilisec()
    {
        $this->rightMilisec = $this->splitRightMiliseconds();
    }
    
    public function setLeftTime()
    {
        $this->leftTime = date("Y-m-d H:i:s", $this->splitLeftTime());
    }
    
    public function setLeftMilisec()
    {
        $this->leftMilisec = $this->splitLeftMiliseconds();
    }
    
    public function getDb_server()
    {
        return $this->db_server;
    }
    
    public function getDb_name()
    {
        return $this->db_name;
    }
    
    public function getDb_group()
    {
        return $this->db_group;
    }
    
    public function getDb_mask()
    {
        return $this->db_mask;
    }
    
    public function getWindow()
    {
        return $this->window;                
    }
    
    public function getAggregator()
    {
        return $this->aggregator;
    }
    
    public function getNeedenLevel()
    {
        return $this->needenLevel;
    }
    
    public function getTableName()
    {
        $level = $this->getLevelReq();
        $tableName = 'cache' . $level . '__' . $this->getDb_server() . '__' . $this->getDb_name() . '__' . $this->getDb_group();
        return $tableName;
    }
    
    public function getLevelReq()
    {
        if($this->needenLevel != 0)
        {
            if($this->needenLevel != 60)
            {
                if($this->needenLevel != 3600)
                {
                    if($this->needenLevel != 86400)
                    {
                        return $this->levels[6];
                    }
                    else
                    {
                        return $this->levels[5];
                    }
                }
                else
                {
                    return $this->levels[4];
                }
            }
            else
            {
                return $this->levels[2];
            }
        }
        else
        {
            return $this->levels[0];
        }
    }
    
    public function getLevelInSelect()
    {
        return $this->dataLevel[$this->needenLevel];
    }
    
    public function getLeftTime()
    {
        return $this->leftTime;
    }
    
    public function getRightTime()
    {
        return $this->rightTime;
    }
    
    public function getLeftMiliseconds()
    {
        return $this->leftMilisec;
    }
    
    public function getRightMiliseconds()
    {
        return $this->rightMilisec;
    }
    
    public function getColumnsInSelect() 
    {   
        $channels = explode(',', $this->getDb_mask());
        $columns = '`time`';
        foreach ($channels as $channel)
        {
            $columns = $columns . ',`' . $this->getAggregator() . $channel. '`';
        }        
        return $columns;
                
    }
    
    public function getChannelLabel($channelNumber) 
    {
        if($channelNumber < count($this->test_items))
        {
            if($this->getDb_server() == 'fastgen')
            {   
                if($channelNumber < count($this->fast_items))
                {
                    return $this->fast_items[$channelNumber];                
                }
                else
                {
                    return null;
                }
            }
            else if($this->getDb_group() == 'extra')
                {                
                    if($channelNumber < count($this->extra_items))
                    {
                        return $this->extra_items[$channelNumber];                
                    }
                    else
                    {
                        return null;
                    }
                }
                else
                {
                    return $this->test_items[$channelNumber];
                }        
            }
            else
            {
                return null;
            }
    }
    
    public function splitLeftTime()
    {
        $leftTime = explode('-', $this->window)[0];
        $leftTime = explode('.', $leftTime)[0];
        return $leftTime;
    }
    
    public function splitRightTime()
    {
        $rightTime = explode('-', $this->window)[1];
        $rightTime = explode('.', $rightTime)[0];
        return $rightTime;
    }
    
    public function splitLeftMiliseconds()
    {
        $leftMilisec = explode('-', $this->window)[0];
        $leftMilisec = explode('.', $lefMilisec)[1];
        return $leftMilisec;
    }
    
    public function splitRightMiliseconds()
    {
        $rightMilisec = explode('-', $this->window)[1];
        $rightMilisec = explode('.', $rightMilisec)[1];
        return $rightMilisec;
    }
    
}
