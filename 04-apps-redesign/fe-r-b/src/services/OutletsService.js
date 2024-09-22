import { makeLoggedInApiCaller } from "./BaseService";
import SecurityService from "./SecurityService";


class OutletsService{
    outlets_url = "/outlets";
    create = (newOutlet) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.post(`${this.outlets_url}`, newOutlet);
    }
    readAll = () => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`${this.outlets_url}`);
    }
    readOne = (id) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.get(`${this.outlets_url}/${id}`);
    } 
    update = (id, changedOutlet) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.put(`${this.outlets_url}/${id}`, changedOutlet);
    }
    delete = (id) => {
        const securityService = new SecurityService();
        const apiCaller = makeLoggedInApiCaller(securityService.getUser().token);
        return apiCaller.delete(`${this.outlets_url}/${id}`);
    }       
}

const outletsService = new OutletsService();
export default outletsService;