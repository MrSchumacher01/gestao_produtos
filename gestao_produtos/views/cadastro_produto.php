<?php
require '../database/conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$pdo = Conexao::getConexao();

// Cadastro do produto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $id_fornecedor = $_POST['id_fornecedor'];

    // Tratamento da foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        $novoNomeFoto = uniqid() . '.' . $extensao;
        $caminhoFoto = 'uploads/' . $novoNomeFoto;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../' . $caminhoFoto);
        $foto = $caminhoFoto;

    }

    // Inserir no banco
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, descricao, foto, id_fornecedor) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $preco, $descricao, $foto, $id_fornecedor]);

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Produto cadastrado com sucesso!',
                showConfirmButton: false,
                timer: 2500
            });
        });
    </script>";

}

// Buscar fornecedores para o select
$fornecedores = $pdo->query("SELECT * FROM fornecedores")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="container mt-5">

    <h1>Cadastro de Produto</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Preço:</label>
            <input type="number" step="0.01" name="preco" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Foto:</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="mb-3">
            <label>Fornecedor:</label>
            <select name="id_fornecedor" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor['id'] ?>"><?= $fornecedor['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cadastrar Produto</button>
    </form>

    <hr>
    <a href="consultar_produtos.php" class="btn btn-info">Consultar Produtos</a>
    <a href="listar_produtos.php" class="btn btn-secondary">Voltar</a>

</body>

</html>