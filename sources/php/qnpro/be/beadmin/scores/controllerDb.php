<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class McqTestScoresControllerDb{ 
		public $db;
		public function __construct(){
			$this->db = new McqTestScoresModel(); 
		}
		// ***
		public function QData($p_assignment_id){
			return $this->db->QData($p_assignment_id);
		}
		
		public function QAss(){
			return $this->db->QAss();
		}
        
    }