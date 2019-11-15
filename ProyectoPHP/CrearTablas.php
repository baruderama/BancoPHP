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
            IDUSUARIO INT,
            PRIMARY KEY(IDUSUARIO),
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
        $sql="CREATE table Creditos(
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            USUARIO VARCHAR(40) unique,
            JAVECOINS FLOAT,
            TIPO CHAR,
            CHECK (JAVECOINS >= 0 AND (TIPO='V' or TIPO ='C')))";
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
            CUENTA VARCHAR(40) NOT NULL,
            CUPOMAX FLOAT,
            SOBRECUPO FLOAT,
            CUOTAMANEJO FLOAT,
            TASAINTERES FLOAT,
            FOREIGN KEY (CUENTA) REFERENCES Clientes(USUARIO),
            FOREIGN KEY (CUENTA) REFERENCES Creditos(USUARIO)
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