<?php if(!isset($RUN)) { exit(); } ?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>

<?php echo $val->DrowJsArrays(); ?>

<script language="javascript">
    function ChangeCat()
    {
        var id = querySt("id") !="-1" ? "&id="+querySt("id") : "";        
        var p_cat_id =$("#drpCats").val();        
         $.post(
			"index.php?module=add_assignment" + id, 
			{  ajax: "yes", fill_tests : "yes", cat_id : p_cat_id },
			function(data){             
				document.getElementById('tdTests').innerHTML=data;
				document.getElementById('drpTests').style.width="150px";
				//$("#drpTests").val()
				$("#drpTests")[0].selectedIndex = 1;
				//alert($("#drpTests")[0].selectedIndex);
			}
		
		);
    }
	function DoSelAll()
    {
        $("input[name='chkgrd[]']").each(function(){this.checked=true;});
		DoSelAfter();
		return false;
    }
	function DoSelNone()
	{
		$("input[name='chkgrd[]']").each(function(){this.checked=false;});
		DoSelAfter();
		return false;
	}
	function DoSelCount()
	{
		var vc = 0, isFirst = true, prevlbl="",prevno="";
		var vmsg = "";
		$("input:checked[name='chkgrd[]']").each(function(){
			var lbl = $("label[for='" + this.id + "']").text();
			var lbltext,lblno;
			lblno = lbl.replace(/\D/g, '');
			lbltext = lbl.replace(/[0-9]/g, '');
			if(isFirst){ vmsg += "|" + lbltext + lblno + "-"; }
			if( (!isFirst) && (prevlbl != lbltext) && (vc > 0) ){
				vmsg += prevno + ":" + vc; 				
				vc=0;
				vmsg += "|" + lbltext + lblno + "-"
			}
			//if(this.checked)
			{
				vc++;
				isFirst = false;
			}
			prevlbl = lbltext;	
			prevno = lblno;
		}
			
		); 
		if(vc>0){vmsg += prevno + ":" + vc;}
		$("#SelC").text(vmsg);
		return false;
	}
	function DoSelAfter(){
		DoSelCount();
	}
	function DoSelBatch(pBatch)
	{
		var from = 1;
		var to = 1;
		
		switch(pBatch){
			case 'A': from=152;to=191; break;
			case 'B': from=192;to=231; break;
			case 'C': from=232;to=267; break;
			case 'D': from=268;to=303; break;
			case 'E': from=304;to=338; break;
			case 'F': from=339;to=373; break;
			case 'G': from=374;to=408; break;
			case 'H': from=409;to=442; break;
			case 'I': from=443;to=480; break;
			case 'J': from=481;to=518; break;
			case 'Z': from=2;to=151; break;
		}
		
		//alert(from + "," + to);
		
		/* based on zero based index 
		  var expr = "input[name='chkgrd[]']:lt(" + to + ")";
		  if (from > 1) {
			expr += ":gt(" + (from-2) + ")";
		  }
		  $(expr).attr("checked", true);
		*/
		//based on value of checkbox 
		$("input[name='chkgrd[]']").each(function() {
            if((this.value >= from) && (this.value <= to)) this.checked = !this.checked;
		});
		DoSelAfter();
		return false;
	}
    function ShowUsers(type)
    {
        if(type=='local')
        {            
            document.getElementById('tdLocalUsers').style.display="";
            document.getElementById('tdImportedUsers').style.display="none";            
            document.getElementById('btnLcl').style.color="red";
            document.getElementById('btnImp').style.color="black";
        }
        else
        {
            document.getElementById('tdLocalUsers').style.display="none";
            document.getElementById('tdImportedUsers').style.display="";
            document.getElementById('btnLcl').style.color="black";
            document.getElementById('btnImp').style.color="red";
        }
    }

    function CheckForm()
    {        
        return validate();
    }

    function ShowOptions()
    {
        var type = getType();
        var display = "none";
        if(type=="1") display="";
        else
        {
            document.getElementById('txtSuccessP').value="0";
            document.getElementById('txtTestTime').value="0";
        }

        for(var i=0;i<4;i++)
        {
            document.getElementById("drpTr"+i).style.display=display;
        }        
    }

    function getType()
    {
        var type = document.getElementById('drpType').options[document.getElementById('drpType').selectedIndex].value;
        return type;
    }

</script>

<form id="form1" method="post">    
    <table width="400px">
        <tr>
            <td class="desc_text" width="170px">
                <label class="desc_text">Category :</label>
            </td>
            <td>
                 <select style="width:150px" id="drpCats" name="drpCats" onchange="ChangeCat()">
                <?php echo $cat_options ?>
                </select>
            </td>
        </tr>
         <tr>
            <td class="text_desc">
                <label class="desc_text">Test :</label>
            </td>
            <td id="tdTests">
                 <select style="width:150px" id="drpTests" name="drpTests">
                     <option value="-1">Not Selected</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="text_desc">
                <label class="desc_text">Type :</label>
            </td>
            <td>
                 <select style="width:150px" id="drpType" name="drpType" onchange="ShowOptions()">
                     <?php echo $type_options ?>
                </select>
            </td>
        </tr>
           <tr id="drpTr0">
            <td class="text_desc">
               <label class="desc_text">Show results to user :</label>
            </td>
            <td>
                 <select style="width:150px" id="drpShowRes" name="drpShowRes">
                     <?php echo $showres_options ?>
                </select>
            </td>
        </tr>
          <tr id="drpTr1">
            <td class="text_desc">
                <label class="desc_text">Results by :</label>
            </td>
            <td>
                 <select style="width:150px"  id="drpResultsBy" name="drpResultsBy">
                     <?php echo $result_options ?>
                </select>
            </td>
        </tr>
             <tr id="drpTr2">
            <td class="text_desc">
                <label class="desc_text">Success point/percent :</label>
            </td>
            <td>
                 <input style="width:50px" type="text" name="txtSuccessP" id="txtSuccessP" value="<?php echo util::GetData("txtSuccessP") ?>"  />
            </td>
        </tr>
               <tr id="drpTr3">
            <td class="text_desc">
                <label class="desc_text">Test time (in minutes) :</label>
            </td>
            <td>
                 <input style="width:50px"  type="text" name="txtTestTime" id="txtTestTime" value="<?php echo util::GetData("txtTestTime") ?>"  />
            </td>
        </tr>
    </table>

    <br>
    <hr />
    <table  style="width:100%;">
        <tr>
            <td colspan="2">
                <input id="btnLcl" type="button" onclick="ShowUsers('local')" value="Local users" style="border:0;width:150px;color:red" />&nbsp;<input id="btnImp" type="button" onclick="ShowUsers('imported')" value="Imported users" style="border:0;width:150px" /> | <a href="javascript:DoSelAll();">Select All</a> | <a href="javascript:DoSelNone();">Select None</a>				
				| <a href="javascript:DoSelBatch('A');">A</a> | <a href="javascript:DoSelBatch('B');">B</a>
				| <a href="javascript:DoSelBatch('C');">C</a> | <a href="javascript:DoSelBatch('D');">D</a>
				| <a href="javascript:DoSelBatch('E');">E</a> | <a href="javascript:DoSelBatch('F');">F</a>
				| <a href="javascript:DoSelBatch('G');">G</a> | <a href="javascript:DoSelBatch('H');">H</a>
				| <a href="javascript:DoSelBatch('I');">I</a> | <a href="javascript:DoSelBatch('J');">J</a>	
				| <a href="javascript:DoSelBatch('Z');">Staff</a> | <span id="SelC">&nbsp;</span>
            </td>            
        </tr>
        <tr>
            <td valign="top" id="tdLocalUsers">
                 <div id="div_grid" style="width:100%;"><?php echo $grid_html ?></div>
            <!--/td>
            <td valign="top" id="tdImportedUsers" style="display:none"-->
                    <div id="div_grid"><?php echo $imported_grid_html ?></div>
            </td>
        </tr>
    </table>
    <br>
    <hr>
    <table>
        <tr>
            <td><input onclick="return CheckForm()" style="width:100px" type="submit" id="btnSave" name="btnSave" value="Save" /></td>
            <td><input onclick="javascript:window.location.href='index.php?module=assignments'" style="width:100px" type="button" id="btnCancel" name="btnCancel" value="Cancel" /></td>
        </tr>
    </table>
</form>
<script language="JavaScript" type="text/javascript" src="lib/checkboxes.js"></script>
<script language="javascript">
    ChangeCat();
    ShowOptions();	
	allow_group_select_checkboxes("tdLocalUsers");
	DoSelAfter();
</script>