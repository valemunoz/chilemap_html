<?PHP
//chdir("/usr/local/www/d_admin/chilemap.cl/www/includes");
include ('connec.php');


function getDireccion($direccion,$limite)
{
	$direc=getDireccionExacta($direccion,$limite);
	$direcciones=$direc;
	/*if(count($direc)==0)
	{
		$direc=getDireccionIlike($direccion,$limite);
		foreach($direc as $dir)
		{
			$direcciones[]=$dir;
		}
	}*/
	return $direcciones;
}
/*
Entrega arreglo con direcciones exacta
*/

function getDireccionExacta($direccion,$limite)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_direccion,calle,segmento,numero_municipal,comuna,region,latitud,longitud,query_completa,origen from gis_direccion where query_completa like '%".strtolower(trim($direccion))."%'";
	if($limite > 0)
	{
		$sql .=" limit ".$limite."";
	}
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$direc=Array();
		$direc[]=$rowCalle[0];
		$direc[]=$rowCalle[1];
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];
		$direc[]=$rowCalle[8];  
		 
		$direc[]=1;
		$direc[]=$rowCalle[9]; 
		$direcciones[]=$direc;
		
		
	}	
	pg_close($dbPg);
  return $direcciones;
}
/*
Entrega arreglo con direccion similares
*/
function getDireccionIlike($direccion,$limite)
{
	$dbPg=pgSql_db();		
	$dir=explode(" ",strtolower($direccion));	
	$sql="select id_direccion,calle,segmento,numero_municipal,comuna,region,latitud,longitud,query_completa,origen from gis_direccion where 1=1";
	foreach($dir as $d)
	{
		if(trim($d)!="" and !is_numeric($d))
		{
			$sql .=" and query_completa like '%$d%'";
		}
		if(is_numeric($d))
		{
			$sql .=" and numero_municipal =".$d."";
		}
	}
		if($limite > 0)
	{
		$sql .=" limit ".$limite."";
	}
	
	$rsCalle = pg_query($dbPg, $sql);	
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$direc=Array();
		$direc[]=$rowCalle[0];
		$direc[]=$rowCalle[1];
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];      
		$direc[]=$rowCalle[8];  
		$direc[]=2;
		$direc[]=$rowCalle[9]; 
		$direcciones[]=$direc;
	}	
	pg_close($dbPg);
  return $direcciones;
}

?>