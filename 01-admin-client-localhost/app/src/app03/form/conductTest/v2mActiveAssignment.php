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
		$v_m = $this->phpUtil->field('m','');
		
		if(!($v_m==='')){
			switch($v_m){
				case 'html': $this->html();	break;	
			}
		}
	}
	public function html(){			
		$vhtml = $this->phpUtil->output_form(realpath(FS_DIR_ACTASS_PC.'ActiveAssignmentView.php'));
		
		if(!isset($_SESSION['txtLogin'])){
			$outdata = array('IsLoggedIn'=>0);
		}else{
			$p_user_id = $_SESSION['user_id'];			
			$p_user = $_SESSION['txtLogin'];
			$p_full_name = $_SESSION['full_name'];	
			//			
			$oConductTestDb = new ConductTestDb();
			$mdlivetest = $oConductTestDb->QueryIsLiveTest($p_user_id);
			$mdassignment = $oConductTestDb->QueryAssessesmentByUser($p_user_id);
			//
			$outdata = array('IsLoggedIn'=>1,'vhtml'=>$vhtml,"mdassignment"=>$mdassignment, 
					"user_id"=>$p_user_id, "user_name"=>$p_user, "full_name"=>$p_full_name, "mdlivetest"=>$mdlivetest);
		}
				
		$v_out = $this->phpUtil->output(1, 'Yet To Login', $outdata);
		
		header('Content-Type: application/json');
		echo($v_out);
		return $v_out;
	}		
}

$oActiveAssignmentPageController = new  ActiveAssignmentPageController();	// change 7

?>