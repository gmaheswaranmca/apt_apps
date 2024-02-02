<?php 
    function getHostDetail(){
        echo("<div style='border:1px solid silver;'>");
        echo("<h3>");
        echo('Host Details');

        echo("</h3><p>");
        $domain = $_SERVER['SERVER_NAME'];
        echo($domain);

        echo("</p><p>");

        $domain = $_SERVER['HTTP_HOST'];
        echo($domain);

        echo("</p><p>");
        
        if (strpos($domain, 'localhost') !== false) {
            echo "Yes this is indeed the localhost domain";
        }
        else if (strpos($domain, 'apttraining') !== false) {
            echo "Yes this is indeed the apttraining domain";
        }
        else if (strpos($domain, 'aptonlinetest') !== false) {
            echo "Yes this is indeed the aptonlinetest domain";
        }

        echo("</p><p>");

        $domain = $_SERVER['REQUEST_URI'];
        echo($domain);

        echo("</p><p>");

        

        $reqHdrs = apache_request_headers();
        print_r($reqHdrs);
        echo("</p><pre>");
        foreach($reqHdrs as $key => $val) {
            echo $key . ":" . $val;
            echo "\n";
        }

        echo("</pre>");
        echo("</div>");
    }

    getHostDetail();