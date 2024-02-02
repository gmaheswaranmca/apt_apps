<div align="center" id="divQst" class="qst_main_table_li" style="padding:0px;margin:0px;">

<table align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		{{#TestPapers}}
		<td width="25%">
			<input type="button" style="width:100%;"
			class="pgrBt  {{IsActive}} {{#IsActive}}pgrBtCurr{{/IsActive}}" 
			value="{{quiz_name}}" title="{{quiz_name}}"
			onclick="TakeTestViewRender.LoadPaper({{quiz_id}})"> 
		</td>		
		{{#IsPagerLine}}</tr><tr>{{/IsPagerLine}}
		{{/TestPapers}}
</table>
</div>