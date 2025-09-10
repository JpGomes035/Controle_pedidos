<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';


$IdUsuario = $_GET['IdUsuario'];
$sql = "DELETE FROM usuario WHERE IdUsuario = $IdUsuario";
$update = mysqli_query($conexao,$sql);

if($update){
    header("Location: listar_usuario.php?excluido=".$IdUsuario); 
}
?>
