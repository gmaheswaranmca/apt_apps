<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerAct')) define('DIR_ControllerAct', __DIR__.'/');
	include (realpath(DIR_ControllerAct.'../../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_ControllerAct.'controllerDb.php'));

    class BridgeEditorController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new BridgeEditorControllerDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 
		public function RestSaveSource(){				
			$src_text = $this->q('src_text');
			
			/**/$this->dodb->SaveBridgeSrcText($src_text);
			$mdEditedData 	= $this->dodb->QueryBridgeEdit();
				
			/**/$lret = array(
					'BridgeEditingData' => $mdEditedData
				); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);			
		}
		
		public function RestEditedData(){							
			//$mdEditedData 	= array('src_text'=>''); 
			$mdEditedData 	= $this->dodb->QueryBridgeEdit();
				
			/**/$lret = array(
					'BridgeEditedData' => $mdEditedData
				); 			
				
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);			
		}
		
		public function RestSaveEdited(){			
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