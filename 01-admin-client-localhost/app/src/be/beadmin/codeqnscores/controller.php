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
	include (realpath(DIR_Controller.'controllerAct.php'));

    class CodeQnTestScoresControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new CodeQnTestScoresController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'RptScoreInit': 			$ext->RptScoreInit(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"RptScoreInit"}
                case 'RptScoreEachTestLive': 			$ext->RptScoreEachTestLive(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"RptScoreEachTestLive"}
                case 'QnAndAnswer': 			$ext->QnAndAnswer(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"QnAndAnswer"}
            }   
        }
    }
    new CodeQnTestScoresControllerNav();
    