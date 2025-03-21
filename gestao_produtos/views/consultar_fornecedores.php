<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();

// Excluir fornecedor
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    // Verifica se há produtos vinculados a este fornecedor
    $stmtVerifica = $pdo->prepare("SELECT COUNT(*) FROM produtos WHERE id_fornecedor = ?");
    $stmtVerifica->execute([$id]);
    $quantidadeProdutos = $stmtVerifica->fetchColumn();

    if ($quantidadeProdutos > 0) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Não é possível excluir o fornecedor, pois há <strong>$quantidadeProdutos produto(s)</strong> vinculado(s) a ele.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    } else {
        $stmt = $pdo->prepare("DELETE FROM fornecedores WHERE id = ?");
        $stmt->execute([$id]);
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Fornecedor excluído com sucesso!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    }
}


$fornecedores = $pdo->query("SELECT * FROM fornecedores")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consultar Fornecedores</title>
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
                    window.location.href = 'consultar_fornecedores.php?excluir=' + id;
                }
            });
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="container mt-5">

    <h1>Fornecedores Cadastrados</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?= $fornecedor['nome'] ?></td>
                    <td><?= $fornecedor['endereco'] ?></td>
                    <td><?= $fornecedor['contato'] ?></td>
                    <td>
                        <a href="editar_fornecedor.php?id=<?= $fornecedor['id'] ?>"
                            class="btn btn-warning btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm"
                            onclick="confirmarExclusao(<?= $fornecedor['id'] ?>)">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="cadastro_fornecedor.php" class="btn btn-secondary">Voltar</a>

</body>

</html>