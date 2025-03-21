<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Login</h1>
    <form method="POST" action="autenticar.php">
        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Senha:</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="mt-3 text-center">
            <a href="esqueci_senha.php">Esqueci a senha</a>
            <a href="cadastro_usuario.php">Novo usuário</a>
        </div>
    </form>
</body>
</html>
