<style type="text/css">
.bg td{background-color:#ccc; color:black;}
.bor td{border-bottom:1px solid #ccc;}
</style>

<table class="tblGrid">
	<tr class="c_list_head bg">
		<td>Title</td>
		<td>About</td>
		<td>Qns</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
	{{#assignment}}
	<tr class="c_list_item bor" style="height:42px;">
		<td>
			{{quiz_name}}</td>
		<td>
			{{about_quiz}}</td>
		<td>
			{{qn_count}} 
		</td>
		<td>
			<a href="PageTestPaper.php?id={{quiz_id}}" class="aptBtn" style="padding: 10px 10px; text-decoration: none;">
			Go Inside
			</a>
		</td>		
	</tr>
	{{/assignment}}
	{{^assignment}}
		<tr class="c_list_item bor" style="height:42px;">
			<td style="height:100px;">No Active Assignments Found.</td>
			<td>&nbsp;</td>
		</tr>
	{{/assignment}}
</table>	
<table>
    <tr><td class="desc_text">&nbsp;</td></tr>
	<tr><td class="desc_text">&nbsp;</td></tr>
</table>