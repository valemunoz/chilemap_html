var contenedor_resultado="resultados_a";
var contenedor_resultado_servicio="resultados_b";
//var CM_path="http://www.chilemap.cl";
//var CM_path_completo="http://www.chilemap.cl/index_mapa.php";
//var CM_url_print="http://www.chilemap.cl/print.php";

var CM_path="http://localhost/chilemap_html";
var CM_path_completo="http://localhost/chilemap_html/index_mapa.php";
var CM_url_print="http://localhost/chilemap_html/print.php";
//
var CM_id_pto_share=0;
var CM_tipo_pto_share;
var CM_logo="images/logo.png";
var CM_logo2="images/logo2.png";
var CM_caption='Tu lugar esta aqu&iacute;';

var CM_farma_turno=false;
function regUser()
{
	
	var nombre=document.getElementById("nombre_reg").value;
	var clave=$.trim(document.getElementById("clave_reg").value);
	var mail=document.getElementById("mail_reg").value;
	var newsletter=document.getElementById("envio").checked;
	var msg="";
	var valida=true;
	if($.trim(nombre)=="" || $.trim(clave)=="" || $.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(clave.length != 6)
	{		
		msg=""+msg+" <strong>La clave debe contener 6 caracteres.</strong><br>";
		valida=false;
	}
	
	if(!valida)
	{
		var capaContenedora = document.getElementById("msg_error_regi");
		capaContenedora.innerHTML=msg;
		
	}else
	{
		var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=1&nombre="+nombre+"&clave="+clave+"&mail="+mail+"&tipo_usuario=1&news="+newsletter+"&pais=chile");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);
	}
}
function userReg()
{
	setTimeout("closeModalInicio();",4000)
}
function closeModalInicio()
{
	$('#mask').hide("slow");
		$('.window').hide("slow");
}


function validarEmail( email ) {
	  var valido=true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        valido=false;
        
   return valido;     
}

function incioSesion()
{
	
	var clave=$.trim(document.getElementById("clave").value);
	var mail=document.getElementById("mail").value;
	var msg="";
	var valida=true;
	if($.trim(clave)=="" || $.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(!valida)
	{
		var capaContenedora = document.getElementById("msg_error");
		capaContenedora.innerHTML="<br>"+msg;
	}else
	{
		var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=2&clave="+clave+"&mail="+mail+"");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);
		
	}
	
}

function cerrarSesion()
{
	
		var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=3");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);
}

function validaContacto()
{
	
	var nombre=document.getElementById("nombre_contac").value;
	var telefono=$.trim(document.getElementById("tele_contac").value);
	var mail=document.getElementById("mail_contac").value;
	var mensaje=document.getElementById("mensaje_contacto").value;
	//alert(nombre+"-"+telefono+"-"+mail+"-"+mensaje);
	var msg="";
	$("#msg_contacto").html(msg);
	var valida=true;
	if($.trim(nombre)=="" || $.trim(mail)=="" || $.trim(mensaje)=="")
	{		
		valida=false;
		msg="<strong>Los campos nombre,mail y mensaje son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(telefono.length>0 && !$.isNumeric(telefono) )
	{
		msg=""+msg+" <strong>El telefono solo debe contener numeros.</strong><br>";
		valida=false;
	}
	if(telefono.length>0 && telefono.length <7)
	{
		msg=""+msg+" <strong>El telefono debe contener al menos 7 caracteres.</strong><br>";
		valida=false;
	}
	if(!valida)
	{
		
		
		$("#msg_contacto").html(msg);
		
	}else
	{
		/*var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=4&nombre="+nombre+"&telefono="+telefono+"&mail="+mail+"&msg="+mensaje+"");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);*/
		$("#msg_contacto").load("query.php", 
			{tipo:4,nombre:nombre,telefono:telefono,mail:mail,msg:mensaje} 
				,function(){	
				}
		);
	}
}

function olvidoContrasena()
{
		//var capaContenedora = document.getElementById('reg_modal');
		//capaContenedora.innerHTML=capaContenedora.innerHTML='<font class=AP_titulo2>Buscando...</font>';
		/*$("#reg_modal").load("olvido.php", 
			{tipo:1} 
				,function(){	
				}
		);*/
		
		launchWindow('#mod_olvido');
}

function validOlvido()
{
	var mail=document.getElementById("mail_olv").value;
	var valida=true;
	var capaContenedora = document.getElementById("msg_olvido");
	var msg="";
	if($.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(!valida)
	{
		
		
		capaContenedora.innerHTML=msg;
		
	}else
	{
		
		var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=5&mail="+mail+"");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);
	}
	
}

function msgActivacion()
{
	var mail=document.getElementById("mail").value;
$("#msg_error").load("confirmacion.php", 
			{tipo:1, mail:mail} 
				,function(){	
				}
		);
}

/*
	Buscador
*/
function buscar(CM_query)
{
	
	var CM_centro= map.getCenter().transform(
        new OpenLayers.Projection("EPSG:900913"), // de WGS 1984
        new OpenLayers.Projection("EPSG:4326") // a Proyección Esférica Mercator
      );
	if($.trim(CM_query)!="")
	{
		var query=$.trim(CM_query);
	}else
	{
		var query=$.trim(document.getElementById("query").value)
	}
	if(query!="")
	{
		showLoad();
		$("#output").load("query.php", 
			{tipo:12,q:query} 
				,function(){	
				}
		);
		var capaContenedora = document.getElementById(contenedor_resultado);
		capaContenedora.innerHTML='<font class=AP_titulo2>Buscando... Paciencia esto puede tardar unos segundos. <br>Estamos buscando en nuestro contenedor y en otros.</font>';
		
		var capaContenedora2 = document.getElementById("cont_direc");
		capaContenedora2.innerHTML='<img src="images/495.gif">';
		
		
		$("#"+contenedor_resultado+"").load("query_mapa.php", 
			{tipo:1,act:1, consulta:encodeURI(query), lon:CM_centro.lon, lat:CM_centro.lat} 
				,function(){
						
				}
		);
		
		
		
		var capaContenedora3 = document.getElementById("cont_serva");
		capaContenedora3.innerHTML='<img src="images/495.gif">';
		showLoad();
		var capaContenedora4 = document.getElementById(contenedor_resultado_servicio);
		capaContenedora4.innerHTML='<font class=AP_titulo2>Buscando...</font>';
		$("#"+contenedor_resultado_servicio+"").load("query_mapa.php", 
			{tipo:1,act:2, consulta:encodeURI(query), lon:CM_centro.lon, lat:CM_centro.lat} 
				,function(){	
					hideLoad();
				}
		);

	}else
	{
		alert("Debe ingresar algo");
	}
}


function compartirFace(CM_link)
{	
	if(CM_link=="")
	{
		CM_link=CM_path;
	}
  	FB.ui({ method: 'feed',
    	name: 'Chilemap.cl',
      link: ''+CM_link+'',
      picture: ""+CM_path+"/"+CM_logo2+"",
      caption: CM_caption,
      description: 'Revisa este link!'       
   });
}

function loadServicios()
{
		//var capaContenedora = document.getElementById("foo3");
		//capaContenedora.innerHTML=capaContenedora.innerHTML='<font class=AP_titulo2>Buscando...</font>';
		$("#servicios_2").load("query_mapa.php", 
			{tipo:3} 
				,function(){	
				}
		);
}
/*FIN*/
function replaceAll( text, busca, reemplaza ){

  while (text.toString().indexOf(busca) != -1)

      text = text.toString().replace(busca,reemplaza);

  return text;

}
function buscaLupa()
{
	
	var query=$.trim(document.getElementById("qry").value);
	query=replaceAll(query,' ','-');
	
	if(query!="")
	{		
		//window.location=""+CM_path+"/index_mapa.php?q="+encodeURI(query)+"";
		
		window.location=""+CM_path+"/"+query+".htm";
	}else
	{
		window.location=""+CM_path+"/index_mapa.php";
	}
	
}

function validaMail(CM_cadena)
{	
	var nombre=document.getElementById("nombre_cont").value;
	var nombre_d=document.getElementById("nombre_dest").value;
	
	var mail=document.getElementById("mail_cont").value;
	var mensaje=document.getElementById("msg_cont").value;
	var CM_link;
	if(CM_cadena=="" && CM_cadena==0)
	{
		AM_exten=getExtencion();
		CM_link=CM_path_completo+"?left="+AM_exten.left+"&bottom="+AM_exten.bottom+"&right="+AM_exten.right+"&top="+AM_exten.top;
	}
	if(CM_cadena>0)
	{
		CM_link=CM_path_completo+"?ptot="+CM_tipo_pto_share+"&pto="+CM_id_pto_share;
		CM_id_pto_share=0;
		CM_tipo_pto_share=0;
		
	}
	
	//alert(CM_link);
	var msg="";
	var valida=true;
	if($.trim(nombre_d)=="" || $.trim(nombre)=="" || $.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	
	if(!valida)
	{
		
		
		$("#msg_mail").html(msg);
		
	}else
	{
		
		/*var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=6&nombre="+nombre+"&nombre_d="+nombre_d+"&mail="+mail+"&msg="+mensaje+"&link="+CM_link+"");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);*/
		
		$("#msg_mail").load("query.php", 
			{tipo:6, nombre:nombre, nombre_d:nombre_d, mail:mail, msg:mensaje,link:CM_link} 
				,function(){	
				}
		);
		
	}
}

function addFavorito(cm_estadoSesion,CM_id_data,CM_tipo_data)
{
	
	if(cm_estadoSesion==0)
	{
		$("#output").load("query.php", 
			{tipo:7, id:CM_id_data, tipo_data:CM_tipo_data} 
				,function(){	
				}
		);
	}else
	{
		launchWindow('#mod_sesion');
	}
	
}
function loadPHP(CM_archivo,CM_div)
{
	$("#"+CM_div+"").load(""+CM_archivo+"", 
			{tipo:1} 
				,function(){	
				}
		);
}
function editUser()
{
	
	var nombre=document.getElementById("nombre").value;
	var mal=document.getElementById("ml").value;
	
	var clave=$.trim(document.getElementById("contn").value);
	var clave_r=$.trim(document.getElementById("contn2").value);
	
	var msg="";
	var valida=true;
	if($.trim(nombre)=="")
	{		
		valida=false;
		msg +="<strong>Nombre es un campo obligatorio.</strong><br>";
	}
	if($.trim(clave)!="")
	{
		if(clave.length != 6)
		{		
			msg +=""+msg+" <strong>La clave debe contener 6 caracteres.</strong><br>";
			valida=false;
		}

		if($.trim(clave) != $.trim(clave_r))
		{		
			msg=""+msg+" <strong>Claves no coinsiden.</strong><br>";
			valida=false;
		}
	}
	if(!valida)
	{
		var capaContenedora = document.getElementById("msg_datos");
		capaContenedora.innerHTML=msg;
		
	}else
	{
		/*var body = document.getElementsByTagName("body")[0];
		var scr = document.createElement("script");
		scr.setAttribute("type","text/javascript");
		scr.setAttribute("src","query.php?tipo=8&nombre="+nombre+"&cl="+clave+"&ml="+mal+"");
		scr.setAttribute("id","scriptTemporal");
		body.appendChild(scr);*/
		
		$("#output").load("query.php", 
			{tipo:8, nombre:nombre, cl:""+clave+"", ml:""+mal+""} 
				,function(){	
				}
		);
	}
}

function closeUser(mail)
{	
	$("#output").load("query.php", 
			{tipo:9,ml:""+mail+""} 
				,function(){	
				}
		);
}
function delFav(CM_id_fav,CM_usuario)
{
	$("#msg_fav").load("query.php", 
			{tipo:10,id_fav:CM_id_fav} 
				,function(){	
					loadFavoritos(CM_usuario);
				}
		);
		

}
function loadFavoritos(CM_id_usuario)
{
	$("#cont_favo").load("query.php", 
			{tipo:11, id_usuario:CM_id_usuario} 
				,function(){	
				}
		);
}
function compartirPto(CM_id,CM_tipo)
{
	CM_id_pto_share=CM_id;
	CM_tipo_pto_share=CM_tipo;
	loadPHP('modal_mail.php','mod_mail');
	launchWindow('#mod_mail');
}
function closeModalWeb()
{
	 $('#popup_web').fadeOut('slow');
}

function showMensaje(CM_texto)
{
	$('.cont_web').html(CM_texto);
 $('#popup_web').fadeIn('fast');
 $('#popup_web').fadeOut(1500);
				
}
function showAlerta(CM_texto,CM_fideout)
{
	$('.cont_web').html(CM_texto);
 $('#popup_web').fadeIn('fast');
 $('#popup_web').fadeOut(CM_fideout);
				
}
function enterpressalert(e, textarea,id){
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code == 13) 
	{ //Enter keycode
		if(id==1)
		{
			buscaLupa();
		}
		if(id==2)
		{
			buscar('');
		}
 		
	}
}

function loadFarmaTurno()
{
	var elm=document.getElementById("img_serv_001");
	if(CM_farma_turno==true)
	{
		elm.className="serv_circulo_off";
		CM_farma_turno=false;
		deleteServicioMapa(0);
		try
		{
			$("#cont_otro").html("");
			$("#resultados_c").html("");
			
	}catch(e){}
		
	}else
	{
	
			elm.className="serv_circulo_on";
			CM_farma_turno=true;
			loadFarma();
					
	}
}

function loadFarma()
{
	$('.cont_web').html("Buscando...<br><img src='images/495.gif'>");
 $('#popup_web').fadeIn('fast');
	var AM_exten = getExtencion();
	$("#output").load("query_mapa.php", 
			{tipo:11, loni:AM_exten.left, lati:AM_exten.bottom, lond:AM_exten.right, lats:AM_exten.top} 
				,function(){	
					closeModalWeb();
				}
		);
}

function changeFlash()
{
	
	setInterval("cambiaFlash();", 10000);
}
function cambiaFlash()
{
	
	$("#output").load("query.php", 
			{tipo:13} 
				,function(){	
					
				}
		);
}

/*funciones subir lugar*/
function OpenModalGrilla(CM_lon,CM_lat)
{
	limpiarPuntosDrag();
	if(CM_lon==0 || CM_lat==0)
	{
	var CM_centro= map.getCenter().transform(
        new OpenLayers.Projection("EPSG:900913"), // de WGS 1984
        new OpenLayers.Projection("EPSG:4326") // a Proyección Esférica Mercator
      );
      CM_lon=CM_centro.lon;
      CM_lat=CM_centro.lat;
  }
  
      addMarcadorVector(CM_lon,CM_lat,"","iconos/lugar.png",40,40);
      moverCentro2(CM_lon,CM_lat,map.getZoom());
      activarDrag();
    document.getElementById("lng").value=CM_lon;
        document.getElementById("lati").value=CM_lat;  
		$( "#grilla" ).dialog( "open" );
		
}
function loadMarcadorDrag()
{
	limpiarPuntosDrag();
	var coord=document.getElementById("direc_lugar").value;
	
	CM_lonlat=coord.split(",");
	addMarcadorVector(CM_lonlat[0],CM_lonlat[1],"","iconos/lugar.png",40,40);
  moverCentro2(CM_lonlat[0],CM_lonlat[1],17);
   document.getElementById("lng").value=CM_lonlat[0];
        document.getElementById("lati").value=CM_lonlat[1];  
  //activarDrag();
}
function CloseModalGrilla()
{
		$( "#grilla" ).dialog( "close" );
}

function moveDrag(feature, pixel)
{
	
    		lon=feature.geometry['x'];
    		lat=feature.geometry['y'];
    		lonlat=new OpenLayers.LonLat(lon,lat).transform(
        new OpenLayers.Projection("EPSG:900913"), // de WGS 1984
        new OpenLayers.Projection("EPSG:4326") // a Proyección Esférica Mercator
  			);
    		
         document.getElementById("lng").value=lonlat.lon;
         document.getElementById("lati").value=lonlat.lat;
  
}

function getCiudad()
{
	
	var region=document.getElementById("reg").value;
	$("#ciudad_lugar").load("query.php", 
			{tipo:14, region:region} 
				,function(){	
					
				}
		);
}

function buscaLugar()
{
	var calle=document.getElementById("calle_lugar").value;
	var numero=document.getElementById("num_lugar").value;
	var comuna=document.getElementById("ciudad_lugar").value;
	if($.trim(calle)!="" && $.trim(numero)!="" && $.trim(comuna)!="")
	{
		$("#direc_lugar").load("query.php", 
			{tipo:15, calle:calle, numero:numero,comuna:comuna} 
				,function(){	
					
				}
		);
	}else
		{
			msg="Los campos Ciudad, Calle y Numero son obligatorios";
			$("#msg_error_lugar").html(msg);
		}
}
function saveLugar()
{
	var valida=true;
	var msg="";
	var lugar=document.getElementById("nom_lugar").value;
	var categoria=document.getElementById("cat").value;
	var region=document.getElementById("reg").value;
	
	var calle=document.getElementById("calle_lugar").value;
	var numero=document.getElementById("num_lugar").value;
	var comuna=document.getElementById("ciudad_lugar").value;
	
	
	
	var lon=document.getElementById("lng").value;
	var lat=document.getElementById("lati").value;
	if($.trim(lugar)=="" || $.trim(categoria)=="" || $.trim(region)=="" || $.trim(calle)=="" || $.trim(numero)=="" || $.trim(comuna)=="" || $.trim(lon)=="" || $.trim(lat)=="")
	{
		valida=false;
		msg +="<br>Todos los campos son obligatorios";
	}
	if(valida)
	{
	$("#msg_error_lugar").load("query.php", 
			{tipo:16, calle:calle, numero:numero,comuna:comuna,lugar:lugar,categoria:categoria,region:region,lon:lon,lat:lat} 
				,function(){	
					
				}
		);
	}else
		{
			$("#msg_error_lugar").html(msg);
		}
}
/*fin funciones sbir lugar*/