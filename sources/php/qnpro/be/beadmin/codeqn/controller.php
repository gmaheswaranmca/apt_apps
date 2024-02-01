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

    class CodeQnControllerNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new CodeQnController();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
                case 'CodeQnGet': 			$ext->CodeQnGet(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"CodeQnGet"}
                case 'RunQn': 			$ext->RunQn(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"RunQn"}
                case 'RunTC': 			$ext->RunTC(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"RunTC"} 
                case 'SaveEditedQn': 			$ext->SaveEditedQn(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"SaveEditedQn"}
                case 'SaveAddQn': 			$ext->SaveAddQn(); 			break;
                //  http://localhost/apt/aaa/qnpro/be/beadmin/sysadm/controller.php   
                //  {"m":"SaveAddQn"}
            }   
        }
    }
    new CodeQnControllerNav();
    