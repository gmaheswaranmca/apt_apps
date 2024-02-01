<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class BridgeEditorControllerDb{ 
		public $db;
		public function __construct(){
			$this->db = new BridgeEditorModel(); 
		}
		// ***
		public function QueryBridgeEdit()	{
			return $this->db->QueryBridgeEdit();
		}
		
		public function SaveBridgeSrcText($src_text)	{
			return $this->db->SaveBridgeSrcText($src_text);
		}
		
		public function SaveBridgeEditedText($edited_text)	{
			return $this->db->SaveBridgeEditedText($edited_text);
		}
    }