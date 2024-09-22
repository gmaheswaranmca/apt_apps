import { makeLoggedInApiCaller } from "./BaseService";
import SecurityService from "./SecurityService";


class SalesService{
    SALES_URL = "/sales";
    create = (newSale) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.post(`/sales`, newSale);
    }
    todaySales = (outlet_id,date) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`/sales/today/${outlet_id}/${date}`);
    }
    monthlySales = (month) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`/sales/monthly/${month}`);
    }
    yearlySales = (year) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`/sales/yearly/${year}`);
    }       
}

const salesService = new SalesService();
export default salesService;