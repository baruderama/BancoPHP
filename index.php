<?php 
	if(isset($_POST['btnOpBan']))
	{
		
	}
	else
	{
		if(isset($_POST['btnIniSes']))
		{
			
		}
		else
		{
			if(isset($_POST['btnOpBan']))
			{
				
			}
		}
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

