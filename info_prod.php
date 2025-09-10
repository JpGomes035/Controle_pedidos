<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';
include_once('head.php');
$id = $_GET['id'];

?>
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
<title>Cadastro Completo</title>
<div style="padding:20px 0;max-width:800px" class="container">
    <h4 style="padding:0 0 20px 0;margin-bottom:35px;" class="border-bottom">Informações complementares</h4>
    <form action="atualizar_info_prod.php" method="POST">
        <?php
        $sql = "SELECT * FROM estoque WHERE IdProduto = $id";
        $retorno = mysqli_query($conexao, $sql);

        while ($array = mysqli_fetch_array($retorno, MYSQLI_ASSOC)) {
            $idProduto = $array['IdProduto'];
            $nome = $array['Nome'];
            $descProd = $array['descProd'];
            $vencProd = $array['vencProd'];
            $unidade_estoque = $array['unidade_estoque'];
            $peso = $array['peso'];
            $precoPromocional = $array['precoPromocional'];
            $status_prod = $array['status_prod'];
            $preco_custo = $array['preco_custo'];
            $preco_bruto = $array['preco_bruto'];
            $qntVendas = $array['qntVendas'];
            $localEstoq = $array['localEstoq'];

            ?>
            <input style="display:none" id="idProduto" name="idProduto" value="<?= $idProduto ?>">
            <!--<div class="form-group">
            <label for="numeroProduto">Número Produto</label>
            <input type="text" class="form-control" id="numeroProduto" placeholder="Digite o número do produto"
                name="numeroProduto" required  value="<?= $numero ?>" readonly>
        </div>-->
            <div class="form-group">
                <label for="nomeProduto">Nome Produto</label>
                <input type="text" class="form-control" id="nomeProduto" name="nomeProduto"
                    placeholder="Digite o nome do produto" readonly autocomplete="off" value="<?= $nome ?> ">
            </div>
            <div class="form-group">
                <label for="descProd">Descrição Complementar:</label>
                <input type="text" class="form-control" id="descProd" name="descProd" placeholder="Descrição do Produto"
                    required autocomplete="off" value="<?= $descProd ?>">
            </div>
            <div class="form-group">
                <label for="unidade_estoque">Unidade de Medida: </label>
                <input type="text" class="form-control" id="unidade_estoque" name="unidade_estoque"
                    placeholder="Unid, litro, caixa.." required autocomplete="off" value="<?= $unidade_estoque ?>">
            </div>
            <div class="form-group">
                <label for="vencProd">Dias de validade desse produto:</label>
                <input type="date" class="form-control" id="vencProd" name="vencProd"
                    placeholder="Quantos dias esse produto tem de validade?" autocomplete="off" value="<?= $vencProd ?>">
            </div>
            <div class="form-group">
                <label for="peso">Peso do Prod(KG): </label>
                <input type="text" class="form-control" id="peso" name="peso"
                    placeholder="Peso do prod por uma unid de medida?" autocomplete="off" value="<?= $peso ?>">
            </div>
            <div class="form-group">
                <label for="precoPromocional">Preço Promocional do Produto: </label>
                <input type="text" class="form-control" id="precoPromocional" name="precoPromocional"
                    placeholder="Preço Promocional do produto?" step="0.01" autocomplete="off"
                    value="<?= $precoPromocional ?>">
            </div>
            <div class="form-group">
                <label for="status_prod">Status atual do produto?</label>
                <input type="text" class="form-control" id="status_prod" name="status_prod"
                    placeholder="Estragado, manutenção, em uso, etc.." autocomplete="off" value="<?= $status_prod ?>">
            </div>
            <div class="form-group">
                <label for="preco_custo">Preço de Custo do Produto: </label>
                <input type="text" class="form-control" id="preco_custo" name="preco_custo"
                    placeholder="Preço de custo do produto?" step="0.01" autocomplete="off" value="<?= $preco_custo ?>">
            </div>
            <div class="form-group">
                <label for="preco_bruto">Preço Bruto do Produto: </label>
                <input type="text" class="form-control" id="preco_bruto" name="preco_bruto"
                    placeholder="Preço Bruto do produto?" step="0.01" autocomplete="off" value="<?= $preco_bruto ?>">
            </div>
            <div class="form-group">
                <label for="preco_bruto">Quantidade de vendas registradas no sistema: </label>
                <input type="text" class="form-control" id="qntVendas" name="qntVendas"
                    placeholder="No registry" step="0.01" autocomplete="off" value="<?= $qntVendas ?>" readonly>
            </div>
            <div class="form-group">
                <label for="localEstoq">Localidade do Produto: </label>
                <input type="text" class="form-control" id="localEstoq" name="localEstoq"
                    placeholder="Qual a Localidade do produto na Loja?" autocomplete="off" value="<?= $localEstoq ?>">
            </div>
            <button type="submit" class="btn-enviar btn btn-primary btn-sm btn-block">Atualizar/Voltar</button>
        <?php } ?>
    </form>
</div>