<?php 

    // Conect to database
    $dsn = "mysql:host=localhost;dbname=belyfood";
    $user = "root";
    $password = "";

    try{
        $con = new PDO($dsn, $user, $password);
    } catch (PDOException $e){
        echo "error: " . $e->getMessage();
    }
?>