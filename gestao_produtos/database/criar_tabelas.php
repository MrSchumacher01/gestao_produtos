<?php
require 'conexao.php';

try {
    $pdo = Conexao::getConexao();

    // Criar tabela usuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL
        )
    ");

    // Criar tabela fornecedores
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS fornecedores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL
        )
    ");

    // Criar tabela produtos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS produtos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            preco DECIMAL(10,2) NOT NULL,
            id_fornecedor INT,
            FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id)
        )
    ");

    echo "Tabelas criadas com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage();
}
?>
