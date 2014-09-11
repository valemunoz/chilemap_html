<?PHP
//chdir("/usr/local/www/desarrollo/desarrollo.chilemap.cl/www");

include('includes/funciones.php');
require_once("includes/mensajes.php");
//validaciones de IP
$estado_ses=estado_sesion();
$data_server= explode("?",$_SERVER['HTTP_REFERER']);


if(substr(strtolower($data_server[0]),0,strlen($CM_path_base))==$CM_path_base)
{
if($_REQUEST['tipo']==1 and $_REQUEST['act']==1)//direcciones
{
	$query=urldecode($_REQUEST['consulta']);
	$query=str_replace("#","",$query);
	$query=str_replace(" , "," ",$query);
	
	$query=str_replace(", "," ",$query);
	$query=str_replace(" ,"," ",$query);
	$query=str_replace(","," ",$query);
  $query =strtolower(elimina_acentos(utf8_decode($query)));	
	$query=str_replace("'","",$query);
	$query=str_replace('"',"",$query);
	//$query=ConsultaCaracteres($query);
	//$query=str_replace("a","[aбад]",$query);
	//echo "<br>".$query;
	$busca_direccion=false;
	
	$query_arr=explode(" ",$query);
	foreach($query_arr as $q)
	{
		
		if(is_numeric(trim($q)))
		{
			$busca_direccion=true;
			break;
		}
	}
	if($busca_direccion)
	{
		$direcciones=getDireccion($query,10);
		$busqueda=1;
		
	}else
	{
		?>
		<script>
		var capaContenedora = document.getElementById("cont_direc");
		capaContenedora.innerHTML=capaContenedora.innerHTML='Total:(0)';	
	</script>
	
	<?php
	echo $CM_msg_direccion_no;
	}

	
	if(count($direcciones)>0 and $busca_direccion)
	{
		?>
	<script>
		var capaContenedora = document.getElementById("cont_direc");
		capaContenedora.innerHTML=capaContenedora.innerHTML='Total:(<?=count($direcciones)?>)';	
	</script>
	<?PHP
		?>
		<script>
				deleteMarkerDireccion();
		</script>
		<?php
		session_start();
		$_SESSION['busqueda_direccion']= $query;

		foreach($direcciones as $i => $direc)
		{
			?>
			<script>
				var dt=distanciaEntre(<?=$_REQUEST['lon']?>,<?=$_REQUEST['lat']?>,<?=$direc[7]?>,<?=$direc[6]?>);
				
			</script>
				
			<?php
			
			$distancia=distancia($_REQUEST['lon'],$_REQUEST['lat'],$direc[7],$direc[6]);
			$texto="<div id=titulo1>Direccion</div>";
			$texto .="<div id=titulo2>".ucwords(utf8_encode(toponimos(strtolower($direc[1]))))." #".$direc[3]."</div>";
			$texto .="<div id=titulo3>".ucwords(utf8_encode(toponimos(strtolower($direc[4]))))."</div>";
			$texto=utf8_encode(ucwords(utf8_decode($texto)));
			$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$direc[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$direc[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace(**".$CM_path_base2."?ptot=1&pto=".$direc[0]."**);> <a href=**https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$direc[0]."&via=chilemap&text=Revisa este link** target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
			$texto_resultado="";
			if($i % 2==0)
			{
				?>
				<div class="ser"> 
				
				<div class="des_resul">
					<div onclick="deleteMarkerDireccion();addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>',<?=$direc[6]?>,<?=$direc[7]?>,'<?=$texto?>','');moverCentro(<?=$direc[6]?>,<?=$direc[7]?>,<?=$CM_ZOOM_DIR?>);">
						<span class="span_result"><?=ucwords(utf8_encode(toponimos($direc[1])))?> # <?=$direc[3]?>, <?=ucwords(utf8_encode(toponimos(strtolower($direc[4]))))?></span>
						</br>
						<span class="span_distancia">Distancia:<?=round($distancia,2)?>Km</span>
						<?php
						if($direc[10]==2 or $direc[10]==3)
						{
							if($direc[10]==3)
							{
								$txt_dir="OSM";
							}else
							{
								$txt_dir="GOOGLE";
							}
							?>
							<span class="span_nota">Direcci&oacute;n no exacta obtenida desde <?=$txt_dir?></span>
							<?php						
						}
						?>
					</div>
						<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$direc[0]?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$direc[0]?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=1&pto=<?=$direc[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=1&pto=<?=$direc[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>

				</div> 
                <div class="img_ser" style="width:35px; height:35px;margin-right: 5px; margin-top:5px; float:left">
						<img width="35" height="35" src="<?=$CM_ICONO_DIR?>">
				</div> 
			</div>
			
			
				<?php
			}else
			{
				?>
			<div class="ser1">
      
      	<div class="des_resul">
      		<div onclick="deleteMarkerDireccion();addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>',<?=$direc[6]?>,<?=$direc[7]?>,'<?=$texto?>','');moverCentro(<?=$direc[6]?>,<?=$direc[7]?>,<?=$CM_ZOOM_DIR?>);">
      			<span class="span_result"><?=ucwords(utf8_encode(toponimos($direc[1])))?> # <?=$direc[3]?>, <?=ucwords(utf8_encode(toponimos(strtolower($direc[4]))))?></span>
      		</br>
					<span class="span_distancia">Distancia:<?=round($distancia,2)?>Km</span>
					<?php
						if($direc[10]==2 or $direc[10]==3)
						{
							if($direc[10]==3)
							{
								$txt_dir="OSM";
							}else
							{
								$txt_dir="GOOGLE";
							}
							?>
							<span class="span_nota">Direcci&oacute;n no exacta obtenida desde <?=$txt_dir?></span>
							<?php
						}
					?>

      		</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$direc[0]?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$direc[0]?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=1&pto=<?=$direc[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=1&pto=<?=$direc[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
      	</div>
        	<div class="img_ser" style="width:45px;margin-top:5px;margin-right: 5px; height:35px; float:left">
      		<img width="35" height="35" src="<?=$CM_ICONO_DIR?>">
      	</div> 
      </div>
      
      
				
				<?php
			}
			?>
			<script>
				CM_busqueda[CM_busqueda.length]="<?=$direc[6]?>,<?=$direc[7]?>";
				CM_busqueda_texto[CM_busqueda_texto.length]="<?=$texto?>";
				CM_busqueda_icono[CM_busqueda_icono.length]='iconos/direccion.png';
				addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$direc[6]?>','<?=$direc[7]?>',"<?=$texto?>",'');
				
				
			</script>

			
			
			<?php
		}
		?>
		<script>
			verMarcadores();
		
		</script>
		<?PHP
		
	}elseif(($CM_GOOGLE_SEARCH or $CM_OSM_SEARCH ) and $busca_direccion)
	{
		
		if($CM_OSM_SEARCH)
		{			
			$direccion_osm=buscarDireccionOSM($query);
			$busqueda=3;
			$txt_dir="OSM";
			//print_r($direccion_google);
		}
		if(count($direccion_osm)==0 and $CM_GOOGLE_SEARCH)
		{
			$direccion_google=getDireccionGoogle($query);			
			$busqueda=2;
			$txt_dir="GOOGLE";
			//print_r($direccion_google);
		}
		
		 if($busqueda==2)
		     $direccion_query=$direccion_google;
		  if($busqueda==3)
		     $direccion_query=$direccion_osm;
		     
		     ?>
	<script>
		var capaContenedora = document.getElementById("cont_direc");
		capaContenedora.innerHTML=capaContenedora.innerHTML='Total:(<?=count($direccion_query)?>)';	
	</script>
	<?PHP
		if(count($direccion_query)>0)
		{
			?>
			<script>
				deleteMarkerDireccion();
			</script>
			<?php
			session_start();
			$_SESSION['busqueda_direccion']= $query;
			
		 
   
			foreach($direccion_query as $i => $direc)
			{
				if(trim($direc[2])=="")
				{
					$direc[2]=0;
				}
								
				
						
				$dir[]=$direc[3];
				$dir[]=$direc[2];
				$dir[]=$direc[4];
				$dir[]=$direc[6];//region
				$dir[]=$direc[7];//lat
				$dir[]=$direc[8];//lon
				$dir[]=ucwords("".$direc[3]." ".$direc[2]." ".$direc[4]." ".$direc[6]." ");//completa
				addDireccion($dir,$busqueda);
				$id_pto=getIdDireccionXLatLon($direc[7],$direc[8]);
				$distancia=distancia($_REQUEST['lon'],$_REQUEST['lat'],$direc[8],$direc[7]);
				$texto="<div id=titulo1>Direccion</div>";
				$texto .="<div id=titulo2>".ucwords(utf8_encode(toponimos(strtolower($direc[3]))))." #".$direc[2]."</div>";
				$texto .="<div id=titulo3>".ucwords(utf8_encode(toponimos(strtolower($direc[4]))))."</div>";
				//$texto=ucwords(utf8_encode($texto));
				$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$id_pto.",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$id_pto.",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace(**".$CM_path_base2."?ptot=1&pto=".$id_pto."**);> <a href=**https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$id_pto."&via=chilemap&text=Revisa este link** target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
			
				?>
				<script>
					CM_busqueda[CM_busqueda.length]="<?=$direc[7]?>,<?=$direc[8]?>";
				CM_busqueda_texto[CM_busqueda_texto.length]="<?=$texto?>";
				CM_busqueda_icono[CM_busqueda_icono.length]='iconos/direccion.png';
					addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$direc[7]?>','<?=$direc[8]?>','<?=$texto?>','');
				</script>
						

				<?php
				
				if($i % 2==0)
			{
				?>
			
				<div class="ser"> 
				
				<div class="des_resul">
					<div onclick="deleteMarkerDireccion();addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$direc[7]?>','<?=$direc[8]?>','<?=$texto?>','');moverCentro(<?=$direc[7]?>,<?=$direc[8]?>,<?=$CM_ZOOM_DIR?>);">
						<span class="span_result"><?=$direc[3]?> # <?=$direc[2]?>, <?=$direc[4]?></span>
						</br>
						<span class="span_distancia">Distancia:<?=round($distancia,2)?>Km</span>
						<span class="span_nota">Direcci&oacute;n no exacta obtenida desde <?=$txt_dir?></span>
						
					</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$id_pto?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$id_pto?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=1&pto=<?=$id_pto?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=1&pto=<?=$id_pto?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
				</div> 
                <div class="img_ser" style="width:35px; height:35px;margin-right: 5px; margin-top:5px; float:left">
						<img width="35" height="35" src="<?=$CM_ICONO_DIR?>">
				</div> 
			</div>
				<?php
			}else
			{
				?>
				
				<div class="ser1">
      
      	<div class="des_resul">
      		<div onclick="deleteMarkerDireccion();addMarcador('<?=$CM_ICONO_DIR?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$direc[7]?>','<?=$direc[8]?>','<?=$texto?>','');moverCentro(<?=$direc[7]?>,<?=$direc[8]?>,<?=$CM_ZOOM_DIR?>);">
      			<span class="span_result"><?=$direc[3]?> # <?=$direc[2]?>, <?=$direc[4]?></span>
      		</br>
					<span class="span_distancia">Distancia:300mts</span>
					<span class="span_nota">Direcci&oacute;n no exacta obtenida desde <?=$txt_dir?></span>
      		</div>
      							<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$id_pto?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$id_pto?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=1&pto=<?=$id_pto?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=1&pto=<?=$id_pto?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>

      	</div>
        	<div class="img_ser" style="width:45px;margin-top:5px;margin-right: 5px; height:35px; float:left">
      		<img width="35" height="35" src="<?=$CM_ICONO_DIR?>">
      	</div> 
      </div>
      
			
				<?php
			}
			}
			
		}else
		{
			echo $CM_msg_direccion_no;
			
		}
	}
	
}elseif($_REQUEST['tipo']==1 and $_REQUEST['act']==2) //servicios
{	
	$query=urldecode($_REQUEST['consulta']);
	$query=strtolower(elimina_acentos(utf8_decode($query)));
	$query=str_replace("#","",$query);
//  $query =strtolower(elimina_acentos2(utf8_decode($query)));	
  $query=str_replace("'","",$query);
	$query=str_replace('"',"",$query);
	
	$servicios=getServiciosXRadio($query,100,$_REQUEST['lat'],$_REQUEST['lon'],10000);
	$servicios_pagos=getServiciosXRadioPagos($query,100,$_REQUEST['lat'],$_REQUEST['lon'],10000);
	
	//print_r($servicios_pagos);
	//print_r($servicios);
	if(count($servicios)==0)
	{
		$servicios=getServiciosDirecXRadio($query,100,$_REQUEST['lat'],$_REQUEST['lon'],10000);
	}
	$total_serv=count($servicios_pagos) + count($servicios);
	//print_r($servicios);
	?>
	<script>

				deleteMarkerServicio();
				var capaContenedora = document.getElementById("cont_serva");
				capaContenedora.innerHTML=capaContenedora.innerHTML='Total:(<?=$total_serv?>)';	
			</script>	
	<?PHP
 //pagos
 
 	if(count($servicios_pagos)>0)
	{
	
		$estado_ses=estado_sesion();
		foreach($servicios_pagos as $i => $serv)
		{
			
			$categoria=$serv[2];			
			$texto ="<div id=titulo2>".strtoupper($serv[1])."</div>";
			$texto .="<div id=titulo4>".strtoupper($categoria)."</div>";
			if(trim($serv[5])!="")
			{
				$texto .="<div id=titulo5>".ucwords($serv[5])." #".$serv[6]."</div>";
			}
			$texto .="<div id=titulo6>".ucwords($serv[7])."</div>";
			$texto .="<div id=tit_descrip>".ucwords(trim($serv[10]))."</div>";
			$texto .="<div id=titulo3>Distancia: ".round($serv[8],2)."Km </div>";
			
			$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$serv[0].",3);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$serv[0].",3);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace(**".$CM_path_base2."?ptot=3&pto=".$serv[0]."**);> <a href=**https://twitter.com/share?url=".$CM_path_base2."?ptot=3&pto=".$serv[0]."&via=chilemap&text=Revisa este link** target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
			
			$texto=elimina_acentos($texto);
			
			$texto_mini=ucwords(strtolower($serv[1]));
			$data_categoria=getServicioCategoria($serv[9]);
			$icono=$data_categoria[2];
			
			if(trim($icono)=="")
			{
				$icono=$CM_ICONO_SERV;
			}
			//$texto=ConsultaCaracteres($texto);
			?>
			<script>
				CM_busqueda[CM_busqueda.length]="<?=$serv[3]?>,<?=$serv[4]?>";
				CM_busqueda_texto[CM_busqueda_texto.length]="<?=$texto?>";
				CM_busqueda_icono[CM_busqueda_icono.length]='iconos/servicio.png';
				
				addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>',"<?=$texto?>","<?=$texto_mini?>");
			</script>
			
			<?php
			
			if($i % 2==0)
			{
				?>
				<div class="ser"> 
				
					
				<div class="des_resul">
					<div  onclick="levantarPopup('<?=$texto?>');addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>','<?=$texto?>','<?=$texto_mini?>');moverCentro(<?=$serv[3]?>,<?=$serv[4]?>,<?=$CM_ZOOM_SERV?>);">
					<span class="span_result"><?=ucwords(utf8_encode(toponimos($serv[1])))?></span>
					</br>
					<?php
					if(trim($serv[5])!="")
					{
					?>
						<span class="span_dir"><?=ucwords(utf8_encode(toponimos(strtolower($serv[5]))))?> #<?=$serv[6]?></span> 
						<br>
						<?php
					}
					?>
					<span class="span_comuna"><?=ucwords(utf8_encode(toponimos(strtolower($serv[7]))))?></span>
					</br>
					<span class="span_distancia">Distancia:<?=round($serv[8],2)?>Km</span>
					</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$serv[0]?>,3);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$serv[0]?>,3);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=3&pto=<?=$serv[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=3&pto=<?=$serv[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
				</div> 
        <div class="img_ser" style="width:35px; height:35px;margin-right: 5px; margin-top:5px; float:left">
						<img width="35" height="35" src="<?=$icono?>">
				</div> 

				
			
			
			</div>
				
				<?php
			}else
			{
				?>
			<div class="ser1">
      
      	<div class="des_resul">
      		<div onclick="levantarPopup('<?=$texto?>');addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>','<?=$texto?>','<?=$texto_mini?>');moverCentro(<?=$serv[3]?>,<?=$serv[4]?>,<?=$CM_ZOOM_SERV?>);">
      		<span class="span_result"><?=ucwords(utf8_encode(toponimos($serv[1])))?></span>
      		</br>
      		<?php
      		if(trim($serv[5])!="")
      		{
      		?>
						<span class="span_dir"><?=ucwords(utf8_encode(toponimos(strtolower($serv[5]))))?> #<?=$serv[6]?></span> 
						<br>
						<?php
					}
					?>
					<span class="span_comuna"><?=ucwords(utf8_encode(toponimos(strtolower($serv[7]))))?></span>
					</br>
					
					<span class="span_distancia">Distancia:<?=round($serv[8],2)?>Km</span>
					</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$serv[0]?>,3);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$serv[0]?>,3);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=3&pto=<?=$serv[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=3&pto=<?=$serv[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
      	</div>
        	<div class="img_ser" style="width:35px;margin-top:5px;margin-right: 5px; height:35px; float:left">
      		<img width="35" height="35" src="<?=$icono?>">
      	</div> 
      
     
      </div>
      
				
				<?php
			}
		}
		?>
		<script>
			
			verMarcadoresServicio();
		</script>
		<?php
	}
	//otros
	if(count($servicios)>0)
	{
	
		$estado_ses=estado_sesion();
		foreach($servicios as $i => $serv)
		{
			
			$categoria=$serv[2];			
			$texto ="<div id=titulo2>".strtoupper($serv[1])."</div>";
			$texto .="<div id=titulo4>".strtoupper($categoria)."</div>";
			if(trim($serv[5])!="" or trim($serv[6])!="")
			{
				$texto .="<div id=titulo5>".ucwords($serv[5])." #".$serv[6]."</div>";
			}
			$texto .="<div id=titulo6>".ucwords($serv[7])."</div>";
			$texto .="<div id=titulo3>Distancia: ".round($serv[8],2)."Km </div>";
			if(trim($serv[10])!="")
			{
				$texto .="<div id=titulo_descripcion>".utf8_decode($serv[10])."</div>";
			}
			
			$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$serv[0].",2);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$serv[0].",2);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace(**".$CM_path_base2."?ptot=2&pto=".$serv[0]."**);> <a href=**https://twitter.com/share?url=".$CM_path_base2."?ptot=2&pto=".$serv[0]."&via=chilemap&text=Revisa este link** target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
			
			$texto=elimina_acentos($texto);
			
			$texto_mini=ucwords(strtolower($serv[1]));
			
			
			
			$data_categoria=getServicioCategoria($serv[9]);
			$icono=$data_categoria[2];
			
			if(trim($icono)=="")
			{
				$icono=$CM_ICONO_SERV;
			}
			//$texto=ConsultaCaracteres($texto);
			?>
			<script>
				CM_busqueda[CM_busqueda.length]="<?=$serv[3]?>,<?=$serv[4]?>";
				CM_busqueda_texto[CM_busqueda_texto.length]="<?=$texto?>";
				CM_busqueda_icono[CM_busqueda_icono.length]='iconos/servicio.png';
				
				addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>',"<?=$texto?>","<?=$texto_mini?>");
			</script>
			
			<?php
			
			if($i % 2==0)
			{
				?>
				<div class="ser"> 
				
					
				<div class="des_resul">
					<div  onclick="levantarPopup('<?=$texto?>');addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>','<?=$texto?>','<?=$texto_mini?>');moverCentro(<?=$serv[3]?>,<?=$serv[4]?>,<?=$CM_ZOOM_SERV?>);">
					<span class="span_result"><?=ucwords(utf8_encode(toponimos($serv[1])))?></span>
					</br>
					<?php
      		if(trim($serv[5])!="" or trim($serv[6])!="")
      		{
      		?>
					<span class="span_dir"><?=ucwords(utf8_encode(toponimos(strtolower($serv[5]))))?> #<?=$serv[6]?></span> 
					<br>
					<?php
					}
					?>
					
					<span class="span_comuna"><?=ucwords(utf8_encode(toponimos(strtolower($serv[7]))))?></span>
					</br>
					<span class="span_distancia">Distancia:<?=round($serv[8],2)?>Km</span>
					</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$serv[0]?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$serv[0]?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=2&pto=<?=$serv[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=2&pto=<?=$serv[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
				</div> 
        <div class="img_ser" style="width:35px; height:35px;margin-right: 5px; margin-top:5px; float:left">
						<img width="35" height="35" src="<?=$icono?>">
				</div> 

				
			
			
			</div>
				
				<?php
			}else
			{
				?>
			<div class="ser1">
      
      	<div class="des_resul">
      		<div onclick="levantarPopup('<?=$texto?>');addMarcadorServicio('<?=$icono?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$serv[3]?>','<?=$serv[4]?>','<?=$texto?>','<?=$texto_mini?>');moverCentro(<?=$serv[3]?>,<?=$serv[4]?>,<?=$CM_ZOOM_SERV?>);">
      		<span class="span_result"><?=ucwords(utf8_encode(toponimos($serv[1])))?></span>
      		</br>
      		
					<?php
      		if(trim($serv[5])!="" or trim($serv[6])!="")
      		{
      		?>
					<span class="span_dir"><?=ucwords(utf8_encode(toponimos(strtolower($serv[5]))))?> #<?=$serv[6]?></span> 
					<br>
					<?php
					}
					?>
					<span class="span_comuna"><?=ucwords(utf8_encode(toponimos(strtolower($serv[7]))))?></span>
					</br>
					
					<span class="span_distancia">Distancia:<?=round($serv[8],2)?>Km</span>
					</div>
					<div id=botonera>
						<img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(<?=$estado_ses?>,<?=$serv[0]?>,2);>
						<img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(<?=$serv[0]?>,2);>
						<img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('<?=$CM_path_base2?>?ptot=2&pto=<?=$serv[0]?>');> 
						<a href='https://twitter.com/share?url=<?=$CM_path_base2?>?ptot=2&pto=<?=$serv[0]?>&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a>
					</div>
      	</div>
        	<div class="img_ser" style="width:35px;margin-top:5px;margin-right: 5px; height:35px; float:left">
      		<img width="35" height="35" src="<?=$icono?>">
      	</div> 
      
     
      </div>
      
				
				<?php
			}
		}
		?>
		<script>
			
			verMarcadoresServicio();
		</script>
		<?php
	}
	
	if($total_serv==0)
	{
		echo $CM_msg_servicio_no;
	}
	?>


<?PHP	
	
}

elseif($_REQUEST['tipo']==2)
{
	//echo "antenas";
	$datos=getAntenasExtend($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	foreach($datos as $dat)
	{
	?>
<script>
		//addMarcadorServicio('iconos/direccion.png','40,40',<?=$dat[1]?>,<?=$dat[2]?>,'Antena','');			
		addMarcadorOnDemand('iconos/antena.png','30,30',<?=$dat[1]?>,<?=$dat[2]?>,'Antena',100,'texto mini');			
</script>
	<?PHP
	}
	
}elseif($_REQUEST['tipo']==4)//servicios especificos
{
	//echo "antenas";
	$datos=getServicioExtend($_REQUEST['id'],$_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	//print_r($datos);
	if(count($datos)>0)
	{
		foreach($datos as $i => $dat)
		{
			$texto_mini=ucwords(strtolower(trim($dat[10])));
			$texto_html="<strong>".trim($dat[10])."</strong>";
			$texto_html .= "<br>".trim($dat[3])." ".trim($dat[4])."<br>".trim($dat[5])."";
			//echo "<br> ".$dat[1]." - ".$dat[2]."";
		?>
		<script>		
			addMarcadorOnDemand('<?=$_REQUEST['icono']?>','30,30',<?=$dat[1]?>,<?=$dat[2]?>,'<?=$texto_html?>',<?=$_REQUEST['id_serv']?>,'<?=$texto_mini?>');			
			</script>
		<?PHP
		}
	}
	
}elseif($_REQUEST['tipo']==5) //manzanas
{
	//echo "antenas";
	$datos=getManzanasExtend($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
		foreach($datos as $d)
		{
			$data=$d[8];
			//echo "<br>".$data;
			$data=str_replace("MULTIPOLYGON(((","",trim($data));
			$data=str_replace(")))","",$data);
			$data=str_replace(",","|",$data);
			$data=str_replace(" ",",",$data);
			$texto="<div id=titulo2>DATOS MANZANA</div><br>";
			$texto.="<div id=titulo5>Estrato Social: ".$d[7]."</div>";
			
			
			if(is_numeric($d[11]))
			{
				//$texto.="<br>Hombres: ".$d[11]."";
			}
			if(is_numeric($d[12]))
			{
			//	$texto.="<br>Mujeres: ".$d[12]."";
			}
			$texto.="<div id=titulo5>Total Hogares: ".$d[6]."</div>";
			if(is_numeric($d[9]))
			{
				$texto.="<div id=titulo5>Total Personas: ".$d[9]."</div>";
			}
  		
  		//$texto.="<br><div class=txt_minimo>Datos obtenidos desde INE</div>";
			
  	
			//echo "<br><br>".$data;
			?>
			
				
			<?php
			if(strtolower($d[7])=="e")
			{
				?>
				opt_style=CM_myStyles;
			<?PHP
			}elseif(strtolower($d[7])=="d")
			{
				?>
				opt_style=CM_myStyles2;
			<?PHP
			}elseif(strtolower($d[7])=="c2")
			{
				?>
				opt_style=CM_myStyles3;
			<?PHP
			}elseif(strtolower($d[7])=="c3")
			{
				?>
				opt_style=CM_myStyles4;
			<?PHP
			}elseif(strtolower($d[7])=="abc1")
			{
				?>
				opt_style=CM_myStyles5;
			<?PHP
			}else
			{
				?>
				opt_style=CM_myStyles_default;
			<?PHP
			}
			?>
				addPoligono('<?=$data?>','<?=$texto?>',opt_style);	
			<?PHP
  	
		}
	}
	?>
		
		hideLoad();

	<?PHP
	
	
}
elseif($_REQUEST['tipo']==6)//servicios especificos
{
	$datos=getServicioExtend($_REQUEST['id'],$_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
		foreach($datos as $i => $dat)
		{
			$texto_mini=ucwords(strtolower(trim($dat[10])));
  	  $texto_html="<strong>".trim($dat[10])."</strong>";
			$texto_html .= "<br>".trim($dat[3])." ".trim($dat[4])."<br>".trim($dat[5])."";			
			$texto_html ="<div id=titulo2>".strtoupper($dat[10])."</div>";
			$texto_html .="<div id=titulo4>".strtoupper($dat[9])."</div>";
			if(trim($dat[3])!="" or trim($dat[4])!="")
			{ 
				$texto_html .="<div id=titulo5>".ucwords($dat[3])." #".$dat[4]."</div>";
			}
			$texto_html .="<div id=titulo6>".ucwords($dat[5])."</div>";			
			if(trim($dat[11])!="")
			{
				$texto_html .="<div id=tit_descrip>".$dat[11]."</div>";
			}

			//$texto_html .="<div id=botonera><img class=img_boton src=images/favorito.png title='Agregar a favoritos'><img class=img_boton src=images/mail.png title='Enviar por correo'><img class=img_boton src=images/facebook.png title='Compartir en Facebook' onclick='javascript:compartirFace();'> <img class=img_boton src=images/twitter.png title='Compartir en Twitter'></div>";
			
			//$texto_html="test";
		?>
		
			
			addMarcadorOnDemand('<?=$_REQUEST['icono']?>','<?=$CM_SIZE_ICONO_MAPA_SERV_ODM?>',<?=$dat[1]?>,<?=$dat[2]?>,"<?=$texto_html?>",<?=$_REQUEST['id_serv']?>,"<?=$texto_mini?>");			
		
		<?PHP
		}
		?>
		
			$("#cont_otro").html("");
		
		<?php
	}
	?>
	hideLoad();
	<?php
	
	
}elseif($_REQUEST['tipo']==7) //ParaderosTransantiago
{

	
	$datos=getTransantiagoParaderos($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
				?>
		<script>

			
			total_all=parseInt(<?=count($datos)?>);
			if(total.search("Total")>=0)
			{
				total=replaceAll(total,'Total:','');
				total=replaceAll(total,'(','');
				total=replaceAll(total,')','');
				var tot=parseInt(<?=count($datos)?>);
				
				total_all= parseInt(total) + parseInt(tot);
			}
			$("#cont_otro").html("Total:("+total_all+")");
			var html_contenido=$("#resultados_c").html();
			
			if(html_contenido.search("Busca")>=0)
			{
				html_contenido="";
			}
			
			var html_cont ="<div id=titulo_resultado>PARADEROS TRANSANTIAGO</div>";
			</script>
		<?php
		//print_r($datos);
		foreach($datos as $d)
		{
			$texto_mini=strtoupper($d[4]);
			$texto_html='<div id=titulo10>'.strtoupper($d[4]).'</div>';
			$texto_html .='<div id=titulo11>'.ucwords(utf8_decode($d[1])).'</div>';
			$texto_html .='<div id=titulo12>Parada de:</div>';
			$texto_html .='<div id=parada_trans>';
			//$texto_html .=strtoupper($d[5]);
			$data_parada=explode(",",$d[5]);
		  //print_r($data_parada);
		  
			foreach($data_parada as $dat)
			{
				
				//$color=getDataRuta($dat);
				
				//style=color:#'.$color[0].'
				$texto_html .='<p>'.strtoupper($dat).'</a> <input type=button onclick=javascript:deleteLineas();getRecorrido([b]\"[/b]'.$dat.'[b]\"[/b],[b]\"[/b]i[b]\"[/b]); value=Ida class=btn_pop><input type=button value=Regreso class=btn_pop onclick=javascript:deleteLineas();getRecorrido([b]\"[/b]'.$dat.'[b]\"[/b],[b]\"[/b]r[b]\"[/b]);>';
			}
			$texto_html .='</div>';
			$texto_html .='<div id=final_data><p>Datos Recolectados desde datos.gob.cl</p></div>';
			
			
			
			?>
			
				<!--div class="ser"> 
				<div id="link_" onclick='javascript:moverCentro("<?=$d[2]?>","<?=$d[3]?>",18);levantarPopup("<?=$texto_html?>");'>
					<div class="des_resul">
							<span class="span_result"><?=strtoupper($d[4])?></span>
								<span class="span_dir"><?=ucwords($d[1])?></span>
					</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
								<img width="35" height="35" src="<?=$CM_ICONO_TRANSANTIAGO?>">
					</div> 
				</div>
				</div-->
			
			<script>
				html_cont +="<div class='ser'> <div id='link_' onclick=javascript:moverCentro('<?=$d[2]?>','<?=$d[3]?>',18);>	<div class=des_resul>	<span class=span_result><?=strtoupper($d[4])?></span><span class=span_dir><?=$d[1]?></span>	</div> <div class=img_ser style='width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left'><img width=35 height=35 src=<?=$CM_ICONO_TRANSANTIAGO?>></div> </div></div>";
				addMarcadorServicio('<?=$CM_ICONO_TRANSANTIAGO?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$d[2]?>','<?=$d[3]?>','<?=$texto_html?>','<?=$texto_mini?>');
				</script>
			<?php
			
		}
		?>
		<script>
			$("#resultados_c").html(html_cont+"<br>"+html_contenido);
		</script>

		<?php
	}
}elseif($_REQUEST['tipo']==8) //lineas ruta x
{
	$data=getRutasLinea($_REQUEST['ruta'],$_REQUEST['origen']);
	//print_r($data);
  $lonlat_inicio=explode(",",$data[0]);
	$lonlat_termino=explode(",",$data[count($data)-1]);

	$data_geo=implode("|",$data);
	?>
	<script>
		deleteMarkerDireccion();
		addLinea('<?=$data_geo?>');
	  addMarcador('iconos/inicio.png','<?=$CM_SIZE_ICONO_MAPA?>','<?=$lonlat_inicio[1]?>','<?=$lonlat_inicio[0]?>','','Inicio Recorrido <?=strtoupper($_REQUEST["ruta"])?>');
		addMarcador('iconos/termino.png','<?=$CM_SIZE_ICONO_MAPA?>','<?=$lonlat_termino[1]?>','<?=$lonlat_termino[0]?>','','Termino Recorrido <?=strtoupper($_REQUEST["ruta"])?>');

	</script>
	<?php
}elseif($_REQUEST['tipo']==9) //servicios pagos
{
	//echo "aqui";
	$datos=getServicioExtendPagos($_REQUEST['id'],$_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	
	if(count($datos)>0)
	{
		?>
		<script>
			total_all=parseInt(<?=count($datos)?>);
			if(total.search("Total")>=0)
			{
				total=replaceAll(total,'Total:','');
				total=replaceAll(total,'(','');
				total=replaceAll(total,')','');
				var tot=parseInt(<?=count($datos)?>);
				//alert(parseInt(total)+"-" + parseInt(tot));
				total_all= parseInt(total) + parseInt(tot);
				
			}
			$("#cont_otro").html("Total:("+total_all+")");
			
			var html_contenido=$("#resultados_c").html();
			if(html_contenido.search("Busca")>=0)
			{
				html_contenido="";
			}
			var html_cont ="<div id=cont_res_<?=$_REQUEST['id_serv']?>><div id=titulo_resultado><?=strtoupper($datos[0][9])?></div>";
		</script>
		
		<?php
		foreach($datos as $i => $dat)
		{
			
			$texto_mini=ucwords(strtolower(trim($dat[10])));
			
  	  			
			$texto_html ="<div id=titulo2>".strtoupper($dat[10])."</div>";
			$texto_html .="<div id=titulo4>".strtoupper($dat[9])."</div>";			
			if(trim($dat[3])!="")
			{
				$texto_html .="<div id=titulo5>".ucwords($dat[3])." #".$dat[4]."</div>";
			}
			$texto_html .="<div id=titulo6>".ucwords($dat[5])."</div>";			
			$texto_html .="<div id=tit_descrip>".ucwords(trim($dat[11]))."</div>";
			if(trim($dat[3])!="")
			{
				$direccion=ucwords($dat[3])." #".$dat[4].", ".$dat[5];
			}else
			{
				$direccion="<br><br><br>".$dat[5];
			}
			
			
		?>
		
			<script>
				html_cont +="<div class='ser'> <div id='link_' onclick=javascript:moverCentro('<?=$dat[1]?>','<?=$dat[2]?>',18);>	<div class=des_resul>	<span class=span_result><?=strtoupper($dat[10])?></span><span class=span_dir><?=$direccion?></span>	</div> <div class=img_ser style='width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left'><img width=35 height=35 src=<?=$dat[12]?>></div> </div></div>";
				addMarcadorOnDemandPago('<?=$dat[12]?>','<?=$CM_SIZE_ICONO_MAPA_SERV_ODM?>',<?=$dat[1]?>,<?=$dat[2]?>,"<?=$texto_html?>",<?=$_REQUEST['id_serv']?>,"<?=$texto_mini?>");			
			</script>
		
		<?PHP
		}
		?>
		<script>
			
			$("#resultados_c").html(html_cont+"<br>"+html_contenido+"</div>");
			</script>
		<?php

	}
}elseif($_REQUEST['tipo']==10) //servicios pagos > zoom 15
{
	//echo "aqui";
	$datos=getServicioExtendPagosFull($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	
	if(count($datos)>0)
	{
		foreach($datos as $i => $dat)
		{
			
			$texto_mini=ucwords(strtolower(trim($dat[10])));
			$data_cat=getServicioCategoria($dat[0]);
  	  if($data_cat[3]==5)//autorizado
  	  {
				$texto_html ="<div id=titulo2>".strtoupper($dat[10])."</div>";
				$texto_html .="<div id=titulo4>".strtoupper($dat[9])."</div>";			
				$texto_html .="<div id=titulo5>".ucwords($dat[3])." #".$dat[4]."</div>";
				$texto_html .="<div id=titulo6>".ucwords($dat[5])."</div>";			
				$texto_html .="<div id=tit_descrip>".ucwords(trim($dat[11]))."</div>";
				$direccion=ucwords($dat[3])." #".$dat[4].", ".$dat[5];
			
			
				?>
		
				<script>
			
					addMarcadorOnDemandPago('<?=$data_cat[2]?>','<?=$CM_SIZE_ICONO_MAPA_SERV_ODM_FULL?>',<?=$dat[1]?>,<?=$dat[2]?>,"<?=$texto_html?>",100,"<?=$texto_mini?>");			
				</script>
		
				<?PHP
			}
		}
	}
}elseif($_REQUEST['tipo']==11) //farmacias de turno
{

	
	$datos=getFarmaciasTurno($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
				?>
		<script>

			
			total_all=parseInt(<?=count($datos)?>);
			if(total.search("Total")>=0)
			{
				total=replaceAll(total,'Total:','');
				total=replaceAll(total,'(','');
				total=replaceAll(total,')','');
				var tot=parseInt(<?=count($datos)?>);
				
				total_all= parseInt(total) + parseInt(tot);
			}
			$("#cont_otro").html("Total:("+total_all+")");
			var html_contenido=$("#resultados_c").html();
			
			if(html_contenido.search("Busca")>=0)
			{
				html_contenido="";
			}
			
			var html_cont ="<div id=titulo_resultado>Farmacias de turno</div>";
			</script>
		<?php
		//print_r($datos);
		foreach($datos as $d)
		{
			$texto_mini=strtoupper($d[0]);
			$texto_html='<div id=titulo10>'.strtoupper(trim($d[0])).'</div>';
			$texto_html .='<div id=titulo11>'.ucwords(utf8_decode(trim($d[5]))).', '.ucwords(utf8_decode(trim($d[7]))).'</div>';
			$texto_html .='<div id=titulo12>Fecha Turno:'.trim($d[1]).'</div>';
			$texto_html .='<div id=titulo12>'.trim($d[6]).'</div>';		
			?>
			
				<!--div class="ser"> 
				<div id="link_" onclick='javascript:moverCentro("<?=$d[2]?>","<?=$d[3]?>",18);levantarPopup("<?=$texto_html?>");'>
					<div class="des_resul">
							<span class="span_result"><?=strtoupper($d[4])?></span>
								<span class="span_dir"><?=ucwords($d[1])?></span>
					</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
								<img width="35" height="35" src="<?=$CM_ICONO_TRANSANTIAGO?>">
					</div> 
				</div>
				</div-->
			
			<script>
				html_cont +="<div class='ser'> <div id='link_' onclick=javascript:moverCentro('<?=$d[3]?>','<?=$d[4]?>',18);>	<div class=des_resul>	<span class=span_result><?=strtoupper($d[0])?></span><span class=span_dir><?=$d[7]?></span>	</div> <div class=img_ser style='width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left'><img width=35 height=35 src=<?=$CM_ICONO_FARMACIA?>></div> </div></div>";
				//addMarcadorServicio('<?=$CM_ICONO_FARMACIA?>','<?=$CM_SIZE_ICONO_MAPA?>','<?=$d[3]?>','<?=$d[4]?>','<?=$texto_html?>','<?=$texto_mini?>');
				addMarcadorOnDemand('<?=$CM_ICONO_FARMACIA?>','<?=$CM_SIZE_ICONO_MAPA?>',<?=$d[3]?>,<?=$d[4]?>,'<?=$texto_html?>',0,'<?=$texto_mini?>');			
				</script>
			<?php
			
		}
		?>
		<script>
			$("#resultados_c").html(html_cont+"<br>"+html_contenido);
		</script>

		<?php
	}
}

}
?>
