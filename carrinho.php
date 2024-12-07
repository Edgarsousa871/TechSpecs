<?php
session_start();

// Verifica se o carrinho existe, se não, cria um
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona produtos ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto'])) {
    $produto = [
        'nome' => htmlspecialchars($_POST['produto'], ENT_QUOTES, 'UTF-8'),
        'preco' => htmlspecialchars($_POST['preco'], ENT_QUOTES, 'UTF-8')
    ];
    $_SESSION['carrinho'][] = $produto;
}

// Remove produtos do carrinho
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    array_splice($_SESSION['carrinho'], (int)$_GET['remove'], 1);
}

// Calcula o total
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += floatval(str_replace(['€', ' ', ','], ['', '', '.'], $item['preco']));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        h2 {
            color: #0073e6;
            border-bottom: 2px solid #0073e6;
            padding-bottom: 10px;
        }
        .cart-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0073e6;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .total {
            font-weight: bold;
            font-size: 1.5em;
            margin-top: 20px;
            color: #0073e6;
        }
        .remove-button {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
        }
        .remove-button i {
            margin-right: 5px;
        }
        .remove-button:hover {
            color: #d12d2d;
        }
        a {
            text-decoration: none;
            color: #0073e6;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
        .empty-cart {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2em;
            color: #777;
        }
        .checkout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0073e6;
            color: white;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
        .checkout-button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>

<h2>Seu Carrinho</h2>

<div class="cart-container">
    <?php if (empty($_SESSION['carrinho'])): ?>
        <p class="empty-cart">Seu carrinho está vazio.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $index => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['preco'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="?remove=<?php echo $index; ?>" class="remove-button">
                                <i class="fas fa-trash-alt"></i> Remover
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="total">Total: <?php echo number_format($total, 2, ',', '.') . '€'; ?></p>
        <a href="checkout.php" class="checkout-button">Finalizar Compra</a>
    <?php endif; ?>
</div>

<a href="index .php">Voltar à Loja</a>

</body>
</html>


