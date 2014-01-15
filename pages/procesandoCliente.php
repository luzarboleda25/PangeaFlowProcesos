<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
session_start();
//try {
include("../lib/funciones.php");
require_once('../lib/nusoap.php');

if(isset($_POST["procesar"])){
		
	if($_SESSION["sesionUsuario"]!="" && $_SESSION["usuario"]!=""){

		if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["telefono"])
			&& isset($_POST["direccion"])  && $_POST["nombre"]!="" && $_POST["apellido"]!=""
			&& $_POST["telefono"]!="" && $_POST["direccion"]!=""){
				
			$nombre = $_POST["nombre"];
			$apellido = $_POST["apellido"];
			$telefono = $_POST["telefono"];
			$direccion = $_POST["direccion"];
				
			$sesionActual = $_SESSION["sesionUsuario"];
			$actividad = $_SESSION["actividad"];
				
			$tareaInicial = array('id' => '2','borrado' => '0','tareaInicial' => '1','tareaInformativa' => '0','codigo' => '0','costo' => 12.22,'duracion' => '0','version' => '0');
			$idTarea = array('idTarea' => $tareaInicial);
			$condicion = array('id' => '1','borrado' => '0');	 
			$parametros= array('actividadActual' => $actividad,
						'sesionActual' => $sesionActual,
						'condicionActual' => $condicion);
			$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
			$client = new SOAPClient($wsdl_url);
			$client->decode_utf8 = false;
			$resultadoFinActividad = $client->FinalizarActividad($parametros);
			//echo '<br><pre>';print_r($resultadoFinActividad);
				
			if($resultadoFinActividad->return->estatus == "OK"){
				$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeTransicion?WSDL';
				$client = new SOAPClient($wsdl_url);
				$client->decode_utf8 = false;
				$resultadoTransicion=$client->consultaTransicionXTarea($idTarea);
				//echo '<br><pre>';print_r($resultadoTransicion);
				if($resultadoTransicion->return->estatus == "OK"){
					$siguienteTarea=$resultadoTransicion->return->transicions->idTareaDestino;
					//echo '<br><pre>';print_r($siguienteTarea);
					$_SESSION["siguienteTarea"] = $siguienteTarea;
					
					$_SESSION["resultadoTransicion"]=$resultadoTransicion;
					$_SESSION["resultadoFinActividad2"]=$resultadoFinActividad;
					iraUrl("procesandoFactura.php");
				}else{
					javaalert($resultadoTransicion->return->estatus.": ".$resultadoTransicion->return->observacion);
		        }
			}else{
				javaalert($resultadoFinActividad->return->estatus.": ".$resultadoFinActividad->return->observacion);
		    }
		}
	}
}
include("../views/procesandoCliente.php");

echo '<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>';
echo '<br>Resultado del Resultado de la Creación de la Instancia:<pre>';print_r($_SESSION["resultadoCreacion2"]);
echo '<br>Resultado de la Búsqueda de la Instancia Creada:<pre>';print_r($_SESSION["resultadoInstancia2"]);
echo '<br>Resultado de la Búsqueda de la Actividad Inicial:<pre>';print_r($_SESSION["resultadoActividad2"]);
echo '<br>Resultado de Iniciar Actividad :<pre>';print_r($_SESSION["resultadoInicio2"]);

/*} catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	iraURL('../views/index.php');
}*/
?>
