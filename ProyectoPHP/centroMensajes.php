<?php 
session_start();
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Centro Mensajes</title>
</head>
<body>
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
            <input type="submit" value="Ver mensajes recibidos" name="recibidos">
            </form>

            <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
            <label>No Usuario destino: </label>
            <input type="text" name="noDestino" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
            <label>Asunto: </label>
            <input type="text" name="asunto"  id="subject" required placeholder="Asunto"><br><br>
        
            <label>Mensaje: </label>
            <input type="text" style="height:200px;font-size:14pt;" name="mensaje"  id="subject" required placeholder="Mensaje"><br><br>
            <input type="submit" value="enviar" name="enviar">
            </form>
        
            <?php 
            if(isset($_POST['recibidos'])){

                $id=$_SESSION["id"];
                include_once dirname(__FILE__).'/Conf/config.php';
                 $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                 $str_datos='<h2>Mensajes</h2>';
                $str_datos.='<table border="1" style="width:100%">';
                $str_datos.='<tr>';
                $str_datos.='<th>Asunto</th>';
                $str_datos.='<th>Mensaje</th>';
                $str_datos.='</tr>';
                $sql="SELECT * FROM Mensajes where PIDUSUARIODESTINO= '$id' ";
                $resultado = mysqli_query($con,$sql);
                while($fila = mysqli_fetch_array($resultado)) {
                    $str_datos.='<tr>';
                    $str_datos.= "<td>".$fila['ASUNTO']."</td> <td>".$fila['MENSAJE']."</td>";
                    $str_datos.= "</tr>";
                }
                $str_datos.= "</table>";
                echo $str_datos;


                 mysqli_close($con);
            }

            ?>

            <?php 
            if(isset($_POST['enviar'])){
                include_once dirname(__FILE__).'/Conf/config.php';
                $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $asunto=$_POST['asunto'];
                $mensaje=$_POST['mensaje'];
                $noDestino=$_POST['noDestino'];
                $id=$_SESSION["id"];
                //check if form was submitted
                // en el primer campo el id de usuario de esta session, en el segundo va el cupo, en el tercero la tasa sugerida
                $sql="INSERT INTO MENSAJES(PIDUSUARIO,ASUNTO,MENSAJE,PIDUSUARIODESTINO)VALUES('$id','$asunto','$mensaje','$noDestino')";
                if(mysqli_query($con,$sql)){
                    echo "Se ha enviado con exito";
                }
                else {
                    echo "Error al enviar".mysqli_error($con)."<br>";
                }
                mysqli_close($con);
            }

            ?>
            <form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>

</body>
</html>