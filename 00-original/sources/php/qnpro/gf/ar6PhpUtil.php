<?php 
class ar6PhpUtil
{
	private $v_clientId = '';
	private $v_clientSecret = '';
	private $v_url = ''; 
	private $apiService;
	public function __construct()
	{
		$vapiService = $this->getCodeQnApiServices();
		//
		$url 			= $vapiService['url'];   
		$v_clientId 	= $vapiService['clientId'];
		$v_clientSecret = $vapiService['clientSecret'];
		//
		$this->v_url			= $url 				;   
		$this->v_clientId		= $v_clientId 		;
		$this->v_clientSecret 	= $v_clientSecret	;
		$this->apiService 		= $vapiService		;
	}
	public function getHostName(){
		//$domainName = $_SERVER['SERVER_NAME'];
		$domainName = $_SERVER['HTTP_HOST'];
		return $domainName;
	}
	
	public function field($name, $default=''){
		$v_f = $default;
		if (isset($_GET[$name])){
			$v_f = $_GET[$name];
		}elseif (isset($_POST[$name])){
			$v_f = $_POST[$name];
		}else{
			$v_f = $this->restPostField($name, $default);
		}
		
		return $v_f;
	}
	public function restPostField($name, $default=''){
		$postdata = file_get_contents("php://input");
		$request = (array)json_decode($postdata);
		$v_f = $default;
		if (isset($request[$name])){
			$v_f = $request[$name];
		}		
		return $v_f;
	}
	
	
	public function output($p_r_code, $p_r_msg, $p_r){
		$v_return = array("r_code"=>$p_r_code, "r_msg"=>$p_r_msg, "r"=>$p_r);
		$v_return = $this->arr_to_json($v_return);		
		return $v_return;
	}
	
	public function arr_to_json($p_arr){
		$v_return = json_encode($p_arr);		
		return $v_return;
	}
	
	public function output_form($p_frm){
		//echo "aa $p_frm bb<br>";
		ob_start();
		include $p_frm;
		$v_return = ob_get_clean();
		/*
			$v_return = ob_get_contents();
			ob_end_clean();
		*/
		return $v_return;
	}
	
	public function output_form_init($p_frm)
	{	//user-lookup/form-user-lookup.php
		$v_out=''; 
		$v_out=$this->output_form($p_frm); 
		echo($v_out);
		return $v_out;
	}
	
	public function Now()
	{
		return date('Y-m-d H:i:s');
	}
	public function getCodeQnApiServices(){
		//https://www.jdoodle.com/compiler-api
		//https://docs.jdoodle.com/compiler-api/compiler-api
		//It is a JSON based Rest API.
		//	!!!!DONT make call directly from web page
		//	!!!!Direct the request from your webpage to your own server and call JDoodle API from your server
		$apiServiceOne = array(
			'clientId' => '9f0d8737e218cab0ac901f50097b1b8b',
			'clientSecret' => 'b199a9f735e06990970bc56b7acf0598a4cc17b2d3f91d29a5851f91643d71ec',
			'url' => 'https://api.jdoodle.com/v1/execute',
			'credits_url' => 'https://api.jdoodle.com/v1/execute',
			'jdoodle_account_is_via_gmail' => True, 
			'jdoodle_gmail_account' => 'pystud19@gmail.com', 
			'jdoodle_account_passowrd_ifso' => 'NA'
		); //apttraining	

		$apiServiceTwo = array(
			'clientId' => '524a4ccae6caac2a3f791b04186c72f5',
			'clientSecret' => '4a70a9a269720b855f37e9e353eb4fdfd460fbf3ba33a508709ab1a8e805e2cf',
			'url' => 'https://api.jdoodle.com/v1/execute',
			'credits_url' => 'https://api.jdoodle.com/v1/credit-spent',
			'jdoodle_account_is_via_gmail' => True, 
			'jdoodle_gmail_account' => 'gmaheswaranmca@gmail.com', 
			'jdoodle_account_passowrd_ifso' => '2020apttraining'
		); //aptonlinetest

		$apiServiceThree = array(
			'clientId' => 'aravindchennai',
			'clientSecret' => 'heisattrichy',
			'url' => 'http://apttraining.co.in/codeqnapi/controllerRun.php',
			'credits_url' => 'http://apttraining.co.in/codeqnapi/controllerCredit.php',
			'jdoodle_account_is_via_gmail' => False, 
			'jdoodle_gmail_account' => 'NA', 
			'jdoodle_account_passowrd_ifso' => 'NA'
		);

		$apiServiceFour = array(
			'clientId' => 'aravindchennai',
			'clientSecret' => 'heisattrichy',
			'url' => 'http://oxy.aptonlinetest.co.in/codeqnapi/controllerRun.php',
			'credits_url' => 'http://oxy.aptonlinetest.co.in/codeqnapi/controllerCredit.php',
			'jdoodle_account_is_via_gmail' => False, 
			'jdoodle_gmail_account' => 'NA', 
			'jdoodle_account_passowrd_ifso' => 'NA'
		);

		$hostName = $this->getHostName();
		if (strpos($hostName, 'localhost') !== false) 
            $apiService = $apiServiceThree;   //apiServiceThree     apiServiceFour
        else if (strpos($hostName, 'apttraining') !== false) 
            $apiService = $apiServiceOne;        
        else if (strpos($hostName, 'aptonlinetest') !== false) 
			$apiService = $apiServiceTwo;
		else 
			$apiService = $apiServiceFour;	

		return $apiService;
	}
	public function RunTechCode($p_program, $p_lang, $p_version, $p_is_input, $p_input){
		$url 			= $this->v_url;   
		$v_clientId 	= $this->v_clientId;
		$v_clientSecret = $this->v_clientSecret;

		
		$jsonData = array(
			'script'=>$p_program, 'language'=>$p_lang, 'versionIndex'=>$p_version,
			'clientId' => $v_clientId, 'clientSecret' =>$v_clientSecret,
			'stdin' =>$p_input
		); 

		if($p_is_input==true)	$jsonData['stdin'] = $p_input;
		
		$jsonResult= $this->curlRestDo($url, $jsonData);

		if(isset($jsonResult['output'])){
			 $vret = array(
				'output'=>$jsonResult, 'error'=>NULL, 'other_error'=>false
			  );
		}
		else if(isset($jsonResult['error'])){
			$vret = array(
				'output'=>NULL, 'error'=>$jsonResult, 'other_error'=>false
			  );
		}else{
			$vret = array(
				'output'=>NULL, 'error'=>NULL, 'other_error'=>true
			  );
		}
		return $vret;		
	}	

	public function jdoodleRunCode($p_program, $p_lang, $p_version, $p_input){
		$url 			= $this->v_url;   
		$v_clientId 	= $this->v_clientId;
		$v_clientSecret = $this->v_clientSecret;

		$jsonData = array(
			'script'=>$p_program, 'language'=>$p_lang, 'versionIndex'=>$p_version,
			'clientId' => $v_clientId, 'clientSecret' =>$v_clientSecret,
			'stdin' =>$p_input
		); 

		$jsonResult= $this->curlRestDo($url, $jsonData);
		
		return $jsonResult;			
	}	

	public function jdoodleCreditSpent(){
		//$this->apiService
		$url 			= $this->apiService['credits_url'];   
		$v_clientId 	= $this->v_clientId;
		$v_clientSecret = $this->v_clientSecret;

		$jsonData = array(
			'clientId' => $v_clientId, 'clientSecret' =>$v_clientSecret
		); 
		$jsonResult= $this->curlRestDo($url, $jsonData);
		
		return $jsonResult;		
	}
	public function curlRestDo($url, $jsonData){
		$jsonDataEncoded = json_encode($jsonData);//Encode the array into JSON.
		// echo("X ");print_r($jsonDataEncoded);echo(" X");
	
		$ch = curl_init(); //Initiate cURL.
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1); //Tell cURL that we want to send a POST request.		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); //Set the content type to application/json		
		$result = curl_exec($ch);//Execute the request
		// echo("A ");print_r($result);echo(" A");
		$jsonResult=json_decode($result,true);
		return $jsonResult;
	}

	public function readFile($filePathAndName){
		$fileContent = file_get_contents($filePathAndName);
		return $fileContent;
	}
}



$phpUtil = new ar6PhpUtil();	

?>

