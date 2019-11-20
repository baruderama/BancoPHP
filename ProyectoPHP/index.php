<?php 
	include_once dirname(__FILE__).'/Conf/config.php';
					$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
	session_start();
	if(isset($_POST['btnCerrarS']))
	{
		if($_POST['btnCerrarS']=='Cerrar sesion')
		{
			unset($_SESSION["newsession"]);
			unset($_POST['btnCerrarS']);
		}
	}
	$hideIniciar='';
	$logout="style='display:none;'";
	if(isset($_SESSION["newsession"]))
	{
		if($_SESSION["newsession"]!='')
		{
			$hideIniciar="style='display:none;'";
			$logout="";
		}
		
	}
	
	/*if(isset($_POST['btnProductos']))
	{
		$str_datos.='<table border="1" style="width:100%">';
		$str_datos.='<tr>';
		$str_datos.='<th>Producto</th>';
		$str_datos.='</tr>';
		$sql = " select* from productos";
		$resultado = mysqli_query($con,$sql);
		while($fila = mysqli_fetch_array($resultado)) {
			$str_datos.='<tr>';
			$str_datos.= "<td>".$fila['nombre']."</td>";
			$str_datos.= "</tr>";
		}
		$str_datos.= "</table>";
		echo $str_datos;
	}*/
	
	mysqli_close($con);
	
?>
<html>
	<head>
		<title>Menu</title>
	</head>
	<body>
		<form action="CrearTablas.php" method="post">
			<input type="submit" value="Crear Tablas">
		</form>
		<div <?php echo $logout;?> class="logout">
			<form action="" method="post"  >
				<input type="submit" value="Cerrar sesion" name = "btnCerrarS">
			</form>
		</div>
		<div <?php echo $hideIniciar;?> class="sinIniciarsesio">
			<form action="Registro.php" method="post"  >
				<input type="submit" value="Registrarse" name = "btnReg">
			</form>
			<form action="IniciarSesion.php" method="post"  >
				<input type="submit" value="Iniciar sesion" name = "btnReg">
			</form>
		</div>
		<form action="Productos.php" method="post"  >
			<!--
			<input type="submit" value="Registrarse" name = "btnReg">
			<input type="submit" value="Iniciar Sesion" name = "btnIniSes"> -->
			<input type="submit" value="Buscar Producto" name = "btnProductos">
		</form>
		<form action="OperacionesBancarias.php" method="post"  >
				<input type="submit" value="Operaciones Bancarias" name = "btnOperaciones">
		</form>
	</body>
</html>