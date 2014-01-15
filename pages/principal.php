<?php
session_start();
//try {
include("../lib/funciones.php");
require_once('../lib/nusoap.php');

if(isset($_POST["procesar"])){
	
	if($_SESSION["sesionUsuario"]!="" && $_SESSION["usuario"]!=""){
		
		$sesionActual = $_SESSION["sesionUsuario"];
		$usuarioActual = $_SESSION["usuario"];
		
		$periodo = array('id' => '2','borrado' =>'0');
		$grupo = array('id' => '2','borrado' => '0');		
		$proceso = array('id' => '1','borrado' => '0','codigo' => '0','costo' => 12.22,'duracion' => '0','version' => '0');
		$tareaInicial = array('id' => '2','borrado' => '0','tareaInicial' => '1','tareaInformativa' => '0','codigo' => '0','costo' => 12.22,'duracion' => '0','version' => '0');
		$instancia = array('IdUsuario' => $usuarioActual,'borrado' => '0');
		$parametros = array('instanciaActual' => $instancia,
					'sesionActual' => $sesionActual,
					'periodoActual' => $periodo,
					'grupoActual' => $grupo,
					'procesoActual' => $proceso,
					'tareaInicial' => $tareaInicial,
					'descripcionInstancia'=>'Descripcion_'.date("Y-m-d"),
					'referenciaInstancia'=>'Referencia_'.date("Y-m-d"),
					'estadoInstancia'=>'Estado_'.date("Y-m-d"));
					
		$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeInstancias?WSDL';
		$client = new SOAPClient($wsdl_url);
		$client->decode_utf8 = false;
		$resultadoCreacion=$client->CrearInstancia($parametros);
		//echo '<br><pre>';print_r($resultadoCreacion);
		
		if($resultadoCreacion->return->estatus == "OK"){
			$resultadoInstancia=$client->consultarInstanciaXMaxId();
			
			if($resultadoInstancia->return->estatus == "OK"){
				$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
				$client = new SOAPClient($wsdl_url);
				$client->decode_utf8 = false;
				$instancia = array('id' => $resultadoInstancia->return->instancias->id,'borrado' => '0');
				$_SESSION["instancia"] = $instancia;
				$parametros = array('idInstancia' => $instancia,'idTarea' => $tareaInicial);
				$resultadoActividad = $client->consultarActividadXInstanciaYTarea($parametros);
				//echo '<br><pre>';print_r($resultadoActividad);
				
				if($resultadoActividad->return->estatus == "OK"){
					$actividad = array('id' => $resultadoActividad->return->actividads->id,'borrado' => '0');
					$_SESSION["actividad"] = $actividad;
					$parametros = array('actividadActual' => $actividad,
								'usuarioActual' => $usuarioActual);
					$resultadoAsignar = $client->AsignarActividad($parametros);
					//echo '<br><pre>';print_r($resultadoAsignar);					
					$parametros = array('actividadActual' => $actividad,
								'sesionActual' => $sesionActual);						
					$resultadoInicio = $client->IniciarActividad($parametros);
					//echo '<br><pre>';print_r($resultadoInicio);
					
					if($resultadoInicio->return->estatus == "OK"){
						$_SESSION["resultadoCreacion2"]=$resultadoCreacion;
						$_SESSION["resultadoInstancia2"]=$resultadoInstancia;
						$_SESSION["resultadoActividad2"]=$resultadoActividad;
						$_SESSION["resultadoInicio2"]=$resultadoInicio;	
						iraUrl("procesandoCliente.php");
					}else{
				        javaalert($resultadoInicio->return->estatus.": ".$resultadoInicio->return->observacion);
		            }
				}else{
					javaalert($resultadoActividad->return->estatus.": ".$resultadoActividad->return->observacion);
		        }
			}else{
				javaalert($resultadoInstancia->return->estatus.": ".$resultadoInstancia->return->observacion);
		    }
		}else{
			javaalert($resultadoCreacion->return->estatus.": ".$resultadoCreacion->return->observacion);
		}
	}
}
include("../views/principal.php");

echo '<br>Resultado del Logueo:<pre>';print_r($_SESSION["resultadoLogueo"]);
echo '<br>Resultado del Resultado de la Creación de la Instancia:<pre>';print_r($_SESSION["resultadoCreacion"]);
echo '<br>Resultado de la Búsqueda de la Instancia Creada:<pre>';print_r($_SESSION["resultadoInstancia"]);
echo '<br>Resultado de la Búsqueda de la Actividad Inicial:<pre>';print_r($_SESSION["resultadoActividad"]);
echo '<br>Resultado de Iniciar Actividad :<pre>';print_r($_SESSION["resultadoInicio"]);
echo '<br>Resultado de Finalizar Actividad:<pre>';print_r($_SESSION["resultadoFinActividad"]);


/*} catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	iraURL('../views/index.php');
}*/
?>

