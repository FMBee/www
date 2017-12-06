<?php

class Log {
	
	private $_handle,
			$_error = false;
	
	public function __construct($file, $mode = 'a+'){
		
		$this->_handle = fopen($file, $mode);
		
		$this->_error = !$this->_handle;
	}
	
	public function put($line, $stamp = null, $eol = true) {
		
		$this->_error = !fwrite(	$this->_handle, 
									(is_null($stamp) ? date('H:i:s-') .gettimeofday()['usec'] : $stamp) .' ' 
									.$line 
									.($eol ? PHP_EOL : '')
								);
	}

	public function init() {
		
		$this->put('*--------------------------------*', '');
		$this->put(date('r') .' process begins');
	}
	
	public function close($echo = true) {
	
		if( $echo )		$this->put(date('r') .' end of process');
		
		fclose($this->_handle);
	}
	
	public function error() {
		
		return $this->_error;
	}
	
	
}