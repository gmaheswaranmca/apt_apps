<div align="center" id="divQst" class="qst_main_table_li">
	<table cellpadding="0" cellspacing="0" width="100%" id="QnEditing">
		{{#question}}
		<tr>
			{{#options}}
				<td width="{{CellWidth}}%" style="border:1px dashed silver;border-bottom:0px;">{{Letter}}) 
					<input type="radio" name="nameOptIsAns"  id="idOptIsAns{{id}}" value="{{id}}"     {{#IsAnswer}}checked{{/IsAnswer}}> 
					<input type="text"  name="nameOpt{{id}}" id="idOpt{{id}}"      value="{{option}}" style="width:83%;{{#IsOptChanged}}border-color:orange;{{/IsOptChanged}}">
				</td>
				{{#IsNextLine}}</tr><tr>{{/IsNextLine}}
			{{/options}}
		</tr>			
		{{/question}}
		{{#quiz}}
			<td  style="border:1px dashed silver;border-bottom:0px;">
				<textarea id="idRule" style="width:100%;height:200px;">{{rule}}</textarea>
			</td>
		{{/quiz}}
	</table>
</div>
