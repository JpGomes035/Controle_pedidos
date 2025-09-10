<?php
include_once 'iniciar_sessao.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lista fornecedores</title>
</head>

<style>
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

    p {
        font-size: 16px;
        line-height: 1.6;
    }

    th,
    tr,
    td {
        text-align: center;
        font-weight: bold;
        border: 1px solid #ddd;
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
</style>
<?php include_once 'head.php' ?>

<body>
    <?php include_once('menu.php'); ?>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:30px">Lista de Fornecedores</h3>
        <h6><b>Clique no número para abrir o whatsapp no fornecedor. (precisa estar logado no web whatsapp) e no
                Email para abrir opções de contato no email</h6></b>
        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar por nome, CNPJ, email ou Telefone" name="pesquisar" value="<?= isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>

                    <th scope="col">ID</th>
                    <th scope="col">Fornecedor</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Cep</th>
                    <th scope="col">Email</th>
                    <th scope="col">Cod_Forn</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'conexao.php';

                // Filtro de pesquisa
                $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

                // Consulta SQL com filtro de pesquisa
                $sql = "SELECT IdFornecedor, nomeForn, cnpjForn, telefoneForn, cepForn, emailForn, cod_Forn FROM `fornecedor` WHERE nomeForn LIKE '%$pesquisar%' OR cnpjForn LIKE '%$pesquisar%' OR emailForn LIKE '%$pesquisar%' OR telefoneForn LIKE '%$pesquisar%'";


                // Paginação
                $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                $itensPorPagina = 10;
                $inicio = ($paginaAtual - 1) * $itensPorPagina;

                $sql .= " LIMIT $inicio, $itensPorPagina";

                $retorno = mysqli_query($conexao, $sql);

                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $IdFornecedor = $array['IdFornecedor'];
                    $nomeForn = $array['nomeForn'];
                    $cnpjForn = $array['cnpjForn'];
                    $telefoneForn = $array['telefoneForn'];
                    $cepForn = $array['cepForn'];
                    $emailForn = $array['emailForn'];
                    $cod_Forn = $array['cod_Forn'];

                ?>
                    <tr>
                        <?php
                        $sqlmensagem = "SELECT idMensagem, mensagem FROM `mensagem` ORDER BY idMensagem DESC LIMIT 1";
                        $retornomensagem = mysqli_query($conexao, $sqlmensagem);
                        ?>

                        <td><?= $IdFornecedor ?></td>
                        <td><?= $nomeForn ?></td>
                        <td><?= $cnpjForn ?></td>
                        <?php
                        $mensagem = ""; // Define a variável $mensagem com um valor vazio inicialmente
                        if ($row = mysqli_fetch_assoc($retornomensagem)) {
                            $mensagem = $row['mensagem']; // Atribui o valor da coluna 'mensagem' ao $mensagem se existir um resultado da consulta
                        }
                        ?>
                        <td><a href="https://web.whatsapp.com/send?phone=<?= $telefoneForn ?>&text=<?= $mensagem ?>" target="_blank" style="color: blue;"><?= $telefoneForn ?></a></td>
                        <td><?= $cepForn ?></td>
                        <td>
                            <a href="email/index.php?emailForn=<?= $emailForn ?>">
                                <?= $emailForn ?>
                            </a>
                        </td>
                        <td><?= $cod_Forn ?></td>
                        <td>
                            <a class="btn-editar btn btn-sm btn-warning" href="editar_fornecedor.php?id=<?= $IdFornecedor ?>" role="button"><i class="far fa-edit"></i> Editar</a>
                            <a class="btn-editar btn btn-sm btn-danger" href="excluir_fornecedor.php?id=<?= $IdFornecedor ?>" role="button"><i class="far fa-trash-alt"></i> Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        // Paginação - Contagem total de registros
        $sqlContagem = "SELECT COUNT(*) AS total FROM `fornecedor` WHERE nomeForn LIKE '%$pesquisar%'";

        $retornoContagem = mysqli_query($conexao, $sqlContagem);
        $arrayContagem = mysqli_fetch_assoc($retornoContagem);
        $totalRegistros = $arrayContagem['total'];

        // Cálculo da quantidade de páginas
        $quantidadePaginas = ceil($totalRegistros / $itensPorPagina);

        // Exibição dos links de paginação
        echo '<nav aria-label="Paginação" style="margin-top: 20px;">
                <ul class="pagination justify-content-center">';

        for ($i = 1; $i <= $quantidadePaginas; $i++) {
            $active = ($i == $paginaAtual) ? 'active' : '';

            echo '<li class="page-item ' . $active . '">
                    <a class="page-link" href="?pagina=' . $i . '&pesquisar=' . $pesquisar . '">' . $i . '</a>
                  </li>';
        }

        echo '</ul>
              </nav>';
        ?>

        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                Fornecedor <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Fornecedor <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        ?>

        <a href="cep_forn.php" class="btn-enviar btn btn-success btn-sm btn-block">Consultar CEP</a>
        <a href="https://solucoes.receita.fazenda.gov.br/servicos/cnpjreva/cnpjreva_solicitacao.asp" class="btn-enviar btn btn-success btn-sm btn-block" target="_blank">Consultar CNPJ</a>
        <a href="cadastrar_fornecedor.php" class="btn-enviar btn btn-success btn-sm btn-block">Voltar para o Cadastro</a>
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