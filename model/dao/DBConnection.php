<?php

class DBConnection {

    private static $instances;

    private function __construct(){

    }

    /**
     * @return \PDO
     */
    public static function getSingletonPDO($db_host = DB_HOST,$db_name = DB_NAME, $db_user = DB_USER, $db_pass = DB_PASS){
        if(empty(self::$instances[$db_host][$db_name])){
            try{
                $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8;';
                self::$instances[$db_host][$db_name] = new \PDO($dsn,$db_user,$db_pass,array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                self::$instances[$db_host][$db_name]->exec("SET NAMES utf8");
                self::$instances[$db_host][$db_name]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
            }
        }
        return  self::$instances[$db_host][$db_name];
    }
}