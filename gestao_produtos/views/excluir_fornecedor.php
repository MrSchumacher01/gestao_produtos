<?php
// excluir_fornecedor.php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM fornecedores WHERE id = ?");
$stmt->execute([$id]);

echo "<div class='alert alert-success'>Fornecedor excluído com sucesso!</div>";
header('refresh:2;url=listar_produtos.php');
?>
