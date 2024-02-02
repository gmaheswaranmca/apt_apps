<?php  
	@session_start();
	$RUN=1;
	if (!defined('DR')) define('DR', __DIR__.'/'); include_once(realpath(DR.'../../pref.php'));
	include (realpath(DR.'../../gf/ar6PhpUtil.php'));
	include (realpath(DR.'../TestPaper/TestPaperModel.php'));
	function q($f){
		global $phpUtil;
		return $phpUtil->field($f,'');
	}
	class TestPaperDoDb{ 
		public $db;
		public function __construct(){
			$this->db = new TestPaperModel(); 
		}public function QueryQnOpt($p_question_id){
			return $this->db->QueryQnOpt($p_question_id);
		}public function mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText){
			return $this->db->mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText);
		}	
	}
	if(isset($_POST["btnSave"])){
		//Save Here
		echo('Saved Successfully');
		return;
	}
	$question_id = q('question_id');
	$dodb = new TestPaperDoDb();
	$mdQnOpt = $dodb->QueryQnOpt($question_id);
?>
<html>
	<head>
		<title>Apt Online Test<?php echo($link);?>-Edit Question</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<link rel="shortcut icon" href="../static/img/comp/fav.png" />
		<link href="../../static/css/cat.css<?php echo(AptTime);?>" type="text/css" rel="stylesheet">		
	</head>
	<body>
		<form method="post">
		<div>
			<div id="idQnDiv">					
				<span id="idQnTitle">Question</span>:<br>
				<textarea id="idQn"><?php echo($mdQnOpt['Qn'][0]['question_text']); ?></textarea> 
			</div>
			<div id="QnEditOptions">
				<div align="center" id="divQst" class="qst_main_table_li">
					<table cellpadding="5" cellspacing="0" width="100%" id="QnEditing">										
							<?php 
							$QnOpt = $mdQnOpt['QnOpt'];
							for($J = 0; $J < count($QnOpt); $J++){ 
								$Opt = $QnOpt[$J];
							?>
							<tr>
								<td style="border:1px dashed silver;">
									<input type="radio" name="nameOptIsAns"  value="<?php echo($Opt['id']); ?>"     <?php if($Opt['is_answer']==1){ ?>checked<?php } ?>> 
								</td><td width="100%">
									<input type="text"  name="nameOpt<?php echo($J); ?>" value="<?php echo($Opt['option_text']); ?>" style="width:100%;">
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td style="border:1px dashed silver;" colspan="2">
								<input type="submit" name="btnSubmit" value="Save" class="aptBtn">
								</td>
							</tr>
						
					</table>
				</div>	
			</div>			
		</div>
		</form>
		<script type="text/javascript">
			window.CKEDITOR_BASEPATH='../../ckeditor/';
		</script>
		<script type="text/javascript" src="../../ckeditor/ckeditor.js?t=B8DJ5M3"></script>
		<script type="text/javascript">
			CKEDITOR.replace('idQn',{
				"toolbar":[["Source","-","Bold","Italic","Underline","Strike"],["Image","Link","Unlink","Anchor"]],
				'width':'100%',
				'height':'200px'
			});	
			CKEDITOR.appendTo( 'idQn',{ removePlugins: 'htmlwriter' }); 
		</script>
	</body>
</html>