<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lista Pedido Compras</title>
    <style>
        .container {
            padding-top: 20px;
        }

        .form-control {
            width: 300px;
            display: inline-block;
        }

        .btn-primary {
            margin-left: 10px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination-link {
            padding: 5px 10px;
            margin: 0 5px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 3px;
        }

        .pagination-link:hover,
        .pagination-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-editar {
            margin-right: 5px;
        }

        #alerta {
            margin-top: 20px;
        }

        body {
            background: linear-gradient(to bottom, #4daaaa, #a7a4a4);
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

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: grey;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
        }

        th,
        tr,
        td {
            text-align: center;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        .pago-azul {
            color: blue;
        }

        .nao-pago-vermelho {
            color: red;
        }

        .chart {
            width: 400px;
            /* Ajuste conforme necessário */
            height: 80px;
            /* Ajuste conforme necessário */
            border: 1px solid #ccc;
            margin: 20px;
            padding: 10px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .bar {
            background-color: #4CAF50;
            height: 100%;
            width: 200%;
            transition: width 0.5s;
        }

        .icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: black;
        }

        .label {
            margin-left: 30px;
            font-size: 16px;
            /* Ajuste conforme necessário */
            font-weight: bold;
            color: #333;
        }

        .status {
            color: red;
        }
    </style>
</head>

<body>
    <?php include_once('menu.php'); ?>
    <div class="container">
        <h3 style="margin-bottom:30px">Lista de pedidos de compra</h3>
        <h6><b>Clique no Cod_pedido pra gerar comprovante, clique no fornecedor pra abrir os detalhes do pagamento. Dest é para inserir o valor total em algum banco cadastrado</h6>
        </b>
        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control"
                    placeholder="Pesquisar por nome do Fornecedor e cod_pedido ou status" name="pesquisar"
                    value="<?= isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </div>
        </form>

        <?php
        include_once 'conexao.php';

        // Configuração da paginação
        $registrosPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $offset = ($paginaAtual - 1) * $registrosPorPagina;

        // Filtro de pesquisa
        $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

        // Consulta SQL com filtro de pesquisa
        $sql = "SELECT codigo_pedido, nome_fornecedor, responsavel_pedido, observacoes, valor_total, data, pago FROM `pedido_compra` WHERE (codigo_pedido LIKE '%$pesquisar%' OR nome_fornecedor LIKE '%$pesquisar%' OR pago LIKE '%$pesquisar%') AND deletado = 'N' LIMIT $offset, $registrosPorPagina";

        $retorno = mysqli_query($conexao, $sql);

        $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo_pedido FROM `pedido_compra` WHERE (nome_fornecedor LIKE '%$pesquisar%' OR pago LIKE '%$pesquisar%') AND deletado = 'N'"));

        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);


        ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cod_pedido</th>
                    <th scope="col">Nome do Fornecedor</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Valor_total</th>
                    <th scope="col">Data</th>
                    <th scope="col">Pago?</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $codigo_pedido = $array['codigo_pedido'];
                    $nome_fornecedor = $array['nome_fornecedor'];
                    $responsavel_pedido = $array['responsavel_pedido'];
                    $observacoes = $array['observacoes'];
                    $valor_total = $array['valor_total'];
                    $data = $array['data'];
                    $pago = $array['pago'];
                    ?>
                    <tr>
                        <td>
                            <a href="detalhes_pedido_compra.php?codigo_pedido=<?= $codigo_pedido ?>" target="blank">
                                <?= $codigo_pedido ?>
                            </a>
                        </td>
                        <td>
                            <a href="info_pagamento.php?codigo_pedido=<?= $codigo_pedido ?>">
                                <?= $nome_fornecedor ?>
                            </a>
                        </td>
                        <td>
                            <?= $responsavel_pedido ?>
                        </td>
                        <td>
                            <?= $valor_total ?>
                        </td>
                        <td>
                            <?php
                            // Recebe a data original e formata para o formato desejado
                            $data_emissao_original = $data;
                            $timestamp = strtotime($data_emissao_original);
                            $data_emissao_formatada = date("d/m/y", $timestamp); // A letra "Y" representa o ano com 4 dígitos
                            echo $data_emissao_formatada;
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($pago == 'S') {
                                echo "<span class='pago-azul'>$pago</span>";
                            } elseif ($pago == 'N') {
                                echo "<span class='nao-pago-vermelho'>$pago</span>";
                            } else {
                                echo $pago;
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn-editar btn btn-sm btn-warning"
                                href="pedido_compra_pago.php?codigo_pedido=<?= $codigo_pedido ?>"
                                onclick="return confirm('Tem certeza de que deseja pagar este pedido?')" role="button"><i
                                    class="fa fa-money"></i> Pag</a>
                            <a class="btn-editar btn btn-sm btn-info"
                                href="escolher_destino_compra.php?codigo_pedido=<?= $codigo_pedido ?>&valor_total=<?= $valor_total ?>"
                                role="button">
                                <i class="fa fa-location-arrow"></i> Dest
                            </a>
                            <a class="btn-editar btn btn-sm btn-warning"
                                href="estornar_pedido_compra.php?codigo_pedido=<?= $codigo_pedido ?>"
                                onclick="return confirm('Tem certeza de que deseja estornar este pedido?')" role="button"><i
                                    class="fa fa-money"></i> Est</a>

                            <?php if ($nivel == 1) { ?>
                                <a class="btn-editar btn btn-sm btn-danger"
                                    href="excluir_pedido_compra.php?codigo_pedido=<?= $codigo_pedido ?>"
                                    onclick="return confirm('Tem certeza de que deseja excluir este pedido?')" role="button">
                                    <i class="far fa-trash-alt"></i> Exc</a>
                            </td>
                        <?php } else
                                echo "Sem acesso";
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        include_once 'conexao.php';
        $sql2 = "SELECT SUM(valor_total) AS total FROM pedido_compra 
         WHERE (codigo_pedido LIKE '%$pesquisar%' 
                OR nome_fornecedor LIKE '%$pesquisar%' 
                OR responsavel_pedido LIKE '%$pesquisar%' 
                OR observacoes LIKE '%$pesquisar%' 
                OR data LIKE '%$pesquisar%') 
                AND pago = 'S'
                AND deletado = 'N'";

        $retorno2 = mysqli_query($conexao, $sql2);

        if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $total1 = $resultado['total'];
            // Exibe o resultado na tela
            echo "<b> Já Pagos: <font color='red'>R$" . $total1 . "</font></b>";
        } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
        }
        ?>
        <br>
        <?php
        include_once 'conexao.php';
        $sql2 = "SELECT SUM(valor_total) AS total FROM pedido_compra 
         WHERE (codigo_pedido LIKE '%$pesquisar%' 
                OR nome_fornecedor LIKE '%$pesquisar%' 
                OR responsavel_pedido LIKE '%$pesquisar%' 
                OR observacoes LIKE '%$pesquisar%' 
                OR data LIKE '%$pesquisar%') 
                AND pago = 'N'
                AND deletado = 'N'";

        $retorno2 = mysqli_query($conexao, $sql2);

        if ($retorno2) {
            // Extrai o resultado da consulta
            $resultado = mysqli_fetch_assoc($retorno2);
            $total2 = $resultado['total'];
            // Exibe o resultado na tela
            echo "<b> Pagamentos Pendentes: <font color='red'>R$" . $total2 . "</font></b> <br>";
        } else {
            // Se houver algum erro na consulta
            echo "Erro ao executar a consulta SQL: " . mysqli_error($conexao);
        }
        $total_valor = $total1 + $total2;
        echo "<b> Total: <font color='red'>R$" . $total_valor . "</font></b> <br>";
        ?>
    </div>
    </div>
    <?php
    if (isset($_GET['pago'])) {
        echo '<div id="alerta" class="alert alert-success" role="alert">
                Pedido <b>' . $_GET['pago'] . '</b> pago com sucesso!.
                </div>';
    }
    if (isset($_GET['estornado'])) {
        echo '<div id="alerta" class="alert alert-success" role="alert">
                Pedido <b>' . $_GET['estornado'] . '</b> Estornado com sucesso!.
                </div>';
    }
    if (isset($_GET['excluido'])) {
        echo '<div id="alerta" class="alert alert-danger" role="alert">
                Pedido <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
    }

    // Exibir a paginação somente se houver mais de uma página
    if ($totalPaginas > 1) {
        ?>
        <div class="pagination">
            <?php if ($paginaAtual > 1) { ?>
                <a class="pagination-link" href="?pagina=1&pesquisar=<?= $pesquisar ?>">Primeira</a>
                <a class="pagination-link" href="?pagina=<?= ($paginaAtual - 1) ?>&pesquisar=<?= $pesquisar ?>">Anterior</a>
            <?php } ?>
            <?php for ($i = max(1, $paginaAtual - 2); $i <= min($paginaAtual + 2, $totalPaginas); $i++) { ?>
                <a class="pagination-link <?= $paginaAtual == $i ? 'active' : '' ?>"
                    href="?pagina=<?= $i ?>&pesquisar=<?= $pesquisar ?>">
                    <?= $i ?>
                </a>
            <?php } ?>
            <?php if ($paginaAtual < $totalPaginas) { ?>
                <a class="pagination-link" href="?pagina=<?= ($paginaAtual + 1) ?>&pesquisar=<?= $pesquisar ?>">Próxima</a>
                <a class="pagination-link" href="?pagina=<?= $totalPaginas ?>&pesquisar=<?= $pesquisar ?>">Última</a>
            <?php } ?>
        </div>
    <?php } ?>
    </div>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function () {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>

</body>

</html>