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

    class AptJobControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new AptJobController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'QueryJobDB': 			$ext->QueryJobDB(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"QueryJobDB"}
                case 'AddSchedule': 			$ext->AddSchedule(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"AddSchedule"}
                case 'AddJob': 			$ext->AddJob(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"AddJob"}
                case 'ChangeSchedule': 			$ext->ChangeSchedule(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"ChangeSchedule"}
                case 'ChangeJob': 			$ext->ChangeJob(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"ChangeJob"}
                case 'UpdateSchedule': 			$ext->UpdateSchedule(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"UpdateSchedule"}
                case 'UpdateJob': 			$ext->UpdateJob(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"UpdateJob"}
                case 'CloseSchdule': 			$ext->CloseSchdule(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"CloseSchdule"}
                case 'DoneJob': 			$ext->DoneJob(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"DoneJob"}
                case 'UpdateLiveStatus': 			$ext->UpdateLiveStatus(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/aptjob/controller.php   
                //  {"m":"UpdateLiveStatus"}
            }   
        }
    }
    new AptJobControllerNav();
    