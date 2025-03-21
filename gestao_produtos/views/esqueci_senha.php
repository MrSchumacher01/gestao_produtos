<?php
require '../database/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    try {
        $pdo = Conexao::getConexao();
        
        // Verifica se o e-mail existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Gerar nova senha temporária
            $novaSenha = substr(md5(time()), 0, 8); // Gera uma senha com 8 caracteres
            $senhaHash = hash('sha256', $novaSenha);

            // Atualizar a senha no banco
            $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
            $stmt->execute([$senhaHash, $email]);

            echo "<div class='alert alert-success'>Sua nova senha temporária é: <strong>$novaSenha</strong></div>";
            echo "<a href='login.php' class='btn btn-primary'>Voltar ao Login</a>";
        } else {
            echo "<div class='alert alert-danger'>E-mail não encontrado!</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Esqueci a Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Recuperar Senha</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Digite seu e-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Gerar Nova Senha</button>
        <a href="login.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>
</html>
