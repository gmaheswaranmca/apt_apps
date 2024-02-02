<style type="text/css">
	.timerCounter {
		display: table-cell; 		
		width: 40px; height:40px; 
		margin:1%;
		font-size: 20px;					
		font-family: 'Lucida Console'; 	
		
		border-radius:20px;
		border:1px solid #434343;		
background: #000000;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #434343, #000000);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #434343, #000000); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


		color: white;
		
		vertical-align:middle;
		text-align: center;	
		
	}
	.timerDiv{
		display:block; width:100%; padding:3px;
		text-align:center;
	}
	.tmrBox{
	font-family:tahoma; font-size:9pt; font-weight:bold;	
	
	border: 1px solid #DBDBDB; border-radius: 5px;
	color:navy;
	background: #ADA996;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.tmrTxt{float:bottom;font-size:7pt;display:block;}
</style>
<table align="center">
	<tr>
	<td class="tmrBox" align="center">Remaining Time: <div style="width:100%" id="myRemainingTime">mm:ss</div></td>
	</tr>
	<tr>
	<td  class="tmrBox" align="center">Test started at : <span id="myTestStartAt">hh:mm PM</span></td>
	</tr>
	<tr>
	<td>
		<div sty1le="overflow:auto; height: 200px;" id="myQMatrix">
		
		</div>
		<table style="font-family:tahoma; font-size:9pt; font-weight:bold;">
			<tr><td>Legend</td></tr>
		</table>	
		<table style="font-family:tahoma; font-size:9pt;">
			<tr>
				<td><span class="pgrBt pgrBtAns" style="display:inline-block;">&nbsp;</span>&nbsp;Answered&nbsp;</td>
			</tr>
			<tr>
				<td><span class="pgrBt pgrBtNotAns" style="display:inline-block;">&nbsp;</span> Not Answered</td>				
			</tr>
			<tr>
				<td><span class="pgrBt pgrBtNotVisit" style="display:inline-block;">&nbsp;</span> Not Visited</td>				
			</tr>
			<tr>
				<td><span class="pgrBt pgrBtAns pgrBtCurr" style="display:inline-block;">&nbsp;
					</span><!--&nbsp;<span class="pgrBt pgrBtNotAns pgrBtCurr" style="display:inline-block;">&nbsp;
					</span>&nbsp;<span class="pgrBt pgrBtNotVisit pgrBtCurr" style="display:inline-block;">&nbsp;</span>-->&nbsp;Current Question</td>				
			</tr>
		</table>
	</td>
	</tr>
		<tr>
	<td class="tmrBox" align="center"><div style="width:100%" id="myRemainingTime">mm:ss</div></td>
	</tr>

</table>


