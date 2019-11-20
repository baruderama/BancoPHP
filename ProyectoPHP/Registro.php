<?php
include_once dirname(__FILE__).'/Conf/config.php';
$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
echo "<form action='' method='post'>
<input type='text' placeholder='Nickname' name = 'txtRegNom'>
<input type='password' placeholder='Password' name = 'txtRegPass'>
<input type='email' name='correo' id='subject1' required placeholder='Correo valido'><br><br>
<input type='submit' value='Registrarse' name = 'btnRegistrar'>
</form>";
echo "<form action='index.php' method='post'>
					<input type='submit' value='Volver' name = 'btnVolver'>
				</form>";
if(isset($_POST['txtRegNom']))
{
    //echo "ENTRA";
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
        $email=$_POST['correo'];
        $passCrypt = crypt('$password','$6iahEstoyArto');
        $sql="SELECT COUNT(PID) FROM administrador";
        $aux = mysqli_fetch_row(mysqli_query($con,$sql));
        if($aux[0]==0)
        {
            $sql = "INSERT INTO administrador(USUARIO, CONTRASENHA,EMAIL) VALUES ('$nombre','$passCrypt','$email')";
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
            $sql = "INSERT INTO clientes (USUARIO, CONTRASENHA,EMAIL) VALUES ('$nombre','$passCrypt','$email')";
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
mysqli_close($con);
?>