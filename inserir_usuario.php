<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once 'password.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processando</title>
    <style>
        body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
            color: black;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $nome = trim($_POST["nome"]);
    $sobrenome = trim($_POST["sobrenome"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    $nivelUsuario = trim($_POST["nivelUsuario"]);
    $telefoneUsuario = trim($_POST["telefoneUsuario"]);
    $cpfUsuario = trim($_POST["cpfUsuario"]);
    $Setor = trim($_POST["Setor"]);

    // Verifica se o email já está cadastrado
    $sql_verificar_email = "SELECT COUNT(*) AS total FROM usuario WHERE Email = '$email'";
    $resultado_verificar_email = mysqli_query($conexao, $sql_verificar_email);
    $row = mysqli_fetch_assoc($resultado_verificar_email);
    if ($row['total'] > 0) {
        // Email já está em uso, então você pode exibir uma mensagem de erro ou redirecionar de volta ao formulário de cadastro
        echo "Este email já está cadastrado. Por favor, escolha outro.";
        echo "<script>setTimeout(function(){window.location.href='cadastrar_usuario.php?erro=email_existente';}, 5000);</script>";
        exit;
    }

    // Insere o novo usuário no banco de dados
    $sql = "INSERT INTO `usuario` (`Nome`, `Sobrenome`, `Email`, `Senha`, `NivelUsuario`, `Status`, `telefoneUsuario`, `cpfUsuario`, `Setor`) VALUES " .
        "('$nome', '$sobrenome','$email', sha1('$senha'), $nivelUsuario, 'Ativo', '$telefoneUsuario', '$cpfUsuario', '$Setor')";
    $inserir = mysqli_query($conexao, $sql);

    if ($inserir) {
        // Se a inserção for bem-sucedida, exibe uma mensagem de sucesso
    ?>
        <?php include_once 'head.php' ?>
        <div style="padding:20px 0;max-width:800px;text-align:center" class="container">
            <h4>Usuário <b><?= $nome . ' ' . $sobrenome ?></b> Cadastrado com sucesso!</h4>
            <a class="btn btn-sm btn-primary" role="button" href="cadastrar_usuario.php">Voltar para o cadastro de usuário</a>
        </div>
    <?php
    } else {
        // Se houver algum erro ao inserir no banco de dados, exibe uma mensagem de erro
        echo "Erro ao cadastrar usuário: " . mysqli_error($conexao);
    }
    ?>
</body>

</html