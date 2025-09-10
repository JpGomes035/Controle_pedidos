<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$codigo_pedido = $_GET['codigo_pedido'];

?>
<style>
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
        font-weight: bold;
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
    }

    p {
        font-size: 16px;
        font-weight: bold;
        line-height: 1.6;
    }
</style>
<title>Recebimento</title>
<?php include_once('menu.php'); ?>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Informações Sobre o Recebimento:</h4>
    <form action="atualizar_info_recebimento.php" method="POST">
        <?php
        $sql = "SELECT * FROM pedidos WHERE codigo_pedido = $codigo_pedido";
        $retorno = mysqli_query($conexao, $sql);

        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $codigo_pedido = $array['codigo_pedido'];
            $fm_pag = $array['fm_pag'];
            $valor_total = $array['valor_total'];
            $banco_receb = $array['banco_receb'];
            $responsavel_pedido = $array['responsavel_pedido'];
            $observacoes = $array['observacoes'];
            ?>
            <input style="display:none" id="codigo_pedido" name="codigo_pedido" value="<?= $codigo_pedido ?>">
            <div class="form-group">
                <label for="Cod_pedido">Codigo do Pedido</label>
                <input type="text" class="form-control" id="codigo_pedido" name="codigo_pedido" placeholder="Cod_pedido"
                    readonly autocomplete="off" value="<?= $codigo_pedido ?> ">
            </div>
            <div class="form-group">
                <label for="Cod_pedido">Responsável: (Não permitido editar)</label>
                <input type="text" class="form-control" id="responsavel_pedido" name="responsavel_pedido" placeholder="Responsavel pelo Pedido"
                 autocomplete="off" value="<?= $responsavel_pedido ?> " readonly>
            </div>
            <div class="form-group">
                <label for="valor_total">Valor Total:</label>
                <input type="text" id="valor_total" class="form-control" name="valor_total" step="0.01"
                    value="<?= $valor_total ?> " required>
                <br>
                <textarea id="observacoes" name="observacoes" rows="4" cols="100"><?= $observacoes ?></textarea>
                <div class="form-group">
                    <label for="fm_pag">Forma de Pagamento: </label>
                    <select class="form-control" id="fm_pag" name="fm_pag" <?= $fm_pag ?>>
                        <?php
                        $sqlnome = "SELECT * FROM fm_pag WHERE deletado = 'N'";
                        $retornonome = mysqli_query($conexao, $sqlnome);
                        while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                            $id_fmpag = $array["id_fmpag"];
                            $nome_fmpag = $array["nome_fmpag"];
                            // Verifica se o valor de $fm_pag é igual ao nome_fmpag para marcar como selecionado
                            $selected = ($nome_fmpag == $fm_pag) ? 'selected="selected"' : '';
                        ?>
                            <option value="<?= $nome_fmpag ?>" <?= $selected ?>><?= $nome_fmpag ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="banco_receb">Qual o banco responsavel?</label>
                    <select class="form-control" id="banco_receb" name="banco_receb" <?= $banco_receb ?>>
                        <?php
                        $sqlnome = "SELECT * FROM banco ORDER BY nomeBanco ASC";
                        $retornonome = mysqli_query($conexao, $sqlnome);
                        while ($array = mysqli_fetch_array($retornonome, MYSQLI_ASSOC)) {
                            $idBanco = $array["idBanco"];
                            $nomeBanco = $array["nomeBanco"];
                            $selected = ($nomeBanco == $banco_receb) ? 'selected="selected"' : '';
                        ?>
                           <option value="<?= $nomeBanco ?>" <?= $selected ?>><?= $nomeBanco ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar/Voltar</button>
            <?php } ?>
    </form>
</div>