<?php
    include 'tabelacadastro.php';

    echo $_GET["nomeu"];
    $nomeu = $_GET["nomeu"];
    
    echo $_GET["senha"];
    $senha = $_GET["senha"];

$sql = "SELECT * FROM usuario WHERE NomeUsuario ='$nomeu' and Senha='$senha'";

        mysqli_query($con,$sql);

        if (mysqli_affected_rows($con)!=0) {

           //login ok

            mysqli_close($con);
            header('location:feed.php'); //chama a tela inicial do sistema

        } else {

           //login erro

            mysqli_close($con);

            header('location:../tela_cadastro.html'); //chama a tela de cadastro do sistema

        }    
?>