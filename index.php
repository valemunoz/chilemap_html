<?php
require_once ('includes/mensajes.php');

require_once("includes/Mobile_Detect.php");
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
if($deviceType!="computer")
{
	?>
			<script>
	window.location="<?=$CM_path_mobile?>";
	</script>
	<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
 


<link href="css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/mo.css" rel="stylesheet" type="text/css">
<link href="css/modal.css" rel="stylesheet">
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/ext/jquery-1.7.2.min.js"></script>
<script>

$(document).ready(function() {	
	
	//Put in the DIV id you want to display
	//launchWindow('#dialog1');
	
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

<style>
body {
font-family:verdana;
font-size:15px;
}

a {color:#333; text-decoration:none}
a:hover {color:#ccc; text-decoration:none}

#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:rgba(0, 0, 0, 0.68);
  display:none;
}
  
#boxes .window {
  position:fixed;
  width:440px;
  height:200px;
  display:none;
  z-index:9999;
  padding:20px;
}

#boxes #dialog {
  width:375px; 
  height:203px;
  padding:10px;
  background-color:#ffffff;
}

#boxes #dialog1 {
  width:278px; 
  height:203px;
}

#dialog1 .d-header {
  background:url(images/login-header.png) no-repeat 0 0 transparent; 
  width:375px; 
  height:150px;
}

#dialog1 .d-header input {
  position:relative;
  top:60px;
  left:100px;
  border:3px solid #cccccc;
  height:22px;
  width:200px;
  font-size:15px;
  padding:5px;
  margin-top:4px;
}

#dialog1 .d-blank {
  float:left;
  background:url(images/login-blank.png) no-repeat 0 0 transparent; 
  width:267px; 
  height:53px;
}

#dialog1 .d-login {
  float:left;
  width:108px; 
  height:53px;
}

#boxes #dialog2 {
  background:url(images/notice.png) no-repeat 0 0 transparent; 
  width:326px; 
  height:229px;
  padding:50px 0 20px 25px;
}
</style>
</head>
<body>
<?PHP
include("includes/funciones.php");
?>
<img id="imagenfondo" src="images/fondo2.jpg" width="1920" height="1080">
<div id="container">

<div class="logo"><img src="images/logo_inicio.png" alt="logo_inicio"></div>

<div class="texto_inicio"> 

<div class="text" style="float:left">Tu lugar esta aquì</div>

<div class="tex1t" style="float:left">

<input class="imp_inicio" name="qry" id="qry" onKeyPress="enterpressalert(event, this,1)" type="text" placeholder="Ejemplo: Las Condes 8967/bancos"></div>


<div class="text2" style="float:left; outline:none !important;">

<a style="outline:none !important;" href="javascript:buscaLupa();" class="btn go" id="boton_modal">

<img style="outline:none !important;" src="images/lupa.png" alt="lupa"></a></div>

</div>





		</div>

<div id="boxes">


  
<!-- Start of Login Dialog -->  
<div id="dialog1" class="window">



 <?PHP
 include("modal_registro.php");
 ?>
</div>
<!-- End of Login Dialog -->  



<!-- Start of Sticky Note -->
<div id="dialog2" class="window">
  sitio de mapas, busqueda de direcciones, mapa, gis, georeferenciacion, transantiago, bip, lugares bip <br/><br/>
<input type="button" value="Close it" class="close"/>
</div>
<!-- End of Sticky Note -->



<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
</div>


<script>
	$("#qry").focus();
</Script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45595484-1', 'chilemap.cl');
  ga('send', 'pageview');

</script>
<script language="Javascript" type="text/javascript">
//<![CDATA[

<!-- Begin
document.oncontextmenu = function(){return false}
// End -->
//]]>
</script>
</body>
</html>
