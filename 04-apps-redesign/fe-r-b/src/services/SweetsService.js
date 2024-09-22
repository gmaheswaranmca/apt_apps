import { makeLoggedInApiCaller } from "./BaseService";
import SecurityService from "./SecurityService";


class SweetsService{
    sweets_url = "/sweets";
    create = (newSweet) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.post(`${this.sweets_url}`, newSweet);
    }
    readAll = () => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`${this.sweets_url}`);
    }
    readOne = (id) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`${this.sweets_url}/${id}`);
    } 
    update = (id, changedSweet) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.put(`${this.sweets_url}/${id}`, changedSweet);
    }
    delete = (id) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.delete(`${this.sweets_url}/${id}`);
    }       
}

const sweetsService = new SweetsService();
export default sweetsService;