<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('WRDB')) define('WRDB', __DIR__.'/');
	
	include (realpath(WRDB.'/ar6PhpMySqlDao.php'));
	class WrapperModel{
		private $m_dao = NULL;		
		public function __construct(){
			$this->m_dao = new ar6PhpMySqlDao();
		}public function QueryNoParam($sql){						
			return $this->QueryParam($sql, array());
		}public function QueryParam($sql, $param){
			$v_result = $this->m_dao->db_read($sql, $param, 1); 
			if ($v_result === true)	return $this->m_dao->getResult();						
			return $v_result;
		}public function WriteParam($sql, $param){
			$v_result = $this->m_dao->db_write_batch($sql, $param);
			return $v_result;
		}
		public function WriteParamBulk($sql, $param){
			$v_result = $this->m_dao->db_write_batch_bulk($sql, $param);
			return $v_result;
		}public function WriteIdParam($sql, $param){
			$v_result = $this->m_dao->db_write($sql, $param);
			return $v_result;
		}

		public function QueryNoParamMeta($sql){						
			return $this->QueryParamMeta($sql, array());
		}	
		
		public function QueryParamMeta($sql, $param){
			$v_result = $this->m_dao->db_read_with_meta($sql, $param, 1); 								
			return $v_result;
		}
	}