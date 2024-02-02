<style type="text/css">
.btLogin{
padding:10px; width: 130px; 
font-weight: bold;
border-radius: 50px; border: 1px solid rgb(21, 87, 153);
color:white;
background-color: rgb(28, 181, 224);

cursor:pointer;
}
input[type=text], textarea, input[type=password] {
  padding: 3px 0px 3px 3px;
  margin: 5px 1px 3px 0px;
  border: 1px solid rgb(21, 87, 153);
  border-radius:4px;
}

</style>

<table cellpadding="0" cellspacing="0" align="center"
	style="background-color: #f4f5f7; font-family: Arial; font-size: 10pt;
		border-radius: 20px;box-shadow:0px 0px 5px rgba(0,0,0,0.8);">
	<tr>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
        <td colspan="2">
            <table align="center" class="loginTbl">
                <tr>
                    <td colspan="2" valign="middle" style="background-color:#f4f5f7; border-radius: 10px;">
						<img src="../static/img/comp/LoginLogo.png" style="width:100%; height: auto;">
                    </td>
                </tr>
                <tr>
                    <td class="main_txt_lt" align="left">
						<label for="uxUserName">User Name</label>
                    </td>
					<td>
                        <input type="text" name="txtLogin" id="uxUserName" class="login_box" maxlength="25" placeholder="User Name"
							onkeydown ="LoginViewRender.MoveToPassword(	);">
                    </td>
                </tr>
                <tr>
                    <td class="main_txt_lt" align="left">
                        <label for="uxPassword">Password</label>
                    </td>
                    <td>
                        <input type="password" class="login_box" id="uxPassword" name="txtPass" maxlength="25"  placeholder="Password" onkeydown ="LoginViewRender.FireLogin();">
                    </td>
                </tr>											
				<tr>
					<td colspan="2" height="5">&nbsp;</td>
				</tr>											
                <tr>
					<td colspan="2" align="center">
						<input type="button" value="Login" name="btnSubmit" class="btLogin"  id="uxDoLogin"
							onclick="LoginViewRender.DoLogin();" >
					</td>
                </tr>
                <tr>
                     <td colspan="2" align="center" class="main_txt_lt">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
							
				