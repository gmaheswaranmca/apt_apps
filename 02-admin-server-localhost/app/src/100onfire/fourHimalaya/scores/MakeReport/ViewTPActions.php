<table align="center" width="100%">
	<tr>		
		<td>
			<input type="button" class="pgrBt  pgrBtAns" value="Make Report" title="Make Report" style="width:150px;"
			onclick="MakeReportViewRender.MakeReport();"> 
		</td>
	</tr>
	<tr>		
		<td>
			<input type="button" class="pgrBt  " value="Test Plan" title="Test Plan" style="width:150px;"
			onclick="MakeReportViewRender.TestPlan();"> 
		</td>
	</tr>
	<tr>		
		<td>
			<input type="button" class="pgrBt  " value="New Make Report" title="New Make Report" style="width:150px;"
			onclick="MakeReportViewRender.NewMakeReport();"> 
		</td>
	</tr>
	<tr>		
		<td>
			<input type="button" class="pgrBt  " id="idNMRPrev" value="<<" title="Test Plan" 
			onclick="MakeReportViewRender.NewMakeReportPrev();"> 
			<input type="button" class="pgrBt  " id="idNMRNext" value=">>" title="Test Plan" 
			onclick="MakeReportViewRender.NewMakeReportNext();"> 
		</td>
	</tr>
</table>
<div id="idDivDownloadMsg">
</div>