<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<?php include_once('menu.php'); ?>

<head>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
  <title>Perfil </title>

</head>

<div class="content-wrapper">
  <div class="container">
    <div class="profile">
      <h2>Informações atuais da Empresa</h2>
      <h6>Caso queira trocar suas informações, entre em contato conosco.</h6>
      <br>
      <table class="profile-table">
        <tbody>
          <?php
          $numero_suporte = '+55 35 8468-7649';
          include_once 'conexao.php';
          $sql = "SELECT id_info, nome, cnpj, email, telefone, rua, cep, cidade, bairro FROM `informacoes`";
          $retorno = mysqli_query($conexao, $sql);

          while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $id_info = $array['id_info'];
            $nome = $array['nome'];
            $cnpj = $array['cnpj'];
            $email = $array['email'];
            $telefone = $array['telefone'];
            $rua = $array['rua'];
            $bairro = $array['bairro'];
            $cep = $array['cep'];
            $cidade = $array['cidade'];

            $mensagem_suporte = 'Somos da ' . $nome . ' Precisamos de suporte técnico. Pode nos ajudar?';
            ?>
            <tr>
              <td>ID:</td>
              <td>
                <?php echo "#" . $id_info; ?>
              </td>
            </tr>
            <tr>
              <td>Nome:</td>
              <td>
                <?php echo $nome; ?>
              </td>
            </tr>
            <tr>
              <td>Documento:</td>
              <td>
                <?php echo $cnpj; ?>
              </td>
            </tr>
            <tr>
              <td>Email:</td>
              <td>
                <?php echo $email; ?>
              </td>
            </tr>
            <tr>
              <td>Telefone:</td>
              <td>
                <?php echo $telefone; ?>
              </td>
            </tr>
            <tr>
              <td>Endereço:</td>
              <td>
                <?php echo $rua; ?>
              </td>
            </tr>
            <tr>
              <td>Bairro:</td>
              <td>
                <?php echo $bairro; ?>
              </td>
            </tr>           
            <tr>
              <td>CEP:</td>
              <td>
                <?php echo $cep; ?>
              </td>
            </tr>
            <tr>
              <td>Cidade:</td>
              <td>
                <?php echo $cidade; ?>
              </td>
            </tr>
          <?php } ?>
          <tr>
            <td>Suporte Téc.: </td>
            <td><a href="https://web.whatsapp.com/send?phone=<?= $numero_suporte ?>&text=<?= $mensagem_suporte ?> "
                target="_blank" style="color: blue;">Entre em contato.</a></td>
          </tr>
        </tbody>
      </table>
      <br>
      <a href="perfil.php">Voltar</a>
    </div>
  </div>

  <style>
    body {
      background: linear-gradient(to bottom, #2a9d8f, #264653);
      color: black;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-weight: bold;
      text-align: left;
    }

    th,
    td {
      padding: 10px;
      border: 2px solid #000;
    }

    th {
      background-color: grey;
      color: white;
      font-weight: bold;
      text-align: center;
    }

    td {
      background-color: #f9f9f9;
      font-weight: bold;
      text-align: center;
    }

    h1 {
      font-size: 24px;
      font-weight: bold;
    }

    h6 {
      font-weight: bold;
    }

    p {
      font-size: 16px;
      font-weight: bold;
      line-height: 1.6;
    }

    .dark-mode 
    label,
    h2,
    h6{
      color: whitesmoke;
      font-weight: bold;
    }