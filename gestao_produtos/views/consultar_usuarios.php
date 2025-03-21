<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();

// Excluir usuário
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Usuário excluído com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao excluir o usuário. Tente novamente mais tarde.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}



$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consultar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você não poderá desfazer essa ação!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'consultar_usuarios.php?excluir=' + id;
                }
            });
        }

    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="container mt-5">

    <h1>Usuários Cadastrados</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['nome'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm"
                            onclick="confirmarExclusao(<?= $usuario['id'] ?>)">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="cadastro_usuario.php" class="btn btn-secondary">Voltar</a>

</body>

</html>