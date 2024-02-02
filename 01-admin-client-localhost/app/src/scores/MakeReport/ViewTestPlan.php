<style type="text/css">
.bg td{background-color:#ccc; color:black;}
.bor td{border-bottom:1px solid #ccc;}
.aptUserList { 
	overflow: auto;
	margin:5px;padding:5px;
	max-height:50px;
	border:1px solid #56ab2f; border-radius:10pt;
	background-color:#a8e063;
	font-size:8pt;font-family:'Arial Narrow';	
}
</style>
<div id="secTP">
<table class="tblGrid" style="margin:2px;margin-left:0px;margin-right:0px;border:0px;">
	<tr class="c_list_head bg"><td><span style="color:darkgreen;">Test Papers</span>
		<span style="margin-left:1in;">Select&nbsp;&nbsp;<a href="javascript:gfMgr.CheckboxSelAllNone('idDivTP',true);">All</a>&nbsp;&nbsp;
				<a href="javascript:gfMgr.CheckboxSelAllNone('idDivTP',false);">None</a></span>
		</td>
	</tr>
</table>

<div align="center" id="idDivTP" class="qst_main_table_li">
	<table cellpadding="0" cellspacing="0" width="100%">
		{{#testpaper}}
		<tr>		
			<td style="border-top:1px solid silver;">
				<input type="checkbox" name="nameIsQzYes"  id="idIsQzYes{{quiz_id}}" value="{{quiz_id}}"> 				
				<input type="hidden" name="nameQzIdx"  id="idQzIdx{{quiz_id}}" value="{{idx}}">
			</td>		
			<td style="border-top:1px solid silver;">
				{{quiz_name}}
			</td>
			<td style="border-top:1px solid silver;">
				<input type="text"  name="nameQzQns" id="idQzQns{{quiz_id}}" value="{{qn_count}}"> Qns
			</td>		
			<td style="border-top:1px solid silver;">
				<input type="text"  name="nameQzMins" id="idQzMins{{quiz_id}}" value="0"> mins
			</td>
			
			<td style="border-top:1px solid silver;">
				{{about_quiz}}
			</td>			 
		</tr>			
		<tr>	
			<td style="border-bottom:1px solid silver;">
			</td>
			<td style="border-bottom:1px solid silver;" colspan="4">
			
			<div class="aptUserList">{{{assignment}}}</div>
			</td>
		</tr>	
		{{/testpaper}}
	</table>
</div>
</div>
<div id="secTest">
<table class="tblGrid" style="margin:2px;margin-left:0px;margin-right:0px;border:0px;">
	<tr class="c_list_head bg"><td><span style="color:darkgreen;">Tests</span>
		<span style="margin-left:1in;">Select&nbsp;&nbsp;<a href="javascript:gfMgr.CheckboxSelAllNone('idDivTest',true);">All</a>&nbsp;&nbsp;
				<a href="javascript:gfMgr.CheckboxSelAllNone('idDivTest',false);">None</a></span>
		</td>
	</tr>
</table>


<div align="center" id="idDivTest" class="qst_main_table_li">
	<table cellpadding="0" cellspacing="0" width="100%">
		{{#assignment}}
		<tr>		
			<td style="border-top:1px solid silver;width:15px;">
				<input type="checkbox" name="nameIsAssignmentYes"  id="idIsAssignmentYes{{assignment_id}}" value="{{assignment_id}}">
				<input type="hidden" name="nameAssignmentIdx"  id="idAssignmentIdx{{assignment_id}}" value="{{idx}}">
			</td>
			<td style="border-top:1px solid silver;">
				{{quiz_name}}, {{question_count}} Qns, {{quiz_duration}} Mins
			</td>		
		</tr>		
		<tr>	
			<td style="border-bottom:1px solid silver;"> 
			</td>
			<td style="border-bottom:1px solid silver;">
			<div class="aptUserList">{{user_list}}</div>
			</td>
		</tr>			
		{{/assignment}}
	</table>
</div>
</div>
<div id="secField">
<table class="tblGrid" style="margin:2px;margin-left:0px;margin-right:0px;border:0px;"><tr class="c_list_head bg"><td>Report Fields</td></tr></table>

<div align="center" id="idDivField" class="qst_main_table_li">
	<table cellpadding="0" cellspacing="0" width="100%">
		{{#fields}}
		<tr>		
			<td style="border-top:1px solid silver;width:15px;">
				<input type="checkbox" name="nameIsField"  id="idIsField{{field_id}}" value="{{field_id}}">
				<input type="hidden" name="nameFieldIdx"  id="idFieldIdx{{field_id}}" value="{{idx}}">
			</td>
			<td style="border-top:1px solid silver;">
				{{field_name}}
			</td>		
		</tr>		
		<tr>	
			<td style="border-bottom:1px solid silver;">
			</td>
			<td style="border-bottom:1px solid silver;">
			<div class="aptUserList">{{field_list}}</div>
			<div class="aptUserList">{{field_caption}}</div>
			</td>
		</tr>			

		{{/fields}}
	</table>
</div>
</div>
<div id="secUserGroup">
<table class="tblGrid" style="margin:2px;margin-left:0px;margin-right:0px;border:0px;">
	<tr class="c_list_head bg"><td><span style="color:darkgreen;">Report User Groups</span>
		<span style="margin-left:1in;">Select&nbsp;&nbsp;<a href="javascript:gfMgr.CheckboxSelAllNone('idDivUserGroup',true);">All</a>&nbsp;&nbsp;
				<a href="javascript:gfMgr.CheckboxSelAllNone('idDivUserGroup',false);">None</a></span>
		</td>
	</tr>
</table>



<div align="center" id="idDivUserGroup" class="qst_main_table_li">
	<table cellpadding="0" cellspacing="0" width="100%">
		{{#user_groups}}
		<tr>		
			<td style="border-top:1px solid silver;width:15px;">
				<input type="checkbox" name="nameIsUsrGroup"  id="idIsUsrGroup{{group_id}}" value="{{group_id}}">
				<input type="hidden" name="nameUsrGroupIdx"  id="idUsrGroupIdx{{group_id}}" value="{{idx}}">
			</td>
			<td style="border-top:1px solid silver;">					
					<div class="aptUserList"><strong style="background-color:#ccc;padding:5px;border:1px solid silver;border-radius:5px;">{{group_name}}</strong> {{d_user_list}}</div>
			</td>		
		</tr>		
		{{/user_groups}}
	</table>
</div>
</div>
<a href="javascript:MakeReportViewRender.PleaseTellMe();">Please Tell Me</a>