import SecurityService from "../../services/SecurityService";

function LoggedInHeader({username,handleLogout}){
    const doLogout = function(event){
        const securityService = new SecurityService();        
        securityService.doLogout();
        if(handleLogout){
            handleLogout();
        }
    }
    return(<>                    
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
            <div className="container-fluid">
                <a className="navbar-brand" href="/sales/add">The Taste Outlet</a>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav">
                        <li className="nav-item"><a className="nav-link" href="/sales/add">add sale</a></li>
                        <li className="nav-item"><a className="nav-link" href="/sales/today">sales</a></li>
                        
                    </ul>
                </div>
                <div className="d-flex">   
                    {username} <button className="btn btn-danger"
                    onClick={doLogout}>Logout</button>
                </div>
            </div>
        </nav>
    </>);
    
}

export default LoggedInHeader;