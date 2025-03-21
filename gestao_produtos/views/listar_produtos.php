<?php
require '../database/conexao.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

try {
    $pdo = Conexao::getConexao();
    $stmt = $pdo->query("
        SELECT p.id, p.nome, p.preco, p.descricao, p.foto, f.nome as fornecedor
        FROM produtos p
        JOIN fornecedores f ON p.id_fornecedor = f.id
    ");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="text-center mb-4">Lista de Produtos</h1>

    <form method="POST" action="adicionar_cesta.php">
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <?php if (!empty($produto['foto'])): ?>
                            <div class="text-center mt-3">
                                <img src="../<?= htmlspecialchars($produto['foto']) ?>" alt="Foto do Produto" class="img-fluid"
                                    style="max-height: 300px;">
                            </div>
                        <?php else: ?>
                            <div class="text-center mt-3">
                                <p>Sem foto</p>
                            </div>
                        <?php endif; ?>

                        <div class="card-body text-center"> <!-- Centralizar todos os textos -->
                            <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produto['descricao']) ?></p>
                            <p class="card-text" style="font-size: 1.25rem; font-weight: bold;">R$
                                <?= number_format($produto['preco'], 2, ',', '.') ?> no Pix
                            </p>

                            <div class="form-check d-flex justify-content-center align-items-center gap-2">
                                <input type="checkbox" class="form-check-input" id="produto<?= $produto['id'] ?>"
                                    name="produtos[]" value="<?= $produto['id'] ?>"
                                    style="border: 2px solid #000; width: 20px; height: 20px;">
                                <label class="form-check-label" for="produto<?= $produto['id'] ?>">Adicionar à Cesta</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        </div> <!-- Fechamento da div row -->

        <div class="text-center mt-5 mb-4">
            <button type="submit" class="btn btn-primary">Adicionar à Cesta</button>
            <a href="cadastro_usuario.php" class="btn btn-secondary">Cadastrar Usuário</a>
            <a href="cadastro_fornecedor.php" class="btn btn-secondary">Cadastrar Fornecedor</a>
            <a href="cadastro_produto.php" class="btn btn-secondary">Cadastrar Produto</a>
        </div>
    </form>

    <!-- Rodapé -->
    <footer class="text-center mt-5 mb-3 text-muted">
        Desenvolvido por Marcos Roberto Schumacher
    </footer>

    </form>
</body>

</html>