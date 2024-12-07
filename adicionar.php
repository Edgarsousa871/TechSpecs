<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto = $_POST['produto'];
    $preco = $_POST['preco'];

    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Adiciona o produto ao carrinho
    $_SESSION['carrinho'][] = [
        'produto' => $produto,
        'preco' => $preco,
    ];

    // Redireciona de volta para a página inicial
    header('Location: index.php');
    exit();
}
