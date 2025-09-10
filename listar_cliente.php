<?php
include_once 'iniciar_sessao.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        th {
            text-align: center;
        }

        a {
            color: black;
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

        h3,
        h6 {
            font-weight: bold;
            color: black;
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
</head>
<title>Lista de Clientes</title>
<?php include_once 'head.php' ?>

<body>
    <?php include_once('menu.php'); ?>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:18px">Lista de Clientes</h3>
        <h6><b>Clique no número para abrir o whatsapp no contato do cliente (Precisa estar logado no web whatsapp) e no
                Email para entrar em contato.</h6></b>
        <form action="listar_cliente.php" method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquise o nome do cliente, CPF, CEP, email ou pesquise em branco para listar todos">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Cep</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'conexao.php';

                // Pagination variables
                $registrosPorPagina = 10; // Number of records per page
                $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Get current page, default is 1
                $offset = ($paginaAtual - 1) * $registrosPorPagina; // Offset for SQL query

                // Search variable
                $pesquisar = isset($_POST['pesquisar']) ? $_POST['pesquisar'] : '';

                // Construct the SQL query
                $sql = "SELECT idCliente, nomeCliente, numeroCliente, emailCliente, cepCliente, cpfCliente FROM `cliente`";
                if (!empty($pesquisar)) {
                    $sql .= " WHERE nomeCliente LIKE '%$pesquisar%'  OR cpfCliente LIKE '%$pesquisar%' OR emailCliente LIKE '%$pesquisar%' OR cepCliente LIKE '%$pesquisar%'";
                }
                $sql .= " LIMIT $offset, $registrosPorPagina";

                $retorno = mysqli_query($conexao, $sql);

                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $idCliente = $array['idCliente'];
                    $nomeCliente = $array['nomeCliente'];
                    $numeroCliente = $array['numeroCliente'];
                    $emailCliente = $array['emailCliente'];
                    $cepCliente = $array['cepCliente'];
                    $cpfCliente = $array['cpfCliente'];
                ?>
                    <tr>
                        <?php
                        $sqlmensagem = "SELECT idMensagem, mensagem FROM `mensagem` ORDER BY idMensagem DESC LIMIT 1";
                        $retornomensagem = mysqli_query($conexao, $sqlmensagem);
                        ?>

                        <td><a href="info_client.php?idCliente=<?= $idCliente ?>">
                                <?php echo $idCliente; ?>
                            </a></td>
                        <td>
                            <?= $nomeCliente ?>
                        </td>
                        <?php
                        $mensagem = ""; // Define a variável $mensagem com um valor vazio inicialmente
                        if ($row = mysqli_fetch_assoc($retornomensagem)) {
                            $mensagem = $row['mensagem']; // Atribui o valor da coluna 'mensagem' ao $mensagem se existir um resultado da consulta
                        }
                        ?>
                        <td><a href="https://web.whatsapp.com/send?phone=<?= $numeroCliente ?>&text=<?= $mensagem ?>" target="_blank" style="color: blue;">
                                <?= $numeroCliente ?>
                            </a></td>
                        <td>
                            <a href="email/index.php?emailCliente=<?= $emailCliente ?>">
                                <?= $emailCliente ?>
                            </a>
                        </td>
                        <td>
                            <?= $cepCliente ?>
                        </td>
                        <td>
                            <?= $cpfCliente ?>
                        </td>
                        <td>
                            <a class="btn-editar btn btn-sm btn-warning" href="editar_cliente.php?id=<?= $idCliente ?>" role="button"><i class="far fa-edit"></i> Editar</a>
                            <a class="btn-editar btn btn-sm btn-danger" href="excluir_cliente.php?id=<?= $idCliente ?>" role="button"><i class="far fa-trash-alt"></i> Excluir</a>
                        </td>

                    </tr>
                <?php } ?>

            </tbody>
        </table>

        <?php
        // Pagination
        $sqlCount = "SELECT COUNT(*) AS total FROM `cliente`";
        if (!empty($pesquisar)) {
            $sqlCount .= " WHERE nomeCliente LIKE '%$pesquisar%'";
        }
        $countResult = mysqli_query($conexao, $sqlCount);
        $rowCount = mysqli_fetch_assoc($countResult)['total'];
        $totalPages = ceil($rowCount / $registrosPorPagina);
        ?>

        <nav aria-label="Paginação">
            <ul class="pagination">
                <?php if ($paginaAtual > 1) { ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>&pesquisar=<?= $pesquisar ?>">Anterior</a></li>
                <?php } ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>"><a class="page-link" href="?pagina=<?= $i ?>&pesquisar=<?= $pesquisar ?>">
                            <?= $i ?>
                        </a></li>
                <?php } ?>

                <?php if ($paginaAtual < $totalPages) { ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>&pesquisar=<?= $pesquisar ?>">Próxima</a></li>
                <?php } ?>
            </ul>
        </nav>

        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                Cliente <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Cliente <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        ?>
        <a href="cep.php" class="btn-enviar btn btn-success btn-sm btn-block">Consultar CEP</a>
        <a href="https://solucoes.receita.fazenda.gov.br/servicos/cnpjreva/cnpjreva_solicitacao.asp" class="btn-enviar btn btn-success btn-sm btn-block" target="_blank">Consultar CNPJ</a>
        <a href="cadastrar_cliente.php" class="btn-enviar btn btn-success btn-sm btn-block">Voltar para o Cadastro</a>
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