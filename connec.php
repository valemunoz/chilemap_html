<?PHP

function pgSql_db()
	{
		
	  $HostDB="localhost";
    $PortDB="5432";          
    $UserDB="postgres"; 
    $PassDB="12345";
    $NameDB="gis";    
		$dbPg = pg_connect("host=$HostDB port=$PortDB dbname=$NameDB user=$UserDB password=$PassDB");		 	
		return $dbPg;
	}

?>
