<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio 1</title>
    <link rel='stylesheet' href='css/style.css'>
    <title>Cadastro usuário</title>
</head>

<body id='bodyusuario'>

    <?php
    include 'tabelacadastro.php';
    ?>
    </head>

    <body>
        
        
        <div id='titulodados'><h1>Dados do cliente</h1></div>
        <div id='dados'> 
            Nome:
            <?php
            echo $_GET["nome"];
            $nome = $_GET["nome"];
            ?> <br>
        </div>

        <div id='dados'>
            Sobrenome:
            <?php
            echo $_GET["snome"];
            $snome = $_GET["snome"];
            ?> <br>
        </div>

        <div id='dados'>
            Nome de Usuário:
            <?php
            echo $_GET["nomeu"];
            $nomeu = $_GET["nomeu"];
            ?> <br>
        </div>

        <div id='dados'>
            Telefone:
            <?php
            echo $_GET["telefone"];
            $telefone = $_GET["telefone"];
            ?> <br>
        </div>
     
        <div id='dados'>
            Email:
            <?php
            echo $_GET["email"];
            $email = $_GET["email"];
            ?> <br>
        </div>

        <div id='dados'>
            Senha:
            <?php
            echo $_GET["senha"];
            $senha = $_GET["senha"];
            ?> <br>
        </div>

        <!-- PAREI AQUI (pedro) -->
        <?php
        $sql = "INSERT INTO Usuario (Nome, Sobrenome, NomeUsuario, Telefone, Email, Senha) 
        VALUES ('$nome' ,'$snome', '$nomeu','$telefone', '$email', '$senha')";
        mysqli_query($con, $sql);
        if (mysqli_error($con)) {
            echo mysqli_error($con);
        } else {
            echo "Usuario cadastrado com sucesso!";
        }
        mysqli_close($con);
        ?>
        <br>
        <a href='../index.html'>
            <input type='button' value='Novo Cadastro' id='botaousuario' />
        </a>
    </body>


</html>