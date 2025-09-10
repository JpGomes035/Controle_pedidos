<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$codigo_pedido = $_GET['codigo_pedido'];
$sql = "UPDATE pedidos SET deletado = 'S', id_reg_delet = $usuarioLogado WHERE codigo_pedido = $codigo_pedido";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: lista_pedidos.php?excluido=".$codigo_pedido); 
}
?>
