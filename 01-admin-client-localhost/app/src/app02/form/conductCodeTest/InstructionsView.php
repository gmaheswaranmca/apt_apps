{{#show_error}}

	<div class="qst_main_table_li">
		<table border=1 class="tblGridGreen">
			<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
				<td align="center">
					<h3>You have finished this 'Coding Test'</h3>
				{{#is_timedout}}<p>Timed Out.</p>{{/is_timedout}}
				<p><a href="ActiveAssignmentRes.php">Go Back</a></p>
				<!-- {{#quiz}}<br/> Total Score is {{pass_score_point}} out of {{pass_score}}{{/quiz}} -->
				</td>
			</tr>
		</table>
	</div>
	
{{/show_error}}
{{^show_error}}
{{^quiz}}
	<div class="qst_main_table_li">
		<table border=1 class="tblGridGreen">
			<tr class="c_list_item_gr" style="height:100px; font-weight: bold;">
				<td align="center">You don't have access to this 'Coding Test' </td>
			</tr>
		</table>
	</div>
{{/quiz}}
{{#quiz}}
<div class="qst_main_table_li">
	{{#show_intro}}
		<table border=1 class="tblGridGreen">
			<tr class="c_list_head_gr" style="padding:5px; background-color:#ccc;">
				<td>Instructions</td>				
			</tr>
		</table>	
		<table border=1 class="tblGridGreen">
			<tr class="c_list_item_gr">
				<td>{{{intro_text}}}</td>



			</tr>
		</table>
		<table width="100%">
				<tr class="c_list_item_gr">
					<td><input type="button" class="aptBtn"  
							id="btnContinue" onclick="JsController.StepAfterInstruction()"  							
							value="{{#InstructionsShownFirstTime}}Continue{{/InstructionsShownFirstTime}}{{^InstructionsShownFirstTime}}Close{{/InstructionsShownFirstTime}}"
							/>					
					</td>
				</tr>
		</table>
	{{/show_intro}}
	{{^show_intro}}
		<table border=1 class="tblGridGreen">
			<tr class="c_list_item_gr">
				<td>No Instructions for this 'Coding Test' .</td>
			</tr>
		</table>
	{{/show_intro}}
</div>
{{/quiz}}

{{/show_error}}