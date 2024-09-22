import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import LogInHeader from "../header/LogInHeader";
import SecurityService from '../../services/SecurityService';
import authService from '../../services/AuthService';

function AdminLogin() { 
    const initLoginData = {"username":"", "password":""};
    
    const [loginData, setLoginData] = useState(initLoginData);
    const navigate = useNavigate();
    
    const nocallToNothing = function() {
        const securityService = new SecurityService();        
        if(securityService.isLoggedIn()){
            navigate("/admin/outlets/list");
            return;
        }
    }
    // eslint-disable-next-line
    useEffect(() => {nocallToNothing();}, []);
    const onTextChange = function(event) {
        const changedLoginData = {...loginData};
        changedLoginData[event.target.id] = event.target.value;
        setLoginData(changedLoginData);
    }

    const doLogin = async function(event) {
        const axiosResponse = await authService.login({
            username: loginData.username,
            password: loginData.password
        });
        console.log(axiosResponse)
        const json = axiosResponse.data;
        if(!json.isValidLogin){
            alert('Invaid Username/Password');
            return;
        }
        console.log(`${loginData.username} has been logged in successfully`);
             

        const securityService = new SecurityService();        
        securityService.setUser(json.user);//securityData
        navigate("/admin/outlets/list");
    }
    return(
        <>
            <LogInHeader/>
            
            <div>
                <h3>Login</h3>
                <div class="container">
                    <div className="form-group">
                        <label htmlFor="username">Username</label>
                        <input type="text" className="form-control" 
                        id="username" aria-describedby="usernameHelp" placeholder="Enter admin username"
                        value={loginData.username} onChange={onTextChange}/> 
                        <small id="usernameHelp" className="form-text text-muted">Please enter username.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input type="password" className="form-control" 
                        id="password" aria-describedby="passwordHelp" placeholder="Enter the password"
                        value={loginData.password} onChange={onTextChange}/>
                        <small id="passwordHelp" className="form-text text-muted">Please enter the password.</small>
                    </div>
                   
                    <button type="button" class="btn btn-success"
                     onClick={doLogin}>Login</button>
                </div>
            </div>
        </>
    );
}

export default AdminLogin;