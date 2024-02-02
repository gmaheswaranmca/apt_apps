<?php 
	if(!isset($RUN)) exit();  
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include_once (realpath(ROOTDB.'../../../gf/ar6PhpMySqlDao.php'));

class UserAndModuleDb	
{
	private $m_dao = NULL;
	
	public function __construct()
	{
		$this->m_dao = new ar6PhpMySqlDao();
	}
	public function GetModules($p_user,$p_password,$p_imp_password,$p_check_pass=true)	// change 2a
	{
		if($p_check_pass==true){
			$v_sql = 
			"select m.*, u.UserID as user_id, u.user_type,u.password, 0 as imported, Name full_name 
			 from users u 
			 left join roles_rights rr on rr.role_id = u.user_type 
			 left join modules m on m.id= rr.module_id 
			 where u.UserName=:p_user and Password=:p_password 
			 "; // change 2b
			$v_param = array("p_user"=>$p_user, "p_password"=>$p_password);
		}	 
		else{
			$v_sql = 
			"select m.*, u.UserID as user_id, u.user_type,u.password, 0 as imported, Name full_name
			from users u 
			left join roles_rights rr on rr.role_id = u.user_type 
			left join modules m on m.id= rr.module_id 
			where u.UserName=:p_user 
			"; // change 2b
			$v_param = array("p_user"=>$p_user);	// change 5c	
		}	
		
		//echo($v_sql." ".$p_user);
		
		
		
		
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public static function allow($user_type)
    {
        if($user_type!=$_SESSION['user_type'])
        {
            header("location:login.php");
        }
    }
}