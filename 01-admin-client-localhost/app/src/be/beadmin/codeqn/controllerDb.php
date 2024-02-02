<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class CodeQnControllerDb{ 
		public $db;
		public function __construct(){
			$this->db = new CodeQnModel(); 
		}
		// ***


        public function QueryCodeQn()	{
			return $this->db->QueryCodeQn();
		}

        public function QueryTestCase()	{
			return $this->db->QueryTestCase();
		}

		public function SaveEditedQn($Qn,$TC)	{
			return $this->db->SaveEditedQn($Qn,$TC);
		}

		public function SaveAddQn($Qn,$TC)	{
			return $this->db->SaveAddQn($Qn,$TC);
		}

    }