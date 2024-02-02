<?php 
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_CpDo')) define('DIR_CpDo', __DIR__.'/');
	include (realpath(DIR_CpDo.'../../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_CpDo.'../../../gf/LinuxModule.php'));
	include (realpath(DIR_CpDo.'CpModel.php'));

	class CpDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new CpDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 			
			switch($v_m){
				case 'vLoad': 		$ext->vLoad(); 		break;
				case 'mdLoad': 		$ext->mdLoad(); 	break;
				case 'mdLoadHis': 	$ext->mdLoadHis(); 	break;
				case 't': 			$ext->t(); 	break;
			}
		}
	}
	new CpDoNav();	
	class CpDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new CpDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vLoad(){
			$vLoad = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewCp.php'));
			$vLoadVal = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewCpLoadVal.php'));
			$vLoadHisModal = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewCpHisModal.php'));
			$vEye = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewEye.php'));
			$vEyeDet = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewEyeDet.php'));
			$vHisDet = $this->phpUtil->output_form(realpath(DIR_CpDo.'ViewCpHisDetail.php'));		
		/**/$lret = array('vLoad' => $vLoad,'vLoadVal' => $vLoadVal,
						 'vLoadHisModal' => $vLoadHisModal,'vEye' => $vEye,'vEyeDet' => $vEyeDet,
						 'vHisDet' => $vHisDet); 
			$mdLoad = $this->loadval();			 
			foreach ($mdLoad as $resEl => $resVal) $lret[$resEl] = $resVal;
		/**/$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdLoad(){
			$mdLoad = $this->loadval(); 
		/**/$vRet = $this->phpUtil->arr_to_json($mdLoad);
			header('Content-Type: application/json');
			echo($vRet);
		}public function mdLoadHis(){
			$mdLoadHis = $this->dodb->QueryNowHour();		 
		/**/$lret = array('mdLoadHis' => $mdLoadHis);
			$mdLoad = $this->loadval();
			foreach ($mdLoad as $resEl => $resVal) $lret[$resEl] = $resVal;
		/**/$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}private function loadval(){
			$mdLoad = sys_getloadavg();
			$mdLoad[0] = round($mdLoad[0],2); $mdLoad[1] = round($mdLoad[1],2); $mdLoad[2] = round($mdLoad[2],2);			
			$loadtext = '[' . round($mdLoad[0],2) . ',' . round($mdLoad[1],2) . ',' . round($mdLoad[2],2) . ']' ;
		/**/$maxLoad = ($mdLoad[0] > $mdLoad[1] ? $mdLoad[0] : $mdLoad[1]);
			if($mdLoad[2] > $maxLoad) $maxLoad = $mdLoad[2];
		/**/$mdMaxHourLoad = $this->dodb->QueryNowHourMax();
			$dbMaxLoad =  is_null($mdMaxHourLoad) ? 0 : $mdMaxHourLoad[0]['loadval'];			
			if($maxLoad > $dbMaxLoad) $v_dao_result = $this->dodb->InsertLoad($loadtext, $maxLoad);
		/**/$lret = array('mdLoad' => $mdLoad, 'dbMaxLoad' => $dbMaxLoad, 'loadtext' => $loadtext);
		/**/return $lret;
		}
		public function t(){
			$mdMaxHourLoad = $this->dodb->QueryNowHour();
			$lret = array('mdMaxHourLoad' => $mdMaxHourLoad);
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
	}
	class CpDoDb{
		private $db;
		public function __construct(){
			$this->db = new CpModel(); 
		}public function QueryNowHourMax(){
			return $this->db->QueryNowHourMax();
		}public function QueryNowHour(){
			return $this->db->QueryNowHour();
		}public function InsertLoad($loadtext, $maxLoad){
			return $this->db->InsertLoad($loadtext, $maxLoad);
		}
	}
?>