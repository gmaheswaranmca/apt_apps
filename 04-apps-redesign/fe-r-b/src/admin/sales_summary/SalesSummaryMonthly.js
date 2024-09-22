import { useEffect, useState } from "react";
import { useNavigate } from 'react-router-dom';

import SecurityService from "../../services/SecurityService";
import LoggedInHeader from "../header/LoggedInHeader";
import salesService from "../../services/SalesService";
import outletsService from "../../services/OutletsService";
function SalesSummaryMonthly() {
    const initReport = {
        "footer":{"total":[]},
        "body" : [
            {"date":"01-May-2024","amount":[]},
            {"date":"02-May-2024","amount":[]}
        ], 
        "filter":{"month": new Date().toJSON().substring(0,7),
        "box" : new Date().toJSON().substring(0,7)
        }
};
const [report, setReport] =  useState(initReport);
const [username, setUsername] =  useState('');
const [outlets, setOutlets] =  useState([]);
const navigate = useNavigate();
const callToReadReport = async function(){
    const securityService = new SecurityService();        
    if(!securityService.isLoggedIn()){
        navigate("/admin/login");
        return;
    }
    const axiosOutletResponse = await outletsService.readAll();
    const queriedOutlets = axiosOutletResponse.data.data;
    setOutlets(queriedOutlets);
    setUsername(securityService.getUser().username);
    const changeableReport = {...report};
    changeableReport.filter.month = changeableReport.filter.box;
    setReport(changeableReport)
    let axiosResponse;
    try{
        axiosResponse = await salesService.monthlySales(report.filter.month);
    }
    catch(error){
        alert('Login Expired 1');
        securityService.doLogout();
        navigate("/admin/login");
        return;
    }
    
    const json =  axiosResponse.data; 
    const report_body = [];
    const findDateLine = (report_body, date) => {
        for(let e of report_body){  
            if(e.date === date){
                return e;
            }
        }
        return { date: date, amount: []};
    }
    for(let e of json.data){
        let report_body_line = findDateLine(report_body,e.date);
        //alert(JSON.stringify(report_body_line))
        if(report_body_line.amount.length === 0){
            for(let eOutlet of queriedOutlets){
                report_body_line.amount.push({
                    outlet:eOutlet.outletname,
                    value: eOutlet._id === e.outlet_id ? e.total_amount : 0,
                    outlet_id: eOutlet._id
                })
            }
            report_body.push(report_body_line)
        }
        else{
            for(let amount_line of report_body_line.amount){
                if(amount_line.outlet_id === e.outlet_id){
                    amount_line.value = e.total_amount
                }
            }
        }
    }

    let queriedReport = {
        "footer": {...report.footer},
        body : report_body, 
         "filter":{...report.filter}
    } 
    queriedReport.footer.total = [];     
    for(let eOutlet of queriedOutlets){
        queriedReport.footer.total.push(0)
    }
    
    for(let body_item of queriedReport.body){
        let i = 0;
        for(let amount_line of body_item.amount){
            queriedReport.footer.total[i] += amount_line.value;
            i++;
        }
    }
    setReport(queriedReport);
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
const handleLogout = function(){
    navigate("/admin/login");
}
    return(
        <>  <LoggedInHeader  handleLogout={handleLogout} username={username}/>
            <div className="container">
                <h3>Monthly Date-Wise Summary of the month {report.filter.month}</h3>
                <div class="container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="box-label">Month</span>
                        </div>
                        <input type="text" className="form-control" 
                        id="box" 
                        aria-label="box" aria-describedby="box-label"
                        value={report.filter.box} onChange={onTextChange}/>
                        <button className="btn btn-primary" onClick={onQuery}>Query</button>&nbsp;
                        <a className="btn btn-success" href="/admin/sales/summary/yearly">Yearly month-wise summary</a>&nbsp;
                        
                    </div>
                </div>
                <table class="table table-stripped table-dark">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    {
                        outlets.map((outlet,index)=>{
                            return(
                                <th>{outlet.outletname} (Rs.)</th>
                            )
                        })
                    }
                    </tr>
                </thead>
                <tbody>
                    { report.body.map((body_item, index) => 
                    {
                        return (
                            <tr>
                                <th scope="row">{index + 1}</th>
                                <td>{body_item.date}</td>
                                {
                                    body_item.amount.map((amount_line,index)=>{
                                        return(
                                            <td>{amount_line.value}</td>
                                        )
                                    })
                                }
                            </tr>
                        );
                    } 
                    ) }    
                </tbody>
                <tfoot>
                    {report.body.length > 0 && <tr>
                        <th scope="col" colspan="2">Total</th>
                        {
                        report.footer.total.map((total_line,index)=>{
                                        return(
                                            <th scope="col">{total_line}</th>
                                        )
                                    })
                        }
                        </tr>
                    }
                    {report.body.length === 0 && <tr>
                        <th scope="col" colspan="3">No Search Result</th>
                        </tr>
                    }
                </tfoot>
                </table>

            </div>
        </>
    );
}

export default SalesSummaryMonthly;