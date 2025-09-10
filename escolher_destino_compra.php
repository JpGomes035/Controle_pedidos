<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <style>
    body {
        background: linear-gradient(to bottom, #2a9d8f, #264653);
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
</style>
</head>
<body>
<?php
// Verifique se o código do pedido e o valor total foram passados via GET
if (isset($_GET['codigo_pedido']) && isset($_GET['valor_total'])) {
    // Obtenha o código do pedido e o valor total
    $codigo_pedido = $_GET['codigo_pedido'];
    $valor_total = $_GET['valor_total'];

    // Exiba o valor total do pedido
    echo "<p>Valor Total do Pedido: R$ $valor_total</p>";
?>
<p><b>O Pedido vai ser marcado como pago automaticamente após o processo.</b></p>
<p><b>Vai ser descontado o valor total do pedido do banco que for escolhido abaixo.</b></p>
<form action="processar_destino_compra.php" method="post">
    <input type="hidden" name="codigo_pedido" value="<?= $codigo_pedido ?>">
    <input type="hidden" name="valor_total" value="<?= $valor_total ?>">
    <!-- Adicione aqui opções para o usuário escolher onde deseja receber o pagamento -->
    <div class="form-group">
        <label for="destino"><b>Qual o banco responsável?</b></label>
        <select class="form-control" id="destino" name="destino">
            <?php
            $sqlnome = "SELECT * FROM banco ORDER BY nomeBanco ASC";
            $retornonome = mysqli_query($conexao, $sqlnome);
            while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                $idBanco = $array["idBanco"];
                $nomeBanco = $array["nomeBanco"];
                $valor_banco = $array["valor_banco"];
                echo "<option value='$nomeBanco'> $nomeBanco | R$ Total: $valor_banco </option>";
            ?>                
            <?php } ?>
        </select>
    </div>
    <button type="submit">Confirmar</button>
</form>
<?php
} else {
    echo "Código do pedido ou valor total não especificados.";
}
?>
<a href="lista_pedido_compras.php">Voltar</a>
</body>
</html>

