<style type="text/css">
.pgrBtLike{
	display:table-cell;
	vertical-align:middle;
	text-align:center;
	
}
</style>

<div align="center" id="divQst" class="qst_main_table_li">
	<table style="width: 100%;" cellpadding="0" cellpspacing="0" border="0">
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
		<td style="padding:1px;">
			<table border="0" class="qst_ans_table" cellspacing="1" >
				{{#answer}}
				<tr style="background-color:#eee;color:navy;">
					<td style="padding:5px;border:1px solid #ccc;">
						<label class="rbcontainer">{{{answer_text}}}
						<input type="radio" {{#IsUserAnswered}}checked{{/IsUserAnswered}} id="rdAns" name="rdAns" value="{{answer_id}}">
						<span class="rbcheckmark"></span>
						</label>
					</td>					
				</tr>
				{{/answer}}				
			</table>            
		</td>
	</tr>

	<tr class="c_list_item_gr">
		<td style="padding:5px;">
			<div id="myQBtns" class="AboutQuizInScreen">
				<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.PreviousQuestion();" title="Previous"><span style="color:black;">&#x25C4;</span>Previous</button>
				{{^IsLastQn}}<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.NextQuestion();" title="Save & Next"><span style="color:black;">&#x1f4be;</span>Save<span style="color:black;">&</span>Next<span style="color:black;">&#x25BA;</span></button>{{/IsLastQn}}
				{{#IsLastQn}}<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.NextQuestion();" title="Save & Next"><span style="color:black;">&#x1f4be;</span> Save</button>{{/IsLastQn}}
				<button type="button" class="aptBtn" onclick="JsController.apdata.action.ShowInstruction();"  title="Instructions"><span style="color:black;">&#x003F;</span>Instructions</button>
			</div>			
			<div id="myQBtns" class="AboutQuizInMobile">
				<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.PreviousQuestion();" title="Previous"><span style="color:black;">&#x25C4;</span>Previous</button>
				{{^IsLastQn}}<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.NextQuestion();" title="Save & Next"><span style="color:black;">&#x1f4be;</span>Save<span style="color:black;">&</span>Next<span style="color:black;">&#x25BA;</span></button>{{/IsLastQn}}
				{{#IsLastQn}}<button class="aptBtn"  style="min-width:50px;"  onclick="JsController.apdata.action.NextQuestion();" title="Save & Next"><span style="color:black;">&#x1f4be;</span> Save</button>{{/IsLastQn}}
				<button type="button" class="aptBtn" onclick="JsController.apdata.action.ShowInstruction();"  title="Instructions"><span style="color:black;">&#x003F;</span></button>
			</div>			
		</td>
	</tr>
	{{/question}}
	</table>
</div>