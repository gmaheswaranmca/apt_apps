<?php 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
    $IsRest = 1;
    $RUN = 1;
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_Controller')) define('DIR_Controller', __DIR__.'/');
    include (realpath(DIR_Controller.'../../../gf/ar6PhpUtil.php'));
	//include (realpath(DIR_Controller.'controllerAct.php'));

    class ApiJdoodleControllerNav{ 
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new ApiJdoodleController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'jdoodleapidb': 			$ext->jdoodleapidb(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beApiDb/jdoodle/controller.php   
                //  {"m":"jdoodleapidb"}
            }   
        }
    }
    class ApiJdoodleController{
		private $phpUtil = null;

		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 
        public function jdoodleapidb(){
/*
#   -> jdoodleapidb : api_credits_url, api_code_run_url, api_login_id, api_password 
#   ->                -> jdoodle_account_is_via_gmail, jdoodle_gmail_account, jdoodle_account_passowrd_ifso  
#   ->                -> language_codes :[{'lang_code':xxx, 'lang_name':xxx, 'short_program': xxx}]
*/          $apiService = $this->phpUtil->getCodeQnApiServices();
            $language_codes = array(
                array('lang_code'=>'java', 'lang_name'=>'Java', 'short_program'=>'',
                    'versions' => array(
                        array('version_index'=> '0', 'version_name' => 'JDK 1.8.0_66'),
                        array('version_index'=> '1', 'version_name' => 'JDK 9.0.1'),
                        array('version_index'=> '2', 'version_name' => 'JDK 10.0.1'),
                        array('version_index'=> '3', 'version_name' => 'JDK 11.0.4')
                        )
                ),
                array('lang_code'=>'c', 'lang_name'=>'C', 'short_program'=>'',
                    'versions' =>array(
                        array('version_index'=> '0', 'version_name' => 'GCC 5.3.0'),
                        array('version_index'=> '1', 'version_name' => 'Zapcc 5.0.0'),
                        array('version_index'=> '2', 'version_name' => 'GCC 7.2.0'),
                        array('version_index'=> '3', 'version_name' => 'GCC 8.1.0'),
                        array('version_index'=> '4', 'version_name' => 'GCC 9.1.0'))
                ),
                array('lang_code'=>'cpp', 'lang_name'=>'C++', 'short_program'=>'',
                    'versions' =>array(
                        array('version_index'=> '0', 'version_name' => 'GCC 5.3.0'),
                        array('version_index'=> '1', 'version_name' => 'Zapcc 5.0.0'),
                        array('version_index'=> '2', 'version_name' => 'GCC 7.2.0'),
                        array('version_index'=> '3', 'version_name' => 'GCC 8.1.0'),
                        array('version_index'=> '4', 'version_name' => 'GCC 9.1.0'))
                ),
                array('lang_code'=>'python3', 'lang_name'=>'Python 3', 'short_program'=>'',
                    'versions' =>array(
                        array('version_index'=> '0', 'version_name' => '3.5.1'),
                        array('version_index'=> '1', 'version_name' => '3.6.3'),
                        array('version_index'=> '2', 'version_name' => '3.6.5'),
                        array('version_index'=> '3', 'version_name' => '3.7.4'))
                )
            );
            $api_base = array(
                "api_credits_url" => $apiService['credits_url'], 
                "api_code_run_url" => $apiService['url'], 
                "api_login_id" => $apiService['clientId'], 
                "api_password" => $apiService['clientSecret'], 
                "jdoodle_account_is_via_gmail" => $apiService['jdoodle_account_is_via_gmail'], 
                "jdoodle_gmail_account" => $apiService['jdoodle_gmail_account'], 
                "jdoodle_account_passowrd_ifso" => $apiService['jdoodle_account_passowrd_ifso'],
                'language_codes' => $language_codes
            );	
		    //
            $lret = $api_base; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
    }
    new ApiJdoodleControllerNav();
    