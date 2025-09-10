<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$mensagem = trim($_POST["mensagem"]);

$sql = "INSERT INTO `mensagem` (`mensagem`) VALUES ('$mensagem')";
$inserir = mysqli_query($conexao, $sql);
?>
<?php include_once 'head.php'?>
<div style="padding:20px 0;max-width:800px;text-align:center" class="container">
    <h4>Mensagem adicionada com sucesso!</h4>
    <a class="btn btn-sm btn-primary" role="button" href="perfil.php">Voltar para o perfil.</a>
</div>