<style type="text/css">
.bg td{background-color:#ccc; color:black;}
.bor td{border-bottom:1px solid #ccc;}
</style>

<table class="tblGrid">
	<tr class="c_list_head bg">
		<td>Title</td>
		<td>Status</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
	{{#assignment}}
	<tr class="c_list_item bor" style="height:42px;">
		<td>
			{{quiz_name}} <br>
			Total Number of Questions: {{qn_count}} Questions <br> 
			Maximum Time Limit: {{time_limit}} mins
		</td>
		<td>
			{{#IsQuizToStart}}
			<a href="TakeTest.php?id={{assignment_id}}" class="aptBtn" style="padding: 10px 50px; text-decoration: none;">
			{{#IsQuizToContinue}}Continue{{/IsQuizToContinue}}{{^IsQuizToContinue}}Start{{/IsQuizToContinue}}			
			</a>
			{{/IsQuizToStart}}
			{{^IsQuizToStart}}
				You have already finished this test{{#IsTimedOut}} by time out{{/IsTimedOut}}.<br/>
			{{/IsQuizToStart}}
		</td>
		<td>&nbsp;</td>
	</tr>
	{{/assignment}}
	{{^assignment}}
		<tr class="c_list_item bor" style="height:42px;">
			<td style="height:100px;">No Active Assignments Found.</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	{{/assignment}}
</table>	
<table>
    <tr><td class="desc_text">&nbsp;</td></tr>
	<tr><td class="desc_text">&nbsp;</td></tr>
</table>