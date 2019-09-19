<?php

class DBMssql extends DB {
	
	public function __construct() { 
    	
        try{

            $os = strtoupper(substr(PHP_OS, 0, 3));

            switch( $os ) {
                
                case 'WIN':
        		
    	            $this->_pdo = new PDO(	'sqlsrv:Server=' .Config::get('mssql/host')
    					            		.',' .Config::get('mssql/port')
    					            		.';Database=' .Config::get('mssql/db'),
    					            		Config::get('mssql/username'),
    					            		Config::get('mssql/password')
    	            					);
                    break;
                    
                case 'LIN':
                    
    	            $this->_pdo = new PDO(	'dblib:host=' .Config::get('mssql/host')
    					            		.':' .Config::get('mssql/port')
    					            		.';dbname=' .Config::get('mssql/db')
    					            		.';charset=utf8',
    					            		Config::get('mssql/username'),
    					            		Config::get('mssql/password')
    	            					);
                    break;
            }
//             $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
        	
        	$this->setError($e->getMessage());
        }
    }
    
    public static function getInstance(){

        if ( is_null(self::$_instance) ){
        
        	$db = new DBMssql();
        
        	if ( !$db->error() ) {
        
        		self::$_instance = $db;
        	}
        }
        return self::$_instance;
    }
    
} 