<?php
include_once 'iniciar_sessao.php';
include_once 'conexao.php';

$numeroProduto = trim($_POST["numeroProduto"]);
$nomeProduto = trim($_POST["nomeProduto"]);
$precovenda = trim($_POST["precovenda"]);
$quantidadeProduto = trim($_POST["quantidadeProduto"]);
$categoriaProduto = trim($_POST["categoria"]);
$fornecedorProduto = trim($_POST["fornecedor"]);
$unidade_estoque = trim($_POST["unidade_estoque"]);
$descProd = trim($_POST["descProd"]);
$status_prod = trim($_POST["status_prod"]);

// Verificar e fazer upload da imagem
$target_dir = "upload-prod/";
$unique_id = uniqid();
$target_file = $target_dir . $unique_id . '_' . basename($_FILES["img_prod"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verifica se o arquivo é uma imagem
$check = getimagesize($_FILES["img_prod"]["tmp_name"]);
if ($check !== false) {
    if (move_uploaded_file($_FILES["img_prod"]["tmp_name"], $target_file)) {
        $img_prod = $target_file;
    } else {
        echo "Desculpe, houve um erro ao fazer o upload da sua imagem.";
        exit;
    }
} else {
    echo "O arquivo não é uma imagem.";
    exit;
}

$sql = "INSERT INTO `estoque` (`Categoria`, `Fornecedor`, `Nome`, `precovenda`, `Numero`, `Quantidade`, `descProd`, `unidade_estoque`, `status_prod`, `img_prod`, `deletado`, `precoPromocional`) 
VALUES ('$categoriaProduto', '$fornecedorProduto', '$nomeProduto', '$precovenda', '$numeroProduto', $quantidadeProduto, '$descProd', '$unidade_estoque', '$status_prod', '$img_prod', 'N', '$precoPromocional')";
$inserir = mysqli_query($conexao, $sql);

if ($inserir) {
    header("Location: listar_produtos.php?cadastrado=1");
} else {
    echo "Erro ao cadastrar produto.";
}
?>
