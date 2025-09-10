<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<?php include_once ('menu.php'); ?>

<head>
  <link rel="stylesheet" href="perfil.css">
  <title>Perfil</title>
</head>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Configurações do diretório de upload
  $targetDir = "upload-imagens/";
  $allowTypes = array('jpg', 'jpeg', 'png', 'jfif');

  // Conexão com o banco de dados
  include_once 'conexao.php';

  // Verifica se o arquivo foi enviado corretamente
  if (!empty($_FILES['imagem']['name'])) {
    $fileName = basename($_FILES['imagem']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Verifica se o tipo de arquivo é permitido
    if (in_array(strtolower($fileType), $allowTypes)) {
      // Move o arquivo para o diretório de upload
      if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFilePath)) {
        // Insere o nome original do arquivo no banco de dados
        $sql = "INSERT INTO imagens (nome) VALUES ('$fileName')";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
          echo "<br> <b><i class='fa fa-check' aria-hidden='true'></i> Arquivo enviado com sucesso e salvo no banco de dados.</b>";
        } else {
          echo "<br><b><i class='fa fa-times' aria-hidden='true'></i> Erro ao salvar o nome do arquivo no banco de dados. </b>";
        }
      } else {
        echo "<br> <b><i class='fa fa-times' aria-hidden='true'></i> Erro ao fazer o upload do arquivo. </b>";
      }
    } else {
      echo "<br> <b><i class='fa fa-times' aria-hidden='true'></i> Tipo de arquivo não permitido. <br> Formatos permitidos: <br> JPG, JPEG e PNG e JFIF.</b>";
    }
  } else {
    echo "<br> <b><i class='fa fa-times' aria-hidden='true'></i> Nenhum arquivo selecionado.</b>";
  }
}
?>
<div class="form_mens-container">
  <div class="form_mens">
    <form action="inserir_mensagem.php" method="post">
      <input type="hidden" class="form-control" id="idMensagem" name="idMensagem">
      <label for="mensagem">Qual a mensagem inicial para os clientes?</label>
      <textarea name="mensagem" id="mensagem" rows="5" required
        placeholder="Mensagem que vai ser enviada para o cliente no WhatsApp assim que iniciada a conversa."></textarea>
      <input type="submit" value="Enviar">
    </form>
  </div>
</div>
<br><br>
<div class="retangulo">
 <h6>Clique duas vezes na logo</h6>
  <?php
  // Consulta SQL para buscar a última imagem adicionada
  $sql = "SELECT nome FROM imagens ORDER BY id_imagem DESC LIMIT 1";
  $resultado = mysqli_query($conexao, $sql);
  if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $imagem = $row['nome'];

    // Exibe o retângulo HTML com a imagem
    echo '<img src="upload-imagens/' . $imagem . '" alt="Logo da Empresa" ondblclick="ampliarImagem(this)">';
  } else {
    echo "<i class='fa fa-times' aria-hidden='true'></i> Nenhuma imagem encontrada.";
  }
  ?>
</div>
<!-- Formulário HTML para upload de imagem -->
<div class="form_img">
  <form action="" method="post" enctype="multipart/form-data">
    <label for="imagens"><b>Troque sua Logo aqui: </b></label>
    <input type="file" name="imagem">
    <br>
    <input type="submit" value="Enviar">
  </form>

  <div id="idUsuario">
    <?php
    $mostrarInformacoes = true; // Defina o valor padrão conforme necessário
    
    if ($mostrarInformacoes) {
      $sql = "SELECT Nome, Email FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
      $retorno = mysqli_query($conexao, $sql);

      if (mysqli_num_rows($retorno) > 0) {
        $row = mysqli_fetch_assoc($retorno);
        $nomeUser = $row["Nome"];
        $emailUser = $row["Email"];
      }
      echo "<b> User Logado: </b><br>";
      echo $nomeUser . " #" . $usuarioLogado;
      echo '<br>'. $emailUser;

    }
    ?>
  </div>
  <br>
  <?php
  $numero_suporte = '+55 35 8468-7649';
  include_once 'conexao.php';
  $sql = "SELECT id_info, nome, cnpj, email, telefone, rua, cep, cidade FROM `informacoes`";
  $retorno = mysqli_query($conexao, $sql);

  while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
    $id_info = $array['id_info'];
    $nome = $array['nome'];
    $cnpj = $array['cnpj'];
    $email = $array['email'];
    $telefone = $array['telefone'];
    $rua = $array['rua'];
    $cep = $array['cep'];
    $cidade = $array['cidade'];

    $mensagem_suporte = 'Somos da ' . $nome . ' Precisamos de suporte técnico. Pode nos ajudar?';
  }
  ?>
  <a href="info_perfil.php" class="infoperfil"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Ver informações
      da empresa </b><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  <br>
  <a href="https://web.whatsapp.com/send?phone=<?= $numero_suporte ?>&text=<?= $mensagem_suporte ?> " class="infoperfil"
    target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Suporte Técnico </b><i
      class="fa fa-arrow-left" aria-hidden="true"></i></a>
  <br>
  <a href="cadastrar_usuario.php" class="infoperfil" target ="_blank" aria-hidden="true"><i class="fa fa-arrow-right" aria-hidden="true"></i><b> Cadastrar usuário </b></a><i class="fa fa-arrow-left" aria-hidden="true"></i>
</div>
</div>

<script>
function ampliarImagem(img) {
  var src = img.src;
  var newWindow = window.open();
  newWindow.document.write('<img src="' + src + '" style="width:100%">');
  newWindow.document.title = "Imagem Ampliada";
}
</script>
