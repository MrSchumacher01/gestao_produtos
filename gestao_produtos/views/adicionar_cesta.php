<?php
require '../database/conexao.php';

$produtosSelecionados = $_POST['produtos'] ?? [];

if (empty($produtosSelecionados)) {
    die("<p>Nenhum produto foi selecionado. <a href='listar_produtos.php'>Voltar</a></p>");
}

try {
    $pdo = Conexao::getConexao();
    $placeholders = implode(',', array_fill(0, count($produtosSelecionados), '?'));
    $stmt = $pdo->prepare("SELECT id, nome, descricao, preco, foto FROM produtos WHERE id IN ($placeholders)");
    $stmt->execute($produtosSelecionados);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <h2 class="fw-bold mb-4">Meu carrinho</h2>

        <div class="row">
            <!-- PRODUTOS DA CESTA -->
            <div class="col-md-7">
                <form method="POST" action="cesta_produtos.php">
                    <?php foreach ($produtos as $index => $produto): ?>
                        <div class="card mb-3">
                            <div class="card-body d-flex align-items-center">
                                <img src="../<?= htmlspecialchars($produto['foto']) ?>" alt="Foto do Produto"
                                    class="img-fluid me-3" style="width: 100px; height: 100px; object-fit: cover;">

                                <div class="flex-grow-1">
                                    <h5 class="fw-bold"><?= htmlspecialchars($produto['nome']) ?></h5>
                                    <p class="text-muted mb-1"><?= htmlspecialchars($produto['descricao']) ?></p>

                                    <!-- Quantidade -->
                                    <div class="d-flex align-items-center mt-3">
                                        <span class="me-2">Quantidade:</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="alterarQuantidade('qtd<?= $index ?>', -1)">-</button>
                                        <input type="text" class="form-control text-center mx-1"
                                            name="quantidades[<?= $produto['id'] ?>]" id="qtd<?= $index ?>" value="1"
                                            style="width: 50px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="alterarQuantidade('qtd<?= $index ?>', 1)">+</button>
                                    </div>

                                    <p class="fw-bold mt-3" style="font-size: 1.2rem;">R$
                                        <?= number_format($produto['preco'], 2, ',', '.') ?> no Pix</p>
                                </div>

                                <!-- Botão Remover Produto -->
                                <button type="submit" name="remover" value="<?= $produto['id'] ?>"
                                    class="btn btn-outline-danger">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </form>
            </div>

            <!-- RESUMO DA COMPRA -->
            <div class="col-md-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold">Subtotal (<?= count($produtos) ?> itens)</h5>
                        <p class="text-end fw-bold">
                            R$ <?= number_format(array_sum(array_column($produtos, 'preco')), 2, ',', '.') ?>
                        </p>
                        <h6 class="mt-3">Cupom de desconto</h6>
                        <p class="text-end"><a href="#" class="text-primary">Adicionar</a></p>

                        <h5 class="mt-3 fw-bold">Valor total</h5>
                        <p class="text-end fw-bold" style="font-size: 1.4rem;">
                            R$ <?= number_format(array_sum(array_column($produtos, 'preco')), 2, ',', '.') ?> no Pix
                        </p>

                        <!-- BOTÕES FINALIZAR E ESCOLHER MAIS PRODUTOS -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Finalizar</button>
                            <a href="listar_produtos.php" class="btn btn-primary btn-lg">Escolher mais produtos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function alterarQuantidade(campoId, valor) {
            var campo = document.getElementById(campoId);
            var atual = parseInt(campo.value);
            var novoValor = atual + valor;
            if (novoValor < 1) novoValor = 1;
            campo.value = novoValor;
        }
    </script>

</body>

</html>