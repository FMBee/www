<?php

class FTP {
	
    private static $_instance = null;
    private static $_message;

    private $_MESS = array(
    		1 => 'Réseau inaccessible',
    		2 => 'Problème de connexion serveur',
    		3 => 'Transfert(s) effectué(s)',
    		4 => 'Problème lors du transfert FTP',
    		5 => 'Problème lors du login FTP'
    );
    
    private 	$_connecId,
    			$_error = false,
    			$_putCount = 0,
    			$_getCount = 0,
    			$_delCount = 0
    ;

    public function __construct($mode = 'curl', $passive = false) {
    	
        try{
        	if( $mode == 'curl' ) {
        		
	        	$ch = curl_init(Config::get('ftp/server'));
	
	        	if( curl_errno($ch) ) {
	        		
	        		$this->setError($this->_MESS[1] .curl_error($ch));
	        	}
	        	else{
	        		curl_close($ch);
	        	}
        	}
        	else{
	        	if( !($ch = fsockopen(Config::get('ftp/server'), 21, $errno, $errstr)) ) {   //pas de retour si aucune connexion internet
	        	
	        		$this->setError($this->_MESS[1] .$errstr);
	        	}
	        	else{
	        		fclose($ch);
	        	}
        	}
        	
        	if ( $ch ) {
        		
        		$this->_connecId = ftp_connect(Config::get('ftp/server'));
        	
        		if(! $this->_connecId) {
        	
        			$this->setError($this->_MESS[2]);
        		}
        		else {
        			if( ftp_login(	$this->_connecId, 
        								Config::get('ftp/username'),
        								Config::get('ftp/password')) ) {
        				
        				if( $passive ){
        					
        					ftp_pasv($this->_connecId, true);
        				}
        			}
        			else{
        				$this->setError($this->_MESS[5]);
        				$this->close();
        			}
        		}
        	}
        	
        }catch(Exception $e){

			$this->setError($e->getMessage());
        }
    }

    public static function getInstance(){

        if ( is_null(self::$_instance) ){

        	$ftp = new FTP();
            
            if ( !$ftp->error() ) {

            	self::$_instance = $ftp;
            }
        }
        return self::$_instance;
    }
    
    public static function message(){
    	
        return self::$_message;
    }
    
    public function close() {
    	
    	ftp_close($this->_connecId);
    }

    private function setError($message) {
    	
    	$this->_error = true;
    	self::$_message = $message;
    }
    
    public function put($fromFile, $toFile, $mode = FTP_BINARY) {
    	
		if (ftp_put($this->_connecId, $fromFile, $toFile, $mode)) {
		
			$this->_putCount++;
			return true;
		}
		else{
			$this->setError($this->_MESS[4]);
			return false;
		}
    }   
    
    public function get($fromFile, $toFile, $mode = FTP_BINARY) {
    	
		if (ftp_get($this->_connecId, $fromFile, $toFile, $mode)) {
		
			$this->_getCount++;
			return true;
		}
		else{
			$this->setError($this->_MESS[4]);
			return false;
		}
    }    

    public function delete($file) {
    	
    	if ( ftp_delete($this->_connecId, $file) ) {
    		
			$this->_delCount++;
			return true;
		}
		else{
			$this->setError($this->_MESS[4]);
			return false;
    	}
    }
    public function error(){
    	
        return $this->_error;
    }

    public function putCount(){
    	
        return $this->_putCount;
    }

    public function getCount(){
    	
        return $this->_getCount;
    }
    
} 