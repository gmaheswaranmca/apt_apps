<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class BridgeEditorModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new BridgeEditroSql();
		}
		//
		public function QueryBridgeEdit()	{	
			//1. Query last "edit_number" From bridge_pref
			$prRes = $this->wmd->QueryNoParam(
				$this->sql->sqlQueryBridgePref
			);		
			$edit_number = $prRes[0]["edit_number"];
			//2. Query src_text, edited_text, has_edited From bridge_edit
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryBridgeEdit, 
					array("p_edit_number" => $edit_number)
				);
		}
		
		public function SaveBridgeSrcText($src_text){
			//1. Query last "edit_number" From bridge_pref
			$prRes = $this->wmd->QueryNoParam(
				$this->sql->sqlQueryBridgePref
			);		
			//2. Rotate "edit_number" to next one
			$edit_number = $prRes[0]["edit_number"] + 1;
			if($edit_number > 10) $edit_number = 1;
			//3. Update Pref new edit
			//4. Update edit src
			$sql = array($this->sql->UpdateQueryBridgePref, 
				$this->sql->UpdateQueryBridgeEditSrc); 
			$param = array(
				array('p_edit_number' => $edit_number),
				array('p_src_text' => $src_text, 'p_edit_number' => $edit_number)
			);			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return $res;
		}
		
		public function SaveBridgeEditedText($edited_text){
			//1. Query "edit_number" From bridge_pref
			$prRes = $this->wmd->QueryNoParam(
				$this->sql->sqlQueryBridgePref
			);		
			$edit_number = $prRes[0]["edit_number"];
			$sql = array($this->sql->UpdateQueryBridgeEditDone); 			
			//2. Update edit "the edited" text
			$param = array(
				array('p_edited_text' => $edited_text, 'p_edit_number' => $edit_number)
			);			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return $res;
		}
    }
    		