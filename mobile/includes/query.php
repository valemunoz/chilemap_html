<?php
include("../../includes/funciones.php");
require_once("Mobile_Detect.php");
$CM_path_base="http://localhost/chilemap_html/mobile/";
$CM_path_base2="http://localhost/chilemap_html/mobile/index.php";
$CM_path_web="http://www.chilemap.cl/index_mapa.php";
//$CM_path_base="http://www.chilemap.cl/mobile/";
//$CM_path_base2="http://www.chilemap.cl/mobile/index.php";

$CM_ICONO_TRANSANTIAGO="img/bus2.png";
$CM_ICONO_SERV="img/marker.png";
$CM_ICONO_DIR="img/direc.png";
$pagina_home="index.php";
$CM_path_activa_mail="http://www.chilemap.cl/activa.php";
$CM_PATH_REENVIO_CONF="http://www.chilemap.cl/confirmacion.php?mail=CM_MAIL";
$CM_path_re_activa_mail="http://www.chilemap.cl/reactiva.php";
$CM_ZOOM_DIR=15;

/*MSG REGISTRO USUARIO*/
$CM_USUARIO_REGISTRADO="Lo sentimos pero tu mail ya est&aacute; registrado.";
$CM_USUARIO_ESPERA_ACTIVACION="Ya estas registrado!, estamos esperando que confirmes tu direcci&oacute;n de correo.<br><br>Quieres que te reenviemos el correo de confirmaci&oacute;n? <a href='".$CM_PATH_REENVIO_CONF."'>Haz click AQUI</a>.";
$CM_USUARIO_INACTIVO="Lo sentimos pero tu mail ya est&aacute; registrado e inactivo. Quieres volver a activar tu cuenta? <a href='".$CM_path_re_activa_mail."?mail=_MAIL_'>Haz click AQUI</a>";
$CM_USUARIO_NO_REG="Lo sentimos pero no estas registrado en nuestro sitio.";
$CM_USUARIO_REG_OK="<strong>Bienvenido a la familia ChileMap!</strong><br><br>Te enviamos un correo para confirmar tu direcci&oacuten.<br><br><br>Equipo ChileMap!";

$CM_USUARIO_EDIT="<strong>Cambios realizados!</strong>";
$CM_USUARIO_CLOSE="<strong>Es una l&aacute;stima! esperamos verte pronto!</strong>";

/*FIN*/
/*MSG INICIO SESION*/
$CM_INICIO_CLAVE="Tu correo o clave no coincide con nuestros registros, por favor int&eacute;ntalo nuevamente.";
$CM_INICIO_ESPERA_ACT="Lo sentimos pero no puedes iniciar sesi&oacute;n hasta que confirmes el mail enviado luego del registro.<br>Necesitas que lo enviemos nuevamente? <a href='javascript:onclick:msgActivacion();'>haz click aqui</a>";
$CM_INICIO_CTA_INACTIVA="Lo sentimos pero no puedes iniciar sesi&oacute;n, tu cuenta esta inactiva. <a href='".$CM_path_re_activa_mail."?mail=_MAIL_'>Quieres activarla nuevamente? haz click aqu&iacute;</a>";
$CM_MSG_REENV_CONF="Hemos enviado un mail para que confirmemos tu cuenta de correo. <br>Por favor revisa tu bandeja de entrada o SPAM.";

/*FIN*/
/*MSG CONTACTO*/
$CM_MSG_RECIBIDO="Hemos recibido tu mensaje, nos pondremos en contacto lo antes posible.<br><br><br>Equipo Chilemap.cl";
$CM_MSG_ERROR="Ocurri&oacute; un error, por favor int&eacute;ntelo mas tarde.";
/*FIN*/
/*MSG OLVIDO*/
$CM_MSG_OLVIDO_ENV="Hemos enviado un correo con tu cotrase&ntildea.";
$CM_MSG_OLVIDO_NOUSER="Lo sentimos pero el mail no est&aacute; registrado en nuestro sitio.";
/*FIN*/
/*Mail*/
$CM_MAIL_CONTACTO_US="Hemos recibido tu mensaje, nos pondremos en contacto lo antes posible.<br><br><br><img src='".$CM_path_logo."'><br><strong>Equipo de Chilemap.cl</strong>";
$CM_MAIL_OLVIDO="Hola<br><br> Haz solicitado recuperar tu contraseña y esta es:<br><br><strong>US_CONTRASENA</strong><br><br><img src='".$CM_path_logo."'><br><strong>Equipo de Chilemap.cl</strong>";
$CM_MAIL_CONFIRMACION='Hola!<br><br> Este correo es para confirmar tu direcci&oacute;n de Email ingresado en el sitio chilemap.cl, por favor haz click en el link <br> m&aacute;s adelante para confirmar tu correo y terminar con el registro.<br> URL_CONF <br><br><br><img src="'.$CM_path_logo.'"><br><strong>Equipo de Chilemap.cl</strong>';
/*FIN*/

$CM_msg_mail_ok="El mail ha sido enviado.";
$CM_msg_mail_err="Lo sentimos ha ocurrido un error. Por favor int&eacute;talo nuevamente.";
$CM_mail="_NOMBRE_ ha compartido un link contigo. <br><br> Haz click en este link para verlo <a href='_LINK_'>Link chilemap.cl</a><br><br>Equipo Chilemap.cl";

$CM_ERROR_GENERAL="Lo sentimos pero no entendemos tu solicitud <a href='".$CM_path_base."'>Volver al Home</a>";

$CM_msg_direccion_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para direcciones.</div>";
$CM_msg_servicio_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para puntos.</div>";
$estado_sesion=estado_sesion();

$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$data_server= explode("?",$_SERVER['REQUEST_URI']);
if($deviceType=="computer")
{
	?>
		<script>
			//window.location="<?=$CM_path_web?>?<?=$data_server[1]?>";
	</script>
	<?php
	
}
$data_server= explode("?",$_SERVER['HTTP_REFERER']);
//echo "".strtolower($data_server[0])."==".$CM_path_base2." or ".strtolower($data_server[0])."==".$CM_path_base."";
if(strtolower($data_server[0])==$CM_path_base2 or strtolower($data_server[0])==$CM_path_base or strtolower($data_server[0])=="http://".substr($CM_path_base,11) or strtolower($data_server[0])=="http://".substr($CM_path_base2,11))
{
	if($_REQUEST['tipo']==1)
	{
		
	}elseif($_REQUEST['tipo']==2)
	{
		$dat=getDireccionGoogleLATLON($_REQUEST['lat'],$_REQUEST['lon']);
		$num=explode("-",$dat[0][2]);
		?>
		<script>
			SIS_CALLE="<?=$dat[0][3]?>";
			SIS_NUM="<?=trim($num[0])?>";
			SIS_COMUNA="<?=$dat[0][4]?>";
			var txt ="Cerca de: <?=$dat[0][3]?> #<?=$dat[0][2]?>,<?=$dat[0][4]?>";
			$("#text_sup").html(txt);
			</script>
		<?php
		
	}elseif($_REQUEST['tipo']==3)
	{
		$query=trim($_REQUEST['query']);
		
		$query=str_replace("#","",$query);
		$query=str_replace(" , "," ",$query);
		
		$query=str_replace(", "," ",$query);
		$query=str_replace(" ,"," ",$query);
		$query=str_replace(","," ",$query);
  	$query =strtolower(elimina_acentos(utf8_decode($query)));	
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
	?>
	<script>
		$( '#tot_pto' ).html( '(<?=$total_serv?>)' );
		</Script>
	<?php
		foreach($servicios_pagos as $i => $serv)
	{
		$dir=ucwords($serv[5])." ".$serv[6].", ".ucwords($serv[7]);
		$texto="<div class=titulo>".ucwords($serv[1])."</div>";
		$texto .="<div class=titulo_pop2>".ucwords($serv[2])."</div>";
		$texto .="<div class=titulo_pop3>".ucwords($dir)."</div>";      
		if(trim($serv[10])!="")
		{
			 $texto .="<div class=titulo_pop_descrip>".ucwords($serv[10])."</div>";
		}
		$texto .="<div class=titulo_pop3>Distancia: ".round($serv[8],2)."Km</div>";
		
		$texto .="<div id=botonera><img class=img_boton src=img/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_sesion.",".$serv[0].",3);><img class=img_boton src=img/mail.png title=Enviar por correo onclick=compartirPto(".$serv[0].",3);> <img class=img_boton src=img/facebook.png title=Compartir en Facebook onclick=compartirFace(".$serv[0].",1);><a href=https://twitter.com/share?url=".$CM_path_web."?ptot=1&pto=".$serv[0]."&via=chilemap&text=Revisa este link target=_BLANK><img  class=img_boton src=img/twitter.png title=Compartir en Twitter></a></div>"; 
		$data_categoria=getServicioCategoria($serv[9]);
		$icono=$data_categoria[2];
			
			if(trim($icono)=="")
			{
				$icono=$CM_ICONO_SERV;
			}
		
		?>
		
		
			<li><a href="javascript:verMapa('<?=$texto?>',<?=$serv[4]?>,<?=$serv[3]?>,'<?=$icono?>');">
        <span class=tit_pto><?=ucwords(substr(ucwords($serv[1]),0,20))?></span>
        <p class=mini_txt><?=$dir?></p>        
        <p class="ui-li-aside"><strong><?=round($serv[8],2)?>km</strong></p>
    		</a></li>
	</li>
		<?php
	}
	foreach($servicios as $i => $serv)
	{
		$dir=ucwords($serv[5])." ".$serv[6].", ".ucwords($serv[7]);
		$texto="<div class=titulo>".ucwords($serv[1])."</div>";
		$texto .="<div class=titulo_pop2>".ucwords($serv[2])."</div>";
		$texto .="<div class=titulo_pop3>".ucwords($dir)."</div>";
		if(trim($serv[10])!="")
		{
			$texto .="<div class=titulo_pop_descrip>".ucwords($serv[10])."</div>";
		}
		$texto .="<div class=titulo_pop3>Distancia: ".round($serv[8],2)."Km</div>"; 
		$texto .="<div id=botonera><img class=img_boton src=img/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_sesion.",".$serv[0].",2);><img class=img_boton src=img/mail.png title=Enviar por correo onclick=compartirPto(".$serv[0].",2);> <img class=img_boton src=img/facebook.png title=Compartir en Facebook onclick=compartirFace(".$serv[0].",1);><a href=https://twitter.com/share?url=".$CM_path_web."?ptot=1&pto=".$serv[0]."&via=chilemap&text=Revisa este link target=_BLANK><img  class=img_boton src=img/twitter.png title=Compartir en Twitter></a></div>"; 
		$icono='img/marker.png';
		?>
		
		
			<li><a href="javascript:verMapa('<?=$texto?>',<?=$serv[4]?>,<?=$serv[3]?>,'<?=$icono?>');">
        <span class=tit_pto><?=ucwords(substr(ucwords($serv[1]),0,20))?></span>
        <p class=mini_txt><?=$dir?></p>
        
        <p class="ui-li-aside"><strong><?=round($serv[8],2)?>km</strong></p>
    		</a></li>
	</li>
		<?php
	}
	
	}elseif($_REQUEST['tipo']==4)
	{
	$datos=getServicioExtend($_REQUEST['id'],$_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
		foreach($datos as $i => $dat)
		{
			$dir=$dat[3]." ".$dat[4];
		$texto="<div class=titulo>".strtoupper($dat[10])."</div>";
		$texto .="<div class=titulo_pop2>".ucwords($dat[9])."</div>";
		$texto .="<div class=titulo_pop3>".ucwords($dir)."</div>";
		if(trim($dat[11])!="")
		{
			$texto .="<div class=titulo_pop_descrip>".ucwords($dat[11])."</div>";
		}
		$texto .="<div class=titulo_pop3>".ucwords($dat[5])."</div>"; 
		if($dat[0]==32)
		{
			$fec=getFechaLibre(15);
			$fecha=getFecha();
			
			$detalle1=getDetalleServ(" and id_servicio=".$dat[12]." and texto4='1' and fecha_registro >='".$fec."' order by fecha_registro desc limit 1"); //dinero
			$detalle2=getDetalleServ(" and id_servicio=".$dat[12]." and texto4='2' and fecha_registro >='".$fec."'  order by fecha_registro desc limit 1"); //habilitado
			if(count($detalle1) ==0)
			{
				
				$est_d="No hay registro";
			}else
			{
				
				$tiempo= segundos($detalle1[0][7],$fecha);
				if($tiempo/60 < 60)
				{
					$txt_mini="Hace ".($tiempo/60)." min";
				}else
				{
					$tot=($tiempo/60);
					$tot=round($tot/60,2);
					$txt_mini="Hace ".$tot." hrs";
				}
				$est_d=" ".$detalle1[0][3]." <span class=titulo_mini>(".$txt_mini.")</span>";
				
				
			}
			if(count($detalle2) ==0)
			{
				$est_c="No hay registro";
				
			}else
			{
				$tiempo= segundos($detalle2[0][7],$fecha);
				if($tiempo/60 < 60)
				{
					$txt_mini="Hace ".($tiempo/60)." min";
				}else
				{
					$tot=($tiempo/60);
					$tot=round($tot/60,2);
					$txt_mini="Hace ".$tot." hrs";
				}
				$est_c=" ".$detalle2[0][3]." <span class=titulo_mini>(".$txt_mini.")</span>";
				
			}
			
			$texto .="<hr><div class=titulo_pop40>Cajero habilitado:  ".$est_c."</div>"; 
			$texto .="<div class=titulo_pop40><hr>Hay dinero: ".$est_d."</div>"; 
			$texto .="<div class=titulo_mini>*La consulta es menor a 12 horas</div>"; 				
			$texto .="<div class=titulo_pop_descrip> <strong>Ayuda a la comunidad!</strong>";
			$texto .="<br>El cajero esta habilitado? <br><input type='button' value='Si' class='btn_pop' onclick='addDescripCajero(2,0,".$dat[12].");'> <input type='button' value='No' class='btn_pop' onclick='addDescripCajero(2,1,".$dat[12].");'>";
			$texto .="<br>El cajero cuenta con dinero? <br><input type='button' value='Si' class='btn_pop' onclick='addDescripCajero(1,0,".$dat[12].");'> <input class='btn_pop' type='button' value='No' onclick='addDescripCajero(1,1,".$dat[12].");'>";
			$texto .="</div>";
			$texto .="<div class=titulo_pop3  id=mini_resp></div>";
		}
		//$texto .="<div id=botonera><img class=img_boton src=img/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_sesion.",".$dat[0].",3);><img class=img_boton src=img/mail.png title=Enviar por correo onclick=compartirPto(".$dat[0].",3);> <img class=img_boton src=img/facebook.png title=Compartir en Facebook onclick=compartirFace(".$dat[0].");><a href=https://twitter.com/share?url=".$CM_path_web."?ptot=1&pto=".$dat[0]."&via=chilemap&text=Revisa este link target=_BLANK><img  class=img_boton src=img/twitter.png title=Compartir en Twitter></a></div>"; 
			
	
		?>
		
			
			<script>
			addMarcadoresOndemand(<?=$dat[2]?>,<?=$dat[1]?>,"<?=$texto?>",'<?=$_REQUEST['icono']?>',30,30,<?=$_REQUEST['id_serv']?>);
		</script>
		<?PHP
		}
	}
	}elseif($_REQUEST['tipo']==5)
	{
			
	$datos=getTransantiagoParaderos($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);



	if(count($datos)>0)
	{
		//print_r($datos);
		foreach($datos as $d)
		{
				$texto="<div class=titulo>".strtoupper($d[4])."</div>";
				$texto .="<div class=titulo_pop2>".ucwords(utf8_decode($d[1]))."</div>";
		$texto .='<div id=titulo_pop3>Parada de:</div>';
		$texto .=strtoupper($d[5]);
			
			$texto .='</div>';
			$texto .='<div class=span_nota>Datos Recolectados desde datos.gob.cl</div></div>';
			
			
			
			?>
			
				<li onclick="javascript:moverCentro('<?=$d[2]?>','<?=$d[3]?>',17);"><img class="ui-li-icon ui-corner-none" src="<?=$CM_ICONO_TRANSANTIAGO?>"><?=strtoupper($d[4])?></li>
			
			<script>
				
				addMarcadoresOtros('<?=$d[3]?>','<?=$d[2]?>','<?=$texto?>','<?=$CM_ICONO_TRANSANTIAGO?>',30,30)
				</script>
			<?php
			
		}
		?>
		<script>
			//$('#resul_otros').listview('refresh');
			</script>
		<?php
	}
		
	}elseif($_REQUEST['tipo']==6)
	{
		$estado_sesion=estado_sesion();
		
		if($estado_sesion!=0 )
		{
			//cerrar_sesion();
			?>
							<script>
								//cerrarSesion();
								$("#ll_iniciar").show();
								$("#ll_reg").show();
								$("#cont_favoritos").html("");
								$("#ll_cerrar").hide();
							</script>
		<?php
		
		}else
		{
			
			?>
			<script>
				loadCategorias();
				loadFavoritos();
				$("#text_supIz").html("Bienvenido <?=ucwords($_SESSION['nombre'])?>");
				$("#ll_iniciar").hide();
				$("#ll_reg").hide();
				$("#ll_cerrar").show();
				</Script>
			<?php
		}


					
		
	}elseif($_REQUEST['tipo']==7)//inicio sesion
	{
			$usuario=getUsuario($_REQUEST['mail'],10);
	if(count($usuario)>0)
	{
		if($usuario[7]==0 and $usuario[5]==$_REQUEST['clave'])
		{
			inicioSesion($_REQUEST['mail'],$usuario[2],$usuario[0]);
			?>
			<script>
			//closeModalInicio();
			window.location.href="<?=$pagina_home?>";
			</script>
			<?PHP
			
			
		}elseif($usuario[7]==0 and $usuario[5]!=$_REQUEST['clave'])
		{
			$msg=$CM_INICIO_CLAVE;
		}
		if($usuario[7]==1)
		{
			$msg=str_replace("CM_MAIL",$_REQUEST['mail'],$CM_INICIO_ESPERA_ACT);
			
		}
	  if($usuario[7]==2)
			
			$msg=str_replace("_MAIL_",$_REQUEST['mail'],$CM_INICIO_CTA_INACTIVA);
	}else
	{		
		$msg=$CM_USUARIO_NO_REG;
		
	}
	?>
	<script>
		$( "#msg_error_reg" ).html("<?=$msg?>");
	 	</script>
		<?PHP
	}elseif($_REQUEST['tipo']==8)
{
	cerrar_sesion();
}elseif($_REQUEST['tipo']==9)
	{
		$estado_sesion=estado_sesion();
		if($estado_sesion==0)
		{
			
			?>
							<script>
								window.location.href="home.html";
							</script>
		<?php
		
		}
	}elseif($_REQUEST['tipo']==10)
	{
		
		$query=trim($_REQUEST['query']);
		
		$query=str_replace("#","",$query);
		$query=str_replace(" , "," ",$query);
		
		$query=str_replace(", "," ",$query);
		$query=str_replace(" ,"," ",$query);
		$query=str_replace(","," ",$query);
  	$query =strtolower(elimina_acentos(utf8_decode($query)));	
		$query=str_replace("'","",$query);
		$query=str_replace('"',"",$query);
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
			$calle=array();
			$num=array();
			$com=array();
			$lon=array();
			$lat=Array();
			$tip=array();
			$direc=array();
			$data=getDireccionExacta(urldecode($query),10);
			if(count($data)>0)
			{
				foreach($data as $dat)
				{
					$calle[]=$dat[1];
					$num[]=$dat[3];
					$com[]=$dat[4];
					$lat[]=$dat[6];
					$lon[]=$dat[7];
					$tip[]=$dat[9];
					$direc[]=$dat[0];
				}
			
			}else
			{
				$data=buscarDireccionOSM($query." chile");
				if(count($data)>0)
				{
					foreach($data as $dat)
					{
						$calle[]=$dat[3];
						$num[]=$dat[2];
						$com[]=$dat[4];
						$lat[]=$dat[1];
						$lon[]=$dat[0];
						$tip[]=3;
						$dir=array();
						$dir[]=$dat[3];
						$dir[]=$dat[2];
						$dir[]=$dat[4];
						$dir[]=$dat[6];//region
						$dir[]=$dat[7];//lat
						$dir[]=$dat[8];//lon
						$dir[]=ucwords("".$dat[3]." ".$dat[2]." ".$dat[4]." ".$dat[6]." ");//completa
						addDireccion($dir,3);
						$id_pto=getIdDireccionXLatLon($dat[7],$dat[8]);
						$direc[]=$id_pto;
				
					}
					
				}else
				{
					$data=getDireccionGoogle($query." chile");
					if(count($data)>0)
					{
						foreach($data as $dat)
						{
							$calle[]=$dat[3];
							$num[]=$dat[2];
							$com[]=$dat[4];
							$lat[]=$dat[7];
							$lon[]=$dat[8];
							$tip[]=2;
							$dir=array();
						$dir[]=$dat[3];
						$dir[]=$dat[2];
						$dir[]=$dat[4];
						$dir[]=$dat[6];//region
						$dir[]=$dat[7];//lat
						$dir[]=$dat[8];//lon
						$dir[]=ucwords("".$dat[3]." ".$dat[2]." ".$dat[4]." ".$dat[6]." ");//completa
						addDireccion($dir,3);
						$id_pto=getIdDireccionXLatLon($dat[7],$dat[8]);
						$direc[]=$id_pto;
						}
					}else
					{
						?>
						<script>
							mensaje("No hay resultados para la busqueda","myPopup");
							</script>
						<?php
					}
				}
			
			}
			if(count($calle)>0)
			{
				
				foreach($calle as $i => $cal)
				{
					$dir=ucwords($cal)." #".$num[$i].", ".ucwords($com[$i]);
					$texto="<div class=titulo>Direcci&oacute;n</div>";
					$texto .="<div class=titulo_pop>".ucwords($cal)." ".$num[$i].", ".ucwords($com[$i])."</div>";
					if($tip[$i]==2 or $tip[$i]==3)
					{
						if($tip[$i]==2)
							$text_dir="GOOGLE";
						else	
							$text_dir="OSM";
						$texto .="<span class=span_nota>Direcci&oacute;n no exacta obtenida desde ".$text_dir."</span>";
					
					}
					//$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$direc[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$direc[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('".$CM_path_web."?ptot=1&pto=".$direc[0]."');><a href='https://twitter.com/share?url=".$CM_path_web."?ptot=1&pto=".$direc[0]."&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
					$texto .="<div id=botonera><img class=img_boton src=img/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_sesion.",".$direc[$i].",1);><img class=img_boton src=img/mail.png title=Enviar por correo onclick=compartirPto(".$direc[$i].",1);> <img class=img_boton src=img/facebook.png title=Compartir en Facebook onclick=compartirFace(".$direc[$i].",1);><a href=https://twitter.com/share?url=".$CM_path_web."?ptot=1&pto=".$direc[$i]."&via=chilemap&text=Revisa este link target=_BLANK><img  class=img_boton src=img/twitter.png title=Compartir en Twitter></a></div>";
					?>
					
					<li><a  href="javascript:verMapa('<?=$texto?>',<?=$lon[$i]?>,<?=$lat[$i]?>,'img/direc.png');"><span class=mini_txt><?=$dir?></span></a>			
				</li>
					<?php
				}	
				?>
				<script>					
					$( '#tot_dir' ).html( '(<?=count($calle)?>)' );
					</Script>
				<?php
			}else
			{
				?>
						<script>
							mensaje("No hay resultados para la busqueda","myPopup");
							</script>
						<?php
			}
		}
		
	
	
	
	}elseif($_REQUEST['tipo']==11)
	{
		$categoria=getCategoriasCliente($_SESSION['us_id_cli']);
		foreach($categoria as $cat)
		{
			?>
			<li><a  href="#"><span class=titulo2><?=ucwords($cat[1])?></span></p></a>					
							<a href="javascript:loadCategMapa(<?=$cat[0]?>);" data-rel="popup" data-position-to="window" data-transition="pop" data-icon="search">Ver en el Mapa</a>
							
						</li>
						
			  
			<?php
			
		}
	}elseif($_REQUEST['tipo']==12)
	{
		$datos=getServicioExtendPagosFull($_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
		foreach($datos as $i => $dat)
		{
			$data_cat=getServicioCategoria($dat[0]);
			if($data_cat[3]==5)//autorizado
  	  {
			
			$dir=$dat[3]." ".$dat[4];
			$texto="<div class=titulo>".strtoupper($dat[10])."</div>";
			$texto .="<div class=titulo_pop2>".ucwords($dat[9])."</div>";
			$texto .="<div class=titulo_pop3>".ucwords($dir)."</div>";
			$texto .="<div class=titulo_pop3>".ucwords($dat[5])."</div>"; 
			if(trim($dat[11])!="")
			{
				$texto .="<div class=titulo_pop_descrip>".ucwords($dat[11])."</div>";
			}
			
		
		
				
			
				?>
		
			
					<script>
						addMarcadoresOndemandPagos(<?=$dat[2]?>,<?=$dat[1]?>,"<?=$texto?>",'<?=$data_cat[2]?>',20,20,100);
					</script>
		
				<?PHP
			}
		}
	}
	}elseif($_REQUEST['tipo']==13)
	{
		$para=trim($_REQUEST['mail']);
		$titulo="Formulario de contacto chilemap";
		$msg="Hemos recibido su mensaje. Nos pondremos en contacto a la brevedad.<br><br> Equipo Chilemap";
		sendMail($para,$msg,$titulo);
		$msg2="Mensaje recibido desde formulario Gis version Movil.<br><br>";
		$msg2.="<br>Nombre: ".$_REQUEST['nom'];
		$msg2.="<br>Telefono: ".$_REQUEST['tel'];
		$msg2.="<br>Mail: ".$_REQUEST['mail'];
		$msg2.="<br>Mensaje: ".$_REQUEST['descrip'];
		sendMail("contacto@chilemap.cl,valeria@chilemap.cl",$msg2,$titulo);
	}elseif($_REQUEST['tipo']==14)//registra usuario
	{
	
	$usuario=getUsuario($_REQUEST['mail'],10);
	
	if(count($usuario)==0) // no existe usuario con ese mail, se procede a registrar
	{
		$key=generar_clave(10);
		addUsuario($_REQUEST['tipo_usuario'],$_REQUEST['nombre'],$_REQUEST['mail'],$_REQUEST['pais'],$_REQUEST['clave'],1,$key,$_REQUEST['news']);
		$url="".$CM_path_activa_mail."?mail=".urlencode($_REQUEST['mail'])."&co=".$key."";
		$mensaje = str_replace("URL_CONF",$url,$CM_MAIL_CONFIRMACION);	
		$envio=sendMail($_REQUEST['mail'],$mensaje,"Registro de Usuario ChileMap");
		if($envio)
		{
			$msg=$CM_USUARIO_REG_OK;
		}else
		{
			$msg=$CM_MSG_ERROR;
		}
		?>
	<script>
		$("#mod_registro").dialog( "close" );
   //$.mobile.changePage('#mensaje', 'pop', true, true);
	 //setTimeout("$.mobile.changePage('#mensaje', 'pop', true, true);",500);
	 
	  
	  setTimeout('mensaje("<?=$msg?>","myPopup");',500);
	 
	 </script>
   <?PHP
	}else
	{
		if($usuario[7]==0)
		   $msg=$CM_USUARIO_REGISTRADO;
		if($usuario[7]==1)
		   $msg=$CM_USUARIO_ESPERA_ACTIVACION;
		if($usuario[7]==2)
		   $msg=str_replace("_MAIL_",$_REQUEST['mail'],$CM_USUARIO_INACTIVO);
   
 		 echo $msg;
   
	}
	
	
	

}elseif($_REQUEST['tipo']==15)
{
	$servicios=CM_getServiciosActivos();
	$cat_pagos=getCatPagos();
						foreach($servicios as $i => $serv)
    						{
    							?>
    							<script>
    									addServicios('<?=$serv[1]?>','<?=$i+1?>','<?=$serv[2]?>','<?=$serv[5]?>');
    									</script>
    							
    							<?php	
    						}
    						if(count($cat_pagos)>0)
    						{
    						foreach($cat_pagos as $i => $serv)
    						{
    							?>
    							<script>
    									addServiciosPagos('<?=$serv[2]?>','<?=$i?>','<?=$serv[1]?>','<?=$serv[4]?>');
    									</script>
    							
    							<?php	
    						}
    					}   
	?>
	<div data-role="collapsible" data-collapsed="false" id="nav_serv" data-theme="b">
			  	  	
						
	<h3>Servicios</h3>
			  	  <div data-role="navbar">
    				<ul>
        			<?php
        			foreach($cat_pagos as $i => $serv)
    								{
    									?>
    									<li onclick="$('#mypanel').panel('close');">
    										<a href="javascript:checkServPago(<?=$serv[1]?>,'<?=$serv[4]?>',<?=$i?>);">
    											<img width=23px height=23px src="<?=$serv[4]?>">
    										</a>
    									</li>
    									<?php	
    								}   
        			foreach($servicios as $i => $serv)
        			{
        				if(trim($serv[5])!="")
    								{
    								?>
    								<li onclick="$('#mypanel').panel('close');">
    									<a href="javascript:checkServ(<?=$serv[2]?>,'<?=$serv[5]?>',<?=$i+1?>);">
    										<img width=23px height=23px src="<?=$serv[5]?>">
    									</a>
    								</li>
    								<?php	
    								}
        			}
        			
        			?>
    				</ul>
					</div><!-- /navbar -->
					
			  	  	
						</div>
	<?php
}elseif($_REQUEST['tipo']==16)//servicios especificos pagos
{
	$datos=getServicioExtendPagos($_REQUEST['id'],$_REQUEST['lati'],$_REQUEST['lats'],$_REQUEST['lond'],$_REQUEST['loni']);
	if(count($datos)>0)
	{
		$html="";
		foreach($datos as $i => $dat)
		{
			
			$texto_html ="<div id=cont_pop><div class=titulo>".strtoupper($dat[10])."</div>";
			$texto_html .="<div class=titulo_pop2>".ucwords($dat[9])."</div>";
			if(trim($dat[3])!="")
			{
				$texto_html .="<div class=titulo_pop2>".ucwords($dat[3])." #".$dat[4]."</div>";
			}
			$texto_html .="<div class=titulo_pop3>".ucwords($dat[5])."</div>";			
			$texto_html .="<div class=titulo_pop_descrip>".ucwords(trim($dat[11]))."</div></div>";
			
			$html .="<li onclick=javascript:moverCentro(".$dat[1].",".$dat[2].",".$CM_ZOOM_DIR.");><img class='ui-li-icon ui-corner-none' src=".$dat[12].">".strtoupper($dat[10])."</li>";
		?>
		
			
			<script>
			addMarcadoresOndemandPagos(<?=$dat[2]?>,<?=$dat[1]?>,"<?=$texto_html?>",'<?=$dat[12]?>',30,30,<?=$_REQUEST['id_serv']?>);
			</Script>
		
		<?PHP
	
		}
		?>
		<script>
		var tot_a=$("#cont-otros").html();
		tot_a=replaceAll(tot_a,'(','');
		tot_a=replaceAll(tot_a,')','');
		tot_b=parseInt("<?=count($datos)?>");
		total=0;
		if($.isNumeric(tot_a))
		{
				total=parseInt(tot_a);
		}
		total=total+tot_b;
		$("#cont-otros").html("("+total+")");
		$("#cont-total").html("("+total+")");
		$("#resul_otros2").html("<?=$html?>");
		$('#resul_otros2').listview('refresh');
		</script>
		<?php
	}
	
}elseif($_REQUEST['tipo']==17)
{
		session_start();
												
	?>
	<div data-role="collapsible-set" data-inset="true" id="colap_fav">
    											<div data-role="collapsible" >
        										<h3>Favoritos <span id="cont-fav"></span></h3>
														<ul data-role="listview" data-filter="true" data-scroll="true" data-filter-placeholder="Busca favoritos..." data-inset="true" id="resul_fav">	
															<?php
																		$datos=getFavoritoXUsuario($_SESSION['id_usuario']);
															foreach($datos as $dat)
															{
																if($dat[2]==1)
																{
																 $dat_pto=getDireccionXId($dat[3]);
																  $titulo2="DIRECCION";
																  $icono=$CM_ICONO_DIR;
																  
																   $titulo=ucwords(utf8_encode(toponimos(strtolower($dat_pto[5]))))." #".$dat_pto[6];
																}
																elseif($dat[2]==2)  
																{
																	$dat_pto=getServicioXId($dat[3]);
																	$titulo=ucwords(utf8_encode($dat[4]));  
																	$titulo2=ucwords(utf8_encode($dat[4]));  
																	$icono=$CM_ICONO_SERV;
																	
																}
																elseif($dat[2]==3)  
			  												{
			  													
			  													$dat_pto=getServicioPagoXId($dat[3]);
																	$titulo=ucwords(utf8_encode($dat_pto[1]));  
																	$titulo2=ucwords(utf8_encode($dat_pto[1]));  
																	$icono=$CM_ICONO_SERV;
																	
																	
			  												}  
																$texto="<div id=cont_pop><div class=titulo>".$titulo2."</div>";
																$texto .="<div class=titulo_pop>".ucwords(utf8_encode(toponimos(strtolower($dat_pto[5]))))." #".$dat_pto[6]."</div>";
																$texto .="<div class=titulo_pop>".ucwords(utf8_encode(toponimos(strtolower($dat_pto[7]))))."</div>";
																$texto=ucwords(utf8_encode($texto))."</div>";
																?>
																<li onclick="$('#mypanel').panel('close');"> 
																<img class="ui-li-icon ui-corner-none" src="img/basura.png" onclick="javascript:deleteFavoritos(<?=$dat[0]?>);"><div onclick='javascript:addMarcadores("<?=$dat[6]?>","<?=$dat[5]?>","<?=$texto?>","<?=$icono?>",35,35);moverCentro("<?=$dat[5]?>","<?=$dat[6]?>","<?=$CM_ZOOM_DIR?>");'><?=$titulo?></div>
																</li>
																	<?php
															}
															?>
			  	    							</ul>			    	
						    					</div>
	<?php
}elseif($_REQUEST['tipo']==18)
{
	eliminarFav($_REQUEST['id_fav']);
}elseif($_REQUEST['tipo']==19) //add favoritos
{
		
		session_start();
		$datos=getFavorito($_REQUEST['id'],$_REQUEST['tipo_data'],$_SESSION['id_usuario']);
		//print_r($datos);
		if(count($datos)==0)
		{
			$data[]=$_REQUEST['tipo_data'];
			$data[]=$_REQUEST['id'];
			addFavoritos($data);
			
		}else
		{
			
		}
		
		
}elseif($_REQUEST['tipo']==20) //envia mail modal
{
	//$msg="".$_REQUEST['nombre']." ha compartido un link contigo. <br><br> Haz click en este link para verlo <a href='".$_REQUEST['link']."'>Link chilemap.cl</a>";
		$msg=str_replace("_NOMBRE_",$_REQUEST['nombre'],$CM_mail);
	$msg=str_replace("_LINK_",$_REQUEST['link'],$msg);

	$envio=sendMail($_REQUEST['mail'],$msg,"".$_REQUEST['nombre'].", compartio un link contigo.");
	if($envio)
	{
		$msg="Link enviado.";
		?>
	  <script>
		var capaContenedora = document.getElementById("msg_mail");
	 	capaContenedora.innerHTML="<?=$msg?>";
	 	</script>
  <?php 
	}else
	{
		$msg="No se pudo enviar link.";
		?>
	<script>
		var capaContenedora = document.getElementById("msg_mail");
	 	capaContenedora.innerHTML="<?=$msg?>";
	 	</script>
  <?php 
	}
}elseif($_REQUEST['tipo']==21)
{
	
	//$("#msg_error_rec").html("El formato del mail es incorrecto");
	$usuario=getUsuario($_REQUEST['mail'],0);
	if(count($usuario)>0)
	{
		$para=trim($_REQUEST['mail']);
		$titulo="Solciitud de Clave Chilemap";
		$msg="Haz solicitado desde el sitio web la recuperacion de tu clave de ingreso";
		$msg .="<br> La clave de ingreso es:".$usuario[5];
		sendMail($para,$msg,$titulo);
		
		?>
		<script>
			
			$("#mod_recupera").dialog("close");
			setTimeout('$("#mod_sesion").dialog("close");',200);
			setTimeout('mensaje("Datos enviados a la direcci&oacute;n de correo electr&oacute;nico","myPopup");',600);
			</Script>
		<?php
	}else
	{
		?>
		<script>
		$("#msg_error_rec").html("Usuario no registrado");	
			</Script>
		<?php
	}
}elseif($_REQUEST['tipo']==22)
{
	$tipo=$_REQUEST['tipo_data'];
	$valor=$_REQUEST['valor'];
	if($valor==0)
	  $valor="Si";
	if($valor==1)
	  $valor="No";
	  
	$data=array();
	$data[]=$_REQUEST['serv'];
	$data[]="";
	$data[]=$valor;
	$data[]="";
	$data[]=$tipo;
	$data[]="";	
	addServicioDetalle($data);
}
}
?>