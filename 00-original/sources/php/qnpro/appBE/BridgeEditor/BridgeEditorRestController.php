<?php 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
	@session_start();
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_BridgeEditor')) define('DIR_BridgeEditor', __DIR__.'/');
	include (realpath(DIR_BridgeEditor.'../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_BridgeEditor.'BridgeEditorModel.php'));
	class BridgeEditorRestController_DB{ 
		public $db;
		public function __construct(){
			$this->db = new BridgeEditorModel(); 
		}public function QueryBridgeEdit()	{
			return $this->db->QueryBridgeEdit();
		}public function SaveBridgeSrcText($src_text)	{
			return $this->db->SaveBridgeSrcText($src_text);
		}public function SaveBridgeEditedText($edited_text)	{
			return $this->db->SaveBridgeEditedText($edited_text);
		}	
	}
	
	class BridgeEditorRestController_Do{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new BridgeEditorRestController_DB();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function RestSaveSource(){				
			$src_text = $this->q('src_text');
			
			/**/$this->dodb->SaveBridgeSrcText($src_text);
			$mdEditedData 	= $this->dodb->QueryBridgeEdit();
				
			/**/$lret = array(
					'BridgeEditingData' => $mdEditedData
				); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);			
		}public function RestEditedData(){							
			//$mdEditedData 	= array('src_text'=>''); 
			$mdEditedData 	= $this->dodb->QueryBridgeEdit();
				
			/**/$lret = array(
					'BridgeEditedData' => $mdEditedData
				); 			
				
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);			
		}public function RestSaveEdited(){			
			$edited_text = $this->q('edited_text');
			
			/**/$this->dodb->SaveBridgeEditedText($edited_text);
			$mdEditedData 	= $this->dodb->QueryBridgeEdit();
				
			/**/$lret = array(
					'BridgeEditedData' => $mdEditedData
				); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');	
			echo($lret);
		}
	}
	class BridgeEditorRestController{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new BridgeEditorRestController_Do();
			$v_m = $ext->q('m');		
			//echo($v_m);
			if($v_m==='') return; 	
			
			switch($v_m){
				case 'SaveSource': 		$ext->RestSaveSource(); 	break;
				case 'EditedData': 		$ext->RestEditedData(); 	break;
				case 'SaveEdited': 		$ext->RestSaveEdited(); 	break;
			}
		}
	}
	new BridgeEditorRestController();	
	
	
?>