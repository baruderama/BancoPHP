<?php
include_once dirname(__FILE__).'/Conf/config.php';
$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
$ac=false;
if(isset($_POST['cMax']))
{
    $ac=true;
    if($_POST['btn']=='rechazar')
    {
        $id=$_POST['id'];
        $sql="DELETE FROM Tarjetas_CreditoSinAprobar WHERE PID = $id ";
        if(mysqli_query($con,$sql))
        {
        }
        else{
            echo "Error en el rechazo ".mysqli_error($con).".<br>";
        }
    }
    else
    {   
        $id=$_POST['id'];
        $idc=$_POST['idC'];
        //$pC=$_POST['idC'];
        $cp=$_POST['cMax'];
        $sc=$_POST['sobre'];
        $cm=$_POST['cuotaM'];
        $ts=$_POST['tasa'];
        $sql="INSERT INTO Tarjetas_Credito(PIDCUENTA,CUPOMAX,SOBRECUPO,CUOTAMANEJO,TASAINTERES) VALUES($idc, $cp, $sc,$cm,$ts)";
		if(mysqli_query($con,$sql)){
            echo "Se ha insertado la tarjeta CREDITO <br>";
        }
        else {
            echo "Error AL INSERTAR la tarjeta CREDITO <br>";
        }
        $sql="DELETE FROM Tarjetas_CreditoSinAprobar WHERE PID = '$id' ";
        if(mysqli_query($con,$sql))
        {
        }
        else{
            echo "Error en el rechazo ".mysqli_error($con).".<br>";
        }
    }
    unset($_POST['cMax']);
}
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprobar Tarjetas</title>
</head>
<body>

<h2>Tarjetas por aprobar:</h2>

<?php
include_once dirname(__FILE__).'/Conf/config.php';
$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
 $str_datos='';
 $str_datos.='<table border="1" style="width:100%">';
 $str_datos.='<tr>';
 $str_datos.='<th>Numero</th>';
 $str_datos.='<th>Numero Cuenta</th>';
 $str_datos.='<th>Cupo Max</th>';
 $str_datos.='<th>Sobrecupo</th>';
 $str_datos.='<th>Cuota de manejo</th>';
 $str_datos.='<th>Tasa Interes</th>';
 $str_datos.='<th>Accion</th>';
 $str_datos.='</tr>';
 $sql="SELECT * FROM Tarjetas_CreditoSinAprobar ";
 $resultado = mysqli_query($con,$sql);
 while($fila = mysqli_fetch_array($resultado)) {
     $str_datos.='<tr> <form action="" method="post"> ';
     $str_datos.= '<td><input type="text" value="'.$fila['PID'].'" name="id" readonly></td><td><input type="text" value="'.$fila['PIDCUENTA'].'" name="idC" readonly></td> <td><input type="text" value="'.$fila['CUPOMAX'].'" name="cMax"></td><td><input type="text" value="'.$fila['SOBRECUPO'].'"name="sobre"></td><td><input type="text" value="'.$fila['CUOTAMANEJO'].'"name="cuotaM"></td><td><input type="text" value="'.$fila['TASAINTERES'].'"name="tasa"></td><td><input type="submit" value="aprobar" name="btn"><input type="submit" value="rechazar" name="btn"></td></form>';
     $str_datos.= '</tr>';
 }
 $str_datos.= "</table>";
 echo $str_datos;
?>

    
<form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>
</body>
</html>