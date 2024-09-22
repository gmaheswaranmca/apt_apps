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
                <a className="navbar-brand" href="/admin/outlets/list">The Taste Admin</a>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav">
                        <li className="nav-item"><a className="nav-link" href="/admin/outlets/list">outlets</a></li>
                        <li className="nav-item"><a className="nav-link" href="/admin/sweets/list">sweets</a></li>
                        <li className="nav-item"><a className="nav-link" href="/admin/sales/summary/monthly">monthly date-wise sales</a></li>
                        <li className="nav-item"><a className="nav-link" href="/admin/sales/summary/yearly">yearly month-wise sales</a></li>
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