<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class QnFileControllerDb{ 
		public $db;
		public function __construct(){
			$this->db = new QnFileModel(); 
		}
		// ***
		public function QueryTestPaperActive()	{
			return $this->db->QueryTestPaperActive();
		}
		
		public function QueryUserTestTakingPaper($p_quiz_id)	{
			return $this->db->QueryUserTestTakingPaper($p_quiz_id);
		}
		
		public function QueryUTTPQuestion($p_quiz_id){
			return $this->db->QueryUTTPQuestion($p_quiz_id);
		}
		
		public function QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule){
			return $this->db->QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule);
		}
		
		public function QnDataSave($qn_id, $qn_text, $options){
			return $this->db->QnDataSave($qn_id, $qn_text, $options);
		}		
    }