import './Login.css'
import loginImage from './../../LoginLogo.png'
export default function Login() {
    return (
        <>
<div id="PageAfter" class="clsPageAfter">
        <div className="mainPage">
			<div>
				<div id="pageContent">
<table cellpadding="0" cellspacing="0" align="center" id="LoginPageTable">
	<tbody><tr>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
        <td colspan="2">
            <table align="center" className="loginTbl">
                <tbody><tr>
                    <td colspan="2" valign="middle" id="LoginPageImageCell">
						<img src={loginImage} alt="APT Training Resources Logo"/>
                    </td>
                </tr>
                <tr>
                    <td className="main_txt_lt" align="left">
						<label for="uxUserName">User Name</label>
                    </td>
					<td>
                        <input type="text" name="txtLogin" id="uxUserName" 
                            className="login_box" maxlength="25" placeholder="User Name" 
                            onkeydown="JsController.MoveToPassword(	);"/>
                    </td>
                </tr>
                <tr>
                    <td className="main_txt_lt" align="left">
                        <label for="uxPassword">Password</label>
                    </td>
                    <td>
                        <input type="password" className="login_box" id="uxPassword" name="txtPass" maxlength="25" 
                        placeholder="Password" onkeydown="JsController.FireLogin();"/>
                    </td>
                </tr>											
				<tr>
					<td colspan="2" height="5">&nbsp;</td>
				</tr>											
                <tr>
					<td colspan="2" align="center">
						<input type="button" value="Login" name="btnSubmit" className="btLogin" 
                        id="uxDoLogin" onclick="JsController.DoLoginIn();"/> 
					</td>
                </tr>
                <tr>
                     <td colspan="2" align="center" className="main_txt_lt">&nbsp;</td>
                </tr>
            </tbody></table>
        </td>
    </tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</tbody></table>
							
				</div>
			</div>
		</div></div>
        </>
    )
}