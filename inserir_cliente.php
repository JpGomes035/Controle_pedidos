<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
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
$nomeCliente = trim($_POST["nomeCliente"]);
$numeroCliente = trim($_POST["numeroCliente"]);
$emailCliente = trim($_POST["emailCliente"]);
$cepCliente = trim($_POST["cepCliente"]);
$cpfCliente = trim($_POST["cpfCliente"]);

// Verifica se o CPF já está cadastrado
$sql_verificar_cpf = "SELECT COUNT(*) AS total FROM cliente WHERE cpfCliente = '$cpfCliente'";
$resultado_verificar_cpf = mysqli_query($conexao, $sql_verificar_cpf);
$row = mysqli_fetch_assoc($resultado_verificar_cpf);
if ($row['total'] > 0) {
    // CPF já está em uso, então você pode redirecionar de volta ao formulário de cadastro
    echo "Este CPF já está cadastrado. Favor verificar.";
    echo "<script>setTimeout(function(){window.location.href='cadastrar_cliente.php?erro=cpf_existente';}, 5000);</script>";
    exit; // Sai do script após o redirecionamento
}

// Insere o novo cliente no banco de dados
$sql = "INSERT INTO `cliente` (`nomeCliente`, `numeroCliente`, `emailCliente`, `cepCliente`, `cpfCliente`) VALUES ('$nomeCliente', '$numeroCliente', '$emailCliente', '$cepCliente', '$cpfCliente')";
$inserir = mysqli_query($conexao, $sql);

if ($inserir) {
    // Se a inserção for bem-sucedida, exibe uma mensagem de sucesso
    ?>
    <?php include_once 'head.php'?>
    <div style="padding:20px 0;max-width:800px;text-align:center" class="container">
        <h4>Cliente <b><?=$nomeCliente?></b> Adicionado(a) com sucesso!</h4>
        <a class="btn btn-sm btn-primary" role="button" href="cadastrar_cliente.php">Voltar para o cadastro de cliente</a>
    </div>
    <?php
} else {
    // Se houver algum erro ao inserir no banco de dados, exibe uma mensagem de erro
    echo "Erro ao adicionar cliente: " . mysqli_error($conexao);
}
?>
</body>
</html