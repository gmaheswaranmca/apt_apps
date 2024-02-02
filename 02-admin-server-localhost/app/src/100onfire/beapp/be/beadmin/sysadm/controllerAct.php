<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerAct')) define('DIR_ControllerAct', __DIR__.'/');
	include (realpath(DIR_ControllerAct.'../../../gf/ar6PhpUtil.php'));

	/* Link Name */
	function qInput($f){
		global $phpUtil;
		return $phpUtil->field($f,'');
	}
	$linkName = qInput('LinkCodeName');
	if($linkName!=='')	$RestLinkName = $linkName;
	/* End Link Name */
	
	include (realpath(DIR_ControllerAct.'controllerDb.php'));

    class SysAdmController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new SysAdmControllerDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 


        public function LiveMointorMcqQnTestInit(){
			$now = $this->dodb->QueryNow();		
			$mdTestCountTotal = $this->dodb->QueryTestCountTotal();			 
			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestIsDemo = $this->dodb->QueryTestIsDemo();			
		    //
            $lret = array('now_mysql' => $now, 
						'now_php' => date('Y-m-d H:i:s'),
						'mdTestCountTotal' => $mdTestCountTotal,
						  'mdTestCountLive' => $mdTestCountLive,
                          'mdTestCountAnswered' => $mdTestCountAnswered,
						  'mdTestIsDemo' => $mdTestIsDemo); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

        public function LiveMointorMcqQnTestRightNow(){
			$now = $this->dodb->QueryNow();		

			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestStatus = $this->dodb->QueryTestStatus();
		    //
            $lret = array('now_mysql' => $now, 
						'now_php' => date('Y-m-d H:i:s'),
						'mdTestCountLive' => $mdTestCountLive,
						  'mdTestCountAnswered' => $mdTestCountAnswered,
						  'mdTestStatus' => $mdTestStatus);  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		// 


        public function LiveMointorCodeQnTestInit(){
			$now = $this->dodb->QueryNow();		

			$mdCodeQnTestCountTotal = $this->dodb->QueryCodeQnTestCountTotal();			 
			$mdCodeQnTestCountLive = $this->dodb->QueryCodeQnTestCountLive();
			$mdCodeQnTestCountAnswered = $this->dodb->QueryCodeQnTestCountAnswered();
			$mdCodeQnTestIsDemo = $this->dodb->QueryCodeQnTestIsDemo();			
		    //
            $lret = array('now_mysql' => $now, 
							'now_php' => date('Y-m-d H:i:s'),
							'mdCodeQnTestCountTotal' => $mdCodeQnTestCountTotal,
						  'mdCodeQnTestCountLive' => $mdCodeQnTestCountLive,
                          'mdCodeQnTestCountAnswered' => $mdCodeQnTestCountAnswered,
						  'mdCodeQnTestIsDemo' => $mdCodeQnTestIsDemo); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

        public function LiveMointorCodeQnTestRightNow(){
			$now = $this->dodb->QueryNow();		

			$mdCodeQnTestCountLive = $this->dodb->QueryCodeQnTestCountLive();
			$mdCodeQnTestCountAnswered = $this->dodb->QueryCodeQnTestCountAnswered();
			$mdCodeQnTestStatus = $this->dodb->QueryCodeQnTestStatus();
		    //
            $lret = array('now_mysql' => $now, 
							'now_php' => date('Y-m-d H:i:s'),
							'mdCodeQnTestCountLive' => $mdCodeQnTestCountLive,
						  'mdCodeQnTestCountAnswered' => $mdCodeQnTestCountAnswered,
						  'mdCodeQnTestStatus' => $mdCodeQnTestStatus);  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		// 


        public function LiveMointorAllTestInit(){
			$now = $this->dodb->QueryNow();		

			$mdTestCountTotal = $this->dodb->QueryTestCountTotal();			 
			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestIsDemo = $this->dodb->QueryTestIsDemo();	

			$mdCodeQnTestCountTotal = $this->dodb->QueryCodeQnTestCountTotal();			 
			$mdCodeQnTestCountLive = $this->dodb->QueryCodeQnTestCountLive();
			$mdCodeQnTestCountAnswered = $this->dodb->QueryCodeQnTestCountAnswered();
			$mdCodeQnTestIsDemo = $this->dodb->QueryCodeQnTestIsDemo();			
			$mdCodeQnTestCases = $this->dodb->QueryCodeQnTestCases();	
		    //
            $lret = array('now_mysql' => $now, 
						'now_php' => date('Y-m-d H:i:s'),
						'mdTestCountTotal' => $mdTestCountTotal,
						  'mdTestCountLive' => $mdTestCountLive,
                          'mdTestCountAnswered' => $mdTestCountAnswered,
						  'mdTestIsDemo' => $mdTestIsDemo,
						  'mdCodeQnTestCountTotal' => $mdCodeQnTestCountTotal,
						  'mdCodeQnTestCountLive' => $mdCodeQnTestCountLive,
                          'mdCodeQnTestCountAnswered' => $mdCodeQnTestCountAnswered,						  
						  'mdCodeQnTestIsDemo' => $mdCodeQnTestIsDemo,
						  'mdCodeQnTestCases' => $mdCodeQnTestCases); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

        public function LiveMointorAllTestRightNow($mdRes){
			$now = $this->dodb->QueryNow();		

			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestStatus = $this->dodb->QueryTestStatus();

			$mdCodeQnTestCountLive = $this->dodb->QueryCodeQnTestCountLive();
			$mdCodeQnTestCountAnswered = $this->dodb->QueryCodeQnTestCountAnswered();
			$mdCodeQnTestStatus = $this->dodb->QueryCodeQnTestStatus();
			$mdCodeQnTestCases = $this->dodb->QueryCodeQnTestCases();	
		    //
            $lret = array('now_mysql' => $now, 
						'now_php' => date('Y-m-d H:i:s'),
						'mdTestCountLive' => $mdTestCountLive,
							'mdTestCountAnswered' => $mdTestCountAnswered,
							'mdTestStatus' => $mdTestStatus,
						  	'mdCodeQnTestCountLive' => $mdCodeQnTestCountLive,
						  	'mdCodeQnTestCountAnswered' => $mdCodeQnTestCountAnswered,
						  	'mdCodeQnTestStatus' => $mdCodeQnTestStatus,
							  'mdCodeQnTestCases' => $mdCodeQnTestCases,
							'mdRes' => $mdRes);  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function LiveMointorChangeStatus(){
			$p_assignment_id = $this->q('assignment_id');
			$p_status = $this->q('status');
			$mdRes = $this->dodb->WriteAssignmentSetStatus($p_assignment_id,$p_status);
			$this->LiveMointorAllTestRightNow($mdRes);
		}
		public function LiveMointorCodeQnChangeStatus(){
			$p_assignment_id = $this->q('assignment_id');
			$p_status = $this->q('status');
			$mdRes = $this->dodb->WriteCodeQnAssignmentSetStatus($p_assignment_id,$p_status);
			$this->LiveMointorAllTestRightNow($mdRes);
		}

		//

		public function QueryAppHmStartup(){
			$res = $this->dodb->QueryAppHmStartup();		

            $lret = $res;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		public function QueryMeta(){				
			$res = $this->dodb->QueryMeta();		

			$result = array(
				'response' => $res);

            $lret = $result;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function DoDownload(){
			$login_name = $this->q('login_name');
			$login_password = $this->q('login_password');

			if(!($login_name === md5("maheswaran") && $login_password == md5("victory")))
				$login_status = true;
			
			if($login_status)
				$res = $this->dodb->DoDownload();		
			else
				$res = false;

			$result = array('login_status' => $login_status, 'response' => $res);

            $lret = $result;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function DoUpload(){
			$login_name = $this->q('login_name');
			$login_password = $this->q('login_password');
			$db = $this->q('db');

			if(!($login_name === md5("maheswaran") && $login_password === md5("victory")))
				$login_status = true;
			
			if($login_status)
				$res = $this->dodb->DoUpload($db);		
			else
				$res = false;

			$result = array('login_status' => $login_status, 'response' =>$res);

            $lret = $result;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
    }