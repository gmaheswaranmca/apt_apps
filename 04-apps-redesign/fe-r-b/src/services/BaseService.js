import axios from 'axios'
const config = {
    baseURL: 'http://localhost:8080',
    headers :{
        'Content-type' : 'application/json'
    }
};
function makeNotLoggedInApiCaller(){ 
   const apiCaller = axios.create(config);
   return apiCaller
}
function makeLoggedInApiCaller(token){
    config.headers['x-access-token'] = token; 
    const apiCaller = axios.create(config);
    return apiCaller
 }
export { makeNotLoggedInApiCaller,
    makeLoggedInApiCaller};