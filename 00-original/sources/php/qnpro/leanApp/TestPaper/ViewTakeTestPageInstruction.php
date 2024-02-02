{{^IsValidAssignment}}
	<div class="qst_main_table_li">
			<table border=1 class="tblGridLi">
				<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
					<td align="center">No such test paper exist.<br>
					Otherwise, You may not have access to the test paper.</td>
				</tr>
			</table>
		</div>
	
{{/IsValidAssignment}}
{{#IsValidAssignment}}	
	{{#quiz}}
		{{#IsFinished}}
	<div class="qst_main_table_li">
		<table border=1 class="tblGridLi">
			<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
				<td align="center">
					You have already finished the test {{#IsTimedOut}} by time out.{{/IsTimedOut}}
				</td>
			</tr>
		</table>
	</div>	
		{{/IsFinished}}
		{{^IsFinished}}
		<div class="qst_main_table_li">
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
								id="btnContinue" onclick="TakeTestViewRender.vTakeTestPage.NextToInstruction()"  							
								value="{{#QStarted}}Close{{/QStarted}}{{^QStarted}}Continue{{/QStarted}}"
								style="disp1lay:None;"/>	
							{{^QStarted}}<span class="brand-prd-desc" style="width:100%;font-size:18pt;" 
								id="msgContinue">Wait for few seconds...Loading...</span>{{/QStarted}}
						</td>
					</tr>
			</table>
		</div>
		{{/IsFinished}}
	{{/quiz}}
{{/IsValidAssignment}}