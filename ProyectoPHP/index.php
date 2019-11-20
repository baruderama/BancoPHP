<?php 
	/*$i1='l';
	$i2='l';
	if(isset($_POST['name2']))
	{
		$i1=$_POST['name1'];
		echo $_POST['name1'];
	}
	else
	echo 'pailas';
	$str_datos='';
	$str_datos.='<table border="1" style="width:100%">';
	$str_datos.='<tr>';
	$str_datos.='<th>Numero Cuenta</th>';
	$str_datos.='<th>Cupo Max</th>';
	$str_datos.='</tr>';
	$str_datos.='<tr> <form action="" method="post"> ';
	$str_datos.= '<td> jj </td> <td><input type="text" value="'.$i1.'" name="name1"></td><td><input type="submit" value="ssu" name="name2"></td></form>';
	$str_datos.= '</tr>';
	$str_datos.= "</table>";
	echo $str_datos;*/
	include_once dirname(__FILE__).'/Conf/config.php';
					$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
	session_start();
	if(isset($_POST['btnCerrarS']))
	{
		if($_POST['btnCerrarS']=='Cerrar sesion')
		{
			unset($_SESSION['admin']);
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
	$secAdm="style='display:none;'";
	$secCl='';
	if(isset($_SESSION['admin']))
	{
		$secAdm='';
		$secCl="style='display:none;'";

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
		<div  <?php echo $secCl;?>>
			<form action="Productos.php" method="post"  >
				<!--
				<input type="submit" value="Registrarse" name = "btnReg">
				<input type="submit" value="Iniciar Sesion" name = "btnIniSes"> -->
				<input type="submit" value="Buscar Producto" name = "btnProductos">
			</form>
			<form action="OperacionesBancarias.php" method="post"  >
					<input type="submit" value="Operaciones Bancarias" name = "btnOperaciones">
			</form>
		</div>
		<div  <?php echo $secAdm;?>>
			<h2>Panel de administracion</h2>
			<form action="AprobarCreditos.php" method="post"  >
				<input type="submit" value="Revisar Creditos Nuevos" name = "btnAprobarCreditos">
			</form>
			<form action="AprobarTarjetasCredito.php" method="post"  >
				<input type="submit" value="Revisar Tarjetas de credito" name = "btnAprobarTarjetas">
			</form>
			<form action="AdminUsuarios.php" method="post"  >
				<input type="submit" value="Administrar Usuarios" name = "btnAdminUsuarios">
			</form>
		</div>
		
	</body>
</html>