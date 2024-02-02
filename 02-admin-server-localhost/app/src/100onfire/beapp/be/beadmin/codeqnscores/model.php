<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class CodeQnTestScoresModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new CodeQnTestScoresSql();
		}

        //
		public function QData($p_assignment_id){
			return $this->wmd->QueryParam($this->sql->QData,  
				array("p_assignment_id" => $p_assignment_id));			
		}
		
		public function QAss(){			
			$AssSet = $this->wmd->QueryNoParam($this->sql->QAssSet);
			$mdAssTP = $this->wmd->QueryNoParam($this->sql->QAssTP);
			$mdAssTest = $this->wmd->QueryNoParam($this->sql->QAssTest);
			$mdRptField = $this->wmd->QueryNoParam($this->sql->QRptField);
			$mdRptUsrGroup = $this->wmd->QueryNoParam($this->sql->QRptUsrGroup);
			$res = array('mdAssTP' => $mdAssTP, 'mdAssTest' => $mdAssTest,
				'mdRptField' => $mdRptField, 'mdRptUsrGroup' => $mdRptUsrGroup);
			return $res; 
		}
    }
    		