<?php

class DBMysql extends DB {

    public function __construct() { 
    	
        try{
            $this->_pdo = new PDO(	'mysql:dbname=' .Config::get('mysql/db')
            						.';host=' .Config::get('mysql/host'),
				            		Config::get('mysql/username'),
				            		Config::get('mysql/password')
            					);
//             $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
        	
        	$this->setError($e->getMessage());
        }
    }

    public static function getInstance(){

        if ( is_null(self::$_instance) ){
        
        	$db = new DBMysql();
        
        	if ( !$db->error() ) {
        
        		self::$_instance = $db;
        	}
        }
        return self::$_instance;
    }

} 