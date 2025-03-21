<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();

// Buscar produto para edição
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar fornecedores para o select
$stmtFornecedores = $pdo->query("SELECT * FROM fornecedores");
$fornecedores = $stmtFornecedores->fetchAll(PDO::FETCH_ASSOC);

// Atualizar produto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $id_fornecedor = $_POST['id_fornecedor'];

    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, descricao = ?, id_fornecedor = ? WHERE id = ?");
    $stmt->execute([$nome, $preco, $descricao, $id_fornecedor, $id]);

    echo "<div class='alert alert-success'>Produto atualizado com sucesso!</div>";
    header('refresh:2;url=listar_produtos.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Editar Produto</h1>
    <form method="POST">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" value="<?= $produto['nome'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Preço:</label>
            <input type="text" name="preco" class="form-control" value="<?= $produto['preco'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" class="form-control"><?= $produto['descricao'] ?></textarea>
        </div>
        <div class="mb-3">
            <label>Fornecedor:</label>
            <select name="id_fornecedor" class="form-select" required>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor['id'] ?>" <?= $produto['id_fornecedor'] == $fornecedor['id'] ? 'selected' : '' ?>>
                        <?= $fornecedor['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="listar_produtos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
