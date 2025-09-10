<?php
include_once 'iniciar_sessao.php';

$cliente_id = $_GET['cliente_id']; // Alterando para GET, pois está sendo passado via URL

// Validar se $cliente_id foi passado e é um número válido
if(isset($cliente_id) && is_numeric($cliente_id)) {
    $sql = "UPDATE clients SET pago = 'nao' WHERE cliente_id = $cliente_id";
    $update = mysqli_query($conexao, $sql);

    if ($update) {
        header("Location: ProControl.php?" . $cliente_id);
        exit(); // Finaliza o script após o redirecionamento
    } else {
        echo "Erro ao atualizar o pagamento.";
    }
} else {
    echo "Cliente ID inválido.";
}
?>
