<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $contato = $_POST['contato'];

    $pdo = Conexao::getConexao();
    $stmt = $pdo->prepare("INSERT INTO fornecedores (nome, endereco, contato) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $endereco, $contato]);

    echo "<div class='alert alert-success'>Fornecedor cadastrado com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Cadastro de Fornecedor</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Endereço:</label>
            <input type="text" name="endereco" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contato:</label>
            <input type="text" name="contato" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Cadastrar</button>
    </form>

    <hr>
    <a href="consultar_fornecedores.php" class="btn btn-info">Consultar Fornecedores</a>
    <a href="listar_produtos.php" class="btn btn-secondary">Voltar</a>

</body>
</html>
