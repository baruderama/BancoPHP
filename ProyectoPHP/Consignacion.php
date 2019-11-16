<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
    <input type="radio" name="tipo" 
    <?php if(isset($pagoCredito) && $pagoCredito="pagoCredito") ?> value="pagoCredito"> Pago Credito<br>
    <input type="radio" name="tipo" 
    <?php if(isset($consignarAhorros) && $consignarAhorros="consignarAhorros") ?> value="consignarAhorros"> 
    Consignar ahorros<br>
    <label>Cantidad consignar/pagar: </label>
        <input type="text" name="pagarConsignar" pattern="[1-9]([0-9])*" id="subject" required placeholder="Solo números"><br><br>
    <input type="submit" value="Consignar" name="Ejecucion">
    </form>


    <?php 
        
    
    ?>


</body>

</html>