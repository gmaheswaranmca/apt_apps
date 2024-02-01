<?php if(!isset($RUN)) { exit(); } ?>

<HTML>
    <HEAD>
		<META http-equiv="content-type" content="text/html; charset=utf-8">
                <script language ="javascript" src="jquery.js"></script>
                <script language ="javascript" src="grid.js"></script>
                <script src="cms.js" type="text/javascript"></script>
                <title>Quizzes and Surveys</title>                

    </HEAD>
    <link href="style/index.css" type="text/css" rel="stylesheet" />
    <link href="style/grid.css" type="text/css" rel="stylesheet" />
    <BODY bgcolor="#97A3AF" >

         <script language="javascript">

         window.onscroll = function()
         {
            MoveLoadingMessage("loadingDiv");
         }

         jQuery.ajaxSetup({
            beforeSend: function() {            
            $('#loadingDiv').show()
         },
            complete: function(){
            $('#loadingDiv').hide()
         },
            success: function() {}
         });
         
        </script>
        
              <table style="display:none" id="loadingDiv" style="position: absolute; left: 10px; top: 10px">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td bgcolor="red">
                                        <font color="white" size="3"><b>&nbsp;Please wait ...&nbsp;</b></font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>

        <script language="javascript">
            MoveLoadingMessage("loadingDiv");
        </script>

         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="display:none;">
           <tr valign="middle">
                <td style="">
                    <div class="logo_block"><img src="style/i/APEC-LOGO.png" width="200"/></div>
                </td>
                <td>
                </td>
                <td valign="middle">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr valign="middle">
                            <td  valign="middle" align="center" >
                                <!--<img src="style/i/bg_3.gif" />--><div class="main_heading">Online Test</div>
                            </td>
                            <td align="right" style="width:200px;">  
								<img src="style/i/logo.png" alt="Logo" width="80%"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>	
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                
                <td  align="center" valign="top" bgcolor="#F4F5F7" width="*">
                          <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                                <tr>                                    
                                        <td valign="top" bgcolor="#F4F5F7">
                                         
                                                    
                                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="main_table_desc_text">
                                                                            <font color="black">
                                                                                <?php
                                                                                    echo desc_func();
                                                                                ?>
                                                                            </font>
                                                                        </td><td align="right">
                                        <a href="logout.php" border="1"><img border=0 src="style/i/logout.gif" /></a>
                                    </td>                                                                       
                                                                    </tr>
                                                                    <!--tr>
                                                                        <td><br><hr><br></td>
                                                                    </tr-->
                                                                </table>
                                                          
                                                    </td>
                                                                                                    
                                    </tr>
                                    <tr height="550px">
                                        <td valign="top">
                                             <?php
						include "modules/".$module_name."_tmp.php";
                                             ?>
                                        </td>
                                    </tr>
                            </table>

                </td>
				<td width="5px">&nbsp;</td>
				<td class="c_menu_td" valign="top" id="idMenuDiv" style="width:150px;max-width:50px;overflow-x:scroll;scrollbar-width:2px;">
					<input type="button" value="<<" onclick="$('#idMenuDiv').css('width','150px');"> &nbsp;
					<input type="button" value=">>" onclick="$('#idMenuDiv').css('width','50px');">
					<br>
					<table>
						
								<?php
									while($row=db::fetch($modules))
									{
										?>
										<tr>
										<td>
										<?php
										echo "<a class=\"menu_child_name\" href='index.php?module=".$row['file_name']."'><div class='c_menu_list_bg' style='width:100%'>".$row['module_name']."</div></a>";
										?>
										</td>
										</tr>
										<?php
									}
								?>
							
					</table>
					
                </td>
                
            </tr>
         </table>
         <table style="width:100%" style="display:<?php echo DEBUG_SQL=="yes" ? "" : "none" ?>">
            <tr>
                <td bgcolor="white">
                    <table style="width:100%" cellpadding="0" cellspacing="0">
                        <?php
                        for($i=0;$i<count($queries);$i++)
                        {
                            ?>
                                <tr>
                                    <td bgcolor="moccasing" class="query_head">
                                      <b>Query <?php echo $i+1 ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="query">
                                        <?php echo util::getFormattedSQL($queries[$i]) ?>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                    </td>
                                </tr>
                            <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
   </BODY>

   

</HTML>