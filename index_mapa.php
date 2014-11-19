<?PHP
include("includes/funciones.php");
require_once ('includes/mensajes.php');
require_once("includes/Mobile_Detect.php");
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$data_server= explode("?",$_SERVER['REQUEST_URI']);
$cat_pagos=getCatPagos();

if($deviceType!="computer")
{
	if(count($data_server)>1)
	{
	?>
		<script>
			window.location="<?=$CM_path_mobile?>?<?=$data_server[1]?>";
		</script>
	<?php
	}else
	{

		$data_server= explode(".",$_SERVER['REQUEST_URI']);
		$dat=explode("/",$data_server[0]);
		$i=count($dat)-1;
		$dat=$dat[$i];
		?>
		<script>
			
			window.location="<?=$CM_dominio_mobile?>/<?=$dat?>.htm";
		</script>
	<?php
	}
	
}
//echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$estado_ses=estado_sesion();
//echo "estado sesion:".$estado_ses;
?>
<!doctype html>

<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->

<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->

<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->

<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
	
		<meta charset="utf-8">
	<meta name="description" content="Somos un sitio con un completo mapa con información georeferenciada que se desarrollo con la idea de facilitar la búsqueda de direcciones y lugares en chile."/>
  <meta name="keywords" content="direcciones, puntos de interes, mapas,lugares, chile, gis, sig"/>
  <meta name="content-type" http-equiv="content-type" content="text/html; charset=utf-8"/>
  <meta name="robots" content="index, follow" />
  

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ChileMap.cl - Mapas, Direcciones y Lugares!</title>
	<link href="http://www.chilemap.cl/images/logo.png" rel="image_src" />
 <link rel="shortcut icon" href="img/favicon/logo.ico">
 
	



<link href="css/style_popup.css" type="text/css" rel="stylesheet" charset="utf-8" /> 
	<link href="css/boilerplate.css" rel="stylesheet" type="text/css">
	<link href="css/Untitled-1.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/style8.css">
	<link rel="stylesheet" href="css/styles22.css">
	<!--link rel="stylesheet" href="rmm-css/responsivemobilemenu.css" type="text/css"/-->
	<link rel="stylesheet" href="css/styles2.css">
	
	<link rel="stylesheet" type="text/css" href="css/demo.css" />
	
	<link rel="stylesheet" type="text/css" href="css/elastislide.css" />
	
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	
	<!--link rel="stylesheet" href="src/jquery.scrollbars.css"-->
	
	<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/jquery.horizontal.scroll.css" />
	<link rel="stylesheet" type="text/css" href="css/demo_style.css" />
	<!--link href='http://fonts.googleapis.com/css?family=Dancing+Script:regular,bold&v1' rel='stylesheet' type='text/css'-->
	<link rel="stylesheet" type="text/css" href="css/interior.css">
	
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<link href="stylemenu/bootstrap.css" rel="stylesheet">
<link href="stylemenu/style.css" rel="stylesheet">
<link href="stylemenu/bootstrap-responsive.css" rel="stylesheet">

<script src="jsmenu/bootstrap.js"></script> <!-- Bootstrap -->


<script type="text/javascript" src="highslide/highslide/highslide-with-html.js"></script>
  
<script src="OpenLayers/OpenLayers.js"></script>
<script src="js/funciones_api.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script src="js/respond.min.js"></script>
<script src="js/swfobject.js" type="text/javascript"></script> 

<script type="text/javascript">
    hs.graphicsDir = 'highslide/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.outlineWhileAnimating = true;
	</script>  
<script>
	window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '171716159685522',                        // App ID from the app dashboard
      channelUrl : 'http://www.chilemap.cl', // Channel file for x-domain comms
      status     : true,                                 // Check Facebook Login status
      xfbml      : true,                                 // Look for social plugins on the page
      req_perms : 'publish_stream'
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/es_ES/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


    //grilla
  $(function() {
    $( "#grilla" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });      
 

  });
	</script>

</head>

<body>
	
<script>

$(document).ready(function() {	
	
	//Put in the DIV id you want to display
	//launchWindow('#modal_auto2');
	
	//if close button is clicked
	$('.window #close').click(function () {
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			
	

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});	
	<?php
	if($_REQUEST['act']==1)
	{
		?>
		launchWindow('#mod_sesion');
		<?php
	}
	?>
});

function launchWindow(id) {
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height());
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	

}

</script>
	<div class="highslide-html-content" id="highslide-html">
	<div class="highslide-header">
		<ul>
			<li class="highslide-move">
				<a border="0" href="#" onclick="return false">Mover</a>
			</li>
			<li class="highslide-close">
				<a border="0" href="#" onclick="return hs.close(this)">X</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body" id="contenido">
		TESTEO
	</div>
    <div class="highslide-footer">
        <div>
            <span class="highslide-resize" title="Resize">
                <span></span>
            </span>
        </div>
    </div>
</div>
<div id="boxes">


  
<!-- Start of Login Dialog -->  
<div id="mod_sesion" class="window">
<?php
include("modal_sesion.php");
?>
</div>
<div id="mod_registro" class="window">
<?php
include("modal_registro.php");
?>
</div>
<div id="mod_favoritos" class="window">
<?php
include("modal_favoritos.php");
?>
</div>
<div id="mod_datos" class="window">
<?php
include("modal_datos.php");
?>
</div>

<div id="mod_mail" class="window">
<?php
include("modal_mail.php");
?>
</div>
<!-- Start of Login Dialog -->  
<div id="mod_contacto" class="window">
<?php
include("modal_contacto.php");
?>
</div>
<div id="mod_olvido" class="window">
<?php
include("olvido.php");
?>
</div>
<div class="gridContainer clearfix">


  <div id="LayoutDiv1" style="z-index:1003">
  

  

<div class="navbar navbar-fixed-top">

            
    <div class="navbar-inner">
      <div class="container-fluid">
        <a border="0" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        
        
        
        <div class="nav-collapse collapse">
        
        
        
        <!--menu_registrado-->
   <?PHP
if($estado_ses==0)//usuario logeado
{
?>     
        <li class="bien" style="font-size: 13px!important;margin-left: 20px!important;color: white;font-weight: bold;"><font style="font-size: 13px!important;" color="#00CCFF">Bienvendo:</font>                <?=$_SESSION['nombre']?></li>    
          <ul class="nav pull-right">
       
            <li class="dropdown"><a border="0" href="#" class="dropdown-toggle" data-toggle="dropdown">Mi Cuenta <b class="caret"></b></a>
         
              <ul class="dropdown-menu">
                 <li><a border="0" href="javascript:loadPHP('modal_datos.php','mod_datos');launchWindow('#mod_datos');">Mis datos</a></li>
                 <li><a border="0" href="javascript:loadPHP('modal_favoritos.php','mod_favoritos');launchWindow('#mod_favoritos');">Favoritos</a></li>
                 <li><a href="javascript:cerrarSesion();">Salir</a></li>
              </ul>
         </li> 
          
          
         
         <li><a border="0" href="javascript:loadPHP('modal_contacto.php','mod_contacto');launchWindow('#mod_contacto');" class="clsVentanaIFrame clsBoton3" rel="Contacto">Contacto</a></li>
         <li><a border="0" href='<?=$CM_path_coorporativo?>' target="_BLANK">Quienes somos?</a></li>
         <li><a border="0" href='http://gis.chilemap.cl/antenas/' target="_BLANK">SIG Antenas</a></li>
         <li><a border="0" class="facebook" href='https://www.facebook.com/chilemap' target=_BLANK>facebook</a></li>
         <li class="w_face"><div class="fb-like" data-href="https://www.facebook.com/chilemap" data-width="10" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>
         <li><a border="0" class="twitter" href='https://twitter.com/chilemap' target=_BLANK>twitter</a></li>
         
       

     <?php
   }else
   {
   	?>           
          </ul>
        <!--menu_registrado-->
        
        
          <ul class="nav pull-right">
          <li><a border="0" href="javascript:loadPHP('modal_registro.php','mod_registro');launchWindow('#mod_registro');" class="clsBoton1" rel="Regístrate Aquí">Regístrate aquí</a></li>
         <li><a border="0" href="javascript:launchWindow('#mod_sesion');" class="clsBoton1" rel="Iniciar sesión">Iniciar sesión</a></li>
         <li><a border="0" href="javascript:loadPHP('modal_contacto.php','mod_contacto');launchWindow('#mod_contacto');" class="clsVentanaIFrame clsBoton3" rel="Contacto">Contacto</a></li>
         <li><a border="0" class="twitter" href='<?=$CM_path_coorporativo?>' target="_BLANK">Quienes somos?</a></li>
         <li><a border="0" href='http://gis.chilemap.cl/antenas/' target="_BLANK">SIG Antenas</a></li>
         <li><a border="0" class="facebook" href='https://www.facebook.com/chilemap' target=_BLANK>facebook</a></li>
         <li class="w_face"><div class="fb-like" data-href="https://www.facebook.com/chilemap" data-width="10" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>
         <li><a border="0" class="twitter" href='https://twitter.com/chilemap' target=_BLANK>twitter</a></li>
        

             
          </ul>
          
      <?php

  }
     ?>      
        </div>
      </div>
    </div>
  </div>
   

        </div> 

  <div id="LayoutDiv4"><a border="0" href="<?=$CM_path_base2?>"><img src="images/logo.png"></a>

  </div>

  <div id="LayoutDiv2">

  

  

  <div class="texto_inicio"> 

  <div class="text" style="float:left">Tu lugar esta aquì</div>

  

  
<?php
if(trim($_REQUEST['q'])!="")
{
	
	$texto=str_replace("ñ","n",$_REQUEST['q']);
	$texto=str_replace("Ñ","n",$texto);
	$texto=str_replace("á","a",$texto);
	$texto=str_replace("é","e",$texto);
	$texto=str_replace("í","i",$texto);
	$texto=str_replace("ó","o",$texto);
	$texto=str_replace("ú","u",$texto);
	$texto=str_replace("ü","u",$texto);	
  $value=str_replace("-"," ",trim(strtolower($texto)));
   
  
}
else
{
   $value="";   
}
?>
  <div class="tex1t" style="float:left"><input onKeyPress="enterpressalert(event, this,2);" value= "<?=$value?>" autocomplete=off class="imp_inicio" name="query" id="query" type="text" placeholder="Ejemplo: Las Condes 8967"></div>

  

  

  

<div class="text2" style="float:left;outline:none !important;"><a style="outline:none !important;" border="0" href="javascript:buscar('');" class="btn_bu_interior" style="" id="boton_modal"><img style="outline:none !important;" src="images/lupa.png"></a></div>

</div>

<ul id="horiz_container_outer">


		<li id="horiz_container_inner">

			<ul id="horiz_container">

				<li><img src="images/imp.png" title="Imprimir" onclick="javascript:printMapa();"></li>

				<li onclick="javascript:limpiarMapa();"><img src="iconos/borrar.png" title="Limpiar Mapa"></li>

                <li onclick="javascript:loadPHP('modal_mail.php','mod_mail');launchWindow('#mod_mail');"><img src="iconos/correo.png" title="Enviar Link Actual por Mail"></li>

				<li><img src="iconos/medida.png" onclick="javascript:toogleMedidor();" title="Activar Control Medidor de Distancias"></li>

                <li><img src="iconos/transantiago.png" onclick="javascript:loadTS();" title="Ver Paraderos Transantiago"></li>
                <li><img src="iconos/entorno.png" onclick="javascript:accionManzana();" title="Informacion por Manzanas"></li>
                
			<?php
			if($estado_ses==0)
			{
			?>
				<li><img src="iconos/favoritos.png" title="Ver Favoritos" onclick="javascript:loadPHP('modal_favoritos.php','mod_favoritos');launchWindow('#mod_favoritos');"></li>
				<?php
			}
				?>

                <li><img src="iconos/megusta.png" title="Compartir en Facebook" onclick="javascript:compartirFace('<?=$CM_path_base2?>');"></li>

				<li><a href='https://twitter.com/share?url=".$CM_path_base."&via=chilemap&text=Chilemap.cl, tu lugar esta aquí' target=_BLANK><img title="Compartir en Twitter" src="iconos/twi.png"></a></li>

                <li><img  title="Ubicacion Actual" src="iconos/mira.png" onclick="javscript:currentLocation();"></li>
                
                <li><img src="images/mano.png" title="Control Mapa" onclick="javascript:manoBarra();"></li>

	
			</ul>

		</li>	
      	

	</ul>			


	<div id="scrollbar">

	  <a border="0" id="left_scroll" class="mouseover_left" href="#"></a>	

		<div id="track">

        </div>
        
		     <div id="dragBar"></div>
<a border="0" id="right_scroll" class="mouseover_right" href="#"></a>
		</div>

		

  </div>
    <?PHP
if($estado_ses==0)//usuario logeado
{
	?>
	<!--div id="LayoutDiv3"> <div class="che" onclick="javascript:loadPHP('modal_contacto.php','mod_contacto');launchWindow('#mod_contacto');">Que te parece?</div><div class="text_che">Ayudanos a mejorar!</div></div-->
	<div id="LayoutDiv3"> <div class="che" onclick="OpenModalGrilla(0,0);">Sube un Lugar!</div><div class="text_che">Ayuda a la comunidad!</div></div>
	<?php
}else
{
?>     

  <!--div id="LayoutDiv3"> <div class="che" onclick="javascript:loadPHP('modal_registro.php','mod_registro');launchWindow('#mod_registro');">Regístrate!</div><div class="text_che">Se parte de la comunidad Chilemap!</div></div-->
  <div id="LayoutDiv3"> <div class="che" onclick="OpenModalGrilla(0,0);">Sube un Lugar!</div><div class="text_che">Ayuda a la comunidad!</div></div>
<?php
}
?>
  <div id="LayoutDiv5">
  <div id="swf_div">Nada</div>
 <!-- <img src="images/banner.jpg" style="border: 2px solid #dedede;">-->
 <!--object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  height="85" id="FlashID" title="flash" style="width:100% !important">
   <param name="movie" id="movie" value="img/1.swf">
   <param name="quality" value="high">
   <param name="wmode" value="opaque">
   <param name="swfversion" value="6.0.65.0">
   
   <param name="expressinstall" value="Scripts/expressInstall.swf">
   
   
   <object type="application/x-shockwave-flash" id="ban_centro" name="ban_centro" data="img/1.swf" width="352" height="85">
   
     <param name="quality" value="high">
     <param name="wmode" value="opaque">
     <param name="swfversion" value="6.0.65.0">
     <param name="expressinstall" value="Scripts/expressInstall.swf">
    
     <div>
       <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
       <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
     </div>
    
   </object>
   
 </object-->
<script>
	var var1={};
				 	var var2={};
				 	var var3={};
				 	
				 	swfobject.embedSWF("img/1.swf", "swf_div", "332", "80", "9.0.0", "js/expressInstall.swf",var1,var2,var3);
	</Script>
  </div>

  <div id="LayoutDiv6">

   <div id="pestañas">

    <div id="TabbedPanels1" class="TabbedPanels">

      <ul class="TabbedPanelsTabGroup">

        <li class="TabbedPanelsTab" tabindex="0">DIRECCIONES <div id="cont_direc"></div></li>

        <li class="TabbedPanelsTab" tabindex="0">LUGARES<div id="cont_serva"></div></li>

        <li class="TabbedPanelsTab" tabindex="0">OTROS<div id="cont_otro"></div></li>

      </ul>

      <div class="TabbedPanelsContentGroup" style=" text-shadow:none;">
      
        <div id="resultados_a" class="TabbedPanelsContent" style="display:block; overflow-y:scroll; height:360px;margin-top:10px;" >
        
        
		
			<div class="ser"> 
				
				<div class="des_resul">Bienvenidos a Chilemap, tu lugar esta aquí Búscalo!</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
				
				</div> 
			</div>
            
            
            	
			<div class="ser1">
      
      	<div class="des_resul">Busca una dirección escribiéndola directamente en la caja de búsqueda.</div>
        	<div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left">
      		<img width="30" height="30" src="iconos/direccion.png">
      	</div> 
      </div>
      
      
      	
      <div class="ser"> 
				
				<div class="des_resul">Quieres ver los paraderos del Transantiago cerca de tu ubicación?...Haz click en el icono para activar el control</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
						<img width="23" height="23" src="iconos/transantiago.png">
				</div> 
			</div>
            
            
            	
            <div class="ser1">
            <div class="des_resul">Buscas bancos, restaurant o cajeros?, escribe lo que necesitas en la caja de búsqueda y encuéntralo!</div> 
            <div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left"><img width="30px" height="30px" src="iconos/restaurant.png"></div></div>
            
            
            	
            <div class="ser">
            <div class="des_resul">Buscar una Clinica cerca de tu casa?, escribe la dirección, búscala y luego escribe clínica o lo que necesites!</div> 
            <div class="img_ser" style="width:30px;margin-right: 5px;margin-top:5px;  height:30px;float:left"><img width="30px" height="30px" src="iconos/clinica.png"></div></div>	
						<div class="ser1">
            <div class="des_resul">Limpia el mapa utilizando este icono</div> 
            <div class="img_ser" style="width:30px;margin-right: 5px;margin-top:5px;  height:30px;float:left"><img width="30px" height="30px" src="iconos/borrar.png"></div></div>	
			
			
			
		
        
        
        </div>
        
        

        <div id="resultados_b" class="TabbedPanelsContent" style="display:block;overflow-y:scroll; height:360px;position:absolut; margin-top:10px; ">
       
	
			<div class="ser"> 
				
				<div class="des_resul">Aquí encontraras los servicios que encontremos como resultados de acuerdo a la búsqueda ingresada.</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
				
				</div> 
			</div>
            
            
            	
			<div class="ser1">
      
      	<div class="des_resul">Busca una dirección escribiéndola directamente en la caja de búsqueda.</div>
        	<div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left">
      		<img width="30" height="30" src="iconos/direccion.png">
      	</div> 
      </div>
      
      
      	
      <div class="ser"> 
				
				<div class="des_resul">Quieres ver los paraderos del Transantiago cerca de tu ubicación?...Haz click en el icono para activar el control</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
						<img width="23" height="23" src="iconos/transantiago.png">
				</div> 
			</div>
            
            
            	
            <div class="ser1">
            <div class="des_resul">Buscas bancos, restaurant o cajeros?, escribe lo que necesitas en la caja de búsqueda y encuéntralo!</div> 
            <div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left"><img width="30px" height="30px" src="iconos/restaurant.png"></div></div>
            
            
            	
            <div class="ser">
            <div class="des_resul">Buscar una Clínica cerca de tu casa?, escribe la dirección, búscala y luego escribe clínica o lo que necesites!</div> 
            <div class="img_ser" style="width:30px;margin-right: 5px;margin-top:5px;  height:30px;float:left"><img width="30px" height="30px" src="iconos/clinica.png"></div></div>	
			
        
        </div>

        <div id="resultados_c" class="TabbedPanelsContent" style="display:block;overflow-y:scroll; height:360px;margin-top:10px;">
        
        
        
		
			
			<div class="ser"> 
				
				<div class="des_resul">Aquí encontraras alertas y resultados de búsquedas sobre transantiago y otros.</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
				
				</div> 
			</div>
            
            
            	
			<div class="ser1">
      
      	<div class="des_resul">Busca una dirección escribiéndola directamente en la caja de búsqueda.</div>
        	<div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left">
      		<img width="30" height="30" src="iconos/direccion.png">
      	</div> 
      </div>
      
      
      	
      <div class="ser"> 
				
				<div class="des_resul">Quieres ver los paraderos del Transantiago cerca de tu ubicación?...Haz click en el icono para activar el control</div> 
                <div class="img_ser" style="width:23px; height:23px;margin-right: 5px; margin-top:5px; float:left">
						<img width="23" height="23" src="iconos/transantiago.png">
				</div> 
			</div>
            
            
            	
            <div class="ser1">
            <div class="des_resul">Buscas bancos, restaurant o cajeros?, escribe lo que necesitas en la caja de búsqueda y encuéntralo!</div> 
            <div class="img_ser" style="width:30px;margin-top:5px;margin-right: 5px; height:30px; float:left"><img width="30px" height="30px" src="iconos/restaurant.png"></div></div>
            
            
            	
            <div class="ser">
            <div class="des_resul">Buscar una Clínica cerca de tu casa?, escribe la dirección, búscala y luego escribe clínica o lo que necesites!</div> 
            <div class="img_ser" style="width:30px;margin-right: 5px;margin-top:5px;  height:30px;float:left"><img width="30px" height="30px" src="iconos/clinica.png"></div></div>	
			
		
        
        
        </div>

      </div>

    </div>

  </div>

   

   </div>


  <div id="LayoutDiv7"></div>
 <div id="output"></div>
  
<script>
	init("LayoutDiv7");
	changeFlash();
</script>

<?php
if(trim($_REQUEST['q'])!="")
{
   ?>
   <script>
   		buscar('<?=$value?>');
   	</script>
   <?php  
}
if(isset($_REQUEST['pto']))
{
	if($_REQUEST['ptot']==2)//servicio
	{
		$data_serv=getServicioXId($_REQUEST['pto']);
		
		$titulo=ucwords(strtolower($data_serv[1]));
	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
		$texto ="<div id=titulo2>".$titulo."</div>";
					
					$texto .="<div id=titulo5>".$direccion."</div>";
					$texto .="<div id=titulo6>".ucwords($data_serv[7])."</div>";			
					$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$data_serv[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$data_serv[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."');> <a href='https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
					
			
   ?>
   <script>
   		addMarcador('<?=$CM_ICONO_SERV?>','35,35',<?=$data_serv[3]?>,<?=$data_serv[4]?>,"<?=$texto?>",'<?=$titulo?>');
   		moverCentro(<?=$data_serv[3]?>,<?=$data_serv[4]?>,17);
   	</script>
   <?php  
 }elseif($_REQUEST['ptot']==3)//servicio pago
	{
		$data_serv=getServicioPagoXId($_REQUEST['pto']);
		$data_categoria=getServicioCategoria($data_serv[9]);
		$titulo=ucwords(strtolower($data_serv[1]));
	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
		$texto ="<div id=titulo2>".$titulo."</div>";					
					$texto .="<div id=titulo5>".$direccion."</div>";
					$texto .="<div id=titulo6>".ucwords($data_serv[7])."</div>";			
					$texto .="<div id=tit_descrip>".ucwords(trim($data_serv[8]))."</div>";			
					$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$data_serv[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$data_serv[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."');> <a href='https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
					
			
   ?>
   <script>
   	
   		addMarcador('<?=$data_categoria[2]?>','35,35',<?=$data_serv[3]?>,<?=$data_serv[4]?>,"<?=$texto?>",'<?=$titulo?>');
   		moverCentro(<?=$data_serv[3]?>,<?=$data_serv[4]?>,14);
   	</script>
   <?php  
 }elseif($_REQUEST['ptot']==1)//direccion
	{
		$data_serv=getDireccionXId($_REQUEST['pto']);
		
	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
	  $titulo=$direccion;
		//$texto ="<div id=titulo2>".$titulo."</div>";
					
					$texto ="<div id=titulo2>".$direccion."</div>";
					$texto .="<div id=titulo6>".ucwords($data_serv[7])."</div>";			
					$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$data_serv[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$data_serv[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace('".$CM_path_base2."&ptot=1&pto=".$data_serv[0]."');> <a href='https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."&via=chilemap&text=Revisa este link' target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
					
			
   ?>
   <script>
   		addMarcador('<?=$CM_ICONO_SERV?>','35,35',<?=$data_serv[3]?>,<?=$data_serv[4]?>,"<?=$texto?>",'<?=$titulo?>');
   		moverCentro(<?=$data_serv[3]?>,<?=$data_serv[4]?>,17);
   	</script>
   <?php  
 }
}  
?>





  <div id="LayoutDiv8">

    <!--carrusel-->
 	<div class="list_carousel responsive">

			<ul id="foo5">
        <?php
        $cont=0;
        $cont_max=8;
    				  		if(count($cat_pagos)>0)
    				  		{
        foreach($cat_pagos as $i => $cp)
        {
        	?>
        	<li id="img_serv_pago_<?=$i?>" class="serv_circulo_off"><a href="javascript:checkServPago(<?=$cp[1]?>,'<?=$cp[4]?>',<?=$i?>);"><img class="img_marcas" src="<?=$cp[4]?>"></a></li>
        	<?php
        	$cont++;
        }
      }
        
        if($cont < $cont_max)
        {
        	for($i=$cont;$i<$cont_max;$i++)
        	{
        		if($i%2==0)
        		{
        			?>
        			<li><a href="<?=$CM_path_coorporativo?>" target="_BLANK"><img class="img_marcas" src="images/fa.png"></a></li>
				
        			<?php
        		}else
        		{
        			?>
        			<li><a href="<?=$CM_path_coorporativo?>" target="_BLANK"><img class="img_marcas" src="images/fa1.png"></a></li>
				
        			<?php
        			
        		}
        	}
        }
        ?>
				

	

			</ul>
			<?php
			    				  		if(count($cat_pagos)>0)
    				  		{
			  foreach($cat_pagos as $i => $cp)
        {
        	?>
        	<script>
        		addServiciosPagos('<?=$cp[2]?>','<?=$i?>','<?=$cp[1]?>','<?=$cp[4]?>');
        		</script>
        	<?php
        	$cont++;
        }
      }
			?>
			<script>
				addServiciosPagos("todos",100,100,"");
				</script>
				
			<div class="clearfix"></div>
           <a id="preva" class="prev" href="#"></a> 
           <a id="nexta" class="next" href="#"></a>	

		</div>
		
		<div class="list_carousel responsive" >

			<ul id="foo3">
            
            <li id="img_serv_00" class="serv_circulo_off" onclick=loadTS();>
				  		<img title="Paraderos del Transantiago" src="iconos/web/transantiago.png">
				  	</li>
				  	<li id="img_serv_001" class="serv_circulo_off" onclick=loadFarmaTurno();>
				  		<img title="Farmacias de Turno: Enero a Junio 2014" src="iconos/web/farma_turno.png">
				  	</li>
				  	<li id="img_serv_002" class="serv_circulo_off" onclick="accionManzana();">
				  		<img title="Informacion por Manzanas" src="iconos/web/entorno.png">
				  	</li>
				  	<!--li id="img_serv_01" class="serv_circulo_off" onclick=checkAntenas();>
				  		<img title="Antenas Telefonía" src="iconos/antena.png">
				  	</li-->
				  	<script>
				  		addServicios('Farmacias de Turno',0,'0','');
				  	</script>
           <?php
					$datos=CM_getServiciosActivos();
					foreach($datos as $i => $dat)
					{
				  	?>
				  	
				  	<li id="img_serv_<?=$i+1?>" class="serv_circulo_off" onclick=checkServ(<?=$dat[2]?>,'<?=$dat[5]?>',<?=$i+1?>);>
				  		<img title="<?=$dat[1]?>" src="<?=$dat[5]?>">
				  	</li>
				  	
				
				  	<?PHP
					}
					?>
								

			</ul>

			<div class="clearfix"></div>

				<a id="prev3" class="prev" href="#"></a>

				<a id="next3" class="next" href="#"></a>

			

		</div>
	<script>
					<?php
					foreach($datos as $i => $dat)
					{									
				  	?>				
				  		addServicios('<?=$dat[1]?>','<?=$i+1?>','<?=$dat[2]?>','<?=$dat[5]?>');
				  	
				  	<?PHP
					}
        ?>    
        //addServicios("antenas",100,100,"");
				</script>
  
      <!--carrusel-->

 
</div>

    

  </div>

  

  <!--<div id="LayoutDiv9">Chilemap</div>-->

 

</div>




	
    
    
     
    
    
    
	
	<!-- custom scrollbars plugin -->
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
		(function($){
			$(window).load(function(){
				/* custom scrollbar fn call */
				$(".content_1").mCustomScrollbar({
					scrollButtons:{
						enable:true
					}
				});
				$(".content_2").mCustomScrollbar({
					scrollInertia:150
				});
				$(".content_3").mCustomScrollbar({
					scrollInertia:600,
					autoDraggerLength:false
				});
				$(".content_4").mCustomScrollbar({
					set_height:"85%",
					mouseWheel:false
				});
				$(".content_5").mCustomScrollbar({
					horizontalScroll:true,
					scrollButtons:{
						enable:true
					},
					theme:"dark-thin"
				});
				$(".content_6").mCustomScrollbar({
					horizontalScroll:true,
					advanced:{
						autoExpandHorizontalScroll:true
					}
				});
				$(".content_7").mCustomScrollbar({
					set_width:"95%",
					scrollButtons:{
						enable:true
					},
					theme:"light-2"
				});
				$(".content_8").mCustomScrollbar({
					callbacks:{
						onScroll:function(){
							onScrollCallback();
						},
						onTotalScroll:function(){
							onTotalScrollCallback();
						},
						onTotalScrollOffset:40,
						onTotalScrollBack:function(){
							onTotalScrollBackCallback();
						},
						onTotalScrollBackOffset:20
					}
				});
				
				/* 
				demo fn 
				functions below are for demo and examples
				*/
				$(".demo_functions a[rel='append-new']").click(function(e){
					e.preventDefault();
					$(".content_6 .images_container").append("<img src='demo_files/mcsThumb1.jpg' class='new' />");
					$(".content_6 .images_container img").load(function(){
						$(".content_6").mCustomScrollbar("update");
					});
				});
				$(".demo_functions a[rel='prepend-new']").click(function(e){
					e.preventDefault();
					$(".content_6 .images_container").prepend("<img src='demo_files/mcsThumb8.jpg' class='new' />");
					$(".content_6 .images_container img").load(function(){
						$(".content_6").mCustomScrollbar("update");
					});
				});
				$(".demo_functions a[rel='append-new-scrollto']").click(function(e){
					e.preventDefault();
					$(".content_6 .images_container").append("<img src='demo_files/mcsThumb1.jpg' class='new' />");
					$(".content_6 .images_container img").load(function(){
						$(".content_6").mCustomScrollbar("update");
						$(".content_6").mCustomScrollbar("scrollTo","right");
					});
				});
				$(".demo_functions a[rel='scrollto']").click(function(e){
					e.preventDefault();
					$(".content_6").mCustomScrollbar("scrollTo","#mcs_t_5");
				});
				$(".demo_functions a[rel='remove-last']").click(function(e){
					e.preventDefault();
					$(".content_6 .images_container img:last").remove();
					$(".content_6").mCustomScrollbar("update");
				});
				$(".demo_functions a[rel='toggle-width']").click(function(e){
					e.preventDefault();
					$(".content_6").toggleClass("toggle_width");
					$(".content_6").mCustomScrollbar("update");
				});
				$(".demo_functions a[rel='scrollto-par-5']").click(function(e){
					e.preventDefault();
					$(".content_7").mCustomScrollbar("scrollTo","#par-5");
				});
				$(".demo_functions a[rel='increase-height']").click(function(e){
					e.preventDefault();
					$(".content_7").animate({height:1100},"slow",function(){
						$(this).mCustomScrollbar("update");
					});
				});
				$(".demo_functions a[rel='decrease-height']").click(function(e){
					e.preventDefault();
					$(".content_7").animate({height:350},"slow",function(){
						$(this).mCustomScrollbar("update");
					});
				});
				var content_7_height=$(".content_7").height();
				$(".demo_functions a[rel='reset-height']").click(function(e){
					e.preventDefault();
					if($(".content_7").height()!=content_7_height){
						$(".content_7").animate({height:content_7_height},"slow",function(){
							$(this).mCustomScrollbar("update");
						});
					}
				});
				$(".demo_functions a[rel='scrollto-bottom']").click(function(e){
					e.preventDefault();
					$(".content_7").mCustomScrollbar("scrollTo","bottom");
				});
				$(".demo_functions a[rel='scrollto-top']").click(function(e){
					e.preventDefault();
					$(".content_7").mCustomScrollbar("scrollTo","top");
				});
				$(".demo_functions a[rel='scrollto-par-1st']").click(function(e){
					e.preventDefault();
					$(".content_7").mCustomScrollbar("scrollTo","first");
				});
				function onScrollCallback(){
					$(".callback_demo .callback_demo_output").html("<em>Scrolled... Content top position: "+mcs.top+"</em>").children("em").delay(1000).fadeOut("slow");
				}
				function onTotalScrollCallback(){
					if($(".appended").length<1){
						$(".content_8 .mCSB_container").append("<p class='appended'><img src='demo_files/mcsImg1.jpg' /></p>");
					}else{
						$(".callback_demo .callback_demo_output").html("<em>Scrolled to bottom. Content top position: "+mcs.top+"</em>").children("em").delay(1000).fadeOut("slow");
					}
					$(".content_8 .mCSB_container img").load(function(){
						$(".content_8").mCustomScrollbar("update");
						$(".callback_demo .callback_demo_output").html("<em>New image loaded...</em>").children("em").delay(1000).fadeOut("slow");
					});
				}
				function onTotalScrollBackCallback(){
					$(".callback_demo .callback_demo_output").html("<em>Scrolled to top. Content top position: "+mcs.top+"</em>").children("em").delay(1000).fadeOut("slow");
				}
				$(".callback_demo a[rel='scrollto-bottom']").click(function(e){
					e.preventDefault();
					$(".content_8").mCustomScrollbar("scrollTo","bottom");
				});
			});
		})(jQuery);
	</script>




 <!--PRUEBA-->
 <script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquerypp.custom.js"></script><script type="text/javascript" src="js/jquery.elastislide.js"></script>

        
 
        

       

		<script type="text/javascript">

			

			$( '#carousel' ).elastislide();

			

		</script>



<!--carrusel-->




<script type="text/javascript" language="javascript" src="js/jquery.carouFredSel-6.2.1-packed.js"></script>




 <script type="text/javascript">

var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");

</script>





<script type="text/javascript" language="javascript">

			$(function() {



				//	Basic carousel, no options

				$('#foo0').carouFredSel();



				//	Basic carousel + timer, using CSS-transitions

				$('#foo1').carouFredSel({

					auto: {

						pauseOnHover: 'resume',

						progress: '#timer1'

					}

				}, {

					transition: true

				});



				//	Scrolled by user interaction

				$('#foo2').carouFredSel({

					auto: false,

					prev: '#prev2',

					next: '#next2',

					pagination: "#pager2",

					mousewheel: true,

					swipe: {

						onMouse: true,

						onTouch: true

					}

				});



				//	Variable number of visible items with variable sizes

				$('#foo3').carouFredSel({

					width: '100%',

					height: 'auto',

					prev: '#prev3',

					next: '#next3',

					scroll: 2,

					auto: false

				});



				//	Responsive layout, resizing the items

				$('#foo4').carouFredSel({

					responsive: true,

					width: '100%',

					scroll: 2,

					items: {

						

					//	height: '30%',	//	optionally resize item-height

						visible: {

							min: 2,

							max: 6

						}

					}

				});



				//	Fuild layout, centering the items

				$('#foo5').carouFredSel({

					width: '100%',

					scroll: 2,

					prev: '#preva',
					next: '#nexta',

				});



			});

		</script> 





<!--carrusel fin-->





		<script src="js/jquery.horizontal.scroll.js" type="text/javascript"></script>

		

		<script type="text/javascript">

		

			$(document).ready(function(){

				$('#horiz_container_outer').horizontalScroll();

			

			});

		

		</script>



<script>









    $(function() {



        var btn_movil = $('#nav-mobile'),

            menu = $('#menu').find('ul');



        // Al dar click agregar/quitar clases que permiten el despliegue del menú

        btn_movil.on('click', function (e) {

            e.preventDefault();



            var el = $(this);



            el.toggleClass('nav-active');

            menu.toggleClass('open-menu');

        })



    });

	

	

	

</script>




 <?php
 if(isset($_REQUEST['left']))
 {
 	?>
 	<script>
 		zoomExtendido(<?=$_REQUEST['left']?>,<?=$_REQUEST['bottom']?>,<?=$_REQUEST['right']?>,<?=$_REQUEST['top']?>);
 	</script>
 	<?php
 }
  if(isset($_REQUEST['lat']) and isset($_REQUEST['lon']))
 {
 	?>
 	<script>
 		//zoomExtendido(<?=$_REQUEST['left']?>,<?=$_REQUEST['bottom']?>,<?=$_REQUEST['right']?>,<?=$_REQUEST['top']?>);
 		addMarcador('<?=$CM_ICONO_SERV?>','35,35',<?=$_REQUEST['lat']?>,<?=$_REQUEST['lon']?>,"",'Ubicaci&oacute;n enviada');
   	moverCentro(<?=$_REQUEST['lat']?>,<?=$_REQUEST['lon']?>,17);
 	</script>
 	<?php
 }
 ?>



<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
</div>

<a href=# id=popup_CM onclick="levantar(this);" class=highslide></a>
<script type="text/javascript">
	
	$("#query").focus();
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45595484-1', 'chilemap.cl');
  ga('send', 'pageview');

</script>
<div id="popup_web" style="display: none;">
    <div class="content-popup">
        <div class="close_web"><a href="javascript:closeModalWeb();" id="close_web"><img src="images/cerrar.png"/></a></div>
        <div class="cont_web">Contenido POPUP</div>
    </div>
</div>
<script language="Javascript" type="text/javascript">
//<![CDATA[

<!-- Begin
document.oncontextmenu = function(){return false}
// End -->
//]]>
</script>
<?php
$categorias=getCategorias();
$regiones=getRegiones();
$comuna=getComunaxRegion($regiones[0][1]);
?>
<div id="grilla" title="Agrega tu Lugar Aquí">
	<div id="contenedor_grilla">
<table id="table_lugar">
	<tbody>
	<tr><td width=40%>Nombre Lugar</td><td width=60%><input id="nom_lugar" name="nom_lugar" class="form_drag" type="text" ></td></tr>
	<tr><td width=40%>Categoria</td>
		<td width=60%>
		<select id="cat" name="cat" class="form_drag">
			<?php
			foreach($categorias as $cat)
			{
			?>
			<option value=<?=$cat[0]?>><?=ucwords($cat[1])?></option>
			<?php
			}
			?>
		</select>
		</td>
	</tr>
	<tr><td width=40%>Region</td>
		<td width=60%>
		<select id="reg" name="reg" class="form_drag" onchange="getCiudad();">
			<?php
			foreach($regiones as $reg)
			{
			?>
			<option value=<?=$reg[1]?>><?=ucwords($reg[0])?></option>
			<?php
			}
			?>
		</select>
		</td>
	</tr>
	<tr><td width=40%>Comuna</td>
		<td width=60%>
		<select id="ciudad_lugar" class="form_drag" name="ciudad_lugar">
			<?php
			foreach($comuna as $com)
			{
			?>
				<option value="<?=strtolower($com[0])?>"><?=ucwords($com[0])?></option>
			<?php
			}
			?>
		</select>
		</td>
	</tr>
	<tr><td width=40%>Calle</td><td width=60%><input id="calle_lugar" name="calle_lugar" class="form_drag" type="text" ></td></tr>
	<tr><td width=40%>Número</td><td width=60%><input id="num_lugar" name="num_lugar" class="form_drag" type="text" ></td></tr>
	<tr><td width=40%>Direcciones</td>
		<td width=60%>
		<select id="direc_lugar" name="direc_lugar" class="form_drag" onchange="loadMarcadorDrag();">

	</select>
		</td>
	</tr>
	<tr><td width=40%>Longitud</td><td width=60%><input readonly=true class="form_drag" id="lng" name="lng" type="text" ></td></tr>
	<tr><td width=40%>Latitud</td><td width=60%><input readonly=true class="form_drag" id="lati" name="lati" type="text" ></td></tr>
	<tr><td width=40%></td><td width=60%><br><a class="btn" onclick="buscaLugar();">Validar</a> | <a class="btn" onclick="saveLugar();">Guardar</a></td></tr>

</tbody>
</table>	
<div id="msg_error_lugar"></div>
<div class=msg_drag>Mueve el icono <img src="iconos/lugar.png" width=30px height=30px>para corregir la ubicación.</div>
<div class=msg_drag>Haz clic en validar para corroborar tu direccion en el mapa.</div>
</br>
<div id="map2"></div>	
</div>
</div>
<script>
	init2('map2');
	</script>
</body>

</html>

