<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM fornecedores WHERE id = ?");
$stmt->execute([$id]);
$fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $contato = $_POST['contato'];

    $stmt = $pdo->prepare("UPDATE fornecedores SET nome = ?, endereco = ?, contato = ? WHERE id = ?");
    $stmt->execute([$nome, $endereco, $contato, $id]);

    echo "<div class='alert alert-success'>Fornecedor atualizado com sucesso!</div>";
    header('refresh:2;url=consultar_fornecedores.php');
}
?>

<!-- Parte visual -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Editar Fornecedor</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= $fornecedor['nome'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Endereço:</label>
            <input type="text" name="endereco" value="<?= $fornecedor['endereco'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contato:</label>
            <input type="text" name="contato" value="<?= $fornecedor['contato'] ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="consultar_fornecedores.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
