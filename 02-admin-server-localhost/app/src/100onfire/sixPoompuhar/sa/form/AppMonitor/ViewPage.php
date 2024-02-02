<div class="container-responsive">
<table class="table table-borderless">			
<tr>
	<td>Dashboard</td>
	<td style="width:100%;"><div class="btn btn-light rounded-pill m-1 loadvaltmr" id="DivAppMonitorTmr">1</td>
</tr>
{{#test}}
<tr>
	<td class="align-middle text-nowrap">
		<div class="badge {{#is_finished}}badge-success{{/is_finished}} {{#is_on}}badge-warning{{/is_on}} {{#is_off}}badge-secondary{{/is_off}} f10 p-1 text-left">
			{{quiz_name}} <small class="badge badge-light">{{status_disp_name}}</small>
		</div> 
	</td>
	<td class="text-left text-nowrap">
		<div class="badge badge-danger rounded-circle f10 wh3rem"  >{{not_taken}}			</div>
		<div class="badge badge-warning   rounded-circle f10 wh3rem"  >{{liveuser_count}}	</div>
		<div class="badge badge-success   rounded-circle f10 wh3rem"  >{{tookuser_count}}		</div>
		<div class="badge badge-light     rounded-circle f10 wh3rem"  >=		</div>
		<div class="badge badge-primary   rounded-circle f10 wh3rem"  >{{user_count}}			</div>
		{{#is_finished}}
		<div class="badge badge-dark   rounded-pill f10 wh3rem"  style="width:4rem;">
			<a href="" class="link text-light" 
			onclick="return gfMgr.DlgSecretCodeOpen(AppMonitorReqRes.mdResultDownload.CallMe,[{{assignment_id}},'{{quiz_name}}']);"
			data-toggle="modal" data-target="#dlgSecretCode">Result</a></div>
		{{/is_finished}}	
		{{^is_off}}
		<div class="badge badge-dark  rounded-pill f10 wh3rem"  style="width:4rem;">
			<a href="" class="link text-light" 
			onclick="return gfMgr.DlgSecretCodeOpen(AppMonitorReqRes.mdAssessmentUpdateStatus.CallMe,[{{assignment_id}},0]);"
			data-toggle="modal" data-target="#dlgSecretCode">Off</a></div>
		{{/is_off}}			
		{{^is_on}}
		<div class="badge badge-dark  rounded-pill f10 wh3rem"  style="width:4rem;">
			<a href="" class="link text-light" 
			onclick="return gfMgr.DlgSecretCodeOpen(AppMonitorReqRes.mdAssessmentUpdateStatus.CallMe,[{{assignment_id}},1]);"
			data-toggle="modal" data-target="#dlgSecretCode">On</a></div>
		{{/is_on}}
		{{^is_finished}}
		<div class="badge badge-dark  rounded-pill rf10 wh3rem"  style="width:4rem;">
			<a href="" class="link text-light" 
			onclick="return gfMgr.DlgSecretCodeOpen(AppMonitorReqRes.mdAssessmentUpdateStatus.CallMe,[{{assignment_id}},2]);"
			data-toggle="modal" data-target="#dlgSecretCode">Finish</a></div>
		{{/is_finished}}
			
	</td>
</tr>
{{/test}}		
<tr>
    <td></td>
	<td>
		<div class="badge badge-danger mw10remw18per"    >Absent</div>
		<div class="badge badge-warning mw10remw18per"  >Live</div>
		<div class="badge badge-success mw10remw18per"  >Finished</div>
		<div class="badge badge-primary mw10remw18per"  >Total</div>
	</td>
</tr>
</div>		