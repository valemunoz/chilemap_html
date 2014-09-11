<?PHP

function pgSql_db()
	{
		/*
	  $HostDB="pgsql92.hub.org";
    $PortDB="5432";          
    $UserDB="3455_admin_db"; 
    $PassDB="npr26c";
    $NameDB="3455_gis";
    */
   
    $HostDB="localhost";
    $PortDB="5432";          
    $UserDB="postgres"; 
    $PassDB="12345";
    $NameDB="gis";
   
    //echo "host=$HostDB port=$PortDB dbname=$NameDB user=$UserDB password=$PassDB";
		$dbPg = pg_connect("host=$HostDB port=$PortDB dbname=$NameDB user=$UserDB password=$PassDB");		 	
		return $dbPg;
	}

?>
