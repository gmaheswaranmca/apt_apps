import { makeNotLoggedInApiCaller } from "./BaseService";


const apiCaller = makeNotLoggedInApiCaller();

class AuthService{
    login = (loginData) => {
        return apiCaller.post(`/login`, loginData);
    }
    outlet_login = (loginData) => {
        return apiCaller.post(`/outlet/login`, loginData);
    }
}

const authService = new AuthService();
export default authService;