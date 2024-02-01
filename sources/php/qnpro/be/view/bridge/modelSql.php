<?php 
	if(!isset($RUN)) exit(); 
class BridgeEditroSql{

        public $sqlQueryBridgePref = 
"SELECT pr.edit_number FROM aaaq_bridge_pref pr";

    public $UpdateQueryBridgePref = 
"UPDATE aaaq_bridge_pref SET edit_number=:p_edit_number"; 
    
    public $UpdateQueryBridgeEditSrc = 
"UPDATE aaaq_bridge_edit SET src_text=:p_src_text, edited_text=:p_src_text, has_edited=0 WHERE edit_number=:p_edit_number";

    public $sqlQueryBridgeEdit = 
"SELECT pe.src_text, pe.edited_text, pe.has_edited FROM aaaq_bridge_edit pe WHERE edit_number=:p_edit_number";

    public $UpdateQueryBridgeEditDone = 
"UPDATE aaaq_bridge_edit SET edited_text=:p_edited_text, has_edited=1 WHERE edit_number=:p_edit_number";		
    



} 