<?php
include_once dirname(__FILE__).'/Conf/config.php';
$con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
    session_start();
    if(isset($_SESSION["newsession"]) && $_SESSION["tipo"]=='A') //Se revisa que sea un administrador
    {
        //Pago creditos
        //echo "gg";
        $sql = "SELECT DATENAME(w, FECHADEPAGO) from creditos";
        $resultado = mysqli_query($con,$sql);
        if($resultado !='Saturday' && $resultado !='Sunday') //Que hoy no sea Sabado o domingo para poder hacer los pagos
        {
            //Cobro visitantes
            $sql = "SELECT * FROM  Creditos where tipo = 'V' and FECHADEPAGO = GETDATE()"; //se sacan los creditos que tienen fecha de corte el dia de hoy y que la persona es visitante
            $resultado = mysqli_query($con,$sql);
            
            var_dump($resultado);
            if($resultado)
            {

            }else
            {
                echo " err ".mysqli_error($con);
            }
            while($fila = mysqli_fetch_array($resultado)) {
                echo "hh";
                var_dump($fila);
                $javecoins = $fila['JAVECOINS'];
                $usuario = $fila['USUARIO'];
                $idCredito = $fila['PID'];
                $idVisitante = $fila['IDVISITANTE'];
                $fechaUltimoPago = $fila['FECHAULTIMOPAGO'];
                $fechaPago = $fila['FECHADEPAGO'];
                $interval = date_diff($fechaPago, $fechaUltimoPago);
                $sql = "SELECT email from visitantes where PID=$idVisitante";
                $resultado2=mysqli_query($con,$sql);
                $auxEmail = mysqli_fetch_array($resultado2);
                if (mysqli_query($con,$sql)) {
                    if($interval->d >5 && $fechaUltimoPago < $fechaPago)
                    {
                        mail("$auxEmail[0]",'Pago', 'Por favor realice su pago');
                    }
                }
                
            }


            //Cobro clientes
            $sql = "SELECT * FROM  creditos where tipo = 'C' and FECHADEPAGO = SYSDATETIME()"; //se sacan los creditos que tienen fecha de corte el dia de hoy y que la persona es cliente
            
            $resultado = mysqli_query($con,$sql);
            while($fila = mysqli_fetch_array($resultado)) {
                $javecoins = $fila['JAVECOINS'];
                $usuario = $fila['USUARIO'];
                $idCredito = $fila['PID'];
                $sql = "SELECT SUM(JAVECOINS) FROM `cuentas_ahorros` WHERE IDUSUARIO = $usuario";  //Se suman los Javecoins de cada cuenta de usuario para saber si tiene presupuesto para pagar    
                $resultado2 = mysqli_fetch_row(mysqli_query($con,$sql));

                if($resultado2[0]>=$javecoins) //Si tiene presupuesto se ejecuta el pago del credito
                {
                    $sql = "SELECT JAVECOINS FROM `cuentas_ahorros` WHERE IDUSUARIO = $usuario order by 'desc'";   //se sacan las cuentas de ahorro por cada persona para hacer el debito
                    $resultado2 = mysqli_query($con,$sql);
                    $valPagar = $javecoins;

                    while($fila2 = mysqli_fetch_array($resultado2)) {

                        if($fila2[0]*1000 >= $valPagar) //Si se alcanza a pagar todo con esta cuenta
                        {
                            $sql = "INSERT INTO `registropagos`(`idCredito`, `pago`) VALUES ($idCredito, $valPagar)"; //Registro el pago

                            if (mysqli_query($con,$sql)) {
                                echo "Se ha registrado el pago correctamente";
                                $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= ($fila2[0]*1000 - $valPagar) where IDUSUARIO = $usuario and JAVECOINS = $fila2[0]";

                                if (mysqli_query($con,$sql)) {
                                    echo "Se ha actualizado la cuenta correctamente";
                                }else {
                                    echo "No se ha podido actualizar la cuenta . " . mysqli_error($con);
                                    $sql = "DELETE FROM `registropagos` WHERE idCredito = $idCredito and pago = $valPagar";     
                                }
                            }else {
                                echo "No se ha podido realizar el pago. " . mysqli_error($con);
                            }

                            break; //Se han pagado las deudas
                            
                        }
                        else
                        { 
                            //Se le resta a cada cuenta hasta pagar todo, pero finalizando en el if de arriba
                            $sql = "INSERT INTO `registropagos`(`idCredito`, `pago`) VALUES ($idCredito, ($fila2[0]))";

                            if (mysqli_query($con,$sql)) {
                                echo "Se ha registrado el pago correctamente";
                                $valPagar-=$fila2[0]*1000;
                                $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= (0) where IDUSUARIO = $usuario and JAVECOINS = $fila2[0]";

                                if (mysqli_query($con,$sql)) {
                                    echo " y se ha actualizado la cuenta correctamente";
                                }else {
                                    echo "pero no se ha podido actualizar la cuenta . " . mysqli_error($con);
                                    $sql = "DELETE FROM `registropagos` WHERE idCredito = $idCredito and pago = $valPagar";     
                                }
                            }else {
                                echo "No se ha podido realizar el pago. " . mysqli_error($con);
                            }
                        }
                    }
                }
                
            }

            //Pago Tarjetas de credito
            $sql = "SELECT PIDTARJETA,CANTIDADPAGAR,CANTIDADCUOTAS,CUOTASPAGAS,FECHAPAGO from deudas_tarjetas where FECHADEPAGO = SYSDATETIME()"; //Se sacan las deudas de tarjetas que tienen fecha de corte el dia de hoy
            $resultado = mysqli_query($con,$sql);
            while($fila = mysqli_fetch_array($resultado)) {
                $tarjeta =$fila[0];
                $cantiPagar = $fila[1];
                $cantiCuotas = $fila[2];
                $cuota = $fila[3];
                $fechaPago = $fila[4];

                //Se saca la tarjeta que referencia la deuda tarjeta
                $sql = "SELECT PIDCUENTA, TASAINTERES, CUOTAMANEJO from tarjetas_credito where PID = $tarjeta"; 
                $resultado = mysqli_query($con,$sql);
                $fila2 = mysqli_fetch_array($resultado);
                $cuenta = $fila2[0];
                $tasaInteres = $fila2[1];
                $cuotaManejo = $fila2[2];

                //Se busca la cuenta que referencia la tarjeta de credito
                $sql = "SELECT JAVECOINS, IDUSUARIO FROM `cuentas_ahorros` WHERE IDUSUARIO = $cuenta ";    
                $resultado2 = mysqli_fetch_row(mysqli_query($con,$sql));
                $fila3 = mysqli_fetch_array($resultado);
                $usuario = $fila3[1];
                //Si hay que tener en cuenta la tasa de interes
                if($cuota > 0)
                {
                    if($fila3[0] - ($cantiPagar)/$cantiCuotas>=0)
                    {
                        //Se actualiza la cuenta
                        $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= $fila3[0]-((($cantiPagar)/$cuota + $cantiPagar*$tasaInteres)+$cuotaManejo) where IDUSUARIO = $cuenta and JAVECOINS = $fila3[0]";
                        
                        if (mysqli_query($con,$sql)) {
                            echo "Pago de tarjeta correcto";
                        }else {
                            echo "El pago no se ha podido realizar . " . mysqli_error($con);    
                        }
                        $sql = "UPDATE `deudas_tarjetas` SET `CANTIDADCUOTAS`= $cuota + 1 where PIDTARJETA = $tarjeta";
                        if (!mysqli_query($con,$sql)) {
                            echo "No es posible actualizar la cantidad de cuotas";
                            $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= $fila3[0]+((($cantiPagar)/$cuota + $cantiPagar*$tasaInteres)+$cuotaManejo) where IDUSUARIO = $cuenta and JAVECOINS = $fila3[0]";
                            if (!mysqli_query($con,$sql)) {
                                echo "Maximo error";
                            }                
                        }
                        $sql = "UPDATE `deudas_tarjetas` SET `FECHADEPAGO`= DATEADD(MONTH,1,FECHADEPAGO) where PIDTARJETA=$tarjeta";
                        if (!mysqli_query($con,$sql)) {
                            echo "No es posible actualizar la fecha de pago";
                        } 
                    }
                    else
                    {
                        //Se busca la persona para enviar el email
                        $sql = "SELECT EMAIL from clientes where PID = $usuario";
                        $auxMail = mysqli_fetch_row(mysqli_query($con,$sql));
                        //Envìo de email
                        mail("$auxMail[0]",'Fondos insuficientes', 'No hay suficientes fondos para pagar la tarjeta de credito');
                        echo "Se ha enviado un correo informando que no hay fondos";           
                        
                    }
                }
                else
                {
                    //Realiza el pago de la tarjeta de credito sin incluir la tasa de interes
                    $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= $fila3[0]-($cantiPagar)/$cuota +$cuotaManejo where IDUSUARIO = $cuenta and JAVECOINS = $fila3[0]";
                    if (mysqli_query($con,$sql)) {
                        echo "Pago de tarjeta correcto";
                    }else {
                        echo "El pago no se ha podido realizar . " . mysqli_error($con);    
                    }

                    $sql = "UPDATE `deudas_tarjetas` SET `CANTIDADCUOTAS`= $cuota + 1 where PIDTARJETA = $tarjeta";
                    if (!mysqli_query($con,$sql)) {
                        echo "No es posible actualizar la cantidad de cuotas";
                        $sql = "UPDATE `cuentas_ahorros` SET `JAVECOINS`= $fila3[0]+((($cantiPagar)/$cantiCuotas + $cantiPagar*$tasaInteres)+$cuotaManejo) where IDUSUARIO = $cuenta and JAVECOINS = $fila3[0]";
                        if (!mysqli_query($con,$sql)) {
                            echo "Maximo error";
                        }                
                    }

                    $sql = "UPDATE `deudas_tarjetas` SET `FECHADEPAGO`= DATEADD(MONTH,1,FECHADEPAGO) where PIDTARJETA=$tarjeta";
                    if (!mysqli_query($con,$sql)) {
                        echo "No es posible actualizar la fecha de pago";
                    } 
                }
                if($cuota == $cantiCuotas)
                {
                    $sql = "DELETE FROM `deudas_tarjetas` WHERE PIDTARJETA = $tarjeta";
                    if (!mysqli_query($con,$sql)) {
                        echo "No es posible actualizar el ultimo pago";
                    } 
                    $sql = "UPDATE tarjetas_credito SET CUPOACTUAL = 0 where PID = $cuenta";
                    if (!mysqli_query($con,$sql)) {
                        echo "No es posible actualizar el cupo para el ultimo pago";
                    } 
                } 

            }


        }
        else
        {
            $sql = "UPDATE `creditos` SET `FECHADEPAGO`= DATEADD(DAY,1,FECHADEPAGO) where DATENAME(w, FECHADEPAGO) = 'Saturday' or DATENAME(w, FECHADEPAGO) = 'Sunday'";
            
        }

        
    }
    mysqli_close($con);
?>

<form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>