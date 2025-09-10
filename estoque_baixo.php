<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Sugestão de compra</title>
    <link rel="stylesheet" href="estoque_baixo.css">
</head>

<body>
    <?php include_once('menu.php'); ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <h3 style="margin-bottom:10px">Sugestão de compra de acordo com o estoque:</h3>
        <h6 style="margin-bottom:20px"> Use <b>PONTO .</b> para o campo de valor.</h6>
        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Faça aqui a busca pelo nome do produto"
                    name="pesquisar" value="<?= isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </div>
        </form>

        <form method="POST" action="criar_pedido.php" id="formPedido">
            <?php
            include_once 'conexao.php';

            // Obter o nome do usuário logado
            $usuarioLogado = $_SESSION['usuario']; // Supondo que o ID do usuário esteja armazenado na sessão
            $nomeUser = '';

            $sqlUser = "SELECT Nome FROM usuario WHERE IdUsuario = $usuarioLogado AND Status = 'Ativo'";
            $retornoUser = mysqli_query($conexao, $sqlUser);

            if (mysqli_num_rows($retornoUser) > 0) {
                $rowUser = mysqli_fetch_assoc($retornoUser);
                $nomeUser = $rowUser["Nome"];
            }

            // Configuração da paginação
            $registrosPorPagina = 15;
            $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $offset = ($paginaAtual - 1) * $registrosPorPagina;

            // Filtro de pesquisa
            $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

            // Consulta SQL com filtro de pesquisa
            $sql = "SELECT IdProduto, Numero, Nome, precovenda, Quantidade, Categoria, Fornecedor, qntVendas 
                    FROM `estoque` 
                    WHERE Quantidade < '3' 
                    AND Nome LIKE '%$pesquisar%' 
                    AND deletado = 'N' 
                    LIMIT $offset, $registrosPorPagina";

            $retorno = mysqli_query($conexao, $sql);
            if (!$retorno) {
                echo "Erro na consulta: " . mysqli_error($conexao);
            }

            $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT IdProduto FROM `estoque` WHERE Quantidade < '3' AND Nome LIKE '%$pesquisar%' AND deletado = 'N'"));
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Selecionar</th>
                        <th scope="col">ID</th>
                        <th scope="col">Numero</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Ultimo Fornecedor</th>
                        <th scope="col">Qnt_Vendas</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (mysqli_num_rows($retorno) === 0) {
                        echo "<tr><td colspan='10'>Nenhum produto para realizar a sugestão de compra <i class='fa fa-exclamation' aria-hidden='true'></i> </td></tr>";
                    } else {
                        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                            $IdProduto = $array['IdProduto'];
                            $Numero = $array['Numero'];
                            $Nome = $array['Nome'];
                            $precovenda = $array['precovenda'];
                            $Quantidade = $array['Quantidade'];
                            $Categoria = $array['Categoria'];
                            $Fornecedor = $array['Fornecedor'];
                            $qntVendas = $array['qntVendas'];
                    ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="produtos[]" value="<?= $IdProduto ?>">
                                    <br>
                                    <input type="hidden" name="nome_fornecedor" value="Fornecedor">
                                    <input type="hidden" name="responsavel_pedido" value="<?= $nomeUser ?>">
                                    <input type="hidden" name="observacoes" value="Observações do pedido">
                                    <input type="hidden" name="data" value="<?= date('Y-m-d') ?>">
                                    quantidade: <input type="number" name="quantidades[]" placeholder="quantidade" value="1">
                                    <br>
                                    Valor unitario: <input type="text" name="valor_unitario[]" value="10.00">
                                    <br>
                                    Valor total: <input type="text" name="valor_total[]" value="10.00">

                                </td>
                                <td>
                                    <a href="editar_produto.php?id=<?= $IdProduto ?>">
                                        <?= $IdProduto ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $Numero ?>
                                </td>
                                <td>
                                    <?= $Nome ?>
                                </td>
                                <td>R$
                                    <?= $precovenda ?>
                                </td>
                                <td>
                                    <?= $Quantidade ?>
                                </td>
                                <td>
                                    <?= $Categoria ?>
                                </td>
                                <td>
                                    <?= $Fornecedor ?>
                                </td>
                                <td>
                                    <?= $qntVendas == 0 ? 'No registry' : $qntVendas ?>
                                </td>

                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Criar pedido com esses produtos</button>
        </form>
        <script>
            document.getElementById('formPedido').addEventListener('submit', function(event) {
                var checkboxes = document.querySelectorAll('input[name="produtos[]"]:checked');
                if (checkboxes.length === 0) {
                    alert('Por favor, selecione pelo menos um produto.');
                    event.preventDefault(); // Impede o envio do formulário
                }
            });
        </script>
        <br>
        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                Categoria <b>' . $_GET['atualizado'] . '</b> atualizada com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Pedido <b>' . $_GET['excluido'] . '</b> deletado com sucesso!.
                </div>';
        }
        ?>

        <a href="lista_pedido_compras.php">Voltar</a>
    </div>
    <?php
    $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT IdProduto FROM `estoque` WHERE Nome LIKE '%$pesquisar%' AND deletado = 'N'"));
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

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
        setTimeout(function() {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>

    <?php include_once 'footer.php' ?>
</body>

</html>