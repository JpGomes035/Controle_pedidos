<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';

// Configurações de paginação
$registrosPorPagina = 20;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

$sql = "SELECT IdProduto, Categoria, descProd, Fornecedor, Nome, Numero, Quantidade, precovenda, img_prod, catalogo, promocao FROM `estoque` WHERE deletado = 'N'";

// Consulta SQL para contar o total de registros (fora da pesquisa)
$sqlTotalRegistrosForaPesquisa = "SELECT COUNT(*) AS total FROM `estoque` WHERE deletado = 'N'";
$resultadoTotalRegistrosForaPesquisa = mysqli_query($conexao, $sqlTotalRegistrosForaPesquisa);
$totalRegistrosForaPesquisa = mysqli_fetch_assoc($resultadoTotalRegistrosForaPesquisa)['total'];

// Verifica se foi enviado um termo de pesquisa
if (isset($_GET['termo'])) {
    $termo = $_GET['termo'];

    // Adiciona a cláusula WHERE à consulta SQL para buscar produtos que correspondam ao termo de pesquisa
    $sql .= " AND (Nome LIKE '%$termo%' OR Categoria LIKE '%$termo%' OR Fornecedor LIKE '%$termo%' OR Numero LIKE '%$termo%' OR descProd LIKE '%$termo%')";

    // Consulta SQL para contar o total de registros (dentro da pesquisa)
    $sqlTotalRegistrosDentroPesquisa = "SELECT COUNT(*) AS total FROM `estoque` WHERE deletado = 'N' AND (Nome LIKE '%$termo%' OR Categoria LIKE '%$termo%' OR Fornecedor LIKE '%$termo%' OR Numero LIKE '%$termo%' OR descProd LIKE '%$termo%')";
    $resultadoTotalRegistrosDentroPesquisa = mysqli_query($conexao, $sqlTotalRegistrosDentroPesquisa);
    $totalRegistrosDentroPesquisa = mysqli_fetch_assoc($resultadoTotalRegistrosDentroPesquisa)['total'];
} else {
    // Se não houver termo de pesquisa, o total de registros dentro da pesquisa será igual ao total de registros fora da pesquisa
    $totalRegistrosDentroPesquisa = $totalRegistrosForaPesquisa;
}

// Adiciona a cláusula LIMIT e OFFSET à consulta SQL
$sql .= " LIMIT $registrosPorPagina OFFSET $offset";

$retorno = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="print_produtos.css" media="print">
<title>Lista de Produtos</title>

<head>
    <!-- Estilos CSS -->
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
            border: 1px solid #ddd;
            font-weight: bold;
        }

        th {
            background-color: grey;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
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

        h7 {
            font-weight: bold;
        }
    </style>
</head>

<body>

    </script>
    <?php include_once 'menu.php'; ?>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:30px">Lista de Produtos</h3>
        <h7>Clique no nome do produto em vermelho para mais informações, clicando no ID abre a imagem do produto. Caso não tenha foto, vai abrir uma tela em branco.</h7>
        <br>
        <!-- Formulário de pesquisa -->
        <form action="listar_produtos.php" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="termo" class="form-control" placeholder="Pesquise por Nome do Produto, Categoria, Descrição, Fornecedor ou Nº Produto.">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <!-- Tabela de produtos -->
        <table class="table">
            <!-- Cabeçalho da tabela -->
            <thead>
                <!-- Colunas do cabeçalho -->
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Nº Produto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Fornecedor</th>
                    <th scope="col">Preço venda</th>
                    <th scope="col" class="acoes">Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Corpo da tabela (conteúdo dinâmico) -->
                <?php
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $idProduto = $array['IdProduto'];
                    $categoria = $array['Categoria'];
                    $fornecedor = $array['Fornecedor'];
                    $nome = $array['Nome'];
                    $numero = $array['Numero'];
                    $quantidade = $array['Quantidade'];
                    $descricao = $array['descProd'];
                    $precovenda = $array['precovenda'];
                    $img_prod = $array['img_prod'];
                    $catalogo = $array['catalogo'];
                    $promocao = $array['promocao'];
                ?>
                    <tr>
                        <td><a href="#" onclick="window.open('<?= $img_prod ?>', '_blank')"><?= $idProduto ?></a></td>
                        <td><a class="print-link print-only" href="info_prod.php?id=<?= $idProduto ?>"><?= $nome ?></a></td>
                        <td><?= $numero ?></td>
                        <td><?= $categoria ?></td>
                        <td><?= $quantidade ?></td>
                        <td><?= $fornecedor ?></td>
                        <td>R$ <?= $precovenda ?></td>
                        <td>
                            <?php if (($nivel == 1) || ($nivel == 2)) { ?>
                                <a class="btn-editar btn btn-sm btn-warning" href="editar_produto.php?id=<?= $idProduto ?>" role="button"><i class="far fa-edit"></i> Editar</a>
                            <?php } ?>
                            <?php if ($nivel == 1) { ?>
                                <a class="btn-editar btn btn-sm btn-danger" href="excluir_produto.php?id=<?= $idProduto ?>" role="button"><i class="far fa-trash-alt"></i> Excluir</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
            function enviarWhatsApp(nome, preco, descricao, urlImagem, telefone) {
                const mensagem = encodeURIComponent(
                    `Olá! Confira nosso produto:\n\n` +
                    `Nome: ${nome}\n` +
                    `Preço: ${preco}\n` +
                    `Descrição: ${descricao}\n\n` +
                    `Veja a imagem: ${urlImagem}\n\n` +
                    `Para mais informações, entre em contato!`
                );

                const urlWhatsApp = `https://web.whatsapp.com/send?phone=${telefone}&text=${mensagem}`;
                window.open(urlWhatsApp, '_blank');
            }
        </script>
        <!-- Total de registros dentro da pesquisa -->
        <h7>Total de registros: <?= $totalRegistrosDentroPesquisa ?></h7>
        <br>
        <h7>CTAL = Catálogo</h7>
        <br>
        <h7>Promo = Promoção</h7>
        <!-- Paginação -->
        <ul class="pagination justify-content-center">
            <?php
            // Calcula o total de páginas
            $totalPaginas = ceil($totalRegistrosForaPesquisa / $registrosPorPagina);

            // Exibe a paginação
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo '<li class="page-item ' . ($paginaAtual == $i ? 'active' : '') . '">';
                echo '<a class="page-link" href="?pagina=' . $i . '">' . $i . '</a>';
                echo '</li>';
            }
            ?>
        </ul>
        <!-- Mensagens de alerta -->
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

    <!-- Script -->
    <script>
        setTimeout(function() {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);

        function imprimirProdutos() {
            window.print();
        }
    </script>
    <!-- Footer -->
    <?php include_once 'footer.php' ?>
</body>

</html>