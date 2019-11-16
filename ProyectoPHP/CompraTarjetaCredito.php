<?php
if(isset($_POST['Moneda']))
{
	$totalJav;
	if($_POST['Moneda']=='JaveCoins')
	{
		$totalJav=$_POST['total'];
	}
	else
	{
		$totalJav=$_POST['total']/1000;
	}
	$Nombre = '';//esto se reemplaza por session
	//query para obtener el id del usuario iniciado
	$idusuario= 1;
	$tarjeta=1;
	$totalCobrar=$totalJav;
	$cuotas=$_POST['cuotas'];
	include_once dirname(__FILE__).'/Conf/config.php';
	$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
	
	$sql="SELECT PID FROM Cuentas_Ahorros where IDUSUARIO = $idusuario";
	$resultado = mysqli_query($con,$sql);
	$idCuenta;
	while($fila = mysqli_fetch_array($resultado)) 
	{
		$idCuenta=$fila['PID'];
	}
	$sql="SELECT * FROM Tarjetas_Credito where PIDCUENTA = $idCuenta AND PID = $tarjeta";
	$resultado = mysqli_query($con,$sql);
	$cMax;
	$cAct;
	while($fila = mysqli_fetch_array($resultado)) 
	{
		$cMax=$fila['CUPOMAX'];
		$cAct=$fila['CUPOACTUAL'];
	}
	if($cMax>= $totalCobrar+$cAct)
	{

		$cAct+=$totalCobrar;
		$sql="UPDATE Tarjetas_Credito SET CUPOACTUAL = $cAct where PID = $tarjeta AND PIDCUENTA =$idCuenta";
		if(mysqli_query($con,$sql))
		{
			echo "Exito actual $cAct <br>";
			$sql="INSERT INTO Deudas_Tarjetas(PIDTARJETA,CANTIDADCUOTAS,CANTIDADPAGAR)VALUES($tarjeta, $cuotas, $totalCobrar)";
			if(mysqli_query($con,$sql))
			{
				echo "Listo<br><br>";
				header("Location:PagoExitoso.php");
			}
			else{
				echo "Error en la insercion ".mysqli_error($con).".<br>";
			}
		}
		else{
			echo "Error en la actualizacion ".mysqli_error($con).".<br>";
		}
	}
	else 
	{
		echo "fondos insuficientes";
	}
}
else
{
	$_POST['Moneda']='';
	$_POST['JaveCoins']='';
	$_POST['Pesos']='';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<style type="text/css">

  input:required:invalid, input:focus:invalid {
    background-image: url(https://www.the-art-of-web.com/images/invalid.png);
    background-position: right top;
    background-repeat: no-repeat;
  }
  input:required:valid {
    background-image: url(https://www.the-art-of-web.com/images/valid.png);
    background-position: right top;
    background-repeat: no-repeat;
  }

</style>
</head>

<body>
<h1>Pagar Con Tarjeta</h1>
	<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
    <label>Total a pagar: </label>
	<input type="text" name="total" pattern="([1-9]([0-9])*.?([0-9])*)|(0.([0-9])*[1-9])" id="subject" required placeholder="Solo números(ej. 12 o 12.0)"><br><br>
	<label>Pagar en: </label>
	<select name="Moneda">
		<option  value="JaveCoins">JaveCoins</option> 
		<option  value="Pesos">Pesos</option> 
	</select><br><br>
	<label>No de Tarjeta: </label>
	<input type="text" name="tarjeta" pattern="[1-9]([0-9])*" id="card" required placeholder="Solo números"><br><br>
	<label>No de Cuotas: </label>
	<input type="text" name="cuotas" pattern="[1-6]" id="cuota" required placeholder="Solo números"><label> (Max. 6)</label><br><br>
	
    <input type="submit" value="Pagar" name="Ejecutar">
    </form>


</body>

</html>