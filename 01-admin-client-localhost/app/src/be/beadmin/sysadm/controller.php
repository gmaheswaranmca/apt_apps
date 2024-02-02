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

    class SysAdmControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new SysAdmController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'LiveMointorTestInit': 			$ext->LiveMointorAllTestInit(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorTestInit"}
                case 'LiveMointorTestRightNow': 			$ext->LiveMointorAllTestRightNow('NotApplicableForQuery'); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorTestRightNow"}
                case 'LiveMointorChangeStatus': 			$ext->LiveMointorChangeStatus(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorChangeStatus"}
                case 'LiveMointorCodeQnChangeStatus': 			$ext->LiveMointorCodeQnChangeStatus('NotApplicableForQuery'); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorCodeQnChangeStatus"}

                case 'LiveMointorMcqQnTestInit': 			$ext->LiveMointorMcqQnTestInit(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorMcqQnTestInit"}
                case 'LiveMointorMcqQnTestRightNow': 			$ext->LiveMointorMcqQnTestRightNow(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorMcqQnTestRightNow"}
            
                case 'LiveMointorCodeQnTestInit': 			$ext->LiveMointorCodeQnTestInit(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorCodeQnTestInit"}
                case 'LiveMointorCodeQnTestRightNow': 			$ext->LiveMointorCodeQnTestRightNow(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"LiveMointorCodeQnTestRightNow"}


                case 'QueryAppHmStartup': 			$ext->QueryAppHmStartup(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"QueryAppHmStartup"}


                case 'QueryMeta': 			$ext->QueryMeta(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"QueryMeta"}

                case 'DoDownload': 			$ext->DoDownload(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"DoDownload"}

                case 'DoUpload': 			$ext->DoUpload(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"DoUpload"}
            }   
        }
    }
    new SysAdmControllerNav();
    