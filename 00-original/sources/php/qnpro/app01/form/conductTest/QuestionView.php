<style type="text/css">
.pgrBtLike{
	display:table-cell;
	vertical-align:middle;
	text-align:center;
	
}
</style>

<div align="center" id="divQst" class="qst_main_table_li">
	<table style="width: 100%;">
	{{#question}}
	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;">
			<span class="pgrBtLike pgrBt pgrBtAns pgrBtCurr">Q{{qno_l}} <!--.{{qno_a}}--></span>
			<span class="pgrBtLike pgrBt {{#IsAnswering}}pgrBtAning{{/IsAnswering}}  {{^IsAnswering}}{{#IsAnswered}} pgrBtAns{{/IsAnswered}} {{/IsAnswering}}">&nbsp;</span>
			
		</td>
	</tr>
	<tr>
		<td style="padding:5px;">
			<font face="tahoma" size="4">
				<b>
					{{{question_text}}}
				</b>
			</font>
		</td>
	</tr>    
	<tr>
		<td style="padding:10px;">
			<table border="0" class="qst_ans_table" cellspacing="10" >
				{{#answer}}
				<tr style="background-color:#eee;color:navy;">
					<td style="padding:5px;border:1px solid #ccc;">
						<label class="rbcontainer">{{answer_text}}
						<input type="radio" {{#IsUserAnswered}}checked{{/IsUserAnswered}} id="rdAns" name="rdAns" value="{{answer_id}}">
						<span class="rbcheckmark"></span>
						</label>
					</td>					
				</tr>
				{{/answer}}				
			</table>            
		</td>
	</tr>
	<!--tr class="c_list_item_gr">
		<td class="footer_text" style="padding:5px; background-color:#ccc;">
			<input type="hidden" name="hdnPriority" id="hdnPriority" value="{{curr_priority}}">
			<input type="hidden" name="hdnNextPriority" id="hdnNextPriority" value="{{next_priority}}">
			{{footer_text}}
		</td>
	</tr-->
	<tr class="c_list_item_gr">
		<td style="padding:5px;">
			<div id="myQBtns">
			<input type="button" class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.PreviousQuestion();" value="<<">
			{{^IsLastQn}}<input type="button" class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.NextQuestion();" value="  Save >>  ">{{/IsLastQn}}
			{{#IsLastQn}}<input type="button" class="aptBtn"  style="min-width:50px;" onclick="JsController.apdata.action.FinishTest();" value="Save & Finish">{{/IsLastQn}}
			<input type="button" class="aptBtn" onclick="JsController.apdata.action.ShowInstruction();" value="Instructions">
			</div>
			<div id="myNonQBtns" style="display:none;color:orange;font-weight:bold;font-size:12pt;font-family:Arial; text-align: center;">Saving Your Answer...
			</div>
		</td>
	</tr>
	{{/question}}
	</table>
</div>