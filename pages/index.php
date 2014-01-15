<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
session_start();
//try {
include("../lib/funciones.php");
require_once('../lib/nusoap.php'); 
$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeControlDeUsuarios?WSDL';
$client = new SOAPClient($wsdl_url);
$client->decode_utf8 = false;

if (isset($_POST["Biniciar"])){
	
	if(isset($_POST["usuario"]) && $_POST["usuario"]!="" && isset($_POST["password"]) && $_POST["password"]!="" ){	
	
		$usuario = array('id' => $_POST["usuario"],'clave' => $_POST["password"],'borrado' => '0','diasValidezClave' => '10');
		$_SESSION["usuario"] = $usuario;		
		$sesion = array('idUsuario' => $usuario,'ip' => '127.0.0.1','borrado' => '0');
		$sesionUsuario = array('sesionActual' => $sesion);
		$resultadoLogueo = $client->LogIn($sesionUsuario);
		//echo '<pre>';print_r($resultadoLogueo);	
		
		if($resultadoLogueo->return->estatus == "OK"){
			$periodo = array('id' => '2','borrado' => '0');		
			$grupo = array('id' => '2','borrado' => '0');		
			$proceso = array('id' => '1','borrado' => '0','codigo' => '0','costo' => 12.22,'duracion' => '0','version' => '0');	
			$tareaInicial = array('id' => '1','borrado' => '0','tareaInicial' => '1','tareaInformativa' => '0','codigo' => '0','costo' => 12.22,'duracion' => '0','version' => '0');	
			$sesionActual = array('id' => $resultadoLogueo->return->sesions->id,'borrado' => '0');	
			$_SESSION["sesionUsuario"] = $sesionActual;
			$instancia = array('IdUsuario' => $usuario,'borrado' => '0');
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
			$resultadoCreacion = $client->CrearInstancia($parametros);
			//echo '<br><pre>';print_r($resultadoCreacion);
			
			if($resultadoCreacion->return->estatus == "OK"){
				$resultadoInstancia = $client->consultarInstanciaXMaxId();
				
				if($resultadoInstancia->return->estatus == "OK"){
					$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
					$client = new SOAPClient($wsdl_url);
					$client->decode_utf8 = false; 	
					$instancia = array('id' => $resultadoInstancia->return->instancias->id,'borrado' => '0');	
					$parametros = array('idInstancia' => $instancia,'idTarea' => $tareaInicial);	
					$resultadoActividad = $client->consultarActividadXInstanciaYTarea($parametros);
					//echo '<br><pre>';print_r($resultadoActividad);
					
					if($resultadoActividad->return->estatus == "OK"){
						$actividad = array('id' => $resultadoActividad->return->actividads->id,'borrado' => '0');	
						$parametros = array('actividadActual' => $actividad,
						           'usuarioActual' => $usuario);
						$resultadoAsignar = $client->AsignarActividad($parametros);
						echo '<br><pre>';print_r($resultadoAsignar);								
						$parametros = array('actividadActual' => $actividad,
									'sesionActual' => $sesionActual);								
						$resultadoInicio = $client->IniciarActividad($parametros);
						echo '<br><pre>';print_r($resultadoInicio);
						
						if($resultadoInicio->return->estatus == "OK"){
							$condicion = array('id' => '1','borrado'=>'0');	
							$parametros = array('actividadActual' => $actividad,
										'sesionActual' => $sesionActual,
									   	'condicionActual' => $condicion);
							$resultadoFinActividad = $client->FinalizarActividad($parametros);
							echo '<br><pre>';print_r($resultadoFinActividad);
							
							if($resultadoFinActividad->return->estatus == "OK"){								
								$_SESSION["resultadoLogueo"]=$resultadoLogueo;
								$_SESSION["resultadoCreacion"]=$resultadoCreacion;
								$_SESSION["resultadoInstancia"]=$resultadoInstancia;
								$_SESSION["resultadoActividad"]=$resultadoActividad;
								$_SESSION["resultadoInicio"]=$resultadoInicio;
								$_SESSION["resultadoFinActividad"]=$resultadoFinActividad;
								iraURL("../pages/principal.php");
							}else{
				             javaalert($resultadoFinActividad->return->estatus.": ".$resultadoFinActividad->return->observacion);
		                    }
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
		}else{
		javaalert($resultadoLogueo->return->estatus.": ".$resultadoLogueo->return->observacion);
		}
	}
}	
include("../views/index.php");
/* } catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	iraURL('../views/index.php');
}*/
?>

