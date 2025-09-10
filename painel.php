<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="painel.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">

<head>
  <title>Painel</title>
</head>

<body>
  <div class="container">
    <div class="panel">
      <p style="color: white; font-size: 16px; text-align: center;">Painel do Sistema ao Total</p>
      <div class="chart">
        <div class="chart-header">
        </div>
        <div class="chart-content">
          <div class="chart-labels">
            <span class="fa fa-money"> Rendas:</span>
          </div>
          <?php
          include_once 'conexao.php';
          $sql2 = "SELECT SUM(valor_total) AS v_total_pedidos FROM pedidos where pago ='S' and deletado = 'N';";
          $retorno2 = mysqli_query($conexao, $sql2);

          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $v_total_pedidos = $resultado['v_total_pedidos'];

            // Exibe o resultado na tela
            echo "<p class='chart-label'>Pedidos já recebidos: R$" . number_format($v_total_pedidos, 2, ',', '') . "</p>";
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }


          ?>

          <div class="chart-bar-recebidos" style="width: 70%;">
            <?php echo "R$" . number_format($v_total_pedidos, 2, ',', ''); ?>
          </div>
        </div>
      </div>
      <div class="chart">
        <div class="chart-content">
          <div class="chart-labels">
            <span class="fa fa-money"> Despesas:</span>
          </div>
          <?php
          include_once 'conexao.php';

          $sql2 = "SELECT SUM(valor_total) AS v_total_ped_compras FROM pedido_compra WHERE pago = 'S' AND deletado = 'N';";
          $retorno2 = mysqli_query($conexao, $sql2);

          if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $v_total_ped_compras = $resultado['v_total_ped_compras'] ?? 0; // Valor padrão caso seja nulo

            // Exibe o total de pedidos pagos
            echo "<p class='chart-label'>Pedidos já pagos: R$" . number_format($v_total_ped_compras, 2, ',', '') . "</p>";

            // Certifique-se de inicializar a variável $v_total_pedidos

            // Calcula a diferença entre a renda e a despesa
            $diferenca = $v_total_pedidos - $v_total_ped_compras;

            // Define a cor da diferença com base na condição
            $corDiferenca = ($v_total_pedidos > $v_total_ped_compras) ? 'green' : 'red';

            // Exibe o resultado na tela com a cor formatada
            echo sprintf('<p style="color: %s;">A diferença entre renda e despesas é: R$%s</p>', $corDiferenca, number_format($diferenca, 2, ',', ''));
          } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
          }
          ?>
          <div class="chart-bar" style="width: 70%;">
            <?php echo "R$" . number_format($v_total_ped_compras ?? 0, 2, ',', ''); ?>
          </div>

        </div>
      </div>
      <h6>Clique aqui para realizar o Backup: <a href="backup\backup.php"><i class="fa fa-database"
            aria-hidden="true"></i> Realizar backup.</a></h6>
      <h6>Listagem de Backup: <a href="backup/lista_backup.php"><i class="fa fa-database" aria-hidden="true"></i>
          Backups.</a></h6>
      <h6>Voltar: <a href="lista_pedidos.php"><i class="fa fa-home" aria-hidden="true"></i>Voltar.</a></h6>


    </div>
    <?php include_once('footer.php') ?>
  </div>
</body>

</html>