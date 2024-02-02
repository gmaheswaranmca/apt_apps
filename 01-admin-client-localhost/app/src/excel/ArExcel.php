<?php
class ArExcelUser{
	public $username = '';
	public $fullname = '';
	public $password = '';
	public function __construct($dataA, $dataB, $dataC){
		$this->username = $dataA;
		$this->password = $dataB;
		$this->fullname = $dataC;
	}	
}
class ArExcel	
{
	private $exBook = null;
	private $exSheet = null;
	private $exData = null;
	public function __construct(){
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
		include 'PHPExcel/IOFactory.php';
		$this->Init();
	}
	
	public function Init(){
		$excel_file = AR_XL_FILE; //"$inputFileName";
		try {
			$this->exBook = PHPExcel_IOFactory::load($excel_file);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($excel_file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		$this->exSheet = $this->exBook->getActiveSheet();
		$this->exData  = $this->exSheet->toArray(null,true,true,true);		
	}
	public function ExData(){		
		$ls = $this->exData;
		$C = count($ls);
		
		$exUsers = array();
		for($vRow = 2; $vRow <= $C; $vRow++){
			$dataA = trim($ls[$vRow]['A']);
			$dataB = trim($ls[$vRow]['B']);
			$dataC = trim($ls[$vRow]['C']);
			$exUser = new ArExcelUser($dataA, $dataB, $dataC);
			array_push($exUsers, $exUser);
		}
		return $exUsers;
	}
}	



$ValueExcel = new ArExcel();
?>	