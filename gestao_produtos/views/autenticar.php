<?php
require '../database/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = hash('sha256', $_POST['senha']); // Aplicando o mesmo hash

    $pdo = Conexao::getConexao();

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->execute([$email, $senha]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario['nome'];
        header('Location: listar_produtos.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Login ou senha incorretos.</div>";
    }
}
?>
