<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>
    <?php
        include_once dirname(__FILE__).'/Conf/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS);
        $sql="CREATE DATABASE DBProyecto";
        if(mysqli_query($con,$sql))
        {
            echo "Base de datos DBProyecto creada.<br>";
        }
        else{
            echo "Error en la creación".mysqli_error($con).".<br>";
        }
        mysqli_close($con);
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql="CREATE TABLE Administrador (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            USUARIO VARCHAR(40) unique,
            EMAIL VARCHAR(40) unique,
            CONTRASENHA VARCHAR(40)
        )";

        if(mysqli_query($con,$sql))
        {
            echo "Tabla Administrador creada.<br>";
        }
        else{
            echo "Error en la creación tabla Admin".mysqli_error($con).".<br>";
        }
        $sql="CREATE TABLE Clientes (
        PID INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(PID),
        USUARIO VARCHAR(40) unique,
        EMAIL VARCHAR(40) unique,
        CONTRASENHA VARCHAR(40)
        )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Clientes creada.<br>";
        }
        else{
            echo "Error en la creación tabla Clientes ".mysqli_error($con);
        }

        

        $sql="CREATE TABLE Visitantes (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            EMAIL VARCHAR(40) unique,
            CONTRASENHA VARCHAR(40)
            )";
            if(mysqli_query($con,$sql))
            {
                echo "Tabla Visitantes creada.<br>";
            }
            else{
                echo "Error en la creación tabla Visitantes ".mysqli_error($con);
            }
        $sql='CREATE table Cuentas_Ahorros(
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            IDUSUARIO INT,
            JAVECOINS FLOAT,
            FOREIGN KEY (IDUSUARIO) REFERENCES Clientes(PID) ON DELETE CASCADE,
            CHECK (JAVECOINS >= 0))';

        

        if(mysqli_query($con,$sql))
        {
            echo "Tabla Cuentas_Ahorros creada.<br>";
        }
        else{
            echo "Error en la creación tabla Cuentas_Ahorros ".mysqli_error($con)."<br>";
        }


        

        $sql="CREATE table Creditos(
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            IDUSUARIO INT,
            IDVISITANTE INT,
            EMAIL VARCHAR(30),
            CUPOJAVECOINS FLOAT,
            TASAINTERES FLOAT,
            FECHADEPAGO INT,
            TIPO CHAR,
            CANTIDADCUOTAS INT NOT NULL,
            CUOTASPAGAS INT DEFAULT 0,
            FECHAULTIMOPAGO DATE,
            FOREIGN KEY (IDUSUARIO) REFERENCES Clientes(PID) ON DELETE CASCADE,
            FOREIGN KEY (IDVISITANTE) REFERENCES Visitantes(PID) ON DELETE CASCADE,
            CHECK (CUPOJAVECOINS >= 0 AND (TIPO='V' or TIPO ='C') AND (FECHADEPAGO> 0 AND FECHADEPAGO<32)))";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Creditos creada.<br>";
        }
        else{
            echo "Error en la creación tabla Creditos ".mysqli_error($con)."<br>";
        }

        

        $sql="CREATE table Tarjetas_Credito (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDCUENTA INT NOT NULL,
            CUPOMAX FLOAT,
			CUPOACTUAL FLOAT DEFAULT 0,
            SOBRECUPO FLOAT,
            CUOTAMANEJO FLOAT,
            TASAINTERES FLOAT,
            FOREIGN KEY (PIDCUENTA) REFERENCES Cuentas_Ahorros(PID) ON DELETE CASCADE
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Tarjetas_Credito creada.<br>";
        }
        else{
            echo "Error en la creación tabla Tarjetas_Credito ".mysqli_error($con)."<br>";
        }
        
        $sql="CREATE table Tarjetas_CreditoSinAprobar (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDCUENTA INT NOT NULL,
            CUPOMAX FLOAT,
			CUPOACTUAL FLOAT DEFAULT 0,
            SOBRECUPO FLOAT,
            CUOTAMANEJO FLOAT,
            TASAINTERES FLOAT,
            FOREIGN KEY (PIDCUENTA) REFERENCES Cuentas_Ahorros(PID) ON DELETE CASCADE
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Tarjetas_Credito creada.<br>";
        }
        else{
            echo "Error en la creación tabla Tarjetas_Credito ".mysqli_error($con)."<br>";
        }
        //SYSDATETIME()
		$sql="CREATE table Deudas_Tarjetas (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDTARJETA INT NOT NULL,
			CANTIDADPAGAR FLOAT,
            CANTIDADCUOTAS INT NOT NULL,
            CUOTASPAGAS INT DEFAULT 0,
            FECHAPAGO DATE,
            FOREIGN KEY (PIDTARJETA) REFERENCES Tarjetas_Credito(PID) ON DELETE CASCADE
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Tarjetas_Credito creada.<br>";
        }
        else{
            echo "Error en la creación tabla Tarjetas_Credito ".mysqli_error($con)."<br>";
        }

        $sql="CREATE table Mensajes (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDUSUARIO INT NOT NULL,
            ASUNTO VARCHAR(30),
			MENSAJE VARCHAR(255),
            PIDUSUARIODESTINO INT NOT NULL,
            FOREIGN KEY (PIDUSUARIO) REFERENCES CLIENTES(PID) ON DELETE CASCADE
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Mensajes creada.<br>";
        }
        else{
            echo "Error en la creación tabla Mensajes ".mysqli_error($con)."<br>";
        }

        $sql="CREATE table MensajesAdmin (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDADMIN INT NOT NULL,
            ASUNTO VARCHAR(30),
			MENSAJE VARCHAR(255),
            PIDUSUARIODESTINO INT NOT NULL,
            FOREIGN KEY (PIDADMIN) REFERENCES ADMINISTRADOR(PID) ON DELETE CASCADE
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla MensajesAdmin creada.<br>";
        }
        else{
            echo "Error en la creación tabla MensajesAdmin ".mysqli_error($con)."<br>";
        }
        mysqli_close($con);
    ?> 
    <form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>
</body>
</html>