<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class QnFileModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new QnFileSql();
		}
		
		public function QueryTestPaperActive()	{			
			return $this->wmd->QueryNoParam(
					$this->sql->sqlQueryTestPaperActive
				);
		}
		
		public function QueryUserTestTakingPaper($p_quiz_id){
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUserTestTakingPaper, 
					array("p_quiz_id" => $p_quiz_id)
				);
		}
		
		public function QueryUTTPQuestion($p_quiz_id){			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUTTPQuestion, 
					array("p_quiz_id" => $p_quiz_id)
				);
		}
		
		public function QueryQnOpt($p_question_id){			
			return array(
				'Qn' => $this->wmd->QueryParam($this->sql->sqlQn, array("p_question_id" => $p_question_id)),
				'QnOpt' => $this->wmd->QueryParam($this->sql->sqlQnOpt, array("p_question_id" => $p_question_id))
			);
		}
		
		public function QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQuizV2;
			$a_param = array('p_instruction_text' => $instructions, 
				'p_qz_name' => $qz_name, 'p_qz_desc' => $qz_desc, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQuizRule;
			$a_param = array('p_rule_text' => $rule, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}
		
		public function QzAdd($qz_name, $qz_desc, $instructions, $rule){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQuizV2;
			$a_param = array('p_instruction_text' => $instructions, 
				'p_qz_name' => $qz_name, 'p_qz_desc' => $qz_desc);//, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQuizRule;
			$a_param = array('p_rule_text' => $rule);//, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}
		
		public function QnDataSave($qn_id, $qn_text, $options){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQn;
			$a_param = array('p_question_text' => $qn_text, 'p_question_id' => $qn_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQnOpt;
			for ($I = 0; $I < count($options); $I++) {
				$a_param = array(
					'p_option_text' => $options[$I]->option, 
					'p_is_answer' => $options[$I]->is_answer, 
					'p_option_id'=> $options[$I]->option_id);
				array_push($sql,$a_sql);array_push($param,$a_param);
			}
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}		
    }
    		