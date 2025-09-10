<?php
include('conexao.php'); // Incluindo a conexão com o banco de dados

$nome_fmpag = $_POST['nome_fmpag'];
$banco_vinculado = $_POST['banco_vinculado'];
$percentual_taxa = isset($_POST['percentual_taxa']) ? $_POST['percentual_taxa'] : 0;

// Insere os dados no banco de dados (formas de pagamento)
$sql = "INSERT INTO fm_pag (nome_fmpag, banco_vinculado, percentual_taxa, deletado) VALUES ('$nome_fmpag', '$banco_vinculado', '$percentual_taxa', 'N')";

if (mysqli_query($conexao, $sql)) {
    // Redireciona para a página listar_formpag.php
    header("Location: listar_formpag.php");
    exit(); // Sempre use exit após um redirecionamento com header
} else {
    echo "Erro ao cadastrar a forma de pagamento: " . mysqli_error($conexao);
}
?>
