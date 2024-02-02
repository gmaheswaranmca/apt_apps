<?php 
class ar6PhpUtil
{
	private $v_clientId = '';
	private $v_clientSecret = '';
	private $v_url = ''; 
	public function __construct()
	{
		$apiService = $this->getCodeQnApiServices();

		$url 			= $apiService['url'];   
		$v_clientId 	= $apiService['clientId'];
		$v_clientSecret = $apiService['clientSecret'];

		$this->v_url			= $url 			;   
		$this->v_clientId		= $v_clientId 	;
		$this->v_clientSecret 	= $v_clientSecret;
	}
	public function getHostName(){
		//$domainName = $_SERVER['SERVER_NAME'];
		$domainName = $_SERVER['HTTP_HOST'];
		return $domainName;
	}
	private function getCodeQnApiServices(){
		$apiServiceOne = array(
			'clientId' => '9f0d8737e218cab0ac901f50097b1b8b',
			'clientSecret' => 'b199a9f735e06990970bc56b7acf0598a4cc17b2d3f91d29a5851f91643d71ec',
			'url' => 'https://api.jdoodle.com/v1/execute'
		); //apttraining

		$apiServiceTwo = array(
			'clientId' => '524a4ccae6caac2a3f791b04186c72f5',
			'clientSecret' => '4a70a9a269720b855f37e9e353eb4fdfd460fbf3ba33a508709ab1a8e805e2cf',
			'url' => 'https://api.jdoodle.com/v1/execute'
		); //aptonlinetest

		$apiServiceThree = array(
			'clientId' => 'aravindchennai',
			'clientSecret' => 'heisattrichy',
			'url' => 'http://apttraining.co.in/codeqnapi/controller.php'
		);

		$apiServiceFour = array(
			'clientId' => 'aravindchennai',
			'clientSecret' => 'heisattrichy',
			'url' => 'http://aptonlinetest.co.in/codeqnapi/controller.php'
		);

		$hostName = $this->getHostName();
		if (strpos($hostName, 'localhost') !== false) 
            $apiService = $apiServiceThree;        
        else if (strpos($hostName, 'apttraining') !== false) 
            $apiService = $apiServiceOne;        
        else if (strpos($hostName, 'aptonlinetest') !== false) 
			$apiService = $apiServiceTwo;
		else 
			$apiService = $apiServiceFour;	

		return $apiService;
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

	public function RunTechCode($p_program, $p_lang, $p_version, $p_is_input, $p_input){
		$url 			= $this->v_url;   
		$v_clientId 	= $this->v_clientId;
		$v_clientSecret = $this->v_clientSecret;

		if($p_is_input==true){
			$jsonData = array(
				'script'=>$p_program, 'language'=>$p_lang, 'versionIndex'=>$p_version,
				'clientId' => $v_clientId, 'clientSecret' =>$v_clientSecret,
				'stdin' =>$p_input
			); //The JSON data.
		}else{
			$jsonData = array(
				'script'=>$p_program, 'language'=>$p_lang, 'versionIndex'=>$p_version,
				'clientId' => $v_clientId, 'clientSecret' =>$v_clientSecret
			); //The JSON data.
		}
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
		
		// echo("C ");
		
		if(!curl_errno($ch)){ 
		  $info = curl_getinfo($ch); 
		  // echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']; 
		} else { 
		  // echo 'Curl error: ' . curl_error($ch); 
		}
		// echo("C ");
		
		//$vret = {'output':null,'error':null}
		if(isset($jsonResult['output'])){
			 //$test_case_passed=1;
			 //echo"<script>alert('Test Case Passed Successfully ! Click Save and do other program');</script>";
			 $vret = array(
				'output'=>$jsonResult, 'error'=>NULL, 'other_error'=>false
			  );
		}
		else if(isset($jsonResult['error'])){
			//$test_case_passed=0;
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
}

$phpUtil = new ar6PhpUtil();	

