<?php 
	include_once dirname(__FILE__).'/Conf/config.php';
					$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
	if(isset($_POST['btnProductos']))
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
	}
	else
	{
		if(isset($_POST['btnIniSes']))
		{
			echo "<form action='' method='post'>
					<input type='text' placeholder='Login Nickname' name = 'txtLogNom'>
					<input type='password' placeholder='Password' name = 'txtLogPass'>
					<input type='submit' value='Iniciar Sesion' name = 'btnLogin'>
				</form>";
		}
		else
		{
			if(isset($_POST['btnLogin']))
			{
				$nombre = $_POST['txtLogNom'];
				$password = $_POST['txtLogPass'];
				$passCrypt = crypt('$password','$6iahEstoyArto');
				$sql = "SELECT COUNT(1) FROM administrador where usuario = '$nombre' and contrasenha = '$passCrypt' ";
				$aux = mysqli_fetch_row(mysqli_query($con,$sql));
				if($aux[0]==1)
				{
					echo "<h2>Bienvenido $nombre </h2>";
					session_start();
					$_SESSION["newsession"]=$nombre;
					echo $_SESSION["newsession"];
				}
				else
				{
					$sql = "SELECT COUNT(1) FROM clientes where usuario = '$nombre' and contrasenha = '$passCrypt' ";
					$aux = mysqli_fetch_row(mysqli_query($con,$sql));
					if($aux[0]==1)
					{
						echo "<h2>Bienvenido $nombre </h2>";
						session_start();
						$_SESSION["newsession"]=$nombre;
						echo $_SESSION["newsession"];
					}
					else
					{
						echo "Nickname o password incorrectos";
					}
				}
			}
		}
		mysqli_close($con);
	}
	
?>
<html>
	<head>
		<title>Menu</title>
	</head>
	<body>
		<form action="CrearTablas.php" method="post">
			<input type="submit" value="Crear Tablas">
		</form>
		<form action="Registro.php" method="post">
			<input type="submit" value="Registrarse" name = "btnReg">
		</form>
		<form action="Registro.php" method="post">
			<input type="submit" value="Iniciar sesion" name = "btnReg">
		</form>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
			<input type="submit" value="Registrarse" name = "btnReg">
			<input type="submit" value="Iniciar Sesion" name = "btnIniSes">
			<input type="submit" value="Buscar Producto" name = "btnProductos">
		</form>
	</body>
</html>