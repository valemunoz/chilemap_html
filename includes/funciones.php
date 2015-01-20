<?PHP
//chdir("/usr/local/www/d_admin/chilemap.cl/www/includes");
include ('connec.php');

/*sessiones*/
function inicioSesion($mail,$nombre,$id_usuario)
{
	session_start();
	//session_register('usuario');
	$_SESSION["usuario"] = $mail;
	$_SESSION["id_usuario"] = $id_usuario;
	$_SESSION['fecha']=date("Y-m-d H:i:s");
	$_SESSION['nombre']=$nombre;
	
}
function cerrar_sesion()
{
	session_start();
	unset($_SESSION["usuario"]); 
	unset($_SESSION["fecha"]); 
	unset($_SESSION["nombre"]); 
	session_destroy();
}
function estado_sesion()
{
	session_start();
	$estado=1;
	$hoy=date("Y-m-d H:i:s");
	$tiempo= segundos($_SESSION['fecha'],$hoy);
	
	if(isset($_SESSION['usuario']) and trim($_SESSION['usuario'])!="" and $tiempo < 7200)	
  {
  	$estado=0;
  }
  
  return $estado;
}

function segundos($hora_inicio,$hora_fin){
$hora_i=substr($hora_inicio,11,2);
$minutos_i=substr($hora_inicio,14,2);
$año_i=substr($hora_inicio,0,4);
$mes_i=substr($hora_inicio,5,2);
$dia_i=substr($hora_inicio,8,2);
$hora_f=substr($hora_fin,11,2);
$minutos_f=substr($hora_fin,14,2);
$año_f=substr($hora_fin,0,4);
$mes_f=substr($hora_fin,5,2);
$dia_f=substr($hora_fin,8,2);
$diferencia_seg=mktime($hora_f,$minutos_f,0,$mes_f,$dia_f,$año_f) - mktime($hora_i,$minutos_i,0,$mes_i,$dia_i,$año_i);
return $diferencia_seg;
}

/*fin sesiones*/

function getUsuario($mail,$estado)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_usuario,id_tipo_usuario,nombre,mail,pais,clave,fecha_registro,estado,key from cm_usuario where mail ilike '".trim($mail)."'";
	if($estado!=10)
	{
		$sql.=" and estado=".$estado."";
	}
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle))
	{		
		$usuario[]=$rowCalle[0];
		$usuario[]=$rowCalle[1];
		$usuario[]=$rowCalle[2];
		$usuario[]=$rowCalle[3];
		$usuario[]=$rowCalle[4];
		$usuario[]=$rowCalle[5];		
		$usuario[]=$rowCalle[6];
		$usuario[]=$rowCalle[7];
		$usuario[]=$rowCalle[8];
	}	
  return $usuario;
}
function generar_clave($longitud){ 
       $cadena="[^A-Z0-9]"; 
       return substr(eregi_replace($cadena, "", md5(rand())) . 
       eregi_replace($cadena, "", md5(rand())) . 
       eregi_replace($cadena, "", md5(rand())), 
       0, $longitud); 
} 
function addUsuario($tipo,$nombre,$mail,$pais,$clave,$estado,$key,$news)
{
	$dbPg=pgSql_db();		
	
	$sql="insert into cm_usuario(id_tipo_usuario,nombre,mail,pais,clave,fecha_registro,estado,key,newsletter) values(".$tipo.",'".$nombre."','".$mail."','".$pais."','".$clave."','".date("Y-m-d H:i:s")."',".$estado.",'".$key."','".$news."');";
	
	$rsCalle = pg_query($dbPg, $sql);	

}
function updateEstadoUsuario($usuario,$estado)
{
	$dbPg=pgSql_db();		
	$sql="update cm_usuario set estado=".$estado." where mail ilike '".$usuario."';";
	$rsCalle = pg_query($dbPg, $sql);	
}

function updateUsuario($usuario,$data)
{
	$dbPg=pgSql_db();		
	$sql="update cm_usuario set nombre= '".$data[0]."'";
	if(trim($data[1])!="")
	{
		$sql .=", clave=".$data[1]."";
	}
	$sql .=" where mail ilike '".$usuario."' and estado=0";

	$rsCalle = pg_query($dbPg, $sql);	
}
/*  CORREOS */

function sendMail($para,$msg,$titulo)
{
	
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Cabeceras adicionales
	$cabeceras .= 'From: contacto@chilemap.cl' . "\r\n";
	$cabeceras .= 'Reply-To: contacto@chilemap.cl' . "\r\n";
	
	
	if(mail($para, $titulo, $msg, $cabeceras))
	{
		$envio=true;
	}else
	{
		$envio=false;
	}
	return $envio;
}

/*  FIN CORREOS*/

function addFavoritos($data)
{
	if($data[0]==2)
	{
		$servicio=getServicioXId($data[1]);
	}else
	{
		$servicio=getDireccionXId($data[1]);
	}
	$dbPg=pgSql_db();		
	$sql="INSERT INTO cm_favoritos(
            id_usuario, id_tipo_favorito, id_pto_favorito, titulo, 
            latitud, longitud, descripcion, estado, fecha_registro)
    VALUES (".$_SESSION['id_usuario'].", ".$data[0].", ".$data[1].", '".$servicio[1]."', 
            ".$servicio[3].", ".$servicio[4].", '', 0, '".date("Y-m-d H:i:s")."');";
  $rsCalle = pg_query($dbPg, $sql);	
	pg_close($dbPg);
}

function getFavorito($id,$tipo,$id_usuario)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_favorito,id_usuario,id_tipo_favorito,id_pto_favorito,titulo,latitud,longitud,descripcion,estado,fecha_registro from cm_favoritos where id_pto_favorito=".$id." and id_tipo_favorito=".$tipo." and id_usuario=".$id_usuario." and estado=0";
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle))
	{		
		$data=array();
		$data[]=$rowCalle[0];
		$data[]=$rowCalle[1];
		$data[]=$rowCalle[2];
		$data[]=$rowCalle[3];
		$data[]=$rowCalle[4];
		$data[]=$rowCalle[5];		
		$data[]=$rowCalle[6];
		$data[]=$rowCalle[7];
		$data[]=$rowCalle[8];
		$data[]=$rowCalle[9];
		$datas[]=$data;
	}	
  return $datas;
}

function getFavoritoXUsuario($id_usuario)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_favorito,id_usuario,id_tipo_favorito,id_pto_favorito,titulo,latitud,longitud,descripcion,estado,fecha_registro from cm_favoritos where id_usuario=".$id_usuario." and estado=0";
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle))
	{		
		$data=array();
		$data[]=$rowCalle[0];
		$data[]=$rowCalle[1];
		$data[]=$rowCalle[2];
		$data[]=$rowCalle[3];
		$data[]=$rowCalle[4];
		$data[]=$rowCalle[5];		
		$data[]=$rowCalle[6];
		$data[]=$rowCalle[7];
		$data[]=$rowCalle[8];
		$data[]=$rowCalle[9];
		$datas[]=$data;
	}	
  return $datas;
}
/*MAPA funciones*/
function getDireccionRound($lon_centro,$lat_centro,$limite)
{
	$dbPg=pgSql_db();		
	$sql="select ST_Distance(geom,ST_GeomFromText('POINT(".$lon_centro." ".$lat_centro.")',2276))*1609.34 from gis_direccion limit ".$limite.";";
	$rsCalle = pg_query($dbPg, $sql_calle);	
	pg_close($dbPg);
}
/*
Entrega arreglo con direccion exacta y similares
*/

function getDireccion($direccion,$limite)
{
	$direc=getDireccionExacta($direccion,$limite);
	$direcciones=$direc;
	if(count($direc)==0)
	{
		$direc=getDireccionIlike($direccion,$limite);
		foreach($direc as $dir)
		{
			$direcciones[]=$dir;
		}
	}
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
/*
Entrega lat y longitud de una direccion X a traves de APIgoogle
*/
function getDireccionGoogle($direccion)
{
	
	
	$delay = 0;
	//$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
	$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
  $geocode_pending = true;
  while ($geocode_pending) {
    //$address = "pasaje u 2113 chile";
    $address=trim($direccion);
    $request_url = $base_url . "&address=" . urlencode($address)."+chile&oe=utf-8&sensor=false";
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
				$dire[]=$tipo;
				$dire[]=$direc;
				$dire[]=$numero_municipal;
				$dire[]=$calle;
				$dire[]=$comuna;
				$dire[]=$ciudad;
				$dire[]=$region;
				$dire[]=$latitud;
				$dire[]=$longitud;
				$dire[]=$tipo_gis;
      	$direccion_arr[]=$dire;
				$i++;
    	}      
    } 
    usleep($delay);
  }
 
	return $direccion_arr;
}

/*
Entrega direccionde desde lat y longitud
*/
function getDireccionGoogleLATLON($lat,$lon)
{
	$delay = 0;
	
	$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
  $geocode_pending = true;
  while ($geocode_pending) {
    
    $address=trim($direccion);
    //$request_url = $base_url . "&address=" . urlencode($address)."+chile&oe=utf-8&sensor=false";
    $request_url=$base_url."latlng=".$lat.",".$lon."&sensor=false";
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
				$dire[]=$tipo;
				$dire[]=$direc;
				$dire[]=$numero_municipal;
				$dire[]=$calle;
				$dire[]=$comuna;
				$dire[]=$ciudad;
				$dire[]=$region;
				$dire[]=$latitud;
				$dire[]=$longitud;
				$dire[]=$tipo_gis;
				if(strtolower($tipo)=="street_address")
				{
      		$direccion_arr[]=$dire;
      	}
				$i++;
    	}      
    } 
    usleep($delay);
  }
 
	return $direccion_arr;
}
/*
ADD direccion a la BD
*/
function addDireccion($dir,$origen)
{
		
	$com=getComuna(trim($dir[2]));	
		
	if(count($com)==0)
	{
		$id_comuna=0;
	}else
	{
		$id_comuna=$com[1];
	}

	$reg_arr=explode(" ", $dir[3]);

	$id_region=0;
	foreach($reg_arr as $reg)
	{
		$reg=trim($reg);
		if(strtolower($reg) !="region" and strtolower($reg)!='chile')
		{

			$region=getRegion($reg);
			//print_r($region);
			
			if(count($region)==0)
			{
				$id_region=0;
			}else
			{
				$id_region=$region[1];
				break;
			}
		}
	}
  $dbPg=pgSql_db();
	$sql=strtolower(utf8_encode(limpia(utf8_decode("insert into gis_direccion(calle,numero_municipal,latitud,longitud,comuna,id_comuna,region,id_region,query_completa,geom,origen) values('".$dir[0]."','".$dir[1]."','".$dir[4]."','".$dir[5]."','".$com[0]."',".$id_comuna.",'".$region[0]."',".$id_region.",'".$dir[6]."',ST_GeomFromText('POINT(".$dir[5]." ".$dir[4].")',2276),".$origen.")"))));
	//echo "<br>".$sql."<br>";
	$rsCalle = pg_query($dbPg, $sql);	
	pg_close($dbPg);
}
/*
Entrega arreglo con servicios
*/

function getServicios($servicios,$limite)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna from gis_servicios where nombre_servicio ilike '%".$servicios."%' and estado=0";
	if($limite>0)
	{
		$sql .=" limit ".$limite."";
	}
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$direc=Array();
		$direc[]=$rowCalle[0];
		$direc[]=trim($rowCalle[1]);
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];
		$direcciones[]=$direc;
		
		
	}	
	pg_close($dbPg);
  return $direcciones;
}

function getServicioXId($id)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna from gis_servicios where id_servicio=".$id." and estado=0";

	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		
		$direc[]=$rowCalle[0];
		$direc[]=trim($rowCalle[1]);
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];
		
		
		
	}	
	pg_close($dbPg);
  return $direc;
}

function getServicioPagoXId($id)
{
	$dbPg=pgSql_db();		
	$fecha=date("Y-m-d H:i:s");
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna,descripcion,id_categoria from cm_servicios where id_servicio=".$id." and estado=0 and fecha_inicio <= '".$fecha."' and fecha_termino >= '".$fecha."'";
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		
		$direc[]=$rowCalle[0];
		$direc[]=trim($rowCalle[1]);
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];
		$direc[]=$rowCalle[8];
		$direc[]=$rowCalle[9];
		
		
		
	}	
	pg_close($dbPg);
  return $direc;
}
function getServiciosXRadio($servicios,$limite,$lat,$lon,$radio)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna,ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 as radio,id_categoria,descripcion from gis_servicios where estado=0 and (calle like '%".$servicios."%' or categoria like '%".$servicios."%' or nombre_servicio like '%".$servicios."%' or query_completa like '%".$servicios."%') and ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 < ".$radio."";
	$sql .=" order by radio";
	if($limite>0)
	{
		$sql .=" limit ".$limite."";
	}
	//echo "<br>".$sql;
	$rsCalle = pg_query($dbPg, $sql);	

	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$data_categoria=getServicioCategoria($rowCalle[9]);
		if(count($data_categoria)>0)
		{
				$direc=Array();
				$direc[]=$rowCalle[0];
				$direc[]=trim($rowCalle[1]);
				$direc[]=$rowCalle[2];
				$direc[]=$rowCalle[3];
				$direc[]=$rowCalle[4];
				$direc[]=$rowCalle[5];
				$direc[]=$rowCalle[6];
				$direc[]=$rowCalle[7];
				$direc[]=$rowCalle[8];//radio
				$direc[]=$rowCalle[9];
				$direc[]=$rowCalle[10];
				$direcciones[]=$direc;
		}
		
	}	
	
  return $direcciones;
}

function getServiciosXRadioPagos($servicios,$limite,$lat,$lon,$radio)
{
	$dbPg=pgSql_db();		
	$fecha=date("Y-m-d H:i:s");
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna,ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 as radio,id_categoria,descripcion from cm_servicios where estado=0 and fecha_inicio <= '".$fecha."' and fecha_termino >= '".$fecha."' and query_completa ilike '%".$servicios."%' and ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 < ".$radio."";
	$sql .=" order by radio";
	if($limite>0)
	{
		$sql .=" limit ".$limite."";
	}
	
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$data_categoria=getServicioCategoria($rowCalle[9]);
		if(count($data_categoria)>0)
		{
			$direc=Array();
			$direc[]=$rowCalle[0];
			$direc[]=trim($rowCalle[1]);
			$direc[]=$rowCalle[2];
			$direc[]=$rowCalle[3];
			$direc[]=$rowCalle[4];
			$direc[]=$rowCalle[5];
			$direc[]=$rowCalle[6];
			$direc[]=$rowCalle[7];
			$direc[]=$rowCalle[8];//radio
			$direc[]=$rowCalle[9];
			$direc[]=$rowCalle[10];
			$direcciones[]=$direc;
		}
		
		
	}	
	//pg_close($dbPg);
  return $direcciones;
}
function getServiciosDirecXRadio($servicios,$limite,$lat,$lon,$radio)
{
	$dbPg=pgSql_db();		
	$query_arr=explode(" ",$servicios);
	$sql2="";
	foreach($query_arr as $i => $query)
	{
		if(trim($query)!="")
		{
			if($sql2=="")
				$sql2 ="query_completa like ('%".$query."%')";
			else
			  $sql2 .="and query_completa like ('%".$query."%')";
		}
	}
	$sql="select id_servicio,nombre_servicio,categoria,latitud,longitud,calle,numero_municipal,comuna,ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 as radio,id_categoria from gis_servicios where (".$sql2.") and ST_Distance(
  ST_GeographyFromText('POINT(".$lon." ".$lat.")'), 
  ST_GeographyFromText(st_AsText(geom))
  )/1000 < ".$radio."";
	$sql .=" order by radio";
	if($limite>0)
	{
		$sql .=" limit ".$limite."";
	}
	
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		$data_categoria=getServicioCategoria($rowCalle[9]);
		if(count($data_categoria)>0)
		{
		$direc=Array();
		$direc[]=$rowCalle[0];
		$direc[]=trim($rowCalle[1]);
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=toponimos($rowCalle[5]);
		$direc[]=$rowCalle[6];
		$direc[]=toponimos($rowCalle[7]);
		$direc[]=$rowCalle[8];//radio
		$direc[]=$rowCalle[9];//id_categoria
		$direcciones[]=$direc;
		}
		
	}	
	
  return $direcciones;
}

function getRegionxId($id)
{
	$dbPg=pgSql_db();
	
	$sql2 = "select nombre,id_region from gis_region where id_region = ".$id."";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$regiones[]=$row2[0];
			$regiones[]=$row2[1];
		}
		pg_close($dbPg);
		return $regiones;
}
function getComuna($comuna)
{
	$dbPg=pgSql_db();
	$sql2 = "select nombre,id_comuna from gis_comuna where nombre ilike '%".$comuna."%'";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$comunas[]=$row2[0];
			$comunas[]=$row2[1];
		}
		pg_close($dbPg);
		return $comunas;
}
function getRegion($region)
{
	$dbPg=pgSql_db();
	
	$sql2 = "select nombre,id_region from gis_region where nombre ilike '%".$region."%'";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$regiones[]=$row2[0];
			$regiones[]=$row2[1];
		}
		pg_close($dbPg);
		return $regiones;
}
function elimina_acentos($cadena)
{
	
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	return(strtr($cadena,$tofind,$replac));
}


function ConsultaCaracteres($texto) 
{
	$texto=strtolower(elimina_acentos($texto));	
	$texto=str_replace(".","",$texto);		
	$texto=str_replace(",","",$texto);		
	$texto=str_replace("a","[aáàä]",$texto);
	$texto=str_replace("e","[eéèë]",$texto);
	$texto=str_replace("i","[iíìï]",$texto);
	$texto=str_replace("o","[oóòö]",$texto);
	$texto=str_replace("u","[uúùü]",$texto);
	$texto=str_replace("n","[nñ]",$texto);
	$texto=str_replace("s","[sz]",$texto);
	$texto=str_replace("z","[sz]",$texto);
	$texto=str_replace("[s[sz]]","[sz]",$texto);
	
	$texto=str_replace("v","[vb]",$texto);
	$texto=str_replace("b","[vb]",$texto);
	$texto=str_replace("[v[vb]]","[vb]",$texto);

	//$texto=str_replace("z","[sz]",$texto);
	return $texto;
}


function getAntenas()
{
	$dbPg=pgSql_db();
	
	$sql2 = "select empresa,latitud,longitud,comuna from gis_antenas";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$datos=Array();
			$datos[]=$row2[0];
			$datos[]=$row2[1];
			$datos[]=$row2[2];
			$datos[]=$row2[3];
			$dat[]=$datos;
		}
		pg_close($dbPg);
		return $dat;
}

function getAntenasExtend($latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	
	$sql2 = "SELECT empresa,latitud,longitud,comuna FROM gis_antenas where lat<=".$latS." and lat >=".$latI." and lon <=".$lonD." and lon >=".$lonI."";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}

function CM_getServiciosActivos()
{
	$dbPg=pgSql_db();	
	$sql2 = "select id_serv,nombre,id_gis_servicio,estado,prioridad,icono from cm_servicios_web where estado=0 and web=0 order by prioridad";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];
	   $data[]=$row2[5];
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}

function getServicioExtend($id_serv,$latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	
	$sql2 = "SELECT id_categoria,latitud,longitud,calle,numero_municipal,comuna,region,id_comuna,id_region,categoria,nombre_servicio,descripcion,id_servicio FROM gis_servicios where id_categoria=".$id_serv." and latitud<=".$latS." and latitud >=".$latI." and longitud <=".$lonD." and longitud >=".$lonI."";		
  $rs2 = pg_query($dbPg, $sql2);
	//echo "<br>".$sql2;
	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];	
	   $data[]=$row2[5];	
	   $data[]=$row2[6];	
	   $data[]=$row2[7];	
	   $data[]=$row2[8];	
	   $data[]=$row2[9];	
	   $data[]=$row2[10];	
	   $data[]=$row2[11];	
	      $data[]=$row2[12];	
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}

function getPoligon()
{
	$dbPg=pgSql_db();
	
	$sql2 = "SELECT ST_astext(geom) from manzana_santiago limit 1";		
  $rs2 = pg_query($dbPg, $sql2);
//echo "<br>".$sql2;
	if ($row2 = pg_fetch_row($rs2))
		{
			$geom=str_replace("MULTIPOLYGON(((","",$row2[0]);
			$geom=str_replace(")))","",trim($geom));
			$geom_arr=explode(",",$geom);
			foreach($geom_arr as $dat)
			{
				$data=array();
				$data=explode(" ",$dat);
				$data_arr[]=$data;
			}
	  }
	  pg_close($dbPg);
	return $data_arr;
}
function getManzanasExtend($latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	
  //$sql2 = "SELECT comuna,manzent,es_e,es_d,es_c3,es_c2,es_abc1,total_hogar,nivel_se,st_astext(geom),personas,region,mujeres,hombres FROM manzana_santiago where ST_Contains(ST_GeomFromText('POLYGON((".$lonI." ".$latI.", ".$lonI." ".$latS.", ".$lonD." ".$latS.", ".$lonD." ".$latI.",".$lonI." ".$latI."))',4326),ST_Centroid(geom))";		
  $sql2 = "SELECT manzent,es_e,es_d,es_c3,es_c2,es_abc1,total_hogar,nivel_se,st_astext(geom),personas,region,mujeres,hombres FROM manzanas_chile where ST_Contains(ST_GeomFromText('POLYGON((".$lonI." ".$latI.", ".$lonI." ".$latS.", ".$lonD." ".$latS.", ".$lonD." ".$latI.",".$lonI." ".$latI."))',4326),ST_Centroid(geom))";		
  $rs2 = pg_query($dbPg, $sql2);
  //echo "<br>".$sql2;
	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	    $data[]=$row2[2];
	    $data[]=$row2[3];	
	    $data[]=$row2[4];	
	    $data[]=$row2[5];	
	    $data[]=$row2[6];	
	    $data[]=$row2[7];	
	    $data[]=$row2[8];	
	    $data[]=$row2[9];	
	    $data[]=$row2[10];	
	    $data[]=$row2[11];	
	    $data[]=$row2[12];	
	    $data[]=$row2[13];	
	    
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}
function buscarDireccionOSM($query)
{
	
	$delay = 0;
	
	$base_url="http://nominatim.openstreetmap.org/search?";
  $geocode_pending = true;
  while ($geocode_pending) {
    //$address = "pasaje u 2113 chile";
    $address=trim($direccion);
    $request_url = $base_url . "q=".urldecode($query." chile")."&format=xml&polygon=1&addressdetails=1";
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
    		$lonlat[]=$place['lon'];
    		$lonlat[]=$place['lat'];
    		$lonlat[]=$place->house_number;
    		$lonlat[]=$place->road;
    		$lonlat[]=$place->city;
    		$lonlat[]=$place->country;
    		$lonlat[]=$place->state;
				$lonlat[]=$place['lat'];
    		$lonlat[]=$place['lon'];
    		$lonlat_arr[]=$lonlat;
    	}
    	//echo "<br>".$longitud;
    	//print_r($xml_result);
    }
  }
  return $lonlat_arr;
}
function toponimos($texto)
{
	$texto=str_replace("vicuna","vicuña",$texto);	
	$texto=str_replace("nunoa","ñuñoa",$texto);
	$texto=str_replace("penaflor","peñaflor",$texto);
	$texto=str_replace("penalolen","peñalolen",$texto);
	$texto=str_replace("ibanez","ibañez",$texto);
	$texto=str_replace("borgono","borgoño",$texto);
	return $texto;
}
function toponimosHtml($texto)
{
	$texto=str_replace("vicuna","vicu&ntilde;a",$texto);	
	$texto=str_replace("nunoa","&ntilde;u&ntilde;oa",$texto);
	$texto=str_replace("penaflor","pe&ntilde;aflor",$texto);
	$texto=str_replace("penalolen","pe&ntilde;alolen",$texto);
	$texto=str_replace("ibanez","iba&ntilde;ez",$texto);
	$texto=str_replace("borgono","test",$texto);

	return $texto;
}


function getServicioCategoria($id_categoria)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_serv_categoria,nombre,icono,origen,id_cliente from gis_servicio_categoria where id_serv_categoria=".$id_categoria." and estado=0";
	$rsCalle = pg_query($dbPg, $sql);	
		//echo $sql;
		$data=array();
	while ($row2 = pg_fetch_row($rsCalle)){	
	
		$data[]=$row2[0];	
		$data[]=$row2[1];	
		$data[]=$row2[2];	
		$data[]=$row2[3];	
		$data[]=$row2[4];	
	}
	pg_close($dbPg);
	return $data;
}
function limpia($cadena)
{
	$a_tofind = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å'
   , 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø'
   , 'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë', 'Ç', 'ç'
   , 'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï'
   , 'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü', 'ÿ', 'Ñ', 'ñ');
$a_replac = array('A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a'
   , 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o'
   , 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'C', 'c'
   , 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'
   , 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'y', 'N', 'n');
return $cadenaSinAcentos = str_replace($a_tofind, $a_replac, $cadena);
}

function getTransantiagoParaderos($latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	
  $sql2 = "SELECT stop_code,stop_name,stop_lat,stop_lon,stop_id,rutas FROM trans_stop where ST_Contains(ST_GeomFromText('POLYGON((".$lonI." ".$latI.", ".$lonI." ".$latS.", ".$lonD." ".$latS.", ".$lonD." ".$latI.",".$lonI." ".$latI."))',2276),ST_Centroid(geom))";		
  
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];	    
			$data[]=$row2[2];
			$data[]=$row2[3];
			$data[]=$row2[4];
			$data[]=$row2[5];
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}

function getBusesxParada($stop_id)
{
	$dbPg=pgSql_db();
	
  $sql2 = "select distinct(route_id),route_id from trans_trip where trip_id in(select trip_id from trans_stop_times where stop_id ilike '".$stop_id."')";		
  
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{			
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
			$datas[]=$data;
		}
	pg_close($dbPg);
	return $datas;
}

function getDataRuta($id_ruta)
{
	$dbPg=pgSql_db();
	
  $sql2 = "select route_color from trans_routes where id_ruta ilike '".$id_ruta."'";		
  
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{			
			$data[]=$row2[0];
		}
	pg_close($dbPg);
	return $data;
}

function getRutasLinea($id_ruta,$destino)
{
	$dbPg=pgSql_db();
	$sql2="select shape_pt_lat,shape_pt_lon from trans_shapes where shape_id ilike '".trim($id_ruta)."-".$destino."-base' order by shape_pt_sequence";
	$rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
	{						
			$data[]=$row2[1].",".$row2[0];			
	}
	pg_close($dbPg);
	return $data;
}
function eliminarFav($id)
{
	$dbPg=pgSql_db();
	$sql2="update cm_favoritos set estado=2 where id_favorito=".$id."";
	$rs2 = pg_query($dbPg, $sql2);

	pg_close($dbPg);
	return $data;
}
function getDireccionXId($id)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_direccion,segmento,'direccion',latitud,longitud,calle,numero_municipal,comuna from gis_direccion where id_direccion=".$id."";

	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		//$arr_callesComuna[$rowCalle[0]] = $rowCalle[1];
		
		$direc[]=$rowCalle[0];
		$direc[]=trim($rowCalle[1]);
		$direc[]=$rowCalle[2];
		$direc[]=$rowCalle[3];
		$direc[]=$rowCalle[4];
		$direc[]=$rowCalle[5];
		$direc[]=$rowCalle[6];
		$direc[]=$rowCalle[7];
		
		
		
	}	
	pg_close($dbPg);
  return $direc;
}
function getIdDireccionXLatLon($lat,$lon)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_direccion from gis_direccion where latitud=".$lat." and longitud=".$lon." and origen in(2,3)";

	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		
		$id=$rowCalle[0];
		
		
		
		
	}	
	pg_close($dbPg);
  return $id;
}

function distancia($lon,$lat,$lon2,$lat2)
{
	$dbPg=pgSql_db();		
	$sql="select ST_Distance(ST_GeographyFromText('POINT(".$lon." ".$lat.")'),ST_GeographyFromText('POINT(".$lon2." ".$lat2.")'))/1000";
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){		
		
		$dist=$rowCalle[0];	
		
	}	
	pg_close($dbPg);
  return $dist;
}
function getCatPagos()
{
	$dbPg=pgSql_db();		
	$fecha=date("Y-m-d H:i:s");
	$sql="select id_serv,id_gis_servicio,nombre,prioridad,icono from cm_servicios_pago_web where estado=0 and fecha_inicio <='".$fecha."' and fecha_termino >='".$fecha."' order by prioridad";
	$rsCalle = pg_query($dbPg, $sql);	
	//echo $sql;
	while ($rowCalle = pg_fetch_row($rsCalle)){	
		$data_categoria=getServicioCategoria($rowCalle[1]);
		if(count($data_categoria)>0)
		{
			
		$data=array();
		$data[]=$rowCalle[0];	
		$data[]=$rowCalle[1];	
		$data[]=$rowCalle[2];	
		$data[]=$rowCalle[3];	
		$data[]=$rowCalle[4];	
		$datos[]=$data;
		}
	}	
	//pg_close($dbPg);
  return $datos;
}

function getServicioExtendPagos($id_serv,$latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	$fecha=date("Y-m-d H:i:s");
	$sql2 = "SELECT id_categoria,latitud,longitud,calle,numero_municipal,comuna,region,id_comuna,id_region,categoria,nombre_servicio,descripcion FROM cm_servicios where id_categoria=".$id_serv." and fecha_inicio <= '".$fecha."' and fecha_termino >= '".$fecha."' and latitud<=".$latS." and latitud >=".$latI." and longitud <=".$lonD." and longitud >=".$lonI." and estado=0";		
  $rs2 = pg_query($dbPg, $sql2);
	//echo "<br>".$sql2;
	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			
			$data_categoria=getServicioCategoria($row2[0]);
		if(count($data_categoria)>0)
		{
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];	
	   $data[]=$row2[5];	
	   $data[]=$row2[6];	
	   $data[]=$row2[7];	
	   $data[]=$row2[8];	
	   $data[]=$row2[9];	
	   $data[]=$row2[10];	
	   $data[]=$row2[11];
	   $data[]=$data_categoria[2];
			$datos[]=$data;
		}
	}
	//pg_close($dbPg);
	return $datos;
}

function getServicioExtendPagosFull($latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	$fecha=date("Y-m-d H:i:s");
	$sql2 = "SELECT id_categoria,latitud,longitud,calle,numero_municipal,comuna,region,id_comuna,id_region,categoria,nombre_servicio,descripcion FROM cm_servicios where estado=0 and fecha_inicio <= '".$fecha."' and fecha_termino >= '".$fecha."' and latitud<=".$latS." and latitud >=".$latI." and longitud <=".$lonD." and longitud >=".$lonI."";		
  $rs2 = pg_query($dbPg, $sql2);
	//echo "<br>".$sql2;
	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];	
	   $data[]=$row2[5];	
	   $data[]=$row2[6];	
	   $data[]=$row2[7];	
	   $data[]=$row2[8];	
	   $data[]=$row2[9];	
	   $data[]=$row2[10];	
	   $data[]=$row2[11];
			$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}
/*Fin mapa*/

function addQuery($query)
{
	$dbPg=pgSql_db();		
	$sql="insert into cm_query(query,fecha_registro) values('".$query."','".date("Y-m-d H:i:s")."')";
	$rsCalle = pg_query($dbPg, $sql);	
	pg_close($dbPg);
}

function getFarmaciasTurno($latI,$latS,$lonD,$lonI)
{
	$dbPg=pgSql_db();
	
  $fecha_actual=date("Y-m-d H:i:s");
	$fecha_actual2 = strtotime ( '-3 hours ' , strtotime ( $fecha_actual ) ) ;
	$fec = date ( 'Y-m-d H:i:s' , $fecha_actual2 );
	
	
	
	$fecha = date ( 'Y-m-d' , $fecha_actual2 );
	$nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
	$nueva = date ( 'Y-m-d' , $nuevafecha );
	$nueva_hora = date("Y-m-d 07:59:59");	
	
	
	//echo "<br> fec: ".$fec." -- ".$nueva_hora."";
	if($fec <= $nueva_hora)
	{
		$query="(fecha = '".$fecha."' or (fecha ='".$nueva."' and horario ilike '%del dia siguiente%') )";
	}else
	{
		$query="fecha = '".$fecha."'";
	}
	$sql2 = "SELECT nombre,fecha,estado,latitud,longitud,direccion,horario,comuna from cm_farmacia_turno where estado=0 and ".$query." and latitud<=".$latS." and latitud >=".$latI." and longitud <=".$lonD." and longitud >=".$lonI."";		
  $rs2 = pg_query($dbPg, $sql2);
	echo "<br>".$sql2;
	while ($row2 = pg_fetch_row($rs2))
		{
			$data=Array();
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];	
	   $data[]=$row2[5];	
	   $data[]=$row2[6];	
	   $data[]=$row2[7];	
	   
		$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
	
}
function getFechaHora()
{
	$fecha_actual=date("Y-m-d H:i:s");
	$fecha_actual2 = strtotime ( '-3 hours ' , strtotime ( $fecha_actual ) ) ;
	$fec = date ( 'Y-m-d H:i:s' , $fecha_actual2 );
	return $fec;
}
function getBanner()
{
	$dbPg=pgSql_db();	
 
	$sql2 = "SELECT id_banner,id_cliente, estado, desde, hasta, archivo from cm_banner where estado=0 and desde <= '".getFechaHora()."' and hasta >='".getFechaHora()."' ORDER BY random() limit 1";		
  $rs2 = pg_query($dbPg, $sql2);
	//echo "<br>".$sql2;
	$data=array();
	while ($row2 = pg_fetch_row($rs2))
		{
			
			$data[]=$row2[0];
			$data[]=$row2[1];
	   $data[]=$row2[2];
	   $data[]=$row2[3];	
	   $data[]=$row2[4];	
	   $data[]=$row2[5];	
	   
	}
	pg_close($dbPg);
	return $data;
	
}
function getCategorias()
{
	$dbPg=pgSql_db();		
	
	$sql="select id_serv_categoria,nombre,icono,origen,id_cliente from gis_servicio_categoria where estado=0 and id_cliente =0 order by nombre";
	$rsCalle = pg_query($dbPg, $sql);	
		//echo $sql;
		$data=array();
	while ($row2 = pg_fetch_row($rsCalle)){	
		$data=array();
		$data[]=$row2[0];	
		$data[]=$row2[1];	
		$data[]=$row2[2];	
		$data[]=$row2[3];	
		$data[]=$row2[4];	
		$datos[]=$data;
	}
	pg_close($dbPg);
	return $datos;
}
function getRegiones()
{
	$dbPg=pgSql_db();
	
	$sql2 = "select nombre,id_region from gis_region order by id_region";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$region=array();
			$region[]=$row2[0];
			$region[]=$row2[1];
			$regiones[]=$region;
		}
		pg_close($dbPg);
		
		return $regiones;
}
function getComunaxRegion($id)
{
	$dbPg=pgSql_db();
	$sql2 = "select nombre,id_comuna from gis_comuna where id_region =".$id." order by nombre";		
  $rs2 = pg_query($dbPg, $sql2);

	while ($row2 = pg_fetch_row($rs2))
		{
			$comunas=array();
			$comunas[]=$row2[0];
			$comunas[]=$row2[1];
			$com[]=$comunas;
		}
		pg_close($dbPg);
		return $com;
}
function getCategoriaxId($id)
{
	$dbPg=pgSql_db();		
	
	$sql="select id_serv_categoria,nombre,icono,origen,id_cliente from gis_servicio_categoria where id_serv_categoria=".$id."";
	$rsCalle = pg_query($dbPg, $sql);	
		//echo $sql;
		$data=array();
	while ($row2 = pg_fetch_row($rsCalle)){	
		
		$data[]=$row2[0];	
		$data[]=$row2[1];	
		$data[]=$row2[2];	
		$data[]=$row2[3];	
		$data[]=$row2[4];	
		
	}
	pg_close($dbPg);
	return $data;
}
function addServicioLibre($data)
{
	$dbPg=pgSql_db();
	
	$sql2 = utf8_encode("INSERT INTO gis_servicios(
            calle, numero_municipal, latitud, longitud, comuna, 
            id_comuna, region, id_region, categoria, id_categoria, nombre_servicio, 
            geom, query_completa, origen, estado,
            fecha_registro, descripcion,id_osm)
    VALUES ('".$data[0]."', '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."', 
            '".$data[5]."', '".$data[6]."', '".$data[7]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', 
            ST_GeomFromText('POINT(".$data[3]." ".$data[2].")',2276), '".$data[11]."', '".$data[12]."', '".$data[13]."', 
            '".getFecha()."', '".$data[16]."','".$data[17]."');");		
  $rs2 = pg_query($dbPg, $sql2);
	
	pg_close($dbPg);
	
}
function getFecha()
{
	$fecha=date("Y-m-d H:i:s");
	$fecha_actual2 = strtotime ( '-3 hours ' , strtotime ( $fecha ) ) ;
	$fec = date ( 'Y-m-d H:i:s' , $fecha_actual2 );
	return $fec;
}

function addServicioDetalle($data)
{
	$dbPg=pgSql_db();
	
	$sql2 = utf8_encode("INSERT INTO gis_servicio_detalle(
            id_servicio, url, descripcion, telefono, texto4, 
            texto5, fecha_registro)
    VALUES ('".$data[0]."', '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."', 
            '".$data[5]."', '".getFecha()."')");		
  $rs2 = pg_query($dbPg, $sql2);
	
	pg_close($dbPg);
	
}
function getDetalleServ($qr)
{
	$dbPg=pgSql_db();		
	
	$sql="SELECT id_detalle, id_servicio, url, descripcion, telefono, texto4, 
       texto5, fecha_registro
  FROM gis_servicio_detalle where 1=1";
  if(trim($qr)!="")
  {
  	$sql .=$qr;
  }
	$rsCalle = pg_query($dbPg, $sql);	
		//echo $sql;
		$data_arr=array();
	while ($row2 = pg_fetch_row($rsCalle)){	
		$data=array();
		$data[]=$row2[0];	
		$data[]=$row2[1];	
		$data[]=$row2[2];	
		$data[]=$row2[3];	
		$data[]=$row2[4];	
		$data[]=$row2[5];	
		$data[]=$row2[6];	
		$data[]=$row2[7];	
		$data_arr[]=$data;
	}
	pg_close($dbPg);
	return $data_arr;
}
function getFechaLibre($horas)
{
	$fecha=date("Y-m-d H:i:s");
	$fecha_actual2 = strtotime ( '-'.$horas.' hours ' , strtotime ( $fecha ) ) ;
	$fec = date ( 'Y-m-d H:i:s' , $fecha_actual2 );
	return $fec;
}
?>