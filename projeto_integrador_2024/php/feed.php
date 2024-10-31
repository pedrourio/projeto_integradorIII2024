<?php
include 'tabelacadastro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["Texto"])) {
  $Texto = mysqli_real_escape_string($con, $_POST["Texto"]);

  $sql = "INSERT INTO ObjetoDeEstudo (Texto) VALUES (?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, 's', $Texto);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_error($stmt)) {
    echo mysqli_stmt_error($stmt);
  } else {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    header('location:feed.php'); // abre novamente a tela do feed
    exit();
  }
}
?>

<?php
include 'tabelacadastro.php'; // Inclua a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifique se o arquivo foi enviado sem erros
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        // Gera um nome único para o arquivo
        $extensaoArquivo = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION); // Obtém a extensão original do arquivo
        $nomeArquivo = uniqid('arquivo_', true) . '.' . $extensaoArquivo; // Nome único com prefixo e extensão
        
        $tipoArquivo = $_FILES['arquivo']['type'];
        $tamanhoArquivo = $_FILES['arquivo']['size'];
        $conteudoArquivo = file_get_contents($_FILES['arquivo']['tmp_name']); // Lê o conteúdo do arquivo
        $idObjetoDeEstudo = $_POST['idObjetoDeEstudo']; // Pegue o ID do objeto de estudo

        // Prepare o comando SQL para inserir o arquivo na tabela
        $sql = "INSERT INTO Arquivo (Nome, Tipo, Tamanho, _Arquivo, idObjetoDeEstudo) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        // Associe os parâmetros à instrução preparada
        mysqli_stmt_bind_param($stmt, 'ssdsi', $nomeArquivo, $tipoArquivo, $tamanhoArquivo, $conteudoArquivo, $idObjetoDeEstudo);

        // Execute a instrução
        if (mysqli_stmt_execute($stmt)) {
            echo "Arquivo enviado e salvo com sucesso!";
        } else {
            echo "Erro ao salvar o arquivo: " . mysqli_error($con);
        }

        // Feche a instrução e a conexão
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}
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

      <img src="../img/logo.png" />

      
      <!-- botao de ABRIR TELA de escrever -->
      <button type="submit" class="Enviar" id='abrirtela'>Escrever</button>
      

  

      <!-- link para o perfil -->
       
      <button type="button" id="Perfil" id="perfil">
        <i class="fas fa-user"></i> Acessar Perfil
      </button><br>
  </div>

    <!-- Coluna Central (Feed) -->
    <div class="col-lg-6">
      <header>
        <div class="navbar">
          <div class="logo"><img class="logoheader" src="../img/logo.png"></div>

         
            <div class="search-bar">
            <input type="text" placeholder="Ex: @gemeosshowdebola">
            <button id="bpesquisar"><i class="fas fa-search"></i></button>
           </div>
          
        </div>
        
      </header>

      

      <main>





        <div id="feed-container">
          <?php
          include 'tabelacadastro.php';

          $sqlObjetoDeEstudo = "SELECT Texto FROM ObjetoDeEstudo";
          $result = mysqli_query($con, $sqlObjetoDeEstudo);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="mensagem"><div class="cabecalhomensagem"><i>User123</i>' . '</div>' . htmlspecialchars($row['Texto']) . '</div>  ';
            }
          } else {
            echo '<p>Nenhuma mensagem encontrada.</p>';
          }

          mysqli_close($con);
          ?>
          <?php
          include 'tabelacadastro.php';

          $Arquivo = "SELECT _Arquivo FROM Arquivo";
          $result = mysqli_query($con, $Arquivo);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              // Decodifica o conteúdo BLOB e exibe como uma imagem
              echo '<div class="mensagem"><div class="cabecalhomensagem"><i>User123</i></div>';
              echo '<img src="data:image/png;base64,' . base64_encode($row['_Arquivo']) . '" alt="Imagem" />';
              echo '</div>';
            }
          } else {
            echo '<p>Nenhuma mensagem encontrada.</p>';
          }

          mysqli_close($con);
          ?>
        </div>
    </div>

    <!-- Coluna Direita -->
    <div class="col-lg-3 coluna-lateral">
      <img src="../img/logo.png" />
    </div>

    </main>
  </div>


          <!-- Formulário Oculto como Modal -->
          <div id="fundoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1200;">
      <div id="formularioEscrever" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; width: 80%; max-width: 600px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <!-- Botão de Fechar -->
        <button type="button" id="fecharFormulario" style="position: absolute; top: 10px; right: 10px; background: transparent; border: none; font-size: 18px; cursor: pointer;">X</button>
        
        <form enctype="multipart/form-data" id="ObjetoDeEstudo" action="feed.php" method="post">
          <input type="text" id="Texto" name="Texto" placeholder="Digite seu texto aqui" required>
          <div>
            <button type="submit" class="Enviar">Enviar</button>
            
            
            <label for="arquivo">Escolha um arquivo:</label>
        <input type="file" name="arquivo" id="arquivo" required>

        <label for="idObjetoDeEstudo">ID do Objeto de Estudo:</label>
        <input type="number" name="idObjetoDeEstudo" id="idObjetoDeEstudo" required>

        <button type="submit">Enviar Arquivo</button>
          </div>
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