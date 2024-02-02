<?php 
	
?>
<style type="text/css">
.bg td{background-color:#ccc; color:black;}
.bor td{border-bottom:1px solid #ccc;}
</style>

<table class="tblGrid">
	<tr class="c_list_head bg">
		<td>Test name</td><td>Status</td>
		<td>Start date</td>
		<td>Finish date</td>
	</tr>
	{{#assignment}}
	<tr class="c_list_item bor">
		<td>{{quiz_name}}</td><td>{{#finish_date}}Finished. <!-- Score: {{pass_score_point}} out of {{pass_score}}{{/finish_date}}{{^finish_date}}Not Finished{{/finish_date}} --> </td>
		<td>{{added_date}}</td>
		<td>{{finish_date}}</td>
	</tr>
	{{/assignment}}
	{{^assignment}}
		<tr class="c_list_item">
		<td>No Old Assignments Found.</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{{/assignment}}
</table>	
<table>
    <tr><td class="desc_text">&nbsp;</td></tr>
	<tr><td class="desc_text">&nbsp;</td></tr>
</table>