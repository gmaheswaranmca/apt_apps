<?php 
	@session_start();
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_TestPaper')) define('DIR_TestPaper', __DIR__.'/');
	include (realpath(DIR_TestPaper.'../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_TestPaper.'../../gf/LinuxModule.php'));
	include (realpath(DIR_TestPaper.'TestPaperModel.php'));

	class TestPaperDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new TestPaperDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 			
			switch($v_m){
				case 'vTestPaperPage': 			$ext->vTestPaperPage(); 	break;
				case 'vLoginPage': 				$ext->vLoginPage(); 		break;
				case 'mdLoginDo': 				$ext->mdLoginDo(); 			break;
				case 'vTakeTestPage': 			$ext->vTakeTestPage(); 	break;
			}
		}
	}
	new TestPaperDoNav();	
	class TestPaperDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new TestPaperDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vTestPaperPage(){
			if(isset($_SESSION['user_name'])){
				$user_id = $_SESSION['user_id'];
				$role_id = $_SESSION['role_id'];
				$user_name = $_SESSION['user_name'];				
				$full_name = $_SESSION['full_name'];
				$vTestPaperPage = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTestPaperPage.php'));
				$vMenu 			= $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewMenu.php'));
			/**/$mdTestPaperActive 	= $this->dodb->QueryTestPaperActive($user_id);
				$mdModule 			= $this->dodb->QueryRoleModule($role_id);
				
			/**/$lret = array('IsLoggedIn' => 1, 
					'user' => array('user_id' => $user_id, 'user_name' => $user_name,
						'full_name' => $full_name, 'role_id' => $role_id),
					'vTestPaperPage' => $vTestPaperPage, 'mdTestPaperActive' => $mdTestPaperActive,
					'vMenu' => $vMenu, 'mdModule' => $mdModule
					 ); 
			}else
				$lret = array('IsLoggedIn' => 0);
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function vTakeTestPage(){
			if(isset($_SESSION['user_name'])){
				$user_id = $_SESSION['user_id'];
				$role_id = $_SESSION['role_id'];
				$user_name = $_SESSION['user_name'];				
				$full_name = $_SESSION['full_name'];								
				
			/**/$vTakeTestPageInstruction = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageInstruction.php'));
				$vTakeTestPageQn = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageQn.php'));				
				$vTakeTestQnNumDiv = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestQnNumDiv.php'));
				$vTakeTestQnNum = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestQnNum.php'));
				$vTakeTestPageTitle = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageTitle.php'));
				$vTakeTestPageTimer = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageTimer.php'));
				
				if(isset($_SESSION['assignment_id'])){
					$assignment_id = $_SESSION['assignment_id'];
					$mdUserTestTakingPaper 	= $this->dodb->QueryUserTestTakingPaper($user_id, $assignment_id);	
					if(!is_null($mdUserTestTakingPaper)){
						$quiz_id = is_null($mdUserTestTakingPaper) ? 0 : $mdUserTestTakingPaper[0]['quiz_id'];
						$user_quiz_id = is_null($mdUserTestTakingPaper) ? 0 : $mdUserTestTakingPaper[0]['user_quiz_id'];				
						$mdQuestion 	= $this->dodb->QueryUTTPQuestion($quiz_id);	
						$mdAnswer 	= $this->dodb->QueryUTTPAnswer($user_id, $assignment_id);					
						$mdAssignment = array('IsValidAssignment' => 1, 'ShuffleIsThere' => 1,
							'assignment_id'=>$assignment_id, 'quiz_id' => $quiz_id,						
							'mdUserTestTakingPaper' => $mdUserTestTakingPaper, 'mdQuestion' => $mdQuestion,
							'mdAnswer' => $mdAnswer, "now_server"=>$this->phpUtil->Now()
							);
					}else $mdAssignment = array('IsValidAssignment' => 0);
				}else $mdAssignment = array('IsValidAssignment' => 0);
				
			/**/$vMenu 			= $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewMenu.php'));			
				$mdModule 			= $this->dodb->QueryRoleModule($role_id);
			/**/	
			/**/$lret = array('IsLoggedIn' => 1, 
					'user' => array('user_id' => $user_id, 'user_name' => $user_name,
						'full_name' => $full_name, 'role_id' => $role_id),
					'vTakeTestPageInstruction' => $vTakeTestPageInstruction, 'vTakeTestPageQn' => $vTakeTestPageQn, 
					'vTakeTestQnNumDiv' => $vTakeTestQnNumDiv, 'vTakeTestQnNum' => $vTakeTestQnNum, 
					'vTakeTestPageTitle' => $vTakeTestPageTitle, 'vTakeTestPageTimer' => $vTakeTestPageTimer, 					
					'vMenu' => $vMenu, 'mdModule' => $mdModule,
					'mdAssignment' => $mdAssignment
					 ); 
			}else
				$lret = array('IsLoggedIn' => 0);
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function vLoginPage(){
			if(!isset($_SESSION['user_name'])){
				$vLoginPage = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewLoginPage.php'));
			/**/$lret = array('IsLoggedIn' => 0, 'vLoginPage' => $vLoginPage
					 ); 
			}else
				$lret = array('IsLoggedIn' => 1);
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdLoginDo(){
			$p_txtLogin = $this->q('txtLogin');
			$p_txtPass = $this->q('txtPass');
			$mdIsUserExist 	= $this->dodb->IsUserExist($p_txtLogin, $p_txtPass);
			if(count($mdIsUserExist)!=0){
					$_SESSION['user_id'] = $mdIsUserExist[0]['user_id'];
					$_SESSION['role_id'] = 2;
					$_SESSION['user_name'] = $p_txtLogin;
					$_SESSION['full_name'] = $mdIsUserExist[0]['full_name'];								
					$lret = array('IsLoggedIn' => 1); 
			}else
				$lret = array('IsLoggedIn' => 0);
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
	}
	class TestPaperDoDb{ 
		private $db;
		public function __construct(){
			$this->db = new TestPaperModel(); 
		}public function QueryTestPaperActive($p_user_id)	{
			return $this->db->QueryTestPaperActive($p_user_id);
		}public function IsUserExist($p_user_name, $p_password){
			return $this->db->IsUserExist($p_user_name, $p_password);
		}public function QueryRoleModule($p_role_id)	{
			return $this->db->QueryRoleModule($p_role_id);
		}public function QueryUserTestTakingPaper($p_user_id, $p_assignment_id)	{
			return $this->db->QueryUserTestTakingPaper($p_user_id, $p_assignment_id);
		}public function QueryUTTPQuestion($p_quiz_id){
			return $this->db->QueryUTTPQuestion($p_quiz_id);
		}public function QueryUTTPAnswer($p_user_id, $p_assignment_id){
			return $this->db->QueryUTTPAnswer($p_user_id, $p_assignment_id);
		}		
	}
?>