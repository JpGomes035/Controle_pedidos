<?php 
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Listar Setores</title>
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
    </style>
</head>

<body>
    <?php include_once('menu.php'); ?>
    <div class="container">
        <h3 style="margin-bottom:30px">Lista de Setores</h3>

        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar por nome" name="pesquisar"
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
        $sql = "SELECT idSetor, NomeSetor FROM `setor` WHERE NomeSetor LIKE '%$pesquisar%' LIMIT $offset, $registrosPorPagina";
        $retorno = mysqli_query($conexao, $sql);

        $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT idSetor FROM `setor` WHERE NomeSetor LIKE '%$pesquisar%'"));
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        ?>

        <table class="table">
            <thead>
                <tr>

                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $idSetor = $array['idSetor'];
                    $NomeSetor = $array['NomeSetor'];
                    ?>
                    <tr>

                        <td>
                            <?= $idSetor ?>
                        </td>
                        <td>
                            <?= $NomeSetor ?>
                        </td>
                        <td>
                            <a class="btn-editar btn btn-sm btn-danger" href="excluir_setor.php?id=<?= $idSetor ?>"
                                role="button"><i class="far fa-trash-alt"></i> Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
    if (isset($_GET['atualizado'])) {
        echo '<div id="alerta" class="alert alert-success" role="alert">
                Categoria <b>' . $_GET['atualizado'] . '</b> atualizada com sucesso!.
                </div>';
    }
    if (isset($_GET['excluido'])) {
        echo '<div id="alerta" class="alert alert-danger" role="alert">
                Categoria <b>' . $_GET['excluido'] . '</b> excluída com sucesso!.
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
    <?php include_once 'footer.php' ?>
</body>

</html>