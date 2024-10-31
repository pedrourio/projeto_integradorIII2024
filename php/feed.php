<?php
include 'tabelacadastro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inserção de Texto
    if (isset($_POST["Texto"]) && !empty($_POST["Texto"])) {
        $Texto = mysqli_real_escape_string($con, $_POST["Texto"]);
        $sql = "INSERT INTO ObjetoDeEstudo (Texto) VALUES (?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $Texto);

        if (mysqli_stmt_execute($stmt)) {
            echo "Texto inserido com sucesso!";
        } else {
            echo "Erro ao inserir texto: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
        header('location:feed.php');
        exit();
    }

    // Inserção de Arquivo
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $extensaoArquivo = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('arquivo_', true) . '.' . $extensaoArquivo;
        $tipoArquivo = $_FILES['arquivo']['type'];
        $tamanhoArquivo = $_FILES['arquivo']['size'];
        $conteudoArquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
        

        
        

        $sql = "INSERT INTO Arquivo (Nome, Tipo, Tamanho, _Arquivo) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        
        mysqli_stmt_bind_param($stmt, 'ssbsi', $nomeArquivo, $tipoArquivo, $tamanhoArquivo, $conteudoArquivo);


        mysqli_stmt_send_long_data($stmt, 3, $conteudoArquivo);

        if (mysqli_stmt_execute($stmt)) {
            echo "Arquivo enviado e salvo com sucesso!";
        } else {
            echo "Erro ao salvar o arquivo: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    }
}


mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Feed</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/feed.css">
</head>

<body>
    <div class='row'>
        <!-- Coluna Esquerda -->
        <div class="col-lg-3 coluna-lateral">
            <img src="../img/logomarca.png" />
            <button type="submit" class="botaoColEsq" id='abrirtela'>Escrever</button>
            <button type="button" class="botaoColEsq">
                <i class="fas fa-user"></i> Acessar Perfil
            </button>
            <button type="button" class="botaoColEsq">
            <a href="../index.html">Sair do Sistema</a>
            </button><br>
        </div>

        <!-- Coluna Central (Feed) -->
        <div class="col-lg-6">
            <header>
                <div class="navbar">
                    <div class="logo"><img class="logoheader" src="../img/logotipo.png"></div>
                    <div class="search-bar">
                        <input type="text" placeholder="Ex: @gemeosshowdebola">
                        <button id="bpesquisar"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </header>
            <main>
                <div id="feed-container">
                    <!-- POSTAGEM FIXA EXEMPLO -->
                <div class="mensagem"></div>

                <div class="mensagem">
                    <div class="cabecalhomensagem"><i>User123</i>
                    </div>
                    <p>Esta é uma postagem com foto</p>
                    <img class='imgpost' src="../img/paisagem.jpg" >
                </div>


                    <?php
                    include 'tabelacadastro.php';

                    
                    $sqlTexto = "SELECT Texto FROM ObjetoDeEstudo";
                    $sqlArquivo = "SELECT Nome, Tipo, _Arquivo FROM Arquivo";

                    $resultTexto = mysqli_query($con, $sqlTexto);
                    $resultArquivo = mysqli_query($con, $sqlArquivo);

                    if (mysqli_num_rows($resultTexto) > 0) {
                        while ($row = mysqli_fetch_assoc($resultTexto)) {
                            echo '<div class="mensagem"><div class="cabecalhomensagem"><i>User123</i>' . '</div>' . htmlspecialchars($row['Texto']) . '</div>';
                        }
                    } else {
                        echo '<p>Nenhum texto encontrado.</p>';
                    }

                    if (mysqli_num_rows($resultArquivo) > 0) {
                        while ($row = mysqli_fetch_assoc($resultArquivo)) {
                            // Exibir arquivo como imagem se for do tipo imagem
                            if (strpos($row['Tipo'], 'image') !== false) {
                                echo '<div class="mensagem"><img src="data:' . $row['Tipo'] . ';base64,' . base64_encode($row['_Arquivo']) . '" alt="' . htmlspecialchars($row['Nome']) . '"></div>';
                            } else {
                                // Exibir um link para download do arquivo
                                echo '<div class="mensagem"><a href="data:' . $row['Tipo'] . ';base64,' . base64_encode($row['_Arquivo']) . '" download="' . htmlspecialchars($row['Nome']) . '">Baixar ' . htmlspecialchars($row['Nome']) . '</a></div>';
                            }
                        }
                    } else {
                        echo '<p>Nenhum arquivo encontrado.</p>';
                    }

                    mysqli_close($con);
                    ?>
                </div>
        </div>

        <!-- Coluna Direita -->
        <div class="col-lg-3 coluna-lateral">
            <img src="../img/logomarca.png" />
        </div>
        </main>
    </div>
    <!-- Formulário Oculto como Modal -->
    <div id="fundoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1200;">
        <div id="formularioEscrever" style="color: white;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #52559fe0; padding: 20px; width: 80%; max-width: 600px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <!-- Botão de Fechar -->
            <button type="button" id="fecharFormulario" style="position: absolute; top: 10px; right: 10px; background: transparent; border: none; font-size: 18px; cursor: pointer; color: white">X</button>

            <form enctype="multipart/form-data" id="ObjetoDeEstudo" action="feed.php" method="post">
                <input type="text" id="Texto" name="Texto" placeholder="Digite seu texto aqui" required>
                <input id='arquivo' type="file" name="arquivo">
                <button type="submit" class="Enviar">Enviar</button>
                <div id="mensagemErro" class="invalid-feedback"></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l3r1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="../js/Vfeed.js" type="text/javascript"></script>
</body>

</html>
