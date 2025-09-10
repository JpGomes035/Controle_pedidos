<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lista usuários</title>
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

    h3 {
        text-align: center;
    }

    h6 {
        text-align: center;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
    }

    th,
    tr,
    td {
        text-align: center;
        border: 1px solid #ddd;
        font-weight: bold;
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
        <h3 style="margin-bottom:30px">Lista de Usuários</h3>

        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar por nome, sobrenome, email e CPF" name="pesquisar" value="<?= isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Função</th>
                    <th scope="col">Status</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'conexao.php';

                // Filtro de pesquisa
                $pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

                // Consulta SQL com filtro de pesquisa
                $sql = "SELECT IdUsuario, Nome, Sobrenome, Email, NivelUsuario, telefoneUsuario, cpfUsuario, status FROM `usuario` WHERE Nome LIKE '%$pesquisar%' OR Sobrenome LIKE '%$pesquisar%' OR Email LIKE '%$pesquisar%' OR cpfUsuario LIKE '%$pesquisar%'";


                // Paginação
                $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                $itensPorPagina = 10;
                $inicio = ($paginaAtual - 1) * $itensPorPagina;

                $sql .= " LIMIT $inicio, $itensPorPagina";

                $retorno = mysqli_query($conexao, $sql);

                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $IdUsuario = $array['IdUsuario'];
                    $Nome = $array['Nome'];
                    $Sobrenome = $array['Sobrenome'];
                    $Email = $array['Email'];
                    $NivelUsuario = $array['NivelUsuario'];
                    $telefoneUsuario = $array['telefoneUsuario'];
                    $cpfUsuario = $array['cpfUsuario'];
                    $status = $array['status'];
                ?>
                    <tr>
                        <?php
                        $sqlmensagem = "SELECT idMensagem, mensagem FROM `mensagem` ORDER BY idMensagem DESC LIMIT 1";
                        $retornomensagem = mysqli_query($conexao, $sqlmensagem);
                        ?>

                        <td>
                            <?= $IdUsuario ?>
                        </td>
                        <td>
                            <?= $Nome ?>
                        </td>
                        <td>
                            <?= $Email ?>
                        </td>
                        <td>
                            <?= $NivelUsuario ?>
                        </td>
                        <td>
                            <?= $status ?>
                        </td>
                        <?php
                        $mensagem = ""; // Define a variável $mensagem com um valor vazio inicialmente
                        if ($row = mysqli_fetch_assoc($retornomensagem)) {
                            $mensagem = $row['mensagem']; // Atribui o valor da coluna 'mensagem' ao $mensagem se existir um resultado da consulta
                        }
                        ?>
                        <td><a href="https://web.whatsapp.com/send?phone=<?= $telefoneUsuario ?>&text=<?= $mensagem ?>" target="_blank" style="color: red;">
                                <?= $telefoneUsuario ?>
                            </a></td>
                        <td>
                            <?= $cpfUsuario ?>
                        </td>
                        <td>
                            <?php if (($nivel == 1)) { ?>
                                <a class="btn-editar btn btn-sm btn-warning" href="editar_usuario.php?IdUsuario=<?= $IdUsuario ?>" role="button"><i class="far fa-edit"></i> Editar</a>
                                <a class="btn-editar btn btn-sm btn-danger" href="excluir_usuario.php?IdUsuario=<?= $IdUsuario ?>" role="button"><i class="far fa-trash-alt"></i> Excluir</a>

                        </td>
                    <?php } ?>
                    <?php if ($nivel == 2) {
                    ?>
                        <b>Sem acesso.</b>
                    <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        // Paginação - Contagem total de registros
        $sqlContagem = "SELECT COUNT(*) AS total FROM `usuario` WHERE nome LIKE '%$pesquisar%'";

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
                Usuário <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Usuário <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        ?>
    </div>
    <h6 style="color: black;"><b>Função = 1 é Administrador (Acesso total). <br>Função = 2 é Funcionário (Permissões
            reduzidas).</h6></b>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function() {
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>
    <?php include_once 'footer.php' ?>
</body>

</html>