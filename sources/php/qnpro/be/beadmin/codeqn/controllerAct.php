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

    class CodeQnController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new CodeQnControllerDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 


        public function CodeQnGet(){
			$mdQn = $this->dodb->QueryCodeQn();			 
			$mdTestCase = $this->dodb->QueryTestCase();		
		    //
            $lret = array('mdQn' => $mdQn,
						  'mdTestCase' => $mdTestCase); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

        public function RunQn(){
			$mdQnData = $this->q('QnData');		 					
			$mdQn = $mdQnData->Qn;
			$mdTC = $mdQnData->TC;
			$Code = $mdQn->tested_program;
			$lang = $mdQn->api_lang_name;
			$ver = $mdQn->api_version_no;
			
			//
			$mdTcStatus = array();
		    //
			for($I = 0; $I < count($mdTC); $I++){
				$eTC = $mdTC[$I];
				$input = $eTC->input;
				$output = $eTC->output;

				$tcRunRes = $this->phpUtil->RunTechCode($Code,$lang,$ver,TRUE, $input);
				$actual_output=$tcRunRes['output']['output'];
				$status = 0;
				if($output === $actual_output)
					$status = 1;
				$eTcRunStatus = array('testcase_id' => $eTC->testcase_id, 'status'=>$status,
									'actual_output'=>$actual_output,
									'runData'=>
								array('Code'=>$Code,'lang'=>$lang,'ver'=>$ver,'input'=>$input,'output'=>$output),
								'tcRunRes' => $tcRunRes);
				array_push($mdTcStatus,$eTcRunStatus);
			}

            //
            $lret = array('mdTcStatus' => $mdTcStatus);  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function RunTC(){
			$mdQnData = $this->q('QnData');		 					
			$mdQn = $mdQnData->Qn;
			$mdTC = $mdQnData->TC;
			$Code = $mdQn->tested_program;
			$lang = $mdQn->api_lang_name;
			$ver = $mdQn->api_version_no;
			$input = $mdTC->input;
			$output = $mdTC->output;
			//
			$tcRunRes = $this->phpUtil->RunTechCode($Code,$lang,$ver,TRUE,$input);
			$actual_output=$tcRunRes['output']['output'];
			$status = 0;
			if($output === $actual_output)
				$status = 1;
			$eTcRunStatus = array('testcase_id' => $mdTC->testcase_id, 'status'=>$status,
								'actual_output'=>$actual_output,
							'runData'=>
						array('Code'=>$Code,'lang'=>$lang,'ver'=>$ver,'input'=>$input,'output'=>$output),
						'tcRunRes' => $tcRunRes);
            //
            $lret = array('mdStatus' => $eTcRunStatus);  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function SaveEditedQn(){
			$mdQnData = $this->q('QnData');		 					
			$mdQn = $mdQnData->Qn;
			$mdTC = $mdQnData->TC;
			
			//
			$saveRes = $this->dodb->SaveEditedQn($mdQn,$mdTC);
            //
            $mdNewQn = $this->dodb->QueryCodeQn();			 
			$mdNewTestCase = $this->dodb->QueryTestCase();		
		    //
            $lret = array('mdQn' => $mdNewQn,
						  'mdTestCase' => $mdNewTestCase,
						'saveRes' => $saveRes); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}

		public function SaveAddQn(){
			$mdQnData = $this->q('QnData');		 					
			$mdQn = $mdQnData->Qn;
			$mdTC = $mdQnData->TC;
			
			//
			$saveRes = $this->dodb->SaveAddQn($mdQn,$mdTC);
            //
            $mdNewQn = $this->dodb->QueryCodeQn();			 
			$mdNewTestCase = $this->dodb->QueryTestCase();		
		    //
            $lret = array('mdQn' => $mdNewQn,
						  'mdTestCase' => $mdNewTestCase,
						'saveRes' => $saveRes); 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
    }