<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class CodeQnModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new CodeQnModelSql();
		}

        //Live Tests Dashboard
        public function QueryCodeQn()	{
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQn);
		}public function QueryTestCase()	{
			return $this->wmd->QueryNoParam($this->sql->QueryTestCase);
		}

		public function SaveEditedQn($Qn, $TC){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQn;
			$a_param = array(
				'p_code_title' => $Qn->code_title,
				'p_code_question' => $Qn->code_question,
				'p_tested_program' => $Qn->tested_program,
				'p_question_id' => $Qn->question_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateTestcase;
			for ($I = 0; $I < count($TC); $I++) {
				$a_param = array(
					'p_input' => $TC[$I]->input, 
					'p_output' => $TC[$I]->output, 
					'p_testcase_id'=> $TC[$I]->testcase_id);
				array_push($sql,$a_sql);array_push($param,$a_param);
			}
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}

		public function SaveAddQn($Qn, $TC){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->InsertQn;
			$a_param = array(
				'p_code_title' => $Qn->code_title,
				'p_code_question' => $Qn->code_question,
				'p_lang_code' => $Qn->lang_code,
				'p_level_no' => $Qn->level_no,
				'p_tested_program' => $Qn->tested_program);
			$resId =  $this->wmd->WriteIdParam($a_sql, $a_param);
			$question_id = $resId['last_id'];
			$a_sql = $this->sql->InsertTestcase;
			for ($I = 0; $I < count($TC); $I++) {
				$a_param = array(
					'p_question_id' => $question_id,
					'p_input' => $TC[$I]->input, 
					'p_output' => $TC[$I]->output, 
					'p_sno' => $TC[$I]->sno);
				array_push($sql,$a_sql);array_push($param,$a_param);
			}
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('resId'=>$resId,'res'=>$res,'sql'=>$sql,'param'=>$param);
		} 
    }
    		