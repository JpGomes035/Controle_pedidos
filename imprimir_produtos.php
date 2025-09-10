<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';

include_once 'conexao.php';

// Configurações de paginação
$registrosPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Consulta SQL padrão sem filtro de pesquisa
$sql = "SELECT IdProduto, Categoria, Fornecedor, Nome, Numero, Quantidade, precovenda FROM `estoque` WHERE deletado = 'n'";

// Verifica se foi enviado um termo de pesquisa
if (isset($_GET['termo'])) {
    $termo = $_GET['termo'];

    // Adiciona a cláusula AND à consulta SQL para buscar produtos que correspondam ao termo de pesquisa
    $sql .= " AND (Nome LIKE '%$termo%' OR Categoria LIKE '%$termo%' OR Fornecedor LIKE '%$termo%' OR Numero LIKE '%$termo%')";
}

// Adiciona a cláusula LIMIT e OFFSET à consulta SQL
$sql .= " LIMIT $registrosPorPagina OFFSET $offset";

$retorno = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="print_produtos.css" media="print">
<title>Gerar relatório</title>

<head>
    <style>
        .chart {
            width: 300px;
            height: 60px;
            border: 1px solid #ccc;
            margin: 20px;
            padding: 10px;
            display: flex;
            align-items: center;
            position: relative;
        }

        th,
        tr,
        td {
            text-align: center;
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
            font-weight: bold;
            color: #333;
        }

        th,
        td {
            text-align: center;
            font-weight: bold;
            border-width: 2px;
            border-style: solid;
            border-color: black;
        }

        body {
            background: linear-gradient(to bottom, #b3e0e0, #d9d9d9);
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

        h1 {
            font-size: 24px;
        }

        a {
            color: red;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: black;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        h3 {
            text-align: center;
            color: red;
        }
    </style>
</head>

<body>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:30px">Relatório de Produtos:</h3>
        <form action="imprimir_produtos.php" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="termo" class="form-control"
                    placeholder="Pesquise por Nome do Produto, Categoria, Fornecedor ou Nº Produto.">

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>

            </div>
            <br>
            <h7>caso em pdf, use microsoft print to pdf</h7>
        </form>
        <table class="table">
            <div class="print-content">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Nº Produto</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Fornecedor</th>
                        <th scope="col">Preço venda</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                        $idProduto = $array['IdProduto'];
                        $categoria = $array['Categoria'];
                        $fornecedor = $array['Fornecedor'];
                        $nome = $array['Nome'];
                        $numero = $array['Numero'];
                        $quantidade = $array['Quantidade'];
                        $precovenda = $array['precovenda'];
                        ?>
                        <tr>
                            <td><?= $idProduto ?></td>
                            <td><?= $nome ?></a></td>
                            <td><?= $numero ?></td>
                            <td><?= $categoria ?></td>
                            <td><?= $quantidade ?></td>
                            <td><?= $fornecedor ?></td>
                            <td>R$<?= $precovenda ?></td>
                        <?php } ?>

                </tbody>
        </table>

        <?php
        // Consulta SQL para contar o total de registros
        $sqlTotalRegistros = "SELECT COUNT(*) AS total FROM `estoque`";
        $resultadoTotalRegistros = mysqli_query($conexao, $sqlTotalRegistros);
        $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];

        // Calcula o total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        // Exibe a paginação
        echo '<ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo '<li class="page-item ' . ($paginaAtual == $i ? 'active' : '') . '">';
            echo '<a class="page-link" href="?pagina=' . $i . '">' . $i . '</a>';
            echo '</li>';
        }
        echo '</ul>';
        ?>

        <button class="btn btn-primary imprimir-lista" onclick="imprimirProdutos()">Imprimir Lista</button>
        <a href="relatorios.php" class="btn btn-primary">Voltar</a>



        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                    Produto <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                    Produto <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        if (isset($_GET['cadastrado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                    Produto cadastrado com sucesso!.
                </div>';
        }
        ?>
    </div>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function () {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);

        function imprimirProdutos() {
            window.print();
        }
    </script>
</body>

</html>