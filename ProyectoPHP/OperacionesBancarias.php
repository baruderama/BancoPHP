<?php
session_start();
if(isset($_POST['btnCerrarS']))
{
	if($_POST['btnCerrarS']=='Cerrar sesion')
	{
		unset($_SESSION["newsession"]);
		unset($_POST['btnCerrarS']);
	}
}
$hideIniciado="style='display:none;";
$logout="style='display:none;'";
if(isset($_SESSION["newsession"]))
{
	if($_SESSION["newsession"]!='')
	{
		$hideIniciado="";
		$logout="";
	}
	
} 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>OPERACIONES BANCARIAS</title>
</head>
<body>
	
<form action="Consignacion.php" method="post">
		<input type="submit" value="Consignacion">
	</form><br>
	<form action="Index.php" method="post">
		<input type="submit" value="volver">
	</form><br>
	<div <?php echo $hideIniciado;?> class="hh">
		<form action="Retiros.php" method="post">
			<input type="submit" value="Retiros">
		</form><br>
		<form action="CompraTarjetaCredito.php" method="post">
			<input type="submit" value="Compra con tarjeta de credito">
		</form><br>
	</div>
</body>
</html>