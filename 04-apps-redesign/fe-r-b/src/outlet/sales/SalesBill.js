import { useEffect, useState } from "react";
import { useNavigate } from 'react-router-dom';

import SecurityService from "../../services/SecurityService";
import LoggedInHeader from "../header/LoggedInHeader";
import sweetsService from "../../services/SweetsService";
import salesService from "../../services/SalesService";

function SalesBill() {
    const initOrder = {"bill":{"bill_amount":0},
        "line_items":[
            {"item_id":"I001","quantity":2,"price":20,"amount":40, "item_name":"coffee(small)"},
            {"item_id":"I002","quantity":2,"price":40,"amount":80, "item_name":"coffee(large)"}]
    };
    const initNewLineItem = {"item_id":"","quantity":2,
        "price":20,"amount":40, item_name:""};
    

    const [order, setOrder] =  useState(initOrder);    
    const [newLineItem, setNewLineItem] =  useState(initNewLineItem);
    const [sweets, setSweets] =  useState([]);
    const [username, setUsername] =  useState('');
    const navigate = useNavigate();

    const callToReadAllItems = async function(){    
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/login");
            return;
        }
        const user = securityService.getUser();
        setUsername(`${user.name}(${user.username})`)

        let axiosResponse = await sweetsService.readAll();
        const json = axiosResponse.data;
        setSweets([{_id:"",name:"",selling_price:0},...json.data]);

        setOrder({...initOrder,line_items:[]})
    };
    // eslint-disable-next-line
    useEffect(() => { callToReadAllItems(); }, []);
    const onTextChange = function(event){
        const changedNewLineItem = {...newLineItem};
        changedNewLineItem[event.target.id] = event.target.value;
        if(event.target.id === "quantity"){
            changedNewLineItem.amount = changedNewLineItem.price * changedNewLineItem.quantity;
        }
        setNewLineItem(changedNewLineItem);
    }
    const onItemChange = function(event){
        const changedNewLineItem = {...newLineItem};        
        changedNewLineItem.item_id = event.target.value;
        for(let prod_item of sweets){
            if(prod_item._id === changedNewLineItem.item_id){
                changedNewLineItem.item_name = `${prod_item.name}` ;
                changedNewLineItem.price = prod_item.selling_price;
                changedNewLineItem.amount = changedNewLineItem.price * changedNewLineItem.quantity;
            }
        }
        
        setNewLineItem(changedNewLineItem);
    }
    const findIndex = function(item_id){
        let index = 0;
        for(let each_line_item of order.line_items){
            if(item_id === each_line_item.item_id){
                return index;
            }
            index++;
        }
        return -1;
    }
    const doAddItem = function(event){
        if(newLineItem.item_id === ""){
            return;
        }
        if(findIndex(newLineItem.item_id) !== -1){
            alert(`${newLineItem.item_name} already added`);
            return;
        }
        let changedOrder = {...order,line_items:[...order.line_items,{...newLineItem}]};
        changedOrder.bill.bill_amount = 0;
        for(let each_line_item of changedOrder.line_items){
            changedOrder.bill.bill_amount += each_line_item.amount;
        }
        setOrder(changedOrder);
    }
    const deleteByIndex = function(index_to_delete){
        let index = 0;
        
        let changedOrder = {...order, line_items:[]};
        changedOrder.bill.bill_amount = 0;
        for(let each_line_item of order.line_items){
            if(index !== index_to_delete){
                changedOrder.line_items.push({...each_line_item});
                changedOrder.bill.bill_amount += each_line_item.amount;
            }
            index ++;
        }
        setOrder(changedOrder);
    }
    const doPayment = function(event){
        const securityService = new SecurityService();  
        const user = securityService.getUser();
        const newOrder = {
                bill:{...order.bill,
                        outlet_id:user.admin_id
                    },
                items:[...order.line_items]
        };
        //alert(JSON.stringify(newOrder))
        if(!window.confirm(`Are you sure to make payment?`)){
            return;
        }
        
        const axiosResponse = salesService.create(newOrder);

        alert('Payment done successfully.');
        
        console.log(`Payment done successfully.`);

        callToReadAllItems();
    }
    const handleLogout = function(){
        navigate("/login");
    }
    return(
        <>
            <LoggedInHeader  
                handleLogout={handleLogout} 
                username={username}/>

            <div><h3>Generate Bill</h3>
            <table class="table table-stripped table-dark">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item(Item Size)</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount(Rs.)</th>
                        <th></th>
                        </tr>
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            <select type="text" className="form-control" 
                            id="item_id" 
                            value={newLineItem.item_id} onChange={onItemChange}>
                                {
                                    sweets.map((prod_item) => {
                                        return(
                                            <option value={prod_item._id}>{prod_item.name}</option>
                                        );
                                    })
                                }
                                
                            </select> 
                        </th>
                        <th scope="col">
                            <input type="text" readonly className="form-control  text-danger" 
                            id="price" 
                            value={newLineItem.price}/> 
                        </th>
                        <th scope="col">
                            <input type="number" min="0" max="100" className="form-control" 
                            id="quantity" 
                            value={newLineItem.quantity} onChange={onTextChange}/> 
                        </th>
                        <th scope="col">
                            <input type="text" readonly className="form-control  text-danger" 
                            id="amount" 
                            value={newLineItem.amount}/> 
                        </th>
                        <th>
                        <button className="btn btn-primary"
                            onClick={doAddItem}>add item</button>

                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        { order.line_items.map((each_line_item,index) => 
                        {
                            return (
                                <tr key={index}>
                                    <th scope="row">{index + 1}</th>
                                    <td>{each_line_item.item_name}</td>
                                    <td>{each_line_item.price}</td>
                                    <td>{each_line_item.quantity}</td>
                                    <td>{each_line_item.amount}</td>
                                    <td>
                                        <button className="btn btn-danger" onClick={ 
                                                    function(event) { 
                                                        deleteByIndex(index); 
                                                    } 
                                                }>Delete</button>
                                    </td>
                                </tr>
                            );
                        } 
                        ) }    
                    </tbody>
                    <tbody>
                        
                                <tr>
                                    <th scope="row" colSpan="4">Total</th>
                                    <th>{order.bill.bill_amount}</th>   
                                    <td></td>                                 
                                </tr>
                               
                    </tbody>
                </table>
                <button className="btn btn-success"
                            onClick={doPayment}>Make Payment</button>
            </div>
        </>
    );
}

export default SalesBill;