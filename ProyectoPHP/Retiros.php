<?php 
   // if(isset($_SESSION['usuario'])){
        
    //}


?>



<html>
    <body>
    <form name="form" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
        <label>Numero de cuenta de ahorros: </label>
        <input type="text" name="NoCuenta" pattern="[0-9]{1,20}" id="subject" required placeholder="Solo números"><br><br>
        <label>Cantidad a retirar: </label>
        <input type="text" name="CantidadRetirar" id="Nombre"  pattern="[1-9]([0-9])*" placeholder="Solo números"><br><br>
        <input type="submit" value="Realizar retiro" name="Retiro">
    </form>



    <?php 
        if(isset($_POST['Retiro'])){ //check if form was submitted
          $NoCuenta = $_POST['NoCuenta'];
          $Nombre = '';//esto se reemplaza por session
          //query para obtener el id del usuario iniciado
          //TODO Pesos
          $idusuario= 1;
          $cantidadRetirar= $_POST['CantidadRetirar'];
          $message = "La cuenta de ahorros es: ".$NoCuenta;
          //$sql= "SELECT * FROM Clientes WHERE USUARIO = '$idusu'";
          echo $message;

          include_once dirname(__FILE__).'/Conf/config.php';
          $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        
          $sql="SELECT JAVECOINS FROM cuentas_ahorros where PID = $NoCuenta AND IDUSUARIO = $idusuario";
          $resultado = mysqli_query($con,$sql);
          $act;
          while($fila = mysqli_fetch_array($resultado)) {
			    $act=$fila['JAVECOINS'];
            }
         if($act>=$cantidadRetirar)
         {

             $act-=$cantidadRetirar;
            $sql="UPDATE cuentas_ahorros SET JAVECOINS = $act where PID = $NoCuenta AND IDUSUARIO = $idusuario";
            if(mysqli_query($con,$sql))
            {
                
            echo "Exito actual $act <br>";
            }
            else{
                echo "Error en la actualizacion".mysqli_error($con).".<br>";
            }
         }
         else 
         {
             echo "fondos insuficientes";
         }
        }
    ?>
    </body>
</html>