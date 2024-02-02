<div align="center" id="divQst" class="qst_main_table_li" style="font-size:14pt;font-family:tahoma;">
	<table width="100%" cellpadding="5" cellspacing="0" border="0">
		{{#finish_tp}}		
		<tr>
			<td class="header_text" style="padding:5px; background-color:#ccc;font-size:14pt;" colspan="4">
				Are you sure to finish the test?
			</td>
		</tr>
		<tr>
			<td colspan="4" style="border-bottom:1px solid silver;">
				Out of {{qn_count}} Questions:
			</td>
		</tr> 		
		<tr>
			<td style="border-bottom:1px solid silver;max-width:120px;">
				<span class="pgrBt pgrBtAns" style="display:inline-block;">&nbsp;</span> Answered 
			</td>
			<td width="15" style="border-bottom:1px solid silver;">:</td>
			<td width="70" style="border-bottom:1px solid silver;padding-right:20px;" align="right">
			{{qns_answered}}</td>
			<td style="border-bottom:1px solid silver;"> Questions</td>
		</tr> 
		<tr>
			<td style="border-bottom:1px solid silver;">
				<span class="pgrBt pgrBtNotAns" style="display:inline-block;">&nbsp;</span> Visited but Not Answered 
			</td>
			<td style="border-bottom:1px solid silver;">:</td>
			<td style="border-bottom:1px solid silver;padding-right:20px;" align="right">
			{{qns_not_answered}}</td>
			<td style="border-bottom:1px solid silver;">Questions</td>
		</tr> 
		<tr>
			<td style="border-bottom:1px solid silver;">
				<span class="pgrBt pgrBtNotVisit" style="display:inline-block;">&nbsp;</span> Not Visited 
			</td>
			<td style="border-bottom:1px solid silver;">:</td>
			<td style="border-bottom:1px solid silver;padding-right:20px;" align="right">
			{{qns_not_visited}}</td>
			<td style="border-bottom:1px solid silver;">Questions</td>
		</tr> 
		<tr>
			<td style="border-bottom:1px solid silver;" colspan="4" valign="middle">
				You have Balance Time : <div class="AptStTimer" id="myRemainingTime" style="float:none;"></div>
			</td>
		</tr> 		
		<tr class="c_list_item_gr">
			<td style="padding:5px;" colspan="4">
				<button class="aptBtn"  style="min-width:50px;"  onclick="return JsController.apdata.action.AcceptFinish();" title="Finish"> Finish </button>
				<button class="aptBtn"  style="min-width:50px;"  onclick="return JsController.apdata.action.CancelFinish();" title="Cancel"> Cancel </button>
			</td>
		</tr>
		{{/finish_tp}}
	</table>
</div>