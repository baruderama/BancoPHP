<?php 
include_once dirname(__FILE__).'/Conf/config.php';
$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
    echo "<form action='' method='post'>
            <input type='text' placeholder='Login Nickname' name = 'txtLogNom'>
            <input type='password' placeholder='Password' name = 'txtLogPass'>
            <input type='submit' value='Iniciar Sesion' name = 'btnLogin'>
        </form>";
        echo "<form action='index.php' method='post'>
        <input type='submit' value='Volver' name = 'btnVolver'>
    </form>";
    if(isset($_POST['btnLogin']))
    {
        $nombre = $_POST['txtLogNom'];
        $password = $_POST['txtLogPass'];
        $passCrypt = crypt('$password','$6iahEstoyArto');
        $sql = "SELECT COUNT(1) FROM administrador where usuario = '$nombre' and contrasenha = '$passCrypt' ";
        $aux = mysqli_fetch_row(mysqli_query($con,$sql));
        if($aux[0]==1)
        {
            $ss = "SELECT * FROM administrador where usuario = '$nombre' and contrasenha = '$passCrypt' ";
            $aux = mysqli_fetch_row(mysqli_query($con,$ss)); 
            session_start();
            $_SESSION["newsession"]=$nombre;
            //echo $_SESSION["newsession"];
            $_SESSION["id"] = $aux[0];
            mysqli_close($con);
            header("Location:index.php");
        }
        else
        {
            $sql = "SELECT COUNT(1) FROM clientes where usuario = '$nombre' and contrasenha = '$passCrypt' ";
            //echo "jj";
            $aux = mysqli_fetch_row(mysqli_query($con,$sql));
            if($aux[0]==1)
            {
                
                //echo "<h2>Bienvenido $nombre </h2>";
                $ss = "SELECT * FROM clientes where usuario = '$nombre' and contrasenha = '$passCrypt' ";
                $aux = mysqli_fetch_row(mysqli_query($con,$ss));
                var_dump($aux);
                session_start();
                $_SESSION["newsession"]=$nombre;
                //echo $_SESSION["newsession"];
                $_SESSION["id"] = $aux[0];
                $_SESSION['correo'] = $aux[2];
                mysqli_close($con);
                header("Location:index.php");
            }
            else
            {
                echo "Nickname o password incorrectos";
            }
        }
        mysqli_close($con);
    }

?>