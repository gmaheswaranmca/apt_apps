<style type="text/css">
.pgrBtLike{
	display:table-cell;
	vertical-align:middle;
	text-align:center;
	
}
</style>

<div align="center" id="divQst" class="" >
<div style="background-color:white;">
	<table cellpadding="0" cellspacing="0" width="100%"  style="font-size:12pt;" id="QnSimple">
	{{#question}}
	    <tr>
		<td style="border-bottom:1px silver solid;width:30px;vertical-align:middle;">({{qno_l}})</td>
            <td colspan="2" style="border-bottom:1px silver solid;">
			<table width="100%" style="font-family:Arial;border:1px dashed silver;margin-bottom:20px;">
				<tr><td colspan="5" style="{{#IsChanged}}border:1px solid yellow;{{/IsChanged}}">{{{question_text}}}</td></tr>
				<tr>
					{{#options}}<td width="{{CellWidth}}%" style="border:{{#IsOptChanged}}2px solid orange{{/IsOptChanged}}{{^IsOptChanged}}1px dashed silver{{/IsOptChanged}}; {{#IsAnswer}}font-weight:bold;color:white;background-color:orange;{{/IsAnswer}}">{{Letter}}) {{{option}}}</td>
						{{#IsNextLine}}</tr><tr>{{/IsNextLine}}					
					{{/options}}
					
				</tr>
			</table>
			</td>
	    <td  style="border-bottom:1px silver solid;padding-top:5px; font-family:'Arial Narrow';font-size:8pt;text-align:right;vertical-align:top;width:50px;">
		</td>
     </tr>
	{{/question}}
	</table>
	<table style="width: 100%;" style="display:none;" id="QnInTest">
	{{#question}}
	<tr>
		<td class="header_text" style="padding:5px; background-color:#ccc;{{#IsChanged}}border:1px solid yellow;{{/IsChanged}}">
			<span class="pgrBtLike pgrBt pgrBtAns pgrBtCurr">Q{{qno_l}}</span>
		</td>
	</tr>
	<tr>
		<td style="padding:5px;{{#IsChanged}}border:1px solid yellow;{{/IsChanged}}">
			<font face="tahoma" size="4"><b>{{{question_text}}}</b></font>
		</td>
	</tr>    
	<tr>
		<td style="padding:10px;">
			<table border="0" class="qst_ans_table" cellspacing="10" >
				{{#options}}
				<tr style="background-color:#eee;color:navy;">
					<td style="padding:5px;border:1px solid {{#IsOptChanged}}orange{{/IsOptChanged}}{{^IsOptChanged}}#ccc{{/IsOptChanged}};">
						<label class="rbcontainer">{{{option}}}
							<input type="radio" {{#IsAnswer}}checked{{/IsAnswer}} id="rdAns{{question_id}}_{{id}}" name="rdAns{{question_id}}" value="{{id}}">
							<span class="rbcheckmark"></span>
						</label>
					</td>					
				</tr>
				{{/options}}				
			</table>            
		</td>
	</tr>
	<tr class="c_list_item_gr">
		<td style="padding:5px;">
			&nbsp;<br><br>
		</td>
	</tr>
	{{/question}}
	</table>
	
	

</div>	
</div>

