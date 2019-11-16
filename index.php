<?php 
	include_once dirname(__FILE__).'/Conf/config.php';
					$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
	if(isset($_POST['btnOpBan']))
	{
		
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
			if(isset($_POST['btnReg']))
			{
				echo "<form action='' method='post'>
					<input type='text' placeholder='Nickname' name = 'txtRegNom'>
					<input type='password' placeholder='Password' name = 'txtRegPass'>
					<input type='submit' value='Registrarse' name = 'btnRegistrar'>
				</form>";
			}
			else
			{
				if(isset($_POST['btnRegistrar']))
				{
					echo "ENTRA";
					$nombre = $_POST['txtRegNom'];
					$sql = "SELECT COUNT(1) FROM administrador where usuario = '$nombre' ";
					$aux = mysqli_fetch_row(mysqli_query($con,$sql));
					$existe = false;
					if($aux[0]==1)
					{
						echo "Este nickname ya existe";
						$existe = true;
					}
					else
					{
						$sql = "SELECT COUNT(1) FROM clientes where usuario = '$nombre' ";
						$aux = mysqli_fetch_row(mysqli_query($con,$sql));
						if($aux[0]==1)
						{
							echo "Este nickname ya existe";
							$existe = true;
						}
					}
					if(!$existe)
					{
						$password = $_POST['txtRegPass'];
						$passCrypt = crypt('$password','$6iahEstoyArto');
						$sql="SELECT COUNT(PID) FROM administrador";
						$aux = mysqli_fetch_row(mysqli_query($con,$sql));
						if($aux[0]==0)
						{
							$sql = "INSERT INTO administrador(USUARIO, CONTRASENHA) VALUES ('$nombre','$passCrypt')";
							if(mysqli_query($con,$sql))
							{
								echo "El administrador $nombre ha sido creado correctamente";
							}
							else{
								echo "Error en la creación:".mysqli_error($con).".<br>";
							}
						}
						else
						{
							$sql = "INSERT INTO clientes (USUARIO, CONTRASENHA) VALUES ('$nombre','$passCrypt')";
							if(mysqli_query($con,$sql))
							{
								echo "El cliente $nombre ha sido creado correctamente";
							}
							else{
								echo "Error en la creación".mysqli_error($con).".<br>";
							}
						}
					}
					
					
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
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
			<input type="submit" value="Registrarse" name = "btnReg">
			<input type="submit" value="Iniciar Sesion" name = "btnIniSes">
			<input type="submit" value="Operacion Bancaria" name = "btnOpBan">
		</form>
	</body>
</html>

