<!-- Modal -->
<div class="modal" id="eyeUs" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		   <div class="badge mt-2 mr-1" style="width:2rem;"><img src="../static/img/icons/eye-16px.png" alt="Show Settings"></div>		  
		   <h4 class="modal-title">Eye Detail</h4>
		   <div   class="btn btn-info mt-2 ml-1"
  onclick="CpViewRender.eye.Out();"><img src="../static/img/icons/refresh-16px.png" 
  alt="Refresh" ></div>		
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body" >
		  <div class="container">
				 					
							<div class="badge badge-muted text-left f10 w10h2rem">vLoad</div>
							<div  class="btn btn-light rounded-pill m-1 loadvaltmr f10" id="vLoadReq">1</div>
							<div  class="badge" id="vLoadEye"></div>	
			</div>
			<div class="container">
							<div class="badge text-left f10 w10h2rem" >mdLoad</div>
								<div  class="btn btn-light rounded-pill m-1 loadvaltmr f10"  id="mdLoadReq">1</div>
							
							<div  class="badge" id="mdLoadEye"></div>
			</div>
			<div class="container">
							<div  class="badge text-left f10 w10h2rem">mdLoadHis</div>
								<div  class="btn btn-light rounded-pill m-1 loadvaltmr f10"  id="mdLoadHisReq">1</div>
							<div  class="badge" id="mdLoadHisEye"></div>
				
			</div></div>
		  </div>
		
		<div class="modal-footer">
			
		  <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
		</div>
	  </div>
	  
	</div>
</div>	  