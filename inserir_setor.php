<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$NomeSetor = trim($_POST["NomeSetor"]);

$sql = "INSERT INTO `setor` (`NomeSetor`) VALUES ('$NomeSetor')";
$inserir = mysqli_query($conexao, $sql);
?>
<?php include_once 'head.php'?>
<div style="padding:20px 0;max-width:800px;text-align:center" class="container">
    <h4>Setor: <b><?=$NomeSetor?></b> Adicionado com sucesso!</h4>
    <a class="btn btn-sm btn-primary" role="button" href="cadastrar_setor.php">Voltar para o cadastro de
        Setor</a>
</div>