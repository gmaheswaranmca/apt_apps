<?php 
	session_start();
	$RUN = 1; 
	if(!isset($RUN)) exit(); 
	if (!defined('FS_DIR_LOGIN_PC')) define('FS_DIR_LOGIN_PC', __DIR__.'/');
	
	include (realpath(FS_DIR_LOGIN_PC.'../../../gf/ar6PhpUtil.php'));
	include (realpath(FS_DIR_LOGIN_PC.'ConductTestDb.php'));
	include (realpath(FS_DIR_LOGIN_PC.'../userAndModule/UserAndModuleDb.php'));
	
	class LoginPageController{
		private $m_method = ''; 
		private $phpUtil = null;
		
		public function __construct()
		{
			global $phpUtil;
			$this->phpUtil = $phpUtil;
			$this->frm_init();
		}
		
		public function frm_init(){
			//UserAndModuleDb::allow("2"); // Role Based Access
			
			$v_m = $this->phpUtil->field('m','');
			
			if(!($v_m==='')){
				switch($v_m)
				{
					case 'html':	// change 2a					
						//$html_page = realpath(FS_DIR_LOGIN_PC.'LoginView.php');
						//echo "aa $html_page bb<br>";
						//$this->phpUtil->output_form_init($html_page); // change 2b	
						$this->html();
						break;						
					case 'do_login':
						$this->BmDoLogin();
						break;	
					case 'is_logged_in':
						$this->BmIsLoggedIn();
						break;	
				}
			}
		}
			/*2. dao-read*/
			public function html()
			{			
				$vhtml = $this->phpUtil->output_form(realpath(FS_DIR_LOGIN_PC.'LoginView.php'));
				
				if(!isset($_SESSION['txtLogin']))
					$outdata = array('IsLoggedIn'=>0,'html'=>$vhtml);
				else
					$outdata = array('IsLoggedIn'=>1);
				
				$v_out = $this->phpUtil->output(1, 'Yet To Login', $outdata);
				
				header('Content-Type: application/json');
				echo($v_out);
				return $v_out;
			}

		/*2. dao-read*/
			public function BmIsLoggedIn()
			{			
				
				if(!isset($_SESSION['txtLogin']))
					$outdata = array('IsLoggedIn'=>0);
				else
					$outdata = array('IsLoggedIn'=>1,'html'=>$vhtml);
				
				$v_out = $this->phpUtil->output(1, 'Yet To Login', $outdata);
				
				header('Content-Type: application/json');
				echo($v_out);
				return $v_out;
			}
			public function BmDoLogin()
			{
				//input
				$p_txtLogin = $this->phpUtil->field('txtLogin');
				$p_txtPass = $this->phpUtil->field('txtPass');

				//process
				$v_r_no = 989;
				{
					$oUserAndModuleDb = new UserAndModuleDb();	// change 4b
					$v_dao_result = $oUserAndModuleDb->GetModules($p_txtLogin, "", "", false);	// change 4c
					//echo("Aa".count($v_dao_result)."bb"); print_r($v_dao_result);
					if(count($v_dao_result)!=0){
						  $password = md5(trim($p_txtPass));
						  $db_pwd = $v_dao_result[0]['password'];					  

						  if($password==$db_pwd){
							  
							  
							  $_SESSION['txtLogin'] = $p_txtLogin;
							  $_SESSION['txtPass'] = $password;
							  $_SESSION['txtPassImp'] = $password;
							  $_SESSION['user_id'] = $v_dao_result[0]['user_id'];
							  $_SESSION['user_type'] = 2;
							  
							  $v_r_no = 1; $v_dao_result = array("a" => "success","b"=>$_SESSION['txtLogin']);
							  //echo("xxxYes Passxxx");
						  }else{
							  $v_r_no = 988;	
							  //echo("xxxNo PassKK $p_txtPass $password $db_pwd KKxxx");
						  }
					  }else{
						  $v_r_no = 988;
						  //echo("xxxNo USerxxx");
					  }
					
					   
				}
				//output
				$v_out='';
				switch($v_r_no){
					case 1:
						$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
						break;
					case 989:
						$v_out = $this->phpUtil->output($v_r_no, 'Db Access Failure.', '');
						break;
					case 988:
						$v_out = $this->phpUtil->output($v_r_no, 'Invalid User Name or Password.', '');
						break;	
				}
				header('Content-Type: application/json');
				echo($v_out);
				return $v_out;
			}
			
		/*3. dao-write*/
			
	}

	$oLoginPageController = new LoginPageController();	// change 7

?>