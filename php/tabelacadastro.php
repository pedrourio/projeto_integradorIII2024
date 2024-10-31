<?php
$con = mysqli_connect("localhost", "User1", "User1", "Estudy");//servidor, usuario, senha, banco


if(mysqli_connect_error()){
    echo 'Erro na conexão com BD: '.mysqli_connect_error();
}

?>