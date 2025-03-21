<?php
class Conexao {
    private static $instance;

    public static function getConexao() {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=gestao_produtos;charset=utf8', 'root', '');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro de conexão: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>
