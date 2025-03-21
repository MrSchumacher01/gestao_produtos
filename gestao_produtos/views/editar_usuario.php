<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = !empty($_POST['senha']) ? hash('sha256', $_POST['senha']) : $usuario['senha'];

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $senha, $id]);

    echo "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
    header('refresh:2;url=consultar_usuarios.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Editar Usuário</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= $usuario['nome'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="<?= $usuario['email'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nova Senha (opcional):</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="consultar_usuarios.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
