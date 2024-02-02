<?php 
session_start();
   $RUN = 1;
   
?>
<?php 
  if(!isset($RUN)) { exit(); } 
  
?>
<?php 
if (!defined('FS_DIR_ACTASS_PC')) { /* FS: File System, PC: Page Controller */
define('FS_DIR_ACTASS_PC', __DIR__.'/');
}

$util_path = realpath(FS_DIR_ACTASS_PC.'../../../gf/ar6PhpUtil.php');	
$db_path = realpath(FS_DIR_ACTASS_PC.'ConductTestDb.php');
$module_db_path = realpath(FS_DIR_ACTASS_PC.'../userAndModule/UserAndModuleDb.php');	

include ($util_path);
include ($db_path);
include ($module_db_path);



class ActiveAssignmentPageController	// change 1b
{
	private $m_method = ''; 
	private $phpUtil = null;
	
	public function __construct()
	{
		global $phpUtil;
		$this->phpUtil = $phpUtil;
		$this->frm_init();
	}
	
	public function frm_init(){
		UserAndModuleDb::allow("2"); // Role Based Access
		
		$v_m = $this->phpUtil->field('m','');
		
		if(!($v_m==='')){
			switch($v_m)
			{
				case 'html':	// change 2a
					$html_page = realpath(FS_DIR_ACTASS_PC.'ActiveAssignmentView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;	
				case 'menu_htm':	// change 2a
					$html_page = realpath(FS_DIR_ACTASS_PC.'../userAndModule/MenusView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;		
				case 'dao_list':
					$this->BmQueryAssessesmentByUser();
					break;
					break;				
				case 'daomodule_get':
					$this->BmQueryModuleGet();	
					break;	
			}
		}
	}
	/*2. dao-read*/
		public function BmQueryAssessesmentByUser()
		{
			//input			
			$p_user_id = $_SESSION['user_id']; // change 4a			
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result = $oConductTestDb->QueryAssessesmentByUser($p_user_id);
				$v_dao_result = array("assignment"=>$v_dao_result, "user_id"=>$p_user_id, "user"=>$_SESSION['txtLogin']);				
				$v_r_no = 1;				
			}	
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		
		public function BmQueryModuleGet()
		{
			//input
			$p_user = $_SESSION['txtLogin'];
			$p_password = $_SESSION['txtPass'];
			$p_imp_password = $_SESSION['txtPassImp'];
			$p_check_pass = true;			
			//process
			$v_r_no = 989;
			{
				$oUserAndModuleDb = new UserAndModuleDb();	// change 4b
				$v_dao_result = $oUserAndModuleDb->GetModules($p_user, $p_password, $p_imp_password, $p_check_pass);	// change 4c
				//echo($v_dao_result);
				$v_r_no = 1;
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
	/*3. dao-write*/
		
}

$oActiveAssignmentPageController = new  ActiveAssignmentPageController();	// change 7

?>