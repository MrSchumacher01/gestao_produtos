<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);

echo "<div class='alert alert-success'>Produto excluído com sucesso!</div>";
header('refresh:2;url=listar_produtos.php');
?>
