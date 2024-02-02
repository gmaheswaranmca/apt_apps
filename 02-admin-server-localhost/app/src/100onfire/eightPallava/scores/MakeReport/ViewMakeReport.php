<style type="text/css">
.bg td{background-color:#ccc; color:black;}
.bor td{border-bottom:1px solid #ccc;}
</style>

<table class="tblGrid">
	<tr class="c_list_head bg">
		<td>Report</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
	{{#report}}
	<tr class="c_list_item bor" style="height:42px;">
		<td>
			{{report_name}}
		</td>
		<td>
			<a href="#" class="aptBtn" style="padding: 10px 50px; text-decoration: none;" onclick="MakeReportViewRender.Download({{idx}});return false;">
			More
			</a>
		</td>
		<td>&nbsp;</td>
	</tr>
	{{/report}}
	{{^report}}
		<tr class="c_list_item bor" style="height:42px;">
			<td style="height:100px;">No Active Reports Found.</td>
			<td>&nbsp;</td>
		</tr>
	{{/report}}
</table>	
<table>
    <tr><td class="desc_text">&nbsp;</td></tr>
	<tr><td class="desc_text">&nbsp;</td></tr>
</table>