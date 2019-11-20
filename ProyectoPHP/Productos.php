<?php
    include_once dirname(__FILE__).'/Conf/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
    session_start();
    $active;
    $pedirCreC='';
    $pedirCreV='';
    $pedirAct="style='display:none;'";
    if(isset($_SESSION["newsession"]))
    {
            $active="";
    }else
    {
        $active="style='display:none;'";
    }
    if(isset($_POST['pedirCredito']))
    {
        $pedirAct='';
        if(isset($_SESSION["newsession"]))
        {
            $pedirCreC='';
            $pedirCreV="style='display:none;'";
        }
        else
        {
            $pedirCreC="style='display:none;'";
            $pedirCreV='';
        }
        unset($_POST['pedirCredito']);  

    }
    $pedirTar="style='display:none;'";
    if(isset($_POST['agregarTarjeta']))
    {
        $pedirTar='';
        unset($_POST['agregarTarjeta']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
</head>
<body>
    <div <?php echo $active ?> >
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <input type="submit" value="Abrir Cuenta" name="abrirCuenta">
        </form><br>
        
        <form action="" method="post">
                <input type="submit" value="Pedir una tarjeta" name="agregarTarjeta">
        </form><br>
    </div>
    <form action="" method="post">
        <input type="submit" value="Pedir un credito" name="pedirCredito">
    </form><br>	
    
    
    <?php 
        if(isset($_POST['abrirCuenta'])){ //check if form was submitted
            include_once dirname(__FILE__).'/Conf/config.php';
            $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            $id=$_SESSION["id"];
            $sql="INSERT INTO Cuentas_Ahorros(IDUSUARIO,JAVECOINS)VALUES($id,'0')";
            if(mysqli_query($con,$sql)){
                echo "Se ha insetado la cuenta";
            }
            else {
                echo "Error insertado la cuenta";
            }
        }
        mysqli_close($con);
    ?>


    <div <?php echo $pedirAct; ?> >
        <div <?php echo $pedirCreV; ?>>
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <label>Cantidad de cupo: </label>
            <input type="text" name="cantidadCupo" pattern="[0-9]{1,20}" id="subject" required placeholder="Solo números"><br><br>
            <label>Correo electronico: </label>
            <input type="email" name="correo" id="subject1" required placeholder="Correo valido"><br><br>
            <input type="submit" value="pedir Credito" name="pedirCreditoConCupo">
        </form><br>
        </div>

        <div <?php echo $pedirCreC; ?> >
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <label>Cantidad de cupo: </label>
            <input type="text" name="cantidadCupoCliente" pattern="[0-9]{1,20}" id="subject1" required placeholder="Solo números"><br><br>
            <label>Cantidad de tasa sugerida: </label>
            <input type="text" name="cantidadTasa" pattern="[0-9]+(.[0-9]*[1-9])?" id="subject2" required placeholder="Solo números"><br><br>
            <input type="submit" value="pedir Credito" name="pedirCreditoConCupo">
        </form><br>
        </div>
    </div>
    
	
    
    <?php 
        if(isset($_POST['pedirCreditoConCupo'])){
            
            
            include_once dirname(__FILE__).'/Conf/config.php';
            $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            if(isset($_SESSION["newsession"])){ 
            $cupo=$_POST['cantidadCupoCliente'];
            $tasa=$_POST['cantidadTasa'];
            $correo=$_SESSION['correo'] ;
            $id=$_SESSION["id"];
            //check if form was submitted
            // en el primer campo el id de usuario de esta session, en el segundo va el cupo, en el tercero la tasa sugerida
            $sql="INSERT INTO CREDITOS(IDUSUARIO,CUPOJAVECOINS,TASAINTERES,FECHADEPAGO,TIPO,EMAIL)VALUES($id,$cupo,$tasa,'15','C','$correo')";
            if(mysqli_query($con,$sql)){
                echo "Se ha pedido el credito";
            }
            else {
                echo "Error al pedir el credito".mysqli_error($con)."<br>";
            }
            //enviarselo al admin
        } else {
            $cupo=$_POST['cantidadCupo'];
            $correo=$_POST['correo'];
             //check if form was submitte
            $sql="INSERT INTO CREDITOS(CUPOJAVECOINS,TASAINTERES,FECHADEPAGO,TIPO,EMAIL)VALUES($cupo,'0.20','15','V','$correo')";
            if(mysqli_query($con,$sql)){
                echo "Se ha pedido el credito";
            }
            else {
                echo "Error al pedir el credito".mysqli_error($con)."<br>";
            }
        }
        mysqli_close($con);
        }
    ?>
        
    
    <?php 
    if($pedirTar==''){
        $id=$_SESSION["id"];
    include_once dirname(__FILE__).'/Conf/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
     $str_datos='<h2>Cuentas de ahorros</h2>';
     $str_datos.='<table border="1" style="width:100%">';
     $str_datos.='<tr>';
     $str_datos.='<th>Numero Cuenta</th>';
     $str_datos.='<th>Cantidad Javecoins</th>';
     $str_datos.='</tr>';
     $sql="SELECT * FROM cuentas_ahorros where IDUSUARIO= '$id' ";
     $resultado = mysqli_query($con,$sql);
     while($fila = mysqli_fetch_array($resultado)) {
         $str_datos.='<tr>';
         $str_datos.= "<td>".$fila['PID']."</td> <td>".$fila['JAVECOINS']."</td>";
         $str_datos.= "</tr>";
     }
     $str_datos.= "</table>";
     echo $str_datos;

     mysqli_close($con);
    }

    ?>

        <div <?php echo $pedirTar; ?>>
            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                <label>A que cuenta de ahorros quiere asociarla? : </label>
                <input type="text" name="noCuentaDeAhorros" pattern="[0-9]{1,20}" id="subject" required placeholder="Solo números"><br><br>
                <input type="submit" value="pedir Tarjeta" name="pedirTarjeta">
            </form><br>
        </div>

    <?php 
     if(isset($_POST['pedirTarjeta'])){
            
            
        include_once dirname(__FILE__).'/Conf/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        if(isset($_SESSION["newsession"])){ 
        $noCuentaAhorros=$_POST['noCuentaDeAhorros'];
        $id=$_SESSION["id"];
       
        //check if form was submitted
        // en el primer campo el id de usuario de esta session, en el segundo va el cupo, en el tercero la tasa sugerida
        $sql="INSERT INTO Tarjetas_Credito(PIDCUENTA) VALUES($noCuentaAhorros)";
		if(mysqli_query($con,$sql)){
            echo "Se ha pedido  la tarjeta <br>";
        }
        else {
            echo "Error al pedir la tarjeta <br>";
        }
    
    }
    mysqli_close($con);
}
    
    ?>

<form action="index.php" method="post">
        <input type="submit" value="Volver">
</form>
</body>
</html>