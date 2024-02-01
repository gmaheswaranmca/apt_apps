<?php 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
    $RUN = 1;
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_Controller')) define('DIR_Controller', __DIR__.'/');
	include (realpath(DIR_Controller.'../gf/ar6PhpUtil.php'));

    class ApiControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new ApiController();
			$v_m = $ext->q('clientId');			
			if($v_m==='') return; 	
            $ext->RunCredit();
        }
    }
	class ApiController{
		private $phpUtil = null;
		
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 			
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 
		public function RunCredit(){
			$clientId = $this->q('clientId');
			$clientSecret = $this->q('clientSecret');
			
			if($clientId === 'aravindchennai' && $clientSecret==='heisattrichy'){
				$tc_out = $this->phpUtil->jdoodleCreditSpent();	// 3.1
				$lret = $this->phpUtil->arr_to_json($tc_out);
			}else{
				$tc_out = array('output'=>'API Error');
				$lret = $this->phpUtil->arr_to_json($tc_out);
			}
			header('Content-Type: application/json');
			echo($lret);
		}
		
    }
    new ApiControllerNav();
    