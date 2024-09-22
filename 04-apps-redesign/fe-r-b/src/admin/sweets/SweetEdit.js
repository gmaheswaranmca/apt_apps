import { useEffect, useState } from 'react'
import { useParams, useNavigate } from 'react-router-dom';
import SecurityService from "../../services/SecurityService";
import LoggedInHeader from '../header/LoggedInHeader';
import sweetsService from '../../services/SweetsService';

function SweetEdit() {
    const initSweet = {
        "name":"", 
        "selling_price":0, 
        "expiry_duration":0, 
        "description":""
    };

    const [sweet, setSweet] = useState(initSweet);
    const [username, setUsername] =  useState('');
    const params = useParams();
    const navigate =useNavigate();
    
    const callToReadSweetById = async function(){ 
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/admin/login");
            return;
        }
        
        setUsername(securityService.getUser().username);

        const axiosResponse = await sweetsService.readOne(params.id);
        const json = axiosResponse.data;
        setSweet(json.data);
    }
    
    useEffect(() => { callToReadSweetById(); }, []);

    const onTextChange = function(event){
        const changedSweet = {...sweet};
        changedSweet[event.target.id] = event.target.value;
        setSweet(changedSweet);
    }     
    const doUpdateSweet = function(event){
        if (!window.confirm(`Are you sure to create the sweet '${sweet.name}'?`)) {
            return;
        }
        const axiosResponse = sweetsService.update(params.id,{
            "name":sweet.name, 
            "selling_price":sweet.selling_price, 
            "expiry_duration":sweet.expiry_duration, 
            "description":sweet.description
        });

        alert('Sweet is updated successfully.');
        navigate("/admin/sweets/list")
        console.log(`${sweet.name} has been updated successfully`);
    }
    const handleLogout = function(){
        navigate("/admin/login");
    }
    return(
        <>  <LoggedInHeader  
        handleLogout={handleLogout} 
        username={username}/>
            <div>
                <a href="/admin/sweets/list" className="btn btn-light">&lt;&lt;Go Back</a>
                <h3>Edit Sweet</h3>
                <div class="container">
                <div className="form-group">
                        <label htmlFor="name">name</label>
                        <input type="text" className="form-control" 
                        id="name" aria-describedby="nameHelp" placeholder="Enter sweet name"
                        value={sweet.name} onChange={onTextChange}/> 
                        <small id="nameHelp" className="form-text text-muted">Please enter name of the sweet.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="selling_price">Price</label>
                        <input type="text" className="form-control" 
                        id="selling_price" aria-describedby="selling_priceHelp" placeholder="Enter sales price"
                        value={sweet.selling_price} onChange={onTextChange}/>
                        <small id="selling_priceHelp" className="form-text text-muted">Please enter the sales price.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="expiry_duration">expiry duration</label>
                        <input type="text" className="form-control" 
                        id="expiry_duration" aria-describedby="expiry_durationHelp" 
                        placeholder="Enter expiry_duration"
                        value={sweet.expiry_duration} onChange={onTextChange}/>
                        <small id="expiry_durationHelp" 
                            className="form-text text-muted">Please enter the expiry_duration in days.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="description">Description</label>
                        <textarea className="form-control" 
                        id="description" aria-describedby="descriptionHelp" placeholder="Enter plan description"
                        value={sweet.description} onChange={onTextChange}>
                        </textarea>
                        <small id="descriptionHelp" className="form-text text-muted">Please enter the details about the plan .</small>
                    </div>
                    
                    <button type="button" class="btn btn-warning"
                     onClick={doUpdateSweet}>Update Sweet</button>
                </div>
            </div>
        </>
    );
}

export default SweetEdit;