<?php
    $gg="style='display:none;'";
    $gg2=false;
    if(isset($_POST['btnVerUsuarios']))
    {
        $gg='';
        $gg2=true;
        unset($_POST["btnVerUsuarios"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrar Usuario</title>
</head>
<body>
            <form action="" method="post"  >
				<input type="submit" value="Ver Usuarios" name = "btnVerUsuarios">
            </form>
            
            <?php 
                if($gg2){ 
                    //check if form was submitted
                        //$id=$_SESSION["id"];
                    include_once dirname(__FILE__).'/Conf/config.php';
                    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                     $str_datos='<h2>Clientes</h2>';
                     $str_datos.='<table border="1" style="width:100%">';
                     $str_datos.='<tr>';
                     $str_datos.='<th>Id cliente</th>';
                     $str_datos.='<th>Usuario</th>';
                     $str_datos.='<th>Email</th>';
                     $str_datos.='</tr>';
                     $sql="SELECT * FROM Clientes ";
                     $resultado = mysqli_query($con,$sql);
                     while($fila = mysqli_fetch_array($resultado)) {
                         $str_datos.='<tr>';
                         $str_datos.= "<td>".$fila['PID']."</td> <td>".$fila['USUARIO']."</td> <td>".$fila['EMAIL']."</td>";
                         $str_datos.= "</tr>";
                     }
                     $str_datos.= "</table>";
                     echo $str_datos;
                    
                    mysqli_close($con);
                }
            ?>
    <div <?php echo $gg;?> >
        <form action="" method="post"  >
        <label>iD de Usuario a eliminar: </label>
        <input type="text" name="noUsuario" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
        <input type="submit" value="Eliminar Usuario" name = "btnEliminarUsuario">
        </form>
        <form action="" method="post"  >
        <h2>Modificar Usuarios: </h2>
        <label>iD de Usuario a Modificar: </label>
        <input type="text" name="noUsuario1" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
        <label>Modificar Email: </label>
        <input type="email" name="modEmail" id="subject" required placeholder="Solo números"><br><br>
        <input type="submit" value="Modificar" name = "btnModificarEmail"><br><br>
            </form>
        <form action="" method="post"  >
        <label>iD de Usuario a Modificar: </label>
        <input type="text" name="noUsuario2" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
        <label>Modificar nombre de usuario: </label>
        <input type="text" name="modUsuario" id="subject" required placeholder="Solo números"><br><br>
        <input type="submit" value="Modificar" name = "btnModificarUsuario">
        </form>
    </div>
        

            <?php 
            if(isset($_POST['btnModificarEmail'])){

                $email=$_POST['modEmail'];
                $id=$_POST['noUsuario1'];
                include_once dirname(__FILE__).'/Conf/config.php';
                $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql="UPDATE clientes SET EMAIL = '$email' where PID = $id";
                if(mysqli_query($con,$sql))
                {
                     echo "Exito <br>";
                }
                else{
                    echo "Error en la actualizacion".mysqli_error($con).".<br>";
                }

                mysqli_close($con);
            }
            ?>

<?php 
            if(isset($_POST['btnModificarUsuario'])){
                $usuario=$_POST['modUsuario'];
                $id=$_POST['noUsuario2'];
                include_once dirname(__FILE__).'/Conf/config.php';
                $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql="UPDATE clientes SET USUARIO = '$usuario' where PID = $id";
                if(mysqli_query($con,$sql))
                {
                     echo "Exito <br>";
                }
                else{
                    echo "Error en la actualizacion2".mysqli_error($con).".<br>";
                }

                mysqli_close($con);

            }
            ?>

            <?php 
            if(isset($_POST['btnEliminarUsuario'])){
                // $usuario=$_POST['modUsuario'];
                $id=$_POST['noUsuario'];
                include_once dirname(__FILE__).'/Conf/config.php';
                $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql="DELETE FROM clientes where PID = $id";
                if(mysqli_query($con,$sql))
                {
                     echo "Exito <br>";
                }
                else{
                    echo "Error en la actualizacion2".mysqli_error($con).".<br>";
                }

                mysqli_close($con);

            }
            ?>
<form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>    
</body>
</html>