var path_query="includes/query.php";
var SIS_LON=0;
var SIS_LAT=0;
var bar2="";

var SIS_ACCU=0;
var SIS_CALLE="";
var SIS_NUM="";
var SIS_COMUNA="";

var SIS_NOM="";
var SIS_CALL="";
var SIS_NM="";
var SIS_COM="";
var SIS_DESC="";
var SIS_CATEG="";

var CM_farma_turno=false;
var ADDPTO=0;
var CM_path="http://www.chilemap.cl";
var CM_path_completo="http://www.chilemap.cl/index_mapa.php";
var CM_id_pto_share=""
var CM_tipo_pto_share="";    
var CM_home="index.php";	
var CM_logo="images/logo.png";
var CM_logo2="images/logo2.png";
var CM_caption='Tu lugar esta aqu&iacute;';
//document.addEventListener("offline", onready, false);
//document.addEventListener("online", onready, false);
document.addEventListener("deviceready", deviceListo, false);
function deviceListo()
{
	//document.getElementById('qr').value="";
	addServicios('Cajeros',1000,'32','img/ico_banco.png');
	bar2="";
	$("#output").load(path_query, 
				{tipo:6} 
					,function(){	
						
										
			
					}
			);
			loadInit();
			loadServiciosPanel();
			
			
}
function deviceListo2()
{
	$("#output").load(path_query, 
				{tipo:9} 
					,function(){	
										
			
					}
			);
}
function loadInicioSesion()
{
	//$.mobile.changePage('#mod_inicio', { role: 'dialog'});
	$.mobile.changePage('#mod_inicio', { role: 'dialog'});
}
function volver()
{
	
	
	history.go(-1);
}
function loadInicio()
{
	//window.location="home.html";
	var mail=$.trim(document.getElementById("mail").value);
	var clave=$.trim(document.getElementById("clave").value);
	if(mail !="" && clave!="" && validarEmail(mail))
	{
	$.mobile.loading( 'show', {
			text: 'Cargando...',
			textVisible: true,
			theme: 'a',
			html: ""
		});
		$("#msg_error_reg").load(path_query, 
			{tipo:7,mail:mail,clave:clave} 
				,function(){	
				
					$.mobile.loading( 'hide');
					
				}
		); 
	}else
		{
			//mensaje("Todos los campos obligatorios","myPopup_reg");
			$("#msg_error_reg").html("Todos los campos obligatorios");
		}
}

function loadMapa()
{
	//init('-70.444','-30.988',15);
	init();
	moverCentro(-33.458943,-70.656235,12);
}
function ubicacionActual()
{
	
	$.mobile.loading( 'show', {
				text: 'Obteniendo Coordenadas...',
				textVisible: true,
				theme: 'a',
				html: ""
			});
			
	navigator.geolocation.getCurrentPosition (function (pos)
		{
			var lat = pos.coords.latitude;
  		var lng = pos.coords.longitude;
  		var accu=pos.coords.accuracy.toFixed(2);
  		
  		SIS_LON=lng;
  		SIS_LAT=lat;
  		SIS_ACCU=accu;
  	  //addMarcadores(lng,lat,'Ubicacion Actual','img/marker.png',30,30);
  	  moverCentro(lat,lng,15);
  	  
  	  //verPuntosDrag();
  	  //activarDrag();

  	  
			
			txt_link=''+CM_path_completo+'?lon='+lng+'&lat='+lat+'';
			ShortUrl(txt_link);
			
		
			
			},noLocation,{timeout:3000});
}
function ShortUrl(bigurl)
{
$.getJSON('https://api-ssl.bitly.com/v3/shorten?',
    {
        format: "json",
        access_token: '87ed0ffc00201e3ac1e540d6e3db09d39c09c424',
        login: 'valeria.m.inostroza',
        longUrl: bigurl
    },
    function(response) {
        link_web=response.data.url;
        $("#output").load(path_query, 
				{tipo:2,lat:SIS_LAT,lon:SIS_LON} 
				,function(){	
					
					addMarcadores(SIS_LON,SIS_LAT,'<div class=titulo>Cerca de</div><div class=titulo_pop2>'+SIS_CALLE+' #'+SIS_NUM+'<br> '+SIS_COMUNA+'</div> <div id=botonera><img class=img_boton src=img/mail.png title=Enviar por correo onclick=compartirPto(0,5);> <img class=img_boton src=img/facebook.png title=Compartir en Facebook onclick=compartirFace("",5);><a href="https://twitter.com/share?url='+link_web+'&via=chilemap&text=Revisa este link" target=_BLANK><img  class=img_boton src=img/twitter.png title=Compartir en Twitter></a></div>','img/ico_current.png',40,40);
					$.mobile.loading( 'hide');
				}
		);
        
    }
);

}
function noLocation()
{
	$.mobile.loading( 'hide');
	
	mensaje("Error en la geolocalizaci&oacute;n, por favor intentelo nuevamente","myPopup");
	
}


function mensaje(texto,div)
{
	$( "#"+div ).html("<p>"+ texto+"</p>" );
                  $("#"+div).popup("close");
                  $("#"+div).popup("open");
}
function hideMensaje(div)
{
	  $("#"+div).popup("close");
}



function limpiarMapa()
{
	limpiarPuntosDrag();
	deleteTransantiago();
	deleteServicioMapaPagos(100);
	deleteMarcadores();
	$("#list_bus").html("");
			for(i=0;i<CM_servicios.length;i++)
			{
				
				deleteServicioMapa(i);
			}
			
						for(i=0;i<CM_servicios_pago.length;i++)
			{
		
				deleteServicioMapaPagos(i);
			}
}


function cerrarSesion()
{
	$("#output").load(path_query, 
				{tipo:8} 
					,function(){	
			
  						window.location.href=""+CM_home+"";
					
			
					}
			);
	
}
function validarEmail( email ) {
	  var valido=true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        valido=false;
        
   return valido;     
}

function buscar()
{
		var CM_centro= map.getCenter().transform(
        new OpenLayers.Projection("EPSG:900913"), // de WGS 1984
        new OpenLayers.Projection("EPSG:4326") // a Proyección Esférica Mercator
      );
      
      if(SIS_LON==0 || SIS_LAT==0)
      {
      	lon=CM_centro.lon;
      	lat=CM_centro.lat;
      }else
      	{
      		lon=SIS_LON;
      		lat=SIS_LAT;
      	}
	var qr=$.trim(document.getElementById("qr").value);
	var bus=1;
	$( '#tot_dir' ).html( '' );
	$( '#tot_pto' ).html( '' );
	if(qr!="")
	{
		$.mobile.loading( 'show', {
					text: 'Buscando...',
					textVisible: true,
					theme: 'a',
					html: ""
				});
		$("#list_bus").load(path_query, 
				{tipo:10,query:qr,bus:bus,lon:lon, lat:lat} 
					,function(){	
							
						//$('#cola_bus').trigger('create');
						$('#list_bus').listview('refresh');
			
					}
			);
			$("#list_bus2").load(path_query, 
				{tipo:3,query:qr,lon:lon, lat:lat} 
					,function(){	
						$.mobile.loading( 'hide');	
						//$('#cola_bus').trigger('create');
						$('#list_bus2').listview('refresh');
			
					}
			);
	}else
		{
			mensaje("Debe ingresar una consulta","myPopup");
		}
		
		
}

function verMapa(texto,lon,lat,icono)
{
	
	moverCentro(lat,lon,15);
  addMarcadores(lon,lat,texto,icono,30,30);
  $('#mypanel2').panel('close');
}
function loadCategorias()
{
	$("#list_cat").load(path_query, 
				{tipo:11} 
					,function(){	
							
						//$('#cola_bus').trigger('create');
						$('#list_cat').listview('refresh');
						
  	
					
			
					}
			);
}

function loadCategMapa(categ)
{
	
	
	$("#list_bus").load(path_query, 
				{tipo:12, cat:categ} 
					,function(){	
						$('#list_bus').listview('refresh');
						verPuntosDrag();
					}
			);
}

function senContacto()
{
	var mail=$.trim(document.getElementById("mail_con").value);
	var nom=$.trim(document.getElementById("nom_con").value);
	var tel=$.trim(document.getElementById("tel_con").value);
	var descrip=$.trim(document.getElementById("descrip_con").value);
	
	if(mail !="" && nom!="" && validarEmail(mail) && descrip!="")
	{
		$("#output").load(path_query, 
				{tipo:13, mail:mail,nom:nom,tel:tel,descrip:descrip} 
					,function(){
						$("#mod_contacto").dialog("close");	
						setTimeout('mensaje("Mensaje Enviado.","myPopup");',500);
						
						
					}
			);
		
	}else
		{
			$("#msg_error_contacto").html("Nombres, mail y descripci&oacute;n son campos obligatorios.");
		}
}
function regUser()
{
	
	var nombre=document.getElementById("nombre").value;
	var clave=$.trim(document.getElementById("clave_regi").value);
	var mail=document.getElementById("mail_regi").value;
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
		var capaContenedora = document.getElementById("msg_error_registro");
		capaContenedora.innerHTML=msg;
		
	}else
	{
		
		$("#msg_error_registro").load(path_query, 
			{tipo:14, nombre:""+nombre+"", clave:""+clave+"", mail:""+mail+"", tipo_usuario:1,news:newsletter, pais:"Chile"} 
				,function(){	
				}
		);
	}
}
function msgActivacion()
{
	var mail=document.getElementById("mail").value;
$("#output").load("confirmacion.php", 
			{tipo:1, mail:mail} 
				,function(){	
				}
		);
}
function loadServiciosPanel()
{
	
$("#serv_ptos").load(path_query, 
			{tipo:15} 
				,function(){	
					$('#serv_ptos').trigger('create');
				}
		);
}
function loadFavoritos()
{
	
$("#cont_favoritos").load(path_query, 
			{tipo:17} 
				,function(){	
					$('#cont_favoritos').trigger('create');
				}
		);
}
function addFavorito(cm_estadoSesion,CM_id_data,CM_tipo_data)
{
	
	if(cm_estadoSesion==0)
	{
		$("#output").load("includes/query.php", 
			{tipo:19, id:CM_id_data, tipo_data:CM_tipo_data} 
				,function(){	
					loadFavoritos();
					setTimeout('mensaje("Punto ya agregado a favoritos","myPopup");',300);
				}
		);
	}else
	{
		//launchWindow('#mod_sesion');
		//$.mobile.changePage('#m_sesion', 'pop', true, true);
		$.mobile.changePage('#mod_sesion', { role: 'dialog'});
	}
	
}
function deleteFavoritos(CM_id)
{
	$.mobile.loading( 'hide');
	$("#output").load("includes/query.php", 
			{tipo:18, id_fav:CM_id} 
				,function(){	
					loadFavoritos();					
					setTimeout('mensaje("Agregado a Favoritos.","myPopup");',500);
					
				}
		);
}
function compartirPto(CM_id,CM_tipo)
{
	CM_id_pto_share=CM_id;
	CM_tipo_pto_share=CM_tipo;    
	
	//$.mobile.changePage('#m_mail', 'pop', true, true);
	$.mobile.changePage('#m_mail', { role: 'dialog'});
}

function validaMail(CM_cadena)
{	
	CM_cadena=CM_id_pto_share;
	var nombre=document.getElementById("nombre_mail").value;
	var nombre_d=document.getElementById("nombre_dest").value;
	
	var mail=document.getElementById("mail_mail").value;
	var mensaje=document.getElementById("mensaje_mail").value;
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
	if(CM_tipo_pto_share==5)
	{
		CM_link=CM_path_completo+"?lon="+SIS_LON+"&lat="+SIS_LAT;
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
		
		
		$("#msg_mail").load("includes/query.php", 
			{tipo:20, nombre:nombre, nombre_d:nombre_d, mail:mail, msg:mensaje,link:CM_link} 
				,function(){	
					$("#m_mail").dialog("close");	
					
				}
		);
		
	}
}
function compartirFace(CM_link,tipo)
{
	
	CM_link=CM_path_completo+"?ptot=1&pto="+CM_link+"";
	if(CM_link=="")
	{
		CM_link=CM_path;
	}
	if(tipo==5)
	{
		CM_link=CM_path_completo+"?lon="+SIS_LON+"&lat="+SIS_LAT;
	}
  	FB.ui({ method: 'feed',
    	name: 'Chilemap.cl',
      link: ''+CM_link+'',
      picture: ""+CM_path+"/"+CM_logo2+"",
      caption: CM_caption,
      description: 'Revisa este link!'       
   });
}


function loadRecupera()
{
			
	var mail=document.getElementById("mail_rec").value;
		$("#msg_error_rec").html("");
	if(!validarEmail(mail))
	{
		$("#msg_error_rec").html("El formato del mail es incorrecto");
	}else
		{
			$("#msg_error_rec").load("includes/query.php", 
			{tipo:21, mail:mail} 
				,function(){	
					//$("#mod_sesion").dialog("close");
					//$("#mod_recupera").dialog("close");	
					
					
					
				}
		);		
		}
}