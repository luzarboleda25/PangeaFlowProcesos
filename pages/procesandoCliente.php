<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
  include("../lib/funciones.php");
  require_once('../lib/nusoap.php');
  
  //Codigo para guardar
	if(isset($_POST["procesar"])){

		if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["telefono"]) 
			&& isset($_POST["direccion"])  && $_POST["nombre"]!="" && $_POST["apellido"]!="" 
			&& $_POST["telefono"]!="" && $_POST["direccion"]!=""){
				
				$nombre = $_POST["nombre"];
				$apellido = $_POST["apellido"];
				$telefono = $_POST["telefono"];
				$direccion = $_POST["direccion"];
				
				javaalert("Datos Procesados");
  
  				$periodo= array('id' => '2','borrado'=>'0');		
				$grupo= array('id' => '2','borrado'=>'0');		
			    $proceso= array('id' => '2','borrado'=>'0','codigo'=>'0','costo'=>12.22,'duracion'=>'0','version'=>'0');	
				$tareaInicial= array('id' => '2','borrado'=>'0','tareaInicial'=>'1','tareaInformativa'=>'0','codigo'=>'0','costo'=>12.22,'duracion'=>'0','version'=>'0');	
				$usuario='thunder';
				$id='497';
				
				$sesionActual= array('id' => $id,'borrado'=>'0');	
				$instancia=array('IdUsuario'=>$usuario,'borrado'=>'0');				
				$parametros= array('instanciaActual' => $instancia,
							'sesionActual' => $sesionActual,
							'periodoActual' => $periodo,
							'grupoActual' => $grupo,
							'procesoActual' => $proceso,
							'tareaInicialtareaInicial' => $tareaInicial);	
				$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeInstancias?WSDL';
				$client = new SOAPClient($wsdl_url);
				$client->decode_utf8 = false; 	
				$resultadoCreacion=$client->CrearInstancia($parametros);
			    //echo '<br><pre>';print_r($resultadoCreacion);
					if($resultadoCreacion->return->estatus=="OK"){
						$resultadoInstancia=$client->consultarInstanciaXMaxId($usuario);
						if($resultadoInstancia->return->estatus=="OK"){
							$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeActividades?WSDL';
							$client = new SOAPClient($wsdl_url);
							$client->decode_utf8 = false; 	
							$instancia= array('id' => $resultadoInstancia->return->instancias->id,'borrado'=>'0');	
							$parametros= array('idInstancia' => $instancia,'idTarea'=>$tareaInicial);	
							$resultadoActividad=$client->consultarActividadXInstanciaYTarea($parametros);
							if($resultadoActividad->return->estatus=="OK"){
								$actividad= array('id' => $resultadoActividad->return->actividads->id,'borrado'=>'0');	
							    $parametros= array('actividadActual' => $actividad,
							           'sesionActual' => $sesionActual);
								$resultadoInicio=$client->IniciarActividad($parametros);
								if($resultadoInicio->return->estatus=="Ok"){
									$condicion= array('id' => '1','borrado'=>'0');	
									 $parametros= array('actividadActual' => $actividad,
							           'actividadActual' => $sesionActual);
									$resultadoFinActividad=$client->FinalizarActividad($parametros);
									if($resultadoFinActividad->return->estatus=="OK"){
										$wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeTransicion?WSDL';
										$client = new SOAPClient($wsdl_url);
										$client->decode_utf8 = false; 	
										$resultadoTransicion=$client->ConsultaTransicion($tareaInicial);
										if($resultadoTransicion->return->estatus="OK"){
										  $siguienteTarea=$resultadoTransicion->return->transicions->idTareaDestino;
										  
										}
									}
								}	
							}
						  
						
						}
					}  
  
  
	
		}
		
	}
	
include("../views/procesandoCliente.php");
?>
