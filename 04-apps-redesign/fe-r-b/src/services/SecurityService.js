export default class SecurityService{    
    getUser = () => {
        const user = localStorage.getItem('user')
        return JSON.parse(user)
    }
    setUser = (user) => {
        localStorage.setItem('user', JSON.stringify(user))
    }
    doLogout = () => {
        localStorage.removeItem('user')
    }
    isLoggedIn = () => {
        if(!this.getUser())
        {
            return false            
        }else{
            return true 
        } 
    }
}