<?php

// SERVIDOR
define("HOST", "localhost");
// NOME DA BASE DE DADOS
define("BD", "pap");
// NOME DO UTILIZADOR (É SEMPRE ROOT)
define("USER", "root");
// PALAVRA PASSE (POR DEFEITO É SEMPRE NULO)
define("PASS", "");

// NOME DA FUNÇÃO QUE CRIA A CONEXÃO À BASE DE DADOS
function conexaoBD() {
    try {
        $dsn = "mysql:host=" . HOST . ";dbname=" . BD . ";charset=utf8mb4"; // Adicionado charset
        // Crie a conexão à base de dados usando o método PDO
        $connBD = new PDO($dsn, USER, PASS);
        $connBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connBD; // Retorna a conexão
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return null; // Retorna null se a conexão falhar
    }
}

// Estabelece a conexão e armazena em uma variável global
$pdo = conexaoBD();

?>