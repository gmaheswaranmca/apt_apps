import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import LoggedInHeader from "../header/LoggedInHeader";
import SecurityService from "../../services/SecurityService";
import outletsService from "../../services/OutletsService";

function OutletList() {
    const [outlets, setOutlets] =  useState([]);
    const [username, setUsername] =  useState('');
    const navigate = useNavigate();
    const callToReadAllOutlets = async function(){   
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/admin/login");
            return;
        }
        
        setUsername(securityService.getUser().username)
        let axiosResponse; 
        
        try{
            axiosResponse = await outletsService.readAll();
        }
        catch(error){
            alert('Login Expired 1');
            securityService.doLogout();
            navigate("/admin/login");
            return;
        }
        
        const json =  axiosResponse.data; 
        
        setOutlets(json.data);
    }
    
    useEffect(() => { callToReadAllOutlets();      }, []);
    
    const deleteByOutlet = async function(outlet){
        if(!window.confirm(`Are you sure to delete the outlet '${outlet.outletname}'?`)){
            return;
        }
        const axiosResponse = await outletsService.delete(outlet._id);
        const json = axiosResponse.data;
        alert(json.data.message);
        console.log(`${outlet.outletname} has been deleted successfully`);
        callToReadAllOutlets();
    }
    const handleLogout = function(){
        navigate("/admin/login");
    }
    return(
        <> <LoggedInHeader  
        handleLogout={handleLogout} 
        username={username}/>
        <div className="container">
            <h3>Outlets List</h3>
            <a href="/admin/outlets/add" className="btn btn-success">Add Outlet</a>
            <table class="table table-stripped table-dark">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">outletname</th>
                    <th scope="col">manager_name</th>
                    <th scope="col">phone_number</th>
                    <th scope="col">place</th>
                    <th scope="col">active</th>
                    <th scope="col">information</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    { outlets.map(outlet => 
                    {
                        return (
                            <tr>
                                <th scope="row">{outlet._id}</th>
                                <td>{outlet.outletname}</td>
                                <td>{outlet.manager_name}</td>
                                <td>{outlet.phone_number}</td>
                                <td>{outlet.place}</td>
                                <td>{outlet.active}</td>
                                <td>{outlet.information}</td>
                                <td>
                                    <a href={"/admin/outlets/edit/" + outlet._id} className="btn btn-warning">Edit</a>&nbsp;&nbsp;
                                    <button className="btn btn-danger" onClick={ 
                                                function(event) { 
                                                    deleteByOutlet(outlet); 
                                                } 
                                            }>Delete</button>
                                
                                    
                                    
                                </td>
                            </tr>
                        );
                    } 
                    ) }    
                </tbody>
            </table>
        </div>
        </>
    );
}

export default OutletList;