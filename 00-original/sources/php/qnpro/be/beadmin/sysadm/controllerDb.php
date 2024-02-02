<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class SysAdmControllerDb{ 
		public $db;
		public function __construct(){
			$this->db = new SysAdmModel(); 
		}
		// ***
		public function QueryNow()	{
			return $this->db->QueryNow();
		}

        public function QueryTestCountTotal()	{
			return $this->db->QueryTestCountTotal();
		}

        public function QueryTestCountLive()	{
			return $this->db->QueryTestCountLive();
		}


        public function QueryTestCountAnswered()	{
			return $this->db->QueryTestCountAnswered();
		}
		public function QueryTestStatus()	{
			return $this->db->QueryTestStatus();
		}

        public function QueryTestIsDemo()	{
			return $this->db->QueryTestIsDemo();
		}
        
        public function WriteAssignmentSetStatus($p_assignment_id,$p_status){
			return $this->db->WriteAssignmentSetStatus($p_assignment_id,$p_status);
		}

		//
		public function QueryCodeQnTestCountTotal()	{
			return $this->db->QueryCodeQnTestCountTotal();
		}

        public function QueryCodeQnTestCountLive()	{
			return $this->db->QueryCodeQnTestCountLive();
		}


        public function QueryCodeQnTestCountAnswered()	{
			return $this->db->QueryCodeQnTestCountAnswered();
		}
		public function QueryCodeQnTestStatus()	{
			return $this->db->QueryCodeQnTestStatus();
		}

        public function QueryCodeQnTestIsDemo()	{
			return $this->db->QueryCodeQnTestIsDemo();
		}
        public function QueryCodeQnTestCases()	{
			return $this->db->QueryCodeQnTestCases();
		}

		public function WriteCodeQnAssignmentSetStatus($p_assignment_id,$p_status){
			return $this->db->WriteCodeQnAssignmentSetStatus($p_assignment_id,$p_status);
		}

		//
		public function QueryAptJobConfig()	{
			return $this->db->QueryAptJobConfig();
		}
		public function QueryAppHmStartup()	{
			return $this->db->QueryAppHmStartup();
		}
		public function QueryMeta()	{
			return $this->db->QueryMeta();
		}

		public function DoDownload()	{
			return $this->db->DoDownload();
		}

		public function DoUpload($db)	{
			return $this->db->DoUpload($db);
		}
        
    }