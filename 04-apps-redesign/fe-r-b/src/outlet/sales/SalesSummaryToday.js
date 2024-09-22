import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

import LoggedInHeader from "../header/LoggedInHeader"
import SecurityService from "../../services/SecurityService";
import salesService from "../../services/SalesService";
function SalesSummaryToday() {
    const initReport = {
        "footer":{"total":5000},
        "body" : [
            {"date":"01-May-2024","bill_number":"B001","amount":120},
            {"date":"02-May-2024","bill_number":"B003","amount":120}
        ], 
        "filter":{"date": new Date().toJSON().substring(0,10),
                  "box" : new Date().toJSON().substring(0,10)
                }
    };

    const [report, setReport] =  useState(initReport);
    const [username, setUsername] =  useState('');
    const navigate = useNavigate();

    const callToReadReport = async function(){
        const securityService = new SecurityService();        
        if(!securityService.isLoggedIn()){
            navigate("/login");
            return;
        }
        const user = securityService.getUser() 
        setUsername(user.username)
        const changeableReport = {...report};
        changeableReport.filter.date = changeableReport.filter.box;
        setReport(changeableReport)
        let axiosResponse;
        try{
            axiosResponse = await salesService.todaySales(user.admin_id, report.filter.date);
        }
        catch(error){
            alert('Login Expired 1');
            securityService.doLogout();
            navigate("/login");
            return;
        }
        
        const json =  axiosResponse.data; 
        const report_body = [];
        for(let e of json.data){
            report_body.push({ date: e.date, bill_number: e.bill_number, amount: e.bill_amount })
        }
        
        let queriedReport = {
            "footer": {...report.footer},
            body : report_body, 
            "filter":{...report.filter}
        }
            
        queriedReport.footer.total = 0;
        for(let body_item of queriedReport.body){
            queriedReport.footer.total += body_item.amount;
        }
        setReport(queriedReport);
    
    }
    const handleLogout = function(){
        navigate("/login");
    }
    useEffect(() => { callToReadReport(); }, []);
    const onTextChange = function(event){
        const changedReport = {...report};
        changedReport.filter[event.target.id] = event.target.value;
        setReport(changedReport);
    }
    
    const onQuery = function(event){
        callToReadReport();
    }

    return(
        <>  <LoggedInHeader  handleLogout={handleLogout} username={username}/>
        
            <div className="container">
                {
                    (report.filter.date === new Date().toJSON().substring(0,10)) &&
                    <h3>Today Sales Summary</h3>
                }
                {
                    (report.filter.date !== new Date().toJSON().substring(0,10)) &&
                    <h3>Daily Bill-Wise Summary of the date {report.filter.date}</h3>
                }
                <div class="container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="box-label">Date</span>
                        </div>
                        <input type="date" className="form-control" 
                        id="box" 
                        aria-label="box" aria-describedby="box-label"
                        value={report.filter.box} onChange={onTextChange}/>
                        <button className="btn btn-primary" onClick={onQuery}>Query</button>&nbsp;
                    </div>
                </div>                
                <table class="table table-stripped table-dark">
                <thead>
                    {report.body.length > 0 && <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Bill Number</th>
                    <th scope="col">Amount(Rs.)</th>
                    </tr>
                    }
                </thead>
                <tbody>
                    { report.body.map((body_item, index) => 
                    {
                        return (
                            <tr>
                                <th scope="row">{index + 1}</th>
                                <td>{body_item.date}</td>
                                <td>{body_item.bill_number}</td>
                                <td>{body_item.amount}</td>
                            </tr>
                        );
                    } 
                    ) }    
                </tbody>
                <tfoot>
                    {report.body.length > 0 && <tr>
                        <th scope="col" colspan="3">Total</th>
                        <th scope="col">{report.footer.total}</th>
                        </tr>
                    }
                    {report.body.length === 0 && <tr>
                        <th scope="col" colspan="4">No Search Result</th>
                        </tr>
                    }
                </tfoot>
                </table>

            </div>
        </>
    );
}

export default SalesSummaryToday;
