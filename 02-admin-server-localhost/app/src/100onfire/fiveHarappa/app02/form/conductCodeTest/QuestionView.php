<style type="text/css">
	.timerCounter {
		display: table-cell; 		
		width: 40px; height:40px; 
		margin:1%;
		font-size: 20px;					
		font-family: 'Lucida Console'; 	
		
		border-radius:20px;
		border:1px solid #434343;		
background: #000000;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #434343, #000000);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #434343, #000000); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


		color: white;
		
		vertical-align:middle;
		text-align: center;	
		
	}
	.timerDiv{
		display:block; width:100%; padding:3px;
		text-align:center;
	}
	.tmrBox{
	font-family:tahoma; font-size:9pt; font-weight:bold;	
	
	border: 1px solid #DBDBDB; border-radius: 5px;
	color:navy;
	background: #ADA996;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.tmrTxt{float:bottom;font-size:7pt;display:block;}
</style>

<div align="center" id="divQst" class="qst_main_table_li">
	<table style="width: 100%;">
	{{#question}}
	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;">
			Q{{qno_l}}. {{{question_text}}} | Language:{{lang_full_name}} | Level:{{level_name}}
		</td>
	</tr>
  
	<tr>
		<td style="padding:5px; font-family: tahoma;">
			
					{{{code_question}}}
				
		</td>
	</tr> 
	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;">
			{{#IsAnswered}}You have submitted the code.{{/IsAnswered}}
			{{^IsAnswered}}Type the program below and submit code.{{/IsAnswered}}
		<span style="float:right; padding: 10px; background-color: silver; border-radius: 10px;font-weight: bold; font-size:16pt; cursor: pointer;" title="Maximize" onclick="JsController.DoEditorOnFullScreen();"><img src="../static/img/comp/maximize.png" alternate="Maximize"></span></td>
	</tr>	
	<tr>
		<td style="padding:5px; font-family: tahoma;">
		
		<button class="aptBtn" style="z-index: 10; position: fixed; right: 10px; top: 10px" id="codeClose" onclick="JsController.DoEditorCloseFullScreen();">Close</button>
		
<textarea style="width:100%; height: 400px;" id="plainCode" {{#IsAnswered}}readonly{{/IsAnswered}}>
{{^IsAnswered}}
	{{#runData}}
{{#IsThereLastRun}}{{{lastRunProgram}}}	
		{{/IsThereLastRun}}	
{{^IsThereLastRun}}{{{default_program}}}
		{{/IsThereLastRun}}	
	{{/runData}}
{{/IsAnswered}}
{{#IsAnswered}}
	{{#runData}}
{{#IsThereLastRun}}{{{lastRunProgram}}}
		{{/IsThereLastRun}}	
{{^IsThereLastRun}}{{{user_program}}}
		{{/IsThereLastRun}}	
	{{/runData}}
{{/IsAnswered}}
</textarea>

				
		</td>
	</tr> 
	
	<tr class="c_list_item_gr">
		<td style="padding:5px;">
			{{#IsAnswered}}
			<div style="color:#4CAF50;font-weight:bold;font-size:12pt;font-family:Arial; text-align: center;">
				Thank you. You have submitted the code.</div>
			{{/IsAnswered}}
			{{^IsAnswered}}
			<div id="myQBtns">
				
				<div style="display:inline-block;"><div style="float:left;">
					{{#IsRunAllowed}}
					<input type="button" class="aptBtn"  
						style=" margin-right:10px;" 
						onclick="JsController.RunQnAction();" 
						value="RUN" 
						id="idRunCode"						
						>
					<span style="display:none;" id="idRunningCode">Running...</span>
					{{/IsRunAllowed}}
					{{^IsRunAllowed}}
						<span>
							Max <b>RUN</b> options (<b>{{number_of_runs}}</b> times) used.
						</span>
					{{/IsRunAllowed}}

					<input type="button" class="aptBtn"  					 
						onclick="JsController.SaveQnAction();" 
						value="Submit Code" 
						id="idSubmitCode">	
					</div>						
				</div>
				<div style="display:inline-block; width: 50%;border:1px solid white;">				
				About <b>RUN</b> options: 
				(a) Maximum=<b>{{max_runs}}</b> times. 
				(b) Used=<b>{{number_of_runs}}</b> times. <!--
				(c) Balance=<b>{{NumberOfBalanceRuns}}</b> time(s).<br>
				<b>RUN</b> option will run the first test case.<br>
				<b>RUN</b> option will not SAVE the code and the score for the test case.	<br>			
				<b>Submit Code</b> option will run all the test cases.<br>
				<b>Submit Code</b> option will save the code and the scores of the test cases.<br>
				Once you have used the <b>Submit Code</b> option, you cannot submit again. <br> -->
				</div>
			</div>
			{{/IsAnswered}}
		</td>
	</tr>
	
	<tr class="c_list_item_gr">
		<td style="padding:5px;">
			<div id="myQBtns">
			<div style="float:right;display:inline-block;">
				<input type="button" class="aptBtn" style="float: right;" onclick="JsController.FinishTest();" value="Finish Test"> 
				<input type="button" class="aptBtn" style="float: right;margin-right: 20px;"  onclick="JsController.StepShowInstruction();" value="Instructions">
			</div>
			<div style="display:inline-block; float:right;margin-right: 20px;">
				<input type="button" class="aptBtn"  onclick="JsController.PreviousQuestion();" value="< Previous">
				<input type="button" class="aptBtn"  onclick="JsController.NextQuestion();" value="Next >">			
			</div>
			<div id="myNonQBtns" style="display:none;color:orange;font-weight:bold;font-size:12pt;font-family:Arial; text-align: center;">Submitting Your Code...
			</div>

		</td>
	</tr>
	{{#runData}}
	{{#IsThereLastRun}}
	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;color:orange;">
			Last Run {{{runStatus}}}
		</td>
	</tr>
	<tr>
		<td style="padding:10px;font-family:tahoma;">

						<table cellpadding="10" cellspacing="10" width="100%" style="color:orange;">
							<tr>
								<th colspan="3">Input</th>								
							</tr>
							<tr>
								<td colspan="3"  style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5" readonly>{{input}}</textarea>
									<!--pre style="font-size:12pt;">{{input}}</pre-->
									
								</td>
							</tr>
							<tr>
								<th width="50%" >Expected Output</th>
								<th style="width:20px;"></th>
								<th >Your Output</th>
							</tr>
							<tr >
								<td  valign="top" style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5" readonly>{{expectedOutput}}</textarea>
									<!--pre style="font-size:12pt;">{{expectedOutput}}</pre-->
									
								</td>
								<td></td>
								<td valign="top"  style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5" readonly>{{lastRunOutput}}</textarea>
									<!--pre style="font-size:12pt;">{{lastRunOutput}}</pre-->
									
								</td>
							</tr>				
						</table>
					          
		</td>
	</tr>
	{{/IsThereLastRun}}
	{{/runData}}

	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;">
			Test Cases
		</td>
	</tr>
	<tr>
		<td style="padding:10px;font-family:tahoma;">
			<table border="0" class="qst_ans_table" style="border: 1px solid #ccc;">
				{{#answer}}
				<tr style="background-color:rgb(28, 181, 224);">
					<td style="padding:5px;"><b>Test Case#{{sno}}</b> : 
					<span style="color:white;">{{{TestCaseStatus}}}</span></td>					
				</tr>
				<!--tr>
					<td style="padding:5px;"><b>Status:</b>{{{TestCaseStatus}}}</td>					
				</tr>					
				<tr>
					<td style="padding:5px;"><b>Input:<br/></b><pre style="font-size:12pt;">{{input}}</pre></td>					
				</tr-->
				<tr>
					<td style="padding:5px;" >
						<table cellpadding="10" cellspacing="10" width="100%">
							<tr>
								<th colspan="3">Input</th>								
							</tr>
							<tr>
								<td colspan="3"  style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5"  readonly>{{input}}</textarea>
									<!--pre style="font-size:12pt;">{{input}}</pre-->
									
								</td>
							</tr>
							<tr>
								<th width="50%" >Expected Output</th>
								<th style="width:20px;"></th>
								<th >Your Output</th>
							</tr>
							<tr>
								<td  valign="top" style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5" readonly>{{output}}</textarea>
									<!--pre style="font-size:12pt;">{{output}}</pre-->
									
								</td>
								<td></td>
								<td valign="top"  style="border:1px solid silver;background-color:white;">
									<textarea style="width:100%;" rows="5"  readonly>{{user_output}}</textarea>
									<!--pre style="font-size:12pt;">{{user_output}}</pre-->
									
								</td>
							</tr>				
						</table>
					</td>
				</tr>
				<!--tr>
					<td style="padding:5px;"><b>Output:</b><br/><pre style="font-size:12pt;">{{output}}</pre></td>					
				</tr>
				<tr>
					<td style="padding:5px;"><b>Your Program Output:</b><br/><pre style="font-size:12pt;">{{user_output}}</pre></td>					
				</tr-->
							
				{{/answer}}				
			</table>            
		</td>
	</tr>
	{{/question}}
	</table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
