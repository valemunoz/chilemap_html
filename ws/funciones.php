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
		 
		//$direc[]=1;
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
function buscarDireccionOSM($query)
{
	
	$delay = 0;
	
	$base_url="http://nominatim.openstreetmap.org/search?";
  $geocode_pending = true;
  while ($geocode_pending) {
    //$address = "pasaje u 2113 chile";
    $address=trim($direccion);
    $request_url = $base_url . "q=".urldecode($query)."&format=xml&polygon=1&addressdetails=1";
    $xml = simplexml_load_file($request_url) or die("url not loading");    
    //print_r($xml);
    //$status = $xml->status;
    $geocode_pending=false;
    //echo count($xml->place);
    foreach($xml->place as $place)
    {
    	$place=$xml->place;
    	if(strtolower($place->country)=="chile" and is_numeric(trim($place->house_number)))
    	{
    		$lonlat=Array();
    		
    		$lonlat[]=0;
    		$lonlat[]=$place->road;
    		$lonlat[]=0;
    		$lonlat[]=$place->house_number;
    		$lonlat[]=$place->city;
    		//$lonlat[]=$place->country;
    		$lonlat[]=$place->state;
    		$lonlat[]=$place['lat'];
    		$lonlat[]=$place['lon'];
    		$lonlat[]="";
    		$lonlat[]=2;    		
    		
    		$lonlat_arr[]=$lonlat;
    	}
    	//echo "<br>".$longitud;
    	//print_r($xml_result);
    }
  }
  return $lonlat_arr;
}

function getDireccionGoogle($direccion)
{
	
	
	$delay = 0;
	//$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
	$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
  $geocode_pending = true;
  while ($geocode_pending) {
    //$address = "pasaje u 2113 chile";
    $address=trim($direccion);
   $request_url = $base_url . "&address=" . urldecode($address)."+chile&oe=utf-8&sensor=false";
    $xml = simplexml_load_file($request_url) or die("url not loading");    
    //print_r($xml);
    $status = $xml->status;
    if (strcmp($status, "OK") == 0) {
      // Successful geocode
      $geocode_pending = false;
      
      $total_r=$xml->result;
      
      $len_place=$xml;
      $i=1;
      foreach($len_place->result as $len)
      {
      	$direc = $len->formatted_address;
      	$tipo = $len->type;
      	//echo "total:".count($len->address_component);
      	for($i=0;$i<count($len->address_component);$i++)
      	{
      		$type=$len->address_component[$i]->type;
      		$type2=$len->address_component[$i]->type[0];
      		if(strtolower(trim($type))=="street_number")
      		{
      			$numero_municipal=$len->address_component[$i]->long_name;
      		}elseif(strtolower(trim($type))=="route")
      		{
      			$calle=$len->address_component[$i]->long_name;
      			$abrevia_calle=$len->address_component[$i]->short_name;
      		}elseif(strtolower(trim($type2))=="locality")
      		{
      			$ciudad=$len->address_component[$i]->long_name;
      			$abrevia_ciudad=$len->address_component[$i]->short_name;
      		}elseif(strtolower(trim($type2))=="administrative_area_level_3")
      		{
      			$comuna=$len->address_component[$i]->long_name;
      			$abrevia_comuna=$len->address_component[$i]->short_name;
      		}elseif(strtolower(trim($type2))=="administrative_area_level_1")
      		{
      			$region=$len->address_component[$i]->long_name;
      			$abrevia_region=$len->address_component[$i]->short_name;
      		}elseif(strtolower(trim($type2))=="country")
      		{
      			$pais=$len->address_component[$i]->long_name;
      			$abrevia_pais=$len->address_component[$i]->short_name;
      		}
      		
      		
      	}
      	//geometrias
      	$latitud=$len->geometry->location->lat;
      	$longitud=$len->geometry->location->lng;
      	$tipo_gis=$len->geometry->location_type;
      	
      	$dire=Array();
				//$dire[]=$tipo;
				//$dire[]=$direc;
  		
    		
    		
    		
				$dire[]=0;
				$dire[]=$calle;
				$dire[]=0;
				$dire[]=$numero_municipal;
				$dire[]=$comuna;
				$dire[]=$region;
				$dire[]=$latitud;
				$dire[]=$longitud;
				$dire[]="";
				$dire[]=3;
				
				
				//$dire[]=$ciudad;
				
				
				//$dire[]=$tipo_gis;
				
    		
    		
    		
      	$direccion_arr[]=$dire;
				$i++;
    	}      
    } 
    usleep($delay);
  }
 
	return $direccion_arr;
}
?>