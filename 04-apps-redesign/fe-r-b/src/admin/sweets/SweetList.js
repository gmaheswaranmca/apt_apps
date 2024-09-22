import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import LoggedInHeader from "../header/LoggedInHeader";
import SecurityService from "../../services/SecurityService";
import sweetsService from "../../services/SweetsService";

function SweetList() {
    const [sweets, setSweets] =  useState([]);
    const [username, setUsername] =  useState('');
    const navigate = useNavigate();
    const callToReadAllSweets = async function(){   
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/admin/login");
            return;
        }
        
        setUsername(securityService.getUser().username)
        let axiosResponse; 
        
        try{
            axiosResponse = await sweetsService.readAll();
        }
        catch(error){
            alert('Login Expired 1');
            securityService.doLogout();
            navigate("/admin/login");
            return;
        }
        
        const json =  axiosResponse.data; 
        
        setSweets(json.data);
    }
    
    useEffect(() => { callToReadAllSweets();      }, []);
    
    const deleteBySweet = async function(sweet){
        if(!window.confirm(`Are you sure to delete the sweet '${sweet.name}'?`)){
            return;
        }
        const axiosResponse = await sweetsService.delete(sweet._id);
        const json = axiosResponse.data;
        alert(json.data.message);
        console.log(`${sweet.name} has been deleted successfully`);

        callToReadAllSweets();
    }
    const handleLogout = function(){
        navigate("/admin/login");
    }
    return(
        <>  <LoggedInHeader  
        handleLogout={handleLogout} 
        username={username}/>
            <div className="container">
                <h3>Sweets List</h3>
                <a href="/admin/sweets/add" className="btn btn-success">Add Sweet</a>
                <table class="table table-stripped table-dark">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Exipiry Duration in Days</th>
                        <th scope="col">Description</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        { sweets.map((sweet,index) => 
                        {
                            return (
                                <tr>
                                    <th scope="row">{sweet._id}</th>
                                    <td>{sweet.name}</td>
                                    <td>{sweet.selling_price}</td>
                                    <td>{sweet.expiry_duration}</td>
                                    <td>{sweet.description}</td>
                                    <td>
                                        <a href={"/admin/sweets/edit/" + sweet._id} 
                                            className="btn btn-warning">Edit</a>&nbsp;&nbsp;
                                        <button className="btn btn-danger" onClick={ 
                                                    function(event) { 
                                                        deleteBySweet(sweet); 
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

export default SweetList;