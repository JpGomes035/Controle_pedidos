<?php
include_once 'iniciar_sessao.php';
include_once 'head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Listagem de banco</title>
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

    h1 {
        font-size: 24px;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        font-weight: bold;
    }
    th,tr,td{
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
        .dark-mode p{
            color: whitesmoke;
            font-weight: bold;
        }
</style>
</head>
<body>
<?php include_once('menu.php'); ?>
    <div style="padding:20px 0" class="container">
        <h3 style="margin-bottom:30px">Lista de banco</h3>
        <p>Valor total é somado ou subtraído de acordo com os pedidos de compra/venda.</p>
        <form method="GET" action="" style="margin-bottom: 20px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar por nome" name="pesquisar" value="<?= isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '' ?>">
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
        $sql = "SELECT idBanco, nomeBanco, agencia, cc, valor_banco FROM `banco` WHERE nomeBanco LIKE '%$pesquisar%' OR agencia LIKE '%$pesquisar%' OR cc LIKE '%$pesquisar%' LIMIT $offset, $registrosPorPagina";
        $retorno = mysqli_query($conexao, $sql);

        $totalRegistros = mysqli_num_rows(mysqli_query($conexao, "SELECT idBanco FROM `banco` WHERE nomeBanco LIKE '%$pesquisar%'"));
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        if ($totalPaginas > 1) {
            echo '<div class="pagination">';
            echo '<ul class="pagination-list">';
            if ($paginaAtual > 1) {
                echo '<li class="pagination-item"><a class="pagination-link" href="?pagina=' . ($paginaAtual - 1) . '&pesquisar=' . $pesquisar . '">Anterior</a></li>';
            }
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo '<li class="pagination-item"><a class="pagination-link' . ($paginaAtual == $i ? ' active' : '') . '" href="?pagina=' . $i . '&pesquisar=' . $pesquisar . '">' . $i . '</a></li>';
            }
            if ($paginaAtual < $totalPaginas) {
                echo '<li class="pagination-item"><a class="pagination-link" href="?pagina=' . ($paginaAtual + 1) . '&pesquisar=' . $pesquisar . '">Próxima</a></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

        <table class="table">
            <thead>
                <tr>
                    
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Agencia</th>
                    <th scope="col">C/C</th>
                    <th scope="col">Total</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
                    $idBanco = $array['idBanco'];
                    $nomeBanco = $array['nomeBanco'];
                    $agencia= $array['agencia'];
                    $cc = $array['cc'];
                    $valor_banco = $array['valor_banco'];
                ?>
                    <tr>
                    
                        <td><?= $idBanco ?></td>
                        <td><?= $nomeBanco ?></td>
                        <td><?= $agencia ?></td>
                        <td><?= $cc ?></td>
                        <td><?= $valor_banco ?></td>
                        <td>
                        <?php
            if ($nivel == 1){
                            ?>
                       <a class="btn-editar btn btn-sm btn-warning" href="editar_banco.php?id=<?= $idBanco ?>"
                                role="button"><i class="far fa-edit"></i> Editar</a>
                            <a class="btn-editar btn btn-sm btn-danger" href="excluir_banco.php?id=<?= $idBanco ?>"
                                role="button"><i class="far fa-trash-alt"></i> Excluir</a>
                        </td>
                        <?php }
                        ?> 
                        <?php if ($nivel == 2){
                        ?>
                         <b>Sem permissão para editar\deletar, favor verificar.<b>
                        <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        if (isset($_GET['atualizado'])) {
            echo '<div id="alerta" class="alert alert-success" role="alert">
                Banco <b>' . $_GET['atualizado'] . '</b> atualizado com sucesso!.
                </div>';
        }
        if (isset($_GET['excluido'])) {
            echo '<div id="alerta" class="alert alert-danger" role="alert">
                Banco <b>' . $_GET['excluido'] . '</b> excluído com sucesso!.
                </div>';
        }
        ?>
    </div>
    <script>
        // Código para fechar o alerta automaticamente após 5 segundos
        setTimeout(function(){
            document.getElementById('alerta').style.display = 'none';
        }, 5000);
    </script>
    <?php include_once 'footer.php'?>
</body>

</html>
