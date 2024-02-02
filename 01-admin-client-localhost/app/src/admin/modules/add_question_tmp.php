<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="rte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="rte/richtext.js"></script>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>
<script language ="javascript" src="app/js/mustache/mustache.js"></script>



<form id="form1" method="post" onsubmit="return submitForm();">
<table class="desc_text" style="width:100%">
	<tr>
	<td colspan="2">   
		Question:<textarea  id="txtToPaste"></textarea>Quiz:<?php echo $txtFooter1; ?> | <input type="button" value="Q" id="idQSet"> | <input type="button" value="Opt" id="idOptSet"> |
		<?php echo " | " . $row_quiz['quiz_name'] . " | "  ?><a href="javascript:history.back()">Back</a>
		<input type="submit" id="btnSave01" name="btnSave" value="Save01" style="width:150px">
	</td>
	</tr>
    <tr>
        <td colspan="2">
            <?php 
			$config['toolbar'] = array(
				array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
				array( 'Image', 'Link', 'Unlink', 'Anchor' )
			);	
			//$config['height'] = "600px";
			$CKEditor->editor("txtQstsEd", $txtQsts, $config);			
			?>
        </td>
    </tr>
    
	<tr>
	<td colspan="2">
	<div style="width:100%;"><?php include('add_question_tmp_opt.php'); ?></div>
	</td>
	</tr>
	<tr>
        <td>
            Select template :
        </td>
        <td>
            <select id="drpTemplate" name="drpTemplate" style="width:100%" onchange="ChangeTemplate()">
                <?php echo $temp_options ?>
            </select>
        </td>
    </tr>	
    <tr>
        <td>
            
			Point:
        </td>
        <td>
            <input style="width:100px" type="text" id="txtPoint" value="<?php echo util::GetData("txtPoint") ?>" name="txtPoint">
        </td>
    </tr>
    <tr>
        <td valign="top">
            Header text :
        </td>
        <td>
            <textarea style="width:100%;height:70px" id="txtHeader" name="txtHeader"><?php echo util::GetData("txtHeader") ?></textarea>
        </td>
    </tr>
    <tr>
        <td valign="top">
            Footer text :
        </td>
        <td>
            <textarea style="width:100%;height:70px" id="txtFooter" name="txtFooter"><?php echo util::GetData("txtFooter") ?></textarea>
        </td>
    </tr>

</table>




<script type="text/javascript">
CKEDITOR.config.width ='740px';
</script>
    <SCRIPT language="javascript">
        ChangeTemplate();

        //var c_multi = 4;

        var counters = new Array();
        var answer_count = <?php echo $answers_count ?>;
		
        counters["tblMulti"] = answer_count;
        counters["tblOne"] = answer_count;
        counters["tblArea"] = answer_count;
        counters["tblMultiText"] = answer_count;

        function addRow(tableID, textboxID ) {
			lihtm(answer_count);
			return;
			
            counters[tableID]++;            
                        
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var colCount = table.rows[0].cells.length;
            
            for(var i=0; i<colCount; i++) {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[3].cells[i].innerHTML;
                              
               
                switch(newcell.childNodes[0].type) {
                    case "text":
                            
                            newcell.childNodes[0].value = "";
                            var txtname=newcell.childNodes[0].name;
                            var newname=txtname.substr(0,txtname.length-1)+counters[tableID];
                            newcell.childNodes[0].id=newname;
                            newcell.childNodes[0].name=newname;
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            newcell.childNodes[0].id="chkMulti"+counters[tableID];
                            newcell.childNodes[0].name="chkMulti"+counters[tableID];
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            newcell.childNodes[0].value=counters[tableID];
                            break;
                    
                }
            }
            
        }

        function deleteRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            if(rowCount==4)
                {
                    alert('Cannot delete last choise');
                    return;
                }
            table.deleteRow(rowCount-1);
            counters[tableID]--;
        }

        function ChangeTemplate()
        {
            DisableAllTemplates();
            var val = document.getElementById('drpTemplate').options[document.getElementById('drpTemplate').selectedIndex].value;
            
            if(val ==0)
            {
                document.getElementById('trMulti').style.display="";
            }
            else if(val==1)
            {
                  document.getElementById('trOne').style.display="";
            }
            else if(val==3)
            {
                  document.getElementById('trArea').style.display="";
            }
            else if(val==4)
            {
                  document.getElementById('trMultiText').style.display="";
            }
        }

        function DisableAllTemplates()
        {
            document.getElementById('trMulti').style.display="none";
            document.getElementById('trOne').style.display="none";
            document.getElementById('trArea').style.display="none";
            document.getElementById('trMultiText').style.display="none";
        }
		function lihtm(pno){
pno=$(':radio[name="rdOne"]').length;pno++;		
var vhtml = "<p>{{#line}}{{ch}}<input type='text' id='{{bx_name}}{{no}}'       name='{{bx_name}}{{no}}' value=''> <input type='radio' name='{{opt_name}}'   value='{{no}}'>{{/line}}</p>";

var vdata = {line:[{bx_name:"txtChoise",
opt_name:"rdOne",
no:pno,
ch:pno}]};		

var ht = Mustache.render(vhtml, vdata);
console.log(ht);
$("#hiadder").html(ht);
		}
    </SCRIPT>
</form>

<script language="JavaScript" type="text/javascript" src="js/ques.js"></script>
<script>

var vPasteOpt = 1;
var vanswers_count = <?php echo $answers_count; ?>;
var vcurr_question = <?php echo $queno ?>;
function txtToPasteClearFocus(){
	var vthis = $("#txtToPaste");
	vthis.val("");
	vthis.focus();
} function idOptSetFn(){
	vPasteOpt = 2;
	for(var i=1; i<=vanswers_count; i++)
		$("#txtChoise" + i).val('');
	txtToPasteClearFocus();
}
$(document).ready(function(){
	$("#txtToPaste").change(function(e) {
		var vthis = $(this);
		var vtext = vthis.val();
			
		if(vtext != ""){
			
			var el = '';
			switch(vPasteOpt){
				case 1: 
					//el="#txtQstsEd"; $(el).html(vtext); 
					CKEDITOR.instances['txtQstsEd'].setData(vtext);
					break;
				default: 
					var vNo=vPasteOpt-1; el="#txtChoise" +vNo; 						
					if(vNo > vanswers_count) break;					
					$(el).val(vtext);
			}
			//alert(el);
			vPasteOpt++;
		}
		
		txtToPasteClearFocus();
	}); 
	$("#idQSet").click(function(e) {		
		idOptSetFn();
		vPasteOpt = 1;
	});
	$("#idOptSet").click(function(e) {
		idOptSetFn();
	});
	JsonQProc();
});

</script>