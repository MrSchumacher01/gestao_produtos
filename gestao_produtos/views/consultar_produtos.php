<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();

// Excluir Produto
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    try {
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Produto excluído com sucesso!',
                showConfirmButton: false,
                timer: 2000
            });
        </script>";
    } catch (PDOException $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erro ao excluir o produto!',
                text: 'Tente novamente mais tarde.',
                showConfirmButton: false,
                timer: 3000
            });
        </script>";
    }
}

$produtos = $pdo->query("
    SELECT p.*, f.nome as fornecedor
    FROM produtos p
    JOIN fornecedores f ON p.id_fornecedor = f.id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consultar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    window.location.href = 'consultar_produtos.php?excluir=' + id;
                }
            });
        }
    </script>
</head>

<body class="container mt-5">

    <h1>Produtos Cadastrados</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>
                <th>Fornecedor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td>
                        <?php if (!empty($produto['foto'])): ?>
                            <img src="../<?= htmlspecialchars($produto['foto']) ?>" alt="Foto do Produto" width="100">
                        <?php else: ?>
                            <p>Sem foto</p>
                        <?php endif; ?>

                    </td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td><?= htmlspecialchars($produto['fornecedor']) ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm"
                            onclick="confirmarExclusao(<?= $produto['id'] ?>)">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="cadastro_produto.php" class="btn btn-secondary">Voltar</a>

</body>

</html>