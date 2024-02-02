{{#show_error}}

	<div class="qst_main_table_li">
		<table border=1 class="tblGridLi">
			<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
				<td align="center">You have already finished this quiz				
				{{#is_timedout}}<br/>Timed Out.{{/is_timedout}}
			<!--	{{#quiz}}<br/> Total Score is {{pass_score_point}} out of {{pass_score}}{{/quiz}} -->
				</td>
			</tr>
		</table>
	</div>
	
{{/show_error}}
{{^show_error}}
{{^quiz}}
	<div class="qst_main_table_li">
		<table border=1 class="tblGridLi">
			<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
				<td align="center">You don't have access to this quiz</td>
			</tr>
		</table>
	</div>
{{/quiz}}
{{#quiz}}
<div class="qst_main_table_li">
	{{#show_intro}}
		<table border=1 class="tblGridLi">
			<tr class="c_list_head_gr">
				<td>Instructions</td>				
			</tr>
		</table>	
		<table border=1 class="tblGridLi">
			<tr class="c_list_item_gr">
				<td>{{{intro_text}}}</td>
			</tr>
		</table>
		<table width="100%">
				<tr class="c_list_item_gr">
					<td><input type="button" class="aptBtn"  
							id="btnContinue" onclick="JsController.apdata.action.NextToInstructions()"  							value="{{#QStarted}}Close{{/QStarted}}{{^QStarted}}Continue{{/QStarted}}"
							style="display:None;"/>	
						{{^QStarted}}<span class="brand-prd-desc" style="width:100%;font-size:18pt;" id="msgContinue">Wait for few seconds...Loading...</span>{{/QStarted}}
					</td>
				</tr>
		</table>
	{{/show_intro}}
	{{^show_intro}}
		<table border=1 class="tblGridLi">
			<tr class="c_list_item_gr">
				<td>No Instructions For This Test.</td>
			</tr>
		</table>
	{{/show_intro}}
</div>
{{/quiz}}

{{/show_error}}