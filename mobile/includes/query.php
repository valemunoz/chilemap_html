<?php
include("../../includes/funciones.php");
$CM_ICONO_TRANSANTIAGO="img/bus2.png";
$CM_ICONO_SERV="img/point2.png";

$CM_path_activa_mail="http://www.chilemap.cl/activa.php";
$CM_PATH_REENVIO_CONF="http://www.chilemap.cl/confirmacion.php?mail=CM_MAIL";
$CM_path_re_activa_mail="http://www.chilemap.cl/reactiva.php";


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
$CM_MAIL_OLVIDO="Hola<br><br> Haz solicitado recuperar tu contraseņa y esta es:<br><br><strong>US_CONTRASENA</strong><br><br><img src='".$CM_path_logo."'><br><strong>Equipo de Chilemap.cl</strong>";
$CM_MAIL_CONFIRMACION='Hola!<br><br> Este correo es para confirmar tu direcci&oacute;n de Email ingresado en el sitio chilemap.cl, por favor haz click en el link <br> m&aacute;s adelante para confirmar tu correo y terminar con el registro.<br> URL_CONF <br><br><br><img src="'.$CM_path_logo.'"><br><strong>Equipo de Chilemap.cl</strong>';
/*FIN*/

$CM_msg_mail_ok="El mail ha sido enviado.";
$CM_msg_mail_err="Lo sentimos ha ocurrido un error. Por favor int&eacute;talo nuevamente.";
$CM_mail="_NOMBRE_ ha compartido un link contigo. <br><br> Haz click en este link para verlo <a href='_LINK_'>Link chilemap.cl</a><br><br>Equipo Chilemap.cl";

$CM_ERROR_GENERAL="Lo sentimos pero no entendemos tu solicitud <a href='".$CM_path_base."'>Volver al Home</a>";

$CM_msg_direccion_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para direcciones.</div>";
$CM_msg_servicio_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para puntos.</div>";
$estado_sesion=estado_sesion();

if(1==1)
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
		$texto .="<div class=titulo_pop3>Distancia: ".round($serv[8],2)."</div>"; 
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
		$texto .="<div class=titulo_pop3>Distancia: ".round($serv[8],2)."</div>"; 
		$icono='img/point2.png';
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
							</script>
		<?php
		
		}else
		{
			
			?>
			<script>
				loadCategorias();
				$("#text_supIz").html("Bienvenido <?=ucwords($_SESSION['nombre'])?>");
				$("#ll_iniciar").hide();
				$("#ll_reg").hide();
				</Script>
			<?php
		}
		$servicios=CM_getServiciosActivos();
			foreach($servicios as $i => $serv)
    	{
    		?>
    		<script>
    				//addServicios('<?=$serv[1]?>','<?=$i+1?>','<?=$serv[2]?>','<?=$serv[5]?>');
    				//bar2 +='<li><a href="#mypanel2"><img src="img/banco.png" width=32px height=32px></a></li>';
    		</script>
    		<?php	
    	}
		?>
		  				
    				
		   <script>
		   	/*$(".ui-page-active .maintenance_tabs").empty();
				var bar='<div data-role="navbar" id=list_nav class="maintenance_tabs">';
				bar +='<ul id="myNavbar">';
				bar +='<li><a href="javascript:ubicacionActual();"><img src="img/current.png" width=32px height=32px></a></li>';
				bar +=bar2;
				bar +='<li><a href="#mypanel2"><img src="img/search.png" width=32px height=32px></a></li>';
				bar +='<li><a href="javascript:limpiarMapa();"><img src="img/clean.png" width=32px height=32px></a></li>';
				bar +='</ul>';
				bar +='</div>';
				
  			$(".ui-page-active .maintenance_tabs").append(bar).trigger('create');*/
		   	</script> 		
		<?php
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
			window.location.href="index.html";
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
		$titulo="Gis, formulario de contacto";
		$msg="Hemos recibido su mensaje. Nos pondremos en contacto a la brevedad.<br><br> Equipo Chilemap";
		sendMail($para,$msg,$titulo);
		$msg2="Mensaje recibido desde formulario Gis version Movil.<br><br>";
		$msg2.="<br>Nombre: ".$_REQUEST['nombre'];
		$msg2.="<br>Telefono: ".$_REQUEST['tel'];
		$msg2.="<br>Mail: ".$_REQUEST['mail'];
		$msg2.="<br>Mensaje: ".$_REQUEST['descrip'];
		sendMail("contacto@solutionworks.cl,valeria@solutionworks.cl",$msg2,$titulo);
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
	
	
	

}
}
?>