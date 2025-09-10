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
$nomeForn = trim($_POST["nomeForn"]);
$cnpjForn = trim($_POST["cnpjForn"]);
$telefoneForn = trim($_POST["telefoneForn"]);
$cepForn = trim($_POST["cepForn"]);
$emailForn = trim($_POST["emailForn"]);
$cod_Forn= trim($_POST["cod_Forn"]);

// Verifica se o CNPJ já está cadastrado
$sql_verificar_cnpj = "SELECT COUNT(*) AS total FROM fornecedor WHERE cnpjForn = '$cnpjForn'";
$resultado_verificar_cnpj = mysqli_query($conexao, $sql_verificar_cnpj);
$row = mysqli_fetch_assoc($resultado_verificar_cnpj);
if ($row['total'] > 0) {
    // CNPJ já está em uso, então você pode exibir uma mensagem de erro
    echo "Este CNPJ já está cadastrado. Favor verificar.";
    echo "<script>setTimeout(function(){window.location.href='cadastrar_fornecedor.php?erro=cnpj_existente';}, 5000);</script>";
    // Você pode adicionar um redirecionamento aqui, se desejar
    exit;
}

// Insere o novo fornecedor no banco de dados
$sql = "INSERT INTO `fornecedor` (`nomeForn`, `cnpjForn`, `telefoneForn`, `cepForn`, `emailForn`, `cod_Forn`) VALUES ('$nomeForn', '$cnpjForn', '$telefoneForn', '$cepForn', '$emailForn', '$cod_Forn')";
$inserir = mysqli_query($conexao, $sql);

if ($inserir) {
    // Se a inserção for bem-sucedida, exibe uma mensagem de sucesso
    ?>
    <?php include_once 'head.php'?>
    <div style="padding:20px 0;max-width:800px;text-align:center" class="container">
        <h4>Fornecedor <b><?=$nomeForn?></b> Adicionado com sucesso!</h4>
        <a class="btn btn-sm btn-primary" role="button" href="cadastrar_fornecedor.php">Voltar para o cadastro de fornecedor</a>
    </div>
    <?php
} else {
    // Se houver algum erro ao inserir no banco de dados, exibe uma mensagem de erro
    echo "Erro ao adicionar fornecedor: " . mysqli_error($conexao);
}
?>
