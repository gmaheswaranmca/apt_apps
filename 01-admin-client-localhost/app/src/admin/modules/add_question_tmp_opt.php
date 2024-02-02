<table style="width:100%;">
	<tr style="display:none" id="trOne" >
        <td>
            <table id="tblOne" class="desc_text" >

                 <!--tr>
                    <td colspan="2"><hr></td>
                </tr-->
                <!--tr>

                    <td>Answer Variants
                   </td>
                    <td class="desc_text">Correct answer </td>
                </tr-->
				 <tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
					<td><?php echo chr($i+65-1) ?>
						<input <?php echo util::GetData("ans_selected$i") ?> type="radio" name="rdOne" id="idrdOne<?php echo $i ?>" value="<?php echo $i ?>">
					</td>
                    <td>						
                        <input type="text" id="txtChoise<?php echo $i ?>" name="txtOne<?php echo $i ?>" value="<?php echo util::GetData("txtChoise$i") ?>">
					</td>
                    
					<?php if($i%4==0) {?></tr><tr> <?php } ?>
                <?php } ?>
				</tr>
				<!--tr> <td colspan="2" id="hiadder">  </td> </tr-->
            </table>
            <!--table width="170px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblOne','txtOne')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblOne')" />
                    </td>
                </tr>
            </table-->
        </td>
    </tr>
	
    <tr style="display:none" id="trMulti">
        <td align="center">
            <table class="desc_text" id="tblMulti" >

                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>                    
                    <td>Answer Variants
                    </td>
                    <td class="desc_text">Correct answer </td>
                </tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
                <tr>
                    
                    <td>
                        <input type="text" id="txtChoise1" value="<?php echo util::GetData("txtChoise$i") ?>" name="txtMulti<?php echo $i ?>"></td>
                    <td><input <?php echo util::GetData("ans_selected$i") ?> type="checkbox" id="chkMulti<?php echo $i ?>" name="chkMulti<?php echo $i ?>" ></td>
                </tr>
                <?php } ?>
            </table>
            <table width="170px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblMulti','txtMulti')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblMulti')" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr style="display:none" id="trArea">
        <td align="center">
            <table id="tblArea" class="desc_text">

                <tr>
                    <td valign="top" align="right">
                         Enter correct answer (can be empty):
                     </td>
                    <td>
                        <textarea style="width:300px;height:100px" name="txtArea1"><?php echo util::GetData("txtCrctAnswer1") ?></textarea>
                    <td>
                </tr>
            </table>
        </td>
    </tr>
	
        <tr style="display:none" id="trMultiText">
        <td align="center">
            <table id="tblMultiText" class="desc_text">

               <tr>
                    <td colspan="2"><hr></td>
                </tr>
               <tr>
                    <td>Answer Variants 
                    </td>
                    <td class="desc_text">Correct answer </td>
                </tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
                <tr>

                    <td>
                        <input type="text" id="txtChoise<?php echo $i ?>" name="txtMultiText<?php echo $i ?>" value="<?php echo util::GetData("txtChoise$i") ?>"></td>
                    <td><input type="text" id="txtText<?php echo $i ?>" name="txtMultiCrctAnswer<?php echo $i ?>" value="<?php echo util::GetData("txtCrctAnswer$i") ?>"></td>
                </tr>
                <?php } ?>
            </table>          
             <table width="320px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblMultiText','txtMultiText')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblMultiText')" />
                    </td>
                </tr>
            </table>
              <table style="display:none">
                <tr>
                    <td><input type="checkbox" id="chkAllowNumbers" name="chkAllowNumbers" /><label id="lbl1" for="chkAllowNumbers">Allow users to enter only numbers</label></td>
                </tr><tr>
                    <td><input type="checkbox" id="chkDontCalc" name="chkDontCalc" /><label id="lbl1" for="chkDontCalc">Do not calculate results of this question</label></td>
                </tr>
            </table>
        </td>
    </tr>
</table>



    <br>
     <hr />
     <br>
     <table style="width:850px">
         <tr>
        <td>
            <input type="submit" id="btnSave" name="btnSave" value="Save" style="width:150px">
            <input type="button" id="btnCancel" name="btnCancel" value="Cancel" style="width:150px" onclick="javascript:window.location.href='?module=questions'">
        </td>
    </tr>
     </table>
	 
	  <table style="width:850px">
	                 <tr>
                    <td>Header text (can be empty):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>"  name="txtMultiGroupName" id="txtMultiGrpName"></td>
                </tr>
				
				
				                <!--tr>
                    <td>Header text (can be empty):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtOneGroupName"></td>
                </tr>
				
				
				                 <tr>
                     <td valign="top" align="right">
                         Header text (can be empty):
                     </td>
                    <td>
                        <input style="width:300px" type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtAreaGroupName"></td>

                </tr>
				
				                <tr>
                    <td>Header text (can be empty):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtMultiTextGroupName"></td>
                </tr -->
</table>