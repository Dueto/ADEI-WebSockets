<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sqlquerys
 *
 * @author amatveev
 */


class sqlQuerys 
{
    var $connection = null;

    
    
    function sqlQuerys()
    {
        try
        {
            $this->connection = new \PDO('mysql:host=localhost:3306;dbname=adei;charset=utf8mb4', 
                             'root', 
                             'root', 
                        array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
                            );
        }
        catch(\PDOException $ex)
        {
            echo($ex->getMessage());
        }
        
    }
    
    function selectData($request)
    {
       $cachedb = new CACHEDB($request);
       $tableName = $cachedb->GetCachePostfix();
       
       
        
        try
        {
            $state = $this->connection->prepare('SHOW COLUMNS FROM  ' . $tableName . ' LIKE  "%ns%"');
            $state->execute();
            $mscolumn = $state->fetchAll(\PDO::FETCH_OBJ);
            
            if(count($mscolumn) != 0)
            {
                $columns = $columns . ',`ns`';
            }
            
            $handler = $this->connection->prepare('SELECT ' . $columns . ' FROM `' . $tableName . '` WHERE (`time` <= ?) AND (`time` >= ?) AND (`time` LIKE ?) ORDER BY `time`');
                                   
            $handler->bindValue(1, $rightTime, \PDO::PARAM_STR);
            $handler->bindValue(2, $leftTime, \PDO::PARAM_STR); 
            $handler->bindValue(3, $level, \PDO::PARAM_STR);            
            
            $handler->execute();

            $result = $handler->fetchAll(\PDO::FETCH_OBJ);

            return $result;            
        }
        catch(\PDOException $ex)
        {   
            throw $ex;
        }
        
    }
}
