<?php

require_once 'lib/PHPExcel/PHPExcel.php';

class classeurPHPExcel {
	
	private	$_classeur,
			$_feuille,
			$_header,
			$_line,
			$_tmpfile
			;
	
	public function __construct($filename) {
		
		if ( !is_file('./' .$filename) ) {
 		
			$this->_tmpfile = $filename;
			
			$this->_classeur = new PHPExcel();
			$this->_feuille = $this->_classeur->setActiveSheetIndex(0);
			
			return true;
		}
		else 
			return false;
	}

	public function headline($lig, $col, $value) {
		
		$this->_feuille->setCellValueByColumnAndRow($col, $lig, $value);
	}
	
	public function tabline($lig, $col, $value) {
		
		$this->_feuille->setCellValueByColumnAndRow($col, $lig, $value);
	}
	
	public function close() {
		
		PHPExcel_IOFactory::	createWriter($this->_classeur, 'Excel2007')
								->save($this->_tmpfile);
	}
	
}