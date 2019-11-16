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
        CONTRASENHA VARCHAR(40)
        )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Clientes creada.<br>";
        }
        else{
            echo "Error en la creación tabla Clientes ".mysqli_error($con);
        }

        $sql="INSERT INTO Clientes(USUARIO,CONTRASENHA)VALUES('Manuel','12345')";
        if(mysqli_query($con,$sql)){
            echo "Se ha insetado a Manuel";
        }
        else {
            echo "Error insertado la cuenta";
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
            FOREIGN KEY (IDUSUARIO) REFERENCES Clientes(PID),
            CHECK (JAVECOINS >= 0))';

        

        if(mysqli_query($con,$sql))
        {
            echo "Tabla Cuentas_Ahorros creada.<br>";
        }
        else{
            echo "Error en la creación tabla Cuentas_Ahorros ".mysqli_error($con)."<br>";
        }


        $sql="INSERT INTO Cuentas_Ahorros(IDUSUARIO,JAVECOINS)VALUES('1','1000000')";
        if(mysqli_query($con,$sql)){
            echo "Se ha insetado la cuenta";
        }
        else {
            echo "Error insertado la cuenta";
        }

        $sql="CREATE table Creditos(
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            IDUSUARIO INT,
            CUPOJAVECOINS FLOAT,
            TASAINTERES FLOAT,
            FECHADEPAGO INT,
            TIPO CHAR,
            FOREIGN KEY (IDUSUARIO) REFERENCES Clientes(PID),
            CHECK (CUPOJAVECOINS >= 0 AND (TIPO='V' or TIPO ='C') AND (FECHADEPAGO> 0 AND FECHADEPAGO<32)))";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Creditos creada.<br>";
        }
        else{
            echo "Error en la creación tabla Creditos ".mysqli_error($con)."<br>";
        }

        $sql="INSERT INTO CREDITOS(IDUSUARIO,CUPOJAVECOINS,TASAINTERES,FECHADEPAGO,TIPO)VALUES('1','1000000','0.1','15','C')";
        if(mysqli_query($con,$sql)){
            echo "Se ha insertado EL CREDITO";
        }
        else {
            echo "Error AL INSERTAR EL CREDITO";
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
            FOREIGN KEY (PIDCUENTA) REFERENCES Cuentas_Ahorros(PID)
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Tarjetas_Credito creada.<br>";
        }
        else{
            echo "Error en la creación tabla Tarjetas_Credito ".mysqli_error($con)."<br>";
        }
		$sql="INSERT INTO Tarjetas_Credito(PIDCUENTA,CUPOMAX) VALUES(1, 1000)";
		if(mysqli_query($con,$sql)){
            echo "Se ha insertado la tarjeta CREDITO <br>";
        }
        else {
            echo "Error AL INSERTAR la tarjeta CREDITO <br>";
        }
		$sql="CREATE table Deudas_Tarjetas (
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            PIDTARJETA INT NOT NULL,
			CANTIDADPAGAR FLOAT,
            CANTIDADCUOTAS INT NOT NULL,
            CUOTASPAGAS INT DEFAULT 0,
            FOREIGN KEY (PIDTARJETA) REFERENCES Tarjetas_Credito(PID)
            )";
        if(mysqli_query($con,$sql))
        {
            echo "Tabla Tarjetas_Credito creada.<br>";
        }
        else{
            echo "Error en la creación tabla Tarjetas_Credito ".mysqli_error($con)."<br>";
        }
        mysqli_close($con);
    ?> 
    <form action="index.php" method="post">
        <input type="submit" value="Volver">
    </form>
</body>
</html>