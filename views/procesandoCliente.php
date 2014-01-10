<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<title>Pangea Flow</title>

	<!-- javascript -->	
	<script type="text/javascript" src="../js/jquery-2.0.3.js"></script>
	<script type='text/javascript' src="../js/bootstrap.js"></script>
    
	<!-- styles -->
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap-theme.css" rel="stylesheet">
	<link href="../css/footable-0.1.css" rel="stylesheet" type="text/css" />
	<link href="../css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />
	<link href="../css/footable.paginate.css" rel="stylesheet" type="text/css" />
	
	
</head>

<body>
<br>
<h2 align="center">Ingrese Datos del Cliente</h2>
  <form id="formulario" method="post">
  	<br>
	   	<div class="col-md-4">
        </div>
         <div class="col-md-4">  
        <table width="100%" class="table-striped table-bordered table-condensed">
        	<tr>
			 <th width="70%">Cédula</th>
				 <td><input type="text" name="cedula" id="cedula" maxlength="19" size="30" title="Ingrese la cédula de Identidad" placeholder="Ej. V-19887677" autofocus required></td>
			 </tr>
			 <tr>
			 <th width="70%">Nombre</th>
				 <td><input type="text" name="nombre" id="nombre" maxlength="19" size="30" title="Ingrese el nombre" placeholder="Ej. Juan" required></td>
		     </tr>
			  <tr>
			 <th width="70%">Apellido</th>
				 <td><input type="text" name="apellido" id="apellido" maxlength="19" size="30" title="Ingrese el apellido" placeholder="Ej. Perez"  required></td>
		     </tr>
			 <tr>
			 <th width="70%">Teléfono</th>
				 <td><input type="text" name="telefono" id="telefono" maxlength="19" size="30" title="Ingrese un teléfono" placeholder="Ej. 0416-1234567" required></td>		
			 </tr>
             <tr>
             <th width="70%">Dirección</th>
				 <td><textarea name="direccion" id="direccion" maxlength="149" cols="27" title="Ingrese su dirección" placeholder="Ej. Altos de Paramillo" required></textarea></td>		
			 </tr>		 
	</table><br>
     <div class="col-md-12" align="center"><button class="btn" id="procesar" name="procesar" type="submit">Procesar Cliente</button></div>
</form>  
    </div>
<script src="../js/footable.js" type="text/javascript"></script>
<script src="../js/footable.paginate.js" type="text/javascript"></script>
<script src="../js/footable.sortable.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-2.0.3.js" ></script>

</body>
</html>