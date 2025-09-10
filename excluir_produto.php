<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$id = $_GET['id'];
$sql = "UPDATE estoque SET deletado = 'S', id_reg_delet = $usuarioLogado WHERE IdProduto = $id";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_produtos.php?excluido=".$id); 
}
?>

