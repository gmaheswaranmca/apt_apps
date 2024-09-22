import { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom';
import SecurityService from "../../services/SecurityService";
import LoggedInHeader from '../header/LoggedInHeader';
import outletsService from '../../services/OutletsService';


function OutletAdd() {
    const initOutlet = {
        "outletname":"", 
        "passcode":"", 
        "manager_name":"",
        "phone_number":"", 
        "place":"", 
        "active":1, 
        "information":""
    };
    const [outlet, setOutlet] = useState(initOutlet);
    const [username, setUsername] =  useState('');
    const navigate =useNavigate();
    const noCallToRead = async function(){   
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/admin/login");
            return;
        }
        
        setUsername(securityService.getUser().username)
    }
    useEffect(() => { noCallToRead();  }, []);
    const onTextChange = function(event){
        const changedOutlet = {...outlet};
        changedOutlet[event.target.id] = event.target.value;
        setOutlet(changedOutlet);
    }

    const doCreateOutlet = function(event){
        if(!window.confirm(`Are you sure to create the outlet '${outlet.outletname}'?`)){
            return;
        }
        const axiosResponse = outletsService.create({
            "outletname":outlet.outletname, 
            "passcode":outlet.passcode, 
            "manager_name":outlet.manager_name,
            "phone_number":outlet.phone_number, 
            "place":outlet.place, 
            "active":outlet.active, 
            "information":outlet.information
        });

        alert('Outlet is created successfully.');
        navigate("/admin/outlets/list")
        console.log(`${outlet.outletname} has been created successfully`);
    }
    const handleLogout = function(){
        navigate("/admin/login");
    }
    return(
        <>  <LoggedInHeader  
        handleLogout={handleLogout} 
        username={username}/>
            <div>
                <a href="/admin/outlets/list" className="btn btn-light">&lt;&lt;Go Back</a>
                <h3>Add Outlet</h3>
                <div class="container">
                    <div className="for-group">
                        <label htmlFor="outletname">outletname</label>
                        <input type="text" className="form-control" 
                        id="outletname" aria-describedby="outletname_outletnameHelp" placeholder="Enter outlet name"
                        value={outlet.outletname} onChange={onTextChange}/> 
                        <small id="outletname_outletnameHelp" className="form-text text-muted">Please enter outletname of the outlet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="passcode">passcode</label>
                        <input type="text" className="form-control" 
                        id="passcode" aria-describedby="passcode_passcodeHelp" placeholder="Enter passcode "
                        value={outlet.passcode} onChange={onTextChange}/> 
                        <small id="passcode_passcodeHelp" className="form-text text-muted">Please enter passcode of the outlet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="manager_name">manager_name</label>
                        <input type="text" className="form-control" 
                        id="manager_name" aria-describedby="manager_name_manager_nameHelp" placeholder="Enter manager_name"
                        value={outlet.manager_name} onChange={onTextChange}/> 
                        <small id="manager_name_manager_nameHelp" className="form-text text-muted">Please enter manager_name of the outlet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="phone_number">phone_number</label>
                        <input type="text" className="form-control" 
                        id="phone_number" aria-describedby="phone_number_phone_numberHelp" placeholder="Enter phone_number"
                        value={outlet.phone_number} onChange={onTextChange}/> 
                        <small id="phone_number_phone_numberHelp" className="form-text text-muted">Please enter phone_number of the outlet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="place">place</label>
                        <input type="text" className="form-control" 
                        id="place" aria-describedby="place_placeHelp" placeholder="Enter place"
                        value={outlet.place} onChange={onTextChange}/> 
                        <small id="place_placeHelp" className="form-text text-muted">Please enter place of the outlet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="active" class="form-check-label" >
                            <input type="checkbox"
                            className="form-check-input"
                                id="active"
                                defaultChecked={outlet.active===1}
                                onChange={() => {
                                    const changedOutlet = {...outlet};
                                    changedOutlet.active = outlet.active===1 ? 0 : 1;
                                    setOutlet(changedOutlet)
                                    }
                                }/>
                            active
                        </label>
                    </div>
                    <div className="form-group">
                        <label htmlFor="information">additional_information</label>
                        <textarea className="form-control" 
                        id="information" aria-describedby="information_informationHelp" placeholder="Enter information"
                        value={outlet.information} onChange={onTextChange}>
                        </textarea>
                        <small id="information_informationHelp" className="form-text text-muted">Please enter the details about the outlet .</small>
                    </div>
                    
                    <button type="button" class="btn btn-success"
                     onClick={doCreateOutlet}>Create Outlet</button>
                </div>
            </div>
        </>
    );
}

export default OutletAdd;