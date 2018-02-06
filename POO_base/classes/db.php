<?php

abstract class DB {

	protected  static $_instance = null;
	protected  static $_message;
	
    protected   $_pdo,
    			$_mode = PDO::FETCH_ASSOC,
                $_error = false,
                $_results,
                $_count = 0;

    abstract public function __construct();

    abstract public static function getInstance();

    public static function message(){
    
    	return self::$_message;
    }

    protected function setError($message) {
    	 
    	$this->_error = true;
    	self::$_message = $message;
    }
    
    public function query($sql, $params = array()){

        $this->_error = false;

        if( $query = $this->_pdo->prepare($sql) ){
        	
	        $exec = $query->execute( count($params) ? $params : null );
        	
        	if( $exec ){
            	
                $this->_results = $query->fetchAll($this->_mode);
                $this->_count = $query->rowCount();
            }else{
                $this->setError($query->errorInfo()[2] ." / Erreur de requete : {$sql}");
            }
        }
        return $this;
    }

    public function get($table, $fields = array(), $where = '', $params = array() ){
    	
        if( count($fields) ){
        	
            $sql = "SELECT " .implode(', ', $fields) ." FROM {$table}";
        }
        else{
        	$sql = "SELECT * FROM {$table}";
        }
        
        $sql .= !empty($where) ? " WHERE {$where}" : '';
        	
        return $this->query($sql, $params);
    }

    /*
     * return true/false
     * */
    public function insert($table, $fields){

		$sql = 	"INSERT INTO {$table} (" .implode(', ', array_keys($fields))
				.") VALUES (" .substr(str_repeat('?, ', count($fields)), 0, -2) .")";
		
		$this->query($sql, array_values($fields));
		
		return !$this->error();
    }

    public function update($table, $fields, $id){
    	
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
        	
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }
    }

    public function delete($table, $where = array()){
    	 
    	return $this->action('DELETE', $table, $where);
    }
    
    public function error(){
    	
        return $this->_error;
    }

    public function count(){
    	
        return $this->_count;
    }

    public function results(){
    	
        return $this->_results;
    }

    public function first(){
    	
        return $this->results()[0];
    }

} 