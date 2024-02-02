<div class="modal fade" id="dlgSecretCode" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">		  
			<div class="badge mt-2 mr-1" style="width:2rem;"><img src="../static/img/icons/key-16px.png" alt="Show Settings"></div>
			<h4 class="modal-title">!!!Secret Key!!!</h4>		  			
			<button type="button" class="close" data-dismiss="modal">&times;</button>		
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-auto">Secret Code</div>
				<div class="col-*"><input type="password" placeholder="Please Enter Secret Code" class"form-control" id="AppSecretCode"></div>
			</div>
			<div class="row">
				<div class="col-sd-*"><small id="AppSecretCodeErr">&nbsp;</small></div>
			</div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-dark" onclick="return gfMgr.DlgSecretCodeAccept();">Accept</button>	
		  <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
		</div>
	  </div>
	  
	</div>
</div>	  