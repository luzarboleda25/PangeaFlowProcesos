<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
session_start();
//try {
include("../lib/funciones.php");
require_once('../lib/nusoap.php');

if($_SESSION["sesionUsuario"]!="" && $_SESSION["usuario"]!="" && $_SESSION["instancia"]!="" && $_SESSION["siguienteTarea"]!=""){

	$instancia = $_SESSION["instancia"];
	$tareaInicial = $_SESSION["siguienteTarea"];
	$sesionActual = $_SESSION["sesionUsuario"];
	$usuarioActual = $_SESSION["usuario"];
		
	$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
	$client = new SOAPClient($wsdl_url);
	$client->decode_utf8 = false;
	$parametros = array('idInstancia' => $instancia,'idTarea' => $tareaInicial);
	$resultadoActividad = $client->consultarActividadXInstanciaYTarea($parametros);
	//echo '<br><pre>';print_r($resultadoActividad);
				
	if($resultadoActividad->return->estatus == "OK"){
		$actividad = array('id' => $resultadoActividad->return->actividads->id,'borrado' => '0');
		$parametros = array('actividadActual' => $actividad,
					'usuarioActual' => $usuarioActual);
		$resultadoAsignar = $client->AsignarActividad($parametros);
		//echo '<br><pre>';print_r($resultadoAsignar);			
		$parametros = array('actividadActual' => $actividad,
					'sesionActual' => $sesionActual);	
		$resultadoInicio = $client->IniciarActividad($parametros);
		//echo '<br><pre>';print_r($resultadoInicio);
					
		if($resultadoInicio->return->estatus == "OK"){
			include("../views/procesandoFactura.php");
		}
	}
}


if(isset($_POST["procesar"])){
					
	if(isset($_POST["descripcion"]) && isset($_POST["monto"])
		&& $_POST["descripcion"]!="" && $_POST["monto"]!=""){
				
		$descripcion = $_POST["descripcion"];
		$monto = $_POST["monto"];
						
		$idTarea = array('idTarea' => $tareaInicial);
		$condicion = array('id' => '1','borrado' => '0');
		$parametros= array('actividadActual' => $actividad,
					'sesionActual' => $sesionActual,
					'condicionActual' => $condicion);
		$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
		$client = new SOAPClient($wsdl_url);
		$client->decode_utf8 = false;
		$resultadoFinActividad = $client->FinalizarActividad($parametros);
		echo '<br><pre>';print_r($resultadoFinActividad);
						
		if($resultadoFinActividad->return->estatus == "OK"){
			iraUrl("index.php");
		}
	}
}
/*} catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	iraURL('../views/index.php');
}*/
?>
