<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = hash('sha256', $_POST['senha']);

    $pdo = Conexao::getConexao();
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senha]);

    echo "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Cadastro de Usuário</h1>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Senha:</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Cadastrar</button>
    </form>

    <hr>

    <a href="consultar_usuarios.php" class="btn btn-info mt-3">Consultar Usuários</a>
    <a href="listar_produtos.php" class="btn btn-secondary mt-3">Voltar</a>
    <a href="login.php">Voltar à Tela de Login</a>

</body>
</html>
