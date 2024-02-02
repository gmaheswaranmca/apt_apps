<?php if(!isset($RUN)) { exit(); } ?>
<br />
<br />
<br />
<br />


<html>
    <head>
    <link href="style/index.css" type="text/css" rel="stylesheet" />
	<title>Apt Training - Login</title>
    </head>
    <body bgcolor="#9B9EA5">
    <form method="post" action="login.php">

    <table align="center" border="0" style="width: 100%; height: 500px">
        <tr>
            <td>
                <table align=center  style="width:827px;height:433px;">
                    <tr>
                        <td>
                            <table cellpadding=0 cellspacing=0 align="center" class="login_bg"  style="box-shadow:0px 0px 5px rgba(0,0,0,0.8);">
                                <tr>
                                     <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
								
                                <tr>
                                    <td>

                                    </td>
                                    <td colspan=2 >
                                        <table align="center" >
                                            <tr>
                                                <td colspan="2" valign="middle">
                                                    <img src="style/i/login_logo.png" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=left>
                                                    <label>LOGIN</label>
                                                </td>
                                                <td>
                                                   <input type="text" name="txtLogin" class="login_box"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=left>
                                                    <label>PASSWORD</label>
                                                </td>
                                                <td>
                                                    <input type="password" class="login_box" name="txtPass"  />
                                                </td>
                                            </tr>
											
											<tr>
											<td height="5"></td>
											</tr>
											
                                            <tr>
											<td colspan=2 align=center><input type="submit" value="LOGIN" name="btnSubmit" style="width:100px" class="myButton"/></td>
                                            </tr>
                                             <tr>
                                    <td colspan=3 align=center class="main_txt_lt"><br>
                                         <?php echo $msg ?>
                                    </td>
                                </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

        </form>
    </body>
</html>