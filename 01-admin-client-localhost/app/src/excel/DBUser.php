<?php 
$RUN=1;
if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
$dbbase_path = realpath(ROOTDB.'../student/app/sdk/ar6PhpMySqlDao.php');	
//echo($dbbase_path);
include ($dbbase_path);

class DBUser	
{
	private $m_dao = NULL;
	
	public function __construct()
	{		
		$this->m_dao = new ar6PhpMySqlDao();
	}	
	public function QueryUserAnswers($pUserName)	
	{
		$v_sql = "select a.UserName from users a where a.UserName=:pUserName"; 
		$v_param = array("pUserName"=>$pUserName);	
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}	
	public function SaveUser($pUserName, $pPassword, $pFullName)	
	{
		$resUser = $this->QueryUserAnswers($pUserName);
		
		if(count($resUser)>=1){
			$v_sql = "UPDATE users 
			SET Password = :pPassword, 
				Name=:pFullName, 
			WHERE UserName=:pUserName";
			
			$v_param = array("pUserName"=>$pUserName, "pPassword"=>$pPassword, "pFullName"=>$pFullName);
			echo("<strong>$pUserName Updated<strong>, ");
		}else{
			$v_sql = "insert into users 
				(UserName,Password,Name,added_date,user_type,email)
				VALUES
				(:pUserName, :pPassword, :pFullName,now(),2,'')";
			
			$v_param = array("pUserName"=>$pUserName, "pPassword"=>$pPassword, "pFullName"=>$pFullName);
			echo("<strong>$pUserName Added<strong>, ");
		}
		$vRet = "";
		$vRet = $this->m_dao->db_write_batch(array($v_sql), array($v_param));
		return $vRet;
	}	
}
?>