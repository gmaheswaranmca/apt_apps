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

    class QnFileControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new QnFileController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'vTestPaperPage': 			$ext->vTestPaperPage(); 	break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/qnfile/controller.php   
                //  {"m":"vTestPaperPage"}
				case 'vTakeTestPage': 			$ext->vTakeTestPage(); 		break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/qnfile/controller.php   
                //  {"m":"vTakeTestPage"}				
				case 'QzFileSave': 				$ext->QzFileSave(); 		break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/qnfile/controller.php   
                //  {"m":"QzFileSave"}
				case 'QnDataSave': 				$ext->QnDataSave(); 		break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/qnfile/controller.php   
                //  {"m":"QnDataSave"}
			
            }
        }
    }
    new QnFileControllerNav();
    