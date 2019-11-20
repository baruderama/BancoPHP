<?php 
session_start();
$form1="style='display:none;'";
$form2="style='display:none;'";
$tab1=false;
$tab2=false;
if(isset($_POST['consignar'])||isset($_POST['pagarCredito']))
{
    $form1='';
    if(!isset($_SESSION["newsession"]))
    {
        $form2="style='display:none;'";
    }
}
$form3="style='display:none;'";
if(isset($_POST['pagarCredito']))
{
    $form3='';
    $tab1=true;
    unset($_POST['pagarCredito']);
}
$form4="style='display:none;'";
if(isset($_POST['consignar']))
{
    $form4='';
    $tab2=true;
    unset($_POST['consignar']);
}
?>
<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    
        <form action="" method="post">
            <input type="submit" value="Pagar Credito" name="pagarCredito">
        </form><br>
        
        <form action="" method="post">
                <input type="submit" value="Consignar" name="consignar">
        </form><br>

    <div <?php echo $form3; ?> >
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
        <label>No credito a pagar: </label>
            <input type="text" name="noCredito" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
        <label>Cantidad a pagar: </label>
            <input type="text" name="pagarConsignar" pattern="([1-9]([0-9])*.?([0-9])*)|(0.([0-9])*[1-9])" id="subject" required placeholder="Solo números"><br><br>
            <select name="Moneda">
                <option  value="JaveCoins">JaveCoins</option> 
                <option  value="Pesos">Pesos</option> 
            </select><br><br>
            <input type="submit" value="enviar" name="consignarPagar1">
        </form>
    </div>

    <div <?php echo $form4; ?> >
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
        <label>No cuenta de ahorros a consignar: </label>
            <input type="text" name="noAhorros" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
        
            <label>Cantidad a consignar: </label>
            <input type="text" name="pagarConsignar" pattern="([1-9]([0-9])*.?([0-9])*)|(0.([0-9])*[1-9])" id="subject" required placeholder="Solo números"><br><br>
            <label>Pagar en: </label>
            <select name="Moneda">
                <option  value="JaveCoins">JaveCoins</option> 
                <option  value="Pesos">Pesos</option> 
            </select><br><br>
            <input type="submit" value="enviar" name="consignarPagar2">
        </form>
    </div>
    
    <div <?php echo $form2; ?> >
        <input type="email" name="email" id="subject" required placeholder="Solo correo valido"><br><br>
    </div>
    


    <?php 
    if($tab2){ 
        //check if form was submitted
        if(isset($_SESSION["newsession"])){
            $id=$_SESSION["id"];
        include_once dirname(__FILE__).'/Conf/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
         $str_datos='<h2>Cuentas de ahorros</h2>';
         $str_datos.='<table border="1" style="width:100%">';
         $str_datos.='<tr>';
         $str_datos.='<th>Numero Cuenta</th>';
         $str_datos.='<th>Cantidad Javecoins</th>';
         $str_datos.='</tr>';
         $sql="SELECT * FROM cuentas_ahorros ";
         $resultado = mysqli_query($con,$sql);
         while($fila = mysqli_fetch_array($resultado)) {
             $str_datos.='<tr>';
             $str_datos.= "<td>".$fila['PID']."</td> <td>".$fila['JAVECOINS']."</td>";
             $str_datos.= "</tr>";
         }
         $str_datos.= "</table>";
         echo $str_datos;
        }
        mysqli_close($con);
    }
    ?>

    <?php 
    if($tab1){ 
        //check if form was submitted
        if(isset($_SESSION["newsession"])){
            $id=$_SESSION["id"];
        include_once dirname(__FILE__).'/Conf/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
         $str_datos='<h2>Creditos</h2>';
         $str_datos.='<table border="1" style="width:100%">';
         $str_datos.='<tr>';
         $str_datos.='<th>No Credito</th>';
         $str_datos.='<th>Deuda</th>';
         $str_datos.='</tr>';
         $sql="SELECT * FROM creditos where IDUSUARIO= '$id' ";
         $resultado = mysqli_query($con,$sql);
         while($fila = mysqli_fetch_array($resultado)) {
             $str_datos.='<tr>';
             $str_datos.= "<td>".$fila['PID']."</td> <td>".$fila['CUPOJAVECOINS']."</td>";
             $str_datos.= "</tr>";
         }
         $str_datos.= "</table>";
         echo $str_datos;
        }else {
            $email="";
            $str_datos='<h2>Creditos</h2>';
            $str_datos.='<table border="1" style="width:100%">';
            $str_datos.='<tr>';
            $str_datos.='<th>Numero Credito</th>';
            $str_datos.='<th>Cantidad de Cupo</th>';
            $str_datos.='</tr>';
            $sql="SELECT * FROM creditos where EMAIL= '$email' ";
            $resultado = mysqli_query($con,$sql);
            while($fila = mysqli_fetch_array($resultado)) {
                $str_datos.='<tr>';
                $str_datos.= "<td>".$fila['PID']."</td> <td>".$fila['CUPOJAVECOINS']."</td>";
                $str_datos.= "</tr>";
            }
            $str_datos.= "</table>";
            echo $str_datos;
        }
        mysqli_close($con);
    }
    ?>




    <?php 
        if(isset($_POST['consignarPagar2'])){
            include_once dirname(__FILE__).'/Conf/config.php';
          $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            if(isset($_SESSION["newsession"])){
            $id=$_SESSION["id"];
            $NoCuenta=$_POST['noAhorros'];
        

        $sql="SELECT JAVECOINS FROM cuentas_ahorros where PID = $NoCuenta ";
        $resultado = mysqli_query($con,$sql);
        $act;
        while($fila = mysqli_fetch_array($resultado)) {
              $act=$fila['JAVECOINS'];
          }
       
        $cantidadConsignar=$_POST['pagarConsignar'];
        if($_POST['Moneda']=='JaveCoins')
        {
            $cantidadConsignar=$_POST['pagarConsignar'];
        }
        else
        {
            $cantidadConsignar=$_POST['pagarConsignar']/1000;
        }
           $act+=$cantidadConsignar;
          $sql="UPDATE cuentas_ahorros SET JAVECOINS = $act where PID = $NoCuenta ";
          if(mysqli_query($con,$sql))
          {
              
          echo "Exito actual $act <br>";
          }
          else{
              echo "Error en la actualizacion".mysqli_error($con).".<br>";
          }
        } else {
            $NoCuenta=$_POST['noAhorros'];
            $NoCuenta=$_POST['noAhorros'];
            $cantidadConsignar=$_POST['pagarConsignar'];
        

        $sql="SELECT JAVECOINS FROM cuentas_ahorros where PID = $NoCuenta";
        $resultado = mysqli_query($con,$sql);
        $act;
        while($fila = mysqli_fetch_array($resultado)) {
              $act=$fila['JAVECOINS'];
          }
       
          $cantidadConsignar=$_POST['pagarConsignar'];
        if($_POST['Moneda']=='JaveCoins')
        {
            $cantidadConsignar=$_POST['pagarConsignar'];
        }
        else
        {
            $cantidadConsignar=$_POST['pagarConsignar']/1000;
        }
          $sql="UPDATE cuentas_ahorros SET JAVECOINS = $act where PID = $NoCuenta";
          if(mysqli_query($con,$sql))
          {
              
          echo "Exito actual $act <br>";
          }
          else{
              echo "Error en la actualizacion".mysqli_error($con).".<br>";
          }

        }
       
        mysqli_close($con);
    }

    
    ?>

<?php 
        if(isset($_POST['consignarPagar1'])){
            include_once dirname(__FILE__).'/Conf/config.php';
          $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            $id=$_SESSION["id"];
            if(isset($_SESSION["newsession"])){
            $NoCredito=$_POST['noCredito'];
            

        $sql="SELECT CUPOJAVECOINS FROM creditos where PID = $NoCredito AND IDUSUARIO = $id";
        $resultado = mysqli_query($con,$sql);
        $act;
        while($fila = mysqli_fetch_array($resultado)) {
              $act=$fila['CUPOJAVECOINS'];
          }
       
          $cantidadConsignar=$_POST['pagarConsignar'];
          if($_POST['Moneda']=='JaveCoins')
          {
              $cantidadConsignar=$_POST['pagarConsignar'];
          }
          else
          {
              $cantidadConsignar=$_POST['pagarConsignar']/1000;
          }
           $act-=$cantidadConsignar;
          $sql="UPDATE creditos SET CUPOJAVECOINS = $act where PID = $NoCredito AND IDUSUARIO = $id";
          if(mysqli_query($con,$sql))
          {
              
          echo "Exito actual $act <br>";
          }
          else{
              echo "Error en la actualizacion".mysqli_error($con).".<br>";
          }
        } else {
            $NoCredito=$_POST['noCredito'];
            $email=$_POST['email'];
            $cantidadConsignar=$_POST['pagarConsignar'];
        if($_POST['Moneda']=='JaveCoins')
        {
            $cantidadConsignar=$_POST['pagarConsignar'];
        }
        else
        {
            $cantidadConsignar=$_POST['pagarConsignar']/1000;
        }

        $sql="SELECT CUPOJAVECOINS FROM creditos where PID = $NoCredito AND EMAIL= $email";
        $resultado = mysqli_query($con,$sql);
        $act;
        while($fila = mysqli_fetch_array($resultado)) {
              $act=$fila['CUPOJAVECOINS'];
          }
       

           $act-=$cantidadConsignar;
          $sql="UPDATE creditos SET CUPOJAVECOINS = $act where PID = $NoCredito AND Email= $email";
          if(mysqli_query($con,$sql))
          {
              
          echo "Exito actual $act <br>";
          }
          else{
              echo "Error en la actualizacion".mysqli_error($con).".<br>";
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