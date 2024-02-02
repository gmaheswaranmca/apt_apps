<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
			
	class CpModel{
		private $m_dao = NULL;		
		private $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new CpModelSql();
		}public function QueryNowHour()	{
			return $this->wmd->QueryNoParam($this->sql->sqlReadLoadNowHour);
		}public function QueryNowHourMax()	{
			return $this->wmd->QueryNoParam($this->sql->sqlReadLoadNowHourMax);
		}public function InsertLoad($loadtext, $loadval){			
			return $this->wmd->WriteParam(
				array(
					$this->sql->sqlWriteInsertLoad
				),
				array(
					array("ploadtext" => $loadtext, "ploadval" => $loadval)
				)
			);			
		}	
	}
	class CpModelSql{ 
	public $sqlReadLoadNowHour = 
"SELECT id,date_format(loadtime,'%d-%b-%Y %r') loadtime,loadval,loadtext
FROM maxedu_cp_loadmax 
WHERE date_format(now(),'%Y%m%d%H')=date_format(loadtime,'%Y%m%d%H')
ORDER BY loadval desc 
LIMIT 10"; 			
	public $sqlReadLoadNowHourMax = 
"SELECT id,date_format(loadtime,'%d-%b-%Y %r') loadtime,loadval,loadtext
FROM maxedu_cp_loadmax 
WHERE date_format(now(),'%Y%m%d%H')=date_format(loadtime,'%Y%m%d%H')
ORDER BY loadval desc 
LIMIT 1"; 
	/*args: ploadtext, ploadval*/
	public $sqlWriteInsertLoad = 
"INSERT INTO maxedu_cp_loadmax(loadtext, loadval, loadtime) 
VALUES(:ploadtext, :ploadval, now())"; 
	}
	
	
/*
All the hourly load report:
	SELECT a.id,date_format(a.loadtime,'%d-%b-%Y %r') loadtime,a.loadval,a.loadtext, bb.datehour
FROM maxedu_cp_loadmax a INNER JOIN
   (SELECT date_format(b.loadtime,'Dt:%y-%m-%d,Hr:%H') datehour,max(b.loadval) hourval FROM maxedu_cp_loadmax b
     group by date_format(b.loadtime,'Dt:%y-%m-%d,Hr:%H')
     ) bb ON(date_format(a.loadtime,'Dt:%y-%m-%d,Hr:%H')=bb.datehour AND bb.hourval=a.loadval)
ORDER BY bb.datehour desc,a.loadval desc

*/	
?>