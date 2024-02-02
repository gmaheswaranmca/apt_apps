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

    class BridgeEditorControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new BridgeEditorController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'SaveSource': 		$ext->RestSaveSource(); 	break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"SaveSource"}

				case 'EditedData': 		$ext->RestEditedData(); 	break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"EditedData"}
				case 'SaveEdited': 		$ext->RestSaveEdited(); 	break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"SaveEdited"}
			
            }
        }
    }
    new BridgeEditorControllerNav();
    