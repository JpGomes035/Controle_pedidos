<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$nomeBanco = trim($_POST["nomeBanco"]);
$agencia = trim($_POST["agencia"]);
$cc = trim($_POST["cc"]);
$valor_banco = trim($_POST["valor_banco"]);

$sql = "INSERT INTO `banco` (`nomeBanco`, `agencia`, `cc`, `valor_banco`) VALUES ('$nomeBanco', '$agencia', '$cc', '$valor_banco')";
$inserir = mysqli_query($conexao, $sql);
?>
<?php include_once 'head.php'?>
<div style="padding:20px 0;max-width:800px;text-align:center" class="container">
    <h4>Banco <b><?=$nomeBanco?></b> Adicionado com sucesso!</h4>
    <a class="btn btn-sm btn-primary" role="button" href="cadastrar_banco.php">Voltar para o cadastro de
        banco</a>
</div>